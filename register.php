<?php include "inc/connect.php"; 

$form_good = $user_name = $output =  $validation = $email = $upassword =  $encrypted = "";

if (isset($_POST['register'])){

    $form_good = TRUE;
    $user_name = trim($_POST['user_name']);
    if (str_contains($user_name, ' ')) {
        $form_good = false;        
        $validation .= "Username cannot contain spaces. ";
    }
    // $email = trim($_POST['email']);
    $upassword = trim($_POST['password']);

    $user_name = filter_var($user_name, FILTER_SANITIZE_STRING);
    // $email = filter_var($email, FILTER_SANITIZE_STRING);
    $upassword = filter_var($upassword, FILTER_SANITIZE_STRING);
    // if (!str_contains($email, '@')){
    //     $form_good = false;
    //     $validation .= "Email format wrong";
    // }
    // if (!str_contains($email, '.')){
    //     $form_good = false;
    //     $validation .= "Email format wrong";
    // }
    // if (strlen($email < 6)){
    //     $form_good = false;
    //     $validation .= "Email must be at least 6 characters. ";
    // }
    if (strlen($upassword < 6)){
        $form_good = false;
        $validation .= "Password must be at least 6 characters. ";
    }
    $pattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/";
    if(preg_match($pattern, $upassword) == false) {
        $form_good = false;
        $validation .= "Password must be minimum 6 characters long and contain numbers, and lower and uppercase letters. ";
    }

    //add more validation

    if (isset($user_name)){
        $check_sql = "SELECT user_id from mesr_user WHERE user_name = '$user_name' ";
        $check_res = $conn->query($check_sql);
        if($check_res->num_rows > 0){
            $form_good = FALSE;
            $validation .= "<p>Sorry, username already taken. Please try another.</p>";
        }
    }

    if ($form_good == TRUE){
        $encrypted = password_hash($upassword, PASSWORD_DEFAULT);
        $sql = "INSERT INTO mesr_user ( user_name, password)
                VALUES ('$user_name', '$encrypted')";
        if($conn->query($sql)){
            $validation .= "<p>Registration successful</p>";
            $first_name = $last_name = $form_good = $user_name = $email = $upassword = "";
        }
        else {
            $validation .= "<p>Registration error REMOVE THIS LATER $conn->error</p>";
        }
    }
}

?>

<?php include "inc/header.php"; ?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label for="user_name">Username</label>
    <input type="text" name="user_name" id="user_name" value="<?php if ($user_name){echo $user_name;} ?>">
    <!-- <label for="email">Email</label>
    <input type="text" name="email" id="email" value="<?php //if ($email){echo $email;} ?>"> -->
    <label for="password">Password</label>
    <input type="text" name="password" id="password" value="<?php if ($upassword){echo $upassword;} ?>">

    <input type="submit" value="register" name="register">
    <?php if ($output): ?>
        <div>
            <?php echo $output; ?>
        </div>
    <?php endif ?>

    <?php if ($validation): ?>
        <div class="validation">
            <?php echo $validation; ?>
        </div>
    <?php endif ?>
</form>


<?php include "inc/footer.php"; ?>