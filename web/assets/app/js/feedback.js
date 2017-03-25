var myApp = angular.module('myApp', ['angular-send-feedback']);

myApp.controller('mainController', function($scope) {
    $scope.mainMessage = "Main Controller Loaded";
    $scope.options = {
        html2canvasURL: 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js',
        ajaxURL: Routing.generate('sb_core_feedback_add')
    };
});