<?php session_start();
include "inc/connect.php"; 
include "inc/header.php";
//TODO --PRIVACY POLICY ETC  --SECURITY  --FRIENDING BLOCKING SYSTEM  --WRITE ACTUAL MESSENGER SYSTEM BASED ON INSERT FORM WITH TEXT,IMG  --VALIDATE/FILTER
//styles

if (!isset($_SESSION['a-unique-catbb-thingyyy']))
{
    header("location:index.php");
}  

if (isset($_POST)){
    extract($_POST);
}
include "messages.php";
if (isset($message)){
    echo $message;
}
//validate searchterm

//basically sends a msg
if (isset($add_friend)){
    $friend_sql = "SELECT user_id, user_name FROM mesr_user
         WHERE user_name = '$searchterm'"; 
        $get_one_result = $conn->query($friend_sql);
        if ($get_one_result->num_rows == 1) {
            $get_one_row = $get_one_result->fetch_assoc();
            $friend_id = $get_one_row["user_id"];
            $friend_name = $get_one_row["user_name"];
            $my_id = $_SESSION['user_id'];
            $msg_new_friend_sql = "INSERT INTO `mesr_msgs`(`user_id_recip`, `user_id_sender`, `user_name`, `msg`) 
                                                   VALUES ('$friend_id', '$my_id', '$friend_name', 'Hello, will you be my friend?')";
            $result = $conn->query($msg_new_friend_sql);
            if ($result != false) {
                echo "Success";
            } 
            else {
                echo "Fail msg" . mysqli_error($conn);
            }
        } 
}


//TODO if set add_friend and valid name send a hi msg to them i guess then you'll be connected
?>

<h1>Friends</h1>
<p>Messages</p>


    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="POST">
        <label for="searchterm">Add Friend by Username</label>
        <input type="text" name="searchterm" id="searchterm" value="<?php if(isset($searchterm)){echo $searchterm;} ?>">
        <input type="submit" value="Add Friend" name="add_friend">
    </form>
</main>
</div>
</body>

