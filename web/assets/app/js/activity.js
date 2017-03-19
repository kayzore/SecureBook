$(document).ready(function () {
    $(".autogrow").autoGrow();
    $('#btnAddPictures').click(function () {
        $("#sb_activity_image_file").click();
    });

    $(document).on('click', '.btn-like', function(){
        var btn = this,
            id_activity = this.dataset.activity;
        $(btn).append('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        $.ajax({
            url: Routing.generate('sb_activity_like'),
            method: 'post',
            data: {id_activity: id_activity},
            dataType: 'json',
            success: function (result) {
                var likes_text;
                if (result.activity_likes > 0) {
                    likes_text = result.activity_likes + " J'aimes";
                } else {
                    likes_text = result.activity_likes + " J'aime";
                }
                $(btn)
                    .html(likes_text)
                    .removeClass('btn-like')
                    .removeClass('btn-primary')
                    .addClass('btn-dislike')
                    .addClass('btn-success')
                ;
            }
        });
    });
    $(document).on('click', '.btn-dislike', function(){
        var btn = this,
            id_activity = this.dataset.activity;
        $(btn).append('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        $.ajax({
            url: Routing.generate('sb_activity_dislike'),
            method: 'post',
            data: {id_activity: id_activity},
            dataType: 'json',
            success: function (result) {
                var likes_text;
                if (result.activity_likes > 0) {
                    likes_text = result.activity_likes + " J'aimes";
                } else {
                    likes_text = result.activity_likes + " J'aime";
                }
                $(btn)
                    .html(likes_text)
                    .removeClass('btn-dislike')
                    .removeClass('btn-success')
                    .addClass('btn-like')
                    .addClass('btn-primary')
                ;
            }
        });
    });
});