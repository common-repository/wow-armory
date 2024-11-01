<?php
	require_once("../../../../wp-includes/class-snoopy.php");

	function getRealms($q) {
		$snoopy = new Snoopy();
		$snoopy->agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3";
		$snoopy->fetch('http://www.worldofwarcraft.com/realmstatus/status.xml');
		$output = $snoopy->results;
		$parser = xml_parser_create();
		xml_parse_into_struct($parser,$output,$vals,$index);
		xml_parser_free($parser);		
		$realmCounter = 0;
		foreach($index["R"] as $realm) {
			$ratt = $vals[$realm]["attributes"];
			if(strtolower(substr($ratt["N"],0,strlen($q)))==$q) {
				echo $ratt["N"]."\n";
				$realmCounter++;
			}
		}
		
		return $realms;
	}
	$q = strtolower($_GET["q"]);
	if (!$q) return;
	getRealms($q);
?>