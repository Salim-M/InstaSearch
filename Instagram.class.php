<?php
require('vendor/autoload.php');
class Instagram{
    /*
    ** Created on 26-5-2020 by Salim
    */
    private $url;
    private $username;
    private $dom;
    private $client;

    public function __construct($username){
        $this->url = 'https://codeofaninja.com/tools/find-instagram-id-answer.php?instagram_username=' . $username;
        $this->username = $username;
        $this->dom = new \PHPHtmlParser\Dom();
        $this->client = new \GuzzleHttp\Client();
    }

    public function results(){
        $response = $this->client->request('GET', $this->url);
        if($response->getStatusCode() === 200){
            $data = [];
            //load the response
            $this->dom->load($response->getBody());
            $profiles = $this->dom->find('a');
            $photos = $this->dom->find('img');

            foreach ($photos as $key => $photo) {
                $photo_Link = $photo->getAttribute('src');
                $profile_Link = $profiles[$key]->getAttribute('href');
                $profile_Name = $profiles[$key]->firstChild()->text;
                array_push($data, array(
                    "name" => $profile_Name,
                    "link" => $profile_Link,
                    "photo" => $photo_Link,
                ));
            }
            return [
                "count" => sizeof($data),
                "results" => $data
            ];
        }
        // failed request
        return [
            "count" => 0,
            "results" => null
        ];
    }

    public function match($arrayResponse){
        if($arrayResponse['count'] === 0){
            return [];
        }else{
            foreach ($arrayResponse['results'] as $profile) {
                if(strpos($this->username, $profile['link']) !== -1){
                    return $profile;
                }
            }
        }
    }

}

?>