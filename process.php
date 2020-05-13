<?php 

include_once 'db.php';

if(isset($_POST['vote'])){

	$voter_email = $_POST['email'];

	if(!isset($_POST['choice'])){
		$voter_choice = $_POST['choice'] = "Null";
		header("location: index.php?choice_not_set");
	}
	else{
		$voter_choice = $_POST['choice'];
	}
	/*echo $choice;*/

	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		header("location: index.php?email_invalid");
	}

	else{
		$sql = "SELECT voter_email FROM vote WHERE voter_email ='$voter_email' ";
		$result = mysqli_query($connection, $sql);
		print_r( $result);

		if(mysqli_num_rows($result) > 0){
			header("location: index.php?email_has_been_used");
		}else{
			
			$date = date("Y-m-d h:i:sa");
			$query = mysqli_query($connection, "INSERT INTO vote VALUES('', '$voter_email','$voter_choice','$date');");

			print_r( $query);
			if(!$query){
				header("Location: index.php?could_not_vote");
			}
			else{
				header("Location: index.php?thanx_for_voting");

			}
		}
		

	}

}






 ?>