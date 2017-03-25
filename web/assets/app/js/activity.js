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
        $(btn).append('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        $.ajax({
            url: Routing.generate('sb_activity_like'),
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
    });
    $(document).on('click', '.btn-dislike', function(){
        var btn = this,
            id_activity = this.parentNode.parentNode.parentNode.dataset.activity;
        $(btn).append('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        $.ajax({
            url: Routing.generate('sb_activity_dislike'),
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