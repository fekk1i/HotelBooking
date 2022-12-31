<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/hotel/";

require_once($path . 'connect.php');

// Initialize the session
session_start();

if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['role'] == 'admin')) {
	echo "Unauthorized Access";
	return;
}

if(isset($_POST) & !empty($_POST)){
	$type = ($_POST['type']);
	$price = ($_POST['price']);
	$description = ($_POST['description']);
	// store n upload image
    $image = $_FILES['image']['name']; 
    $dir="../img/rooms/";
    $temp_name=$_FILES['image']['tmp_name'];
    if($image!="")
    {
        if(file_exists($dir.$image))
        {
            $image= time().'_'.$image;
        }
        $fdir= $dir.$image;
        move_uploaded_file($temp_name, $fdir);
    }

    // Execute query
	$query = "INSERT INTO `rooms` (type, price, description, image) VALUES ('$type', '$price', '$description', '$image')";
	$res = mysqli_query($connection, $query);
	if($res){
		header('location: view.php');
	}else{
		$fmsg = "Failed to Insert data.";
		print_r($res->error_list);
	}
}
?>

<?php require_once($path . 'templates/header.php') ?>

	<div class="container">
	<?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
		<h2 class="my-4">Add New Room</h2>
		<form method="post" enctype="multipart/form-data">
			<div class="form-group">
                <label>Type</label>
				<input type="text" id="id" class="form-control" name="type" value="" required/>
            </div> 
            <div class="form-group">
                <label>Price</label>
				<input type="number" class="form-control" name="price" value="" required/>
            </div> 
            <div class="form-group">
                <label>Description</label>
				<input type="text" class="form-control" name="description" value=""/>
            </div> 
            <div class="form-group">
                <label>Image</label>
				<input type="file" class="form-control" name="image" accept=".png,.gif,.jpg,.webp" required/>
            </div> 
			<input type="submit" class="btn btn-primary" value="Add Room" />
		</form>
	</div>
	
<?php require_once($path . 'templates/footer.php') ?>