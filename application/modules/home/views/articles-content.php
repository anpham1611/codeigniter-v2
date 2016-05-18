<?php if (count($articles) > 0) { ?>

<?php foreach ($articles as $article) { ?>

    <article data-id="<?php echo $article->id; ?>" class="content-article">
        <header>
            <h3 class="txt-align-left clr-margin-top">
                <a target="_blank"
                   href="<?php echo(base_url() . 'detail/' . $this->mcommon->base64EncodeStr($article->id)); ?>"><?php echo $article->title; ?></a>
            </h3>
        </header>

        <?php if ($article->type == STATUS_1) { ?>
            <!--Post Image-->
            <div class="badge-post-container post-container ">
                <a target="_blank"
                   href="<?php echo(base_url() . 'detail/' . $this->mcommon->base64EncodeStr($article->id)); ?>">
                    <img alt="<?php echo $article->title; ?>"
                         src="<?php echo $article->data_image; ?>" class="badge-item-img">
                </a>
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

        <div class="post-meta">
            <a target="_blank"
               href="<?php echo(base_url() . 'detail/' . $this->mcommon->base64EncodeStr($article->id)); ?>">
                <span class="view-post-color"><span
                        class="badge-item-count"><?php echo $article->view_count; ?></span> <i
                        class="glyphicon glyphicon-eye-open"></i></span>
            </a>
            &nbsp;&nbsp;
            <a target="_blank"
               href="<?php echo(base_url() . 'detail/' . $this->mcommon->base64EncodeStr($article->id)); ?>">
                <span class="translate-post-color"><span
                        class="badge-item-count"><?php echo $article->translate_count; ?></span>
                    <i class="glyphicon glyphicon-pencil"></i></span>
            </a>
        </div>

        <!--Facebook plugin-->
        <div class="fb-plugin-content">
            <div class="txt-align-left fb-content-like">
                <div class="fb-like"
                     data-href="<?php echo(base_url() . 'detail/' . $this->mcommon->base64EncodeStr($article->id)); ?>"
                     data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
            </div>
        </div>

    </article>

    <hr/>
<?php } ?>

<div id="load-more-articles">
    <img alt="Load more articles"
         src="<?php echo base_url(); ?>/assets/img/load_more.gif" class="item-img-load-more">
</div>

<?php } else { ?>

    <h3 class="comment-post-color">Không tìm thấy nội dung!</h3>
    <h4><a href="<?php echo base_url(); ?>">Quay lại trang chủ</a></h4>

<?php } ?>