<?php


class SparqlHTTPGraph
{

    var $sparql_endpoint = '';
    var $content_type = '';

    /**
     * SparqlHTTPGraph constructor.
     * @param string $sparql_endpoint
     */
    public function __construct($sparql_endpoint, $content_type = 'text/turtle')
    {
        $this->sparql_endpoint = $sparql_endpoint;
        $this->content_type = $content_type;
    }

    public function sendData($data, $method){

        $data = file_get_contents($data);

        $client = new GuzzleHttp\Client(['base_uri' => $this->sparql_endpoint]);
        $response = $client->request($method, 'data', [
            'headers' => [
                'Content-Type' => $this->content_type
            ],
            'body' => $data
        ]);

        return $response;
    }

}
