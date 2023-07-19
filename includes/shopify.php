<?php

class Shopify {
    public $shop_url;
    public $access_token;

    public function set_url($url){
        $this->shop_url = $url;
    }

    public function set_token($token){
        $this->access_token = $token;
    }

    public function get_url(){
        return $this->shop_url;
    }

    public function get_token(){
        return $this->access_token;
    }

    // /admin/api/2023-07/products.json
    public function rest_api($api_endpoint, $query = array(), $method = "GET"){
        $url = "https://{$this->shop_url}{$api_endpoint}";

        //if query not null form query string
        if(in_array($method, array("GET", "DELETE")) && !is_null($query)) {
            $url = $url . "?" . http_build_query($query);
        }

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        $headers[] = "";
        if(!is_null($this->access_token)) {
            $headers[] = "X-Shopify-Access-Token: {$this->access_token}";
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        if($method != "GET" && in_array($method, array("POST", "PUT"))){
            if(is_array($query)){
                $query = http_build_query($query);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
            } 
        }

        $response = curl_exec($curl);
        $error = curl_errno($curl);
        $error_msg = curl_error($curl);

        if($error) {
            return $error_msg;
        }else{
            //split response into 2 arrays
            $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);
          
            //format headers array
            $headers = array();
            $headers_content = explode("\n", $response[0]);
            $headers["status"] = $headers_content[0];

            //remove status from headers_content
            array_shift($headers_content);

            foreach($headers_content as $content){
                $data = explode(":", $content);
                $headers[ trim( $data[0] ) ] = trim( $data[1] );
            }

            //echo print_r($headers);
        }
        curl_close($curl);

        return array("headers" => $headers, "body" => $response[1]);
    }
}
?>