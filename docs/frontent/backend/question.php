<?php
	include 'db.php';
	session_start();
	$number = $_GET['n'];

	$query = "SELECT * FROM question WHERE question_number = $number";

	$result = mysqli_query($connection,$query);
	$question = mysqli_fetch_assoc($result);

	$query = "SELECT * FROM question";
	$total_question = mysqli_num_rows(mysqli_query($connection,$query));
?>
<html>
<head>
	<title>PHP Quizer</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<header>
		<div class="container">
			<p>PHP Quizer</p>
		</div>
	</header>

	<main>
			<div class="container">
				<div class="current">Question <?php echo $number; ?> of <?php echo $total_question; ?> </div>
				<p class="question"><?php echo strip_tags($question['question_text']); ?> </p>
				<form method="POST" action="process.php">
					<ul class="choicess">
						<li><label for="first"><?php echo strip_tags($question['choice1']); ?></label><input type="radio" id="first" name="choice" value="1"></li>
						<li><label for="second"><?=$question['choice2']?></label><input type="radio" id="second" name="choice" value="2"></li>
						<li><label for="third"><?=$question['choice3']?></label><input type="radio" id="third" name="choice" value="3"></li>
					</ul>
					<input type="hidden" name="number" value="<?php echo $number; ?>">
					<input type="submit" name="submit" value="Submit">


				</form>


			</div>

	</main>


	<footer>
			<div class="container">
				Copyright &copy; IT SERIES TUTOR BY SARDOR
			</div>


	</footer>








</body>
</html>
