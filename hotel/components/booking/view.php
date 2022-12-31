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
if ($_SESSION['role'] == 'admin') {
	$ReadSql = "SELECT * FROM `bookings` ORDER BY id";
	# code...
}else {
	$email =$_SESSION['email'];
	$ReadSql = "SELECT * FROM `bookings` WHERE customer_email='$email' ORDER BY id";
}
$res = mysqli_query($connection, $ReadSql);

?>
<?php require($path . 'templates/header.php') ?>

	<div class="container-fluid my-4">
		<div class="row my-2">
			<h2>Luxury boys Hotel - Bookings</h2>	
		</div>
		<table class="table "> 
		<thead> 
			<tr> 
				<th>Booking No.</th> 
				<th>Room No.</th> 
				<th>Customer Email</th> 
				<th>No. of guests</th> 
				<th>Check-In Date</th> 
				<th>Check-Out Date</th> 
				<th>Action</th>
			</tr> 
		</thead> 
		<tbody> 
		<?php 
		while($r = mysqli_fetch_assoc($res)){
		?>
			<tr> 
				<th scope="row"><?php echo $r["id"]; ?></th> 
				<td><?php echo $r["room_no"]; ?></td> 
				<td><?php echo $r["customer_email"]; ?></td> 
				<td><?php echo ($r["adults_num"] + $r["children_num"]); ?></td>
				<td><?php echo $r["check_in"]; ?></td> 
				<td><?php echo $r["check_out"]; ?></td> 
				<td>
					<a href="update.php?id=<?php echo $r["id"]; ?>"><button type="button" class="btn btn-info">Edit</button></a>

					<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal">Delete</button>

					<!-- Modal -->
					  <div class="modal fade" id="myModal" role="dialog">
					    <div class="modal-dialog">
					    
					      <!-- Modal content-->
					      <div class="modal-content">
					        <div class="modal-header">
                            <h5 class="modal-title">Delete Booking</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
					        </button>
					        </div>
					        <div class="modal-body">
					          <p>Are you sure?</p>
					        </div>
					        <div class="modal-footer">
					          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					          <a href="delete.php?id=<?php echo $r["id"]; ?>"><button type="button" class="btn btn-danger"> Yes, Delete</button></a>
					        </div>
					      </div>
					      
					    </div>
					  </div>

				</td>
			</tr> 
		<?php } ?>
		</tbody> 
		</table>
	</div>  


<div id="confirm" class="modal hide fade">
  <div class="modal-body">
    Are you sure?
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
  </div>
</div>

<?php require($path . 'templates/footer.php') ?>