<!DOCTYPE html>
<html>
<body>
<?php

        
        $query = array(array('id' => NULL, 'name' => 'nirvana', 'genre' => NULL , 'type' => '/music/artist'));
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
                echo $topic['genre'] . '<br/>';
        }
?> 
</body>
</html>