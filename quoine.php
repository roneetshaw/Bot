<?php

class Quoine {
    
   public function __construct() {
      $this->privateKey = 'CDCsoL5bMF2FNxGM249JFzO2G0j2+RQTtT6P55xpHHLtd2VXdyyLeV2RktrJ3mNFFEVLpxNTPIuQHPilocILgw==';
      $this->publicKey = '267892';
   }

   private function apiCall($method, array $req = array()) {
      $public_set = array( "products", "GetTradePairs", "GetMarkets", "GetMarket", "GetMarketHistory", "GetMarketOrders" );
      $private_set = array( "X", "GetDepositAddress", "GetOpenOrders", "GetTradeHistory", "GetTransactions", "SubmitTrade", "CancelTrade", "SubmitTip" );
      static $ch = null;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; Cryptopia.co.nz API PHP client; FreeBSD; PHP/'.phpversion().')');
      if ( in_array( $method ,$public_set ) ) {
         $url = "https://api.quoine.com/" . $method;
         if ($req) { foreach ($req as $r ) { $url = $url . '/' . $r; } }
         curl_setopt($ch, CURLOPT_URL, $url );
      } elseif ( in_array( $method, $private_set ) ) {
         $url = "https://api.quoine.com/orders/";
		 echo $url;
         $nonce = explode(' ', microtime())[1];
         $auth_payload = array(
            'path:'.$url,
            'nonce:'.$nonce,
            'token_id:'.$this->publicKey 	
        );
         $hmacsignature = base64_encode( hash_hmac("sha256", 'path:'.$url.'nonce:'.$nonce.'token_id:'.$this->publicKey , base64_decode( $this->privateKey ), true ) );
         $header_value = "amx " . $this->publicKey . ":" . $hmacsignature . ":" . $nonce;
         $headers = array("Content-Type: application/json;", "X-Quoine-Auth: $hmacsignature", "X-Quoine-API-Version: 2");
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($ch, CURLOPT_URL, $url );
         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $req ) );
      }
          // run the query
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE); // Do Not Cache
      $res = curl_exec($ch);
      if ($res === false) throw new Exception('Could not get reply: '.curl_error($ch));
      return $res;
   }
   public function products() {
      $result = json_decode($this->apiCall("X", array() ), true);
      return $result;
    }


}


?>