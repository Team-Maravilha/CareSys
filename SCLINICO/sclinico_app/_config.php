<?php
$link_home = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/';
$current_location = $_SERVER["REQUEST_URI"];
$default_avatar = "/assets/media/avatar/blank.png";

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$id_user = isset($_SESSION["hashed_id"]) ? $_SESSION["hashed_id"] : null;

if (str_contains($current_location, "/pages/auth/")) {
    if ($current_location === "/pages/auth/login" && isset($_SESSION["hashed_id"])) {
        header("Location: $link_home");
        exit;
    }
} else {
    if (str_contains($current_location, "/api/auth.php") || str_contains($current_location, "registo")) {
        return;
    } else if (!isset($_SESSION["hashed_id"])) {
        header("Location: $link_home" . "pages/auth/login");
        exit;
    }
}
