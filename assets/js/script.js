$(document).ready(function(){

    $(function () { $("input,select,textarea").not("[type=submit],[type=date],[type=time],[type=checkbox]").jqBootstrapValidation(); } );
    if (navigator.userAgent.indexOf('Chrome/2') != -1) {
    $('input[type=date]').on('click', function(event) {
        event.preventDefault();
    });
    }
    $('input[type=date]').datepicker();
/*    $('input[type=time]').timepicker();*/
    $(function () {
      var activeTab = $('[href=' + location.hash + ']');
      activeTab && activeTab.tab('show');
    });
    $('.nav a').on('shown', function (e) {
      window.location.hash = e.target.hash;
    })

    function changeHash(hash){parent.location.hash = hash;}
    function getHash(){return parent.location.hash;}

    $(function() 
    { 

     $('#liste').hide();
     $('#icone2').hide(); 

     $('i.icon-th-list').click(function() 
     { 
     	var more = $('#liste');
     	
     	if (more.is(':hidden')) {
        $('#icone2').fadeOut('fast')
        $('#icone').fadeOut('fast', function(){
         more.fadeIn('slow');
         changeHash('l');
        });
      }
      return false;
     }); 

     $('i.icon-th-large').click(function() 
     { 
     	var more = $('#icone');
     	
      if (more.is(':hidden')) {
        $('#icone2').fadeOut('fast', function(){
     	  $('#liste').fadeOut('fast', function(){
         more.fadeIn('slow');
         changeHash('ic');
        })});
      }
      return false;
     }) 

     $('i.icon-th').click(function() 
     { 
      var more = $('#icone2');
      
      if (more.is(':hidden')) {
        $('#icone').fadeOut('fast', function(){
        $('#liste').fadeOut('fast', function(){
         more.fadeIn('slow');
         changeHash('ic2');
        })});
      }
      return false;
     })

});//fin

    $(function(){ 
        $('#postit').draggable({cursor: "move"})
          function postItMove( event, ui ) {
            $("#postit").css("position","absolute");
          }
    }); //FIN Draggable


var fixHelper = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};
    $(function(){ // quand la page a fini de se charger
      $("#tabsort").sortable({ // initialisation de Sortable
        containment: "#draglimite",
        cursor: "move",
        handle: ".dragHandle",
        axis: "y",
        forcePlaceholderSize: true,
        grid: [0, 10],
        helper: fixHelper,
        //helper: "clone",
        //stop: handleDragStop,
        update: handleDragUpdate
      });
      
      function handleDragUpdate( event, ui ) {  // callback quand l'ordre de la liste est changé
        var order = $('#tabsort').sortable('serialize'); // récupération des données à envoyer
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
        $('.dragHandle').each(function(){
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
      $("#tabsort").disableSelection(); // on désactive la possibilité au navigateur de faire des sélections
    }); //FIN SORTABLE

    $('.tooltipb').tooltip('hide')
    $('.typeahead').typeahead()
    $(".chzn-select").chosen();

    /*$(".chzn-select").chosen();*/
}); // end document.ready

