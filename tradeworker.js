
function startautomaticTrade()
{
	importScripts("workerFakeDOM.js");
    importScripts("http://code.jquery.com/jquery-2.1.4.min.js");
	console.log("JQuery version:", $.fn.jquery);
	/*getbalancefromBuyExchange(function(data) {
        console.log(data);
    });*/
}
function getbalancefromBuyExchange(callback)
{
	$.ajax({		
			url: 'webmethods.php',
			type: 'POST',
			data: {type: 'balanceYobit'},
			success: function (d) {
				data=JSON.parse(d);
				callback(data);
		},
		error: function (log) {
			console.log(log);
		}
	});
}
/*function findDiffPercent()
{
				
					console.log(i);
					var pairG = (com[i]).indexOf("usd") > 0 ? (com[i]+"t"): com[i];
					//console.log(pairG+" "+com[i]);
					GetGateIOTicker(pairG,function(dataG){
						var y1 = dataG.highestBid;
						GetYoBitTicker(com[i],function(dataY){
							var x1 = dataY[com[i]].sell;
							var val=(100.0*(x1-y1))/y1;
							console.log(com[i] +" "+ val + " "+x1+" "+y1);
							i++
						});
					});
					break;
				}
				
}*/

function GetKrakenIOTickerwithBinance(i)
{
	
	var com= ["ETHUSDT", "LTCUSDT"];
	var com1= ["XETHZUSD", "XLTCZUSD"];
	if (i>=com.length)
		return 0;
	else
	{
		if((com[i]).indexOf("usd") > -99)
		{
			var pairK= com1[i].toUpperCase();
			GetKrakenTicker(pairK,function(dataC){
				//data=JSON.parse(dataC);
				//console.log(dataC);
				var y1 = dataC[pairK].a[0];
				//console.log(y1.a)
				pairB=(com[i].toUpperCase());
				GetBinanceTicker(pairB,function(dataC){
					var x1 = dataC.bids[0][0];
					var val=(100.0*(x1-y1))/x1;
					console.log(com[i] +": "+ val + "% ");
					i=i+1;
					GetKrakenIOTickerwithBinance(i);	
				});
			});
					
		}
		else
		{
			i=i+1;
			GetKrakenIOTickerwithBinance(i);
		}	
	}
}


function GetCryptoIOTickerwithBinance(i)
{
	
	var com= ["BTC/USDT", "LTC/BTC", "LTC/USDT", "XVG/BTC", "XMR/BTC", "NAV/BTC", "ETC/BTC", "CMT/BTC", "BTG/BTC", "XZC/BTC", "ZEC/BTC", "STRAT/BTC", "KMD/BTC", "ARK/BTC", "DASH/BTC", "FUEL/BTC", "ETH/BTC", "ETH/USDT", "OMG/BTC", "NEO/BTC", "MTL/BTC", "NEBL/BTC", "CTR/BTC", "KNC/BTC", "HSR/BTC", "ENJ/BTC", "POWR/BTC", "BCPT/BTC"];
	if (i>=com.length)
		return 0;
	else
	{
		if((com[i]).indexOf("usd") > -99)
		{
			var pairC= (com[i].toUpperCase()).replace("/", "_");
			GetCryptopiaTicker(pairC,function(dataC){
				//data=JSON.parse(dataC);
				var y1 = dataC.AskPrice;
				pairB=(com[i].toUpperCase()).replace("/", "");
				GetBinanceTicker(pairB,function(dataC){
					var x1 = dataC.bids[0][0];
					var val=(100.0*(x1-y1))/x1;
					console.log(com[i] +": "+ val + "% ");
					i=i+1;
					GetCryptoIOTickerwithBinance(i);	
				});
			});
					
		}
		else
		{
			i=i+1;
			GetCryptoIOTickerwithBinance(i);
		}	
	}
}


function GetGateIOTickerwithBinance(i)
{
	
	var com= ["btc_usdt", "eth_usdt", "ltc_usdt", "cdt_eth", "rdn_eth", "knc_eth", "link_eth", "req_eth", "rcn_eth", "trx_eth", "arn_eth", "bnt_eth", "ven_eth", "mco_eth", "fun_eth", "rlc_eth", "wings_eth", "ctr_eth", "mda_eth", "ost_eth", "mana_eth", "lun_eth", "salt_eth", "fuel_eth", "elf_eth", "lend_eth", "icx_eth", "ada_btc", "lsk_btc", "waves_btc", "dgd_eth", "powr_eth", "powr_btc", "bcd_btc", "hsr_btc", "hsr_eth", "qsp_eth", "neo_usdt", "neo_btc", "gas_btc", "iota_btc", "eth_btc", "etc_btc", "etc_eth", "zec_btc", "dash_btc", "ltc_btc", "btg_btc", "qtum_btc", "qtum_eth", "xrp_btc", "xmr_btc", "zrx_btc", "zrx_eth", "dnt_eth", "oax_eth", "lrc_eth", "lrc_btc", "tnt_eth", "snt_eth", "snt_btc", "omg_eth", "omg_btc", "bat_eth", "bat_btc", "storj_eth", "storj_btc", "eos_eth", "eos_btc", "bts_btc"];
	if (i>=com.length)
		return 0;
	else
	{
		if((com[i]).indexOf("usd") > -99)
		{
			var pairG = com[i];
			$.ajax({ 
				url: 'webmethods.php',
				type: 'POST',
				data: {type: "gateioTicker",pair: pairG},
				success: function (d) {
					data=JSON.parse(d);
					//console.log(data)
					var y1 = data.lowestAsk;
					pairB=(com[i].toUpperCase()).replace("_", "");
					GetBinanceTicker(pairB,function(dataC){
						var x1 = dataC.bids[0][0];
						var val=(100.0*(x1-y1))/x1;
						console.log(com[i] +": "+ val + "% ");
						i=i+1;
						GetGateIOTickerwithBinance(i);	
					});
					
				},
				error: function (log) {
					console.log(log);
				}
			});
		}
		else
		{
			i=i+1;
			GetGateIOTickerwithBinance(i);
		}	
	}
}


