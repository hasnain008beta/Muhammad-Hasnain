<?php

include '../includes/db.php';

$id = $_GET['id'];

mysqli_query(
$conn,
"DELETE FROM projects WHERE id='$id'"
);

header("Location: projects.php");