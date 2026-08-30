<?php

include '../includes/db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}


/* =========================
   ADD PROJECT
========================= */

if (isset($_POST['add_project'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $link = mysqli_real_escape_string($conn, $_POST['project_link']);

    $image = $_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        '../assets/images/' . $image
    );

    mysqli_query($conn, "
        INSERT INTO projects
        (title, description, image, project_link)
        VALUES
        ('$title', '$description', '$image', '$link')
    ");

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


/* =========================
   EDIT / UPDATE PROJECT
========================= */

if (isset($_POST['update_project'])) {

    $id = intval($_POST['id']);

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $link = mysqli_real_escape_string($conn, $_POST['project_link']);


    // Get old image
    $result = mysqli_query(
        $conn,
        "SELECT image FROM projects WHERE id='$id'"
    );

    $old = mysqli_fetch_assoc($result);

    $image = $old['image'];


    // New image selected?
    if (
        isset($_FILES['image']) &&
        $_FILES['image']['error'] == 0 &&
        $_FILES['image']['name'] != ''
    ) {

        $image = $_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            '../assets/images/' . $image
        );


        // Delete old image
        if (
            !empty($old['image']) &&
            file_exists('../assets/images/' . $old['image'])
        ) {

            unlink(
                '../assets/images/' . $old['image']
            );
        }
    }


    mysqli_query($conn, "
        UPDATE projects SET
        title='$title',
        description='$description',
        image='$image',
        project_link='$link'
        WHERE id='$id'
    ");


    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


/* =========================
   EDIT PROJECT LOAD
========================= */

$edit_project = null;

if (isset($_GET['edit'])) {

    $edit_id = intval($_GET['edit']);

    $result = mysqli_query(
        $conn,
        "SELECT * FROM projects WHERE id='$edit_id'"
    );

    $edit_project = mysqli_fetch_assoc($result);
}

?>


<!DOCTYPE html>

<html>

<head>

    <title>Projects</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body>


<div class="container mt-5">


<?php if ($edit_project) { ?>


    <!-- =========================
         EDIT FORM
    ========================= -->

    <h3 class="mb-3">
        Edit Project
    </h3>


    <form
        method="POST"
        enctype="multipart/form-data"
    >

        <input
            type="hidden"
            name="id"
            value="<?= (int)$edit_project['id']; ?>"
        >


        <input
            type="text"
            name="title"
            value="<?= htmlspecialchars($edit_project['title']); ?>"
            placeholder="Project Title"
            class="form-control mb-2"
            required
        >


        <textarea
            name="description"
            placeholder="Description"
            class="form-control mb-2"
            rows="5"
            required
        ><?= htmlspecialchars($edit_project['description']); ?></textarea>


        <input
            type="text"
            name="project_link"
            value="<?= htmlspecialchars($edit_project['project_link']); ?>"
            placeholder="Project URL"
            class="form-control mb-2"
        >


        <?php if (!empty($edit_project['image'])) { ?>

            <div class="mb-2">

                <p class="mb-1">
                    Current Image:
                </p>

                <img
                    src="../assets/images/<?= htmlspecialchars($edit_project['image']); ?>"
                    width="120"
                    height="80"
                    style="object-fit:cover;"
                    class="img-thumbnail"
                >

            </div>

        <?php } ?>


        <label class="form-label">
            Change Image
        </label>


        <input
            type="file"
            name="image"
            class="form-control mb-3"
        >


        <button
            type="submit"
            name="update_project"
            class="btn btn-success"
        >
            Update Project
        </button>


        <a
            href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>"
            class="btn btn-secondary"
        >
            Cancel
        </a>

    </form>


<?php } else { ?>


    <!-- =========================
         ADD PROJECT
    ========================= -->

    <h3 class="mb-3">
        Add New Project
    </h3>


    <form
        method="POST"
        enctype="multipart/form-data"
    >

        <input
            type="text"
            name="title"
            placeholder="Project Title"
            class="form-control mb-2"
            required
        >


        <textarea
            name="description"
            placeholder="Description"
            class="form-control mb-2"
            rows="5"
            required
        ></textarea>


        <input
            type="text"
            name="project_link"
            placeholder="Project URL"
            class="form-control mb-2"
        >


        <input
            type="file"
            name="image"
            class="form-control mb-2"
            required
        >


        <button
            type="submit"
            name="add_project"
            class="btn btn-success"
        >
            Add Project
        </button>

    </form>


<?php } ?>


<hr>


<h3>
    My Recent Projects
</h3>


<div class="table-responsive">

<table class="table table-bordered table-striped align-middle">


<thead class="table-dark">

<tr>

    <th>ID</th>

    <th>Image</th>

    <th>Title</th>

    <th>Action</th>

</tr>

</thead>


<tbody>


<?php

$projects = mysqli_query(
    $conn,
    "SELECT * FROM projects ORDER BY id DESC"
);


while ($row = mysqli_fetch_assoc($projects)) {

?>


<tr>

    <td>
        <?= (int)$row['id']; ?>
    </td>


    <td>

        <img
            src="../assets/images/<?= htmlspecialchars($row['image']); ?>"
            width="80"
            height="60"
            style="object-fit:cover;"
            class="rounded"
        >

    </td>


    <td>
        <?= htmlspecialchars($row['title']); ?>
    </td>


    <td style="white-space: nowrap;">

        <!-- EDIT BUTTON -->

        <a
            href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?edit=<?= (int)$row['id']; ?>"
            class="btn btn-primary btn-sm"
        >
            Edit
        </a>


        <!-- DELETE BUTTON -->

        <a
            href="delete_project.php?id=<?= (int)$row['id']; ?>"
            class="btn btn-danger btn-sm"
            onclick="return confirm('Are you sure you want to delete this project?');"
        >
            Delete
        </a>

    </td>

</tr>


<?php } ?>


</tbody>

</table>

</div>


</div>

</body>

</html>