function GetGateIOTickerwithCryptopia(i)
{
	
	var com= ["btc_usdt", "bch_usdt", "eth_usdt", "etc_usdt", "ltc_usdt", "dash_usdt", "zec_usdt", "xmr_usdt", "doge_usdt", "powr_btc", "hsr_btc", "neo_btc", "eth_btc", "etc_btc", "zec_btc", "dash_btc", "ltc_btc", "bch_btc", "btg_btc", "doge_btc", "xmr_btc", "btm_btc", "omg_btc", "pay_btc"];
	if (i>=com.length)
		return 0;
	else
	{
		if((com[i]).indexOf("usd") > 0)
		{
			var pairG = com[i];
			$.ajax({ 
				url: 'webmethods.php',
				type: 'POST',
				data: {type: "gateioTicker",pair: pairG},
				success: function (d) {
					data=JSON.parse(d);
					//console.log(data)
					var y1 = data.lowestAsk; 
					GetCryptopiaTicker(com[i],function(dataC){
						var x1 = dataC.BidPrice;
						var val=(100.0*(x1-y1))/x1;
						console.log(com[i] +": "+ val + "% ");
						i=i+1;
						GetGateIOTickerwithCryptopia(i);	
					});
					
				},
				error: function (log) {
					console.log(log);
				}
			});
		}
		else
		{
			i=i+1;
			GetGateIOTickerwithCryptopia(i);
		}	
	}
}

function GetGateIOTicker(i)
{
	
	var com= ["btc_usd", "eth_usd", "etc_usd", "ltc_usd", "dash_usd", "zec_usd", "eos_usd", "req_usd", "omg_usd", "pay_usd", "tnt_usd", "doge_usd", "bat_usd", "btg_usd", "lrc_usd", "storj_usd", "knc_usd", "knc_eth", "req_eth", "rcn_eth", "trx_eth", "kick_eth", "bnt_eth", "mco_eth", "rcn_usd", "trx_usd", "kick_usd", "mco_usd", "gnt_usd", "gnt_eth", "mdt_usd", "mdt_eth", "mdt_btc", "lun_usd", "lun_eth", "lsk_usd", "lsk_btc", "waves_usd", "waves_btc", "dgd_usd", "dgd_eth", "bcd_usd", "bcd_btc", "sbtc_usd", "sbtc_btc", "god_usd", "god_btc", "bot_usd", "bot_eth", "eth_btc", "etc_btc", "etc_eth", "zec_btc", "dash_btc", "ltc_btc", "btg_btc", "doge_btc", "rep_eth", "lrc_eth", "lrc_btc", "tnt_eth", "omg_eth", "omg_btc", "pay_eth", "pay_btc", "bat_eth", "bat_btc", "storj_eth", "storj_btc", "eos_eth", "eos_btc", "bts_usd", "bts_btc"];
	if (i>=com.length)
		return 0;
	else
	{
		if((com[i]).indexOf("usd") > 0)
		{
			var pairG = (com[i]).indexOf("usd") > 0 ? (com[i]+"t"): com[i];
			$.ajax({ 
				url: 'webmethods.php',
				type: 'POST',
				data: {type: "gateioTicker",pair: pairG},
				success: function (d) {
					data=JSON.parse(d);
					var y1 = data.highestBid; 
					GetYoBitTicker(com[i],function(dataY){
									var x1 = dataY[com[i]].sell;
									var val=(100.0*(x1-y1))/x1;
									console.log(com[i] +" "+ val + "% " +i);
									
									i=i+1;
									GetGateIOTicker(i);
					});
					
				},
				error: function (log) {
					console.log(log);
				}
			});
		}
		else
		{
			i=i+1;
			GetGateIOTicker(i);
		}	
	}
}
			function GetYoBitTicker(pair,callback)
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: "yobitTicker",pair: pair},
					success: function (d) {
						data=JSON.parse(d);
						
						callback(data)
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			function GetCryptopiaTicker(pair,callback)
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: "cryptoTicker",pair: pair},
					success: function (d) {
						data=JSON.parse(d);
						callback(data.Data)
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			function GetBinanceTicker(pair,callback)
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: "binTicker",pair: pair},
					success: function (d) {
						data=JSON.parse(d);
						callback(data)
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			function GetKrakenTicker(pair,callback)
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: "krakenTicker",pair: pair},
					success: function (d) {
						data=JSON.parse(d);				
						callback(data.result)
					},
					error: function (log) {
						console.log(log);
					}
				});
			}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
startautomaticTrade();
//GetGateIOTicker(0);
//GetGateIOTickerwithCryptopia(0);
//GetCryptoIOTickerwithBinance(0);
GetKrakenIOTickerwithBinance(0);