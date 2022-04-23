<?php
session_start();
include "inc/connect.php"; 
include "inc/header.php";
if (!isset($_SESSION['a-unique-cat-thingyyy'])){
    header('location: inc/admin-login.php');
}
if (isset($_SESSION['a-unique-cat-thingyyy'])):  

    if(isset($_GET['art_id'])) {
        $art_id = $_GET['art_id'];
                $art_sql = "SELECT * FROM `art_catalog` 
                WHERE art_id = $art_id";

                $result = $conn->query($art_sql); 

                if ($result->num_rows == 1){
                    while ($list_row = $result->fetch_assoc()) {
                    extract($list_row); 
                    }
                }


                if (isset($_GET['delete_art'])){
                    if ($_GET['delete_art'] == 'y'){
                        $delete_sql = "DELETE FROM `art_catalog` WHERE art_id = $art_id";
                        $result = $conn->query($delete_sql); 
                        if ($result == false) {
                            echo "Not deleted";
                        }
                        else {
                            echo "deleted";
                        }
                    }
                }
    }
    ?>
    <?php include "insert-valid-submit.php"; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
    
    <?php if(isset($validation)){echo $validation;}?>
    <h1>Add an Art Listing</h1>
    <label for="artname">Art Title</label>
    <input type="text" required id="artname" name="artname" value="<?php if(isset($artname)){ echo htmlspecialchars($artname);} ?>">
    
    <label for="description">Description</label>
    <textarea id="ad" required name="description"><?php if(isset($description)){echo htmlspecialchars($description);} ?></textarea>
    
    <label for="art_type">Art Type (e.g painting)</label>
    <input type="text" required id="art_type" name="art_type" value="<?php if(isset($art_type)){ echo htmlspecialchars($art_type);} ?>">

    
    <label for="medium">Mediums Used (e.g acrylic)</label>
    <input type="text" required id="medium" name="medium" value="<?php if(isset($medium)){ echo htmlspecialchars($medium);} ?>">


    <label for="orientation_lps">Orientation</label>
    <select type="text" name="orientation_lps" id="orientation_lps">
            <option <?php if(isset($orientation_lps)){if($orientation_lps == "L"){echo 'selected = "selected"';}} ?> value="L">Landscape</option>
            <option <?php if(isset($orientation_lps)){if($orientation_lps == "P"){echo 'selected = "selected"';}} ?> value="P">Portrait</option>
            <option <?php if(isset($orientation_lps)){if($orientation_lps == "Y"){echo 'selected = "selected"';}} ?> value="S">Square</option>
    </select>


    <label for="style">Art Style</label>
    <input type="text" required id="style" name="style" value="<?php if(isset($style)){ echo htmlspecialchars($style);} ?>">

    <label for="impasto">Amount of Impasto (thickness)</label>
    <input type="text" required id="impasto" name="impasto" value="<?php if(isset($impasto)){ echo htmlspecialchars($impasto);} ?>">

    <fieldset>
        <label for="bw_yn">Black and White</label>
        <input type="radio" name="bw_yn" id="Y" value="Y" <?php if(isset($bw_yn) && $bw_yn == "Y"){echo " checked ";} ?>>
        <label for="bw_yn">Color</label>
        <input type="radio" name="bw_yn" id="N" value="N" <?php if(isset($bw_yn) && $bw_yn == "N"){echo " checked ";} ?>>
    </fieldset>

    <fieldset>
        <label for="digital_yn">Digital</label>
        <input type="radio" name="digital_yn" id="Y" value="Y" <?php if(isset($digital_yn)){if($digital_yn == "Y"){echo " checked ";}} ?>>
        <label for="">Traditional</label>
        <input type="radio" name="digital_yn" id="N" value="N" <?php if(isset($digital_yn)){if($digital_yn == "N"){echo " checked ";}} ?>>
    </fieldset>

    <fieldset>
        <label for="sold_yn">Unsold</label>
        <input type="radio" name="sold_yn" id="Y" value="Y" <?php if(isset($sold_yn)){if($sold_yn == "Y"){echo " checked ";}} ?>>
        <label for="">Sold</label>
        <input type="radio" name="sold_yn" id="N" value="N" <?php if(isset($sold_yn)){if($sold_yn == "N"){echo " checked ";}} ?>>
    </fieldset>
        
    <label for="price">Price</label>
    <span class="absolutedollar">$</span>
    <input type="text" class="beforedollar" id="price" name="price" value="<?php if(isset($price)){ echo htmlspecialchars($price);} ?>">

    <fieldset>
        <h3>Main Colors</h3>
        <label for="red">red</label>
        <input type="checkbox" name="red" id="red" value="yes">
        <label for="orange">orange</label>
        <input type="checkbox" name="orange" id="orange" value="yes">
        <label for="yellow">yellow</label>
        <input type="checkbox" name="yellow" id="yellow" value="yes">
        <label for="green">green</label>
        <input type="checkbox" name="green" id="green" value="yes">
        <label for="blue">blue</label>
        <input type="checkbox" name="blue" id="blue" value="yes">
        <label for="violet">violet</label>
        <input type="checkbox" name="violet" id="violet" value="yes">
        <label for="black">black</label>
        <input type="checkbox" name="black" id="black" value="yes">
        <label for="white">white</label>
        <input type="checkbox" name="white" id="white" value="yes">
    </fieldset>
    <?php if(!isset($_GET['art_id'])): ?>
        <label for="file_to_upload">Upload image:</label>
        <input type="file" name="file_to_upload" id="file_to_upload">
    <?php else: ?>
        <label for="file_to_upload"></label>
        <input class="displaynone" type="file" name="file_to_upload" id="file_to_upload">
    <?php endif ?>
    <input type="submit" value="<?php if(isset($_GET['art_id'])){echo "Update Listing";}else{echo "Add Listing";} ?>" name="insert-submit" class="add-listing">
    </form> 

    <div class="edit-art">
    <h2><br>Edit</h2>
        <div class="art">
            <?php $list_sql = "SELECT artname, art_id, img_file FROM art_catalog";
            $list_result = $conn->query($list_sql); ?>

                <?php if ($list_result->num_rows > 0): ?>
                    <?php while ($list_row = $list_result->fetch_assoc()): ?>
                    <?php extract($list_row); ?>
                        <div class="smallartcard">
                            <img src="<?php echo BASE_URL . "thumbnails/" . htmlspecialchars($img_file); ?>" alt="art thumbnail">
                            <a class="block" href="insert-form.php?art_id=<?php echo $art_id; ?>">EDIT <?php echo htmlspecialchars($artname); ?></a>
                            <a class="block" href="insert-form.php?art_id=<?php echo $art_id; ?>&delete_art=y">DELETE</a>
                        </div>
                    <?php endwhile ?>
                <?php else: ?>
                    <p>Sorry there is no art to display.</p>
                <?php endif ?>
        </div>
    </div>

<?php endif ?>