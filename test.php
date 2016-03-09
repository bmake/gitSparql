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
echo '<pre>';


if ( isset($_GET['secret']) && $config['secret'] == $_GET['secret']) {

    if(isset($_GET['endpoint']) && isset($_GET['data'])){
        $log = '';

        $endpoint = $_GET['endpoint'];
        $data = $_GET['data'];

        $SparqlHttpGraph = new SparqlHTTPGraph($endpoint, true);

        if(is_array($data) == true){
            $i = false;
            foreach ($data as $item) {
                // First PUT than POST
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
    }

}