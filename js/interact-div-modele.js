console.log('# entrée dans le module interact-div-modele.js');

interact('.div-modele')
	
	.resizable({
		preserveAspectRatio	: false,
		edges				: { left: false, right: true, bottom: true, top: false },
		invert				: 'none', // reposition, none, negate
		restrict 			: { restriction: "parent", endonly: true } //elementRect: {left:0.25, right:0.25, top:0.25, bottom:0.25}
	})

	.dropzone({
		accept		: '.div-piece',
		  // Require a 75% element overlap for a drop to be possible
		 overlap	: 0.75
	})

	.on("resizestart", function(event){
		console.log('# événement resizestart déclenché');
		console.log('# événement resizestart terminé');
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
	})
	
	.on("resizeend", function(event){
		console.log('# événement resizeend déclenché');
		console.log('# événement resizeend terminé');
		console.log();
	})

	.on('dropactivate', function (event) {
    	//event.target.classList.add('drop-activated');
    	console.log('# événement drop-activate déclenché');
		console.log('# événement drop-activate terminé');
		console.log();
  	})

  	.on('dragenter', function (event) {
    	//event.target.classList.add('drop-activated');
    	console.log('# événement drop-dragenter déclenché');
		console.log('# événement drop-dragenter terminé');
		console.log();
  	})

  	.on('dragleave', function (event) {
    	//event.target.classList.add('drop-activated');
    	console.log('# événement drop-dragleave déclenché');
		console.log('# événement drop-dragleave terminé');
		console.log();
  	})

  	.on('dropmove', function (event) {
    	//event.target.classList.add('drop-activated');
    	console.log('# événement drop-move déclenché');
		console.log('# événement drop-move terminé');
		console.log();
  	})

  	.on('drop', function (event) {
    	//event.target.classList.add('drop-activated');
    	console.log('# événement drop- déclenché');
    	//$("#" + event.target.id).append( $("#" + event.relatedTarget.id) );
    	var piece = $(event.relatedTarget); //.detach();
    	var modele = $(event.target);
    	var target = event.target;

    	console.log('## y piece avant=' + piece.position().top);
    	console.log('## event.dragEvent.y0 avant=' + event.dragEvent.y0);
    	console.log('## data-y avant=' + target.getAttribute('data-y'));
    	//piece.position().top += modele.position().top + piece.height() + modele.height();
    	//alert('1');
    	console.log('>> .offset() avant .appendTo(): x=' + piece.offset().left + ' y=' + piece.offset().top );
    	var oldX = piece.offset().left;
    	var oldY = piece.offset().top;
    	piece.appendTo(modele);
    	piece.offset({ top: oldY, left: oldX });
    	console.log('>> .offset() après .appendTo(): x=' + piece.offset().left + ' y=' + piece.offset().top );
    	
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
    	 	
    	console.log('## y piece après=' + piece.position().top);
    	console.log('## event.dragEvent.y0 après=' + event.dragEvent.y0);
    	console.log('## data-y après=' + target.getAttribute('data-y'));
		console.log('# événement drop- terminé');
		console.log();
  	})

  	.on('dropdeactivate', function (event) {
    	//event.target.classList.add('drop-activated');
    	console.log('# événement drop-deactivate déclenché');
		console.log('# événement drop-deactivate terminé');
		console.log();
  	})

;

console.log('# sortie du module interact-div-modele.js');
