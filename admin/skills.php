<?php
include '../includes/db.php';

if(isset($_POST['add_skill']))
{
    $skill = $_POST['skill'];

    mysqli_query(
        $conn,
        "INSERT INTO skills(skill_name)
         VALUES('$skill')"
    );
}

$skills = mysqli_query(
    $conn,
    "SELECT * FROM skills"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Skills</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">

    <h2>Edit Skills Section</h2>

    <form method="POST">
        <input
            type="text"
            name="skill"
            class="form-control mb-2"
            placeholder="Skill Name"
            required>

        <button
            type="submit"
            name="add_skill"
            class="btn btn-success">
            Add Skill
        </button>
    </form>

    <hr>

    <h4>Skills List</h4>

    <?php while($skill = mysqli_fetch_assoc($skills)) { ?>
        <p><?= htmlspecialchars($skill['skill_name']) ?></p>
    <?php } ?>

</div>

</body>
</html>