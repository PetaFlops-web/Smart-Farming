<?php
require_once __DIR__ . '/../db_connect.php';

if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

define('ADMIN_USER', $_SESSION['admin_user'] ?? 'Admin');
