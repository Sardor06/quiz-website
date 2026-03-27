<?php
require_once __DIR__ . '/../config/init.php';
require_login();

if (!is_admin()) {
    die('Access denied.');
}

$message = '';
$error = '';

// create category if needed
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $time_limit = (int)($_POST['time_limit_minutes'] ?? 10);
    $category_name = trim($_POST['category_name'] ?? 'General');

    if ($title === '') {
        $error = 'Quiz title is required.';
    } else {
        $cat_stmt = $conn->prepare("SELECT id FROM categories WHERE name = ?");
        $cat_stmt->bind_param('s', $category_name);
        $cat_stmt->execute();
        $cat = $cat_stmt->get_result()->fetch_assoc();

        if (!$cat) {
            $insert_cat = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
            $cat_desc = 'Created from admin page';
            $insert_cat->bind_param('ss', $category_name, $cat_desc);
            $insert_cat->execute();
            $category_id = $conn->insert_id;
        } else {
            $category_id = (int)$cat['id'];
        }

        $insert_quiz = $conn->prepare("INSERT INTO quizzes (category_id, title, description, time_limit_minutes, total_questions, pass_score, is_published, created_by) VALUES (?, ?, ?, ?, 0, 50.00, 1, ?)");
        $insert_quiz->bind_param('issii', $category_id, $title, $description, $time_limit, $_SESSION['user_id']);
        $insert_quiz->execute();
        $quiz_id = $conn->insert_id;

        $questions = $_POST['questions'] ?? [];
        $question_count = 0;

        foreach ($questions as $index => $question) {
            $question_text = trim($question['text'] ?? '');
            $correct = (int)($question['correct'] ?? 1);
            $options = $question['options'] ?? [];

            if ($question_text === '' || count($options) < 2) {
                continue;
            }

            $question_order = $index + 1;
            $marks = 1.00;

            $insert_question = $conn->prepare("INSERT INTO questions (quiz_id, question_text, question_type, marks, question_order) VALUES (?, ?, 'single_choice', ?, ?)");
            $insert_question->bind_param('isdi', $quiz_id, $question_text, $marks, $question_order);
            $insert_question->execute();
            $question_id = $conn->insert_id;

            $opt_order = 1;
            foreach ($options as $opt_index => $option_text) {
                $option_text = trim($option_text);
                if ($option_text === '') {
                    continue;
                }
                $is_correct = ($opt_index + 1 === $correct) ? 1 : 0;
                $insert_option = $conn->prepare("INSERT INTO question_options (question_id, option_text, is_correct, option_order) VALUES (?, ?, ?, ?)");
                $insert_option->bind_param('isii', $question_id, $option_text, $is_correct, $opt_order);
                $insert_option->execute();
                $opt_order++;
            }

            $question_count++;
        }

        $update_quiz = $conn->prepare("UPDATE quizzes SET total_questions = ? WHERE id = ?");
        $update_quiz->bind_param('ii', $question_count, $quiz_id);
        $update_quiz->execute();

        $message = 'Quiz created successfully.';
    }
}

include __DIR__ . '/../includes/header.php';
?>
<div class="card">
    <h2>Create Quiz (Admin)</h2>
    <p class="meta">After registering a user, change the role in the database to <strong>admin</strong> to use this page.</p>
    <?php if ($message): ?><div class="success"><?= e($message) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>

    <form method="post">
        <label>Quiz Title</label>
        <input type="text" name="title" required>

        <label>Description</label>
        <textarea name="description"></textarea>

        <label>Category Name</label>
        <input type="text" name="category_name" value="General">

        <label>Time Limit (minutes)</label>
        <input type="number" name="time_limit_minutes" value="10" min="1">

        <h3>Question 1</h3>
        <label>Question Text</label>
        <input type="text" name="questions[0][text]" required>
        <label>Option 1</label>
        <input type="text" name="questions[0][options][]" required>
        <label>Option 2</label>
        <input type="text" name="questions[0][options][]" required>
        <label>Option 3</label>
        <input type="text" name="questions[0][options][]">
        <label>Option 4</label>
        <input type="text" name="questions[0][options][]">
        <label>Correct Option Number (1-4)</label>
        <input type="number" name="questions[0][correct]" value="1" min="1" max="4">

        <h3>Question 2</h3>
        <label>Question Text</label>
        <input type="text" name="questions[1][text]">
        <label>Option 1</label>
        <input type="text" name="questions[1][options][]">
        <label>Option 2</label>
        <input type="text" name="questions[1][options][]">
        <label>Option 3</label>
        <input type="text" name="questions[1][options][]">
        <label>Option 4</label>
        <input type="text" name="questions[1][options][]">
        <label>Correct Option Number (1-4)</label>
        <input type="number" name="questions[1][correct]" value="1" min="1" max="4">

        <h3>Question 3</h3>
        <label>Question Text</label>
        <input type="text" name="questions[2][text]">
        <label>Option 1</label>
        <input type="text" name="questions[2][options][]">
        <label>Option 2</label>
        <input type="text" name="questions[2][options][]">
        <label>Option 3</label>
        <input type="text" name="questions[2][options][]">
        <label>Option 4</label>
        <input type="text" name="questions[2][options][]">
        <label>Correct Option Number (1-4)</label>
        <input type="number" name="questions[2][correct]" value="1" min="1" max="4">

        <button type="submit">Create Quiz</button>
    </form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>