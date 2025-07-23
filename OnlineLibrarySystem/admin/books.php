<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Add new book if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $query = "INSERT INTO books (title, author) VALUES ('$title', '$author')";
    mysqli_query($conn, $query);
}

// Get all books from database
$books = mysqli_query($conn, "SELECT * FROM books");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Books</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input { padding: 5px; margin: 5px; }
        table { border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid #000; padding: 8px; }
    </style>
</head>
<body>
    <h2>📚 Add New Book</h2>
    <form method="post">
        <input type="text" name="title" placeholder="Book Title" required>
        <input type="text" name="author" placeholder="Author Name" required>
        <input type="submit" value="Add Book">
    </form>

    <h2>📋 All Books</h2>
    <table>
        <tr>
            <th>ID</th><th>Title</th><th>Author</th><th>Available</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($books)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['title'] ?></td>
            <td><?= $row['author'] ?></td>
            <td><?= $row['available'] ? 'Yes' : 'No' ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
