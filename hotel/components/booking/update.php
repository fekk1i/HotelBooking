<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/hotel/";

require_once($path . 'connect.php');

// Initialize the session
session_start();

if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
	echo "Unauthorized Access";
	return;
}

$id = $_GET['id'];

$SelSql = "SELECT * FROM `bookings` WHERE id=$id";
$res = mysqli_query($connection, $SelSql);
$r = mysqli_fetch_assoc($res);

if(isset($_POST) & !empty($_POST)){
	$room_no = ($_POST['room_no']);
	$customer_email = ($_POST['customer_email']);
	$adults = ($_POST['adults']);
	$children = ($_POST['children']);
	$check_in = ($_POST['check_in']);
	$check_out = ($_POST['check_out']);

	$UpdateSql = "UPDATE `bookings` SET room_no='$room_no', customer_email='$customer_email', adults_num='$adults', children_num='$children', check_in='$check_in', check_out='$check_out' WHERE id='$id' ";
	$res = mysqli_query($connection, $UpdateSql);
	if($res){
		header('location: view.php');
	}else{
		$fmsg = "Failed to Update data.";
	}
}
?>
<?php require($path . 'templates/header.php') ?>

	<div class="mt-4">
	<?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
		<form method="post" class="mx-auto w-25">
            <div class="form-group">
                <label>Room Number</label>
				<input type="text" class="form-control" name="room_no" value="<?php echo $r['room_no']; ?>"/>
            </div> 
            <div class="form-group">
                <label>Customer Email</label>
				<input type="text" class="form-control" name="customer_email" value="<?php echo $r['customer_email']; ?>"/>
            </div> 
            <div class="form-group">
                <label>No. of Adults</label>
				<input type="number" class="form-control" name="adults" value="<?php echo $r['adults_num']; ?>"/>
            </div> 
            <div class="form-group">
                <label>No. of Children</label>
				<input type="number" class="form-control" name="children" value="<?php echo $r['children_num']; ?>"/>
            </div> 
            <div class="form-group">
				<label>Check In</label>
				<input type="date" name="check_in" class="form-control" value="<?php echo $r['check_in']; ?>"/>
			</div>
			<div class="form-group">
				<label>Check Out</label>
				<input type="date" name="check_out" class="form-control" value="<?php echo $r['check_out']; ?>"/>
			</div>
			<input type="submit" class="btn btn-primary" value="Update" />
		</form>
	</div>
	
<?php require($path . 'templates/footer.php') ?>