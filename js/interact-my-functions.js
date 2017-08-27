//alert('entréé dans my_interact.js');

// modèle ---------------------------------------------------
interact('.div-modele')
	
	.dropzone({
		accept: '.div-piece',
		  // Require a 75% element overlap for a drop to be possible
		 overlap: 0.75,
		 ondropactivate: function (event) {
    // add active dropzone feedback
    event.target.classList.add('drop-active');
  },
  ondragenter: function (event) {
    var draggableElement = event.relatedTarget,
        dropzoneElement = event.target;

    // feedback the possibility of a drop
    dropzoneElement.classList.add('drop-target');
    draggableElement.classList.add('can-drop');
    //draggableElement.textContent = 'Dragged in';
  },
  ondragleave: function (event) {
    // remove the drop feedback style
    event.target.classList.remove('drop-target');
    event.relatedTarget.classList.remove('can-drop');
    //event.relatedTarget.textContent = 'Dragged out';
  },
  ondrop: function (event) {
    //event.relatedTarget.textContent = 'Dropped';
    //alert(event.target.id);
    //alert(event.relatedTarget.id);
    //$(this).appendTo($("#"+event.target.id));
    $("#" + event.target.id).append( $("#" + event.relatedTarget.id) );

  },
  ondropdeactivate: function (event) {
    // remove active dropzone feedback
    event.target.classList.remove('drop-active');
    event.target.classList.remove('drop-target');
  }
  })

	.resizable({
		preserveAspectRatio	: false,
		edges				: { left: false, right: true, bottom: true, top: false },
		invert	: 'none', // reposition, none, negate
		restrict: {
				restriction: "parent",
				endonly: true
				//elementRect: {left:0.25, right:0.25, top:0.25, bottom:0.25}
			  }
	})
  
	.on("resizemove", function (event){
		var target = event.target,
			x = (parseFloat(target.getAttribute('data-x')) || 0),
			y = (parseFloat(target.getAttribute('data-y')) || 0);
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
		
	})
	
	.on("dragstart", function (event){
		//var target = $(event.target);
		//target.addClass("dragging");
	})
	
	.on("dragend", function (event){
		//var target = $(event.target);
		//target.removeClass("dragging");
		//$("#element_courant").text( target.attr('id') );
	})



interact('.div-piece')

	.draggable({
		inertia		: true,
		autoScroll	: true,
		onmove		: dragMoveListener,
		restrict	:	{
							restriction	: "parent",
							endOnly		: true,
							elementRect	: { top: 0, left: 0, bottom: 1, right: 1 }
						}/*,
		onend		:	function (event){
							var textEl = event.target.querySelector('p');
							textEl && (textEl.textContent = 'moved a distance of ' + (Math.sqrt(event.dx * event.dx + event.dy * event.dy)|0) + 'px');
						}*/
	})
	
	.resizable({
		preserveAspectRatio	: false,
		edges				: { left: true, right: true, bottom: true, top: true },
		invert	: 'none', // reposition, none, negate
		restrict: {
				restriction: "parent",
				endonly: true
				//elementRect: {left:0.25, right:0.25, top:0.25, bottom:0.25}
			  }
	})
  
	.on("resizemove", function (event){
		var target = event.target;

		//var t = $(event.target);
		//$("#coord").text( t.position().top + ' ' + t.position().left );

		var x = (parseFloat(target.getAttribute('data-x')) || 0);
		var y = (parseFloat(target.getAttribute('data-y')) || 0);
		// update the element's style
		target.style.width  = event.rect.width + 'px';
		target.style.height = event.rect.height + 'px';
		$("#coord").text(x + ' ' + y + ' ' + event.rect.width + ' ' + event.rect.height + ' ' + event.deltaRect.left + ' ' + event.deltaRect.top);
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
		
	})
	
	.on("dragstart", function (event){
		/*var target = $(event.target);
		target.addClass("dragging");*/
	})
	
	.on("dragend", function(event){
		var target = event.target,
	        // keep the dragged position in the data-x/data-y attributes
	        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
	        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
        //alert('coucou');

	    // translate the element
	    target.style.webkitTransform = target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
	    // update the posiion attributes
	    target.setAttribute('data-x', x);
	    target.setAttribute('data-y', y);
	})

	.on("dragmove", function(event){
		var t = $(event.target);
		$("#coord").text( t.position().top + ' ' + t.position().left );
	})
	


interact('.div-table')

	.draggable({
		inertia		: true,
		autoScroll	: true,
		onmove		: dragMoveListener,
		restrict	:	{
							restriction	: "parent",
							endOnly		: true,
							elementRect	: { top: 0, left: 0, bottom: 1, right: 1 }
						}/*,
		onend		:	function (event){
							var textEl = event.target.querySelector('p');
							textEl && (textEl.textContent = 'moved a distance of ' + (Math.sqrt(event.dx * event.dx + event.dy * event.dy)|0) + 'px');
						}*/
	})
	
	.resizable({
		preserveAspectRatio	: false,
		edges				: { left: true, right: true, bottom: true, top: true },
		invert	: 'none', // reposition, none, negate
		restrict: {
				restriction: "parent",
				endonly: true
				//elementRect: {left:0.25, right:0.25, top:0.25, bottom:0.25}
			  }
	})
  
	.on("resizemove", function (event){
		var target = event.target,
			x = (parseFloat(target.getAttribute('data-x')) || 0),
			y = (parseFloat(target.getAttribute('data-y')) || 0);
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
		
	})
	
	.on("dragstart", function (event){
		/*var target = $(event.target);
		target.addClass("dragging");*/
	})
	
	.on("dragend", function (event){
		/*ar target = $(event.target);
		target.removeClass("dragging");
		$("#element_courant").text( target.attr('id') );*/
	})






function dragMoveListener (event) {
	var target = event.target,
        // keep the dragged position in the data-x/data-y attributes
        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
    // translate the element
    target.style.webkitTransform = target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
    // update the posiion attributes
    target.setAttribute('data-x', x);
    target.setAttribute('data-y', y);
}
// this is used later in the resizing and gesture demos
//window.dragMoveListener = dragMoveListener;



interact('.draggable')
  .draggable({
    // enable inertial throwing
    inertia: true,
    // keep the element within the area of it's parent
    restrict: {
      restriction: "parent",
      endOnly: true,
      elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
    },
    // enable autoScroll
    autoScroll: true,

    // call this function on every dragmove event
    onmove: dragMoveListener,
    // call this function on every dragend event
    onend: function (event) {
      var textEl = event.target.querySelector('p');

      textEl && (textEl.textContent =
        'moved a distance of '
        + (Math.sqrt(event.dx * event.dx +
                     event.dy * event.dy)|0) + 'px');
    }
  });





