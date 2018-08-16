<?php

require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

class TrendsGetter {

    public $app = [];
    public $twitterKey = [];

    public $connectionData;

    public function __construct(){
        $this->configLoad(dirname(__FILE__)."/../setting.ini");
        $this->connectionData = $this->connection($twitterKey);
    }

    public function connection(Array $twitterKey){
        $data = new TwitterOAuth(
            $twitterKey["ConsumerKey"],
            $twitterKey["ConsumerSecret"],
            $twitterKey["AccessToken"],
            $twitterKey["AccessTokenSecret"]
        );

        return $data;
    }

    public function configLoad(String $path){
        $configArray = parse_ini_file($path, true);
        $this->app = [
            "name" => $configArray["Default"]["APP_NAME"],
            "debug" => $configArray["Default"]["APP_DEBUG"]
        ];
        $this->twitterKey = [
            "ConsumerKey" => $configArray["Twitter"]["CONSUMER_KEY"],
            "ConsumerSecret" => $configArray["Twitter"]["CONSUMER_SECRET"],
            "AccessToken" => $configArray["Twitter"]["ACCESS_TOKEN"],
            "AccessTokenSecret" => $configArray["Twitter"]["ACCESS_TOKEN_SECRET"]
        ];
    }

    public function getTrends(Int $id){
        $data = $this->connectionData->get(
            "trends/place",
            ["id" => strval($id)]
        );

        if (($code = $this->connectionData->getLastHttpCode()) === 200) {
            if ($this->app["debug"]) {
                ChromePhp::log($this->app["name"]."| Success!!");
            }
        } else {
            switch ($code) {
                default:
                    $message = [
                        "error" => "Not Pattern Error Code!!"
                    ];
                    if ($this->app["debug"]) {
                        ChromePhp::log($this->app["name"]."| Failure!!");
                    }
                    break;
            }
        }

        if (isset($message)) {
            $finalData = json_encode($message);
        } else {
            $finalData = $data;
        }

        return $finalData;
    }
}