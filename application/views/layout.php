<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo('9GAGVN - ' . $title); ?></title>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="author" content="9GAGVN, 9gagvn.net@gmail.com"/>
    <link rel="shortcut icon" type="image/ico" href="<?php echo base_url(); ?>/assets/img/logo-9vn.ico"/>

    <!--CSS-->
    <?php echo link_tag("assets/plugins/bootstrap-3.3.5/css/bootstrap.css"); ?>
    <?php echo link_tag("assets/plugins/bootstrap-3.3.5/css/bootstrap-theme.css"); ?>
    <?php echo link_tag("assets/css/style.css"); ?>

    <!--Jquery-->
    <?php echo script_tag("assets/js/jquery-1.11.3.js"); ?>
</head>

<body>

<?php require_once(APPPATH . "views/master/header.php"); ?>
<center>
    <br/><br/><br/><br/>
    <div class="container">
        <div class="col-md-8">
            <?php
            $this->load->view($content, $data = null);
            ?>
        </div>
        <div class="col-md-4">
            <?php require_once(APPPATH . "views/master/right-panel.php"); ?>
        </div>
    </div>
</center>

<!--JS-->
<footer>
    <a href="javascript: void(0);" class="back-to-top">Back to top</a>
    <div id="fb-root"></div>

    <?php echo script_tag("assets/plugins/bootstrap-3.3.5/js/bootstrap.js"); ?>
    <?php echo script_tag("assets/js/jquery-validation-1.1/jquery.validate.js"); ?>
    <?php echo script_tag("assets/js/jquery-validation-1.1/additional-methods.js"); ?>
    <?php echo script_tag("assets/js/jquery.base64.js"); ?>
    <?php echo script_tag("assets/js/general.js"); ?>
    <script src="http://connect.facebook.net/vi_VN/all.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            $.ajaxSetup({ cache: true });
            $.getScript('//connect.facebook.net/vi_VN/sdk.js', function(){
                FB.init({
                    appId: '<?php echo FB_APP_ID; ?>',
                    version: '<?php echo FB_VERSION; ?>'
                });
            });

            //Check to see if the window is top if not then display button
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('.back-to-top').fadeIn();
                } else {
                    $('.back-to-top').fadeOut();
                }
            });

            //Click event to scroll to top
            $('.back-to-top').click(function () {
                $('html, body').animate({scrollTop: 0}, 800);
                return false;
            });

        });

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.4&appId=<?php echo FB_APP_ID; ?>";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

    </script>

</footer>

</body>
</html>