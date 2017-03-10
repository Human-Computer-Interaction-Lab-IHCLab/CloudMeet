<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cloud Meet</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  

<script>
 
 $(document).ready(function(){


// Clic al evento
  $(document).on('click', '#btnVerEvent', function(e) {

    $("#h1Modal").text("Ver detalles de la reunión");
    $("#modalEvent").modal();

    if(! $("#mTitulo").length ){
        var input = $('<span id ="mTitulo">'+ $("#cmTitulo").val()+'</span>');
        $("#cmTitulo").parent().append(input);
        $("#cmTitulo").remove();
    }
    $("#mTitulo").text($(this).text());

    if(! $("#mDescriptor").length ){
        var input = $('<span id ="mDescriptor">'+ $("#cmDescriptor").val()+'</span>');
        $("#cmDescriptor").parent().append(input);
        $("#cmDescriptor").remove();
    }
    $("#mDescriptor").text($(this).attr('descriptor'));

    if(! $("#mFecha").length ){
        var input = $('<span id ="mFecha">'+ $("#cmFecha").val()+'</span>');
        $("#cmFecha").parent().append(input);
        $("#cmFecha").remove();
    }
    $("#mFecha").text($(this).attr('fecha'));

  
    if(! $("#mInvitados").length ){
        var input = $('<span id="mInvitados">'+ $("#cmInvitados").val()+'</span>');
        $("#cmInvitados").parent().append(input);
        $("#cmInvitados").remove();
    }  
    $("#mInvitados").text($(this).attr('invitados'));




    $("#midEvento").val($(this).attr('ide'));   
    $("#btnGuardar").hide();
    $("#btnModificar").show();
    

  });

// Botón de eliminar evento
  $('#btnEliminar').click(function() { 
      
      //alert("Se borrará =>"+ $("#midEvento").val())  ;
       gapi.client.calendar.events.delete({
          'calendarId': 'primary',
          'eventId': $("#midEvento").val()          
        }).then(function(response) {
          
            //console.log(response);          
            $("#lblMensaje").html("<div class='alert alert-success'><strong> Se eliminó el evento correctamente.</strong></div>");
          
        });


    });   


// Botón de guardar evento
  $('#btnGuardar').click(function() { 
          
    /*
    console.log($("#cmTitulo").val());
    console.log($("#cmDescriptor").val());
    console.log($("#cmFecha").val());
    */


if( $("#midEvento").val() == '' ) {
  // NUEVO

  invitados = $("#cmInvitados").val();
  var correos = invitados.split(",");
  
  if (correos.length >1){
    $.each( correos, function( key, value ) {
      invitados= invitados + "{'email': '" + value +"''},";
    });
  }else
  invitados=  "{'email': '" + $("#cmInvitados").val() +"'},{'email': 'vmedina@ucol.mx'}";

  console.log(invitados);

  var event = {
    'summary': $("#cmTitulo").val(),
    'location': 'Colima/Mexico',
    'description': $("#cmDescriptor").val() ,
    'start': {
      'dateTime': '2017-03-09T09:00:00-07:00',
      'timeZone': 'America/Los_Angeles'
    },
    'end': {
      'dateTime': '2017-03-09T17:00:00-07:00',
      'timeZone': 'America/Los_Angeles'
    },
    'recurrence': [
      'RRULE:FREQ=DAILY;COUNT=2'
    ],
    'attendees': [
      {'email': 'vmedina@gmail.com'},
      {'email': 'javiermanzanoaguilar@ucol.mx'}
    ],
    'reminders': {
      'useDefault': false,
      'overrides': [
        {'method': 'email', 'minutes': 24 * 60},
        {'method': 'popup', 'minutes': 10}
      ]
    }
  };


         gapi.client.calendar.events.insert({
            'calendarId': 'primary',
            'resource': event        
          }).then(function(response) {
            
            console.log(response);          
            
          });


          $("#lblMensaje").html("<div class='alert alert-success'><strong> Se generó un nuevo evento correctamente.</strong></div>");
}else{

 // EDITAR

    $("#lblMensaje").html("<div class='alert alert-success'><strong> Se actualizó la información del evento.</strong></div>");

}//if


  });   

// Botón de nuevo evento
  $('#btnNuevo').click(function() { 
          
    /*
    console.log($("#cmTitulo").val());
    console.log($("#cmDescriptor").val());
    console.log($("#cmFecha").val());
    */
        $("#h1Modal").text("Nueva reunión");
        $("#modalEvent").modal();

        
        if( $("#mTitulo").length ){
          var input = $('<input />', {'type': 'text', 'class':'form-control', 'id': 'cmTitulo','name': 'cmTitulo', 'placeholder':'Escriba el título del evento', 'value':''});
          $("#mTitulo").parent().append(input);
          $("#mTitulo").remove();
          input.focus();
        }else{
          $("#cmTitulo").val("")
          $("#cmTitulo").attr("placeholder", "Escriba el título").val("").focus().blur();
        }

        if( $("#mDescriptor").length ){
          var input2 = $('<input />', {'type': 'text', 'class':'form-control',  'id': 'cmDescriptor', 'placeholder':'Descripción del evento', 'name': 'cmDescriptor','value': ''});
          $("#mDescriptor").parent().append(input2);
          $("#mDescriptor").remove();  
        }else{
          $("#cmDescriptor").val("")
          $("#cmDescriptor").attr("placeholder", "Descripción del evento").val("");
        }
          
        if( $("#mFecha").length ){
          var input3 = $('<input />', {'type': 'text', 'class':'form-control', 'id': 'cmFecha', 'placeholder':'fechas del evento', 'name': 'cmFecha','value': ''});
          $("#mFecha").parent().append(input3);
          $("#mFecha").remove();          
        }else{
          $("#cmFecha").val("")
          $("#cmFecha").attr("placeholder", "Fechas del evento").val("");
        }


        if( $("#mInvitados").length ){
          var input4 = $('<textarea id="cmInvitados" class="form-control"></textarea>');
          $("#mInvitados").parent().append(input4);
          $("#mInvitados").remove();          
        }else{
          $("#cmInvitados").val("")
          $("#cmInvitados").attr("placeholder", "Escriba los correos electrónicos de los invitados").val("");
        }
 
        $("#midEvento").val("");

        $("#btnGuardar").show();
        $("#btnEliminar").hide();
        $("#btnModificar").hide();

  });   



// Botón de modificar evento
 $('#btnModificar').click(function() { 

    $("#h1Modal").text("Editando reunión");
      
        var input = $('<input />', {'type': 'text', 'class':'form-control', 'id': 'cmTitulo','name': 'cmTitulo', 'value':  $("#mTitulo").html()});
        $("#mTitulo").parent().append(input);
        $("#mTitulo").remove();
        input.focus();

        var input2 = $('<input />', {'type': 'text', 'class':'form-control', 'id': 'cmDescriptor', 'name': 'cmDescriptor','value':  $("#mDescriptor").html()});
        $("#mDescriptor").parent().append(input2);
        $("#mDescriptor").remove();
        
        var input3 = $('<input />', {'type': 'text', 'class':'form-control', 'id': 'cmFecha', 'name': 'cmFecha','value':  $("#mFecha").html()});
        $("#mFecha").parent().append(input3);
        $("#mFecha").remove();

        
        var input4 = $('<textarea id="cmInvitados" class="form-control">'+ $("#mInvitados").html()+'</textarea>');
        $("#mInvitados").parent().append(input4);
        $("#mInvitados").remove();


        $("#btnEliminar").hide();
        $("#btnModificar").hide();
        $("#btnGuardar").show();

         



    });   

 
 
});    
</script>

  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
    
  .carousel-inner img {
      width: 100%; /* Set width to 100% */
      margin: auto;
      min-height:200px;
  }

  /* Hide the carousel text when the screen is less than 600 pixels wide */
  @media (max-width: 600px) {
    .carousel-caption {
      display: none; 
    }
  }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="inicio.php">CloudMeet</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      
      <ul class="nav navbar-nav navbar-right">
        <li><div class="g-signin2" data-onsuccess="onSignIn"></div></li>      
        <li><a href="#" onclick="signOut();"><span class="glyphicon glyphicon-log-out"></span></a></li>
      </ul>
    </div>
  </div>
