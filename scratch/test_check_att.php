<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");

// Test month 9 (Sep 2026)
$res1 = $mysqli->query("CALL sp_check_attendance_finalized(9, 2026)");
$r1 = $res1->fetch_assoc();
echo "Month 9 (Sep 2026): cnt={$r1['cnt']}, is_finalized={$r1['is_finalized']}\n";
$mysqli->next_result();

// Test month 10 (Oct 2026)
$res2 = $mysqli->query("CALL sp_check_attendance_finalized(10, 2026)");
$r2 = $res2->fetch_assoc();
echo "Month 10 (Oct 2026): cnt={$r2['cnt']}, is_finalized={$r2['is_finalized']}\n";
$mysqli->next_result();

// Test month 3 (March 2026)
$res3 = $mysqli->query("CALL sp_check_attendance_finalized(3, 2026)");
$r3 = $res3->fetch_assoc();
echo "Month 3 (Mar 2026): cnt={$r3['cnt']}, is_finalized={$r3['is_finalized']}\n";
$mysqli->next_result();

// Test month 11 (Nov 2026 - ungenerated)
$res4 = $mysqli->query("CALL sp_check_attendance_finalized(11, 2026)");
$r4 = $res4->fetch_assoc();
echo "Month 11 (Nov 2026): cnt={$r4['cnt']}, is_finalized=" . var_export($r4['is_finalized'], true) . "\n";
