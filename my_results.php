<?php
require_once __DIR__ . '/config/init.php';
require_login();

$stmt = $conn->prepare("SELECT qa.id, q.title, qa.score, qa.total_marks, qa.percentage, qa.finished_at
                        FROM quiz_attempts qa
                        JOIN quizzes q ON q.id = qa.quiz_id
                        WHERE qa.user_id = ?
                        ORDER BY qa.id DESC");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$results = $stmt->get_result();

include __DIR__ . '/includes/header.php';
?>
<div class="card">
    <h2>My Results</h2>
    <table>
        <thead>
            <tr>
                <th>Quiz</th>
                <th>Score</th>
                <th>Percentage</th>
                <th>Finished At</th>
                <th>Open</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $results->fetch_assoc()): ?>
            <tr>
                <td><?= e($row['title']) ?></td>
                <td><?= e((string)$row['score']) ?> / <?= e((string)$row['total_marks']) ?></td>
                <td><?= e((string)$row['percentage']) ?>%</td>
                <td><?= e($row['finished_at']) ?></td>
                <td><a class="btn" href="result.php?attempt_id=<?= (int)$row['id'] ?>">View</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>