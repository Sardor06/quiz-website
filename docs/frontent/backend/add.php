<?php  include 'db.php';
if(isset($_POST['submit'])){
	$text = $_POST['question_text'];
	$choice1 = $_POST['choice1'];
	$choice2 = $_POST['choice2'];
	$choice3 = $_POST['choice3'];
	$correct = $_POST['correct'];


 // First Query for Questions Table

  $query = "INSERT INTO `question` (`question_number`, `question_text`, `choice1`, `choice2`, `choice3`, `correct`) VALUES (NULL, '".$text."', '".$choice1."', '".$choice2."', '".$choice3."', '".$correct."')";

	$result = mysqli_query($connection, $query);

	//Validate First Query
	// if($result){
	// 	foreach($choice as $option => $value){
	// 		if($value != ""){
	// 			if($correct_choice == $option){
	// 				$is_correct = 1;
	// 			}else{
	// 				$is_correct = 0;
	// 			}
	//
	//
	//
	// 			//Second Query for Choices Table
	// 			$query = "INSERT INTO options (";
	// 			$query .= "question_number,is_correct,coption)";
	// 			$query .= " VALUES (";
	// 			$query .=  "'{$question_number}','{$is_correct}','{$value}' ";
	// 			$query .= ")";
	//
	// 			$insert_row = mysqli_query($connection,$query);
	// 			// Validate Insertion of Choices
	//
	// 			if($insert_row){
	// 				continue;
	// 			}else{
	// 				die("2nd Query for Choices could not be executed" . $query);
	//
	// 			}
	//
	// 		}
	// 	}
	// 	$message = "Question has been added successfully";
	// }






}

		// $query = "SELECT * FROM question";
		// $question = mysqli_query($connection,$query);
		// $total = mysqli_num_rows($question);
		// $next = $total+1;


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
				<h2>Add A Question</h2>
				<?php if(isset($message)){
					echo "<h4>" . $message . "</h4>";
				} ?>

				<form method="POST" action="add.php">
						<p>
							<label>Question Text:</label>
							<input type="text" name="question_text">
						</p>
						<p>
							<label>Choice 1:</label>
							<input type="text" name="choice1">
						</p>
						<p>
							<label>Choice 2:</label>
							<input type="text" name="choice2">
						</p>
						<p>
							<label>Choice 3:</label>
							<input type="text" name="choice3">
						</p>
						<p>
							<label>Correct Option Number</label>
							<input type="number" name="correct">
						</p>
						<input type="submit" name="submit" value ="submit">


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
