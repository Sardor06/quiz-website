<?php require_once __DIR__ . '/../config/init.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Website</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<header class="site-header">
    <div class="container nav">
        <a class="brand" href="/index.php">Quiz Website</a>
        <nav>
            <a href="/index.php">Home</a>
            <?php if (is_logged_in()): ?>
                <a href="/my_results.php">My Results</a>
                <?php if (is_admin()): ?>
                    <a href="/admin/create_quiz.php">Admin</a>
                <?php endif; ?>
                <a href="/logout.php">Logout</a>
            <?php else: ?>
                <a href="/login.php">Login</a>
                <a href="/register.php">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container">