<!DOCTYPE html>
<?php
$filename="try.xml";
$fxml=file_get_contents("try.xml");
$xml =json_decode(json_encode((array) simplexml_load_string($fxml)), true);
//echo sizeof($xml);
//echo '<br>';
$node="";
$nodes="";
$i=0;
$all_node=$xml['entry'];
	foreach($all_node as $node_info){
		// all the information for a node from the file
		$node_id=$node_info['@attributes']['id'];
		
		if(!isset($node_info['graphics']['@attributes']['name'])){$name=$node_id;}
		else{$name = explode(",",$node_info['graphics']['@attributes']['name'])[0];}
		
		$fgcolor=$node_info['graphics']['@attributes']['fgcolor'];
		
		$bgcolor=$node_info['graphics']['@attributes']['bgcolor'];
		
		$type=$node_info['graphics']['@attributes']['type'];
		if($type=="circle"){$type="ellipse";}
		
		$width=$node_info['graphics']['@attributes']['width'];

		$height=$node_info['graphics']['@attributes']['height'];

		$x=$node_info['graphics']['@attributes']['x'];

		$y=$node_info['graphics']['@attributes']['y'];
		
//		echo "<br>finish one node...<br>";
		
		$node="cy.add({
				group:'nodes',
				data: { id: '".$node_id."', name: '".$name."', width:".$width.",height:".$height.",fgcolor:'".$fgcolor."',bgcolor: '".$bgcolor."', faveShape: '".$type."'},
				position:{x:".$x.",y:".$y."}
			});";
		$nodes=$nodes.$node;
		$i++;			
		
//		echo $nodes;
//		echo '<br>';
	}

$edge="";
$edges="";
$r=0;
if(isset($xml['relation'])){
$all_edge=$xml['relation'];
	foreach($all_edge as $edge_info){
		$edge_s=$edge_info['@attributes']['entry1'];
		$edge_t=$edge_info['@attributes']['entry2'];
		$edge_type=$edge_info['@attributes']['type'];
//		echo $edge_s."-->".$edge_t." : ".$edge_type;
		if(sizeof($edge_info['subtype'])>1){
			foreach($edge_info['subtype'] as $sub){
//				echo "<br>  name =".$sub['@attributes']['name'];
//				echo " value =".$sub['@attributes']['value'];
		$edge="cy.add({
				group: 'edges',
				data: {source:'".$edge_s."' , target:'".$edge_t."'}
			});";
		$edges=$edges.$edge;	
		}
		}
		else{
//			echo "<br>		name= ".$edge_info['subtype']['@attributes']['name'];
//			echo "		value= ".$edge_info['subtype']['@attributes']['value']; 		
		$edge="cy.add({
				group: 'edges',
				data: {source:'".$edge_s."' , target:'".$edge_t."'}
			});";
		$edges=$edges.$edge;			
		}
//		echo "<br>";
//		echo $edges;
//		echo "<br>";
		
	}		
}
?>

<html>
<head>
<meta name="description" content="[Visual style example]" />
<script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-2.1.1.min.js"></script><meta charset=utf-8 />
<title>Visual style example</title>
  <script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>
  <link href= 'body.css' type="text/css" rel="Stylesheet"/>
<script>
		//an array store all the drawing information use for people to cancel the step
		var drawList = new Array();
		//draw times
		var drawIndex = -1;
		
		//new elements id
		var node_ele_num=0;
		var edge_ele_num=0;	

$(function(){ // on dom ready
	initCy();
	var cy=$('#cy').cytoscape('get');
});

var initCy=function(){
$('#cy').cytoscape({
  style: cytoscape.stylesheet()
    .selector('node')
      .css({
        'shape': 'data(faveShape)',
        'width': 'data(width)',
		'height': 'data(height)',
        'content': 'data(name)',
        'text-valign': 'center',
        'background-color': 'data(bgcolor)',
        'color': 'data(fgcolor)',
		'font-size':5
      })
    .selector(':selected')
      .css({
        'border-width': 3,
        'border-color': '#333'
      })
    .selector('edge')
      .css({
        'target-arrow-shape': 'triangle',
		'target-arrow-color': 'black',
		'line-color': '#333'
      })
    .selector('edge.questionable')
      .css({
        'line-style': 'dotted',
        'target-arrow-shape': 'diamond'
      })
    .selector('.faded')
      .css({
        'opacity': 0.25,
        'text-opacity': 0
      }),
  
  elements: {
    nodes: [
	]
  },
  
  ready: function(){
    window.cy = this;    
    // giddy up
  }
});
}

