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
	
		table.dataTable thead th { font-size: 15px; color: black;text-align: center;}
		a { cursor: pointer; }
		tr td { text-align: center; }
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
										<h4 class="title">Exchanges</h4>
										<p class="category">*All Exchanges</p>
									</div>
									
								</div>
                                
                            </div>
                            <div class="content">
                                <div class="row" style="margin:20px;">
									<table id="commonCurrDisplay" class="table table-condensed table-hover" width="100%"></table>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
				<input type="hidden" class="form-control" value = "-99" id="exchHiddensave">
            </div>
        </div>
    </div>
</div>
</body>
	<script type="text/javascript">
		
    	$(document).ready(function(){
			initTable();
			
			function initTable()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 2 },
					success: function (data1) {
						var arr = JSON.parse(data1);
						fillCurrTable(arr);
					},
					error: function (log) {
						console.log(log.message);
					}
				});
			}
			
			function fillCurrTable(dataSet)
			{
				$('#commonCurrDisplay').DataTable( {
					data: dataSet,
					dom: 'Bfrtip',
					buttons: [
						'pdf'
					],
					destroy: true,
					columns: [
						{ title: "Currency" },
						{ title: "Binance" },
						{ title: "Crytopia" },
						{ title: "Gate" }
					]
				});
			}
			
    	});
	</script>

</html>
