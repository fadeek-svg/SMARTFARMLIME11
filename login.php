<?php
// login.php
session_start();
include 'db_connect.php'; 
$error_message = '';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // ตรวจสอบรหัสผ่านที่ถูกเข้ารหัสไว้
        if (password_verify($password, $user['password'])) {
            // รหัสผ่านถูกต้อง! สร้าง Session
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            header("location: dashboard.php");
            exit;
        } else {
            $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;500;700&display=swap" rel="stylesheet">
    <style> 
        /* CSS Style */
        :root { --primary-color: #16d316ff; --background-color: #f8f9fa; --card-background: #ffffff; --text-color: #343a40; --border-radius: 8px; --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); }
        body { font-family: 'Kanit', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: var(--background-color); margin: 0; color: var(--text-color); }
        .auth-card { background-color: var(--card-background); padding: 40px; border-radius: var(--border-radius); box-shadow: var(--box-shadow); width: 100%; max-width: 350px; transition: transform 0.3s ease-in-out; }
        .auth-card:hover { transform: translateY(-5px); }
        h2 { text-align: center; color: var(--primary-color); margin-bottom: 25px; font-weight: 700; }
        .input-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: 500; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; border: 1px solid #ced4da; border-radius: var(--border-radius); box-sizing: border-box; transition: border-color 0.3s; }
        input:focus { border-color: var(--primary-color); outline: none; box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); }
        button { background-color: var(--primary-color); color: white; padding: 12px 15px; border: none; border-radius: var(--border-radius); cursor: pointer; width: 100%; font-size: 16px; font-weight: 500; transition: background-color 0.3s; }
        button:hover { background-color: #1aa715ff; }
        .link-text { text-align: center; margin-top: 20px; font-size: 0.9em; }
        .link-text a { color: var(--primary-color); text-decoration: none; font-weight: 500; }
        .link-text a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="auth-card">
        <h2>ล็อกอิน 🔒</h2>
        <?php if ($error_message): ?>
            <p style="color: red; text-align: center; font-weight: 500;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div class="input-group">
                <label for="username">ชื่อผู้ใช้</label>
                <input type="text" placeholder="ป้อนชื่อผู้ใช้" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">รหัสผ่าน</label>
                <input type="password" placeholder="ป้อนรหัสผ่าน" name="password" required>
            </div>
            
            <button type="submit">เข้าสู่ระบบ</button>
        </form>
        <div class="link-text">
            ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิกที่นี่</a>
        </div>
    </div>
</body>
</html>