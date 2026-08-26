<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "config.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    /* =========================
       SERVER-SIDE VALIDATION
    ========================= */

    if ($full_name === "") {

        $message = "Please enter your full name.";
        $messageType = "danger";

    } elseif (!preg_match("/^[A-Za-z ]{3,100}$/", $full_name)) {

        $message = "Name should contain only letters and spaces.";
        $messageType = "danger";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $messageType = "danger";

    } elseif (strlen($password) < 6) {

        $message = "Password must contain at least 6 characters.";
        $messageType = "danger";

    } elseif ($password !== $confirm_password) {

        $message = "Passwords do not match.";
        $messageType = "danger";

    } else {

        /* =========================
           CHECK EXISTING EMAIL
        ========================= */

        $check = mysqli_prepare(
            $conn,
            "SELECT id FROM users WHERE email = ?"
        );

        mysqli_stmt_bind_param($check, "s", $email);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {

            $message = "Email is already registered.";
            $messageType = "danger";

        } else {

            /* =========================
               HASH PASSWORD
            ========================= */

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            /* =========================
               DEFAULT ROLE = USER
            ========================= */

            $role_id = 1;

            /* =========================
               INSERT USER
            ========================= */

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO users
                (role_id, full_name, email, password)
                VALUES (?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "isss",
                $role_id,
                $full_name,
                $email,
                $hashed_password
            );

            if (mysqli_stmt_execute($stmt)) {

                $message = "Registration successful! You can now login.";
                $messageType = "success";

            } else {

                $message = "Registration failed. Please try again.";
                $messageType = "danger";
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_stmt_close($check);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register - Task 3</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        body {
            background: linear-gradient(
                135deg,
                #667eea,
                #764ba2
            );

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            font-family: Arial, sans-serif;
        }

        .register-card {

            width: 100%;

            max-width: 500px;

            background: white;

            border-radius: 20px;

            padding: 35px;

            box-shadow:
                0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .register-title {

            text-align: center;

            font-weight: bold;

            margin-bottom: 25px;
        }

        .form-control {

            border-radius: 10px;

            padding: 12px;
        }

        .btn-register {

            width: 100%;

            padding: 12px;

            border-radius: 10px;

            font-weight: bold;
        }

        .login-link {

            text-align: center;

            margin-top: 20px;
        }

    </style>

</head>

<body>

<div class="register-card">

    <h2 class="register-title">
        Create Account
    </h2>

    <p class="text-center text-muted">
        Task 3 - User Management System
    </p>

    <?php if ($message !== ""): ?>

        <div class="alert alert-<?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>


    <form method="POST"
          action=""
          id="registerForm">

        <div class="mb-3">

            <label class="form-label">
                Full Name
            </label>

            <input
                type="text"
                name="full_name"
                class="form-control"
                placeholder="Enter your full name"
                required
            >

        </div>


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
                placeholder="Enter password"
                minlength="6"
                required
            >

        </div>


        <div class="mb-3">

            <label class="form-label">
                Confirm Password
            </label>

            <input
                type="password"
                name="confirm_password"
                class="form-control"
                placeholder="Confirm password"
                minlength="6"
                required
            >

        </div>


        <button
            type="submit"
            class="btn btn-primary btn-register">

            Register

        </button>

    </form>


    <div class="login-link">

        Already have an account?

        <a href="login.php">
            Login here
        </a>

    </div>

</div>

</body>

</html>