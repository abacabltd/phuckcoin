<?php
/**
 * Plugin Name: Phuck Exchange Rate JSON API
 * Plugin URI: https://givephuck.com
 * Description: Results of Phuck Exchange rates in real time, in JSON format
 * Version: 1.0
 * Author: Seun Skye, Oyeniyi
 * Author URI: https://instagram.com/seun_oyeniyi
 */

define("PHUCK_API_NAMESPACE_V1", "api");
add_action( 'rest_api_init', function() {
    register_rest_route( PHUCK_API_NAMESPACE_V1, '/rate', array(
        'methods' => 'GET',
        'callback' => function($data) {
            $array = array();
        
            // $coinpaprika_url = "https://api.coinpaprika.com/v1/tickers/phuck-phucks";
            // $coinpaprika_json = file_get_contents($coinpaprika_url);
            // $coinpaprika_decode = json_decode($coinpaprika_json);
            // return $coinpaprika_decode;

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "https://api.coinpaprika.com/v1/tickers/phuck-phucks");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            $json_array = json_decode($output, true, 512, JSON_BIGINT_AS_STRING);
            
            $price = $json_array['quotes']['USD']['price'];

            $array[] = array(
                "symbol" => "PHUCK",
                "price_usd" => number_format((float)$price, 9, '.', ''),
                "last_updated" => time()
            );

            // curl_close($curl); //close the curl
            
            return $array;
        }
));
});