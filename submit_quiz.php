<?php
require_once __DIR__ . '/config/init.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$quiz_id = (int)($_POST['quiz_id'] ?? 0);
$answers = $_POST['answers'] ?? [];

$q_stmt = $conn->prepare("SELECT id, marks FROM questions WHERE quiz_id = ?");
$q_stmt->bind_param('i', $quiz_id);
$q_stmt->execute();
$questions = $q_stmt->get_result();

$total_marks = 0.0;
$score = 0.0;
$question_map = [];

while ($q = $questions->fetch_assoc()) {
    $question_map[(int)$q['id']] = (float)$q['marks'];
    $total_marks += (float)$q['marks'];
}

$attempt_stmt = $conn->prepare("INSERT INTO quiz_attempts (quiz_id, user_id, started_at, finished_at, score, total_marks, percentage, status) VALUES (?, ?, NOW(), NOW(), 0, 0, 0, 'submitted')");
$attempt_stmt->bind_param('ii', $quiz_id, $_SESSION['user_id']);
$attempt_stmt->execute();
$attempt_id = $conn->insert_id;

foreach ($question_map as $question_id => $marks) {
    $selected_option_id = isset($answers[$question_id]) ? (int)$answers[$question_id] : null;
    $is_correct = 0;
    $awarded_marks = 0.0;

    if ($selected_option_id) {
        $check_stmt = $conn->prepare("SELECT is_correct FROM question_options WHERE id = ? AND question_id = ?");
        $check_stmt->bind_param('ii', $selected_option_id, $question_id);
        $check_stmt->execute();
        $opt = $check_stmt->get_result()->fetch_assoc();

        if ($opt && (int)$opt['is_correct'] === 1) {
            $is_correct = 1;
            $awarded_marks = $marks;
            $score += $marks;
        }
    }

    $insert_answer = $conn->prepare("INSERT INTO user_answers (attempt_id, question_id, selected_option_id, is_correct, awarded_marks, answered_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $insert_answer->bind_param('iiiid', $attempt_id, $question_id, $selected_option_id, $is_correct, $awarded_marks);
    $insert_answer->execute();
}

$percentage = $total_marks > 0 ? round(($score / $total_marks) * 100, 2) : 0.0;
$update_attempt = $conn->prepare("UPDATE quiz_attempts SET score = ?, total_marks = ?, percentage = ?, status = 'graded' WHERE id = ?");
$update_attempt->bind_param('dddi', $score, $total_marks, $percentage, $attempt_id);
$update_attempt->execute();

header('Location: result.php?attempt_id=' . $attempt_id);
exit;
?>