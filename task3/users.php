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
   FETCH USERS
========================= */

$sql = "
    SELECT
        u.id,
        u.full_name,
        u.email,
        r.role_name,
        u.profile_picture,
        u.created_at
    FROM users u
    INNER JOIN roles r
        ON u.role_id = r.id
    ORDER BY u.id DESC
";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Users | Task 3</title>

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

        <a
            href="logout.php"
            class="btn btn-danger">

            Logout

        </a>

    </div>

</nav>


<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>User Management</h2>

            <p class="text-muted">
                Manage registered users
            </p>

        </div>

        <a
            href="edit_user.php"
            class="btn btn-success">

            + Add User

        </a>

    </div>


    <div class="card shadow">

        <div class="card-body">

            <div class="table-responsive">

                <table
                    class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>

                            <th>Profile</th>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Role</th>

                            <th>Created</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if (mysqli_num_rows($result) > 0): ?>

                        <?php while ($user = mysqli_fetch_assoc($result)): ?>

                            <tr>

                                <td>
                                    <?php
                                        echo $user["id"];
                                    ?>
                                </td>


                                <td>

                                    <?php if (!empty($user["profile_picture"])): ?>

                                        <img
                                            src="uploads/<?php
                                                echo htmlspecialchars(
                                                    $user["profile_picture"]
                                                );
                                            ?>"
                                            width="50"
                                            height="50"
                                            style="
                                                object-fit:cover;
                                                border-radius:50%;
                                            "
                                        >

                                    <?php else: ?>

                                        <span class="text-muted">
                                            No Image
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <?php
                                        echo htmlspecialchars(
                                            $user["full_name"]
                                        );
                                    ?>

                                </td>


                                <td>

                                    <?php
                                        echo htmlspecialchars(
                                            $user["email"]
                                        );
                                    ?>

                                </td>


                                <td>

                                    <?php if ($user["role_name"] === "ADMIN"): ?>

                                        <span class="badge bg-danger">
                                            ADMIN
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-primary">
                                            USER
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <?php
                                        echo htmlspecialchars(
                                            $user["created_at"]
                                        );
                                    ?>

                                </td>


                                <td>

                                    <a
                                        href="edit_user.php?id=<?php
                                            echo $user["id"];
                                        ?>"
                                        class="btn btn-sm btn-warning">

                                        Edit

                                    </a>


                                    <?php if (
                                        $user["id"]
                                        !=
                                        $_SESSION["user_id"]
                                    ): ?>

                                        <a
                                            href="delete_user.php?id=<?php
                                                echo $user["id"];
                                            ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="
                                                return confirm(
                                                    'Are you sure you want to delete this user?'
                                                );
                                            ">

                                            Delete

                                        </a>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="7"
                                class="text-center">

                                No users found.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>

</html>

