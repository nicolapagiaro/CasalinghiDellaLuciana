var orariObj = '';

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
     */
    // aggiungo il listener per mostrare le informazioni delle marche per modificarle
    $('#marcheSelect').on('change', function () {
        var idd = $(this).val();
        $.ajax({
            type: "POST",
            url: "getProdDetails.php",
            data: "id=" + idd,
            success: function (msg) {
                var obj = JSON.parse(msg);
                if (obj.immagine === null || obj.immagine.length === 0)
                    $('#default_img').html("<img width='65%' class='responsive-img' src='../images/no_image.png'>");
                else
                    $('#default_img').html("<img width='65%' src='../images/" + obj.immagine + "' class='responsive-img' />");
            },
            error: function (msg) {
                console.log("Error: " + msg);
            }
        });
    });

    // listener per il bottone di salvataggio delle modifiche di una marca
    $('#submit_btn1').on('click', function () {
        var formData = new FormData();
        formData.append('userImageProd', $('#userImageProd')[0].files[0]);
        $('#load_marca, #submit_btn1').toggle('display');
        $.ajax({
            type: "POST",
            url: "salvaProd.php",
            data: formData,
            success: function (msg) {
                $('#load_marca, #submit_btn1').toggle('display');
                if (msg === '0')
                    Materialize.toast("Modifiche salvate", 4000);
                else
                    Materialize.toast("Errore nel salvataggio delle modifiche", 4000);
            },
            error: function (msg) {
                $('#load_marca, #submit_btn1').toggle('display');
                Materialize.toast("Errore nel salvataggio delle modifiche", 4000);
            },
            cache: false,
            contentType: false,
            processData: false
        });
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
    $("#userImage").on('change', function (e) {
        var formData = new FormData();
        formData.append('userImage', $('#userImage')[0].files[0]);
        $('#load_details').toggle('display');
        $.ajax({
            url: "controlPanel_uploadImage.php",
            type: "POST",
            data: formData,
            success: function (msg) {
                $('#load_details').toggle('display');
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
                $('#load_details').toggle('display');
                Materialize.toast("Errore nel caricamento della foto", 4000);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        e.preventDefault();
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
                descrC = $('#descrC').val();
        $('#load_cat, #submit_btn2').toggle('display');
        $.ajax({
            type: "POST",
            url: "salvaCat.php",
            data: "nome=" + nomeC + "&descr=" + descrC,
            success: function (msg) {
                $('#load_cat, #submit_btn2').toggle('display');
                if (msg === '0')
                    Materialize.toast("Modifiche salvate", 4000);
                else
                    Materialize.toast("Errore nel salvataggio delle modifiche", 4000);
            },
            error: function (msg) {
                $('#load_cat, #submit_btn2').toggle('display');
                Materialize.toast("Errore nel salvataggio delle modifiche", 4000);
            }
        });
    });

    /** 
     * SEZIONE NEWS 
     */
    // listener per il bottone di salvataggio della nuova news
    $('#submit_btn3').on('click', function () {
        var titolo = $('#titoloN').val(),
                descr = $('#descrN').val(),
                color = $('input[name=colorT]:checked').attr('id'),
                dataI = $('#dataI').val(),
                dataF = $('#dataF').val();
        var formData = new FormData();
        formData.append('userImageN', $('#userImageN')[0].files[0]);
        formData.append('titolo', titolo);
        formData.append('descr', descr);
        formData.append('color', color);
        formData.append('dataI', dataI);
        formData.append('dataF', dataF);


        if (dataI > dataF) {
            Materialize.toast("La data di inizio non può essere più grande della data di fine", 4000);
        } else {
            $('#load_news, #submit_btn3').toggle('display');
            $.ajax({
                type: "POST",
                url: "salvaNews.php",
                data: formData,
                success: function (msg) {
                    $('#load_news, #submit_btn3').toggle('display');
                    if (msg !== '1') {
                        Materialize.toast("Modifiche salvate", 4000);
                        location.reload();
                    } else
                        Materialize.toast("Errore nel salvataggio delle modifiche", 4000);
                },
                error: function (msg) {
                    $('#load_news, #submit_btn3').toggle('display');
                    Materialize.toast("Errore nel salvataggio delle modifiche", 4000);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });

    // listener per cambiare il testo a seconda del testo immesso
    $('#titoloN').keyup(function () {
        $('#titlePreview').text($('#titoloN').val());
    });

    // listener per cambiare il testo a seconda del testo immesso
    $('#descrN').keyup(function () {
        $('#descrPreview').text($('#descrN').val());
    });

    // Listener per cambiare colore alle scritte
    $('input[type=radio]').on('click', function () {
        var color = $('input[name=colorT]:checked').attr('id');
        $('#titlePreview, #descrPreview').removeClass();
        $('#titlePreview, #descrPreview').addClass(color);
    });

    /**
     * SEZIONE ORARI E FERIE
     */
    // listener per il bottone di salvataggio degli orari e ferie
    $('#submit_btn4').on('click', function (e) {
        e.preventDefault();
        $('#load_orari, #submit_btn4').toggle('display');
        var o = $('input[name=orario]:checked').attr('id'),
                ferie = $('#ferie').is(':checked');

        orariObj['orario'] = o;
        orariObj['ferie'] = ferie;

        $.ajax({
            type: "POST",
            url: "salvaOrari.php",
            data: 'orari=' + JSON.stringify(orariObj),
            success: function (msg) {
                console.log(msg);
                $('#load_orari, #submit_btn4').toggle('display');
                if (msg !== '1') {
                    Materialize.toast("Modifiche salvate", 4000);
                } else
                    Materialize.toast("Errore nel salvataggio delle modifiche", 4000);
            },
            error: function (msg) {
                console.log('Error' + msg);
                $('#load_orari, #submit_btn4').toggle('display');
                Materialize.toast("Errore nel salvataggio delle modifiche", 4000);
            }
        });
    });
    // carico gli orari
    caricaOrari('../orari.txt');
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

/**
 * Funzione che legge l'immagine e la mostra e rende visibili le scritte
 * @param {type} input
 * @returns {undefined}
 */
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function () {
            $('#preview').attr('src', reader.result);
            if (!$('#titlePreview').is(':visible')) {
                $('#titlePreview, #descrPreview').toggle('display');
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
}

/**
 * Funzione che legge l'immagine e la mostra delle marche
 * @param {type} input
 * @returns {undefined}
 */
function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function () {
            $('#default_img').html("<img width='65%' src='" + reader.result + "' class='responsive-img' />");
        };

        reader.readAsDataURL(input.files[0]);
    }
}

/**
 * Funzione per leggere un file locale
 * @param {type} file percorso del file
 * @returns {string} il testo del file
 */
function caricaOrari(file) {
    $.ajax({
        type: "GET",
        url: file,
        success: function (msg) {
            var obj = JSON.parse(msg.toString());
            orariObj = obj;
            var orariI = obj['inverno'];
            var orariE = obj['estate'];
            var oI = "";
            var oE = "";
            for (var i = 0; i < orariI.length; i++) {
                oI += "<tr>" +
                        "<td>" + orariI[i].giorno + "</td>" +
                        "<td>" + orariI[i].mattina + "</td>" +
                        "<td>" + orariI[i].pomeriggio + "</td>" +
                        "</tr>";
                oE += "<tr>" +
                        "<td>" + orariE[i].giorno + "</td>" +
                        "<td>" + orariE[i].mattina + "</td>" +
                        "<td>" + orariE[i].pomeriggio + "</td>" +
                        "</tr>";
            }

            // stampo le stringhe nella pagina
            $('#cp_orari_i').html(oI);
            $('#cp_orari_e').html(oE);

            // checko il radio attivo
            var oAttivo = obj['orario'];
            $('input[id=' + oAttivo + ']').prop('checked', true);

            // controllo se il negozio è in ferie
            $('#ferie').prop('checked', obj.ferie);
        },
        error: function (msg) {
            console.log("Error: " + msg);
        },
        cache: false
    });
}