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
   GET USER ID
========================= */

$id = isset($_GET["id"])
    ? (int) $_GET["id"]
    : 0;


/* =========================
   VALIDATE ID
========================= */

if ($id <= 0) {
    header("Location: users.php");
    exit;
}


/* =========================
   PREVENT SELF DELETE
========================= */

if ($id === (int) $_SESSION["user_id"]) {

    die("You cannot delete your own account.");

}


/* =========================
   DELETE USER
========================= */

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM users WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


if (mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close($stmt);

    header("Location: users.php");

    exit;

}


mysqli_stmt_close($stmt);

die("Unable to delete user.");

?>