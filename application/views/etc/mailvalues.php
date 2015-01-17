<?php

switch($attr) {
    case 'reg_subject':
        $value = 'Account Registration';
        break;
    case 'reg_msg':
        require(APP_PATH."/views/mail/register.php");
        $value = $msg;
        break;
    case 'forgot_subject':
        $value = 'Your Password';
        break;
    case 'forgot_msg':
        require(APP_PATH."/views/mail/forgot_password.php");
        $value = $msg;
        break;
    case 'recovery_subject':
        $value = 'Password Recovery';
        break;
    case 'recovery_msg':
        require(APP_PATH."/views/mail/recover_password.php");
        $value = $msg;
}

?>