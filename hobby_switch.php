<?php

$hobby_switch = "";
if (isset($interest)){
    echo "interest";
    $hobby_switch = switche($interest);
}
else if (isset($hobby_id)){
    echo "hobby_id";
    $hobby_switch = switche($hobby_id);
}

function switche($input){

    
    switch ($input) {
        case 1:
            $hobby_switch = "Music";
            break;
        case 2:
            $hobby_switch = "Gaming";
            break;
        case 3:
            $hobby_switch = "Art";
            break;
        case 4:
            $hobby_switch = "Crafting";
            break;
        case 5:
            $hobby_switch = "Fitness";
            break;
        case 6:
            $hobby_switch = "Making Friends";
            break;
        case 7:
            $hobby_switch = "Dating";
            break;
        case 8:
            $hobby_switch = "Tech";
            break;
        case 9:
            $hobby_switch = "General";
            break;
        case 10:
            $hobby_switch = "News";
            break;
        case 11:
            $hobby_switch = "TV";
            break;
        case 12:
            $hobby_switch = "Movies";
            break;
        case 13:
            $hobby_switch = "Reading";
            break;
        case 14:
            $hobby_switch = "Anime";
            break;
        case 15:
            $hobby_switch = "Collecting";
            break;
        case 16:
            $hobby_switch = "Models/Toys";
            break;
        case 17:
            $hobby_switch = "Football";
            break;
        case 18:
            $hobby_switch = "Working Out";
            break;
        case 19:
            $hobby_switch = "Cycling/Walking";
            break;
        case 20:
            $hobby_switch = "Hockey";
            break;
        case 21:
            $hobby_switch = "Other Sports";
            break;
        case 22:
            $hobby_switch = "Traveling";
            break;
        case 23:
            $hobby_switch = "Yoga";
            break;
        case 24:
            $hobby_switch = "Philosophy";
            break;
        case 25:
            $hobby_switch = "Science";
            break;
        case 26:
            $hobby_switch = "Religion";
            break;
        case 27:
            $hobby_switch = "Politics";
            break;
        case 28:
            $hobby_switch = "Education";
            break;
        case 29:
            $hobby_switch = "Languages";
            break;
        case 30:
            $hobby_switch = "History";
            break;
        default:
            $hobby_switch = "hobby";
            break;
    }
    echo $hobby_switch;
    return $hobby_switch;
}

?>