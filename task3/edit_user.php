<?php

session_start();

require_once "config.php";

/* =========================
   ADMIN ACCESS ONLY
========================= */

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["role"] !== "ADMIN") {
    die("Access denied. Admins only.");
}


/* =========================
   CHECK EDIT / ADD MODE
========================= */

$id = isset($_GET["id"])
    ? (int) $_GET["id"]
    : 0;

$isEdit = $id > 0;

$message = "";
$messageType = "danger";


/* =========================
   DEFAULT VALUES
========================= */

$full_name = "";
$email = "";
$role_id = 1;


/* =========================
   FETCH USER FOR EDIT
========================= */

if ($isEdit) {

    $stmt = mysqli_prepare(
        $conn,
        "SELECT full_name, email, role_id
         FROM users
         WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) !== 1) {

        die("User not found.");

    }

    $user = mysqli_fetch_assoc($result);

    $full_name = $user["full_name"];
    $email = $user["email"];
    $role_id = $user["role_id"];

    mysqli_stmt_close($stmt);
}


/* =========================
   FORM SUBMISSION
========================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $role_id = (int) ($_POST["role_id"] ?? 1);


    /* =========================
       SERVER-SIDE VALIDATION
    ========================= */

    if ($full_name === "") {

        $message = "Full name is required.";

    } elseif (strlen($full_name) < 3) {

        $message = "Full name must contain at least 3 characters.";

    } elseif (!preg_match("/^[A-Za-z ]+$/", $full_name)) {

        $message = "Name can contain only letters and spaces.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";

    } elseif (!in_array($role_id, [1, 2], true)) {

        $message = "Invalid role selected.";

    } elseif (!$isEdit && strlen($password) < 6) {

        $message = "Password must contain at least 6 characters.";

    } else {

        /* =========================
           ADD USER
        ========================= */

        if (!$isEdit) {

            $hashedPassword =
                password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );


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
                $hashedPassword
            );


            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);

                header("Location: users.php");

                exit;

            } else {

                if (mysqli_errno($conn) === 1062) {

                    $message =
                        "This email is already registered.";

                } else {

                    $message =
                        "Failed to create user.";
                }
            }

            mysqli_stmt_close($stmt);

        }


        /* =========================
           UPDATE USER
        ========================= */

        else {

            if ($password !== "") {

                $hashedPassword =
                    password_hash(
                        $password,
                        PASSWORD_DEFAULT
                    );


                $stmt = mysqli_prepare(
                    $conn,
                    "UPDATE users
                     SET role_id = ?,
                         full_name = ?,
                         email = ?,
                         password = ?
                     WHERE id = ?"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "isssi",
                    $role_id,
                    $full_name,
                    $email,
                    $hashedPassword,
                    $id
                );

            } else {

                $stmt = mysqli_prepare(
                    $conn,
                    "UPDATE users
                     SET role_id = ?,
                         full_name = ?,
                         email = ?
                     WHERE id = ?"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "issi",
                    $role_id,
                    $full_name,
                    $email,
                    $id
                );
            }


            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);

                header("Location: users.php");

                exit;

            } else {

                if (mysqli_errno($conn) === 1062) {

                    $message =
                        "This email is already registered.";

                } else {

                    $message =
                        "Failed to update user.";
                }
            }

            mysqli_stmt_close($stmt);
        }
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo $isEdit ? "Edit User" : "Add User"; ?>
        | Task 3
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        <a
            href="users.php"
            class="navbar-brand">

            Task 3 User Management

        </a>

        <a
            href="logout.php"
            class="btn btn-danger">

            Logout

        </a>

    </div>

</nav>


<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="mb-4">

                        <?php
                        echo $isEdit
                            ? "Edit User"
                            : "Add New User";
                        ?>

                    </h2>


                    <?php if ($message !== ""): ?>

                        <div class="alert alert-danger">

                            <?php
                            echo htmlspecialchars($message);
                            ?>

                        </div>

                    <?php endif; ?>


                    <form
                        method="POST"
                        action="<?php
                            echo $isEdit
                                ? "edit_user.php?id=" . $id
                                : "edit_user.php";
                        ?>">

                        <div class="mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="full_name"
                                class="form-control"
                                value="<?php
                                    echo htmlspecialchars(
                                        $full_name
                                    );
                                ?>"
                                required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="<?php
                                    echo htmlspecialchars(
                                        $email
                                    );
                                ?>"
                                required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="<?php
                                    echo $isEdit
                                        ? "Leave blank to keep current password"
                                        : "Enter password";
                                ?>"
                                <?php
                                    echo !$isEdit
                                        ? "required"
                                        : "";
                                ?>
                            >

                            <?php if ($isEdit): ?>

                                <small class="text-muted">
                                    Leave blank if you don't want to
                                    change the password.
                                </small>

                            <?php endif; ?>

                        </div>


                        <div class="mb-4">

                            <label class="form-label">
                                Role
                            </label>

                            <select
                                name="role_id"
                                class="form-select"
                                required>

                                <option
                                    value="1"
                                    <?php
                                    echo $role_id == 1
                                        ? "selected"
                                        : "";
                                    ?>>

                                    USER

                                </option>

                                <option
                                    value="2"
                                    <?php
                                    echo $role_id == 2
                                        ? "selected"
                                        : "";
                                    ?>>

                                    ADMIN

                                </option>

                            </select>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary">

                            <?php
                            echo $isEdit
                                ? "Update User"
                                : "Add User";
                            ?>

                        </button>


                        <a
                            href="users.php"
                            class="btn btn-secondary">

                            Cancel

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>

