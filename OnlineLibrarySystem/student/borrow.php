<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit();
}

$student_email = $_SESSION['username'];

// Handle borrow request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];

    // Insert borrow record
    $query = "INSERT INTO borrowings (student_email, book_id) VALUES ('$student_email', $book_id)";
    mysqli_query($conn, $query);

    // Mark book as unavailable
    $update = "UPDATE books SET available = 0 WHERE id = $book_id";
    mysqli_query($conn, $update);
}

// Get all available books
$books = mysqli_query($conn, "SELECT * FROM books WHERE available = 1");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Borrow Books</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 70%; }
        th, td { border: 1px solid #000; padding: 8px; }
        form { display: inline; }
    </style>
</head>
<body>
    <h2>📚 Borrow a Book</h2>
    <table>
        <tr>
            <th>ID</th><th>Title</th><th>Author</th><th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($books)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['title'] ?></td>
            <td><?= $row['author'] ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="book_id" value="<?= $row['id'] ?>">
                    <button type="submit">Borrow</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
