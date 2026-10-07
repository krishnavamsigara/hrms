<?php
set_time_limit(0);
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

        // Prepare statements outside the loop for extreme speed
        $insHoliday = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, status, created_at, updated_at) VALUES (?, ?, 'HOLIDAY', NOW(), NOW())");
        $insPresent = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, punch_in, punch_out, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'PRESENT', NOW(), NOW())");
        $insPresentMissing = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, punch_in, status, created_at, updated_at) VALUES (?, ?, ?, 'PRESENT', NOW(), NOW())");
        $insWfh = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, punch_in, punch_out, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'WFH', NOW(), NOW())");
        $insAbsent = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, status, created_at, updated_at) VALUES (?, ?, 'ABSENT', NOW(), NOW())");
        
        $selLeave = $pdo->prepare("SELECT balance_id, leave_type_id FROM emp_leave_balance WHERE emp_id = ? AND year = 2026 AND closing_balance >= 1 LIMIT 1");
        $insLeaveApp = $pdo->prepare("INSERT INTO leave_application (emp_id, leave_type_id, from_date, to_date, total_days, applied_days, approved_leave_days, lop_days, reason, status, applied_on, approved_by, approved_on) VALUES (?, ?, ?, ?, 1, 1, 1, 0, 'Dummy Leave', 'APPROVED', NOW(), 'SYSTEM', NOW())");
        $updLeaveBal = $pdo->prepare("UPDATE emp_leave_balance SET availed = availed + 1, closing_balance = closing_balance - 1 WHERE balance_id = ?");
        $insLeaveAtt = $pdo->prepare("INSERT INTO attendance (emp_id, attendance_date, status, created_at, updated_at) VALUES (?, ?, 'LEAVE', NOW(), NOW())");


        // Wrap inside transaction for speed
        $pdo->beginTransaction();

        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $isWeekend = ($currentDate->format('N') >= 6);
            $isHoliday = in_array($dateStr, $holidays);

            if ($isHoliday || $isWeekend) {
                $insHoliday->execute([$empId, $dateStr]);
            } else {
                $rand = rand(1, 100);
                
                if ($rand <= 80) {
                    $in = $dateStr . " 09:" . str_pad(rand(15, 45), 2, '0', STR_PAD_LEFT) . ":00";
                    $out = $dateStr . " 18:" . str_pad(rand(15, 45), 2, '0', STR_PAD_LEFT) . ":00";
                    $insPresent->execute([$empId, $dateStr, $in, $out]);
                } elseif ($rand <= 85) {
                    $in = $dateStr . " 09:" . str_pad(rand(15, 45), 2, '0', STR_PAD_LEFT) . ":00";
                    $insPresentMissing->execute([$empId, $dateStr, $in]);
                } elseif ($rand <= 88) {
                    $in = $dateStr . " 09:30:00";
                    $out = $dateStr . " 18:30:00";
                    $insWfh->execute([$empId, $dateStr, $in, $out]);
                } elseif ($rand <= 92) {
                    $insAbsent->execute([$empId, $dateStr]);
                } else {
                    $selLeave->execute([$empId]);
                    $bal = $selLeave->fetch(PDO::FETCH_ASSOC);

                    if ($bal) {
                        $insLeaveApp->execute([$empId, $bal['leave_type_id'], $dateStr, $dateStr]);
                        $updLeaveBal->execute([$bal['balance_id']]);
                        $insLeaveAtt->execute([$empId, $dateStr]);
                        $totalLeaves++;
                    } else {
                        $insAbsent->execute([$empId, $dateStr]);
                    }
                }
            }
            $totalAtt++;
            $currentDate->modify('+1 day');
        }
        $pdo->commit();
    }

    echo "Successfully generated $totalAtt attendance records and $totalLeaves leave applications.\n";

} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Error: " . $e->getMessage() . "\n";
}
?>
