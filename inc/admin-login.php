<?php

include 'connect.php';
include 'header.php';
include "messages.php";
if (isset($message)){
    echo $message;
}

if (isset($_POST['login'])){
    extract($_POST);



    if (isset($user_name) &&  isset($password)) {

        $login_sql = "SELECT user_id, user_name, password FROM mesr_user
        WHERE user_name = '$user_name' ";
    
        $login_result = mysqli_query($conn, $login_sql);

        if(mysqli_num_rows($login_result) == 1) {
            $login_row = mysqli_fetch_assoc($login_result);
            $pswd = $login_row['password'];

            if(password_verify($password, $pswd)){
                session_start();
                $_SESSION['user_name'] = $login_row['user_name'];
                $_SESSION['user_id'] = $login_row['user_id'];
                $_SESSION['a-unique-catbb-thingyyy'] = session_id();
                $user_ide = $login_row['user_id'];
                $m .= "Success";
            }
            else {
                echo "1else";
                $validation = "<p>Password incorrect.</p>";
            }
            

        }
        else {
            echo "2els";
            $validation = "<p>Failed to log in.</p>";
        }
    }
    else {
        echo "3els";
        $validation .= "<p>Enter a username and password.</p>";
    }
}

?>


<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label for="user_name">Username</label>
    <input type="text" name="user_name" id="user_name" value="<?php if (isset($user_name)){echo $user_name;} ?>">
    <label for="password">Password</label>
    <input type="text" name="password" id="password" value="<?php if (isset($password)){echo $password;} ?>">

    <input type="submit" value="login" name="login">

    <?php if ($validation): ?>
        <div class="validation">
            <?php if(isset($validation)){echo $validation;} ?>
        </div>
    <?php endif ?>
</form>