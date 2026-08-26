<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "config.php";

/* Protect page */

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");

    exit;
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Task 3</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        <span class="navbar-brand">
            Task 3 User Management
        </span>

        <a
            href="logout.php"
            class="btn btn-danger">

            Logout

        </a>

    </div>

</nav>


<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h2>
                Welcome,
                <?php
                    echo htmlspecialchars(
                        $_SESSION["full_name"]
                    );
                ?>!
            </h2>

            <hr>

            <p>
                <strong>Email:</strong>
                <?php
                    echo htmlspecialchars(
                        $_SESSION["email"]
                    );
                ?>
            </p>

            <p>
                <strong>Role:</strong>

                <span class="badge bg-primary">

                    <?php
                        echo htmlspecialchars(
                            $_SESSION["role"]
                        );
                    ?>

                </span>

            </p>


            <?php if ($_SESSION["role"] === "ADMIN"): ?>

                <div class="alert alert-warning">

                    <strong>Admin Access</strong>

                    <br>

                    You can manage users.

                </div>

                <a
                    href="users.php"
                    class="btn btn-primary">

                    Manage Users

                </a>

            <?php else: ?>

                <div class="alert alert-success">

                    You are logged in as a normal user.

                </div>

            <?php endif; ?>


            <a
                href="profile.php"
                class="btn btn-secondary">

                My Profile

            </a>

        </div>

    </div>

</div>

</body>

</html>

