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
if (isset($_GET)){
    extract($_GET);
}
include "messages.php";
if (isset($message)){
    echo $message;
}
//validate searchterm

//basically sends a msg req for person
if (isset($add_friend)){


        $friend_sql = $conn->prepare("SELECT user_id, user_name FROM mesr_user
        WHERE user_name = ?");
        $friend_sql->bind_param("s", $searchterm);
        $friend_sql->execute();
    
        $get_one_result = $friend_sql->get_result();
    

        if ($get_one_result->num_rows == 1) {
            $get_one_row = $get_one_result->fetch_assoc();
            $friend_id = $get_one_row["user_id"];
            $friend_name = $get_one_row["user_name"];
            $my_id = $_SESSION['user_id'];
            $my_name = $_SESSION['user_name'];

            $msg_for_friend =  'Hello, will you be my friend?';
            $msg_new_friend_sql = $conn->prepare("INSERT INTO `mesr_msgs`(`user_id_recip`, `user_id_sender`, `sender_name`, `msg`) 
                                                VALUES (?, ?, ?, ?)");
            $msg_new_friend_sql->bind_param("iiss", $friend_id, $my_id, $my_name, $msg_for_friend);
            $msg_new_friend_sql->execute();

            $result = $msg_new_friend_sql->get_result();
            echo "Message sent" . $result;
            
        } 
}


//FROM THE HOBBY PART sends msg
if (isset($add)){

        $friend_sql = $conn->prepare("SELECT user_id, user_name FROM mesr_user
        WHERE user_name = ?");
        $friend_sql->bind_param("s", $add);
        $friend_sql->execute();
    
        $get_one_result = $friend_sql->get_result();
    

        if ($get_one_result->num_rows == 1) {
            $get_one_row = $get_one_result->fetch_assoc();
            $friend_id = $get_one_row["user_id"];
            $friend_name = $get_one_row["user_name"];
            $my_id = $_SESSION['user_id'];
            $my_name = $_SESSION['user_name'];

            $msg_for_friend = 'Hello, we both like the interest "' . $msgf . '" will you be my friend?';
            $msg_new_friend_sql = $conn->prepare("INSERT INTO `mesr_msgs`(`user_id_recip`, `user_id_sender`, `sender_name`, `msg`) 
                                                VALUES (?, ?, ?, ?)");
            $msg_new_friend_sql->bind_param("iiss", $friend_id, $my_id, $my_name, $msg_for_friend);
            $msg_new_friend_sql->execute();

            $result = $msg_new_friend_sql->get_result();
            echo "Same Interest introduction message sent" . $result;
            
        } 
}


?>

<h1>Request Friend</h1>



    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="POST">
        <label for="searchterm">Add Friend by Username</label>
        <input type="text" name="searchterm" id="searchterm" value="<?php if(isset($searchterm)){echo $searchterm;} ?>">
        <input type="submit" value="Add Friend" name="add_friend">
    </form>
</main>
<?php include_once "inc/footer.php"; ?>
</div>
</body>

