var catAttiva = 1;
$(document).ready(function () {
    // (prodotti.php) nascondo l'header e il container della ricerca
    $('#ricercaContainer').toggle('display');
    $('#headerRicerca').toggle('display');

    // (index.php) nascondo risultati dell'invio della mail
    $("#result_mail_success").toggle('display');
    $("#result_mail_failed").toggle('display');

    // (index.php) nascondo il form per loggare l'admin
    $("#cp_form").toggle('display');

    // effetto parallax delle immagini nella home
    $('.parallax').parallax();

    // slide delle foto nella home
    $('.slider').slider({height: 400, transition: 650, interval: 5000});

    // per la textarea del testo della mail
    $('textarea').characterCounter();

    $('.materialboxed').materialbox();

    $('.button-collapse').sideNav({
        menuWidth: 250, // Default is 240
        edge: 'left', // Choose the horizontal origin
        closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
    });

    // Dropdown della pagina dei prodotti
    $('.dropdown-button').dropdown({
        inDuration: 225,
        outDuration: 225,
        constrainWidth: true, // Does not change width of dropdown to that of the activator
        hover: true, // Activate on hover
        gutter: 0, // Spacing from edge
        belowOrigin: true, // Displays dropdown below the button
        alignment: 'left', // Displays dropdown with edge aligned to the left of button
        stopPropagation: false // Stops event propagation
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

    // Rendere visibile il form per il login da admin
    $("#cp_trigger").on('click', function () {
        $("#cp_form").toggle('display');
    });

    // Login come admin
    $('#cp_form').submit(function (e) {
        var u = $('#user').val().trim(),
                p = $('#pssw').val().trim();

        if (u.length === 0 || p.length === 0) {
            Materialize.toast("Completare tutti i campi.", 4000);
            e.preventDefault();
        }
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

    // Funzione per il cambio delle tab dei prodotti
    $('.tab').on('click', function () {
        var id = $(this).children('a').attr('id');
        loadProdotti(id);
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
                        s += "<div class='col l3 m4 s6'>";
                        if (obj[i].immagine === null || obj[i].immagine.length === 0)
                            s += "<div class='img' style=\"background-image:url('images/no_image.png');\"></div>";
                        else
                            s += "<div class='img' style=\"background-image:url('images/" + obj[i].immagine + "');\"></div>";

                        var nome = obj[i].nome.toLowerCase();
                        key = key.toLowerCase();
                        nome = nome.replace(key, "<mark>" + key + "</mark>");

                        s += "<p class='center-align' style='text-transform:capitalize;'>" + nome + "</p>" +
                                "<p class='grey-text-1 center-align'><i class='material-icons'>keyboard_arrow_right</i> " + obj[i].categoria.nome + "</p>" +
                                "</div>";
                    }
                    if (obj.length === 0) {
                        s += "<div class='col s12 center-aligned'>" +
                                "<p class='grey-text-1 lighten-2 center-align title-prodotti no-padd'>La ricerca non ha prodotto nessun risultato</p>" +
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

    if ($('#content').is(':visible')) {
        // Primo avvio della pagina (DA CAMBIARE)
        loadProdotti(1, 0);
    }

    $(document).keyup(function (e) {
        if (e.keyCode === 27 && $('#ricercaContainer').is(":visible")) {
            $('#ricercaClose').click();   // esc
        }
    });
});

/**
 * Funzione che carica i prodotti da far vedere
 * @param {type} id
 * @param {type} ordine
 * @returns {undefined}
 */
function loadProdotti(id, ordine) {
    catAttiva = id;
    $("#content").fadeOut('slow');
    $.ajax({
        type: "POST",
        url: "getProdotti.php",
        data: "id=" + id + "&ordine=" + ordine,
        success: function (msg) {
            var obj1 = JSON.parse(msg);
            var obj = obj1.lista;
            var cat = obj1.categoria;
            var noImageProd = new Array();
            var s = ""; // marche
            var v = ""; // marche senza foto
            var t = ""; // slide delle foto
            var c = ""; // lista delle foto per la visualizzazione da cellulare

            // marche
            for (var i = 0; i < obj.length; i++) {
                if (obj[i].immagine === null || obj[i].immagine.length === 0)
                    noImageProd.push(obj[i]);
                else
                    s += "<div class='logo-container img col l3 m4 s6' style=\"background-image:url('images/" + obj[i].immagine + "');\"></div>";
            }
            if (noImageProd.length > 0) {
                v = "<p class='title-prodotti'>E altre come: ";
                for (var i = 0; i < noImageProd.length; i++) {
                    if (noImageProd.length !== (i + 1))
                        v += noImageProd[i].nome + ", ";
                    else
                        v += noImageProd[i].nome;
                }
            }
            if (obj.length === 0) {
                s += "<div class='col s12 center-aligned'>" +
                        "<p class='grey-text center-align'>Nessun articolo presente</p>" +
                        "</div>";
            }

            // immagini 
            if (cat.fotos.length === 0) {
                t += "<div class='col s12 center-aligned'>" +
                        "<p class='grey-text center-align'>Nessuna foto presente</p>" +
                        "</div>";
            } else {
                t += "<div class='slider'><ul class='slides'>";
                for (var i = 0; i < cat.fotos.length; i++) {
                    t += "<li> " +
                            "<img src='images/" + cat.fotos[i].immagine + "' />" +
                            "</li>";
                    c += "<div class='col s12' style='margin-bottom: 8px;'><img class='responsive-img' src='images/" + cat.fotos[i].immagine + "' /></div>";
                }
                t += "</ul></div>";
            }

            // mostro tutto
            $('#catAttiva').text(cat.nome);
            $('#catAttivaDescr').text(cat.descrizione);
            $('#imageContent').html(t);
            $('#imageContentCell').html(c);
            $('#content').html(s);
            $('#content_noimage').html(v);
            $("#content").fadeIn('slow');
            $('.slider').slider({height: 550, transition: 650, interval: 10000});
        },
        error: function (msg) {
            console.log("Error: " + msg);
        }
    });
}

/**
 * Funzione per leggere un file locale
 * @param {type} file percorso del file
 * @returns {string} il testo del file
 */
function readTextFile(file) {
    $.ajax({
        type: "GET",
        url: file,
        success: function (msg) {
            var obj = JSON.parse(msg.toString());
            var orari = obj[obj.orario];
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
            if (!obj.ferie) {
                checkOrarioNegozio(orari);

                var interval = 60000; // 1 minuto
                setInterval(function () { // controllo sempre se è aperto o chiuso
                    checkOrarioNegozio(orari);
                }, interval);
            } else { //il negozio è chiuso per ferie
                if (!$('#orarioC').is(':visible'))
                    $('#orarioC').toggle('display');
                if ($('#orarioA').is(':visible'))
                    $('#orarioA').toggle('display');
                $('#orarioDiff').text('Il negozio è in ferie');
            }

            // stampo le stringhe nella pagina
            $('#tabellaOrari').html(s);
            $('#divOrari').html(v);
        },
        error: function (msg) {
            console.log("Error: " + msg);
        },
        cache: false
    });
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

/**
 * Funzione chiamata dal dropdown per ordinare le marche
 * @param {type} ordine
 * @returns {undefined}
 */
function reloadMarche(ordine) {
    loadProdotti(catAttiva, ordine);
}