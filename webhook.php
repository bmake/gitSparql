<?php

require_once ('vendor/autoload.php');
require_once ('class/SparqlHttpGraph.php');

if(!file_exists('config.php')){

    require_once ('class/RandomStringGenerator.php');

    // Create new instance of generator class.
    $generator = new RandomStringGenerator;
    // Set token length.
    $tokenLength = 32;
    // Call method to generate random string.
    $token = $generator->generate($tokenLength);

    $config = '
    <?php
    $config = array ("secret" => "'.$token.'");
    ';

    file_put_contents('config.php', $config);
}

if(file_exists('config.php')){
    require_once ('config.php');
}

$branch = 'refs/heads/master';

$payload = file_get_contents('php://input');
$payload = json_decode($payload);

if ( isset($_GET['secret']) && $config['secret'] == $_GET['secret'] && isset($payload) && $payload->ref == $branch) {

    if(isset($_GET['endpoint']) && isset($_GET['data'])){

        $endpoint = $_GET['endpoint'];
        $data = $_GET['data'];
        $log['time'] = time();
        $log['commits'] = json_decode(json_encode($data->commits), true);

        $SparqlHttpGraph = new SparqlHTTPGraph($endpoint);

        if(is_array($data) == true){
            $i = false;
            foreach ($data as $item) {
                // First POST than PUT
                if($i == false) {
                    $response = $SparqlHttpGraph->request($item, 'PUT');
                    $i = true;
                }
                else {
                    $response = $SparqlHttpGraph->request($item, 'POST');
                }
                $log[$item]['status'] = $response->getReasonPhrase();
                $log[$item]['message'] = json_decode($response->getBody());

            }
        }
        else{
            $response = $SparqlHttpGraph->request($data, 'POST');

            $log[$data]['status'] = $response->getReasonPhrase();
            $log[$data]['message'] = $response->getBody();
        }

        print_r(json_encode($log));
        file_put_contents('webhook.log', json_encode($log)."\n", FILE_APPEND);
    }

}