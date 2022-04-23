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

<?php if (isset($_SESSION['a-unique-catbb-thingyyy'])):  ?>
    

    <?php if (isset($_GET['sender'])):  ?>
        <?php //show convo from one friend
        $my_id = $_SESSION['user_id'];
        $sender = $_GET['sender'];
        $show_msg_sql = "SELECT `sender_name`, `msg` FROM `mesr_msgs` 
        WHERE user_id_recip = '$my_id' AND user_id_sender = '$sender' ";
        $show_msg_result = mysqli_query($conn, $show_msg_sql);
        if ($show_msg_result != false && $show_msg_result->num_rows>0): ?>
            <?php while ($row = mysqli_fetch_assoc($show_msg_result)): ?>
                <?php extract($row); ?>
                <div class="home-msg"> 
                    <p><?php echo $sender_name; ?></p>
                    <p><?php echo $msg; ?></p>
                </div>
            <?php endwhile ?>
        <? endif ?>

    <?php else: ?>
        <?php //show list of friends/conversations 
        $my_id = $_SESSION['user_id'];
        $show_msg_sql = "SELECT DISTINCT `user_id_sender`, `sender_name` FROM `mesr_msgs` WHERE user_id_recip = '$my_id' ";
        $show_msg_result = mysqli_query($conn, $show_msg_sql);
        if ($show_msg_result != false && $show_msg_result->num_rows>0): ?>
        <?php while ($row = mysqli_fetch_assoc($show_msg_result)): ?>
            <?php extract($row); ?>
            <div class="home-msg"> 
                <a href="<?php echo THIS_PAGE . "?sender=$user_id_sender";?>"><?php echo $sender_name; ?></a>
            </div>
        <?php endwhile ?>
        <? endif ?>
    <? endif ?>
    

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
    
    <?php //if friend ID selected show LIMIT 30 messages from them plus form ?>
    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
        <label for="send_to">to (username)</label>
        <input type="text" id="send_to" name="send_to" value="<?php if(isset($sender_name)){echo htmlspecialchars($sender_name);} ?>">

        <label for="msgtosend">message</label>
        <textarea id="msgtosend" name="msgtosend"><?php if(isset($msgtosend)){echo htmlspecialchars($msgtosend);} ?></textarea>

        <label for="file_to_upload">image</label>
        <input type="file" name="file_to_upload" id="file_to_upload">

        <input type="submit" value="Send" name="send_msg">
    </form>
<? endif ?>

</main>
</div>
</body>

