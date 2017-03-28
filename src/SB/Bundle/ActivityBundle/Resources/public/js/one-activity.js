$(document).ready(function () {
    $(document).on('click', '.btn-like', function(){
        var btn = this,
            id_activity = this.parentNode.parentNode.parentNode.dataset.activity;
        likes.addLike(btn, id_activity);
    });
    $(document).on('click', '.btn-dislike', function(){
        var btn = this,
            id_activity = this.parentNode.parentNode.parentNode.dataset.activity;
        likes.removeLike(btn, id_activity);
    });

    $(document).on('click', '.btn-show-comments', function () {
        var comments_block = $(this.parentNode.parentNode.parentNode).next(),
            id_activity = this.parentNode.parentNode.parentNode.parentNode.dataset.activity;
        comments.showCommentsForOneActivity(comments_block, id_activity, 'one_activity');
    });

    $(document).on('click', '.btn-show-more-comments', function () {
        var comments_block = this.parentNode.parentNode.parentNode,
            id_activity = this.parentNode.parentNode.parentNode.parentNode.dataset.activity,
            firstCommentShow = $(comments_block).find('.media:first')[0];
        $(this).remove();
        comments.showMoreCommentsForOneActivity(comments_block, id_activity, firstCommentShow.dataset.comment);
    });

    $(document).on('click', '.btn-add-comment', function () {
        var btn_send = this,
            id_activity = this.parentNode.parentNode.dataset.activity,
            comment_text = $(this.previousElementSibling.previousElementSibling).val();
        comments.addComment(comment_text, btn_send, id_activity);
    });
});