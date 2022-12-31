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

$id = $_GET['id'];

$SelSql = "SELECT * FROM `rooms` WHERE id=$id";
$res = mysqli_query($connection, $SelSql);
$r = mysqli_fetch_assoc($res);


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
    }else {
    	$image = $r['img'];
    }

    // Execute query
	$query = "UPDATE `rooms` SET type='$type', price='$price', description='$description', image='$image' WHERE id='$id'";
	
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
		<h2 class="my-4">Add New Product</h2>
		<form method="post" enctype="multipart/form-data">
			<div class="form-group">
                <label>Type</label>
				<input type="text" class="form-control" name="type" value="<?php echo $r['type'];?>" required/>
            </div> 
            <div class="form-group">
                <label>New Price</label>
				<input type="text" class="form-control" name="price" value="<?php echo $r['price'];?>" required/>
            </div> 
            <div class="form-group">
                <label>Description</label>
				<input type="text" class="form-control" name="description" value="<?php echo $r['description'];?>"/>
            </div> 
            <div class="form-group">
                <label>New Image</label>
				<input type="file" class="form-control" name="image" accept=".png,.gif,.jpg,.webp"/>
            </div> 
			<input type="submit" class="btn btn-primary" value="Update" />
		</form>
	</div>
	
<?php require_once($path . 'templates/footer.php') ?>