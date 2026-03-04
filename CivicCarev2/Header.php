<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CivicCare - Street Light & Road Damage Reporting</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">CivicCare</a>
            <ul class="nav-links">
                <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Home</a></li>
                <li><a href="report.php" class="<?= basename($_SERVER['PHP_SELF']) == 'report.php' ? 'active' : '' ?>">Report Issue</a></li>
                <li><a href="status.php" class="<?= basename($_SERVER['PHP_SELF']) == 'status.php' ? 'active' : '' ?>">View Status</a></li>
                <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                    <li><a href="admin.php" class="<?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active' : '' ?>">Admin Dashboard</a></li>
                    <li><a href="admin_logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="admin_login.php" class="<?= basename($_SERVER['PHP_SELF']) == 'admin_login.php' ? 'active' : '' ?>">Admin</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>