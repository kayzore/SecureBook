var likes = function () {
    var addLike,
        removeLike;

    /**
     * Add like of activity
     * @param btn
     * @param id_activity
     */
    addLike = function (btn, id_activity) {
        $(btn).append('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        $.ajax({
            url: Routing.generate('sb_activity_like', {'_locale': $('html').attr('lang')}),
            method: 'post',
            data: {id_activity: id_activity},
            dataType: 'json',
            success: function (result) {
                var likes_text;
                if (result.activity_likes > 2) {
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
    };

    /**
     * Remove like of activity
     * @param btn
     * @param id_activity
     */
    removeLike = function (btn, id_activity) {
        $(btn).append('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        $.ajax({
            url: Routing.generate('sb_activity_dislike', {'_locale': $('html').attr('lang')}),
            method: 'post',
            data: {id_activity: id_activity},
            dataType: 'json',
            success: function (result) {
                var likes_text;
                if (result.activity_likes > 2) {
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
    };

    return {
        addLike: addLike,
        removeLike: removeLike
    };
}();