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
    <?php //show list of friends/conversations 
    $my_id = $_SESSION['user_id'];
    $show_msg_sql = "SELECT `user_id_recip`, `user_id_sender`, `user_name`, `msg`, `img_file`, `msg_id` FROM `mesr_msgs` WHERE user_id_recip = '$my_id' ";
    $show_msg_result = mysqli_query($conn, $show_msg_sql);
    if ($show_msg_result != false && $show_msg_result->num_rows>0): ?>
        <?php while ($row = mysqli_fetch_assoc($show_msg_result)): ?>
            <?php extract($row); ?>
            <div class="home-msg"> 
                <p><?php echo $user_name; ?></p>
                <p><?php echo $msg; ?></p>
            </div>
        <?php endwhile ?>
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
                $my_id = $_SESSION['user_id'];
                $msg_new_friend_sql = "INSERT INTO `mesr_msgs`(`user_id_recip`, `user_id_sender`, `user_name`, `msg`) 
                                                       VALUES ('$friend_id', '$my_id', '$friend_name', '$msgtosend')";
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
        <input type="text" id="send_to" name="send_to"><?php if(isset($send_to)){echo htmlspecialchars($send_to);} ?></input>

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

