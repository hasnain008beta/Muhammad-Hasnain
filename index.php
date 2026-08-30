<?php

echo "hello world";
include './includes/db.php';

$result = mysqli_query($conn, "SELECT * FROM hero LIMIT 1");
$hero = mysqli_fetch_assoc($result);

$about_result = mysqli_query($conn, "SELECT * FROM about LIMIT 1");
$about = mysqli_fetch_assoc($about_result);

if(isset($_POST['send_message']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    mysqli_query(
        $conn,
        "INSERT INTO messages(name,email,message)
         VALUES('$name','$email','$message')"
    );

    $success = "Message Sent Successfully!";
}
?>
 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Portfolio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
<nav class="navbar navbar-expand-lg text-white bg-dark">
    <div class="container">

        <a class="navbar-brand text-white" href="#">
            My Portfolio
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link text-white" href="#home">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="#about">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="#projects">Projects</a>
                </li>
 
             <li class="nav-item">
                    <a class="nav-link text-white" href="#skills">Skills</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#contact">Contact</a>
                </li>

            </ul>

        </div>

    </div>
</nav>
<!-- hero section  -->
<?php
include 'includes/db.php';

$result = mysqli_query($conn, "SELECT * FROM hero LIMIT 1");
$hero = mysqli_fetch_assoc($result);
?>

<section class="hero py-5" id="home">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-md-6">

                <h1><?= $hero['title']; ?></h1>

                <p><?= $hero['description']; ?></p>

                <a href="https://github.com/hasnain008beta"   class="btn btn-primary">
                    <?= $hero['button_text']; ?>
                </a>
                  <a href="assets/images/making-CV.pdf" download class="btn btn-primary">
                    <?= $hero['button_text2']; ?>
                </a>

            </div>

            <div class="col-md-6 text-center">

                <img src="assets/images/<?= $hero['image']; ?>"
                     class="img-fluid rounded-circle"
                     width="300">

            </div>

        </div>

    </div>

</section>
<!-- about section  -->
 <section class="about py-5" id="about">

<div class="container">

<div class="row align-items-center">

<div class="col-md-5">

<img src="assets/images/<?php echo $about['image']; ?>"
class="img-fluid rounded">

</div>

<div class="col-md-7">

<h2><?php echo $about['title']; ?></h2>

<p><?php echo $about['description']; ?></p>

</div>

</div>

</div>

</section>



<!-- skill section  -->
 <section class="skills py-5" id="skills">

    <div class="container">

        <div class="text-center mb-5">
            <h2>My Skills</h2>
        </div>

        <div class="row">

            <?php

            $skills = mysqli_query(
                $conn,
                "SELECT * FROM skills ORDER BY id DESC"
            );

            while($skill = mysqli_fetch_assoc($skills))
            {
            ?>

                <div class="col-md-3 mb-3">

                    <div class="card p-3 text-center shadow-sm">

                        <?= htmlspecialchars($skill['skill_name']); ?>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

</section>

<!-- <section class="skills py-5" id="skills">

    <div class="skills-container">

        <div class="text-center mb-5">

            <h2 class="display-5 fw-bold">My Skills</h2>

        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <div class="card p-3 text-center">
                    PHP
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card p-3 text-center">
                    Bootstrap
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card p-3 text-center">
                    MySQL
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card p-3 text-center">
                    JavaScript
                </div>
            </div>

        </div>

    </div>
 

</section> -->

<!-- project section  -->

  <section class="projects py-5" id="projects">

<div class="container">
  <div class="text-center mb-5 text-white">
    <h2>My Recent Projects</h2>
 </div>
<div class="row">

<?php

$projects = mysqli_query(
$conn,
"SELECT * FROM projects"
);

while($project = mysqli_fetch_assoc($projects))
{
?>

<div class="col-md-4 mb-4">

<div class="card">

<img
src="assets/images/<?= $project['image']; ?>"
class="card-img-top">

<div class="card-body">

<h5>
<?= $project['title']; ?>
</h5>

<p>
<?= $project['description']; ?>
</p>

<a
href="<?= $project['project_link']; ?>"
target="_blank"
class="btn btn-primary">

View Project

</a>

</div>

</div>

</div>

<?php } ?>

</div>

</div>

</section>

<!-- contact section   -->
<section class="contact py-5" id="contact">

    <div class="container">

        <div class="text-center mb-5">
            <h2>Contact Me</h2>
            <p>Feel free to contact me anytime</p>
        </div>

        <div class="row justify-content-center">

            <div class="col-md-8">

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">Your Name</label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your Email</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>

                        <textarea
                            name="message"
                            rows="5"
                            class="form-control"
                            required></textarea>
                    </div>

                    <button
                        type="submit"
                        name="send_message"
                        class="btn btn-primary">

                        Send Message

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

<!-- footer section  -->
<footer class="bg-dark text-white text-center py-3">

    <div class="container">

        <p class="mb-0">
            © 2026 My Portfolio | All Rights Reserved
        </p>

    </div>

</footer>

</body>
</html>