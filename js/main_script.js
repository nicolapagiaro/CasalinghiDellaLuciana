$(document).ready(function () {
    // (prodotti.php) nascondo l'header e il container della ricerca
    $('#ricercaContainer').toggle('display');
    $('#headerRicerca').toggle('display');

    // (index.php) nascondo risultati dell'invio della mail
    $("#result_mail_success").toggle('display');
    $("#result_mail_failed").toggle('display');

    $('.parallax').parallax();

    $('.modal').modal();

    $('textarea').characterCounter();

    // intervallo per cambiare le immagini nella home
    var i = 1;
    var images = ['https://scontent-mxp1-1.xx.fbcdn.net/v/t1.0-9/20375966_1434634296618283_8575950060171263086_n.jpg?oh=a21a7c28328f3555c1fb137b9722cfe2&oe=59F808D7',
        'https://scontent-mxp1-1.xx.fbcdn.net/v/t1.0-9/19437508_1402673313147715_3952773638565462554_n.jpg?oh=975644b09312691d2397754a7ef659fb&oe=59F30739'];
    setInterval(function () {
        $('.grow').addClass('grow-animation');
        setTimeout(function(){
            if(i < images.length) {
                $('.grow').attr('src', images[i]);
                i++;
            }
            else if(i === images.length) {
                i=0;
                $('.grow').attr('src', images[i]);
                i++;
            }
            $('.grow').removeClass('grow-animation');
        }, 800);
    }, 15000);

    $('.materialboxed').materialbox();

    $('.button-collapse').sideNav({
        menuWidth: 250, // Default is 240
        edge: 'left', // Choose the horizontal origin
        closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
    }
    );

    //Check to see if the window is top if not then display button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.buttonScrollTop').fadeIn();
        } else {
            $('.buttonScrollTop').fadeOut();
        }
    });

    //Button scroll to top
    $('.buttonScrollTop').click(function () {
        $('html, body').animate({scrollTop: 0}, 500);
        return false;
    });

    // Invio della mail
    $('#mail_form').submit(function (e) {
        e.preventDefault();

        // Get some values from elements on the page:
        var $form = $(this), mail = $form.find("input[name='email']").val().trim(),
                msg = $form.find("textarea[name='text']").val().trim(), nome = $form.find("input[name='nome']").val().trim();

        if (mail.length === 0 || msg.length === 0 || nome.length === 0)
            Materialize.toast("Completare tutti i campi per l'invio della mail.", 4000)

        // Send the data using post
        var posting = $.post("send_mail.php", {email: mail, mailText: msg, nome: nome});

        // Get the result
        posting.done(function (data) {
            if (data === "1")
                if (!$('#result_mail_success').is(":visible"))
                    $("#result_mail_success").toggle('display');
                else
                if (!$('#result_mail_failed').is(":visible"))
                    $("#result_mail_failed").toggle('display');
            //
            setTimeout(function () {
                $form.find("input[name='email']").val("");
                $form.find("textarea[name='text']").val("");
                $form.find("input[name='nome']").val("");
                Materialize.updateTextFields();
                if ($('#result_mail_failed').is(":visible"))
                    $("#result_mail_failed").toggle('display');
                if ($('#result_mail_success').is(":visible"))
                    $("#result_mail_success").toggle('display');
            }, 5000);

        });
    });

    // Primo avvio della pagina (DA CAMBIARE)
    loadProdotti(1, "Infanzia");

    // Funzione per il cambio delle tab dei prodotti
    $('.tab').on('click', function () {
        var id = $(this).children('a').attr('id');
        var nome = $(this).children('a').text();
        loadProdotti(id, nome);
    });

    // Funzione per la ricerca di prodotti
    $('#search_form').submit(function (e) {
        e.preventDefault();

        // Get some values from elements on the page:
        var $form = $(this), key = $form.find("input[name='search']").val();
        if (!($.trim(key) === "")) {
            $.ajax({
                type: "POST",
                url: "search.php",
                data: "key=" + key,
                success: function (msg) {
                    var obj = JSON.parse(msg);
                    var s = "";
                    for (var i = 0; i < obj.length; i++) {
                        s += "<div class='col l4 m6 s12'>" +
                                "<div class='col s12 prodotti-container'>" +
                                "<div class='col l9 offset-l1 m9 offset-m1 s9 offset-s1'><img class='responsive-img' src='images/bruder1.jpg'/>" +
                                "</div><div class='col l12 m12 s12 center-align'>" +
                                "<br><span class='title-prodotti'>" + obj[i].nome + "</span>" +
                                "<p><i class='material-icons'>supervisor_account</i> 6-15 anni</p>" +
                                "<p class='grey-text-1 center-align'><i class='material-icons'>keyboard_arrow_right</i> " + obj[i].categoria.nome + "</p>" +
                                "<a onclick='loadDetails(" + obj[i].id + ")' style='text-decoration: underline;' href='#!'>Piu informazioni</a></div></div></div>";
                    }
                    if (obj.length === 0) {
                        s += "<div class='col s12 center-aligned'>" +
                                "<h5 class='grey-text-1 lighten-2 center-align'>La ricerca non ha prodotto nessun risultato</h5>" +
                                "</div>";
                    }
                    $('#ricercaText').text("Ricerca di \"" + key + "\"");
                    $('#ricercaContent').html(s);
                    if (!$('#ricercaContainer').is(":visible")) {
                        $('#ricercaContainer').toggle('display');
                        $('#headerRicerca').toggle('display');
                        $('#header').toggle('display');
                    }
                },
                error: function (msg) {
                    console.log("Error: " + msg);
                }
            });
        }
    });

    // funzione per la scomparsa del div con la ricerca
    $('#ricercaClose').on('click', function () {
        $('#headerRicerca').toggle('display');
        $('#header').toggle('display');
        $('#ricercaContainer').toggle('display');
        $('#ricerca').val("");
        Materialize.updateTextFields();
    });

    readTextFile("orari.txt");
});

