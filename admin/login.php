<?php
include '../includes/db.php';

session_start();

// Agar admin already login hai
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validation
    if ($username === '' || $password === '') {

        $error = "Please enter both username and password.";

    } else {

        // Secure prepared statement
        $stmt = mysqli_prepare(
            $conn,
            "SELECT id, username, password FROM admin WHERE username = ? LIMIT 1"
        );

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {

            /*
             * IMPORTANT:
             * Ye password_verify() tab use hoga jab database mein
             * password password_hash() ke through save kiya gaya ho.
             */
            if (password_verify($password, $row['password'])) {

                // Security ke liye session ID regenerate
                session_regenerate_id(true);

                $_SESSION['admin'] = $row['username'];
                $_SESSION['admin_id'] = $row['id'];

                header("Location: dashboard.php");
                exit;

            } else {

                $error = "Invalid username or password.";
            }

        } else {

            $error = "Invalid username or password.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | Portfolio</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            min-height: 100vh;
            background:
                linear-gradient(
                    135deg,
                    #0f172a 0%,
                    #1e293b 50%,
                    #334155 100%
                );
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 430px;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(
                135deg,
                #2563eb,
                #4f46e5
            );
            color: #fff;
            padding: 35px 30px;
            text-align: center;
        }

        .admin-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }

        .login-header h2 {
            margin: 0;
            font-weight: 700;
        }

        .login-header p {
            margin: 8px 0 0;
            opacity: 0.85;
            font-size: 14px;
        }

        .login-body {
            padding: 35px 30px;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
        }

        .form-control {
            height: 48px;
            border-radius: 10px;
            border: 1px solid #dbe2ea;
            padding: 10px 14px;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .login-btn {
            height: 48px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(
                135deg,
                #2563eb,
                #4f46e5
            );
            font-weight: 600;
            transition: 0.3s;
        }

        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        }

        .footer-text {
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
            margin-top: 20px;
        }

    </style>

</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        <!-- Header -->
        <div class="login-header">

            <div class="admin-icon">
                🔐
            </div>

            <h2>Admin Login</h2>

            <p>Sign in to access your dashboard</p>

        </div>


        <!-- Login Form -->
        <div class="login-body">

            <?php if ($error !== ''): ?>

                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >
                    <strong>Login Failed!</strong><br>
                    <?= htmlspecialchars($error); ?>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>
                </div>

            <?php endif; ?>


            <form method="POST" autocomplete="off">

                <!-- Username -->
                <div class="mb-3">

                    <label for="username" class="form-label">
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control"
                        placeholder="Enter your username"
                        value="<?= htmlspecialchars($username ?? ''); ?>"
                        autocomplete="username"
                        required
                        autofocus
                    >

                </div>


                <!-- Password -->
                <div class="mb-4">

                    <label for="password" class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >

                </div>


                <!-- Login Button -->
                <button
                    type="submit"
                    name="login"
                    class="btn btn-primary login-btn w-100"
                >
                    Login to Dashboard
                </button>

            </form>

        </div>

    </div>


    <div class="footer-text">
        © <?= date('Y'); ?> Admin Panel. All rights reserved.
    </div>

</div>


<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>
