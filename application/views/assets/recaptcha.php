<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<?php echo $capt_pub_key; ?>">
</script>
<style type="text/css">
.recaptchatable #recaptcha_response_field { padding: 3px!important; border-radius: 3px; font-size: 8pt; }
</style>
<noscript>
   <iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php echo $capt_pub_key; ?>"
       height="300" width="500" frameborder="0"></iframe><br>
   <textarea name="recaptcha_challenge_field" rows="3" cols="40">
   </textarea>
   <input type="hidden" name="recaptcha_response_field"
       value="manual_challenge">
</noscript>