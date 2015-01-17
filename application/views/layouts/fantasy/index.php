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
                <header id="header" class="col-md-12"><img src="<?php echo base_url(); ?>img/logo.png" alt="logo" /><h2><?php echo $serv_name; ?></h2></header>
            </div>
            <div class="row">
                <div class="col-md-12"><?php echo $template['partials']['navigation']; ?></div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div id="sidebar"><?php echo $template['partials']['sidebar-left']; ?></div>
                </div>
                <div class="col-md-6">
                    <div id="content"><?php echo $template['body']; ?></div>
                </div>
                <div class="col-md-3">
                    <div id="sidebar"><?php echo $template['partials']['sidebar-right']; ?></div>
                </div>
            </div>
        </div>
        <div id="footer-container">
            <div class="container">
                <div class="row"><?php echo $template['partials']['footer']; ?></div>
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