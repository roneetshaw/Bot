<?php
	include('config.php');
	include('gateio_plugin.php');
	//include('yobit_api.php');
	include('cryptopiaAPI.php');
	include('binanceAPI.php');
	include('KrakenAPI.php');
	$type = mysqli_real_escape_string($db,$_POST['type']);
	//$yobit= new yobit_api();
	$crypotia= New Cryptopia();
	$binance= New Binance();
	$kraken= New KrakenAPI();
	function transpose($array) {
		return array_map(null, ...$array);
	}
	function getYobitbalance($yo)
	{
		return json_encode($yo->getTradeInfo());
	}
	function getGateiobalance()
	{
		$gateioBal=get_balances();
		return json_encode($gateioBal);
	}
	
	function getYobitTicker($yo,$pair)
	{
		return json_encode($yo->getTickers([$pair]));
	}
	function getGateIOTicker($pair)
	{
		return json_encode(get_ticker($pair));
	}
	
	function getCryptoPairs($cry)
	{
		return json_encode($cry->updatePrices( "GetTradePairs" ));
	}
	
	function GetCurrencies($cry)
	{
		return json_encode($cry->GetCurrencies());
	}
	function GetCryptoTicker($cry,$pair)
	{
		return json_encode($cry->getTicker($pair));
	}
	function GetBinanceCurrencies($bin)
	{
		return json_encode($bin->prices());
	}
	function GetBinanceTicker($bin,$pair)
	{
		return json_encode($bin->depth($pair));
	}
	function GetKrakenCurrencies($kraken)
	{
		return json_encode($kraken->QueryPublic('AssetPairs'));
	}
	function GetKrakenTicker($kraken,$pair)
	{
		return json_encode($kraken->QueryPublic('Ticker', array('pair' => $pair)));
	}
	if($type=="1")
	{
		$query_type = mysqli_real_escape_string($db,$_POST['query_type']);
		$exchName = mysqli_real_escape_string($db,$_POST['exchName']);
		$Status = mysqli_real_escape_string($db,$_POST['Status']);
		$APIkey1 = mysqli_real_escape_string($db,$_POST['APIkey1']);
		$APIkey2 = mysqli_real_escape_string($db,$_POST['APIkey2']);
		if($query_type == "-99")
		{
			
			$insert_query = "insert into EXCHANGE_MASTER (ExchangeName, Status, CreatedDate, APIKey1, APIKey2) values ('".$exchName."','".$Status."',CURDATE(),'".$APIkey1."','".$APIkey2."')";
			$runcheck=mysqli_query($db,$insert_query);
			if ( false===$runcheck ) {
			  printf("error: %s\n", mysqli_error($db));
			}
			else {
			  echo '1';
			}
		}
		else
		{
			$update_query = "Update EXCHANGE_MASTER set ExchangeName= '".$exchName."',Status= '".$Status."',APIKey1= '".$APIkey1."',APIKey1='".$APIkey2."' where Exchange_Id=".$query_type;
			$runcheck=mysqli_query($db,$update_query);
			if ( false===$runcheck ) {
			  printf("error: %s\n", mysqli_error($db));
			}
			else {
			  echo '1';
			}
		}
	}
	else if($type=="2")
	{
		$sql12="SELECT Exchange_Id,ExchangeName,Status,CreatedDate FROM EXCHANGE_MASTER";
		$result = mysqli_query($db,$sql12);
		$Exchange_Id = Array();$ExchangeName = Array();$Status = Array();$CreatedDate = Array();
		while ($row = mysqli_fetch_array($result)) 
		{
			$Exchange_Id[] = $row["Exchange_Id"]; 
			$ExchangeName[] = $row["ExchangeName"];
			$Status[] = $row["Status"]; 
			$CreatedDate[] = $row["CreatedDate"];
		}
		//$row = mysqli_fetch_array($result);
		$res = array($Exchange_Id, $ExchangeName,$Status,$CreatedDate);
		$res=transpose($res);
		echo json_encode($res);
	}

	else if($type=="3")
	{
		$exchId = mysqli_real_escape_string($db,$_POST['id']);
		$total_row='select * from EXCHANGE_MASTER where Exchange_Id='.$exchId;
		$result=mysqli_query($db,$total_row);
		$rows = mysqli_fetch_assoc($result);
		echo json_encode($rows);
		
	}
	else if($type=="4")
	{
		$sql4='select * from EXCHANGE_MASTER';
		$result=mysqli_query($db,$sql4);
		$rows = mysqli_fetch_assoc($result);
		echo json_encode($rows);
	}
	else if($type=="balanceGate")
	{
		echo getGateiobalance();	
	}
	else if($type=="balanceYobit")
	{
		echo getYobitbalance($yobit);
	}
	else if($type=="yobitTicker")
	{
		$pair = mysqli_real_escape_string($db,$_POST['pair']);
		echo getYobitTicker($yobit,$pair);
	}
	else if($type=="gateioTicker")
	{
		$pair = mysqli_real_escape_string($db,$_POST['pair']);
		echo getGateIOTicker($pair);
	}
	else if($type=="cryptoPairs")
	{
		$pair = getCryptoPairs($crypotia);
		echo ($pair);
	}
	else if($type=="cryptoPairs1")
	{
		$data = GetCurrencies($crypotia);
		echo ($data);
	}
	else if($type=="cryptoTicker")
	{
		$pair = mysqli_real_escape_string($db,$_POST['pair']);
		$data = GetCryptoTicker($crypotia,$pair);
		echo ($data);
	}
	else if($type=="bincurr")
	{
		$data = GetBinanceCurrencies($binance);
		echo ($data);
	}
	else if($type=="binTicker")
	{
		$pair = mysqli_real_escape_string($db,$_POST['pair']);
		$data = GetBinanceTicker($binance,$pair);
		echo ($data);
	}
	else if($type=="krakencurr")
	{
		$data = GetKrakenCurrencies($kraken);
		echo ($data);
	}
	else if($type=="krakenTicker")
	{
		$pair = mysqli_real_escape_string($db,$_POST['pair']);
		$data = GetKrakenTicker($kraken,$pair);
		echo ($data);
	}
?>