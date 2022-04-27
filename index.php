<?php session_start();
include "inc/connect.php"; 
include "inc/header.php";
//TODO --PRIVACY POLICY ETC  --SECURITY  --FRIENDING BLOCKING SYSTEM  --WRITE ACTUAL MESSENGER SYSTEM BASED ON INSERT FORM WITH TEXT,IMG  --VALIDATE/FILTER
//styles

if (isset($_GET)){
    extract($_GET);
}
include "messages.php";
if (isset($message)){
    echo $message;
}



//add image validation, and show img code if it's not too difficult... start with text.
?>

<h1>Messenger</h1>

<?php if (isset($_SESSION['a-unique-catbb-thingyyy'])):  //if signed in ?>

<div class="homeflex">
    <?php //what happens if this is empty? used to take up all ?>
</div>

        <?php $my_id = $_SESSION['user_id']; //this is friend list
        $show_msg_sql = "SELECT DISTINCT `user_id_sender`, `sender_name` FROM `mesr_msgs` WHERE user_id_recip = '$my_id' 
                ORDER BY msg_id ASC";
        $show_msg_result = mysqli_query($conn, $show_msg_sql);
        if ($show_msg_result != false && $show_msg_result->num_rows>0): ?>
        <?php while ($row = mysqli_fetch_assoc($show_msg_result)): ?>
            <?php extract($row); ?>
            <div class="home-msg"> 
                <a href="<?php echo "index.php?sender=$user_id_sender";?>"><?php echo $sender_name; ?></a>
            </div>
        <?php endwhile ?>
        <?php else: ?>
            <?php echo "no friends available"; ?>
        <?php endif; ?>

    <?php if (isset($_GET['sender'])):  ?>
        <!-- <button type="button" onclick="window.location.reload(true)">Reload page</button> -->
        <?php //show convo with one friend used to be here ?>
        
    <?php include_once "friend-list.php"; //friend list used to be here ?>


    <? endif ?>
    
    <?php include_once "msg-send-form.php"; ?> 

    <?php //send a message function 
    if (isset($_POST['send_msg'])){
        extract($_POST);
        $friend_sql = "SELECT user_id, user_name FROM mesr_user
             WHERE user_name = '$send_to'"; 
            $get_one_result = $conn->query($friend_sql);
            if ($get_one_result->num_rows == 1) {
                $get_one_row = $get_one_result->fetch_assoc();
                $friend_id = $get_one_row["user_id"];
                $friend_name = $get_one_row["user_name"];
                $my_name = $_SESSION['user_name'];
                $my_id = $_SESSION['user_id'];

                //reload RE SENDDS THE LAST MSG...
                $msg_new_friend_sql = "INSERT INTO `mesr_msgs`(`user_id_recip`, `user_id_sender`, `sender_name`, `msg`) 
                                                       VALUES ('$friend_id', '$my_id', '$my_name', '$msgtosend')";
                $result = $conn->query($msg_new_friend_sql);
                if ($result != false) {
                    echo "Success";
                } 
                else {
                    echo "Fail msg" . mysqli_error($conn);
                }
            } 
    }
    ?>


    


<? endif ?>

</main>
</div>
</body>

