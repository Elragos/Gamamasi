console.log('>> entrée dans le module');

interact('.div-table')

	.draggable({
		inertia		: true,
		autoScroll	: true,
		//onmove		: dragMoveListener,
		restrict	:	{
							restriction	: ".div-piece",
							endOnly		: true,
							elementRect	: { top: 0, left: 0, bottom: 1, right: 1 }
						}
	})
	
	.resizable({
		preserveAspectRatio	: false,
		edges				: { left: true, right: true, bottom: true, top: true },
		invert	: 'none', // reposition, none, negate
		restrict: {
				restriction: ".div-piece",
				endonly: true
				//elementRect: {left:0.25, right:0.25, top:0.25, bottom:0.25}
			  }
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
	    target.style.webkitTransform =
	    target.style.transform =
	      'translate(' + x + 'px, ' + y + 'px)';

	    // update the posiion attributes
	    target.setAttribute('data-x', x);
	    target.setAttribute('data-y', y);

		console.log('# événement dragmove terminé sur une pièce');
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

console.log('>> sortie du module');