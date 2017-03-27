$(document).ready(function () {
    var older_prenom_value = $('#zonePrenom a')[0].innerText,
        older_nom_value = $('#zoneNom a')[0].innerText,
        older_pays_value = $('#zonePays a')[0].innerText,
        older_region_value = $('#zoneRegion a')[0].innerText,
        older_ville_value = $('#zoneVille a')[0].innerText;
    $('.btn-toggle').bootstrapToggle({
        on: 'Visible',
        off: 'Masqué',
        width: '100px'
    });

    $(document).on('change', '#btn-toggle-avatar-visibility', function () {
        console.log('Toggle: ' + $(this).prop('checked'))

        saveConfidentiality('avatar', $(this).prop('checked'), null);
    });

    $('#blocks-user-information div .confidentiality i').click(function () {
        var champ = $(this.parentNode).data('zone').toLowerCase();
        // Click pour changer un parametre public en non public et vis versa
        if (this.parentNode.dataset.public == 'true') {
            // Si l'information est egal a true on passe en false
            saveConfidentiality(champ, false, this);
        } else {
            // Sinon on passe en true
            saveConfidentiality(champ, true, this);
        }
    });
    function saveConfidentiality(champ, new_value, fa) {
        $.ajax({
            url: Routing.generate('sb_user_profil_update_profil_confidentiality', {'_locale': $('html').attr('lang')}),
            method: 'post',
            data: {champ: champ, new_value: new_value},
            dataType: 'json',
            success: function (result) {
                if (result.result == true) {
                    if (new_value && fa != null) {
                        $(fa)
                            .removeClass('fa-eye-slash')
                            .addClass('fa-eye')
                            .attr('title', 'Visible')
                        ;
                        fa.parentNode.dataset.public = 'true';
                    } else if (!new_value && fa != null) {
                        $(fa)
                            .removeClass('fa-eye')
                            .addClass('fa-eye-slash')
                            .attr('title', 'Masqué')
                        ;
                        fa.parentNode.dataset.public = 'false';
                    }
                }
            }
        });
    }

    /**
     * Systeme de modification dynamique des informations (affiche le formulaire)
     */
    $(document).on('click', '#blocks-user-information a', function (evt) {
        evt.preventDefault();
        var elementParent = this.parentNode,
            label = elementParent.dataset.zone,
            zone = this.innerText,
            value;

        if (label == 'Prenom') {
            older_prenom_value = value = zone;
        } else if (label == 'Nom') {
            older_nom_value = value = zone;
        } else if (label == 'Pays') {
            older_pays_value = value = zone;
        } else if (label == 'Region') {
            older_region_value = value = zone;
        } else if (label == 'Ville') {
            older_ville_value = value = zone;
        }

        $(this)
            .fadeOut('slow')
            .remove()
        ;

        $(elementParent)
            .hide()
            .html(''
                + '<form class="form-inline">'
                    + '<div class="form-group">'
                        + '<div class="col-md-3 no-padding">'
                            + '<label for="input' + label + '" class="no-margin" style="margin-top: 4px !important;">' + label + '</label>&nbsp;'
                        + '</div>'
                        + '<div class="col-md-8 no-padding">'
                            + '<input id="input' + label + '" class="form-control input-sm" type="text" value="' + value + '" style="width: 70%">&nbsp;'
                            + '<div class="btn-group btn-group-xs" style="display: inline-block !important;">'
                                + '<button type="button" class="btn btn-primary btn-valid-informations"><i class="fa fa-check" aria-hidden="true"></i></button>'
                                + '<button type="button" class="btn btn-primary btn-cancel-informations"><i class="fa fa-times" aria-hidden="true"></i></button>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</form>')
            .fadeIn('slow')
        ;
    });

    /**
     * Systeme de validation d'un input de modification dynamique des informations
     */
    $(document).on('click', '#blocks-user-information form .btn-valid-informations', function () {
        var new_value = $(this.parentNode.parentNode).find('input').val(),
            zone = this.parentNode.parentNode.parentNode.parentNode.parentNode,
            zone_value = zone.dataset.zone,
            btnCancel = this.nextElementSibling,
            type;

        if (
            (zone_value == 'Prenom' && older_prenom_value != new_value)
            || (zone_value == 'Nom' && older_nom_value != new_value)
            || (zone_value == 'Pays' && older_pays_value != new_value)
            || (zone_value == 'Region' && older_region_value != new_value)
            || (zone_value == 'Ville' && older_ville_value != new_value)
        ) {
            switch (zone_value) {
                case 'Prenom':
                    older_prenom_value = new_value;
                    break;
                case 'Nom':
                    older_nom_value = new_value;
                    break;
                case 'Pays':
                    older_pays_value = new_value;
                    break;
                case 'Region':
                    older_region_value = new_value;
                    break;
                case 'Ville':
                    older_ville_value = new_value;
                    break;
            }
            type = zone_value.toLowerCase();
            saveInformation(type, new_value, btnCancel);
        }
    });

    /**
     * Sauvegarde un champ d'information
     * @param champ
     * @param new_value
     * @param btnCancel
     */
    function saveInformation(champ, new_value, btnCancel) {
        var type = champ;
        $.ajax({
            url: Routing.generate('sb_user_profil_update_profil', {'_locale': $('html').attr('lang')}),
            method: 'post',
            data: {champ: champ, new_value: new_value},
            dataType: 'json',
            success: function (result) {
                if (result.result == true) {
                    if (type == 'prenom' || type == 'nom') {
                        $('#zone-profil-name')
                            .hide()
                            .html(older_prenom_value + '&nbsp;' + older_nom_value)
                            .fadeIn('slow')
                        ;
                    }
                    if (btnCancel != null) {
                        $(btnCancel).click();
                    }
                } else {
                    console.log('error')
                }
            }
        });
    }

    /**
     * Systeme de fermeture d'un champ d'information
     */
    $(document).on('click', '#blocks-user-information form .btn-cancel-informations', function () {
        var form = this.parentNode.parentNode.parentNode.parentNode,
            zone = this.parentNode.parentNode.parentNode.parentNode.parentNode,
            zone_value = zone.dataset.zone,
            label = this.parentNode.parentNode.parentNode.parentNode.parentNode.dataset.zone,
            older_value;

        if (zone_value == 'Prenom') {
            older_value = older_prenom_value;
        } else if (zone_value == 'Nom') {
            older_value = older_nom_value;
        } else if (zone_value == 'Pays') {
            older_value = older_pays_value;
        } else if (zone_value == 'Region') {
            older_value = older_region_value;
        } else if (zone_value == 'Ville') {
            older_value = older_ville_value;
        }

        $(form).remove();
        $(zone).html(label + ' : <a href="#">' + older_value + ' <i class="fa fa-pencil" aria-hidden="true"></i></a>');
    });

    // Click sur le bouton pour sauvegarder le changement de cover
    $('#btnChangeCover').click(function () {
        if ($('#test img')[0].currentSrc !== '') { // verifie si une nouvelle image est choisie
            console.log($('#test img'));
            console.log($('#test img')[0].currentSrc);
        }
    });
});