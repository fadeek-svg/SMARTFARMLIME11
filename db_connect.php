<?php
// db_connect.php
$servername = "localhost";
$db_username = "root";     // <-- เปลี่ยนค่านี้หากไม่ใช่ 'root'
$db_password = "";         // <-- เปลี่ยนรหัสผ่านหากมีการตั้งค่าไว้
$dbname = "humidity_db";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>