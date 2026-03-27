<?php
require_once __DIR__ . '/config/init.php';
include __DIR__ . '/includes/header.php';

$sql = "SELECT q.id, q.title, q.description, q.time_limit_minutes, q.total_questions, c.name AS category_name
        FROM quizzes q
        LEFT JOIN categories c ON c.id = q.category_id
        WHERE q.is_published = 1
        ORDER BY q.created_at DESC";
$result = $conn->query($sql);
?>
<div class="card">
    <h1>Available Quizzes</h1>
    <p class="meta">Register or log in to start a quiz.</p>
</div>

<div class="grid">
<?php while ($quiz = $result->fetch_assoc()): ?>
    <div class="card">
        <h3><?= e($quiz['title']) ?></h3>
        <p><?= e($quiz['description'] ?? '') ?></p>
        <p class="meta">Category: <?= e($quiz['category_name'] ?? 'Uncategorized') ?></p>
        <p class="meta">Questions: <?= (int)$quiz['total_questions'] ?> | Time: <?= (int)$quiz['time_limit_minutes'] ?> min</p>
        <?php if (is_logged_in()): ?>
            <a class="btn" href="quiz.php?id=<?= (int)$quiz['id'] ?>">Start Quiz</a>
        <?php else: ?>
            <a class="btn" href="login.php">Login to Start</a>
        <?php endif; ?>
    </div>
<?php endwhile; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>