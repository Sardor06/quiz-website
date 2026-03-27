<?php
require_once __DIR__ . '/config/init.php';
require_login();

$attempt_id = isset($_GET['attempt_id']) ? (int)$_GET['attempt_id'] : 0;

$stmt = $conn->prepare("SELECT qa.id, qa.score, qa.total_marks, qa.percentage, qa.status, q.title
                        FROM quiz_attempts qa
                        JOIN quizzes q ON q.id = qa.quiz_id
                        WHERE qa.id = ? AND qa.user_id = ?");
$stmt->bind_param('ii', $attempt_id, $_SESSION['user_id']);
$stmt->execute();
$attempt = $stmt->get_result()->fetch_assoc();

if (!$attempt) {
    die('Result not found.');
}

$answers_stmt = $conn->prepare("SELECT qu.question_text, ua.is_correct, ua.awarded_marks, qo.option_text AS selected_answer
                                FROM user_answers ua
                                JOIN questions qu ON qu.id = ua.question_id
                                LEFT JOIN question_options qo ON qo.id = ua.selected_option_id
                                WHERE ua.attempt_id = ?");
$answers_stmt->bind_param('i', $attempt_id);
$answers_stmt->execute();
$answers = $answers_stmt->get_result();

include __DIR__ . '/includes/header.php';
?>
<div class="card">
    <h2>Quiz Result: <?= e($attempt['title']) ?></h2>
    <p><strong>Score:</strong> <?= e((string)$attempt['score']) ?> / <?= e((string)$attempt['total_marks']) ?></p>
    <p><strong>Percentage:</strong> <?= e((string)$attempt['percentage']) ?>%</p>
    <p><strong>Status:</strong> <?= e($attempt['status']) ?></p>
</div>

<div class="card">
    <h3>Answer Summary</h3>
    <table>
        <thead>
            <tr>
                <th>Question</th>
                <th>Your Answer</th>
                <th>Correct?</th>
                <th>Marks</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $answers->fetch_assoc()): ?>
            <tr>
                <td><?= e($row['question_text']) ?></td>
                <td><?= e($row['selected_answer'] ?? 'No answer') ?></td>
                <td><?= (int)$row['is_correct'] === 1 ? 'Yes' : 'No' ?></td>
                <td><?= e((string)$row['awarded_marks']) ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>