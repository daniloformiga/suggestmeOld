<!DOCTYPE html>
<html>
<body>
<?php

        $genero = $_POST['genero'];
        
        $query = array(array('id' => NULL, 'name' => 'nirvana', 'genre' => [] , 'type' => '/music/artist'));
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
                $i = 0;
                echo $topic['genre'][$i] . '<br/>';
                $i++;
        }
?> 
</body>
</html>