$(document).ready(function(){
	// conteggio dei caratteri
	$('input, textarea').characterCounter();
	
	// inizializo le select
	$('select#categorieSelect, select#prodottiSelect').material_select();
	
	// aggiungo il listener per la select delle categorie
	$('#categorieSelect').on('change', function() {
		var idd = $(this).val();
		// Send the data using post
		var posting = $.post("controlPanel_getCategoria.php",{id : idd});
      
		// Get the result
		posting.done(function(data) {
			var myObj = JSON.parse(data);
			$('#nomeC').val(myObj.nome);
			$('#descrC').val(myObj.descrizione);
			$('#imgC').attr('src', '../images/' + myObj.immagine);
			$('#imageC').text(myObj.immagine);
			Materialize.updateTextFields();
		});
	});
	
	// lister per il caricamento dell'immagine delle categorie
	$("form[name='imgCategoriaUpload']").submit(function(e) {
        var formData = new FormData($(this)[0]);
        
        $.ajax({
            url: "controlPanel_uploadImageCat.php",
            type: "POST",
            data: formData,
            async: false,
            success: function (msg) {
                console.log(msg);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        e.preventDefault();
    });
	
	// listener per il bottone salva (categorie)
	$("#salvaCat").on('click', function(e) {
		$("form[name='imgCategoriaUpload']").submit();
		var n = $('#nomeC').val();
		var d = $('#descrC').val();
		
		// Send the data using post
		var posting = $.post("controlPanel_uploadCat.php",{nome : n, descr : d});
      
		// Get the result
		posting.done(function(data) {
			var myObj = JSON.parse(data);
			if (myObj.result)
				 Materialize.toast('Salvato con successo', 4000);
			else
				 Materialize.toast('Errore, non salvato', 4000)
		});
	});
	
	
	$("#panelControl_formUpload").on('submit',(function(e) {
		e.preventDefault();
		$("#image_holder").addClass("hide");
		$("#loaderImg").removeClass("hide");
		$.ajax({
        	url: "controlPanel_uploadImage.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
				console.log(data);
				// Carico le immagini
				var posting1 = $.post("controlPanel_viewImages.php",{id : idd});
			  
				// Get the result
				posting1.done(function(data) {
					$("#loaderImg").addClass("hide");
					$("#image_holder").html(data);
					$('.materialboxed').materialbox();
				});
		    },
		  	error: function() 
	    	{
				console.log(data);
	    	} 	        
	   });
	}));
	
	// aggiungo il listener per la select delle marche
	$('#prodottiSelect').on('change', function() {
		alert("ao");
		var idd = $(this).val();

		// Send the data using post
		var posting = $.post("controlPanel_viewProduct.php",{id : idd});
      
		// Get the result
		posting.done(function(data) {
			var myObj = JSON.parse(data);
			$("#nomeP").val(myObj.nome);
			$("#descrP").val(myObj.descr);
			Materialize.updateTextFields();
			
			// Carico le immagini
			var posting1 = $.post("controlPanel_viewImages.php",{id : idd});
		  
			// Get the result
			posting1.done(function(data) {
				$("#loaderImg").addClass("hide");
				$("#image_holder").html(data);
				$('.materialboxed').materialbox();
			});
		});
	});
});
