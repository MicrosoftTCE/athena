<?php

	$jsonURL = "./data/athena_master.JSON";
	chmod($jsonURL, 0644);
	$perms1 = fileperms($jsonURL);
	chmod("./data/", 0644);
	$perms2 = fileperms("./data/");
	$jsonData = file_get_contents($jsonURL);
	$json_output = json_decode($jsonData);

	$count = 0;

	$nameArr = array();
	
	//	Funding Data
	$fundArray = array();
	$fundArray[] = array();
	$fArray = array();

	//	Investing Data
	$investArray = array();
	$investArray[] = array();
	$iArray = array();

	//	Partnership or Unidentified Collaborations Data
	$porucArray = array();
	//	Affiliation Data
	$affilArray = array();

	foreach($json_output->nodes as $node)
	{
		array_push($nameArr, $node->name);
	}

	//	Enables the use of JSON 
	foreach($json_output->nodes as $node)
	{
		if($node->fundingR !== null)
		{
			//	Cannot find semicolon / One element only.
			if(strpos($node->fundingR, '; ') === false)
			{
				$fundArray[$count][0] = $node->fundingR;
			}
			else
			{
				$fundArray[$count] = explode('; ', $node->fundingR);
			}

			for($x = 0; $x < count($fundArray[$count]); $x++)
			{
				$fArray[$x] = explode(':',$fundArray[$count][$x]);
				if(in_array($fArray[$x][0], $nameArr))
				{
					array_push($json_output->fundingR, array('source' => array_search($node->name, $nameArr, true), 'target' => array_search($fArray[$x][0], $nameArr, true), 'amount' => intval($fArray[$x][1])));
					echo $fArray[$x][0] . "<br/>";

					$json_input = json_encode($json_output);
				}
				if($fArray[$x][0] === "Total")
				{
					array_push($json_output->totalFR, array('name' => $node->name, 'total' => intval($fArray[$x][1])));

					$json_input = json_encode($json_output);
						break;
				}
				if($fArray[$x][0] === "Individuals")
				{
					array_push($json_output->individualsFR, array('name' => $node->name, 'total' => intval($fArray[$x][1])));

					$json_input = json_encode($json_output);
						break;
				}
			}
		}

		if($node->investmentR !== null)
		{
			//	Cannot find semicolon / One element only.
			if(strpos($node->investmentR, '; ') === false)
			{
				$investArray[$count][0] = $node->investmentR;
			}
			else
			{
				$investArray[$count] = explode('; ', $node->investmentR);
			}

			for($x = 0; $x < count($investArray[$count]); $x++)
			{
				$iArray[$x] = explode(':',$investArray[$count][$x]);
				if(in_array($iArray[$x][0], $nameArr))
				{
					array_push($json_output->investingR, array('source' => array_search($node->name, $nameArr, true), 'target' => array_search($iArray[$x][0], $nameArr, true), 'amount' => intval($iArray[$x][1])));
					echo $iArray[$x][0] . "<br/>";

					$json_input = json_encode($json_output);
				}
				if($iArray[$x][0] === "Total")
				{
					array_push($json_output->totalIR, array('name' => $node->name, 'total' => intval($iArray[$x][1])));

					$json_input = json_encode($json_output);
						break;
				}
				if($iArray[$x][0] === "Individuals")
				{
					array_push($json_output->individualsIR, array('name' => $node->name, 'total' => intval($iArray[$x][1])));

					$json_input = json_encode($json_output);
						break;
				}
			}
		}






		if($node->poruc !== null)
		{
			//	Cannot find semicolon / One element only.
			if(strpos($node->poruc, '; ') === false)
			{
				 array_push($porucArray, $node->poruc);
			}
			else
			{
				$porucArray = explode('; ', $node->poruc);
			}

			for($x = 0; $x < count($porucArray); $x++)
			{
				if(in_array($porucArray[$x], $nameArr))
				{
					array_push($json_output->porucs, array('source' => array_search($node->name, $nameArr, true), 'target' => array_search($porucArray[$x], $nameArr, true)));

					$json_input = json_encode($json_output);
				}
			}
		}





		if($node->affil !== null)
		{
			//	Cannot find semicolon / One element only.
			if(strpos($node->affil, '; ') === false)
			{
				 array_push($affilArray, $node->affil);
			}
			else
			{
				$affilArray = explode('; ', $node->affil);
			}

			for($x = 0; $x < count($affilArray); $x++)
			{
				if(in_array($affilArray[$x], $nameArr))
				{
					array_push($json_output->affiliations, array('source' => array_search($node->name, $nameArr, true), 'target' => array_search($affilArray[$x], $nameArr, true)));

					$json_input = json_encode($json_output);
				}
			}
		}














		
		$count++;
	}
	
	$json_output = json_decode($json_input);

	$json_input = json_encode($json_output);
	$json_input == str_replace('\/', '/', $json_input);
	$file = "./data/final_data.json";
	$handle = fopen($file, 'w');
	fwrite($handle, $json_input);
	fclose($handle);
?>