/**
 * Funzione per la visualizzazione delle informazioni
 * su un prodotto cliccato
 * @param {type} id id del prodotto
 * @returns {undefined}
 */
function loadDetails(id) {
    $.ajax({
        type: "POST",
        url: "getProdDetails.php",
        data: "id=" + id,
        success: function (msg) {
            var obj = JSON.parse(msg);
            var s = "";
            for (var i = 0; i < obj.fotos.length; i++) {
                s += "<div class='col l3 m4 s12'>" +
                        "<img class='materialboxed responsive-img image-prod' src='images/" + obj.fotos[i].immagine + "'>" +
                        "</div>";
            }

            $('#nameProd').text(obj.nome);
            $('#descrProd').text(obj.descrizione);
            $('#etaProd').text(obj.eta);
            $('#fotoContainer').html(s);

            // mostro a schermo
            if (!$('#infoProdotto').is(':visible'))
                $('#infoProdotto').toggle('display');
            // muovo la pagina
            $('html, body').animate({
                scrollTop: $("#infoProdotto").offset().top
            }, 'slow');
            $('.materialboxed').materialbox();
        },
        error: function (msg) {
            console.log("Error: " + msg);
        }
    });
}

/**
 * Funzione per chiudere il div dei dettagli
 * @returns {undefined}
 */
function closeDetails() {
    $('#infoProdotto').toggle('display');
}

/**
 * Funzione che carica i prodotti da far vedere
 * @param {type} id id della categoria selezionata
 * @param {type} nome nome della categoria selezionata
 * @returns {undefined}
 */
function loadProdotti(id, nome) {
    $("#content").fadeOut('slow');
    if ($('#infoProdotto').is(':visible'))
        $('#infoProdotto').toggle('display');
    $.ajax({
        type: "POST",
        url: "getProdotti.php",
        data: "id=" + id,
        success: function (msg) {
            var obj1 = JSON.parse(msg);
            var obj = obj1.lista;
            var s = "";
            for (var i = 0; i < obj.length; i++) {
                s += "<div class='col l4 m6 s12'>" +
                        "<div class='col s12 prodotti-container'>" +
                        "<div class='col l9 offset-l1 m9 offset-m1 s9 offset-s1'><img class='responsive-img' src='images/bruder1.jpg'/>" +
                        "</div><div class='col l12 m12 s12 center align'>" +
                        "<br><p><span class='title-prodotti'>" + obj[i].nome + "</span></p>" +
                        "<p><i class='material-icons'>supervisor_account</i> 6-15 anni</p>" +
                        "<a onclick='loadDetails(" + obj[i].id + ")' style='text-decoration: underline;' href='#!'>Piu informazioni</a></div></div></div>";
            }
            if (obj.length === 0) {
                s += "<div class='col s12 center-aligned'>" +
                        "<h5 class='grey-text-1 lighten-2 center-align'>Nessun articolo presente</h5>" +
                        "</div>";
            }

            $('#catAttiva').text(obj1.nomeCat);
            $('#catAttivaDescr').text(obj1.descrCat);
            $('#content').html(s);
            $("#content").fadeIn('slow');
        },
        error: function (msg) {
            console.log("Error: " + msg);
        }
    });
}


/**
 * Cambio dell'immagine nella visualizzazione del prodotto
 * @param {type} $id id dell'immagine
 */
function changeImage($id) {
    $('.selected-image').addClass("unselected-image");
    $('.selected-image').removeClass("selected-image");
    $('#' + $id).addClass("selected-image");
    $('#' + $id).removeClass("unselected-image");
    var $image = $('#' + $id).attr('src');
    $('#imageBig').attr("src", $image);
}

/**
 * Funzione per leggere un file locale
 * @param {type} file percorso del file
 * @returns {string} il testo del file
 */
