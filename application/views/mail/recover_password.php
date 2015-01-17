<?php

// LEGEND --------------------------------------
// =============================================
// | $data[0] = Account ID
// | $data[1] = Password Recovery Code                    
// | $data[2] = Server Name                
// | $data[3] = Website Base URL   
// =============================================
// ---------------------------------------------

$msg = <<<MSG
<p><strong>Greetings!</strong></p>
<p>
You received this email because you requested for your password to be recovered.<br />
To reset your password please click the following link:
</p>
<p><a href="{$data[3]}account/password_recovery?id={$data[0]}&code={$data[1]}">{$data[3]}account/password_recovery?id={$data[0]}&code={$data[1]}</a></p>
<p>If the link doesn't work, copy and paste the link in the address bar.</p>
<p>
If you did not request for this action please ignore this message.<br />
It is advised that you change your account details to protect yourself from hackers.
</p>
<p>Sincerely Yours,<br />{$data[2]} Administration</p>
<hr />
<p style="margin-bottom: 0; color: #a4a4a4;">Copyright &#0169; 2014 {$data[2]} - All Rights Reserved. Visit our website for more information: <a href="{$data[3]}" style="text-decoration: none;">{$data[3]}</a></p>
MSG;

?>