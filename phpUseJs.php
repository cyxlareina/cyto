<!DOCTYPE html>
<html>
<body>

<button onclick="myFunction()">Click me</button>

<p id="demo"></p>

<p>A function is triggered when the button is clicked. The function outputs some text in a p element with id="demo".</p>

<script>
var myFunction=function() {
	var City2 = "first";
	
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("demo").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","save.php?q="+City2+"&f=test.xml",true);
xmlhttp.send();
}
</script>
</body>
</html>
