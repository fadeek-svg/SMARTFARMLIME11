<?php
// register.php
session_start();
include 'db_connect.php'; 
$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // เข้ารหัสรหัสผ่านอย่างปลอดภัย
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        $success_message = "สมัครสมาชิกสำเร็จ! โปรดเข้าสู่ระบบ";
    } else {
        $error_message = "มีข้อผิดพลาด: ชื่อผู้ใช้หรืออีเมลอาจถูกใช้ไปแล้ว";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิก</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;500;700&display=swap" rel="stylesheet">
    <style> 
        /* CSS Style */
        :root { --primary-color: #28a745; --background-color: #f8f9fa; --card-background: #ffffff; --text-color: #343a40; --border-radius: 8px; --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); }
        body { font-family: 'Kanit', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: var(--background-color); margin: 0; color: var(--text-color); }
        .auth-card { background-color: var(--card-background); padding: 40px; border-radius: var(--border-radius); box-shadow: var(--box-shadow); width: 100%; max-width: 350px; transition: transform 0.3s ease-in-out; }
        .auth-card:hover { transform: translateY(-5px); }
        h2 { text-align: center; color: var(--primary-color); margin-bottom: 25px; font-weight: 700; }
        .input-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: 500; }
        input[type="text"], input[type="password"], input[type="email"] { width: 100%; padding: 12px; border: 1px solid #ced4da; border-radius: var(--border-radius); box-sizing: border-box; transition: border-color 0.3s; }
        input:focus { border-color: var(--primary-color); outline: none; box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25); }
        button { background-color: var(--primary-color); color: white; padding: 12px 15px; border: none; border-radius: var(--border-radius); cursor: pointer; width: 100%; font-size: 16px; font-weight: 500; transition: background-color 0.3s; }
        button:hover { background-color: #1e7e34; }
        .link-text { text-align: center; margin-top: 20px; font-size: 0.9em; }
        .link-text a { color: var(--primary-color); text-decoration: none; font-weight: 500; }
        .link-text a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="auth-card">
        <h2>สมัครสมาชิก ✨</h2>
        <?php if ($error_message): ?>
            <p style="color: red; text-align: center; font-weight: 500;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <p style="color: green; text-align: center; font-weight: bold;"><?php echo $success_message; ?>
                <br><a href="login.php" style="color: #1e7e34;">ไปหน้า Login</a>
            </p>
        <?php endif; ?>

        <form method="POST" action="register.php">
             <div class="input-group">
                <label for="username">ชื่อผู้ใช้</label>
                <input type="text" placeholder="ป้อนชื่อผู้ใช้ที่ต้องการ" name="username" required>
            </div>
            <div class="input-group">
                <label for="email">อีเมล</label>
                <input type="email" placeholder="ป้อนอีเมล" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">รหัสผ่าน</label>
                <input type="password" placeholder="ป้อนรหัสผ่าน" name="password" required>
            </div>
            
            <button type="submit">สมัครสมาชิก</button>
        </form>
        <div class="link-text">
            มีบัญชีอยู่แล้ว? <a href="login.php">กลับไปเข้าสู่ระบบ</a>
        </div>
    </div>
</body>
</html>