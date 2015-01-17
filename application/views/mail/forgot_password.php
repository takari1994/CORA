<?php

// LEGEND --------------------------------------
// =============================================
// | $data[0] = User Password                    
// | $data[1] = Server Name                
// | $data[2] = Website Base URL   
// =============================================
// ---------------------------------------------

$msg = <<<MSG
<p><strong>Greetings!</strong></p>
<p>
You received this email because you requested for your password to be recovered.<br />
Below is the information you requested:
</p>
<p>Your password: <strong>{$data[0]}</strong></p>
<p>
If you did not request for this action please ignore this message.<br />
It is advised that you change your account details to protect yourself from hackers.
</p>
<p>Sincerely Yours,<br />{$data[1]} Administration</p>
<hr />
<p style="margin-bottom: 0; color: #a4a4a4;">Copyright &#0169; 2014 {$data[1]} - All Rights Reserved. Visit our website for more information: <a href="{$data[2]}" style="text-decoration: none;">{$data[2]}</a></p>
MSG;

?>