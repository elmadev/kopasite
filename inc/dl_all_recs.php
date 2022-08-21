<?php
include("../kopasitedb.php");
include("../functions.php");


// Prepare Tmp File for Zip archive
$file = tempnam("tmp", "zip");
$zip = new ZipArchive();
$zip->open($file, ZipArchive::OVERWRITE);

// Add contents
$result = mysql_query("SELECT time.RecData, level.LevelName, kuski.Kuski, time.Time FROM time, level, kuski WHERE time.LevelIndex = level.LevelIndex AND time.KuskiIndex = kuski.KuskiIndex AND time.TimeIndex > 41590 AND time.RecData != '' LIMIT 16000,1000");
while($row = mysql_fetch_array($result)){
  $len = strlen($row['LevelName']) + strlen($row['Time']);
  $remaining = min(15 - $len, 4);
  $name = $row['LevelName'].substr($row['Kuski'], 0, $remaining).$row['Time'].'.rec';
  $zip->addFromString($name, $row['RecData']);
}

// Close and send to users
$zip->close();
header('Content-Type: application/zip');
header('Content-Length: ' . filesize($file));
header('Content-Disposition: attachment; filename="recs.zip"');
readfile($file);
unlink($file);
?>