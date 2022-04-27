<?php session_start();
include "inc/connect.php"; 
include "inc/header.php";

if (isset($_GET)){
    extract($_GET);
}
include "messages.php";
if (isset($message)){
    echo $message;
}
if (isset($interesta)){
    echo "Interest added";
}

?>

<h1>Interests</h1>

<?php if (isset($_SESSION['a-unique-catbb-thingyyy'])):  //if signed in ?>

    <?php $my_id = $_SESSION['user_id']; //LIST OF your HOBBIES 

                $sql = $conn->prepare("SELECT `hobby_id`, `user_id` FROM `mesr_interests` WHERE user_id = ?");
                $sql->bind_param("i", $my_id); 
                $sql->execute();
               
                $result = $sql->get_result();
                 ?>
                <?php if ($result != false && $result->num_rows>0): ?>

                    <h2>My Interests:</h2>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <?php extract($row); //LInk to send msg to them ... wen theres seceral it breaks ?>
                            <div class="home-msg"> 
                                <?php include "hobby_switch.php"; ?>
                                <p><?php if(isset($hobby_switch))echo $hobby_switch; ?> </p>
                            </div>
                        <?php endwhile ?>

                <?php else: ?>
                            <?php echo "you currently have no interests"; ?>
                <?php endif; ?>

    <div class="homeflex">
        <?php //what happens if this is empty? used to take up all ?>
    </div>
    <div class="flex">
            <ul class="interests-list">
                <li>
                    <h2>General</h2>
                </li>
                <li><a href="interests.php?interest=1">Music</a></li>
                <li><a href="interests.php?interest=2">Gaming</a></li>
                <li><a href="interests.php?interest=3">Art</a></li>
                <li><a href="interests.php?interest=4">Crafting</a></li>
                <li><a href="interests.php?interest=5">Fitness</a></li>
                <li><a href="interests.php?interest=6">Making Friends</a></li>
                <li><a href="interests.php?interest=7">Dating</a></li>
                <li><a href="interests.php?interest=8">Tech</a></li>
                <li><a href="interests.php?interest=9">General</a></li>
                <li><a href="interests.php?interest=10">News</a></li>
            </ul>
            <ul class="interests-list">
            <li>
                    <h2>Indoors</h2>
                </li>
                <li><a href="interests.php?interest=11">TV</a></li>
                <li><a href="interests.php?interest=12">Movies</a></li>
                <li><a href="interests.php?interest=13">Reading</a></li>
                <li><a href="interests.php?interest=14">Anime</a></li>
                <li><a href="interests.php?interest=15">Collecting</a></li>
                <li><a href="interests.php?interest=16">Models/Toys</a></li>
            </ul>
            <ul class="interests-list">
            <li>
                    <h2>Active</h2>
                </li>
                <li><a href="interests.php?interest=17">Football</a></li>
                <li><a href="interests.php?interest=18">Working Out</a></li>
                <li><a href="interests.php?interest=19">Cycling/Walking</a></li>
                <li><a href="interests.php?interest=20">Hockey</a></li>
                <li><a href="interests.php?interest=21">Other Sports</a></li>
                <li><a href="interests.php?interest=22">Traveling</a></li>
                <li><a href="interests.php?interest=23">Yoga</a></li>
            </ul>
            <ul class="interests-list">
            <li>
                    <h2>Academic</h2>
                </li>
                <li><a href="interests.php?interest=24">Philosophy</a></li>
                <li><a href="interests.php?interest=25">Science</a></li>
                <li><a href="interests.php?interest=26">Religion</a></li>
                <li><a href="interests.php?interest=27">Politics</a></li>
                <li><a href="interests.php?interest=28">Education</a></li>
                <li><a href="interests.php?interest=29">Languages</a></li>
                <li><a href="interests.php?interest=30">History</a></li>
            </ul>
            </div>

        <?php if (isset($interest)): ?>

                <?php $my_id = $_SESSION['user_id']; //LIST OF HOBBIES PEOPLE ACTUALLY DO
                $show_msg_sql = $conn->prepare("SELECT `user_name`, `hobby_id`, `user_id` FROM `mesr_interests` WHERE hobby_id = ?");
                $show_msg_sql->bind_param("i", $interest); 
                $show_msg_sql->execute();

                $show_msg_result = $show_msg_sql->get_result();

                if ($show_msg_result != false && $show_msg_result->num_rows>0): ?>

                <h2>People with this interest:</h2>
                    <?php while ($row = mysqli_fetch_assoc($show_msg_result)): ?>
                        <?php extract($row); //LInk to send msg to them?>
                        <div class="home-msg"> 
                            <?php include "hobby_switch.php"; ?>
                            <a href="<?php echo "friends.php?add=$user_name&msgf=$hobby_switch";?>"><?php echo $user_name; ?></a>
                        </div>
                    <?php endwhile ?>
                    <?php else: ?>
                        <?php echo "no one with that interest available"; ?>
                <?php endif; ?>
        <?php endif; ?>


    

        <?php // ADD INTERESTS
        if (isset($interesta)){
                    $hobby_id = $interesta;
                    $my_name = $_SESSION['user_name'];
                    $type = "";
                    if($hobby_id < 11){
                        $type = "General";
                    }
                    else if($hobby_id < 17){
                        $type = "Indoors";
                    }
                    else if ($hobby_id < 24){
                        $type = "Active";
                    }
                    else if ($hobby_id < 31){
                        $type = "Academic";
                    }
                    $my_id = $_SESSION['user_id']; 
                    $sql = $conn->prepare("INSERT INTO `mesr_interests`(`user_name`, `hobby_id`, `type`, `user_id`) 
                                                        VALUES (?, ?, ?, ?)");
                    $sql->bind_param("sisi", $my_name, $hobby_id, $type, $my_id);
                    $sql->execute();
                    $result = $sql->get_result();
        }
        ?>

    <h2>Add Interests to your Profile</h2>
    <div class="flex">
            <ul class="interests-list">
                <li>
                    <h2>Add General</h2>
                </li>
                <li><a href="interests.php?interesta=1">Music</a></li>
                <li><a href="interests.php?interesta=2">Gaming</a></li>
                <li><a href="interests.php?interesta=3">Art</a></li>
                <li><a href="interests.php?interesta=4">Crafting</a></li>
                <li><a href="interests.php?interesta=5">Fitness</a></li>
                <li><a href="interests.php?interesta=6">Making Friends</a></li>
                <li><a href="interests.php?interesta=7">Dating</a></li>
                <li><a href="interests.php?interesta=8">Tech</a></li>
                <li><a href="interests.php?interesta=9">General</a></li>
                <li><a href="interests.php?interesta=10">News</a></li>
            </ul>
            <ul class="interests-list">
            <li>
                    <h2>Add Indoors</h2>
                </li>
                <li><a href="interests.php?interesta=11">TV</a></li>
                <li><a href="interests.php?interesta=12">Movies</a></li>
                <li><a href="interests.php?interesta=13">Reading</a></li>
                <li><a href="interests.php?interesta=14">Anime</a></li>
                <li><a href="interests.php?interesta=15">Collecting</a></li>
                <li><a href="interests.php?interesta=16">Models/Toys</a></li>
            </ul>
            <ul class="interests-list">
            <li>
                    <h2>Add Active</h2>
                </li>
                <li><a href="interests.php?interesta=17">Football</a></li>
                <li><a href="interests.php?interesta=18">Working Out</a></li>
                <li><a href="interests.php?interesta=19">Cycling/Walking</a></li>
                <li><a href="interests.php?interesta=20">Hockey</a></li>
                <li><a href="interests.php?interesta=21">Other Sports</a></li>
                <li><a href="interests.php?interesta=22">Traveling</a></li>
                <li><a href="interests.php?interesta=23">Yoga</a></li>
            </ul>
            <ul class="interests-list">
            <li>
                    <h2>Add Academic</h2>
                </li>
                <li><a href="interests.php?interesta=24">Philosophy</a></li>
                <li><a href="interests.php?interesta=25">Science</a></li>
                <li><a href="interests.php?interesta=26">Religion</a></li>
                <li><a href="interests.php?interesta=27">Politics</a></li>
                <li><a href="interests.php?interesta=28">Education</a></li>
                <li><a href="interests.php?interesta=29">Languages</a></li>
                <li><a href="interests.php?interesta=30">History</a></li>
            </ul>
            </div>
        


<?php endif ?>

</main>
<?php include_once "inc/footer.php"; ?>
</div>
</body>