</nav>

 

   
</div>
  
<div class="container text-center">    
  <h3>Academia de telemática</h3><br>
<button type="button" id="btnVerEvent" hidden>ver</button>
<div id="lblMensaje">...</div>
 
         <!--Add buttons to initiate auth sequence and sign out-->
    <button id="authorize-button" style="display: none;">Authorize</button>
    <button id="signout-button" style="display: none;">Sign Out</button>
  <div class="row">
    <div class="col-sm-4">


      <div class="panel panel-default">
        <div class="panel-heading">Reuniones...</div>
        <div class="panel-body">
          Reuniones a las que usted ha sido citado.  
        </div>
        <button type="button" class="btn btn-info" id="btnNuevo">Nuevo</button>


        
        <ul id="lstEventos" class="list-group">                    
        </ul>
      </div>


     
      
    </div>
    <div class="col-sm-4"> 
      <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
      <p>Comunicados</p>    
    </div>
     <div class="col-sm-4"> 
      <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
      <p>Tareas</p>    
    </div>
  </div>






   <script type="text/javascript">
      // Client ID and API key from the Developer Console
      var CLIENT_ID = '567367740537-epe61ssfrv2efb00h4igu64icd05ebuv.apps.googleusercontent.com';

      // Array of API discovery doc URLs for APIs used by the quickstart
      var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest"];

      // Authorization scopes required by the API; multiple scopes can be
      // included, separated by spaces.
      var SCOPES = "https://www.googleapis.com/auth/calendar.readonly https://www.googleapis.com/auth/calendar";

      var authorizeButton = document.getElementById('authorize-button');
      var signoutButton = document.getElementById('signout-button');

      /**
       *  On load, called to load the auth2 library and API client library.
       */
      function handleClientLoad() {
        gapi.load('client:auth2', initClient);
      }

      /**
       *  Initializes the API client library and sets up sign-in state
       *  listeners.
       */
      function initClient() {
        gapi.client.init({
          discoveryDocs: DISCOVERY_DOCS,
          clientId: CLIENT_ID,
          scope: SCOPES
        }).then(function () {
          // Listen for sign-in state changes.
          gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);

          // Handle the initial sign-in state.
          updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
          authorizeButton.onclick = handleAuthClick;
          signoutButton.onclick = handleSignoutClick;
        });
      }

      /**
       *  Called when the signed in status changes, to update the UI
       *  appropriately. After a sign-in, the API is called.
       */
      function updateSigninStatus(isSignedIn) {
        if (isSignedIn) {
          authorizeButton.style.display = 'none';
          signoutButton.style.display = 'block';
          listUpcomingEvents();
        } else {
          authorizeButton.style.display = 'block';
          signoutButton.style.display = 'none';
        }
      }

      /**
       *  Sign in the user upon button click.
       */
      function handleAuthClick(event) {
        gapi.auth2.getAuthInstance().signIn();
      }

      /**
       *  Sign out the user upon button click.
       */
      function handleSignoutClick(event) {
        gapi.auth2.getAuthInstance().signOut();
      }

      /**
       * Append a pre element to the body containing the given message
       * as its text node. Used to display the results of the API call.
       *
       * @param {string} message Text to be placed in pre element.
       */
      function appendPre(message) {
        var pre = document.getElementById('content');
        var textContent = document.createTextNode(message + '\n');
        pre.appendChild(textContent);
      }

      /**
       * Print the summary and start datetime/date of the next ten events in
       * the authorized user's calendar. If no events are found an
       * appropriate message is printed.
       */
      function listUpcomingEvents() {
        gapi.client.calendar.events.list({
          'calendarId': 'primary',
          'timeMin': (new Date()).toISOString(),
          'showDeleted': false,
          'singleEvents': true,
          'maxResults': 10,
          'orderBy': 'startTime'
        }).then(function(response) {
          var events = response.result.items;

          //appendPre('Upcoming events:');

          if (events.length > 0) {
            for (i = 0; i < events.length; i++) {
              var event = events[i];
              var when = event.start.dateTime;
              if (!when) {
                when = event.start.date;
              }

              var invitados="";
              for (k = 0; k < event.attendees.length; k++) {
                invitados = invitados  + event.attendees[k].displayName + "<"+ event.attendees[k].email+ ">,";
                
              }
              /*
              console.log(event.attendees[0]);
              console.log(invitados);
              */

              $("#lstEventos").append("<li class='list-group-item'><a href='#' id='btnVerEvent' invitados='"+invitados+"' descriptor='"+event.description+"' ide='"+event.id+"'' fecha='"+when+"' name='btnVerEvent'  >"+event.summary+"</a> <br /></li>");
              //appendPre(event.summary + ' (' + when + ')')
            }
          } else {
            //appendPre('No upcoming events found.');
          }
        });
      } 




    </script>

<script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()">   


</script>



<!-- Modal de reuniones-->
<div id="modalEvent" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="h1Modal">Reuniones</h4>
      </div>
      <div class="modal-body">

        <div class="form-group">
          <h2><span id="mTitulo">Título</span></h2>
          <div><span id="mDescriptor">Descriptor</span></div>
          <span id="mFecha">Fecha</span>
          <input type="hidden" id="midEvento" value="">
          <p> <b>Asistentes:</b> <br />
            <span id="mInvitados">Invitados</span>
          </p>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="btnModificar">Modificar</button>
        <button type="button" class="btn btn-info" id="btnGuardar">Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnEliminar">Eliminar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal de reuniones-->

</div>
<br>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
</html>