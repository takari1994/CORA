<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - CORA Content Management System</title>
    <base href="<?php echo base_url(); ?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-theme.css" />
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans' rel='stylesheet' type='text/css'>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url().'css/styles.css'; ?>" />
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.js"></script>
    <style type="text/css">
        body {background: #eee;}
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="admin_login">
                    <div id="header">
                        <img src="img/cora-logo.png" alt="logo" />
                        <h2>CORA Content Management System <small>ADMIN LOGIN</small></h2>
                    </div>
                    <form class="admin_login_form" action="admin/authenticate" method="POST">
                        <?php
                        
                        if(isset($_GET['msgcode'])) {
                            echo parse_msgcode($_GET['msgcode']);
                        }
                        
                        ?>
                        <input type="text" class="form-control" name="userid" placeholder="Username" />
                        <input type="password" class="form-control" name="userpw" placeholder="Password" />
                        <div class="right">
                            <input type="submit" class="btn btn-primary" name="submit" value="Login as Admin" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>