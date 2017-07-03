$(document).ready(function () {
    $('.parallax').parallax();
    
    $('.modal').modal();
    
    $('.carousel.carousel-slider').carousel({full_width: true, indicators: true});
    
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
        if ($(this).scrollTop() > 120) {
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
    
    // Calcolo se il negozio è ancora aperto
    var orarioOre = new Date($.now()).getHours();
    var orarioMin = new Date($.now()).getMinutes();

    if (orarioOre >= 9 && orarioOre <= 12) {
        if (orarioOre == 12 && orarioMin < 30)
            $('#orario').text("(ora aperto)");
        else
            $('#orario').text("(ora chiuso)");
    } else
        $('#orario').text("(ora chiuso)");

    if (orarioOre >= 15 && orarioOre <= 19) {
        $('#orario').text("(ora aperto)");
        if (orarioOre == 15 && orarioMin > 30)
            $('#orario').text("(ora aperto)");
        else
            $('#orario').text("(ora chiuso)");

        if (orarioOre == 19 && orarioMin < 30)
            $('#orario').text("(ora aperto)");
        else
            $('#orario').text("(ora chiuso)");
    }
    
    
    // cambio delle tab dei profotti
    $('.tab').on('click', function(){
        var id = $(this).children('a').attr('id');
    });
});

// funzione per la select delle categorie su mobile
$("#navigation").change(function () {
    document.location.href = $(this).val();
});

$(function () {
    // mail box
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

    // search box
    $('#search_form').submit(function (e) {
        e.preventDefault();

        // Get some values from elements on the page:
        var $form = $(this), key = $form.find("input[name='search']").val();
        if (!($.trim(key) === "")) {
            $('#content').addClass("hide");
            $('#loader').removeClass("hide");
            $('#textToChange1').text("Cerca: " + key);
            $('#textToChange2').text("Ricerca");
            $('#textToChange3').text("Torna ai prodotti");
            $('#textToChange3').attr("href", "prodotti.php");
            //Send the data using post
            var posting = $.post("search.php", {key: key});

            // Get the result
            posting.done(function (data) {
                $('#loader').addClass("hide");
                $('#content').removeClass("hide");
                $("#content").html(data);
            });
        }
    });
});

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
