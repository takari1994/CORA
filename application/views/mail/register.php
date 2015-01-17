<?php

// LEGEND --------------------------------------
// =============================================
// | $data[0] = Server Name                     
// | $data[1] = Website Base URL                
// | $data[2] = Registration ID [IMPORTANT!!!]   
// | $data[3] = Registration Code [IMPORTANT!!!]
// =============================================
// ---------------------------------------------

$msg = <<<MSG
<p><strong>Greetings {$data[4]}!</strong></p>
<p>
Thank you for signing up on {$data[0]}.<br />
Please verify your account by clicking the link below:<br />
<a href="{$data[1]}account/verify?id={$data[2]}&code={$data[3]}" style="text-decoration: none;">{$data[1]}account/verify?id={$data[2]}&code={$data[3]}</a><br />
</p>
<p>
If the link above does not work, please visit: <a href="{$data[1]}account/verify" style="text-decoration: none;">{$data[1]}account/verify</a> ang manually enter the following:<br />
ID: {$data[2]}<br />
Code: {$data[3]}<br />
</p>
<p>If you did not sign up with us then please ignore this email.<br /><br /></p>
<p>Sincerely Yours,<br />{$data[0]} Administration</p>
<hr />
<p style="margin-bottom: 0; color: #a4a4a4;">Copyright &#0169; 2014 {$data[0]} - All Rights Reserved. Visit our website for more information: <a href="{$data[1]}" style="text-decoration: none;">{$data[1]}</a></p>
MSG;

?>