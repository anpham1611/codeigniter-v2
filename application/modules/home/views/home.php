<div class="panel panel-default">
    <div class="panel-body" id="panel-articles-body">

        <?php
        $this->load->view('home/articles-content', $articles);
        ?>

    </div>
</div>

<?php echo script_tag("assets/js/ajax-manager.js"); ?>
<script type="text/javascript">
    $(window).scroll(function() {
        if($(window).scrollTop() == $(document).height() - $(window).height()) {

            var queue = new $.AjaxQueue();
            queue.add({
                type: 'POST',
                url: '<?php echo base_url(); ?>ajax/get-more-articles',
                data: {arr_ids: getArrIdsOfArticles(), key_search: '<?php echo $key_search; ?>', is_hot: '<?php echo $is_hot; ?>'},
                success: function(data) {
                    $('#load-more-articles').remove();
                    $('#panel-articles-body').append(data);
                    try{
                        FB.XFBML.parse();
                    }catch(ex){}
                },
                _run: function(req) {
                    // special pre-processor to alter the request just before it is finally executed in the queue
                    //req.url = ''
                }
            });

        }
    });

    function getArrIdsOfArticles()
    {
        var arrIDs = [];
        $.each($('#panel-articles-body').find('article'), function() {

            var attr = $(this).attr('data-id');
            if (typeof attr !== typeof undefined && attr !== false) {
                arrIDs.push(attr);
            }

        });

        return arrIDs.join( "," );
    }
</script>