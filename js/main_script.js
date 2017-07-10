$(document).ready(function () {
    // (prodotti.php) nascondo l'header e il container della ricerca
    $('#ricercaContainer').toggle('display');
    $('#headerRicerca').toggle('display');

    $('.parallax').parallax();

    $('.modal').modal();

    $('textarea#textarea1').characterCounter();

    setInterval(function () {
        $('.carousel').carousel('next');
    }, 7000);

    $('.materialboxed').materialbox();

    $('.button-collapse').sideNav({
        menuWidth: 250, // Default is 240
        edge: 'left', // Choose the horizontal origin
        closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
    }
    );

    //Check to see if the window is top if not then display button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {
            $('.buttonScrollTop').fadeIn();
        } else {
            $('.buttonScrollTop').fadeOut();
        }
    });
    $('select').material_select();


    //Button scroll to top
    $('.buttonScrollTop').click(function () {
        $('html, body').animate({scrollTop: 0}, 500);
        return false;
    });

    // Invio della mail
    $('#mail_form').submit(function (e) {
        e.preventDefault();

        // Get some values from elements on the page:
        var $form = $(this), mail = $form.find("input[name='email']").val(),
                msg = $form.find("textarea[name='text']").val(), nome = $form.find("input[name='nome']").val();

        // Send the data using post
        var posting = $.post("send_mail.php", {email: mail, mailText: msg, nome: nome});

        // Get the result
        posting.done(function (data) {
            if (data === "1") {
                $("#result_mail").text("Mail inviata");
            } else
                $("#result_mail").text("Mail non inviata");
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
                                "<div class='col l9 offset-l1'><img class='responsive-img' src='images/bruder1.jpg'/>" +
                                "</div><div class='col l12 center align'>" +
                                "<br><span class='title-prodotti'>" + obj[i].nome + "</span>" +
                                "<p class='grey-text-1 center-align'>" + obj[i].categoria.nome + "</p>" +
                                "<a href='viewItem.php?prod=" + obj[i].id + "'>Piu informazioni</a></div></div></div>";
                    }
                    if (obj.length === 0) {
                        s += "<div class='col s12 center-aligned'>" +
                                "<h5 class='grey-text-1 lighten-2 center-align'>Nessun articolo presente</h5>" +
                                "</div>";
                    }
                    $('#ricercaText').text("Ricerca di \"" + key + "\"");
                    $('#ricercaContent').html(s);
                    if (!$('#ricercaContainer').is(":visible")) {
                        $('#ricercaContainer').toggle('display');
                        $('#headerRicerca').toggle('display');
                        $('#header').toggle('display');
                    }

                    /* muovo la pagina
                     $('html, body').animate({
                     scrollTop: $("#ricercaContainer").offset().top
                     }, 'slow');*/
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

    readTextFile("http://localhost/CasalinghiDallaLucianaProject/orari.txt");
});

/* funzione per la select delle categorie su mobile
 $("#navigation").change(function () {
 document.location.href = $(this).val();
 });*/

/**
 * Funzione che carica i prodotti da far vedere
 * @param {type} id id della categoria selezionata
 * @param {type} nome nome della categoria selezionata
 * @returns {undefined}
 */
function loadProdotti(id, nome) {
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
                        "<div class='col l9 offset-l1'><img class='responsive-img' src='images/bruder1.jpg'/>" +
                        "</div><div class='col l12 center align'>" +
                        "<br><p><span class='title-prodotti'>" + obj[i].nome + "</span></p>" +
                        "<a href='viewItem.php?prod=" + obj[i].id + "'>Piu informazioni</a></div></div></div>";
            }
            if (obj.length === 0) {
                s += "<div class='col s12 center-aligned'>" +
                        "<h5 class='grey-text-1 lighten-2 center-align'>Nessun articolo presente</h5>" +
                        "</div>";
            }

            $('#content').html(s);
            $('#catAttiva').text(obj1.nomeCat);
            $('#catAttivaDescr').text(obj1.descrCat);
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
        var checked = false;
        var obj = JSON.parse(file.toString());
        var orari = obj.estate;
        var s = "";
        for (var i = 0; i < orari.length; i++) {
            s += "<tr>" +
                    "<td>" + orari[i].giorno + "</td>" +
                    "<td>" + orari[i].mattina + "</td>" +
                    "<td>" + orari[i].pomeriggio + "</td>" +
                    "</tr>";
        }
        // verifico se il negozio è aperto ora
        var curDate = new Date();
        for (var i = 0; i < orari.length; i++) {
            if (orari[i].giorno === getDayName(curDate.getDay())) {
                checked = true;
            } else {
                $('#orario').text("- chiuso ora");
            }
        }
        $('#tabellaOrari').html(s);
    });
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