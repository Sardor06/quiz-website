<?php
include 'db.php';
$query = "SELECT * FROM question";
$total_question = mysqli_num_rows(mysqli_query($connection,$query));


?>
<html>
<head>
	<title>PHP online TEST</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<header>
		<div class="container">
			<p>PHP online TEST</p>
		</div>
	</header>

	<main>
			<div class="container">
				<h2>Test Your PHP Knowledge</h2>
				<p>
					This is a multiple choise quiz to test your PHP Knowledge.
				</p>
				<ul>
					<li><strong>Number of Questions:</strong><?php echo $total_question; ?> </li>
					<li><strong>Type:</strong> Multiple Choise</li>
					<li><strong>Estimated Time:</strong> <?php echo $total_question*1.5; ?></li>

				</ul>

				<a href="question.php?n=1" class="start">Start Quize</a>

			</div>

	</main>


	<footer>
			<div class="container">
				Copyright &copy; ITSERIESTUTORBY SARDOR
			</div>


	</footer>
