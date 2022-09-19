<form class="msg-send-form" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
    <label for="send_to">to (username)</label>
    <input type="text" id="send_to" name="send_to" value="<?php if(isset($sender_save)){echo htmlspecialchars($sender_save);} ?>">

    <label for="msgtosend">message</label>
    <textarea id="msgtosend"  class="input-field" name="msgtosend"></textarea>
<!-- 
        <label for="file_to_upload">image</label>
        <input type="file" name="file_to_upload" id="file_to_upload"> -->

    <input type="submit" value="Send" class="send_msg goldbutton <?php if(isset($_SESSION['theme'])){echo $_SESSION['theme'];}?>" name="send_msg"> 
    <!-- <button class="send_msg" name="send_msg">Send Message</button> -->
</form>