function readTextFile(file) {
    $.get(file, function (file) {
        var obj = JSON.parse(file.toString());
        var orari = obj.estate;
        var s = "";
        var v = "";
        for (var i = 0; i < orari.length; i++) {
            s += "<tr>" +
                    "<td>" + orari[i].giorno + "</td>" +
                    "<td>" + orari[i].mattina + "</td>" +
                    "<td>" + orari[i].pomeriggio + "</td>" +
                    "</tr>";
            v += "<p>" + orari[i].giorno + ": " + orari[i].mattina +
                    ", " + orari[i].pomeriggio + "</p>";
        }
        checkOrarioNegozio(orari);

        var interval = 60000; // 1 minuto
        setInterval(function () { // controllo sempre se è aperto o chiuso
            checkOrarioNegozio(orari);
        }, interval);

        // stampo le stringhe nella pagina
        $('#tabellaOrari').html(s);
        $('#divOrari').html(v);
    }
    );
}

/**
 * Funzione che verifica se il negozio è aperto e calcola
 * quanto manca che chiuda.
 * @param {type} orari array di orari del negozio
 * @returns {undefined} niente
 */
function checkOrarioNegozio(orari) {
    var d = new Date(),
            open = new Date(),
            closed = new Date();
    if (d.getDay() !== 0) {
        var orario = orari[d.getDay() - 1];
        if (d.getHours() < 13) { //mattina
            var o = orario.mattina.replace(" ", "").split("-");

            // Statically set UTC date for open
            open.setHours(o[0].split(":")[0]);
            open.setMinutes(o[0].split(":")[1]);
            open.setSeconds(0);
            open.setMilliseconds(0);

            // Statically Set  date for closing
            closed.setHours(o[1].split(":")[0]); // UTC hours is 0
            closed.setMinutes(o[1].split(":")[1]);
            closed.setSeconds(0);
            closed.setMilliseconds(0);

            // Test for store open?
            if (d > open && d < closed) {
                if ($('#orarioC').is(":visible"))
                    $('#orarioC').toggle('display');
                if (!$('#orarioA').is(':visible'))
                    $('#orarioA').toggle('display');
                $('#orarioDiff').text('Chiude fra ' + msToTime(Math.abs(closed - d)));
            } else {
                if (!$('#orarioC').is(':visible'))
                    $('#orarioC').toggle('display');
                if ($('#orarioA').is(':visible'))
                    $('#orarioA').toggle('display');

                // calcolo fra quanto riapre
                o = orario.pomeriggio.replace(" ", "").split("-");
                open = new Date();
                open.setHours(o[0].split(":")[0]);
                open.setMinutes(o[0].split(":")[1]);
                open.setSeconds(0);
                open.setMilliseconds(0);
                $('#orarioDiff').text('Apre fra ' + msToTime(Math.abs(open - d)));
            }
        } else { //pomeriggio
            var o = orario.pomeriggio.replace(" ", "").split("-");

            // Statically set UTC date for open
            open.setHours(o[0].split(":")[0]);
            open.setMinutes(o[0].split(":")[1]);
            open.setSeconds(0);
            open.setMilliseconds(0);

            // Statically Set UTC date for closing
            closed.setHours(o[1].split(":")[0]);
            closed.setMinutes(o[1].split(":")[1]);
            closed.setSeconds(0);
            closed.setMilliseconds(0);

            // Test for store open?
            if (d > open && d < closed) {
                if ($('#orarioC').is(':visible'))
                    $('#orarioC').toggle('display');
                if (!$('#orarioA').is(':visible'))
                    $('#orarioA').toggle('display');
                $('#orarioDiff').text('Chiude fra ' + msToTime(Math.abs(closed - d)));
            } else {
                if (!$('#orarioC').is(':visible'))
                    $('#orarioC').toggle('display');
                if ($('#orarioA').is(':visible'))
                    $('#orarioA').toggle('display');
                if (d < open) {
                    $('#orarioDiff').text('Apre fra ' + msToTime(Math.abs(open - d)));
                }
            }
        }
    } else {
        if (!$('#orarioC').is(':visible'))
            $('#orarioC').toggle('display');
        if ($('#orarioA').is(':visible'))
            $('#orarioA').toggle('display');
        $('#orarioDiff').text('Apre domani');
    }
}

/**
 * Funzione per vedere il nome del giorno dato
 * @param {type} i numero di giorno
 * @returns {String} nome del giorno
 */
function getDayName(i) {
    switch (i) {
        case 0:
            return "Domenica";
        case 1:
            return "Lunedì";
        case 2:
            return "Martedì";
        case 3:
            return "Mercoledì";
        case 4:
            return "Giovedì";
        case 5:
            return "Venerdì";
        case 6:
            return "Sabato";
        default:
            return "Errore";
    }
}

/**
 *
 * @param {type} duration
 * @returns {String}
 */
function msToTime(duration) {
    var milliseconds = parseInt((duration % 1000) / 100)
            , seconds = parseInt((duration / 1000) % 60)
            , minutes = parseInt((duration / (1000 * 60)) % 60)
            , hours = parseInt((duration / (1000 * 60 * 60)) % 24);
    var s = "";
    if (hours > 0) {
        if (hours === 1)
            s += hours + " ora";
        else
            s += hours + " ore";
    }
    if (minutes > 0) {
        if (hours > 0)
            s += " e ";
        if (minutes === 1)
            s += minutes + " minuto";
        else
            s += minutes + " minuti";
    }
    if (hours === 0 && minutes === 0)
        s += "poco";
    return s;
}