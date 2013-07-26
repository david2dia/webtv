/**
 * Un bandeau de news en jQuery, comme sur iTélé
 * par Jay Salvat - http://blog.jaysalvat.com/*/
(function($) {
$.fn.iTvScroller = function(settings) {
    // Options
    var options =  {
        delay: 5000
    };
    $.extend(options, settings);
        
    return this.each(function(){
        var $$ = $(this);
        
        // Applique les classes au 1er et 2ème DT
        $('dt', $$)
            .eq(1).addClass('second').end()
            .eq(0).addClass('first');

        // Fait apparaitre doucement la première news
        $('dd', $$).eq(0).fadeIn('slow');
        
        // Appelle la méthode scrollTitles() toutes les x secondes
        setInterval(scrollTitles, options.delay);
        
        function scrollTitles() {
            // Traitement des DD
            $('dd', $$)
                // On les masque tous
                .hide()
                // On réaffiche celui qui nous intéresse : le suivant
                .eq(1).fadeIn('slow');

            // Traitement des DT
            $('dt', $$)
                // On réinitialise les classes de tous les titres
                .removeClass('first')
                .removeClass('second')
                // On réapplique les classes au 1er, 2ème et 3ème titre
                .eq(2).addClass('second').end()
                .eq(1).addClass('first').end()
                .eq(0).addClass('first')
                // Puis on déplace les titres vers la gauche
                .animate( { marginLeft : '-150px'}, 1000, function() {

                    // Lorsque le déplacement est termine le 1er DT ne nous intéresse plus
                    var dt = $('dt', $$).eq(0)
                        // On réinitialise la marge à gauche
                        .css('marginLeft', 0)
                        // On supprime la classe
                        .removeClass('first')
                        // On le supprime
                        .remove();

                    // On supprime également le DD
                    var dd = $('dd', $$).eq(0).remove();

                    // On repose le DT et DD à la suite des autres titres
                    $$.append( dt.hide().fadeIn('slow'), dd );
                }
            )
        }    
    });
};
})(jQuery);


var fixHelper = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};
$(function(){ // quand la page a fini de se charger
      $("#tabsort").sortable({ // initialisation de Sortable
        containment: "#draglimite2",
        cursor: "move",
        handle: ".dragHandle2",
        axis: "y",
        forcePlaceholderSize: true,
        grid: [0, 10],
        helper: fixHelper,
        //helper: "clone",
        //stop: handleDragStop,
        update: handleDragUpdate
      });
      
      function handleDragUpdate( event, ui ) {  // callback quand l'ordre de la liste est changé
        var order = $('#tabsort2').sortable('serialize'); // récupération des données à envoyer
        $.post(urlajax, order, function(theResponse)
        {
            // On affiche dans l'élément portant la classe "reponse" le résultat du script de mise à jour
            $(".reponse").html(theResponse).fadeIn("fast");
            $("#loader").show("fast"); 
            setTimeout(function()
            {
                $("#loader").hide("fast"); 
                $(".reponse").fadeOut("slow");
            }, 1000);
        });
        var i=1;
        $('.dragHandle2').each(function(){
          $(this).html(i);
          i++;
        });
        //parent.location.reload();
      }
      
      function handleDragStop( event, ui ) {
      var offsetXPos = parseInt( ui.offset.left );
      var offsetYPos = parseInt( ui.offset.top );
      alert( "Drag stopped!\n\nOffset: (" + offsetXPos + ", " + offsetYPos + ")\n");
      }
      $("#tabsort2").disableSelection(); // on désactive la possibilité au navigateur de faire des sélections
    }); //FIN SORTABLE