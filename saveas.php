<?php
if(isset($_REQUEST["q"])){
$q=$_REQUEST["q"];
$f=$_REQUEST["f"];
if($f=="-"){
$myfile=fopen("test.xml","w")or die ("Unable to open file!");
fwrite($myfile,'<?xml version="1.0" ?>');
fwrite($myfile,"\n"); 
fwrite($myfile,'<!DOCTYPE pathway SYSTEM "http://www.kegg.jp/kegg/xml/KGML_v0.7.1_.dtd">');
fwrite($myfile,"\n"); 
fwrite($myfile,'<pathway>');
fwrite($myfile,"\n"); 
}else{
$fp=file($f);
$total_line=count($fp);
$i=0;
$myfile=fopen($f,"r+")or die ("Unable to open file!");
for($i=0;$i<$total_line-1;$i++){
	fgets($myfile);
}
}
//fwrite($myfile,$q); 
//fwrite($myfile,"\n"); 
$n_array=explode("---",$q);
	foreach($n_array as $n){
//		fwrite($myfile,$n);
//		fwrite($myfile,"\n"); 
		$n_attributes=explode(",",$n);
		if($n_attributes[0]=='n'){
//		fwrite($myfile,"This is an node--\n");
		$n_id=$n_attributes[1];
		$n_name=$n_attributes[2];
		$n_width=$n_attributes[3];
		$n_hight=$n_attributes[4];
		$n_fgcolor='#'.$n_attributes[5];
		$n_bgcolor='#'.$n_attributes[6];
		$n_shape=$n_attributes[7];		
		fwrite($myfile,'<entry id="'.$n_id.'" name="" type="gene" link="">'."\n");	
		fwrite($myfile,'	<graphics name="'.$n_name.'" fgcolor="'.$n_fgcolor.'" bgcolor="'.$n_bgcolor.'" type="'.$n_shape.'" x="1019" y="311" width="'.$n_width.'" height="'.$n_hight.'"/>'."\n");
		fwrite($myfile,'</entry>'."\n");
		}else if($n_attributes[0]=='e'){
//		fwrite($myfile,"This is an edge--\n");
		$e_id=$n_attributes[1];
		$e_s=$n_attributes[2];
		$e_t=$n_attributes[3];
		fwrite($myfile,'<relation entry1="'.$e_s.'"entry2="'.$e_t.'"type="PPrel">'."\n");
		fwrite($myfile,'<subtype name="activation" value="--&gt;"/>'."\n");
		fwrite($myfile,'</relation>'."\n");
		}
	}
fwrite($myfile,'</pathway>');	
echo "SAVE SUCCESSFULLY！ \n YOU CAN DOWNLOAD IT NOW.";
}else{
echo "didn't have get";
}
?>