$(document).ready(function () {
    var blockCoverPosition = $('#coverPosition')[0],
        coverPosition;
    if (blockCoverPosition.textContent != '') {
        coverPosition = blockCoverPosition.textContent;
    } else {
        coverPosition = 'top';
    }
    $('#blocks-couverture').imagedrag({
        input: "#coverPosition",
        position: coverPosition,
        attribute: "html"
    });

    $('#blocks-user-information p.popover-wrapper i').click(function () {
        // Click pour changer un parametre public en non public et vis versa
        console.log(this);
        console.log($(this.parentNode).data('public'));
        if ($(this.parentNode).data('public')) {
            // Si l'information est egal a true on passe en false
            console.log('On passe en false');
        } else {
            // Sinon on passe en true
            console.log('On passe en true');
        }
    });

    // Click sur le bouton pour sauvegarder le changement de cover
    $('#btnChangeCover').click(function () {
        if ($('#test img')[0].currentSrc !== '') { // verifie si une nouvelle image est choisie
            console.log($('#test img'));
            console.log($('#test img')[0].currentSrc);
        }
    });
});