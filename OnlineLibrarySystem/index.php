<?php
session_start();
include 'includes/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if ($role == 'admin') {
        $query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    } else {
        $query = "SELECT * FROM students WHERE email='$username' AND password='$password'";
    }

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        if ($role == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: student/dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Library Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; text-align: center; margin-top: 100px; }
        form { background: white; padding: 20px; display: inline-block; border-radius: 10px; box-shadow: 0 0 10px gray; }
        input, select { padding: 10px; margin: 10px; width: 90%; }
        button { padding: 10px 20px; background: blue; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Online Library Login</h2>
    <form method="post">
        <select name="role">
            <option value="admin">Admin</option>
            <option value="student">Student</option>
        </select><br>
        <input type="text" name="username" placeholder="Username or Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
        <div class="error"><?php echo $error; ?></div>
    </form>
</body>
</html>