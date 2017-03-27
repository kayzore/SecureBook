/**
 * @name: Comments system
 * @description: Comment manage system
 * @type {{loadMoreComment, showComments, openCommentZone, closeCommentZone, addComment, autogrow_comments}}
 */
var comments = function () {
    var loadMoreComment,
        showComments,
        showCommentsForOneActivity,
        showMoreCommentsForOneActivity,
        openCommentZone,
        closeCommentZone,
        displayNewComments,
        addComment,
        autogrow_comments,
        init_comments;

    /**
     * Init comments functionality
     */
    init_comments = function () {
        autogrow_comments();
    };

    /**
     * Show or hide a list of comments
     * @param comments_block
     * @param id_activity
     */
    showComments = function (comments_block, id_activity, fromAddComment) {
        if (comments_block.hasClass('open') && !fromAddComment) {
            closeCommentZone(comments_block);
        } else {
            openCommentZone(comments_block, id_activity, '');
        }
        comments_block.toggleClass('open');
        comments_block.toggleClass('is_hidden');
    };

    /**
     * Show or hide a list of comments for the one activity page
     * @param comments_block
     * @param id_activity
     * @param page
     */
    showCommentsForOneActivity = function (comments_block, id_activity, page) {
        if (comments_block.hasClass('open')) {
            closeCommentZone(comments_block);
        } else {
            openCommentZone(comments_block, id_activity, page);
        }
        comments_block.toggleClass('open');
        comments_block.toggleClass('is_hidden');
    };

    showMoreCommentsForOneActivity = function (comments_block, id_activity, id_first_comment) {
        var nb_comment = $(comments_block).find('.media').length;

        if ($(comments_block).find('.nb-comments')[0].innerText != nb_comment) {
            $(comments_block).prepend('<p class="text-center loading-comment">Chargement en cours <i class="fa fa-spinner fa-pulse fa-fw"></i></p>');

            $.ajax({
                url: Routing.generate('sb_activity_get_more_comments'),
                method: 'post',
                data: {id_activity: id_activity, id_comment: id_first_comment},
                dataType: 'html',
                success: function (comments) {
                    displayNewComments(comments_block, comments, 'one_activity', id_activity);
                }
            });
        }
    };

    /**
     * Open a comment zone and display the list of comment
     * @param comments_block
     * @param id_activity
     * @param page
     */
    openCommentZone = function (comments_block, id_activity, page) {
        comments_block.html('<p class="text-center loading-comment">Chargement en cours <i class="fa fa-spinner fa-pulse fa-fw"></i></p>');
        comments_block.slideDown('slow');

        $.ajax({
            url: Routing.generate('sb_activity_get_comments'),
            method: 'post',
            data: {id_activity: id_activity},
            dataType: 'html',
            success: function (comments) {
                displayNewComments(comments_block, comments, page, id_activity);
            }
        });
    };

    /**
     * Display on page a list of comments
     * @param comments_block
     * @param new_comments
     * @param page
     * @param id_activity
     */
    displayNewComments = function (comments_block, new_comments, page, id_activity) {
        $(comments_block).find('.loading-comment')[0].remove();
        $(comments_block).prepend(new_comments);
        if ($(comments_block).find('.nb-comments')[0].innerText > 3) {
            if (page == '') {
                var route = Routing.generate('sb_activity_view', {id: id_activity});
                $(comments_block).prepend(''
                    + '<div class="row" class="row-show-more-comments">'
                        + '<div class="col-xs-12 text-center">'
                            + '<a class="btn-link btn-show-more-comments" href="' + route + '">Voir plus</a>'
                        + '</div>'
                    + '</div>'
                );
            } else if (page == 'one_activity') {
                $(comments_block).prepend(''
                    + '<div class="row" class="row-show-more-comments">'
                        + '<div class="col-xs-12 text-center">'
                            + '<button class="btn-link btn-show-more-comments" href="#">Voir plus</button>'
                        + '</div>'
                    + '</div>'
                );
            }
        }
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
                    showComments(comments_block, id_activity, true);
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
        init_comments: init_comments,
        loadMoreComment: loadMoreComment,
        showComments: showComments,
        showCommentsForOneActivity: showCommentsForOneActivity,
        showMoreCommentsForOneActivity: showMoreCommentsForOneActivity,
        openCommentZone: openCommentZone,
        closeCommentZone: closeCommentZone,
        addComment: addComment,
        autogrow_comments: autogrow_comments
    };
}();