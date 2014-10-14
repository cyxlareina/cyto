<?php
$fxml=file_get_contents("try2.xml");
$xml =json_decode(json_encode((array) simplexml_load_string($fxml)), true);
//echo sizeof($xml);
//echo '<br>';
$node="";
$nodes="";
$i=0;
$all_node=$xml['entry'];
	foreach($all_node as $node_info){
		$node_id=$node_info['@attributes']['id'];
		if(!isset($node_info['graphics']['@attributes']['name'])){$name=$node_id;}
		else{$name = explode(",",$node_info['graphics']['@attributes']['name'])[0];}
		$fgcolor=$node_info['graphics']['@attributes']['fgcolor'];
		$bgcolor=$node_info['graphics']['@attributes']['bgcolor'];
		$type=$node_info['graphics']['@attributes']['type'];
		$width=$node_info['graphics']['@attributes']['width'];
		$height=$node_info['graphics']['@attributes']['height'];
		$x=$node_info['graphics']['@attributes']['x'];
		$y=$node_info['graphics']['@attributes']['y'];
		
		echo "<br>finish one node...<br>";
		
		$node="cy.add({
				group:'nodes',
				data: { id: '".$node_id."', name: '".$name."', width:".$width.",height:".$height.",fgcolor:'".$fgcolor."',bgcolor: '".$bgcolor."', faveShape: '".$type."'},
				position:{x:".$x.",y:".$y."}
			});";
		$nodes=$nodes.$node;
		$i++;			
		
		echo $nodes;
		echo '<br>';
	}
?>