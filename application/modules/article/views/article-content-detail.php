<div class="panel panel-default">
    <div class="panel-body" id="panel-articles-body">

        <article data-id="<?php echo $article->id; ?>" class="content-article">
            <header>
                <h3 class="txt-align-left clr-margin-top">
                    <span class="title-detail"><?php echo $article->title; ?></span>
                </h3>
            </header>

            <?php if ($article->type == STATUS_1) { ?>
                <!--Post Image-->
                <div class="badge-post-container post-container ">
                    <img alt="<?php echo $article->title; ?>"
                         src="<?php echo $article->data_image; ?>" class="badge-item-img">
                </div>
                <!--END: Post Image-->

            <?php } else { ?>
                <!--Post MP4-->
                <div class="badge-post-container post-container ">
                    <video width="100%" height="auto" controls muted autoplay loop preload="none">
                        <!-- MP4 must be first for iPad! -->
                        <source src="<?php echo $article->data_mp4; ?>" type="video/mp4"/>
                        <!-- WebKit video -->
                        <source src="<?php echo $article->data_webm; ?>" type="video/webm"/>
                    </video>
                </div>
                <!--END: Post MP4-->
            <?php } ?>

            <!--Facebook plugin-->
            <div class="fb-plugin-content">
                <div class="txt-align-left fb-content-like">
                    <div class="fb-like"
                         data-href="<?php echo(base_url() . 'detail/' . $this->mcommon->base64EncodeStr($article->id)); ?>"
                         data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
                </div>
            </div>

            <!--Count-->
            <div class="post-meta">
                <span class="view-post-color"><span
                        class="badge-item-count"><?php echo $article->view_count; ?></span> <i
                        class="glyphicon glyphicon-eye-open"></i></span>
                &nbsp;&nbsp;
                <span class="translate-post-color"><span
                        class="badge-item-count" id="translate_count"><?php echo $article->translate_count; ?></span>
                    <i class="glyphicon glyphicon-pencil"></i></span>
            </div>

            <?php
            if (!$this->session->userdata(SESSION_USER_ID)) {
                echo '<p class="margin-top-10 txt-italic">' . $this->lfb->login_fb() . ' để tham gia dịch bài nhé :D</p>';

            } else {
                ?>
                <!--Translate-->

                <?php if ($translate == null) {
                    echo '<p id="remind_translate" class="comment-post-color txt-italic">Tham gia dịch bài bạn nhé :D</p>';
                } ?>

                <form id="frm-translate" action="#">
                    <div class="translate-group txt-align-left" style="margin-top: 10px;">
                        <div id="content_msg"></div>
                        <input type="hidden" value="<?php echo $article->id; ?>" id="hidden_article_id"/>
                        <input type="text" id="txt_title" class="form-control" required="required"
                               value="<?php echo($translate != null ? $translate->title : ''); ?>"
                               placeholder="Dịch chủ đề"/>
                        <textarea id="txt_description" class="form-control margin-top-10"
                                  placeholder="Dịch nội dung (không bắt buộc)"><?php echo($translate != null ? $translate->description : ''); ?></textarea>

                        <div class="margin-top-10 txt-align-right">
                            <button class="btn btn-success" id="btn-submit-translate" onclick="return false;"><i
                                    class="glyphicon glyphicon-ok-sign"></i> Dịch
                            </button>
                        </div>
                    </div>
                </form>
            <?php } ?>

            <!--Facebook plugin-->
            <div class="fb-plugin-content margin-top-10">
                <div class="fb-comments" data-width="100%"
                     data-href="<?php echo(base_url() . 'detail/' . $this->mcommon->base64EncodeStr($article->id)); ?>"
                     data-numposts="5"></div>
            </div>

        </article>
    </div>
</div>

<!-- BEGIN JAVASCRIPT-->
<script type="text/javascript">
    $(document).ready(function () {
        $("#frm-translate").validate({
            rules: {},
            messages: {},
            onfocusout: false,
            invalidHandler: function (form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    validator.errorList[0].element.focus();
                }
            }
        });

        $('#btn-submit-translate').click(function () {

            if ($("#frm-translate").valid()) {

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>ajax/submit_translation",
                    data: {
                        id: $('#hidden_article_id').val(),
                        title: $('#txt_title').val(),
                        description: $('#txt_description').val()
                    },
                    success: function (response) {
                        $('#content_msg').html(response);
                        $('#content_msg').fadeIn();
                        $('#remind_translate').remove();
                        $('#content_msg').delay(3000).fadeOut();
                        increaseTranslateCount();
                    }
                });
            }
        });
    });

    function increaseTranslateCount() {
        <?php if ($translate == null) { ?>
        var count = parseInt($.trim($('#translate_count').html()));
        $('#translate_count').html(count + 1);
        <?php } ?>
    }
</script>
<!-- BEGIN JAVASCRIPT -->