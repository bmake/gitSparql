<?php


class SparqlHTTPGraph
{

    var $sparql_endpoint = '';
    var $content_type = '';
    var $client;
    var $debug;

    /**
     * SparqlHTTPGraph constructor.
     * @param string $sparql_endpoint
     */
    public function __construct($sparql_endpoint, $debug = false, $content_type = 'text/turtle')
    {
        $this->sparql_endpoint = $sparql_endpoint;
        $this->content_type = $content_type;
        $this->client = new GuzzleHttp\Client(['base_uri' => $sparql_endpoint]);
        $this->debug = $debug;
    }

    public function request($data, $method){

        $data = file_get_contents($data);

        $response = $this->client->request($method, '', [
            'debug' => $this->debug,
            'headers' => [
                'Content-Type' => $this->content_type
            ],
            'body' => $data
        ]);

        return $response;
    }

}
