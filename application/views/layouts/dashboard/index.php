<!DOCTYPE html>
<html>
<head>
    <title><?php echo $template['title']; ?></title>
    <base href="<?php echo base_url(); ?>" />
    <?php echo $template['partials']['styles']; ?>
</head>
<body>
    <?php $this->load->view('pages/switch'); ?>
    <div id="page">
        <div class="container">
            <div class="row">
                <header id="header" class="col-md-12"><img src="<?php echo base_url(); ?>img/cora-logo.png" alt="logo" /><h2>CORA Content Management System</h2></header>
            </div>
            <div class="row">
                <div class="col-md-2"><div id="sidebar"><?php echo $template['partials']['sidebar']; ?></div></div>
                <div class="col-md-10">
                    <div id="content"><?php echo $template['body']; ?></div>
                    <footer id="footer" class="col-md-12 center">
                    CORA &#0169; Takari&#0153; 2014 - All rights reserved<br />
                    Designed and Coded by Takari&#0153;
                    </footer>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/tcp.js"></script>
    <script type="text/javascript" src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
    (function($){
        $(window).load(function(){
            $(".custom-scroll").mCustomScrollbar({theme:"dark",autoHideScrollbar:"TRUE"});
        });
    })(jQuery);
    </script>
</body>
</html>