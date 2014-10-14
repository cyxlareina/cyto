<?php
$fxml=file_get_contents("demo2.xml");
$xml =json_decode(json_encode((array) simplexml_load_string($fxml)), true);
echo sizeof($xml);
echo '<br>';
$edge="";
$edges="";
$r=0;
$all_edge=$xml['relation'];
	foreach($all_edge as $edge_info){
		$edge_s=$edge_info['@attributes']['entry1'];
		$edge_t=$edge_info['@attributes']['entry2'];
		$edge_type=$edge_info['@attributes']['type'];
		echo $edge_s."-->".$edge_t." : ".$edge_type;
		if(sizeof($edge_info['subtype'])>1){
			foreach($edge_info['subtype'] as $sub){
				echo "<br>  name =".$sub['@attributes']['name'];
				echo " value =".$sub['@attributes']['value'];
		$edge="cy.add({
				group: 'edges',
				data: {source:'".$edge_s."' , target:'".$edge_t."'}
			});";
		$edges=$edges.$edge;	
		}
		}
		else{
			echo "<br>		name= ".$edge_info['subtype']['@attributes']['name'];
			echo "		value= ".$edge_info['subtype']['@attributes']['value']; 		
		$edge="cy.add({
				group: 'edges',
				data: {source:'".$edge_s."' , target:'".$edge_t."'}
			});";
		$edges=$edges.$edge;			
		}
		echo "<br>";
		echo $edges;
		echo "<br>";
		
	}

?>