<?php

$active = 'Register';
breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <h1 class="post-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
        <div class="spacer"></div>
        <p>Create an account with us by filling up the form below.</p>
        <?php
        
        if(isset($_GET['msgcode'])) {
            echo '<div class="spacer"></div>';
            echo parse_msgcode($_GET['msgcode']);
        }
        
        ?>
        <div class="spacer"></div>
        <script type="text/javascript">
         var RecaptchaOptions = {
            theme : 'white'
         };
        </script>
            <form action="account/create" method="post">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="username" placeholder="Username" required />
                    <input type="password" class="form-control" name="userpass" placeholder="Password" required />
                    <input type="password" class="form-control" name="con-userpass" placeholder="Confirm Password" required />
                    <input type="email" class="form-control" name="email" placeholder="E-mail Address" required />
                    <div class="spacer"></div>
                    <input type="text" class="form-control" name="fname" placeholder="First Name" required />
                    <input type="text" class="form-control" name="lname" placeholder="Last Name" required />
                    <input type="text" name="birthday" class="datepicker-input-normal form-control" placeholder="Birthday" data-date-format="yyyy-mm-dd" readonly required />
                    &nbsp;<strong>Gender:</strong>&nbsp;
                    <input type="radio" name="gender" value="m" checked /> Male&nbsp;&nbsp;
                    <input type="radio" name="gender" value="f" /> Female
                </div>
                <div class="col-md-8">
                    <?php
                    
                    if(0 != $set_acc[0]->req_capt_reg) {
                        $data['capt_pub_key'] = $set_gen[0]->capt_pub_key;
                        $this->load->view('assets/recaptcha.php',$data);
                    }
                    
                    ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="agreetos" value="1" /> I have read and agree to the
                            <a href="<?php echo (0 < $set_gen[0]->tospage?'page/view?id='.$set_gen[0]->tospage:'#')?>" target="_blank">Terms of Service and Conditions</a>.
                        </label>
                    </div>
                    <input type="submit" class="btn btn-primary" name="submit" value="Register" />
                    <input type="reset" class="btn btn-default" value="Cancel" />
                </div>
            </div>
            </form>
        <?php $this->load->view('assets/datepicker'); ?>
        </div>
    </div>
</div>