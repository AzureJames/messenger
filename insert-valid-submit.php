<?php
    include 'inc/connect.php';
    $validation = "";
    
    function resize_image($file, $folder, $file_type, $new_width)
    {
        //it isn't allowed to grow img

        list($width, $height) = getimagesize($file);
        if ($new_width > $width){ $new_width = $width;}
        $img_ratio = $width/$height;
        $new_height = $new_width/$img_ratio;


        $new_file = imagecreatetruecolor($new_width, $new_height);
        if ($file_type == "image/jpeg" || $file_type == "image/pjpeg") {
            $source = imagecreatefromjpeg($file);
        }
        else if ($file_type == "image/png"){
            $source = imagecreatefrompng($file);
        }
        else if ($file_type == "image/webp"){
            $source = imagecreatefromwebp($file);
        }

        imagecopyresampled($new_file, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        $new_fileName = $folder . basename($file);
        imagejpeg($new_file, $new_fileName, 80);
        
        
        imagedestroy($new_file);	
        imagedestroy($source);
    }





    if(isset($_POST['insert-submit'])) {
        $red = $orange = $yellow = $green = $blue = $violet = $black = $white = '';
        extract($_POST);
        $form_good = true;

        //validate
        function validChar($conn, $input, $field)
        {
            global $form_good;
            global $validation;
            $input = trim($input);
            if (strlen($input) != 1){
                $form_good = false;
                $validation .= "$field field must be 1 character";
            }
            $input = mysqli_real_escape_string($conn, $input);
            return $input;
        }

        function validString($conn, $input, $field, $min_len, $max_len)
        {
            global $form_good;
            global $validation;
            $input = trim($input);
            if (strlen($input) > $max_len){
                $form_good = false;
                $validation .= "$field field too long";
            }
            elseif (strlen($input) < $min_len) {
                $validation .= "$field field too short";
                $form_good = false;
            }
            $input = mysqli_real_escape_string($conn, $input);
            return $input;
        }

        $sold_yn = validChar($conn, $sold_yn, "Sold");
        $orientation_lps = validChar($conn, $orientation_lps, "Orientation");
        $bw_yn = validChar($conn, $bw_yn, "Black and White");
        $digital_yn = validChar($conn, $digital_yn, "Digital");
        $artname = validString($conn, $artname, "Title", 2 , 50);
        $art_type = validString($conn, $art_type, "art type", 2 , 25);
        $medium = validString($conn, $medium, "medium", 2 , 25);
        $price = validString($conn, $price, "price", 1 , 25);
        $impasto = validString($conn, $impasto , "impasto", 2 , 25);
        $style = validString($conn, $style, "style", 2 , 50);
        $description = validString($conn, $description, "description", 15 , 400);
        //end of validate

        
        //img section
        if(isset($_FILES['file_to_upload'])){
            $file_name = md5(microtime().rand());
            $file_type  = $_FILES['file_to_upload']['type'];
            $tmp_name  = $_FILES['file_to_upload']['tmp_name'];
            $error  = $_FILES['file_to_upload']['error'];
            $size  = $_FILES['file_to_upload']['size'];

            $upload_good = true;

            if (strlen($file_name) > 55) {
                $upload_good = false;
                $validation .= "<p>Too long file name </p>";
            }

            // >1mb
            if ($size > 1000000) {
                $upload_good = false;
                $validation .= "<p>Too large file </p>";
            }
            if ($size == 0) {
                $upload_good = false;
                $validation .= "<p>No image </p>";
            }

            $allowed_file_types = array("image/jpeg", "image/pjpeg", "image/png", "image/webp");


            if (!in_array($file_type, $allowed_file_types)) {
                $upload_good = false;
                $validation .= "<p>Not an image file type </p>";
            }

            if ($error != 0) {
                $validation .= "<p>Sorry, there was a problem with the file. </p>";
            }



            if ($upload_good == true) {
                if (move_uploaded_file($tmp_name, "uploaded_files/$file_name")) {
        
        
                    resize_image("uploaded_files/$file_name", "thumbnails/", $file_type, 200 );
                    resize_image("uploaded_files/$file_name", "display/", $file_type, 900 );
                }
                else {
                    $validation .= "<p>Not successful image upload</p>";
                }
            }
            else {
                $validation .= "<p>File unsuitable</p>";
            }
            $file_name = validString($conn, $file_name, "img file", 3 , 50);
        }
        //end of images

        
        if ($form_good == true) {
            $user_id = $_SESSION['user_id'];
            if(isset($_GET['art_id'])) {
                extract($_GET);
                //update
                    $update_sql = "UPDATE `art_catalog` SET 
                    art_id='$art_id', sold_yn='$sold_yn', artname='$artname', description='$description', 
                    art_type='$art_type', medium='$medium', orientation_lps='$orientation_lps', price='$price', 
                    style='$style', bw_yn='$bw_yn', digital_yn='$digital_yn', impasto='$impasto'
                    
                    WHERE art_id = $art_id";
                

                if (mysqli_query($conn, $update_sql)) {
                    $validation = "<p>Your art was updated successfully.</p>";
                }
                else {
                    $validation = "<p>Your art was not updated successfully.</p>";
                }

                $sql = "UPDATE `art_colours` SET `red`='$red',`orange`='$orange',
                `yellow`='$yellow',`green`='$green',`blue`='$blue',`violet`='$violet', `black`='$black',
                `white`='$white' 
                WHERE art_id = $art_id";

                if (mysqli_query($conn, $sql)) {
                    $validation .= "<p>Your art colours were posted successfully.</p>";
                }
                else {
                    $validation .= "<p>Your art colours were not posted successfully.</p>";
                }
            }

            //insert new if no art id
            else {
                $insert_sql = "INSERT INTO art_catalog (sold_yn, artname, description, art_type, medium, 
                orientation_lps, price, style, bw_yn, digital_yn, impasto, img_file) 
                VALUES ('$sold_yn', '$artname', '$description', '$art_type', '$medium', '$orientation_lps', '$price', 
                '$style', '$bw_yn', '$digital_yn', '$impasto', '$file_name') ";

                if (mysqli_query($conn, $insert_sql)) {
                    $validation = "<p>Your art was posted successfully.</p>";
                }
                else {
                    $validation = "<p>Your art was not posted successfully.</p>";
                }
                $in_id =  mysqli_insert_id($conn);
                
                $sql = "INSERT INTO art_colours (`art_id`, `red`, `orange`, `yellow`, `green`, `blue`, `violet`, `black`, `white`) 
                VALUES ('$in_id', '$red', '$orange', '$yellow', '$green', '$blue', '$violet', '$black', '$white' ) ";

                if (mysqli_query($conn, $sql)) {
                    $validation .= "<p>Your art colours were posted successfully.</p>";
                }
                else {
                    $validation .= "<p>Your art colours were not posted successfully.</p>";
                }
                }
            }
        }


?>