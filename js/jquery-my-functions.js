// ----- début
console.log('# entrée dans le module jquery-my-functions.js');


// ----- création d'un modèle
$("#btn_creer_modele").click(function(){
	console.log('# événement click déclenché pour le bouton ajouter un modèle');
	var modele_id = new Date().getTime();
	var modele_intitule = prompt("intitulé du modèle", "modèle du " + modele_id);
	if (modele_intitule != null){
		var modele_html = "<div class='div-modele' id='modele_" + modele_id + "' data-intitule='" + modele_intitule + "'><span class='label label-default titre_element' id='modele_intitule_" + modele_id + "'></span></div>";
		var modele_obj = $(modele_html).appendTo($(this).parent());
		$("#modele_intitule_" + modele_id)
			.text(modele_intitule)
			.on("dblclick", function(ev){
				var res = prompt("modifier l'intitulé:");
				//console.log(res);
				if ((res != null) && (res)) $(ev.target).text(res);
				ev.stopImmediatePropagation();
			})
		;
		modele_obj.on("dblclick", function(ev){
			if($(ev.target).hasClass("div-modele")){
				if (confirm("Supprimer le modele (ainsi que tous ses éléments) ?")){
					modele_obj.remove();
					//$("#modele_intitule").text('');
				}
			}
		});
	}
	console.log('# événement click terminé pour le bouton ajouter un modèle');
});



// ----- création d'une pièce
$("#btn_creer_piece").click(function(){
	console.log('# événement click déclenché pour le bouton ajouter une pièce');
	var piece_id = new Date().getTime();
	var piece_intitule = prompt("intitulé de la pièce", "pièce du " + piece_id);
	var piece_html = "<div class='div-piece draggable drag-drop' id='piece_" + piece_id + "' data-intitule='" + piece_intitule + "'><span class='label label-default titre_element' id='piece_intitule_" + piece_id + "'>test</span></div>";  
	console.log("#piece_intitule_" + piece_id);
	var piece_obj = $(piece_html).appendTo($(this).parent());
	$("#piece_intitule_" + piece_id).text(piece_intitule);
	piece_obj.on("dblclick", function(ev){
		if($(ev.target).hasClass("div-piece")){
			if (confirm("Supprimer la pièce (ainsi que ses éléments) ?")){
				piece_obj.remove();
			}
		}
		//ev.stopImmediatePropagation();
	});
	console.log('# événement click terminé pour le bouton ajouter une pièce');
});



// ----- création d'une table
$("#btn_creer_table").click(function(event){
	console.log('# événement click déclenché pour le bouton ajouter une table');
	var table_id = new Date().getTime();
	var table_html = "<div class='div-table draggable drag-drop' id='table_" + table_id + "'></div>";
	var table_obj = $(table_html).appendTo($(this).parent());
	table_obj.on("dblclick", function(ev){
		if($(ev.target).hasClass("div-table")){
			if (confirm("Supprimer la table ?")){
				table_obj.remove();
			}
		}
		//ev.stopImmediatePropagation();
	});
	console.log('# événement click terminé pour le bouton ajouter une table');
});


// ----- enregistrement du modèle en base
$("#btn_enregistrer_modele").click(function(){
	var id, left, top, width, height;
	var XMLString = "";
	$(".div-modele").each(function(i, el){ // parcours des modèles
		id 		= $(this).attr("id");
		intitule = $(this).attr("data-intitule");
		left 	= Math.round($(this).position().left);
		top		= Math.round($(this).position().top);
		width	= Math.round($(this).width());
		height	= Math.round($(this).height());
		XMLString += "<modele id='" + id + "' intitule='" + intitule + "' left='" + left + "' top='" + top + "' width='" + width + "' height='" + height + "'>";
		$(el).children(".div-piece").each(function(i2, el2){ // parcours des pièces
			id 		= $(this).attr("id");
			intitule = $(this).attr("data-intitule");
			left 	= Math.round($(this).position().left);
			top		= Math.round($(this).position().top);
			width	= Math.round($(this).width());
			height	= Math.round($(this).height());
			XMLString += "<piece id='" + id + "' intitule='" + intitule + "' left='" + left + "' top='" + top + "' width='" + width + "' height='" + height + "'>";
			$(el2).children(".div-table").each(function(i3, el3){ // parcours des tables
				id 		= $(this).attr("id");
				left 	= Math.round($(this).position().left);
				top		= Math.round($(this).position().top);
				width	= Math.round($(this).width());
				height	= Math.round($(this).height());
				XMLString += "<table id='" + id + "' left='" + left + "' top='" + top + "' width='" + width + "' height='" + height + "'/>";
			});
			XMLString += "</piece>";
		});
		XMLString += "</modele>";		
	});
	console.log(XMLString);
});

// ----- fin
console.log('# sortie du module jquery-my-functions.js');
