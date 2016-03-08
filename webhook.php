<?php

require 'vendor/autoload.php';
require 'SparqlHttpGraph.php';

$secret = 'SECRET'; //pls change

$payload = file_get_contents('php://input');
$payload = json_decode($payload);

if ( isset($_GET['secret']) && $secret == $_GET['secret'] && isset($payload)) {

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
                    $response = $SparqlHttpGraph->sendData($item, 'POST');
                    $i = true;
                }
                else {
                    $response = $SparqlHttpGraph->sendData($item, 'PUT');
                }
                $log[$item]['status'] = $response->getReasonPhrase();
                $log[$item]['message'] = json_decode($response->getBody());

            }
        }
        else{
            $response = $SparqlHttpGraph->sendData($data, 'POST');

            $log[$data]['status'] = $response->getReasonPhrase();
            $log[$data]['message'] = $response->getBody();
        }

        print_r(json_encode($log));
        file_put_contents('webhook.log', json_encode($log)."\n", FILE_APPEND);
    }

}