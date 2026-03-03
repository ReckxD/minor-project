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
                <li><a href="admin.php" class="<?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active' : '' ?>">Admin</a></li>
            </ul>
        </div>
    </nav>