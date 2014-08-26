<?php

	$jsonURL = "./data/athena_master.JSON";
	chmod($jsonURL, 0644);
	$perms1 = fileperms($jsonURL);
	chmod("./data/", 0644);
	$perms2 = fileperms("./data/");
	$jsonData = file_get_contents($jsonURL);
	$json_output = json_decode($jsonData);
	// Print statements for testing:
	// echo json_encode($json_output);

	$count = 0;
	$nameArr = array();
	//	Funding Data
	$fundArray = array();
	$fundArray[] = array();
	//	Investing Data
	$investArray = array();
	$investArray[] = array();
	//	Partnership or Unidentified Collaborations Data
	$porucArray = array();
	$porucArray[] = array();
	//	Affiliation Data
	$affilArray = array();
	$affilArray[] = array();
	//	Array to store organizations not officially listed.
	$unorg1 = array();
	//	Original count of nodes
	$originalCount = count($json_output->nodes);

	//	Store the organizations' names into an array.
	foreach($json_output->nodes as $node)
	{
		array_push($nameArr, $node->name);
	}

	foreach($nameArr as $name)
	{
		//	Enables the use of JSON 
		foreach($json_output->nodes as $node1)
		{
			if($node1->name === $name)
			{
				//	Funding.
				//	Check if organization has funders.
				if($node1->fundingR !== "")
				{
					//	Cannot find semicolon / One element only.
					if(strpos($node1->fundingR, '; ') === false)
					{
						$fundArray[$count][0] = $node1->fundingR;
					}
					else
					{
						$fundArray[$count] = explode('; ', $node1->fundingR);
					}
					for($i = 0; $i < count($fundArray[$count]); $i++)
					{
						//	Array to store organizations not officially listed.
						$unorg2 = array();

						//	Prevent multiple insertions of singular individual listing.
						$checkIndividual = 0;

						// Print statements for testing:
						// echo $fundArray[$count][$i] . "<br/>";
						foreach($json_output->nodes as $node2)
						{	
							if($node2->name === strstr($fundArray[$count][$i], ':', true))
							{
								//	abs() accounts for dashes in names, which are recognized as negative symbols.
								array_push($json_output->fundingR, array('source' => array_search($node2->name, $nameArr, true), 'target' => $count, 'amount' => abs(filter_var($fundArray[$count][$i], FILTER_SANITIZE_NUMBER_INT))));
								// Print statements for testing:
								// echo "<br/><br/>";
								// echo json_encode($json_output);
								$json_input = json_encode($json_output);
							}
							if("Total" === strstr($fundArray[$count][$i], ':', true))
							{
								//	abs() accounts for dashes in names, which are recognized as negative symbols.
								array_push($json_output->totalFR, array('name' => $name, 'total' => abs(filter_var($fundArray[$count][$i], FILTER_SANITIZE_NUMBER_INT))));
								// Print statements for testing:
								// echo "<br/><br/>";
								// echo json_encode($json_output);
								$json_input = json_encode($json_output);
								break;
							}
							if("Individuals" === strstr($fundArray[$count][$i], ':', true) && $checkIndividual === 0)
							{
								//	abs() accounts for dashes in names, which are recognized as negative symbols.
								array_push($json_output->individualsFR, array('target' => $name, 'amount' => abs(filter_var($fundArray[$count][$i], FILTER_SANITIZE_NUMBER_INT))));
								// Print statements for testing:
								// echo "<br/><br/>";
								// echo json_encode($json_output);
								$json_input = json_encode($json_output);
								$checkIndividual++;
							}
							//	Organization not officially listed.
							if($node2->name !== strstr($fundArray[$count][$i], ':', true) && "Total" !== strstr($fundArray[$count][$i], ':', true) && "Individuals" !== strstr($fundArray[$count][$i], ':', true) && false !== strstr($fundArray[$count][$i], ':', true))
							{
								$counter = -1;
								for($j = 0; $j < count($unorg2); $j++)
								{
									if(strstr($fundArray[$count][$i], ':', true) === $unorg2[$j])
									{
										break;
									}
									else 
									{
										$counter++;
									}	
								}
								if($counter === count($unorg2) - 1)
								{
									array_push($unorg2, strstr($fundArray[$count][$i], ':', true));

									if (!in_array(strstr($fundArray[$count][$i], ':', true), $unorg1)) 
									{
    									array_push($unorg1, strstr($fundArray[$count][$i], ':', true));
    								}

									//	abs() accounts for dashes in names, which are recognized as negative symbols.
    								//	Correct numbering of already existing organizations.
    								if (!in_array(strstr($fundArray[$count][$i], ':', true), $nameArr))
    								{
    									array_push($json_output->fundingR, array('source' => count($nameArr) - 1 + array_search(strstr($fundArray[$count][$i], ':', true), $unorg1), 'target' => $count, 'amount' => abs(filter_var($fundArray[$count][$i], FILTER_SANITIZE_NUMBER_INT))));
										array_push($json_output->nodesAppend, array('src_name' => strstr($fundArray[$count][$i], ':', true), 'number' => count($nameArr) - 1 + array_search(strstr($fundArray[$count][$i], ':', true), $unorg1)));
									}
    								else
    								{
    									for($s = 0; $s < count($nameArr); $s++)
    									{
    										if(strstr($fundArray[$count][$i], ':', true) === $nameArr[$s])
    										{
    											array_push($json_output->fundingR, array('source' => $s, 'target' => $count, 'amount' => abs(filter_var($fundArray[$count][$i], FILTER_SANITIZE_NUMBER_INT))));
												array_push($json_output->nodesAppend, array('src_name' => strstr($fundArray[$count][$i], ':', true), 'number' => $s));
												break;
    										}
    									}
									}
									// Print statements for testing:
									// echo "<br/><br/>";
									// echo json_encode($json_output);
									$json_input = json_encode($json_output);
								}
							}
						}
					}
				}
				//	Investing.
				//	Check if organization has investers.
				if($node1->investmentR !== "")
				{
					//	Cannot find semicolon / One element only.
					if(strpos($node1->investmentR, '; ') === false)
					{
						$investArray[$count][0] = $node1->investmentR;
					}
					else
					{
						$investArray[$count] = explode('; ', $node1->investmentR);
					}
					for($i = 0; $i < count($investArray[$count]); $i++)
					{
						//	Array to store organizations not officially listed.
						$unorg2 = array();

						//	Prevent multiple insertions of singular individual listing.
						$checkIndividual = 0;

						// Print statements for testing:
						// echo $investArray[$count][$i] . "<br/>";
						foreach($json_output->nodes as $node2)
						{	
							if($node2->name === strstr($investArray[$count][$i], ':', true))
							{
								//	abs() accounts for dashes in names, which are recognized as negative symbols.
								array_push($json_output->investingR, array('source' => array_search($node2->name, $nameArr, true), 'target' => $count, 'amount' => abs(filter_var($investArray[$count][$i], FILTER_SANITIZE_NUMBER_INT))));
								// Print statements for testing:
								// echo "<br/><br/>";
								// echo json_encode($json_output);
								$json_input = json_encode($json_output);
							}
							if("Total" === strstr($investArray[$count][$i], ':', true))
							{
								//	abs() accounts for dashes in names, which are recognized as negative symbols.
								array_push($json_output->totalIR, array('name' => $name, 'total' => abs(filter_var($investArray[$count][$i], FILTER_SANITIZE_NUMBER_INT))));
								// Print statements for testing:
								// echo "<br/><br/>";
								// echo json_encode($json_output);
								$json_input = json_encode($json_output);
								break;
							}
							if("Individuals" === strstr($investArray[$count][$i], ':', true) && $checkIndividual === 0)
							{
								//	abs() accounts for dashes in names, which are recognized as negative symbols.
								array_push($json_output->individualsIR, array('target' => $name, 'amount' => abs(filter_var($investArray[$count][$i], FILTER_SANITIZE_NUMBER_INT))));
								// Print statements for testing:
								// echo "<br/><br/>";
								// echo json_encode($json_output);
								$json_input = json_encode($json_output);
								$checkIndividual++;
							}
							//	Organization not officially listed.
							if($node2->name !== strstr($investArray[$count][$i], ':', true) && "Total" !== strstr($investArray[$count][$i], ':', true) && "Individuals" !== strstr($investArray[$count][$i], ':', true) && false !== strstr($investArray[$count][$i], ':', true))
							{
								$counter = -1;
								for($j = 0; $j < count($unorg2); $j++)
								{
									if(strstr($investArray[$count][$i], ':', true) === $unorg2[$j])
									{
										break;
									}
									else 
									{
										$counter++;
									}	
								}
								if($counter === count($unorg2) - 1)
								{
									array_push($unorg2, strstr($investArray[$count][$i], ':', true));

									if (!in_array(strstr($investArray[$count][$i], ':', true), $unorg1)) 
									{
    									array_push($unorg1, strstr($investArray[$count][$i], ':', true));
    								}

									//	abs() accounts for dashes in names, which are recognized as negative symbols.
									//	Correct numbering of already existing organizations.
    								if (!in_array(strstr($investArray[$count][$i], ':', true), $nameArr))
    								{
    									array_push($json_output->investingR, array('source' => count($nameArr) - 1 + array_search(strstr($investArray[$count][$i], ':', true), $unorg1), 'target' => $count, 'amount' => abs(filter_var($investArray[$count][$i], FILTER_SANITIZE_NUMBER_INT))));
										array_push($json_output->nodesAppend, array('src_name' => strstr($investArray[$count][$i], ':', true), 'number' => count($nameArr) - 1 + array_search(strstr($investArray[$count][$i], ':', true), $unorg1)));
    								}
    								else
    								{
    									for($s = 0; $s < count($nameArr); $s++)
    									{
    										if(strstr($investArray[$count][$i], ':', true) === $nameArr[$s])
    										{
    											array_push($json_output->investingR, array('source' => $s, 'target' => $count, 'amount' => abs(filter_var($investArray[$count][$i], FILTER_SANITIZE_NUMBER_INT))));
												array_push($json_output->nodesAppend, array('src_name' => strstr($investArray[$count][$i], ':', true), 'number' => $s));
												break;
    										}
    									}
									}
									// Print statements for testing:
									// echo "<br/><br/>";
									// echo json_encode($json_output);
									$json_input = json_encode($json_output);
								}
							}
						}
					}
				}
				//	Affiliations
				//	Check if organization has any affiliations.
				if($node1->affil !== "")
				{
					//	Cannot find semicolon / One element only.
					if(strpos($node1->affil, '; ') === false)
					{
						$affilArray[$count][0] = $node1->affil;
					}
					else
					{
						$affilArray[$count] = explode('; ', $node1->affil);
					}
					for($i = 0; $i < count($affilArray[$count]); $i++)
					{
						//	Array to store organizations not officially listed.
						$unorg2 = array();

						//	Prevent multiple insertions of singular individual listing.
						$checkIndividual = 0;

						// Print statements for testing:
						// echo $affilArray[$count][$i] . "<br/>";
						foreach($json_output->nodes as $node2)
						{	
							if($node2->name === $affilArray[$count][$i])
							{
								//	abs() accounts for dashes in names, which are recognized as negative symbols.
								array_push($json_output->affiliations, array('source' => array_search($node2->name, $nameArr, true), 'target' => $count));
								// Print statements for testing:
								// echo "<br/><br/>";
								// echo json_encode($json_output);
								$json_input = json_encode($json_output);
							}
							//	Organization not officially listed.
							if($node2->name !== $affilArray[$count][$i] && null !== $affilArray[$count][$i])
							{
								$counter = -1;
								for($j = 0; $j < count($unorg2); $j++)
								{
									if($affilArray[$count][$i] === $unorg2[$j])
									{
										break;
									}
									else 
									{
										$counter++;
									}	
								}
								if($counter === count($unorg2) - 1)
								{
									array_push($unorg2, $affilArray[$count][$i]);

									if (!in_array($affilArray[$count][$i], $unorg1)) 
									{
    									array_push($unorg1, $affilArray[$count][$i]);
    								}

									//	abs() accounts for dashes in names, which are recognized as negative symbols.
									//	Correct numbering of already existing organizations.
    								if (!in_array($affilArray[$count][$i], $nameArr))
    								{
    									array_push($json_output->affiliations, array('source' => count($nameArr) - 1 + array_search($affilArray[$count][$i], $unorg1), 'target' => $count));
										array_push($json_output->nodesAppend, array('src_name' => $affilArray[$count][$i], 'number' => count($nameArr) - 1 + array_search($affilArray[$count][$i], $unorg1)));
    								}
    								else
    								{
    									for($s = 0; $s < count($nameArr); $s++)
    									{
    										if($affilArray[$count][$i] === $nameArr[$s])
    										{
    											array_push($json_output->affiliations, array('source' => $s, 'target' => $count));
												array_push($json_output->nodesAppend, array('src_name' => $affilArray[$count][$i], 'number' => $s));
												break;
    										}
    									}
									}
									// Print statements for testing:
									// echo "<br/><br/>";
									// echo json_encode($json_output);
									$json_input = json_encode($json_output);
								}
							}
						}
					}
				}
				//	Partnerships and Unidentified Collaborations
				//	Check if organization has any partnerships or unidentified collaborations.
				if($node1->poruc !== "")
				{
					//	Cannot find semicolon / One element only.
					if(strpos($node1->poruc, '; ') === false)
					{
						$porucArray[$count][0] = $node1->poruc;
					}
					else
					{
						$porucArray[$count] = explode('; ', $node1->poruc);
					}
					for($i = 0; $i < count($porucArray[$count]); $i++)
					{
						//	Array to store organizations not officially listed.
						$unorg2 = array();

						//	Prevent multiple insertions of singular individual listing.
						$checkIndividual = 0;

						// Print statements for testing:
						// echo $porucArray[$count][$i] . "<br/>";
						foreach($json_output->nodes as $node2)
						{	
							if($node2->name === $porucArray[$count][$i])
							{
								//	abs() accounts for dashes in names, which are recognized as negative symbols.
								array_push($json_output->porucs, array('source' => array_search($node2->name, $nameArr, true), 'target' => $count));
								// Print statements for testing:
								// echo "<br/><br/>";
								// echo json_encode($json_output);
								$json_input = json_encode($json_output);
							}
							//	Organization not officially listed.
							if($node2->name !== $porucArray[$count][$i] && null !== $porucArray[$count][$i])
							{
								$counter = -1;
								for($j = 0; $j < count($unorg2); $j++)
								{
									if($porucArray[$count][$i] === $unorg2[$j])
									{
										break;
									}
									else 
									{
										$counter++;
									}	
								}
								if($counter === count($unorg2) - 1)
								{
									array_push($unorg2, $porucArray[$count][$i]);

									if (!in_array($porucArray[$count][$i], $unorg1)) 
									{
    									array_push($unorg1, $porucArray[$count][$i]);
    								}

									//	abs() accounts for dashes in names, which are recognized as negative symbols.
									//	Correct numbering of already existing organizations.
    								if (!in_array($porucArray[$count][$i], $nameArr))
    								{
    									array_push($json_output->porucs, array('source' => count($nameArr) - 1 + array_search($porucArray[$count][$i], $unorg1), 'target' => $count));
										array_push($json_output->nodesAppend, array('src_name' => $porucArray[$count][$i], 'number' => count($nameArr) - 1 + array_search($porucArray[$count][$i], $unorg1)));
    								}
    								else
    								{
    									for($s = 0; $s < count($nameArr); $s++)
    									{
    										if($porucArray[$count][$i] === $nameArr[$s])
    										{
    											array_push($json_output->porucs, array('source' => $s, 'target' => $count));
												array_push($json_output->nodesAppend, array('src_name' => $porucArray[$count][$i], 'number' => $s));
												break;
    										}
    									}
									}
									// Print statements for testing:
									// echo "<br/><br/>";
									// echo json_encode($json_output);
									$json_input = json_encode($json_output);
								}
							}
						}
					}
				}
				$count++;
			}
		}
	}	

	$json_output = json_decode($json_input);

	foreach($json_output->nodesAppend as $nodesA)
	{
		if($nodesA->number >= $originalCount)
		{
			array_push($json_output->nodes, array('categories' => null, 'name' => $nodesA->src_name, 'nickname' => null, 'location' => null, 'fundingR' => null, 'investmentR' => null, 'yearFR' => null, 'yearIR' => null, 'people' => null, 'affil' => null, 'relatedto' => null, 'poruc' => null, 'weblink' => null, 'randeY' => null, 'rande' => null, 'grantsG' => null, 'yearG' => null, 'numemp' => null, 'tags' => null, 'twitterH' => null, 'followers' => null, 'type' => null, 'golr' => null));
		}
	}

	$json_input = json_encode($json_output);
	$json_input = str_replace('\/','/', $json_input);
	// echo $json_input;
	$file = "./data/final_data.JSON";
	$handle = fopen($file, 'w');
	fwrite($handle, $json_input);
	fclose($handle);
?>