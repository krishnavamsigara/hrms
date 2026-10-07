<?php
$host = '127.0.0.1';
$db   = 'hrmsdevtest';
$user = 'root';
$pass = 'vamsi123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to DB. Starting seeder...\n";

    // 1. Delete existing 2026 data
    $pdo->exec("DELETE FROM payroll_attendance_summary");
    $pdo->exec("DELETE FROM attendance WHERE YEAR(attendance_date) = 2026");
    $pdo->exec("DELETE FROM leave_application WHERE YEAR(from_date) = 2026");
    
    // Reset leave balances for 2026
    $pdo->exec("UPDATE emp_leave_balance SET availed = 0, closing_balance = opening_balance + credited WHERE year = 2026");

    // 2. Fetch active employees & their joining dates
    $stmt = $pdo->query("
        SELECT u.emp_id, d.joining_date 
        FROM user_login_details u 
        JOIN user_details d ON u.emp_id = d.emp_id 
        WHERE UPPER(u.status) = 'ACTIVE'
    ");
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Fetch 2026 Holidays
    $stmt = $pdo->query("SELECT holiday_date FROM holiday_master WHERE status = 'A' AND YEAR(holiday_date) = 2026");
    $holidays = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // 4. Fetch Leave Types
    $stmt = $pdo->query("SELECT leave_type_id, leave_code FROM leave_type WHERE status = 'A'");
    $leaveTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $endDate = new DateTime(date('Y-m-d')); // Up to today

    $totalAtt = 0;
    $totalLeaves = 0;

    foreach ($employees as $emp) {
        $empId = $emp['emp_id'];
        
        $joinDateStr = $emp['joining_date'] ?: '2026-01-01';
        $startDate = new DateTime($joinDateStr);
        if ($startDate < new DateTime('2026-01-01')) {
            $startDate = new DateTime('2026-01-01');
        }
        
        if ($startDate > $endDate) continue;

        // Ensure Leave Balance Exists for 2026
        foreach ($leaveTypes as $lt) {
            $stmt = $pdo->prepare("SELECT balance_id FROM emp_leave_balance WHERE emp_id = ? AND leave_type_id = ? AND year = 2026");
            $stmt->execute([$empId, $lt['leave_type_id']]);
            if (!$stmt->fetch()) {
                $ins = $pdo->prepare("INSERT INTO emp_leave_balance (emp_id, leave_type_id, year, opening_balance, credited, availed, closing_balance) VALUES (?, ?, 2026, 0, 12, 0, 12)");
                $ins->execute([$empId, $lt['leave_type_id']]);
            }
        }

        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $isWeekend = ($currentDate->format('N') >= 6);
            $isHoliday = in_array($dateStr, $holidays);

            if ($isHoliday || $isWeekend) {
                // Insert as HOLIDAY
                $ins = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, status, created_at, updated_at) VALUES (?, ?, 'HOLIDAY', NOW(), NOW())");
                $ins->execute([$empId, $dateStr]);
            } else {
                $rand = rand(1, 100);
                
                if ($rand <= 80) {
                    // PRESENT normal
                    $in = $dateStr . " 09:" . str_pad(rand(15, 45), 2, '0', STR_PAD_LEFT) . ":00";
                    $out = $dateStr . " 18:" . str_pad(rand(15, 45), 2, '0', STR_PAD_LEFT) . ":00";
                    $ins = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, punch_in, punch_out, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'PRESENT', NOW(), NOW())");
                    $ins->execute([$empId, $dateStr, $in, $out]);
                } elseif ($rand <= 85) {
                    // PRESENT missing punch out
                    $in = $dateStr . " 09:" . str_pad(rand(15, 45), 2, '0', STR_PAD_LEFT) . ":00";
                    $ins = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, punch_in, status, created_at, updated_at) VALUES (?, ?, ?, 'PRESENT', NOW(), NOW())");
                    $ins->execute([$empId, $dateStr, $in]);
                } elseif ($rand <= 88) {
                    // WFH
                    $in = $dateStr . " 09:30:00";
                    $out = $dateStr . " 18:30:00";
                    $ins = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, punch_in, punch_out, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'WFH', NOW(), NOW())");
                    $ins->execute([$empId, $dateStr, $in, $out]);
                } elseif ($rand <= 92) {
                    // ABSENT (LOP)
                    $ins = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, status, created_at, updated_at) VALUES (?, ?, 'ABSENT', NOW(), NOW())");
                    $ins->execute([$empId, $dateStr]);
                } else {
                    // LEAVE
                    // Find a leave type with balance
                    $stmt = $pdo->prepare("SELECT * FROM emp_leave_balance WHERE emp_id = ? AND year = 2026 AND closing_balance >= 1 LIMIT 1");
                    $stmt->execute([$empId]);
                    $bal = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($bal) {
                        // Apply leave
                        $ins = $pdo->prepare("INSERT INTO leave_application (emp_id, leave_type_id, from_date, to_date, total_days, applied_days, approved_leave_days, lop_days, reason, status, applied_on, approved_by, approved_on) VALUES (?, ?, ?, ?, 1, 1, 1, 0, 'Dummy Leave', 'APPROVED', NOW(), 'SYSTEM', NOW())");
                        $ins->execute([$empId, $bal['leave_type_id'], $dateStr, $dateStr]);
                        
                        // Deduct balance
                        $upd = $pdo->prepare("UPDATE emp_leave_balance SET availed = availed + 1, closing_balance = closing_balance - 1 WHERE balance_id = ?");
                        $upd->execute([$bal['balance_id']]);

                        // Insert Attendance
                        $ins = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, status, created_at, updated_at) VALUES (?, ?, 'LEAVE', NOW(), NOW())");
                        $ins->execute([$empId, $dateStr]);
                        $totalLeaves++;
                    } else {
                        // No balance -> LOP/ABSENT
                        $ins = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, status, created_at, updated_at) VALUES (?, ?, 'ABSENT', NOW(), NOW())");
                        $ins->execute([$empId, $dateStr]);
                    }
                }
            }
            $totalAtt++;
            $currentDate->modify('+1 day');
        }
    }

    echo "Successfully generated $totalAtt attendance records and $totalLeaves leave applications.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
