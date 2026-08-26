<?php

session_start();

require_once "config.php";

/* =========================
   LOGIN CHECK
========================= */

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");

    exit;

}

$user_id = (int) $_SESSION["user_id"];

$message = "";
$messageType = "success";


/* =========================
   FETCH CURRENT USER
========================= */

$stmt = mysqli_prepare(
    $conn,
    "SELECT
        u.full_name,
        u.email,
        u.password,
        u.profile_picture,
        r.role_name
     FROM users u
     INNER JOIN roles r
        ON u.role_id = r.id
     WHERE u.id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {

    die("User not found.");

}

$user = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


/* =========================
   UPDATE PROFILE
========================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim(
        $_POST["full_name"] ?? ""
    );

    $email = trim(
        $_POST["email"] ?? ""
    );

    $newPassword = $_POST["password"] ?? "";


    /* =========================
       SERVER-SIDE VALIDATION
    ========================= */

    if ($full_name === "") {

        $message =
            "Full name is required.";

        $messageType = "danger";

    } elseif (strlen($full_name) < 3) {

        $message =
            "Full name must contain at least 3 characters.";

        $messageType = "danger";

    } elseif (!preg_match(
        "/^[A-Za-z ]+$/",
        $full_name
    )) {

        $message =
            "Name can contain only letters and spaces.";

        $messageType = "danger";

    } elseif (!filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    )) {

        $message =
            "Please enter a valid email.";

        $messageType = "danger";

    } else {

        /* =========================
           CHECK EMAIL DUPLICATE
        ========================= */

        $stmt = mysqli_prepare(
            $conn,
            "SELECT id
             FROM users
             WHERE email = ?
             AND id != ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $email,
            $user_id
        );

        mysqli_stmt_execute($stmt);

        $emailResult =
            mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($emailResult) > 0) {

            $message =
                "This email is already used by another user.";

            $messageType = "danger";

            mysqli_stmt_close($stmt);

        } else {

            mysqli_stmt_close($stmt);


            /* =========================
               UPDATE BASIC PROFILE
            ========================= */

            if ($newPassword !== "") {

                if (strlen($newPassword) < 6) {

                    $message =
                        "New password must contain at least 6 characters.";

                    $messageType = "danger";

                } else {

                    $hashedPassword =
                        password_hash(
                            $newPassword,
                            PASSWORD_DEFAULT
                        );

                    $stmt = mysqli_prepare(
                        $conn,
                        "UPDATE users
                         SET full_name = ?,
                             email = ?,
                             password = ?
                         WHERE id = ?"
                    );

                    mysqli_stmt_bind_param(
                        $stmt,
                        "sssi",
                        $full_name,
                        $email,
                        $hashedPassword,
                        $user_id
                    );

                    mysqli_stmt_execute($stmt);

                    mysqli_stmt_close($stmt);

                }

            } else {

                $stmt = mysqli_prepare(
                    $conn,
                    "UPDATE users
                     SET full_name = ?,
                         email = ?
                     WHERE id = ?"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "ssi",
                    $full_name,
                    $email,
                    $user_id
                );

                mysqli_stmt_execute($stmt);

                mysqli_stmt_close($stmt);

            }


            /* =========================
               PROFILE IMAGE UPLOAD
            ========================= */

            if (
                isset($_FILES["profile_picture"])
                &&
                $_FILES["profile_picture"]["error"]
                === UPLOAD_ERR_OK
            ) {

                $file = $_FILES["profile_picture"];

                $maxSize = 2 * 1024 * 1024;

                if ($file["size"] > $maxSize) {

                    $message =
                        "Profile picture must be less than 2 MB.";

                    $messageType = "danger";

                } else {

                    $allowedTypes = [
                        "image/jpeg",
                        "image/png",
                        "image/webp"
                    ];

                    $fileInfo =
                        finfo_open(FILEINFO_MIME_TYPE);

                    $mimeType =
                        finfo_file(
                            $fileInfo,
                            $file["tmp_name"]
                        );

                    finfo_close($fileInfo);


                    if (!in_array(
                        $mimeType,
                        $allowedTypes,
                        true
                    )) {

                        $message =
                            "Only JPG, PNG and WEBP images are allowed.";

                        $messageType = "danger";

                    } else {

                        $extensionMap = [
                            "image/jpeg" => "jpg",
                            "image/png"  => "png",
                            "image/webp" => "webp"
                        ];

                        $extension =
                            $extensionMap[$mimeType];

                        $newFileName =
                            "profile_" .
                            $user_id .
                            "_" .
                            time() .
                            "." .
                            $extension;

                        $uploadPath =
                            __DIR__ .
                            "/uploads/" .
                            $newFileName;


                        if (move_uploaded_file(
                            $file["tmp_name"],
                            $uploadPath
                        )) {

                            /* =========================
                               DELETE OLD IMAGE
                            ========================= */

                            if (
                                !empty(
                                    $user["profile_picture"]
                                )
                            ) {

                                $oldImage =
                                    __DIR__ .
                                    "/uploads/" .
                                    $user["profile_picture"];

                                if (
                                    file_exists($oldImage)
                                ) {

                                    unlink($oldImage);

                                }

                            }


                            /* =========================
                               SAVE NEW IMAGE NAME
                            ========================= */

                            $stmt = mysqli_prepare(
                                $conn,
                                "UPDATE users
                                 SET profile_picture = ?
                                 WHERE id = ?"
                            );

                            mysqli_stmt_bind_param(
                                $stmt,
                                "si",
                                $newFileName,
                                $user_id
                            );

                            mysqli_stmt_execute($stmt);

                            mysqli_stmt_close($stmt);

                        } else {

                            $message =
                                "Failed to upload profile picture.";

                            $messageType = "danger";

                        }

                    }

                }

            }


            if ($messageType === "success") {

                $message =
                    "Profile updated successfully.";

            }


            /* =========================
               REFRESH USER DATA
            ========================= */

            $stmt = mysqli_prepare(
                $conn,
                "SELECT
                    u.full_name,
                    u.email,
                    u.profile_picture,
                    r.role_name
                 FROM users u
                 INNER JOIN roles r
                    ON u.role_id = r.id
                 WHERE u.id = ?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "i",
                $user_id
            );

            mysqli_stmt_execute($stmt);

            $result =
                mysqli_stmt_get_result($stmt);

            $user =
                mysqli_fetch_assoc($result);

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

    <title>My Profile | Task 3</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        <a
            href="dashboard.php"
            class="navbar-brand">

            Task 3 User Management

        </a>

        <div>

            <a
                href="dashboard.php"
                class="btn btn-secondary me-2">

                Dashboard

            </a>

            <?php if (
                $_SESSION["role"] === "ADMIN"
            ): ?>

                <a
                    href="users.php"
                    class="btn btn-primary me-2">

                    Users

                </a>

            <?php endif; ?>

            <a
                href="logout.php"
                class="btn btn-danger">

                Logout

            </a>

        </div>

    </div>

</nav>


<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="mb-4">
                        My Profile
                    </h2>


                    <?php if ($message !== ""): ?>

                        <div class="alert alert-<?php
                            echo $messageType;
                        ?>">

                            <?php
                            echo htmlspecialchars(
                                $message
                            );
                            ?>

                        </div>

                    <?php endif; ?>


                    <div class="text-center mb-4">

                        <?php if (
                            !empty(
                                $user["profile_picture"]
                            )
                        ): ?>

                            <img
                                src="uploads/<?php
                                    echo htmlspecialchars(
                                        $user["profile_picture"]
                                    );
                                ?>"
                                width="120"
                                height="120"
                                style="
                                    object-fit:cover;
                                    border-radius:50%;
                                    border:4px solid #ddd;
                                "
                            >

                        <?php else: ?>

                            <div
                                class="bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                                style="
                                    width:120px;
                                    height:120px;
                                    border-radius:50%;
                                    font-size:40px;
                                ">

                                <?php
                                echo strtoupper(
                                    substr(
                                        $user["full_name"],
                                        0,
                                        1
                                    )
                                );
                                ?>

                            </div>

                        <?php endif; ?>

                    </div>


                    <form
                        method="POST"
                        enctype="multipart/form-data">

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
                                        $user["full_name"]
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
                                        $user["email"]
                                    );
                                ?>"
                                required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                New Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Leave blank to keep current password">

                        </div>


                        <div class="mb-4">

                            <label class="form-label">
                                Profile Picture
                            </label>

                            <input
                                type="file"
                                name="profile_picture"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.webp">

                            <small class="text-muted">

                                JPG, PNG or WEBP.
                                Maximum size: 2 MB.

                            </small>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary">

                            Update Profile

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>

