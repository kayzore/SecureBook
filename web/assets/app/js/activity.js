$(document).ready(function () {
    var client = new Faye.Client('http://localhost:3000/');

    client.subscribe('/' + $('#username').text(), function (message) {
        var type;
        if (message.type = 'like') {
            type = '<i class="fa fa-thumbs-up" aria-hidden="true"></i> ';
        } else if (message.type = 'comment') {
            type = '<i class="fa fa-commenting-o" aria-hidden="true"></i> ';
        } else {
            type = '';
        }
        $.notify({
            message: type + message.text
        }, {
            type: "info",
            allow_dismiss: true,
            delay: 3000,
            animate: {
                enter: 'animated fadeInLeft',
                exit: 'animated fadeOutLeft'
            },
            placement: {
                from: "bottom",
                align: "left"
            }
        });
    });

    $(".autogrow").autoGrow();

    $('#btnAddPictures').click(function () {
        $("#sb_activity_image_file").click();
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image-preview-input')
                    .attr('src', e.target.result)
                    .removeClass('hidden')
                ;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#sb_activity_image_file").change(function(){
        readURL(this);
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