//upload file and draw
var myFunction=function() {



<?php
	echo $nodes;
	echo $edges;
?>
    document.getElementById("demo").innerHTML = <?php echo $i; ?>;			
}

//show shape selector	
var showShape = function(obj){
	var top = $(obj).offset().top;
	console.log(top);
	var left = $(obj).offset().left+42;		
	document.getElementById("shape").style.left = left + "px";
	document.getElementById("shape").style.top = top + "px";
	$("#shape").fadeToggle();
	$("#savechoosen").fadeOut();
}

//show save selector
var showSave = function(obj){
	var top = $(obj).offset().top;
	console.log(top);
	var left = $(obj).offset().left+42;		
	document.getElementById("savechoosen").style.left = left + "px";
	document.getElementById("savechoosen").style.top = top + "px";
	$("#savechoosen").fadeToggle();
	$("#shape").fadeOut();
}

var draw_graph = function(graphType,obj){
	
	chooseImg(obj);

	function chooseImg(obj){
		var imgAry  = $("#drawController img");
		for(var i=0;i<imgAry.length;i++){
			$(imgAry[i]).removeClass('border_choose');
			$(imgAry[i]).addClass('border_nochoose');				
		}
		$(obj).removeClass("border_nochoose");
		$(obj).addClass("border_choose");
	}
	
	if(graphType == 'node1'){
		var node_name=prompt("Please enter the name of the node", "@_@");
		if (node_name != null) {
			node_ele_num++;
			var node_ele_id="n"+node_ele_num;
			cy.add({
				group: "nodes",
				data: { id: node_ele_id, name:node_name, width:20,height:20,fgcolor:'#000000',bgcolor: '#ffffff', faveShape: 'ellipse'},
				position: { x: 200, y: 200 }
			});
			AddstepToArray("n,"+node_ele_id+","+node_name+",20,20,000000,ffffff,ellipse");
		}
		$(".shape").fadeOut();
	}
	
	if(graphType == 'node2'){
		var node_name=prompt("Please enter the name of the node", "@_@");
		if (node_name != null) {
			node_ele_num++;
			var node_ele_id="n"+node_ele_num;
			cy.add({
				group: "nodes",
				data: { id: node_ele_id, name:node_name, width:46,height:17,fgcolor:'#000000',bgcolor: '#BFFFBF', faveShape: 'rectangle'},
				position: { x: 200, y: 250 }
			});
			AddstepToArray("n,"+node_ele_id+","+node_name+",46,17,000000,BFFFBF,rectangle");
		}
		$(".shape").fadeOut();
	}
	
	if(graphType == 'node3'){
		var node_name=prompt("Please enter the name of the node", "@_@");
		if (node_name != null) {
			node_ele_num++;
			var node_ele_id="n"+node_ele_num;
			cy.add({
				group: "nodes",
				data: { id: node_ele_id, name:node_name, width:275,height:25,fgcolor:'#000000',bgcolor: '#FFFFFF', faveShape: 'roundrectangle'},
				position: { x: 200, y: 300 }
			});
			AddstepToArray("n,"+node_ele_id+","+node_name+",275,25,000000,FFFFFF,roundrectangle");
		}
		$(".shape").fadeOut();
	}	
	
	if(graphType == 'link'){
	$(".shape").fadeOut();
	alert("Please choose the source first and then target." );
		var s;
		var t;
		var num_of_s=0;
		var num_of_t=0;		
			cy.on('tap', 'node', function(e){
				
				var n = e.cyTarget;
				if(num_of_s==0) {s=n.data('id'); num_of_s++;}
				else if (num_of_t==0) {t=n.data('id');num_of_t++;}					
				if(num_of_s==1 && num_of_t==1)
				{
				edge_ele_num++;
				var edge_ele_id="edge"+edge_ele_num;
					cy.add({
						group: "edges",
						data: { id:edge_ele_id, source:s , target:t}
					});
					AddstepToArray("e,"+edge_ele_id+","+s+","+t);
					num_of_s=-1;
					num_of_t=-1;
					s="";
					t="";
					alert("Successfully draw the line!");
					no_image_choose();
				}
			
			});
	}

}

var redraw=function(){
	window.location.reload()
}

//cancel the drawing
var cancel_d=function(){
	$(".shape").fadeOut();
	no_image_choose();
	if(drawIndex>-1){
	var step=drawList[drawIndex];
	drawIndex--;
	var step_split=step.split(",");
	console.log(step_split[0]+"----index="+drawIndex);
		var remove_id="#"+step_split[1];	
		var j=cy.$(remove_id); 
		cy.remove(j);
	}
	else{
	alert("no more step to be cancle!");
	}
}

