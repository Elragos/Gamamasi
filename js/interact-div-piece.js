console.log('# entrée dans le module interact-div-piece.js');

interact('.div-piece')

	.draggable({
		inertia		: true,
		autoScroll	: true,
		restrict	:	{
							restriction	: ".div-modele",
							endOnly		: true,
							elementRect	: { top: 0, left: 0, bottom: 1, right: 1 }
						}
	})
	
	.resizable({
		preserveAspectRatio	: false,
		edges				: { left: true, right: true, bottom: true, top: true },
		invert	: 'none', // reposition, none, negate
		restrict: {
				restriction: ".div-modele",
				endonly: true,
				//container: "parent"
				//elementRect: {left:0.25, right:0.25, top:0.25, bottom:0.25}
			  }
	})

	.dropzone({
		accept		: '.div-table',
		  // Require a 75% element overlap for a drop to be possible
		 overlap	: 0.75
	})

	.on("resizestart", function(event){
		console.log('# événement resizestart déclenché');
		console.log('# événement resizestart terminé');
		console.log();
	})

	.on("resizemove", function (event){
		console.log('## événement resizemove déclenché');
		var target 	= event.target;
		var	x 		= (parseFloat(target.getAttribute('data-x')) || 0);
		var y 		= (parseFloat(target.getAttribute('data-y')) || 0);
		// update the element's style
		target.style.width  = event.rect.width + 'px';
		console.log(event.rect.left+event.rect.width);
		//target.style.width = event.rect.left+event.rect.width > 800 ? '800px' : event.rect.left+event.rect.width + 'px';
		target.style.height = event.rect.height + 'px';
		// translate when resizing from top or left edges
		x += event.deltaRect.left;
		y += event.deltaRect.top;
		target.style.webkitTransform = target.style.transform = 'translate(' + x + 'px,' + y + 'px)';
		target.setAttribute('data-x', x);
		target.setAttribute('data-y', y);
		
		
		/*var p 			= $("#container");
		var position 	= p.position();
		var el_largeur 	= Math.round(event.rect.width);
		var el_hauteur 	= Math.round(event.rect.height);
		//var el_x 		= Math.round(event.rect.left - position.left);
		//var el_y 		= Math.round(event.rect.top - position.top);
		var el_x 		= Math.round(event.rect.left);
		var el_y 		= Math.round(event.rect.top);
		
		target.textContent = el_largeur + '×' + el_hauteur + ' # x:' + el_x + ', y:' + el_y;*/
		console.log('## événement resizemove terminé');
		console.log();
	})
	
	.on("resizeend", function(event){
		console.log('# événement resizeend déclenché');
		console.log('# événement resizeend terminé');
		console.log();
	})

	.on("dragstart", function (event){
		console.log('# événement dragstart déclenché sur une pièce');
		/*var target = $(event.target);
		target.addClass("dragging");*/
		console.log('# événement dragstart terminé sur une pièce');
		console.log();
	})

	.on("dragmove", function (event){
		console.log('# événement dragmove déclenché sur une pièce');
		/*var target = $(event.target);
		target.addClass("dragging");*/

		var target = event.target,
        // keep the dragged position in the data-x/data-y attributes
        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

        console.log('## x=' + x);
        console.log('## data-x=' + target.getAttribute('data-x'));
        console.log('## dx=' + event.dx);
        console.log('## y=' + y);
        console.log('## data-y=' + target.getAttribute('data-y'));
        console.log('## dy=' + event.dy);

        console.log(event);

	    // translate the element
	    target.style.webkitTransform = target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';

	    // update the posiion attributes
	    target.setAttribute('data-x', x);
	    target.setAttribute('data-y', y);

		console.log('# événement dragmove terminé sur une pièce');
		console.log();
	})

	.on('drop', function (event) {
		alert('');
		console.log('# événement drop- déclenché');
    	//$("#" + event.target.id).append( $("#" + event.relatedTarget.id) );
    	var piece = $(event.relatedTarget); //.detach();
    	var modele = $(event.target);
    	var target = event.target;

    	/*console.log('## y piece avant=' + piece.position().top);
    	console.log('## event.dragEvent.y0 avant=' + event.dragEvent.y0);
    	console.log('## data-y avant=' + target.getAttribute('data-y'));*/
    	//piece.position().top += modele.position().top + piece.height() + modele.height();
    	//alert('1');
    	//console.log('>> .offset() avant .appendTo(): x=' + piece.offset().left + ' y=' + piece.offset().top );
    	var oldX = piece.offset().left;
    	var oldY = piece.offset().top;
    	piece.appendTo(modele);
    	piece.offset({ top: oldY, left: oldX });
    	//console.log('>> .offset() après .appendTo(): x=' + piece.offset().left + ' y=' + piece.offset().top );
    	
    	/*alert(event.dy);
    	piece.offset({
    			top	: modele.position().top + 0,
    			left: modele.position().left + 0
    	});  alert(event.dy); */
    	/*piece.css({
            position: 'absolute',
            //zIndex: 5000,
            left: 20,
            top: 20
        });*/
    	 	
    	/*console.log('## y piece après=' + piece.position().top);
    	console.log('## event.dragEvent.y0 après=' + event.dragEvent.y0);
    	console.log('## data-y après=' + target.getAttribute('data-y'));*/
		console.log('# événement drop- terminé');
		console.log();
	})

	.on("dragend", function (event){
		console.log('# événement dragend déclenché sur une pièce');
		/*var target = $(event.target);
		target.addClass("dragging");*/
		//console.log('## event.target.id=' + $(event.target).parent().attr('id'));
		//console.log('## event.relatedTarget.id=' + event.relatedTarget);
		$(event.target).position().top = 0;
		$(event.target).position().left = 0;
		console.log('# événement dragend terminé sur une pièce');
		console.log();
	})

;

console.log('# sortie du module interact-div-piece.js');
console.log();