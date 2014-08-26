<?php

    session_start();

    require_once("twitteroauth-master/twitteroauth/twitteroauth.php");

    $apikey = "79XS8LGTgixY6rk7Ubda2c6xs";
    $apisecret = "wqTTxjJvQclJY4h20NMT2e25ousrHmzl29hU8W0mpoxYVeHSwc";
    $accesstoken = "2564117432-NLs5m1J9bokmlmR8kekxkW4ljOk5TnWd3aphhr1";
    $accesssecret = "tvHuoGEeQ32TnEi9SqVFy08YPzTu9Nn1t1oqKh6AYeDCM";

    $connection = new TwitterOAuth($apikey, $apisecret, $accesstoken, $accesssecret);

    $count = 0;
    $alreadyAdded = 0;

    $newCsvData = array();
    if (($handle = fopen("d:\home\site\wwwroot\data\organizations.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 4096, ",")) !== FALSE) 
        {
            if($count > 0)
            {
            	if($alreadyAdded === 1)
            	{		

            		if($data[count($data) - 3] === 'null')
            		{
            			$data[count($data) - 2] = $data[count($data) - 3];
            		}
    				else

                        
    				{	

            			$response = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . str_replace('@', '', $data[count($data) - 3])); 

                    
                    foreach($response as $tweet)
            		{
            				$data[count($data) - 2] = $tweet->user->followers_count;
            				break;
            		}
            		}
            		$newCsvData[] = $data;
            	}
            	else
            	{

            		if($data[count($data) - 2] === 'null')
            		{
            			$data[count($data) - 1] = $data[count($data) - 2];
            		}
            		else
            		{
            			$response = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . str_replace('@', '', $data[count($data) - 2])); 
    	        		foreach($response as $tweet)
    	        		{
    	        				$data[count($data) - 1] = $tweet->user->followers_count;
    	        				break;
    	        		}

            		}

            	    $newCsvData[] = $data;
            	}
           	}
            else
            {
            	if($data[count($data) - 2] === 'Number of Twitter Followers')
            	{
            		$data[count($data) - 2] = 'Number of Twitter Followers';
            		$newCsvData[] = $data;
            		$alreadyAdded = 1;
            	}
            	else
            	{ 
            		$data[count($data) - 1] = 'Number of Twitter Followers';
            		$newCsvData[] = $data;
            	}
            	$count++;
            }
        }
        fclose($handle);
    }
$handle = fopen('d:\home\site\wwwroot\data\organizations.csv', 'w');

// $delimiter = '"';
// $separator = ',';

    foreach ($newCsvData as $line) {
        fputcsv($handle,$line,',','"');
       // fwrite($handle, $delimiter.implode($delimiter.$separator.$delimiter, $line).$delimiter."\n");
       // fputcsv($handle,$line,',','"');
    }
    fclose($handle);

?> 