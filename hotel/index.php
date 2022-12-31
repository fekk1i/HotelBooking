<?php
require_once ('connect.php');

// Initialize the session
session_start();

if(isset($_POST) & !empty($_POST)){
	$room_number = ($_POST['room_number']);
	$customer_email = ($_POST['customer_email']);
	$adults = ($_POST['adults']);
	$children = ($_POST['children']);
	$check_in = ($_POST['check_in']);
	$check_out = ($_POST['check_out']);

    // Execute query
	$query = "INSERT INTO `bookings` (room_no, customer_email, adults_num, children_num, check_in, check_out) VALUES ('$room_number', '$customer_email', '$adults', '$children', '$check_in', '$check_out')";
	$res = mysqli_query($connection, $query);
	if($res){
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
			header('location: components/booking/view.php');
		}else {
			header('location: index.php');
		}
	}else{
		$fmsg = "Failed to Insert data.";
		print_r($res->error_list);
	}
}

?>
<?php require('templates/header.php') ?>
	<div class="d-flex">
		<img src="img/hotel_pic.jpg" class="hotel-img">
		<span class="tagline">Our Goal Your Satisfaction.</span>
	</div>
	<div class="d-flex mt-4 mx-4">
        <h2>Welcome To Luxury boys Hotel,
        	<b><?php // check user login and output username
			if ($user_logged) {
				$user_id = ($_SESSION['id']);
				$select_sql = "SELECT name FROM `users` WHERE id='$user_id'";
				$result = mysqli_query($connection, $select_sql);
				if ($result->num_rows > 0) {
					$row = mysqli_fetch_assoc($result);
					echo $row["name"];
					if (!$row["name"]) {
						 echo "Guest";
					}
				}
			} else {
			    echo "Guest";
			}
        	?></b> 	
        </h2>
    </div>

    <div class="d-flex my-2">
	<?php // output success or failed message.
      	if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
    <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
    </div>

	<div class="row main-section">
      <?php 
		$SelSql = "SELECT * FROM `rooms`";
		$res = mysqli_query($connection, $SelSql);
		$num_of_rows = mysqli_num_rows($res);
		if ($num_of_rows > 0) {
	    	// output data of each row
		    while($num_of_rows > 0) {
		    	$num_of_rows--;
		    	$r = mysqli_fetch_assoc($res);
		        include('templates/room.php');
		    }
		} else {
		    echo "<p>No Room Available</p>";
		}
	?>
	</div>

<?php require('templates/footer.php') ?>