$(document).ready(function () {
    var container_activity = $('#container-activity'),
        activityList;

    if (container_activity[0].dataset.totalAtivity > 5) {
        activityList = $('#container-activity div.activity');
        activities.new_waypoint($(activityList[activityList.length - 4]), 'accueil', activityList, container_activity);
    }
});