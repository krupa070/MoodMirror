<?php
session_start();
include('db.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Only admin can delete
$sql = "SELECT role FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

if ($res["role"] !== "admin") {
    die("Access denied.");
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $delete = $conn->prepare("DELETE FROM users WHERE id=?");
    $delete->bind_param("i", $id);
    $delete->execute();
}

header("Location: admin_dashboard.php");
exit;
?>
