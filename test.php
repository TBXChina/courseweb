<html>
<head>
<script type = "text/javascript">
function show()
{
var xmlhttp;
if (window.XMLHttpRequest) {
//code for ie7+, firefox, chrome, opera, safari
xmlhttp = new XMLHttpRequest();
}
else
{
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState == 4 && xmlhttp.status == 200 )
{
document.getElementById("mydiv").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST", "/courseweb/ajax.php", true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("b&&str=asbdfg");
}
    </script>
</head>
<body>
    <button type = "button" onclick = "show()">Request</button>
    <div id = "mydiv"></div>
</body>
</html>