//recover the drawing
var next_d=function(){
	$(".shape").fadeOut();
	no_image_choose();
	if(drawIndex>drawList.length-2){
		alert("no more step can be redo!")
	}
	else{
		drawIndex++;
		var step=drawList[drawIndex];
		var step_split=step.split(",");
		if(step_split[0]=='n'){
		var r_node_id=step_split[1];
		var r_node_name=step_split[2];
		var r_node_width=step_split[3];
		var r_node_hight=step_split[4];
		var r_node_fgcolor='#'+step_split[5];
		var r_node_bgcolor='#'+step_split[6];
		var r_node_shape=step_split[7];
		cy.add({
				group: "nodes",
				data: { id: r_node_id,name :r_node_name,width:r_node_width,height:r_node_hight,fgcolor:r_node_fgcolor,bgcolor:r_node_bgcolor,faveShape: r_node_shape},
				position: { x: 200, y: 200 }
			});
		console.log("redo make node :" +step);
		}
		if(step_split[0]=='e'){
		var r_edge_id=step_split[1];
		var r_edge_s=step_split[2];
		var r_edge_t=step_split[3];
				cy.add({
					group: "edges",
					data: { id:r_edge_id, source:r_edge_s , target:r_edge_t}
				});		
		console.log("redo make edge :" +step);
		}
	}
	
}

//store the drawing information 
var AddstepToArray=function(step){
	while (drawIndex<drawList.length-1){
		drawList.pop();
	}
	drawIndex=drawList.push(step)-1;
	console.log("drawIndex=" +drawIndex+" arraylen="+drawList.length);
}

//not drawing something
var no_image_choose=function(){
		var imgAry  = $("#drawController img");
		for(var i=0;i<imgAry.length;i++){
			$(imgAry[i]).removeClass('border_choose');
			$(imgAry[i]).addClass('border_nochoose');				
		}
}		

var save=function(save_type){
	var o_file="-";
	if(save_type==0){
	<?php
	echo ' o_file="'.$filename.'";';
	?>
	}
	var index=0;
	var save_str="";
	var list="";
	for(index=0;index<=drawIndex;index++){
		if(index==0){
		save_str=drawList[index];
		}else{
		save_str=save_str+"---"+drawList[index];
		}
	}
	console.log(save_str);

	var xmlhttp;

	if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
	else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			console.log(xmlhttp.responseText);
			alert(xmlhttp.responseText);
		}
	}
	xmlhttp.open("GET","saveas.php?q="+save_str+"&f="+o_file,true);
	xmlhttp.send();	
console.log(o_file);
}
</script>
 </head>
<body>
	<div id="cy"></div>
	<div id="drawController">
			<img src = 'image/pencil.png' width = '40px;' height = '40px;' class="img border_nochoose" onclick="showShape(this)" title = 'node'/><br/>
			<img src = 'image/line.png' width = '40px;' height = '40px;' class="img border_nochoose" onclick="draw_graph('link',this);"  title = 'link'/><br/>
			<img src = 'image/cancel.png' width = '40px;' height = '40px;' class="img border_nochoose" onclick="cancel_d()" title = 'cancel'/><br/>
			<img src = 'image/next.png' width = '40px;' height = '40px;' class="img border_nochoose" onclick="next_d()" title = 'next'/><br/>
			<img src = 'image/xx.png' width = '40px;' height = '40px;' class="img border_nochoose" onclick="redraw()" title = 'clean'/><br/>
			<img src = 'image/save.png' width = '40px;' height = '40px;' class="img border_nochoose" onclick="showSave(this)" title = 'save'/><br/>
			<a href="test.xml" download="test"  id="downloadImage_a">
			<img src = 'image/download.png' width = '40px;' height = '40px;' class="img border_nochoose" title = 'download' onclick="downloadImage();"/>
			</a>
			<button onclick="myFunction()">Click me</button><br>
			<p id="demo"></p>			
			<br/>			
	</div>
	
	<div id="shape" class="shape">
		<img src = 'image/node1.png' width = '38px;' height = '38px;' onclick="draw_graph('node1',this)" title = 'node'/>
		<img src = 'image/node2.png' width = '38px;' height = '38px;' onclick="draw_graph('node2',this)" title = 'node'/>
		<img src = 'image/node3.png' width = '38px;' height = '38px;' onclick="draw_graph('node3',this)" title = 'node'/>
	</div>
	
	<div id="savechoosen" class="shape">
		<img src = 'image/save.png' width = '38px;' height = '38px;' onclick="save(0)" title = 'node'/>
		<img src = 'image/saveas.png' width = '38px;' height = '38px;' onclick="save(1)" title = 'node'/>
	</div>	
</body>
</html>