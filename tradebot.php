<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Exchanges configured</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<?php include 'csslibrary.php';?>
	<?php include 'jslibrary.php';?>
	
	<style>
	
		table.dataTable thead th { font-size: 15px; color: black;}
		a { cursor: pointer; }
	</style>

</head>
<body>

<div class="wrapper">
	<?php include 'left-nav.php';?>
    <div class="main-panel">
        <?php include 'upper-nav.php';?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">                 
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
								<div class="row" style="margin:10px;">
									<div class="col-md-9">
										<h4 class="title">Trading configuration</h4>
										<p class="category">*Start Arbitrage bot</p>
									</div>
									<div class="col-md-3" style="padding-left:37px;">
										<input type="button" value="Start Bot" id="btnStartBot" >
										<input type="button" value="Stop Bot" id="btnStopBot" >
									</div>
								</div>                               
                            </div>
                            <div class="content">
                                <div class="row">
									<div class="col-xs-5">
										<select name="from[]" id="multiselect" class="form-control" size="8" multiple="multiple">
											<option value="1">eth_usdt</option>
											<option value="2">ltc_usdt</option>
											<option value="2">zec_usdt</option>
										</select>
									</div>
									
									<div class="col-xs-2">
										<button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
										<button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
										<button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
										<button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
									</div>
									
									<div class="col-xs-5">
										<select name="to[]" id="multiselect_to" class="form-control" size="8" multiple="multiple"></select>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-5">
										<h4><b>Buying exchanges</b> </h4>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-5">
										<select name="from[]" id="bying_multiselect" class="form-control" size="8" multiple="multiple">
											<option value="3">eos_usdt</option>
										</select>
									</div>
									
									<div class="col-xs-2">
										<button type="button" id="bying_multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
										<button type="button" id="bying_multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
										<button type="button" id="bying_multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
										<button type="button" id="bying_multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
									</div>
									
									<div class="col-xs-5">
										<select name="to[]" id="bying_multiselect_to" class="form-control" size="8" multiple="multiple"></select>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-5">
										<h4><b>Selling exchanges</b> </h4>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-5">
										<select name="from[]" id="selling_multiselect" class="form-control" size="8" multiple="multiple">
											
											<option value="3">eos_usdt</option>
										</select>
									</div>
									
									<div class="col-xs-2">
										<button type="button" id="selling_multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
										<button type="button" id="selling_multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
										<button type="button" id="selling_multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
										<button type="button" id="selling_multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
									</div>
									
									<div class="col-xs-5">
										<select name="to[]" id="selling_multiselect_to" class="form-control" size="8" multiple="multiple"></select>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12" >
										<input type="button" value="Save Settings" id="btnSaveSettings" >
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
				<input type="hidden" class="form-control" value = "-99" id="itemHiddensave">
            </div>
        </div>
    </div>
