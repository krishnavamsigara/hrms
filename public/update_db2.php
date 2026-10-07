<?php
$mysqli = new mysqli("localhost", "root", "vamsi123", "hrmsdevtest");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Read the modified SP file
$sql = file_get_contents('../hrms_get_missing_punchouts.sql');
$sql = "DROP PROCEDURE IF EXISTS `hrms_get_missing_punchouts`;\n" . $sql;

// Execute multiple queries
if ($mysqli->multi_query($sql)) {
    echo "Procedure updated successfully.\n";
} else {
    echo "Error updating procedure: " . $mysqli->error;
}
$mysqli->close();
?>
