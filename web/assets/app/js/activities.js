var activities = function () {
    var autogrow_add_activity,
        form_add_preview_image,
        init_activities;

    /**
     * Init activities functionality
     */
    init_activities = function () {
        autogrow_add_activity();
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
        form_add_preview_image: form_add_preview_image
    };
}();