</div>
</body>
	<script type="text/javascript">
		var w;
    	$(document).ready(function(){
			$('#multiselect').multiselect();
			$('#selling_multiselect').multiselect();
			$('#bying_multiselect').multiselect();
			//getGateCurr();
			//getYoBit();
			getExchanges();
			$('#btnStartBot').on('click',function(){
				StartBot();
			})
			$('#btnStopBot').on('click',function(){
				StopBot();
			})
			function StartBot()
			{
				if(typeof(Worker) !== "undefined") {
					if(typeof(w) == "undefined") {
						//alert("Bot starting...");
						w = new Worker("tradeworker.js?v=1.3");
					}
				} 
				else {
					document.getElementById("result").innerHTML = "Sorry, your browser does not support Arbitrage trading...";
				}
			}
			function StopBot()
			{
				//w.terminate();
				//w = undefined;
				//getCommonCurr();
				//findDiffPercent();
				//getCommonCurrGatewithCryptopia();
				//getCommonCurrGatewithBinance();
				//getCommonCurrCryptowithBinance();
				getCommonCurrKrakenwithBinance()
				/*$.ajax({ 
					url: 'https://www.cryptopia.co.nz/api/GetCurrencies',
					type: 'GET',
					success: function (d) {
						console.log(d)
					},
					error: function (log) {
						console.log(log);
					}
				});*/
			}
			
			function getCommonCurrKrakenwithBinance()
			{
				kraken = [];
				common=[];
				getKraken(function(data1){
					d1=JSON.parse(data1);	
					console.log(d1.result)
					obj = d1.result;
					for (var key in obj) {
						if (obj.hasOwnProperty(key)) {
							var x = obj[key].altname;							
							x=x+'T'
							kraken.push(x)
						}
					}
					getBianace(function(data){
						d2=JSON.parse(data);
						console.log(d2)
						for (var key in kraken) {
							if(d2[kraken[key]] != undefined)
								common.push(kraken[key]);
						}
						console.log(common);
					})
					
				});
				
			}
			
			
			function getCommonCurrGatewithBinance()
			{
				$.ajax({ 
					url: 'http://data.gate.io/api2/1/pairs',
					type: 'GET',
					success: function (d) {
						//data=JSON.parse(d);
						console.log(d);
						getBianace(function(data){
							d1=JSON.parse(data);		
							var i=0;
							var common =[];
							for(i=0;i<d.length;i++)
							{
								var g1=(d[i].toUpperCase()).replace("_", "");
								console.log(g1);
								var obj=(d1[g1]);
								if(obj != undefined)
									common.push(d[i]);
							}
							console.log(common);
						})
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			
			function getCommonCurrCryptowithBinance()
			{
				getCryptopia(function(data){
					var pairs=data.Data;
					getBianace(function(data){
							d1=JSON.parse(data);		
							var j=0;
							var common =[];
							for(j=0; j<pairs.length;j++)
							{
								var c1=(pairs[j]['Label']).replace("/", "");;
								var obj=(d1[c1]);
								if(obj != undefined)
									common.push(pairs[j]['Label']);
							}
							console.log(common);
						})
				});
			}
			function getCommonCurrGatewithYobit()
			{
				$.ajax({ 
					url: 'http://data.gate.io/api2/1/pairs',
					type: 'GET',
					success: function (d) {
						//data=JSON.parse(d);
						getYoBit(function(data){
							d1=JSON.parse(data);
							var ser= "server_time"
							var pairs=d1["pairs"];
							var i=0;
							var common =[];
							for(i=0;i<d.length;i++)
							{
								var pair = (d[i]).indexOf("usdt") > 0 ? (d[i]).substring(0, ((d[i]).length-1)): d[i];
								var obj=(pairs[pair]);
								if(obj != undefined)
									common.push(pair);
							}
							console.log(common);
						})
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			function getCommonCurrGatewithCryptopia()
			{
				$.ajax({ 
					url: 'http://data.gate.io/api2/1/pairs',
					type: 'GET',
					success: function (d) {
						//data=JSON.parse(d);
						console.log(d);
						getCryptopia(function(data){
							//d1=JSON.parse(data);
							var ser= "server_time"
							var pairs=data.Data;
							var i=0;
							var common =[];
							for(i=0;i<d.length;i++)
							{
								var g1=(d[i].toUpperCase()).replace("_", "/");
								console.log(g1);
								for(j=0; j<pairs.length;j++)
								{
									var c1=pairs[j]['Label'];
									if(g1 == c1)
									{
										common.push(d[i]);
										break;
									}
								}
							}
							console.log(common);
						})
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			
			function getKraken(callback)
			{
				$.ajax({		
						url: 'webmethods.php',
						type: 'POST',
						data: {type: 'krakencurr'},
						success: function (d) {
							//console.log("Roneet")
							callback(d);
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			
			function getBianace(callback)
			{
				$.ajax({		
						url: 'webmethods.php',
						type: 'POST',
						data: {type: 'bincurr'},
						success: function (d) {
							callback(d);
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			function getCryptopia(callback)
			{
				$.ajax({ 
					url: 'https://www.cryptopia.co.nz/api/GetTradePairs',
					type: 'GET',
					success: function (d) {
						callback(d); 
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			function getYoBit(callback)
			{
				$.ajax({ 
					url: 'https://yobit.net/api/3/info',
					type: 'GET',
					success: function (d) {
						callback(d); 
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			function getExchanges()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 4},
					success: function (d) {
						data=JSON.parse(d);
						$('#bying_multiselect').empty().append('<option value="'+data.Exchange_Id+'">'+data.ExchangeName+'</option>');
						$('#selling_multiselect').empty().append('<option value="'+data.Exchange_Id+'">'+data.ExchangeName+'</option>');
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
    	});
	</script>

</html>
