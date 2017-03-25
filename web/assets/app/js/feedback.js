var myApp = angular.module('myApp', ['angular-send-feedback']);

myApp.controller('mainController', function($scope) {
    $scope.mainMessage = "Main Controller Loaded";
    $scope.options = {
        html2canvasURL: 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js',
        ajaxURL: Routing.generate('sb_core_feedback_add'),
        tpl: {
            initButton:     '<div id="feedback-button"></div><button class="feedback-btn feedback-btn-gray">Feedback</button></div>',
            highlighter:    '<div id="feedback-highlighter"><div class="feedback-logo">Feedback</div><p>Selectionner une ou plusieurs zone à mettre en surbrillance pour votre feedback. Vous pouvez déplacer cette fenêtre si celle-ci vous gêne.</p><button class="feedback-sethighlight feedback-active"><div class="ico"></div><span>Highlight</span></button><label>Mettre une zone en surbrillance.</label><button class="feedback-setblackout"><div class="ico"></div><span>Black out</span></button><label class="lower">Masquer des informations personnelles.</label><div class="feedback-buttons"><button id="feedback-highlighter-next" class="feedback-next-btn feedback-btn-gray">Suivant</button><button id="feedback-highlighter-back" class="feedback-back-btn feedback-btn-gray">Retour</button></div><div class="feedback-wizard-close"></div></div>',
            overview:	    '<div id="feedback-overview"><div class="feedback-logo">Feedback</div><div id="feedback-overview-description"><div id="feedback-overview-description-text"><h3>Message</h3><h3 class="feedback-additional">informations additionnelles</h3><div id="feedback-additional-none"><span>None</span></div><div id="feedback-browser-info"><span>Navigateur Infos</span></div><div id="feedback-page-info"><span>Page Infos</span></div><div id="feedback-page-structure"><span>Page Structure</span></div></div></div><div id="feedback-overview-screenshot"><h3>Screenshot</h3></div><div class="feedback-buttons"><button id="feedback-submit" class="feedback-submit-btn feedback-btn-blue">Envoyer</button><button id="feedback-overview-back" class="feedback-back-btn feedback-btn-gray">Retour</button></div><div id="feedback-overview-error">Veuillez saisir un message.</div><div class="feedback-wizard-close"></div></div>',
            submitSuccess:	'<div id="feedback-submit-success"><div class="feedback-logo">Feedback</div><p>Thank you for your feedback. We value every piece of feedback we receive.</p><p>We cannot respond individually to every one, but we will use your comments as we strive to improve your experience.</p><button class="feedback-close-btn feedback-btn-blue">OK</button><div class="feedback-wizard-close"></div></div>',
            submitError:	'<div id="feedback-submit-error"><div class="feedback-logo">Feedback</div><p>Sadly an error occured while sending your feedback. Please try again.</p><button class="feedback-close-btn feedback-btn-blue">OK</button><div class="feedback-wizard-close"></div></div>'
        }
    };
});