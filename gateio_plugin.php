<?php

function gateio_query($path, array $req = array()) {
	// API settings, add your Key and Secret at here
	$key = 'CFF34698-2B61-4321-9BDA-6103DF7169FF';
	$secret = '3c43ae114b91827d6d37b6f3503ba18d9b94f50c8f0e8315e5c7cdfb80cf23ff';

	// generate a nonce to avoid problems with 32bits systems
	$mt = explode(' ', microtime());
	$req['nonce'] = $mt[1].substr($mt[0], 2, 6);

	// generate the POST data string
	$post_data = http_build_query($req, '', '&');
	$sign = hash_hmac('sha512', $post_data, $secret);

	// generate the extra headers
	$headers = array(
		'KEY: '.$key,
		'SIGN: '.$sign
	);

	//!!! please set Content-Type to application/x-www-form-urlencoded if it's not the default value

	// curl handle (initialize if required)
	static $ch = null;
	if (is_null($ch)) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; gate.io PHP bot; '.php_uname('a').'; PHP/'.phpversion().')');
	}

	curl_setopt($ch, CURLOPT_URL, 'https://gate.io/api2/'.$path);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);


	// run the query
	$res = curl_exec($ch);

	if ($res === false) throw new Exception('Could not get reply: '.curl_error($ch));
	//var_dump($res);
	//print_r($res);
	$dec = json_decode($res, true);
	if (!$dec) throw new Exception('Invalid data received, please make sure connection is working and requested API exists: '.$res);

	return $dec;
}


function curl_file_get_contents($url) {

	// our curl handle (initialize if required)
	static $ch = null;
	if (is_null($ch)) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT,
			'Mozilla/4.0 (compatible; gate.io PHP bot; '.php_uname('a').'; PHP/'.phpversion().')'
			);
	}
	curl_setopt($ch, CURLOPT_URL, 'https://gate.io/api2/'.$url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	// run the query
	$res = curl_exec($ch);
	if ($res === false) throw new Exception('Could not get reply: '.curl_error($ch));
	//echo $res;
	$dec = json_decode($res, true);
	if (!$dec) throw new Exception('Invalid data: '.$res);

	return $dec;
}

function get_top_rate($currency_pair, $type='BUY') {

	$url = '1/orderBook/'.strtoupper($currency_pair);
	$json = curl_file_get_contents($url);

	$rate = 0;

	if (strtoupper($type) == 'BUY') {
		$r =  $json['bids'][0];
		$rate = $r[0];
	} else  {
		$r = end($json['asks']);
		$rate = $r[0];
	}

	return $rate;
}

function get_pairs() {

	$url = '1/pairs';
	$json = curl_file_get_contents($url);

	return $json;
}

function get_marketinfo(){

	$url = '1/marketinfo';
	$json = curl_file_get_contents($url);

	return $json;
}

function get_tickers(){

	$url = '1/tickers';
	$json = curl_file_get_contents($url);

	return $json;
}

function get_ticker($current_pairs){

	$url = '1/ticker/'.strtoupper($current_pairs);
	$json = curl_file_get_contents($url);

	return $json;
}

function get_orderbooks(){

	$url = '1/orderBooks';
	$json = curl_file_get_contents($url);

	return $json;
}

function get_orderbook($current_pairs){

	$url = '1/orderBooks/'.strtoupper($current_pairs);
	$json = curl_file_get_contents($url);

	return $json;
}

function get_trade_history($current_pairs, $tid){

	$url = '1/tradeHistory/'.strtoupper($current_pairs).'/'.$tid;
	$json = curl_file_get_contents($url);

	return $json;
}

function get_balances() {

	return gateio_query('1/private/balances');
}

function get_order_trades($order_number) {

	return gateio_query('1/private/orderTrades',
		array(
			'orderNumber' => $order_number
		)
	);
}

function withdraw($currency, $amount, $address) {

	return gateio_query('1/private/withdraw',
		array(
			'currency' => strtoupper($currency),
			'amount' => $amount,
			'address' => $address
		)
	);
}

function get_order($order_number) {

	return gateio_query('1/private/getOrder',
		array(
			'orderNumber' => $order_number
		)
	);
}

function cancel_order($order_number) {

	return gateio_query('1/private/cancelOrder',
		array(
			'orderNumber' => $order_number
		)
	);
}

function cancel_all_orders($type, $currency_pair) {

	return gateio_query('1/private/cancelAllOrders',
		array(
			'type' => $type,
			'currencyPair' => strtoupper($currency_pair)
		)
	);
}

function sell($currency_pair, $rate, $amount) {

	return gateio_query('1/private/sell',
		array(
			'currencyPair' => strtoupper($currency_pair),
			'rate' => $rate,
			'amount' => $amount,
		)
	);
}

function buy($currency_pair, $rate, $amount) {

	return gateio_query('1/private/buy',
		array(
			'currencyPair' => strtoupper($currency_pair),
			'rate' => $rate,
			'amount' => $amount,
		)
	);
}

function get_my_trade_history($currency_pair, $order_number) {

	return gateio_query('1/private/tradeHistory',
		array(
			'currencyPair' => strtoupper($currency_pair),
			'orderNumber' => $order_number
		)
	);
}

function open_orders() {

	return gateio_query('1/private/openOrders');
}

function deposit_address($currency) {

	return gateio_query('1/private/depositAddress',
		array(
			'currency' => strtoupper($currency)
		)
	);
}
?>