<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Include config file
require_once "connect.php";

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $captcha_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate CAPTCHA
    if(empty(trim($_POST["g-recaptcha-response"]))){
        $captcha_err = "Please complete the CAPTCHA.";
    } else {
        // Your secret key
        $secretKey = "6LfjkbgjAAAAADiSciLWKHOxhoJ5PCvddu3Hd1AJ";
        // Verify the CAPTCHA response
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST["g-recaptcha-response"]);
        $responseData = json_decode($verifyResponse);
        if(!$responseData->success) {
            $captcha_err = "CAPTCHA verification failed.";
        }
    }

    // Validate credentials
    if(empty($email_err) && empty($password_err) && empty($captcha_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, password, role FROM users WHERE email = ?";/*email ? means it is a parameter to prevent SQL injection */
        if($stmt = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();

                // Check if email exists, if yes then verify password
                if($stmt->num_rows == 1){
                    // Bind result variables
                    $stmt->bind_result($id, $email, $hashed_password, $role);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){ // Check if the user is already logged in, if yes then redirect him to welcome page
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["role"] = $role;

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

     // Close connection will close the database connection
    $connection->close();
}
?>
<?php require('templates/header.php') ?>

    <div class="wrapper mx-auto">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateCaptcha()">
    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
        <span class="help-block"><?php echo $email_err; ?></span>
    </div>
    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
        <span class="help-block"><?php echo $password_err; ?></span>
    </div>
    <!-- Google reCAPTCHA widget -->
    <div class="g-recaptcha" data-sitekey="6LfjkbgjAAAAAFNYyONgZM9epmJU2r_1Wz4BN2if"></div>
    <!-- jQuery and reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Login">
    </div>
    <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
</form>

<!-- JavaScript for displaying a notification if the CAPTCHA is not checked -->
<script>
function validateCaptcha() {
    if (grecaptcha.getResponse() == "") {
        alert("Please check the CAPTCHA");
        return false;
    } else {
        return true;
    }
}
</script>
    </div>

<?php require('templates/footer.php') ?>
