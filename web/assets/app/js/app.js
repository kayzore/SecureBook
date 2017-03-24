$(document).ready(function () {
    $.feedback({
        ajaxURL: 'http://test.url.com/feedback',
        html2canvasURL: 'http://localhost/jl/securebook/web/assets/external/libs/feedback/stable/2.0/html2canvas.js',
        postBrowserInfo: true,
        postHTML: true,
        postURL: true,
        initButtonText: 'Feedback',
        highlightElement: true,
        isDraggable: true
    });
});