	<link rel='shortcut icon' href='https://tink.web.id/favicon.ico' />	
	<style>
.sidepanel{width:400px;background-color:rgb(0, 0, 0, 0.9);
position:fixed;z-index:1;height:100%;top:0;left:0;overflow-x:hidden;transition:.5s;padding-top:0px}
.sidepanel a{padding:8px 8px 8px 8px;text-decoration:none;font-size:15px;color:#818181;display:block;transition:.3s}
.sidepanel a:hover{color:#f1f1f1}.sidepanel .closebtn{position:absolute;top:0;left:0;font-size:36px}.openbtn{position:absolute;font-size:36px;cursor:pointer;border:none;text-decoration:none;color:#000}.openbtn:hover{color:red}
.sidepanel img{border-radius: 15px; width: 72px; height: 36px; text-align: center; vertical-align: middle; }
.tombol{
position: fixed;
}
.frame{height:676px;width:1200px;position:absolute;margin-left:120px;margin-top:-5px;backghround-color:#f0f0}
.livestreaming{display:flex;background:#f0f0f0;width:100%;height:100%}

.column {float: left; width: 25%;}
.column span {display: inline-block; vertical-align: middle;  line-height: normal; 
height: 40px;  width: 72px; line-height: 40px;  text-align: center; border: 0px dashed #f0f0f0;
border-radius: 10px; background-color: black; font-size: 0.8em; color: white !important;}

.row {margin-top: 15px;}
.row:after {content: ""; display: table; clear: both;}
.cont { float: left; width: 12%; padding: 0px 0px 20px 0px; text-align: center; vertical-align: middle;border:
}
.cont span {  display: inline-block; vertical-align: middle;  line-height: normal; height: 60px;  width: 100px; line-height: 60px; text-align: center;
  border: 1px dashed #f0f0f0; color: white; font-weight: bold;  border-radius: 20px; background-color: #000;
font-size: 0.9em;  
  }
.cont span img{border-radius: 20px;}
</style>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

function group_by($array, $key) {
    $return = array();
    foreach($array as $val) {
        $return[$val[$key]][] = $val;
    }
    return $return;
}
//////Baca Data
$data = file_get_contents("tv.txt");
$rows = explode("#", $data);
//$rows = array_map("trim", $rows);
$rowCount = count($rows);

for ($i=1; $i <$rowCount ; $i++) {
  $baris = explode("<br />", nl2br($rows[$i]));
  $ket[$i]  = $baris[0];
  $alamat[$i]  = $baris[1];

$ket1[$i] = explode('|', $baris[0]);
$bar = count($ket1[$i]);
for ($z=0; $z <$bar ; $z++) { 
$nama[$i]  = $ket1[$i][0];
$kel[$i]  = $ket1[$i][1];
$logo[$i]  = $ket1[$i][2];
}
}
/////////////////////////////
?>
<!-- Sidebar -->


<div class="sidepanel" style="display:none;z-index:5" id="mySidebar"><big>
<a onclick="sidebar_close()" style="border: 0px;cursor:pointer;font-size:25px">&#9776;</a></big>
<div class="row">
<div class="column">
<a href="<?php echo $_SERVER["PHP_SELF"];?>" style='font-size:65px; cursor:pointer;'>&#9962;</a>
</div>
<?php
for ($i=1; $i < $rowCount ; $i++) { 
echo "
<div class=\"column\">
<a href=\"?tv=$i\">";
if (!empty($logo[$i])){
echo "<span>
<img src=\"$logo[$i]\" width=\"72\" height=\"50\" alt=\"$nama[$i]\" style=\"border-radius: 10px;  \">
</span>
";
}else {
echo "<span>$nama[$i]</span>";
}
echo "

</a>
</div>
";
}
?>
</div class="row">

</div>
<div class="" onclick="sidebar_close()" style="cursor:pointer;font-size:50px" id="myOverlay"></div>
<!-- close Sidebar -->

<div class="tombol">
<button onclick="sidebar_open()" style="font-size:25px; border: 0px; background-color: white; cursor:pointer;">&#9776;</button><br>
<a href="<?php echo $_SERVER["PHP_SELF"];?>" style='font-size:25px; cursor:pointer;'>&#9962;</a>
</div>
<div class="frame">

<?php
if (isset($_GET['tv']) ? $_GET['tv'] : ''){
$id = $_GET['tv'];
//echo $nama[$id];echo "<br>";echo $kel[$id];echo "<br>";echo $logo[$id];echo "<br>";echo $alamat[$id];echo "<br>";
if(preg_match("/.m3u8/i", $alamat[$id])) {
echo "<title>$nama[$id] | $_SERVER[HTTP_HOST]</title>";
//ini m3u8
$hasil = "
<script src=\"/aksesories/player/video.min.js\"></script>
<link href=\"/aksesories/player/video-js.css\" rel=\"stylesheet\">
";
$hasil .= "<center>
<video autoplay muted preload=\"auto\" controls width=\"1200px\" id=\"m3u\" class=\"video-js\">
<source src=\"$alamat[$id]\" type=\"application/x-mpegURL\">
</video>
<script>
var player = videojs('m3u');
player.play(function() {
            player.controlBar.volumePanel.show();
            player.controlBar.volumePanel.volumeControl.show();
            player.controlBar.volumePanel.muteToggle.show();
    });
</script>
</center>
";
        
} //if preg m3u
elseif (preg_match("/.mpd/i", $alamat[$id])){
echo "<title>$nama[$id] | $_SERVER[HTTP_HOST]</title>";
$hasil = "
<script src=\"/aksesories/player/dash.all.min.js\"></script>
<script src=\"/aksesories/player/video.min.js\"></script>
<script src=\"/aksesories/player/videojs-dash.min.js\"></script>
<link href=\"/aksesories/player/video-js.css\" rel=\"stylesheet\">
";
$hasil .= "
<center>
<video width=\"1200px\" id=\"dash\" class=\"video-js vjs-default-skin\">
<source src=\"$alamat[$id]\" type=\"application/dash+xml\">
</video>
<script>
var player = videojs('#dash');
player.play();
</script>  
</center>
";
}else{
echo "<title>$_SERVER[HTTP_HOST]</title>";
$hasil = "
<center>
<iframe src='$alamat[$id]' frameborder='0' scrolling='no' allowfullscreen id='iframe' width='1200' height='675'></iframe>
</center> 
";
}

echo $hasil;

}else{
echo "<div class='row'>";
echo "<title>$_SERVER[HTTP_HOST]</title>";
for ($i=1; $i < $rowCount ; $i++) { 
echo "
<div class=\"cont\">
<a href=\"?tv=$i\">
";
if (!empty($logo[$i])){
echo "
<span><img src=\"$logo[$i]\" alt=\"$nama[$i]\" width=\"100px\" height=\"60px\"></span><br>
";
}else{
echo "<span>$nama[$i]</span>";
}
echo "
</a>
</div>
";
}
echo "</div class='row'>";
}
?>
</div>

<script>
function sidebar_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}

function sidebar_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}
</script>
