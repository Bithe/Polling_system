<?php

include_once 'db.php';
/*date_default_timezone_set("Asia/Dhaka");*/

$phpQuery = mysqli_query($connection, "SELECT * FROM vote WHERE voter_choice ='PHP'");
$javaQuery = mysqli_query($connection, "SELECT * FROM vote WHERE voter_choice ='JAVA'");

$numVotersPHP = mysqli_num_rows($phpQuery);
$numVotersJAVA = mysqli_num_rows($javaQuery);

$sum = $numVotersPHP+$numVotersJAVA;

if($numVotersPHP === 0){
	$phpPercent = 0;
}
else{
	$phpPercent = round(floatval( ($numVotersPHP / $sum) * 100));

}


if($numVotersJAVA === 0){
	$javaPercent = 0;
}
else{
	$javaPercent = round(floatval( ($numVotersJAVA / $sum) * 100));

}




?>




<!DOCTYPE html>
<html>
<head>
	<title>Polling system</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script type="text/javascript">

		$(document).ready(function(){
			setInterval(function(){
				$('#time').load('time.php')
			}, 1000);

		});
		
	</script>


	<style type="text/css">
		@font-face{
			font-family: clock;
			src: url(digital-7.ttf);
		}
		#time{
			width: 100%;
			margin: 0 auto;
			font-family: clock;
			font-size: 20px;

		}
		
	</style>
</head>

<body>

	<div class="container">
		<div class="row justify-content-center">

			<div class="col-lg-8">
				<h2 style="font-family: Comic Sans MS;text-align: center;">Polling Application</h2>

				<div id="time" style="display: inline-block;text-align: right;" >
					<h3> 00 : 00 : 00 PM </h3>
				</div>

				<form action="process.php" method="POST" role="form">

					<div class="form-group">
						<p style="font-family: Comic Sans MS;font-weight: bold;">Email:</p>
						<!-- <h4 style="font-family: Comic Sans MS;">Email:</h4> -->

						<input type="email" name="email" placeholder ="Email Address" class="form-control" >
					</div>

					<div class="radio" style="display: flex;">
						<p style="font-family: Comic Sans MS;font-weight: bold;">Chosse one:</p>

						<label class="radio">
							<input type="radio" name="choice" value="PHP"><img src="image/php.jpg" width="150"><h3 style="display: inline-block;">&nbsp;PHP</h3>
						</label>

						<label class="radio">
							<input 
							type="radio" name="choice" value="JAVA"><img src="image/java.png" width="150"><h3 style="display: inline-block;">&nbsp;JAVA</h3>
						</label>
					</div>

					<div class="form-group">
						<input type="submit" name="vote" value="VOTE" class="btn btn-primary">
					</div>
				</form>

				<!-- progress bar of bootstrap -->

					<div class="progress">
					  <div class="progress-bar progress-bar-striped" style="width:<?php echo $phpPercent; ?>%">
					  	<?php echo $phpPercent; ?>%
					  </div>
					  <div class="progress-bar progress-bar-danger" style="width:<?php echo $javaPercent; ?>%"> <?php echo $javaPercent; ?>%
					  </div>
					</div>

				<div class="table-responsive">

					<table class="table table-hover table-stripped table-bordered">

						<thead>
							<tr>
								<th>Voter's Email</th>
								<th>Voters Choice</th>
								<th>Voting Date and Time</th>
								<th>Time Interval</th>
							</tr>
						</thead>

						<tbody>

							<?php

							$query = mysqli_query($connection, "SELECT * from vote ORDER BY voter_id DESC");
							while ($row = mysqli_fetch_array($query)) :

								$email  = $row['voter_email'];
								$choice = $row['voter_choice'];
								$dateTime = $row['date_time'];
								$message = "just now";
								$date_time_now =  date("Y-m-d h:i:sa");

								$startdate = new DateTime($dateTime);
								$endDate = new DateTime($date_time_now);

								$interval = $startdate->diff($endDate);

								//time interval duration

								if($interval->y >= 1){
									if($interval->y === 1){
										$message = $interval->y . "year ago";
									}
									else{
										$message = $interval->y . "years age";
									}

								}

								elseif($interval->m >= 1){
									if($interval->m === 1){
										$message = $interval->m . "month ago";
									}
									else{
										$message = $interval->m . "months age";
									}

								}

								elseif($interval->d >= 1){
									if($interval->d === 1){
										$message = $interval->d . "day ago";
									}
									else{
										$message = $interval->d . "days age";
									}

								}



								if($interval->h >= 1){
									if($interval->h === 1){
										$message = $interval->h . "hour ago";
									}
									else{
										$message = $interval->h . "hours age";
									}

								}

								elseif($interval->i >= 1){
									if($interval->i === 1){
										$message = $interval->i . "minute ago";
									}
									else{
										$message = $interval->i . "minutes age";
									}

								}

								elseif($interval->s >= 1){
									if($interval->s === 1){
										$message = $interval->s . "second ago";
									}
									else{
										$message = $interval->d . "seconds age";
									}

								}
/*
								$assigned_seconds = strtotime($startdate);

									$completed_seconds = strtotime($date_time_now);

									$duration = $completed_seconds - $assigned_seconds;

									// j gives days
									$time = date ( 'j g:i:s', $duration );
									echo $time;
*/

							?>

							<tr>
								<td><?php echo  $email; ?></td>
								<td><?php echo $choice; ?></td>
								<td><?php echo $dateTime; ?></td>
								<td><?php echo $message; ?></td>
							</tr>

							<?php endwhile;	?>

						<?php

								
							


							?>
							
						</tbody>


					</table>
				</div>


			</div>
			
		</div>
	</div>

</body>
</html>