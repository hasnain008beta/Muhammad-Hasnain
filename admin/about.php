<?php

include '../includes/db.php';

session_start();

$result = mysqli_query(
$conn,
"SELECT * FROM about LIMIT 1"
);

$about = mysqli_fetch_assoc($result);
 

if(isset($_POST['update']))
{
    $title = $_POST['title'];
    $description = $_POST['description'];

    $image = $_FILES['image']['name'];

    if($image != '')
    {
        move_uploaded_file(
        $_FILES['image']['tmp_name'],
        '../assets/images/'.$image
        );

        mysqli_query(
        $conn,
        "UPDATE about
         SET image='$image'"
        );
    }

    mysqli_query(
    $conn,
    "UPDATE about
    SET
    title='$title',
    description='$description'"
    );

    header("Location: about.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body> 

<div class="container mt-5"> 

    <h2>Edit About Section</h2>
    <form method="POST" enctype="multipart/form-data">

<input
type="text"
name="title"
value="<?= $about['title']; ?>"
class="form-control mb-3">

<textarea
name="description"
class="form-control mb-3"
rows="5"><?= $about['description']; ?></textarea>

<input
type="file"
name="image"
class="form-control mb-3">

<button
name="update"
class="btn btn-success">
Update About
</button>

</form>
</div>
</body>
</html>