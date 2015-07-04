<?php
include_once './control/SoundController.php';
include_once './control/IMusicControl.php';
include_once './control/MPDController.php';

?>
<html>
    <meta charset="utf-8">
    <body>
        
    </body>
<?php
//echo "hallo<br/>";
//$contents = file_get_contents("./radio-streams");
//echo $contents . "<br/>";
//$streams = json_decode($contents, true);
//var_dump($streams);
//echo "<hr/>";
//echo "Num:". count($streams) . "<br>";
//
////Liste anlegen, vorher löschen!
////Aufbau einer solchen Datei: https://de.wikipedia.org/wiki/M3U
//$playlistdir = "/mnt/mpd/radiostreams";
//$filename = "playlist.m3u";
//$filepath = $playlistdir . "/" . $filename;
//echo $filepath . "<br/>";
//$sc = array();
//array_push($sc, "#EXTM3U");
//foreach ($streams as $key => $value) {
//    array_push($sc, "#EXTINF:-1," . $value["name"]);
//    array_push($sc, $value["url"]);
//    
//}
//var_dump($sc);
//$playlist = implode("\n", $sc);
//echo $playlist;
//echo "#EXTM3U" >> "$filepath"

$m = new MPDController();
#var_dump($m->loadStreamList());

$m->createPlaylist();

echo '<hr/>';
$m->loadPlaylist();
var_dump($m->listPlaylist());
?>
</html>