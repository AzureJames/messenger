<?php
        $message = "";
        if(isset($m)) {
            switch($m) {
                case 'login':
                    $message = "<p>Logged in</p>";
                    break;
                case 'logout':
                    $message = "<p>Logged out</p>";
                    break;
                case 'loggedout':
                    $message = "<p>Logged out due to inactivity</p>";
                    break;
                case 'notloggedin':
                    $message = "<p>Sorry, this feature is not available now.</p>";
                    break;
                case 'illegalaction':
                    $message = "<p>Sorry, this feature is not available now.</p>";
                    break;       
            }
        }


?>