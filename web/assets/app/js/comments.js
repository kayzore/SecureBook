/**
 * @name: Comments system
 * @description: Comment manage system
 * @type {{loadMoreComment, showComments, openCommentZone, closeCommentZone, addComment, autogrow_comments}}
 */
var comments = function () {
    var loadMoreComment,
        showComments,
        openCommentZone,
        closeCommentZone,
        addComment,
        autogrow_comments;

    /**
     * TODO: Create the loadMoreComment system
     * @param id_activity
     */
    loadMoreComment = function (id_activity) {
        $.ajax({
            url: Routing.generate(''),
            methode: 'get',
            dataType: 'html',
            success: function (comments) {
                console.log(comments)
            }
        });
    };

    /**
     * Show or hide a list of comments
     * @param comments_block
     * @param id_activity
     */
    showComments = function (comments_block, id_activity) {
        if (comments_block.hasClass('open')) {
            closeCommentZone(comments_block);
        } else {
            openCommentZone(comments_block, id_activity);
        }
        comments_block.toggleClass('open');
        comments_block.toggleClass('is_hidden');
    };

    /**
     * Open a comment zone and display the list of comment
     * @param comments_block
     * @param id_activity
     */
    openCommentZone = function (comments_block, id_activity) {
        comments_block.html('<p class="text-center">Chargement en cours <i class="fa fa-spinner fa-pulse fa-fw"></i></p>');
        comments_block.slideDown('slow');

        $.ajax({
            url: Routing.generate('sb_activity_get_comments'),
            method: 'post',
            data: {id_activity: id_activity},
            dataType: 'html',
            success: function (comments) {
                comments_block.html(comments);
                if ($(comments_block).find('.nb-comments')[0].innerText > 3) {
                    var route = Routing.generate('sb_activity_view', {id: id_activity});
                    $(comments_block).prepend('<div class="row"><div class="col-xs-12 text-center"><a class="btn-link btn-show-more-comments" href="' + route + '">Voir plus</a></div></div>');
                }
            }
        });
    };

    /**
     * Close a comment zone
     * @param comments_block
     */
    closeCommentZone = function (comments_block) {
        comments_block.slideUp('slow');
    };

    /**
     * Add comment on activity
     * @param comment_text
     * @param btn_send
     * @param id_activity
     */
    addComment = function (comment_text, btn_send, id_activity) {
        if (comment_text.length > 0) {
            $(btn_send).append('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
            $.ajax({
                url: Routing.generate('sb_activity_add_comment'),
                method: 'post',
                data: {comment_text: comment_text, id_activity: id_activity},
                dataType: 'json',
                success: function (result) {
                    var btnComments = $($(btn_send.parentNode.parentNode).find('.btn-show-comments')[0]),
                        textarea = $($(btn_send.parentNode).find('textarea')[0]),
                        comments_block;

                    btnComments[0].innerText = result.activity_comments + ' Commentaires';
                    $(btn_send).html('<i class="fa fa-paper-plane" aria-hidden="true"></i>');

                    comments_block = $($(btn_send.parentNode.parentNode).find('.activity-comments')[0]);
                    comments.openCommentZone(comments_block, id_activity);
                    $(textarea[0]).val('');
                    $(".autogrow").autoGrow();
                }
            });
        }
    };

    /**
     * Init textarea of comments
     */
    autogrow_comments = function () {
        $(".autogrow-comment").autoGrow();
    };

    return {
        loadMoreComment: loadMoreComment,
        showComments: showComments,
        openCommentZone: openCommentZone,
        closeCommentZone: closeCommentZone,
        addComment: addComment,
        autogrow_comments: autogrow_comments
    };
}();