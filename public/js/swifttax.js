$(document).ready(function(){

 $('.modal-trigger').leanModal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .5, // Opacity of modal background
      in_duration: 300, // Transition in duration
      out_duration: 200, // Transition out duration
      // ready: function() { $.show('#modal2'); }, // Callback for Modal open
      // complete: function() { $.hide('#modal1'); } // Callback for Modal close
    
  });
 });

$("#modal2").hide();
	$("modal2").click(function() {
  alert( "Handler for .click() called." );
});
      


    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
  //   $('.modal-trigger').leanModal();

  // });
  

    