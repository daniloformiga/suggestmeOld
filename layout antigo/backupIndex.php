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

    <title>SuggestMe - Websemântica da Sugestão</title>z

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

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        $user_profile = $facebook->api('/me','GET');
        echo "Nome: " . $user_profile['name'] . "</br></br>";

        $response = $facebook->api("/me/music");
        echo "Bandas Curtidas: " . "</br></br>";

        foreach ($response['data'] as $music) {
            echo $music['name'] . " </br> ";

            $query = array(array('id' => NULL, 'name' => $music['name'], 'genre' => [] , 'type' => '/music/artist'));
            $service_url = 'https://www.googleapis.com/freebase/v1/mqlread';
            $params = array(
                    'query' => json_encode($query)
            );
            $url = $service_url . '?' . http_build_query($params);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);


            foreach ($response['result'] as $topic) {
              

                $query3 = array(array('id' => NULL, 'name' => [], 'genre' => $topic['genre'][0] , 'type' => '/music/artist', 'limit' => 3));


                $service_url3= 'https://www.googleapis.com/freebase/v1/mqlread';
                $params3 = array(
                        'query' => json_encode($query3)
                );

                $url3 = $service_url3 . '?' . http_build_query($params3);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url3);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response3 = json_decode(curl_exec($ch), true);
                curl_close($ch);


                
                 foreach ($response3 as $topic3) {             
                    var_dump($topic);
                      
                  }

           }

        }

        echo '</br> <a href="logout.php"e>Logout</a>';
        


      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl(); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
    } else {

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

    }?>

  </body>

</html>