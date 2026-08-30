<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

$result = mysqli_query($conn, "SELECT * FROM hero LIMIT 1");
$hero = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $button_text = $_POST['button_text'];

    // Image upload
    $image = $_FILES['image']['name'];

    if ($image != "") {
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../assets/images/" . $image
        );

        mysqli_query($conn, "UPDATE hero SET 
            image='$image'
        ");
    }

    mysqli_query($conn, "UPDATE hero SET 
        title='$title',
        description='$description',
        button_text='$button_text'
    ");

    header("Location: hero.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Hero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Edit Hero Section</h2>

    <form method="POST" enctype="multipart/form-data">

        <label>Title</label>
        <input type="text" name="title"
               value="<?= $hero['title']; ?>"
               class="form-control mb-2">

        <label>Description</label>
        <textarea name="description"
                  class="form-control mb-2"><?= $hero['description']; ?></textarea>

        <label>Button Text</label>
        <input type="text" name="button_text"
               value="<?= $hero['button_text']; ?>"
               class="form-control mb-2">

        <label>CV Button</label>
        <input type="text" name="button_text2"
               value="<?= $hero['button_text2']; ?>"
               class="form-control mb-2">
               
        <label>Image</label><br>
     <img src="../assets/images/<?= $hero['image']; ?>" width="120"><br><br>

        <input type="file" name="image" class="form-control mb-3">

        <button type="submit" name="update" class="btn btn-success">
            Update Hero
        </button>

    </form>

</div>

</body>
</html>