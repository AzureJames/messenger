<?php 
    session_start();
    include_once "inc/connect.php";



    if (isset($_SESSION['a-unique-catbb-thingyyy'])): ?>
        <?php             
            $my_id = $_SESSION['user_id'];
            $sender = $_GET['sender'];
            //show list of friends/conversations used to be here ?>
        <div class="hidden"></div>
        <div class="homeflex">
            <!-- this is populated with 2nd js function -->
        </div>

        <?php if (isset($_GET['sender'])): ?>
            <?php echo "<a href='index.php'>all conversations<br></a>"; ?>
            <a href="#bottom"><b>Scroll to Bottom</b><br></a>
            <a href="<?php header("THIS_PAGE"); ?>"><b>Refresh</b><br></a>
            <?php //show convo with one friend 
            $show_msg_sql = "SELECT `sender_name`, `user_id_sender`, `msg`, `msg_id` FROM `mesr_msgs` 
            WHERE (user_id_recip = '$my_id' AND user_id_sender = '$sender') 
            OR (user_id_recip = '$sender' AND user_id_sender = '$my_id')
            ORDER BY msg_id ASC";
            $show_msg_result = mysqli_query($conn, $show_msg_sql);
            if ($show_msg_result != false && $show_msg_result->num_rows>0): ?>
                <?php while ($row = mysqli_fetch_assoc($show_msg_result)): ?>
                    <?php extract($row); 
                        if ($user_id_sender != $my_id){ //sent to user
                        $sender_save = $sender_name; 
                        echo "<div class=\"home-msg\">"; } 
                        else {
                        echo "<div class=\"your-msg\">";
                        }?>
                        <p><?php echo $msg; ?></p>
                    </div>
                <?php endwhile ?>
            <? endif ?>

            <a id="bottom"></a>
            <a href="<?php header("https://azurejames.com/messenger/index.php?sender=$sender#bottom"); ?>"><b>Refresh</b><br></a>
        <? endif ?>

    <? endif ?>