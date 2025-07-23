<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Handle return action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $borrow_id = $_POST['borrow_id'];
    $book_id = $_POST['book_id'];

    // Mark borrowing as returned
    $update = "UPDATE borrowings SET returned = 1 WHERE id = $borrow_id";
    mysqli_query($conn, $update);

    // Make the book available again
    $update_book = "UPDATE books SET available = 1 WHERE id = $book_id";
    mysqli_query($conn, $update_book);
}

// Get borrowed books that are not returned yet
$query = "
    SELECT b.id as borrow_id, b.student_email, bk.title, bk.author, bk.id as book_id, b.borrow_date
    FROM borrowings b
    JOIN books bk ON b.book_id = bk.id
    WHERE b.returned = 0
";
$borrowed = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Return Books</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid #000; padding: 8px; }
        form { display: inline; }
    </style>
</head>
<body>
    <h2>📦 Borrowed Books (Not Yet Returned)</h2>
    <table>
        <tr>
            <th>Student Email</th><th>Book</th><th>Author</th><th>Borrowed On</th><th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($borrowed)): ?>
        <tr>
            <td><?= $row['student_email'] ?></td>
            <td><?= $row['title'] ?></td>
            <td><?= $row['author'] ?></td>
            <td><?= $row['borrow_date'] ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="borrow_id" value="<?= $row['borrow_id'] ?>">
                    <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                    <button type="submit">Mark as Returned</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
