var activities = function () {
    var autogrow_add_activity,
        form_add_preview_image,
        init_activities,
        loadMoreActivities,
        getMoreActivities,
        showNewActivities,
        new_waypoint,
        waypoint,
        loading_activity = false,
        all_activity_loaded = false,
        container_activities,
        activities_list,
        current_page;

    /**
     * Init activities functionality
     */
    init_activities = function () {
        autogrow_add_activity();
    };

    /**
     * System to load more activities
     * @param page
     * @param activityList
     * @param container_activity
     */
    loadMoreActivities = function (page, activityList, container_activity) {
        var lastActivity = activityList.last(),
            id_last_activity = lastActivity[0].dataset.activity,
            route;

        current_page = page;
        activities_list = activityList;
        container_activities = container_activity;

        if (!loading_activity && !all_activity_loaded) {
            loading_activity = true;
            container_activities.fadeIn('slow').append(''
                + '<div class="col-md-8" id="loading-activity">'
                    + '<p class="text-center">Chargement en cours <i class="fa fa-spinner fa-pulse fa-fw"></i></p>'
                + '</div>'
            );

            if (page == 'accueil') {
                route = Routing.generate('sb_activity_get_activity');
                getMoreActivities(route, id_last_activity);
            } else if (page == 'profil') {
                route = Routing.generate('sb_activity_get_my_activity');
                getMoreActivities(route, id_last_activity);
            }
        }
    };

    /**
     * Start ajax request to get more activities
     * @param route
     * @param id_last_activity
     */
    getMoreActivities = function (route, id_last_activity) {
        $.ajax({
            url: route,
            method: 'post',
            data: {id_last_activity: id_last_activity},
            dataType: 'html',
            success: function (list_activity) {
                showNewActivities(list_activity);
            }
        });
    };

    /**
     * Display new activities
     * @param list_new_activities
     */
    showNewActivities = function (list_new_activities) {
        $('#loading-activity').fadeOut('slow').remove();
        container_activities.append(list_new_activities);
        loading_activity = false;
        if (container_activities[0].dataset.totalAtivity == $('#container-activity div.activity').length) {
            waypoint.destroy();
            all_activity_loaded = true;
            container_activities.fadeIn('slow').append(''
                + '<div class="col-md-8 no-pl no-pr">'
                    + '<div class="alert alert-info alert-no-activity">'
                        + '<p class="text-center">Plus d\'actualité</p>'
                    + '</div>'
                + '</div>'
            );
        } else {
            waypoint.destroy();
            activities_list = $('#container-activity div.activity');
            new_waypoint($(activities_list[activities_list.length - 4]), current_page, activities_list, container_activities);
        }
    };

    /**
     * Set new waypoint
     * @param activity
     * @param page
     * @param activityList
     * @param container_activity
     */
    new_waypoint = function (activity, page, activityList, container_activity) {
        waypoint = new Waypoint({
            element: activity,
            handler: function() {
                loadMoreActivities(page, activityList, container_activity);
            }
        });
    };

    /**
     * Preview image system on form add activity
     * @param input
     */
    form_add_preview_image = function (input) {
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
    };

    /**
     * Init textarea of form activity
     */
    autogrow_add_activity = function () {
        $(".autogrow-add-activity").autoGrow();
    };

    return {
        init_activities: init_activities,
        autogrow_add_activity: autogrow_add_activity,
        form_add_preview_image: form_add_preview_image,
        loadMoreActivities: loadMoreActivities,
        new_waypoint: new_waypoint
    };
}();