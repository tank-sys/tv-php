<?php 

//////Baca Data
$data = file_get_contents("tv.txt");
$rows = explode("#", $data);
$rows = array_map("trim", $rows);
$rowCount = count($rows);

function CountCol($data){
    $col = explode("*", $data);
    return count($col);
}

for ($i=1; $i <$rowCount ; $i++) { 
    for ($j=1; $j < CountCol($rows[$i]) ; $j++) { 
        $column = explode("*", $rows[$i]);
        $nama[$i]  = $column[0];
        $logo[$i]  = $column[1];
        $alamat[$i]  = $column[2]; 
        $frame[$i]  = $column[3];
    }
}
 
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel='shortcut icon' href='https://tink.web.id/favicon.ico'/>
<style>
.sidepanel{width:0;background-color:#0f0f0f;
position:fixed;z-index:1;height:100%;top:0;left:0;overflow-x:hidden;transition:.5s;padding-top:60px}.sidepanel a{padding:8px 8px 8px 8px;text-decoration:none;font-size:25px;color:#818181;display:block;transition:.3s}.sidepanel a:hover{color:#f1f1f1}.sidepanel .closebtn{position:absolute;top:0;left:0;font-size:36px}.openbtn{position:absolute;font-size:36px;cursor:pointer;border:none;text-decoration:none;color:#000}.openbtn:hover{color:red}
.frame{height:676px;width:1200px;position:absolute;margin-left:120px;margin-top:-5px;backghround-color:#f0f0}
.livestreaming{display:flex;background:#f0f0f0;width:100%;height:100%}

.column {float: left; width: 45%;}
.row:after {content: ""; display: table; clear: both;}
.cont { float: left; width: 5%; padding: 10px 0px 20px 50px;  }

</style>
</head>
<body>
<div id="mySidepanel" class="sidepanel">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"> x </a>

<div class='row'>
<div class="column">
<a href='./tv.php'>
<img src="./gambar/home.png" width="70">
</a>
</div>
<?php
for ($i=1; $i < $rowCount ; $i++) { 
echo "
<div class=\"column\">
<a href=\"?tv=$i\">
<img src=\"$logo[$i]\" width=\"72\" alt=\"$nama[$i]\" style=\"border-radius: 15px;  \">
</a>
</div>
";
}
?>
</div "row">
</div "sidepanel">

<div class="openbtn">
<a href="javascript:void(0)" class="openbtn" onclick="openNav()">?</a>
</div>

<div class="frame">
<div class="livestreaming">
<?php
if ($_GET['tv'])
{
$id = $_GET['tv'];
$judul = $nama[$id]." |";
echo "<title>$judul $_SERVER[HTTP_HOST]</title>";
echo "
<center>
<iframe src='$alamat[$id]' frameborder='0' scrolling='no'
 allowfullscreen id='iframe' width='1200' height='675'></iframe>
$nama[$id]
</center> 
";
}else{
//halaman awal
echo "<div class='row'>";
echo "<title>tink.web.id</title>";
for ($i=1; $i < $rowCount ; $i++) { 
echo "
<div class=\"cont\">
<a href=\"?tv=$i\">
<img src=\"$logo[$i]\" width=\"100\" alt=\"$nama[$i]\" style=\"border-radius: 20px;  \">
</a>
</div>
";
}
echo "</div class='row'>";

}
?>

</div>
</div>

<script>
function openNav() {
  document.getElementById("mySidepanel").style.width = "180px";
}

function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
}
</script>
  
<SCRIPT>
var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
eventer(messageEvent,function(e) {
  if (e.data.substring(0,3)=='frm') document.getElementById('iframe').style.height = e.data.substring(3) + 'px';
},false);
</SCRIPT>
</body>
</html> 
