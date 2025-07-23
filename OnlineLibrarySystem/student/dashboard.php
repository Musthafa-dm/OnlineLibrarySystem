<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; text-align: center; padding: 40px; }
        h1 { color: #333; }
        a.button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: blue;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
        }
        a.button:hover {
            background-color: darkblue;
        }
    </style>
</head>
<body>
    <h1>👋 Welcome, <?= $_SESSION['username'] ?></h1>
    <h3>What would you like to do today?</h3>

    <a class="button" href="borrow.php">📚 Borrow a Book</a>
    <a class="button" href="../index.php">🚪 Logout</a>
</body>
</html>

