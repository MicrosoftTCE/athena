<?php
	if(isset($_POST['nodes']))
	{	
		$file = "./data/athena_master.JSON";
		$handle = fopen($file, 'w');
		$data = $_POST['nodes'];
		$manipulatedData = str_replace("\\\"", "", str_replace("\"null\"", "null", str_replace("\\r", "", stripslashes(substr($data, 1, -1)))));
		echo $data;
		//	$formatData = '{ "nodes": ' . $manipulatedData . '}';
		$formatData = '{ "nodes": ' . $manipulatedData . ', "affiliations":[], "investingR":[], "fundingR":[], "porucs":[], "totalFR":[], "totalIR":[], "individualsFR":[], "individualsIR":[]}';
		fwrite($handle, $formatData);
		fclose($handle);
	}
?>


