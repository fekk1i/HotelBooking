<div class="col-3 my-2">
	<div class="card m-auto room" style="width: 20rem;">
		<img class="card-img-top" src="<?php echo $server; ?>img/rooms/<?php echo $r['image'];?> ?>" alt="Card Image Caption">
		<div class="card-body">
			<h4 class="card-title"><?php echo $r['type']; ?></h4>
			<p class="card-text"><?php echo $r['description']; ?></p>
			<p>$<?php echo $r['price']; ?></p>

			
			<!-- Button trigger modal -->
			<button type="button" class="btn book-button" data-toggle="modal" data-target="#confirmOrder<?php echo $r["id"]; ?>">
				<span class="text-white"><i class="fa fa-key text-white"></i> Book</span>
			</button>

			<!-- Modal -->
			<div class="modal" id="confirmOrder<?php echo $r["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="confirmTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<form method="post">
							<input type="number" name="room_number" value="<?php echo $r["id"]; ?>" hidden>
							<div class="modal-header">
								<h3 class="modal-title" id="confirmTitle">Book Room</h3>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<label>Email Address</label>
									<input type="email" name="customer_email" class="form-control" 
									value="<?php 
									if ($user_logged) { 
										echo $_SESSION['email'];
									}
									?>" required="true">
								</div>
								<div class="form-group">
									<label>No. of adults</label>
									<input type="number" name="adults" class="form-control" value="2"/>
								</div>
								<div class="form-group">
									<label>No. of children</label>
									<input type="number" name="children" class="form-control" value="0"/>
								</div>
								<div class="form-group">
									<label>Check In</label>
									<input type="date" name="check_in" class="form-control" placeholder="Date of Check In"/>
								</div>
								<div class="form-group">
									<label>Check Out</label>
									<input type="date" name="check_out" class="form-control" placeholder="Date of Check Out"/>
								</div>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-primary">Confirm</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>