$(document).ready(function(){

	var content=document.getElementById('slidesContainer');

	console.log(page.length);
	if (page.length!=0){


		//Configuration
		
		var currentPosition = 0;
		var tempsTransition = 2000;
		var slideWidth = screen.width;
		var slides = $('.slide');
		var hauteur = window.innerHeight;
		hauteur = hauteur

		createPage(content, page[currentPosition][3], page[currentPosition][1], page[currentPosition][0]);

		// Supprime la scrollbar en JS
	  	$('#slidesContainer').css('overflow', 'hidden');

	  	//Définition des tailles en fonction du navigateur
	  	$('#slidesContainer').css({
	  		'width': window.innerWidth,
	  		'height': hauteur
	  	});


	  	$('#slideshow').css({
	  		'width': window.innerWidth,
	  		'height': hauteur
	  	});

	  	$('#slide').css({
	  		'width': window.innerWidth,
	  		'height': hauteur
	  	});



	  	setTimeout(suivant, page[currentPosition][2]);


	}else{
		alert('This channel is empty !');
		window.location.href= 'index.php';
	}
	


// Mise en place d'une fonction passant au slide suivant
    function suivant(){
    	console.log('delete');
    	document.getElementById('slidesContainer').removeChild(document.getElementById('slide'));

    	if (currentPosition < page.length-1){
    		currentPosition++;
    	}else{
    		currentPosition=0;
    		window.location.reload();
    	}
    	console.log(currentPosition);
    	createPage(content, page[currentPosition][3], page[currentPosition][1], page[currentPosition][0]);

    	$('#slide').css({
	  		'width': window.innerWidth,
	  		'height': hauteur
	  	});

	  	console.log(page[currentPosition][2]);
    	setTimeout(suivant, page[currentPosition][2]);
	    
	    
	}


//Permet la création de chaque slide en fonction de leur type
	function createPage(content, type, src, id){
		var container=document.createElement('div');
		container.setAttribute("class", 'slide'); 
		container.id='slide';
		if (type=='video'){
			var myvideo = document.createElement('video');
			myvideo.src = src;
			myvideo.id = id;
			myvideo.width=window.innerWidth;
			myvideo.height=window.innerHeight;
			myvideo.controls = false;
			container.appendChild(myvideo);
		}else if (type== 'frame'){
			var ifrm = document.createElement("IFRAME");
   			ifrm.setAttribute("src", src); 
   			ifrm.setAttribute("id", id); 
   			ifrm.setAttribute("width", window.innerWidth); 
   			ifrm.setAttribute("height", hauteur);
   			ifrm.setAttribute("frameborder", "0");
   			ifrm.setAttribute("allowfullscreen", "true");   
   			ifrm.setAttribute("mozallowfullscreen", "true");   
   			ifrm.setAttribute("webkitallowfullscreen", "true");      

   			container.appendChild(ifrm);
		}else if(type == 'object'){
			var object = document.createElement('OBJECT');
			object.id = "provisoire";
			object.className = "BrightcoveExperience";
			object.data = src;
			object.type = "application/x-shockwave-flash";
			object.width=window.innerWidth;
			object.height=hauteur;

			container.appendChild(object);
		}
		content.appendChild(container);
	}

});