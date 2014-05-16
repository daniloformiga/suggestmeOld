<?php
  // Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
  require_once('facebook-php-sdk/src/facebook.php');

  $config = array(
    'appId' => '379200745559167',
    'secret' => 'b48715ce89081c9c1f36e2d6ea9938f7',
    'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
  );

  $facebook = new Facebook($config);
  $user_id = $facebook->getUser();
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Sugestão usando Web Semântica">
    <meta name="author" content="Danilo Formiga">

    <title>SuggestMe - Websemântica da Sugestão</title>

        <!-- JavaScript -->

    <script src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>

        <!-- CSS -->

    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css"></script>
    <link href="css/stylish-portfolio.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body>

   <?php
    if($user_id) {

      header("Location:redirecionado.php");

      
      }else{

      $login_url = $facebook->getLoginUrl();

      echo '<div id="top" class="header">
      <div class="vert-text">
        <h1>SuggestMe</h1>
        <h3>Faça login para ter acesso ao sistema</h3>
        </br>
        <a href="';
      echo $login_url . '"><img src="img/botao-login.gif"></a>
      </div>
      </div>';

      }

    
    ?>

  </body>

</html>