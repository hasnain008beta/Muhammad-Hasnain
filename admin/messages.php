<?php

include '../includes/db.php';

session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

$messages = mysqli_query(
$conn,
"SELECT * FROM messages ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html>
<head>
<title>Messages</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

<h2>Contact Messages</h2>

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Message</th>
<th>Date</th>
</tr>

<?php while($row=mysqli_fetch_assoc($messages)) { ?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= htmlspecialchars($row['name']); ?></td>

<td><?= htmlspecialchars($row['email']); ?></td>

<td><?= htmlspecialchars($row['message']); ?></td>

<td><?= $row['created_at']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>