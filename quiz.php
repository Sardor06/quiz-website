<?php
require_once __DIR__ . '/config/init.php';
require_login();

$quiz_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$quiz_stmt = $conn->prepare("SELECT id, title, description, time_limit_minutes FROM quizzes WHERE id = ? AND is_published = 1");
$quiz_stmt->bind_param('i', $quiz_id);
$quiz_stmt->execute();
$quiz = $quiz_stmt->get_result()->fetch_assoc();

if (!$quiz) {
    die('Quiz not found.');
}

$q_stmt = $conn->prepare("SELECT id, question_text, marks, question_order FROM questions WHERE quiz_id = ? ORDER BY question_order ASC");
$q_stmt->bind_param('i', $quiz_id);
$q_stmt->execute();
$questions = $q_stmt->get_result();

include __DIR__ . '/includes/header.php';
?>
<div class="card">
    <h2><?= e($quiz['title']) ?></h2>
    <p><?= e($quiz['description'] ?? '') ?></p>
    <p class="timer">Time limit: <span id="timeLeft"><?= (int)$quiz['time_limit_minutes'] * 60 ?></span> seconds</p>
</div>

<form class="card" method="post" action="submit_quiz.php" id="quizForm">
    <input type="hidden" name="quiz_id" value="<?= (int)$quiz['id'] ?>">
    <?php while ($question = $questions->fetch_assoc()): ?>
        <div class="question">
            <h3>Q<?= (int)$question['question_order'] ?>. <?= e($question['question_text']) ?></h3>
            <p class="meta">Marks: <?= e((string)$question['marks']) ?></p>
            <?php
            $options_stmt = $conn->prepare("SELECT id, option_text FROM question_options WHERE question_id = ? ORDER BY option_order ASC");
            $options_stmt->bind_param('i', $question['id']);
            $options_stmt->execute();
            $options = $options_stmt->get_result();
            while ($option = $options->fetch_assoc()):
            ?>
                <label style="display:block; margin-bottom:8px;">
                    <input type="radio" name="answers[<?= (int)$question['id'] ?>]" value="<?= (int)$option['id'] ?>" required>
                    <?= e($option['option_text']) ?>
                </label>
            <?php endwhile; ?>
        </div>
    <?php endwhile; ?>

    <button type="submit">Submit Quiz</button>
</form>

<script>
let timeLeft = parseInt(document.getElementById('timeLeft').textContent, 10);
const display = document.getElementById('timeLeft');
const form = document.getElementById('quizForm');

const timer = setInterval(() => {
    timeLeft--;
    display.textContent = timeLeft;
    if (timeLeft <= 0) {
        clearInterval(timer);
        alert('Time is over. Your quiz will be submitted automatically.');
        form.submit();
    }
}, 1000);
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>