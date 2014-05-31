
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


<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="plugins/bootstrap/bootstrap.css" rel="stylesheet">
        <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
        <link href="plugins/fancybox/jquery.fancybox.css" rel="stylesheet">
        <link href="plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
        <link href="plugins/xcharts/xcharts.min.css" rel="stylesheet">
        <link href="plugins/select2/select2.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    <title></title>
</head>
<body>


<?php 


try {
 
        echo "<br>";

        $user_profile = $facebook->api('/me','GET');

        $response = $facebook->api("/me/music");

        foreach ($response['data'] as $music) {
        

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
              
                if(!empty($topic['genre'][0])){

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


                }
                

           }

        }
        


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
   
?>

<!--Start Header-->
<div id="screensaver">
    <canvas id="canvas"></canvas>
    <i class="fa fa-lock" id="screen_unlock"></i>
</div>
<div id="modalbox">
    <div class="devoops-modal">
        <div class="devoops-modal-header">
            <div class="modal-header-name">
                <span>Basic table</span>
            </div>
            <div class="box-icons">
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="devoops-modal-inner">
        </div>
        <div class="devoops-modal-bottom">
        </div>
    </div>
</div>
<header class="navbar">
    <div class="container-fluid expanded-panel">
        <div class="row">
            <div id="logo" class="col-xs-12 col-sm-2">
                <a href="index.html">SuggestME</a>
            </div>
            <div id="top-panel" class="col-xs-12 col-sm-10">
                <div class="row">
                    <div class="col-xs-8 col-sm-4">
                        
                 
                    </div>
                    <div class="col-xs-4 col-sm-8 top-panel-right">
                        <ul class="nav navbar-nav pull-right panel-menu">
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle account" data-toggle="dropdown">
                                    <div class="avatar">
                                        <img src=<?php echo "http://graph.facebook.com/" . $user_profile['id'] . "/picture" ?> class="img-rounded" alt="avatar" />
                                    </div>
                                    <i class="fa fa-angle-down pull-right"></i>
                                    <div class="user-mini pull-right">
                                        <span class="welcome">Bem vindo,</span>
                                        <span><?php echo $user_profile['name']; ?> </span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                            
                                    <li>
                                        <a href="logout.php">
                                            <i class="fa fa-power-off"></i>
                                            <span class="hidden-sm text">Logout</a></span>
                                            
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    
                </div>

    </header>
            </div>
        </div>

       <div class="box-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bandas Curtidas</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php 

                     $user_profile = $facebook->api('/me','GET');

                     $response = $facebook->api("/me/music");

                     $count = 0;
                     $bandas = array();
                     $contadorArray = 0;
                     $imprimirArray = 0;

                    foreach ($response['data'] as $music) {

                        $query = array(array('id' => NULL, 'name' => $music['name'], 'genre' => [] , 'type' => '/music/artist'));
                        $service_url = 'https://www.googleapis.com/freebase/v1/mqlread';
                        $params = array(
                                'query' => json_encode($query)
                        );
                        $url = $service_url . '?' . http_build_query($params);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $response2 = json_decode(curl_exec($ch), true);
                        curl_close($ch);

                        foreach ($response2 as $topic) {

                            

                            

                                if(!empty($topic[0]['genre'][$count])){
                                    

                                    $query = array(array('id' => NULL, 'name' => [], 'genre' => $topic[0]['genre'][0] , 'type' => '/music/artist', 'limit' => 3));
                                    $service_url = 'https://www.googleapis.com/freebase/v1/mqlread';
                                    $params = array(
                                            'query' => json_encode($query)
                                    );
                                    $url = $service_url . '?' . http_build_query($params);
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    $response3 = json_decode(curl_exec($ch), true);
                                    curl_close($ch);


                                    foreach ($response3 as $genre) {

                                        if(!empty($genre[$count]['name'][0])){
                                            
                                            $bandas[$contadorArray] = $genre[$count]['name'][0];

                                            $contadorArray++;

                                            

                                        }


                                }

                                
                                    


                                };
                            

                      
                    };


                        $count++;
                        
                        



                    ?>
                            
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $music['name']; ?></td>
                        
                        
                        </tr>


                    <?php }; 

                    ?>

                    <?php 

                    $length = count($bandas);
                    $imprimirTamanho = 1;

                     echo '<div class="box-content">
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th width=138>#</th>
                                        <th>Bandas Sugeridas</th>
                                        </tr>
                                    </thead>
                            <tbody>
                                <tr>';

                            for($i = 0; $i < $length; $i++) {
                                 echo "<td>" . $imprimirTamanho . "</td>";
                                 echo "<td>" . $bandas[$i] . "  <a href='#'><img src=img/like.png></td></a>";
                                 echo '</tr>';
                                 $imprimirTamanho++;
                            }

                    ?>


                     

                    </tbody>
                </table>
            </div>

            <script src="plugins/jquery/jquery-2.1.0.min.js"></script>
            <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="plugins/bootstrap/bootstrap.min.js"></script>
            <script src="plugins/justified-gallery/jquery.justifiedgallery.min.js"></script>
            <script src="plugins/tinymce/tinymce.min.js"></script>
            <script src="plugins/tinymce/jquery.tinymce.min.js"></script>
            <!-- All functions for this theme + document.ready processing -->
            




</body>
</html>


