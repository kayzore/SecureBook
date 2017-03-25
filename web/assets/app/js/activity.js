$(document).ready(function () {
    $(document).on('click', '#btnAddPictures', function () {
        $("#sb_activity_image_file").click();
    });

    $(document).on('change', '#sb_activity_image_file', function () {
        activities.form_add_preview_image(this);
    });

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
        comments.showComments(comments_block, id_activity);
    });
    $(document).on('click', '.btn-add-comment', function () {
        var btn_send = this,
            id_activity = this.parentNode.parentNode.dataset.activity,
            comment_text = $(this.previousElementSibling.previousElementSibling).val();
        comments.addComment(comment_text, btn_send, id_activity);
    });
});