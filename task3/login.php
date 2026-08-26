<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "config.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    /* =========================
       VALIDATION
    ========================= */

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $messageType = "danger";

    } elseif ($password === "") {

        $message = "Please enter your password.";
        $messageType = "danger";

    } else {

        /* =========================
           GET USER + ROLE
        ========================= */

        $stmt = mysqli_prepare(
            $conn,
            "SELECT
                u.id,
                u.full_name,
                u.email,
                u.password,
                r.role_name
             FROM users u
             INNER JOIN roles r
                ON u.role_id = r.id
             WHERE u.email = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $email
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        /* =========================
           CHECK USER
        ========================= */

        if (mysqli_num_rows($result) === 1) {

            $user = mysqli_fetch_assoc($result);

            /* =========================
               VERIFY HASHED PASSWORD
            ========================= */

            if (password_verify($password, $user["password"])) {

                /* =========================
                   CREATE SESSION
                ========================= */

                $_SESSION["user_id"] =
                    $user["id"];

                $_SESSION["full_name"] =
                    $user["full_name"];

                $_SESSION["email"] =
                    $user["email"];

                $_SESSION["role"] =
                    $user["role_name"];


                /* =========================
                   ROLE-BASED REDIRECT
                ========================= */

                if ($user["role_name"] === "ADMIN") {

                    header("Location: dashboard.php");

                    exit;

                } else {

                    header("Location: dashboard.php");

                    exit;
                }

            } else {

                $message =
                    "Invalid email or password.";

                $messageType = "danger";
            }

        } else {

            $message =
                "Invalid email or password.";

            $messageType = "danger";
        }

        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login | Task 3</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        body {

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            background:
                linear-gradient(
                    135deg,
                    #667eea,
                    #764ba2
                );

            font-family: Arial, sans-serif;

        }

        .login-card {

            width: 100%;

            max-width: 450px;

            background: white;

            padding: 35px;

            border-radius: 20px;

            box-shadow:
                0 15px 40px rgba(0,0,0,0.25);

        }

        .login-card h2 {

            font-weight: bold;

        }

        .form-control {

            padding: 12px;

            border-radius: 10px;

        }

        .btn-login {

            width: 100%;

            padding: 12px;

            border-radius: 10px;

            font-weight: bold;

        }

    </style>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-card">

    <div class="text-center mb-4">

        <h2>Welcome Back</h2>

        <p class="text-muted">
            Task 3 - User Management System
        </p>

    </div>


    <?php if ($message !== ""): ?>

        <div class="alert alert-<?php
            echo htmlspecialchars($messageType);
        ?>">

            <?php
                echo htmlspecialchars($message);
            ?>

        </div>

    <?php endif; ?>


    <form method="POST"
          action="login.php">

        <div class="mb-3">

            <label class="form-label">
                Email
            </label>

            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="Enter your email"
                required
            >

        </div>


        <div class="mb-3">

            <label class="form-label">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Enter your password"
                required
            >

        </div>


        <button
            type="submit"
            class="btn btn-primary btn-login">

            Login

        </button>

    </form>


    <div class="text-center mt-4">

        Don't have an account?

        <a href="register.php">
            Register
        </a>

    </div>

</div>

</body>

</html>

