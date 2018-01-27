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
									<div class="col-md-3" style="padding-left:37px;">
										<input type="button" value="Add Exchange" id="btnExchAdd" >
									</div>
								</div>
                                
                            </div>
                            <div class="content">
                                <div class="row" style="margin:20px;">
									<table id="exchangeDisplay" class="table table-condensed table-hover" width="100%"></table>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
				<input type="hidden" class="form-control" value = "-99" id="exchHiddensave">
            </div>
        </div>
    </div>
	<div class="modal fade" id="addExchModal" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-sm-4">
						<h4 class="modal-title">Add an Exchange</h4>
					</div>
					<div class="col-sm-6" style="text-align:center">
						
					</div>
					<div class="col-sm-2">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-6" style="text-align:center;">
						<label for="usr">Exchanges</label>
						<div class="dropdown" id="exchType" style="text-align:center;">
							<button class="btn btn-default dropdown-toggle" id="exchangeDisplayModal" style="width:250px" type="button" data-toggle="dropdown">Select an Exchange 
							<span class="caret"></span></button>
						    <ul class="dropdown-menu" style="margin-left:10px;width:250px;"  id="drpExchangeSelect">
								<li><a href="#">Gate.io</a></li>
								<li><a href="#">Yobit</a></li>
						    </ul>
						</div>
					</div>
					<div class="col-sm-6" style="text-align:center;">
						<label for="usr">Status</label>
						<div class="dropdown" id="exchStatus" style="text-align:center;">
							<button class="btn btn-default dropdown-toggle" id="exchangeStatusModal" style="width:250px" type="button" data-toggle="dropdown">Status 
							<span class="caret"></span></button>
						    <ul class="dropdown-menu" style="margin-left:10px;width:250px;"  id="drpExchangeStatus">
								<li><a href="#">Active</a></li>
								<li><a href="#">Expired</a></li>
						    </ul>
						</div>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-6">
						<label for="usr">Secret Key</label>
						<input type="text" class="form-control" id="itemAPICode1">
					</div>
					<div class="col-sm-6">
						<label for="usr">API Key</label>
						<input type="text" class="form-control" id="itemAPICode2">
					</div>
				</div>
				<br/>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="btnItemSave">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>
		  
		</div>
	</div>
</div>
</body>
	<script type="text/javascript">
		
    	$(document).ready(function(){
			initTable();
			$("#drpExchangeSelect li").on('click',function(){
				$("#exchangeDisplayModal").html($(this).text().trim()+' <span class="caret"></span>')
			})
			$("#drpExchangeStatus li").on('click',function(){
				$("#exchangeStatusModal").html($(this).text().trim()+' <span class="caret"></span>')
			})
			function clearFields()
			{
				$("#addExchModal input").val("");
			}
			function initTable()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 2 },
					success: function (data1) {
						var arr = JSON.parse(data1);
						fillItemTable(arr);
					},
					error: function (log) {
									console.log(log.message);
					}
				});
			}
			
			function fillItemTable(dataSet)
			{
				$('#exchangeDisplay').DataTable( {
					data: dataSet,
					dom: 'Bfrtip',
					buttons: [
						'pdf'
					],
					destroy: true,
					columns: [
						{ title: "Sr. no." },
						{ title: "Exchange Name" },
						{ title: "Status" },
						{ title: "Created Date" }
					]
				});
			}
			function saveExchangeinDB()
			{
				$.ajax({ 
					url: 'webmethods.php',
					type: 'POST',
					data: {type: 1, exchName: rm($('#exchangeDisplayModal')),Status: rm($('#exchangeStatusModal')), APIkey1:$("#itemAPICode1").val().trim(),APIkey2:$("#itemAPICode2").val().trim(), query_type: $("#exchHiddensave").val() },
					success: function (d) {
						initTable();
						if(d == "1")
							$("#addExchModal").modal('hide');
					},
					error: function (log) {
						console.log(log);
					}
				});
			}
			$("#btnItemSave").on('click',function(){
				if($("#exchangeDisplayModal").text().trim() != "Select an Exchange" && $("#itemAPICode1").val().length > 0)
				{
					saveExchangeinDB();
				}
				else
					alert("Please Select and Exchange");
			})
			$("#btnExchAdd").on('click',function(){
				clearFields();
				$("#exchType button").html('Select an Exchange<span class="caret"></span>');
				$("#addExchModal").modal('show');
			})
			function rm(element)
			{
				return element.text().trim()
			}
			$("#exchangeDisplay").on('click','tbody tr',function(){
				exchId=$(this).find(':nth-child(1)').text().trim();
				$("#exchHiddensave").val(exchId);
				$.ajax({ 
							url: 'webmethods.php',
							type: 'POST',
							data: {type: 3, id: exchId },
							success: function (d) {
								dataRET=JSON.parse(d);
								$("#itemAPICode1").val(dataRET.APIKey1); $("#itemAPICode2").val(dataRET.APIKey2);
								$("#exchangeDisplayModal").html(dataRET.ExchangeName+'  '+'<span class="caret"></span></button>'); 
								$("#exchangeStatusModal").html(dataRET.Status+'  '+'<span class="caret"></span></button>'); 
							},
							error: function (log) {
								console.log(log);
							}
				});
				$("#addExchModal").modal('show');
			});
    	});
	</script>

</html>
