$(document).ready(function () {
    var loading_activity = false,
        all_activity_loaded= false,
        container_activity = $('#container-activity');
    var client = new Faye.Client('http://localhost:3000/');

    // Inscription du client au channel "notifications" & lorsqu'on recoit un message affichage dans la console
    client.subscribe('/' + $('#username').text(), function (message) {
        console.log(message.text);
        if (message.type = 'like') {
            type = '<i class="fa fa-thumbs-up" aria-hidden="true"></i> ';
        } else if (message.type = 'comment') {
            type = '<i class="fa fa-commenting-o" aria-hidden="true"></i> ';
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
            id_activity;
        if (comments_block.hasClass('open')) {
            comments_block.slideUp('slow');
        } else {
            comments_block.html('<p class="text-center">Chargement en cours <i class="fa fa-spinner fa-pulse fa-fw"></i></p>');
            comments_block.slideDown('slow');
            id_activity = this.parentNode.parentNode.parentNode.parentNode.dataset.activity;

            $.ajax({
                url: Routing.generate('sb_activity_get_comments'),
                method: 'post',
                data: {id_activity: id_activity},
                dataType: 'html',
                success: function (comments) {
                    comments_block.html(comments);
                }
            });
        }
        comments_block.toggleClass('open');
        comments_block.toggleClass('is_hidden');
    });
    $(document).on('click', '.btn-add-comment', function () {
        var btn_send = this,
            id_activity = this.parentNode.parentNode.dataset.activity,
            comment_text = $(this.previousElementSibling.previousElementSibling).val();

        $(btn_send).append('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        $.ajax({
            url: Routing.generate('sb_activity_add_comment'),
            method: 'post',
            data: {comment_text: comment_text, id_activity: id_activity},
            dataType: 'json',
            success: function (result) {
               console.log(result)
            }
        });
    });

    function isScrolledIntoView(elem) {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop + $(elem).height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }
    $(window).scroll(function(){
        var activityList = $('div.activity'),
            isElementInView = isScrolledIntoView($(activityList[activityList.length - 3])),
            isElementInView2 = isScrolledIntoView($(activityList[activityList.length - 2])),
            isElementInView3 = isScrolledIntoView($(activityList[activityList.length - 1])),
            lastActivity,
            id_last_activity;

        if ((isElementInView || isElementInView2 || isElementInView3) && !all_activity_loaded) {
            if (!loading_activity) {
                loading_activity = true;
                lastActivity = activityList.last();
                id_last_activity = lastActivity[0].dataset.activity;
                container_activity.fadeIn('slow').append('<div class="col-md-6" id="loading-activity"><p class="text-center">Chargement en cours <i class="fa fa-spinner fa-pulse fa-fw"></i></p></div>');
                $.ajax({
                    url: Routing.generate('sb_activity_get_activity'),
                    method: 'post',
                    data: {id_last_activity: id_last_activity},
                    dataType: 'html',
                    success: function (list_activity) {
                        $('#loading-activity').fadeOut('slow').remove();
                        container_activity.append(list_activity);
                        loading_activity = false;
                        if (container_activity[0].dataset.totalAtivity == ($('div.activity').length - 1)) {
                            all_activity_loaded = true;
                            container_activity.fadeIn('slow').append('<div class="col-md-6 no-pl"><div class="alert alert-info alert-no-activity"><p class="text-center">Plus d\'actualité</p></div></div>');
                        }
                    }
                });
            }
        }
    })
});