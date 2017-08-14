$(document).ready(function () {
    // conteggio dei caratteri
    $('input, textarea').characterCounter();

    // inizializo le select
    $('select').material_select();

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 5, // Creates a dropdown of 15 years to control year,
        today: 'Oggi',
        clear: 'Pulisci',
        close: 'Ok',
        closeOnSelect: false // Close upon selecting a date,
    });


    /**
     *  SEZIONE MARCHE
     *
    // aggiungo il listener per mostrare le informazioni delle marche per modificarle
    $('#marcheSelect').on('change', function () {
        var idd = $(this).val();
        $.ajax({
            type: "POST",
            url: "../getProdDetails.php",
            data: "id=" + idd,
            success: function (msg) {
                var obj = JSON.parse(msg);
                var s = "";
                for (var i = 0; i < obj.fotos.length; i++) {
                    s += "<div class='col l3 m4 s12' id='container" + obj.fotos[i].id + "'>" +
                            "<img class='responsive-img image-prod' src='../images/" + obj.fotos[i].immagine + "'>" +
                            "<p class='center'><a class='link' onclick='eliminaImg(" + obj.fotos[i].id + ", \"container" + obj.fotos[i].id + "\")' href='#!'>Elimina</a> · <a class='link' onclick='setDefault(" + obj.fotos[i].id + ")' href='#!'>Imposta come default</a></p>" +
                            "</div>";
                }

                $('#nomeP').val(obj.nome);
                $('#descrP').val(obj.descrizione);
                $('#etaP').val(obj.eta);
                if (obj.immagine === null || obj.immagine.length === 0)
                    $('#default_img').html("<img width='65%' class='responsive-img' src='../images/no_image.png'>");
                else
                    $('#default_img').html("<img width='75%' src='../images/" + obj.immagine + "' class='responsive-img' />");

                $('#images_holder').html(s);
                Materialize.updateTextFields();
            },
            error: function (msg) {
                console.log("Error: " + msg);
            }
        });
    });

    // listener per il bottone di salvataggio delle modifiche di una marca
    $('#submit_btn1').on('click', function () {
        var nomeP = $('#nomeP').val(),
                descrP = $('#descrP').val(),
                etaP = $('#etaP').val();
        $.ajax({
            type: "POST",
            url: "salvaProd.php",
            data: "nome=" + nomeP + "&descr=" + descrP + "&eta=" + etaP,
            success: function (msg) {
                if (msg === '0')
                    Materialize.toast("Modifiche salvate", 4000);
                else
                    Materialize.toast("Errore nel salvataggio delle modifiche", 4000);
            },
            error: function (msg) {
                Materialize.toast("Errore nel salvataggio delle modifiche", 4000);
            }
        });
    });
*/
    // lister per il caricamento dell'immagine delle categorie
    $("#userImage").on('change', function (e) {
        var formData = new FormData();
        formData.append('userImage', $('#userImage')[0].files[0]);
        $.ajax({
            url: "controlPanel_uploadImage.php",
            type: "POST",
            data: formData,
            success: function (msg) {
                if (msg !== '0') {
                    Materialize.toast("Foto caricata con successo", 4000)
                    var img = msg.split("|")[1];
                    var id = msg.split("|")[0];
                    var s = "<div style='display: none;' class='col l3 m4 s12' id='container" + id + "'>" +
                            "<img class='responsive-img image-prod' src='../images/" + img + "'>" +
                            "<p class='center'><a class='link' onclick='eliminaImg(" + id + ", \"container" + id + "\")' href='#!'>Elimina</a></p>" +
                            "</div>";
                    $('#images_holder').html($('#images_holder').html() + s);
                    $('#container' + id).toggle('display');
                } else
                    Materialize.toast("Errore nel caricamento della foto", 4000);
            },
            error: function (msg) {
                console.log(msg);
                Materialize.toast("Errore nel caricamento della foto", 4000);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        e.preventDefault();
    });

    /**
     * SEZIONE CATEGORIE
     */
    // aggiungo il listener per mostrare le informazioni delle categorie per modificarle
    $('#categorieSelect').on('change', function () {
        var idd = $(this).val();
        $.ajax({
            type: "POST",
            url: "getCatDetails.php",
            data: "id=" + idd,
            success: function (msg) {
                var obj = JSON.parse(msg);
                var s = "";
                for (var i = 0; i < obj.fotos.length; i++) {
                    s += "<div class='col l3 m4 s12' id='container" + obj.fotos[i].id + "'>" +
                            "<img class='responsive-img image-prod' src='../images/" + obj.fotos[i].immagine + "'>" +
                            "<p class='center'><a class='link' onclick='eliminaImg(" + obj.fotos[i].id + ", \"container" + obj.fotos[i].id + "\")' href='#!'>Elimina</a></p>" +
                            "</div>";
                }

                $('#nomeC').val(obj.nome);
                $('#descrC').val(obj.descrizione);
                $('#etaC').val(obj.eta);
                $('#images_holder').html(s);
                if (obj.immagine === null || obj.immagine.length === 0)
                    $('#img_cat').html("<img width='65%' class='responsive-img' src='../images/no_image.png'>");
                else
                    $('#img_cat').html("<img width='65%' src='../images/" + obj.immagine + "' class='responsive-img' />");

                Materialize.updateTextFields();
            },
            error: function (msg) {
                console.log("Error: " + msg);
            }
        });
    });

    // lister per il caricamento dell'immagine delle categorie
    $("#userImageCat").on('change', function (e) {
        var formData = new FormData();
        formData.append('userImageCat', $('#userImageCat')[0].files[0]);
        $.ajax({
            url: "controlPanel_uploadImageCat.php",
            type: "POST",
            data: formData,
            success: function (msg) {
                if (msg !== '1') {
                    Materialize.toast("Foto caricata con successo", 4000)
                    $('#img_cat').html("<img width='65%' src='../images/" + msg + "' class='responsive-img' />");
                } else
                    Materialize.toast("Errore nel caricamento della foto", 4000);
            },
            error: function (msg) {
                console.log(msg);
                Materialize.toast("Errore nel caricamento della foto", 4000);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        e.preventDefault();
    });

    // listener per il bottone di salvataggio delle modifiche di una categoria
    $('#submit_btn2').on('click', function () {
        var nomeC = $('#nomeC').val(),
                descrC = $('#descrC').val(), etaC = $('#etaC').val();
        $.ajax({
            type: "POST",
            url: "salvaCat.php",
            data: "nome=" + nomeC + "&descr=" + descrC + "&eta=" + etaC,
            success: function (msg) {
                if (msg === '0')
                    Materialize.toast("Modifiche salvate", 4000);
                else
                    Materialize.toast("Errore nel salvataggio delle modifiche", 4000);
            },
            error: function (msg) {
                Materialize.toast("Errore nel salvataggio delle modifiche", 4000);
            }
        });
    });
});

/**
 * Funzione che elimina l'immagine selezionata
 * @param {type} id
 * @param {type} divId
 * @returns {undefined}
 */
function eliminaImg(id, divId) {
    $.ajax({
        type: "POST",
        url: "eliminaImgCat.php",
        data: "id=" + id,
        success: function (msg) {
            if (msg === '0') {
                Materialize.toast("Foto eliminata", 4000);
                $('#' + divId).toggle('display');
            } else
                Materialize.toast("Errore nell'eliminazione della foto", 4000);
        },
        error: function (msg) {
            Materialize.toast("Errore nell'eliminazione della foto", 4000);
        }
    });
}

/**
 * Funzione che setta come immagine predefinita quella selezionata
 * @param {type} id
 * @returns {undefined}
 *
function setDefault(id) {
    $.ajax({
        type: "POST",
        url: "setDefault.php",
        data: "id=" + id,
        success: function (msg) {
            if (msg !== '1') {
                Materialize.toast("Foto di default cambiata", 4000);
                $('#default_img').html("<img width='75%' src='../images/" + msg + "' class='responsive-img' />");
            } else
                Materialize.toast("Errore, foto di default non cambiata", 4000);
        },
        error: function (msg) {
            Materialize.toast("Errore, foto di default non cambiata", 4000);
        }
    });
}*/

/**
 * Funzione che elimina una slide delle news nella home
 * @param {type} id
 * @param {type} divId
 * @returns {undefined}
 */
function eliminaNews(id, divId) {
    $.ajax({
        type: "POST",
        url: "eliminaNews.php",
        data: "id=" + id,
        success: function (msg) {
            if (msg !== '1') {
                Materialize.toast("News eliminata", 4000);
                $('#' + divId).toggle('display');
            } else
                Materialize.toast("Errore, news non eliminata", 4000);
        },
        error: function (msg) {
            Materialize.toast("Errore, news non eliminata", 4000);
        }
    });
}