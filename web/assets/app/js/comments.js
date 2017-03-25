$(document).ready(function () {
    function loadMoreComment(id_activity) {
        $.ajax({
            url: Routing.generate(''),
            methode: 'get',
            dataType: 'html',
            success: function (comments) {
                console.log(comments)
            }
        });
    }

    $(document).on('click', '.btn-show-more-comments', function () {
        console.log('ok');
    });
});