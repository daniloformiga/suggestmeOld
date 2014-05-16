<!DOCTYPE html>
<html>
<body>
<?php

        $genero = $_POST['genero'];
        
        $query = array(array('id' => NULL, 'name' => NULL, 'genre' => $genero , 'type' => '/music/artist'));
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
        echo "Lista das bandas do genero: " . $genero . "</br> </br>";
        foreach ($response['result'] as $topic) {
        
                $query2 = array(array('id' => NULL, 'name' => $topic['name'], 'genre' => [] , 'type' => '/music/artist'));
                $service_url2= 'https://www.googleapis.com/freebase/v1/mqlread';
                $params2 = array(
                        'query' => json_encode($query2)
                );
                $url = $service_url2 . '?' . http_build_query($params2);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response = json_decode(curl_exec($ch), true);
                curl_close($ch);
                
                foreach ($response['result'] as $topic2) {
                        $i = 0;

                        $query3 = array(array('id' => NULL, 'name' => '', 'genre' => $topic['genre'][$i] , 'type' => '/music/artist'));
                        $service_url3= 'https://www.googleapis.com/freebase/v1/mqlread';
                        $params3 = array(
                                'query' => json_encode($query3)
                        );
                        $url = $service_url3 . '?' . http_build_query($params3);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $response = json_decode(curl_exec($ch), true);
                        curl_close($ch);

                        echo  $topic['name']. '<br/>';
                        $i++;
                }
                
        }
?> 
</body>
</html>