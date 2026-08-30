<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Admin Dashboard</h2>
    <hr>

    <div class="row">

        <div class="col-md-3">
            <div class="list-group">

                <a href="dashboard.php" class="list-group-item">
                    Dashboard
                </a>

                <a href="hero.php" class="list-group-item">
                    Hero Section
                </a>

                <a href="about.php" class="list-group-item">
                    About Section
                </a>

                <a href="skills.php" class="list-group-item">
                    Skills
                </a>

                <a href="projects.php" class="list-group-item">
                    Projects
                </a>
                <a href="messages.php" class="list-group-item">
                 Messages
                    </a>

               
                <a href="logout.php"
                   class="list-group-item text-danger">
                    Logout
                </a>

            </div>
        </div>

        <div class="col-md-9">

            <div class="card">
                <div class="card-body">

                    <h4>Welcome Admin</h4>

                    <p>
                        You will Manage all kind of portfolio Project
                    </p>

                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>