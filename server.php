<?php
include_once "inc/connect.php";
if (isset($_SESSION['a-unique-catbb-thingyyy'])){
                
            $my_id = $_SESSION['user_id'];
            $sender = $_GET['sender'];
            //show list of friends/conversations used to be here 
    
         if (isset($_GET['sender'])) {
            $sql = mysqli_query($conn,
            "SELECT `sender_name`, `user_id_sender`, `msg`, `msg_id` FROM `mesr_msgs` 
                        WHERE user_id_recip = 3");
            
            $show_msg_result = mysqli_query($conn, $sql);
            if ($show_msg_result != false && $show_msg_result->num_rows>0){
                 while ($row = mysqli_fetch_assoc($show_msg_result)) {
                     extract($row); 
                }
            exit(json_encode($result));
            }
        }
}
    // SELECT `sender_name`, `user_id_sender`, `msg`, `msg_id` FROM `mesr_msgs` 
    //                     WHERE (user_id_recip = '$my_id' AND user_id_sender = '$sender') 
    //                     OR (user_id_recip = '$sender' AND user_id_sender = '$my_id')
    //                     ORDER BY msg_id ASC
?>