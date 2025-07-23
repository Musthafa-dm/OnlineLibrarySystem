<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Fetch counts
$books = mysqli_query($conn, "SELECT COUNT(*) as total FROM books");
$students = mysqli_query($conn, "SELECT COUNT(*) as total FROM students");
$borrowed = mysqli_query($conn, "SELECT COUNT(*) as total FROM borrowings WHERE returned = 0");
$returned = mysqli_query($conn, "SELECT COUNT(*) as total FROM borrowings WHERE returned = 1");

$book_count = mysqli_fetch_assoc($books)['total'];
$student_count = mysqli_fetch_assoc($students)['total'];
$borrowed_count = mysqli_fetch_assoc($borrowed)['total'];
$returned_count = mysqli_fetch_assoc($returned)['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 30px; text-align: center; }
        h1 { color: #333; }
        .cards { display: flex; justify-content: center; flex-wrap: wrap; margin-bottom: 30px; }
        .card {
            background: white; padding: 20px; margin: 10px;
            border-radius: 10px; box-shadow: 0 0 10px gray;
            width: 200px; text-align: center;
        }
        .count { font-size: 30px; color: darkblue; }
        .buttons { margin-top: 30px; }
        .button {
            display: inline-block; margin: 10px; padding: 12px 20px;
            background-color: blue; color: white; text-decoration: none;
            border-radius: 8px; font-size: 16px;
        }
        .button:hover { background-color: darkblue; }
    </style>
</head>
<body>
    <h1>📊 Welcome Admin: <?= $_SESSION['username'] ?></h1>

    <div class="cards">
        <div class="card">
            <h3>Total Books</h3>
            <div class="count"><?= $book_count ?></div>
        </div>
        <div class="card">
            <h3>Total Students</h3>
            <div class="count"><?= $student_count ?></div>
        </div>
        <div class="card">
            <h3>Borrowed Books</h3>
            <div class="count"><?= $borrowed_count ?></div>
        </div>
        <div class="card">
            <h3>Returned Books</h3>
            <div class="count"><?= $returned_count ?></div>
        </div>
    </div>

    <div class="buttons">
        <a class="button" href="books.php">📚 Manage Books</a>
        <a class="button" href="returns.php">🔁 Return Books</a>
        <a class="button" href="../index.php">🚪 Logout</a>
    </div>
</body>
</html>
