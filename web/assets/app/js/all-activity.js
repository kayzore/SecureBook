$(document).ready(function () {
    var loading_activity = false,
        all_activity_loaded = false,
        container_activity = $('#container-activity'),
        activityList = $('#container-activity div.activity'),
        waypoint;

    if (container_activity[0].dataset.totalAtivity > 5) {
        waypoint = new Waypoint({
            element: $(activityList[activityList.length - 4]),
            handler: function() {
                loadMoreActivity()
            }
        })
    }

    function loadMoreActivity() {
        var activityList = $('#container-activity div.activity'),
            lastActivity = activityList.last(),
            id_last_activity = lastActivity[0].dataset.activity;
        if (!loading_activity && !all_activity_loaded) {
            loading_activity = true;
            container_activity.fadeIn('slow').append(''
                + '<div class="col-md-8" id="loading-activity">'
                + '<p class="text-center">Chargement en cours <i class="fa fa-spinner fa-pulse fa-fw"></i></p>'
                + '</div>');
            $.ajax({
                url: Routing.generate('sb_activity_get_activity'),
                method: 'post',
                data: {id_last_activity: id_last_activity},
                dataType: 'html',
                success: function (list_activity) {
                    $('#loading-activity').fadeOut('slow').remove();
                    container_activity.append(list_activity);
                    loading_activity = false;
                    if (container_activity[0].dataset.totalAtivity == $('#container-activity div.activity').length) {
                        waypoint.destroy();
                        all_activity_loaded = true;
                        container_activity.fadeIn('slow').append(''
                            + '<div class="col-md-8 no-pl no-pr">'
                            + '<div class="alert alert-info alert-no-activity">'
                            + '<p class="text-center">Plus d\'actualité</p>'
                            + '</div>'
                            + '</div>');
                    } else {
                        waypoint.destroy();
                        waypoint = new Waypoint({
                            element: $(activityList[activityList.length - 4]),
                            handler: function() {
                                loadMoreActivity()
                            }
                        });
                    }
                }
            });
        }
    }
});