<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cloud Meet</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="google-signin-client_id" content="567367740537-epe61ssfrv2efb00h4igu64icd05ebuv.apps.googleusercontent.com">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
  <script>
    function onSignIn(googleUser) {
      var profile = googleUser.getBasicProfile();
      console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
      console.log('Name: ' + profile.getName());
      console.log('Image URL: ' + profile.getImageUrl());
      console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.      
      
      $( "#lblbienvenida" ).html("Bienvenido <br />"+  profile.getName() );
      $( "#lblbienvenida" ).append("</br> "+profile.getEmail() );
      //$( "#fperfil" ).html("<img name='aboutme' class='img-circle' src='"+  profile.getImageUrl()+"'/>" );
    } 

     function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
          console.log('User signed out.');
          document.location.href=".";
        });
      }
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
      <a class="navbar-brand" href="#">CloudMeet</a>
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
  <h3><div id="lblbienvenida">Bienvenido a CloudMeet</div></h3><br>
     
  <div class="row">
    <div class="col-sm-12">
      

      <div class="list-group">
        

         
          <h4 class="list-group-item-heading">Grupos a los que esta inscrito:</h4>
     
      


        <a href="admin.php?idg=1" class="list-group-item ">
          Academia de Ciencias
        </a>

        <a href="admin.php?idg=2" class="list-group-item ">
          Academia de Programación
        </a>

              
      </div>


        
       
      
    </div>
     
     
  </div>
</div><br>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
</html>
