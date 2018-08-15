<?php

require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

class TrendsGetter {

    public $connectionData;

    public function __construct(){
        $TwitterKey = [
            "ConsumerKey" => "",
            "ConsumerSecret" => "",
            "AccessToken" => "",
            "AccessTokenSecret" => ""
        ];

        $this->connectionData = $this->connection($TwitterKey);
    }

    public function connection(Array $TwitterKey){
        $data = new TwitterOAuth(
            $TwitterKey["ConsumerKey"],
            $TwitterKey["ConsumerSecret"],
            $TwitterKey["AccessToken"],
            $TwitterKey["AccessTokenSecret"]
        );

        return $data;
    }

    public function getTrends(Int $id){
        $data = $this->connectionData->get(
            "trends/place",
            ["id" => strval($id)]
        );

        if (($code = $this->connectionData->getLastHttpCode()) === 200) {
            ChromePhp::log("[TrendsGetter] Success!!");
        } else {
            switch ($code) {
                // ERRORCodeによってメッセージを変更
                default:
                    $message = [
                        "error" => "Not Pattern Error Code!!"
                    ];
                    ChromePhp::log("[TrendsGetter] Failure!!");
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