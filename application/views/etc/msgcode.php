<?php

switch($code) {
    case 101:
        $msg = '<strong>Success!</strong> Your post/page has been saved.'; break;
    case 102:
        $msg = '<strong>Success!</strong> Your post/page has been deleted.'; break;
    case 103:
        $msg = '<strong>Success!</strong> Your navigation has been deleted.'; break;
    case 104:
        $msg = '<strong>Success!</strong> Your settings has been saved.'; break;
    case 105:
        $msg = '<strong>Success!</strong> Please check your email for verification.'; break;
    case 106:
        $msg = '<strong>Congratulations!</strong> You may now login.'; break;
    case 107:
        $msg = '<strong>Congratulations!</strong> Profile has been updated successfully.'; break;
    case 108:
        $msg = '<strong>Congratulations!</strong> Password has been updated successfully.'; break;
    case 109:
        $msg = '<strong>Congratulations!</strong> Character position was reset successfully.'; break;
    case 110:
        $msg = '<strong>Success!</strong> Users banned without an error.'; break;
    case 111:
        $msg = '<strong>Success!</strong> Users unbanned without an error.'; break;
    case 112:
        $msg = '<strong>Success!</strong> Users deleted without an error.'; break;
    case 113:
        $msg = '<strong>Success!</strong> New Vote 4 Points link has been added.'; break;
    case 114:
        $msg = '<strong>Success!</strong> Vote 4 Points link has been updated.'; break;
    case 115:
        $msg = '<strong>Success!</strong> Item has been added to the cash shop.'; break;
    case 116:
        $msg = '<strong>Success!</strong> Item has been removed from your cart.'; break;
    case 117:
        $msg = '<strong>Success!</strong> Item has been removed cash shop.'; break;
    case 118:
        $msg = '<strong>Success!</strong> The cash shop item has been updated.'; break;
    case 119:
        $msg = '<strong>Success!</strong> IP has been added to IP ban list.'; break;
    case 201:
        $msg = '
        <strong>Completed.</strong> Action performed but might have not done so perfectly. One of the cause may be:
        <ul>
        <li>You do not have authority to perform the action at all.</li>
        <li>You do not have <strong>enough</strong> authority to perform the action on some objects.</li>
        <li>Some objects you wish to delete is premade and cannot be deleted.</li>
        <li>Some object you wish to delete is in use.</li>
        </ul>
        '; break;
    case 401:
        $msg = '<strong>Error!</strong> There seems to be some missing or invalid data.'; break;
    case 402:
        $msg = '<strong>Oops!</strong> Something went wrong, please try again later.'; break;
    case 403:
        $msg = '<strong>Error!</strong> The object you wish to delete is in use.'; break;
    case 404:
        $msg = '<strong>Error!</strong> Incorrect username or password.'; break;
    case 405:
        $msg = '<strong>Error!</strong> You must agree to the terms of service and conditions.'; break;
    case 406:
        $query = mysql_query("SELECT `un_format_error` FROM `tcp_set_acc`"); $read = mysql_fetch_assoc($query);
        $specmsg = $read['un_format_error'];
        $msg = '<strong>Error!</strong> '.$specmsg; break;
    case 407:
        $msg = '<strong>Error!</strong> Username is already taken.'; break;
    case 408:
        $query = mysql_query("SELECT `pw_format_error` FROM `tcp_set_acc`"); $read = mysql_fetch_assoc($query);
        $specmsg = $read['pw_format_error'];
        $msg = '<strong>Error!</strong> '.$specmsg; break;
    case 409:
        $msg = '<strong>Error!</strong> Password does not match.'; break;
    case 410:
        $msg = '<strong>Error!</strong> Email is already in use.'; break;
    case 411:
        $query = mysql_query("SELECT `min_age` FROM `tcp_set_acc`"); $read = mysql_fetch_assoc($query);
        $specmsg = $read['min_age'];
        $msg = '<strong>Error!</strong> You must be atleast '.$specmsg.' years old to register. '; break;
    case 412:
        $msg = '<strong>Error!</strong> The captcha was answered incorrectly.'; break;
    case 413:
        $msg = '<strong>Error!</strong> There was a problem uploading the file.'; break;
    case 414:
        $msg = '<strong>Error!</strong> You are not allowed to change email.'; break;
    case 415:
        $msg = '<strong>Error!</strong> You are not allowed to change gender.'; break;
    case 416:
        $msg = '<strong>Error!</strong> You are not allowed to change birthday.'; break;
    case 417:
        $msg = '<strong>Error!</strong> Incorrect password.'; break;
    case 418:
        $msg = '<strong>Error!</strong> ReCaptcha keys are missing.'; break;
    case 419:
        $msg = '<strong>Error!</strong> Character position reset is disabled.'; break;
    case 420:
        $msg = '<strong>Error!</strong> You cannot reset position from the current map.'; break;
    case 421:
        $msg = '<strong>Error!</strong> You do not have enough authority to perform the action.'; break;
    case 422:
        $msg = '<strong>Error!</strong> Current time is already past set ban time.'; break;
    case 423:
        $msg = '<strong>Error!</strong> You have already voted using this link. Please wait for the next vote time.'; break;
    case 424:
        $msg = '<strong>Error!</strong> Price(s) is/are not valid.'; break;
    case 425:
        $msg = '<strong>Error!</strong> Item ID not found or is invalid.'; break;
    case 426:
        $msg = '<strong>Error!</strong> Item is already in cash shop.'; break;
    case 427:
        $msg = '<strong>Error!</strong> Recipient/Sender is not a valid character name.'; break;
    case 428:
        $msg = '<strong>Error!</strong> You do not have enough credits/points.'; break;
    case 429:
        $msg = '<strong>Error!</strong> IP is already in ban list.'; break;
    case 430:
        $msg = '<strong>Error!</strong> You are not allowed to change username.';
}
    
?>