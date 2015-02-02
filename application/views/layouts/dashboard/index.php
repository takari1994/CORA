<!DOCTYPE html>
<html>
<head>
    <title><?php echo $template['title']; ?></title>
    <base href="<?php echo base_url(); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo $template['partials']['styles']; ?>
</head>
<body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <?php $this->load->view('pages/switch'); ?>
    <div id="page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" id="modules-mobile">
                    <?php echo $template['partials']['modules_mobile']; ?>
                </div>
                <div class="col-md-2" id="modules" data-spy="affix" data-offset-top="40"><div id="sidebar"><?php echo $template['partials']['sidebar']; ?></div></div>
                <div class="col-md-10 col-md-offset-2">
                    <div id="content"><?php echo $template['body']; ?></div>
                    <footer id="footer" class="col-md-12 center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <a href="http://cora.takaworks.net/" target="_blank">
                                        <img src="img/cora-logo.png" style="margin-right: 5px; height: 30px;" alt="cora-logo" />
                                    </a>
                                    <div class="fb-like" data-href="https://www.facebook.com/takaworks" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
                                    <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=52NAECFHCE7BE" class="bbc_url" title="External link" rel="external" target="_blank">
                                        <img class="bbc_img" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" style="margin-left: 5px;" alt="donate-btn">
                                    </a>
                                    <p style="margin-top: 10px;">
                                        CORA&#0153; Content Management System &#0169; 2015 created by <a href="http://takaworks.net/" target="_blank">Takaworks</a>. All rights Reserved.<br />
                                        You are using cora version 0.9.4.2. Page loaded in <?php echo $this->benchmark->elapsed_time();?> seconds. Total memory consumption <?php echo $this->benchmark->memory_usage();?>.
                                    </p>
                                </div>
                            </div>
                        </div>
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