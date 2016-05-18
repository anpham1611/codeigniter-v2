<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>"><img alt="Vui Xem Ảnh * Đua Dịch Bài * Luyện Anh Văn" src="<?php echo base_url(); ?>/assets/img/logo-9vn.png" class="badge-img-logo"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="<?php echo base_url(); ?>">Bài mới</a></li>
                <li><a href="<?php echo (base_url() . 'hot'); ?>">Bài được quan tâm</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php
                if (!$this->session->userdata(SESSION_USER_ID)) {
                    echo '<li>' . $this->lfb->login_fb() . '</li>';

                } else {
                ?>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle cls-avatar" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <img class="img-circle" src="<?php echo $this->session->userdata(SESSION_USER_AVATAR); ?>" alt="<?php echo $this->session->userdata(SESSION_USER_NAME); ?>"> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)">Xin chào <span class="txt-bold like-post-color"><?php echo $this->session->userdata(SESSION_USER_NAME); ?></span></a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo (base_url() . 'logout'); ?>">Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php
                }
                ?>
            </ul>
            <form id="frm-search" action="#" class="navbar-form navbar-right" role="search">
                <div class="form-group">
                    <input type="text" id="searchTextField" required="required" class="form-control box-search" placeholder="Nhập từ khoá">
                </div>
                <button type="button" id="btn-submit-search" class="btn btn-danger" onclick="return false;">Tìm kiếm</button>
            </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<!-- BEGIN JAVASCRIPT-->
<script type="text/javascript">
    $(document).ready(function () {
        $("#frm-search").validate({
            rules: {
            },
            messages: {
            },
            onfocusout: false,
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    validator.errorList[0].element.focus();
                }
            }
        });

        $('#btn-submit-search').click(function(){

            if ($("#frm-search").valid()) {

                // Search
                window.document.location.href = '<?php echo base_url(); ?>search/' + $.base64.encode($.base64.encode($.base64.encode($.trim($("#searchTextField").val()))));
            }
        });

        $('#searchTextField').keypress(function(event){
            if( (event.keyCode == 13) ) {
                if ($("#frm-search").valid()) {
                    window.document.location.href = '<?php echo base_url(); ?>search/' + $.base64.encode($.base64.encode($.base64.encode($.trim($("#searchTextField").val()))));
                }
                event.preventDefault();
                return false;
            }
        });
    });
</script>
<!-- BEGIN JAVASCRIPT -->