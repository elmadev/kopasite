<?php
include("../kopasitedb.php");
include("../functions.php");
$lev = hax($_GET['lev']);

function BadLevel($level) {
  if (fread($level,5)=='POT14') return false;
  return true;
}

function PolyIn ($a,$b) {
  $c = false;
  $x = $a['vertex'][0]['x'];
  $y = $a['vertex'][0]['y'];
  for ($i = 0, $j = $b['vertnum']-1;$i < $b['vertnum']; $j = $i++)
    if (((($b['vertex'][$i]['y']<=$y) && ($y<$b['vertex'][$j]['y'])) ||
        (($b['vertex'][$j]['y']<=$y) && ($y<$b['vertex'][$i]['y']))) &&
        ($x < (($b['vertex'][$j]['x'] - $b['vertex'][$i]['x']) *
        ($y - $b['vertex'][$i]['y'])/($b['vertex'][$j]['y'] - $b['vertex'][$i]['y']) + $b['vertex'][$i]['x'])))
        $c = !$c;
  return $c;
}

//  if (!isset($HTTP_GET_VARS['link'])) {
//    echo "Where is link, eh?";
//    exit;
//  }

  if (!($level = @fopen("../levs/".$lev.".lev", "rb"))) {
    echo "Can't read teh file. ez wrong or old link";
    exit;
  }
  if (BadLevel($level)) {
    fclose($level);
    echo "Fak u! Unknown level format";
    exit;
  }
  $showinfo=false;
  if (isset($HTTP_GET_VARS['noinfo'])) $showinfo=false;

  if ($showinfo) {
    fseek($level,43);
    $levelname = 'Title: ';
    for ($i=0; $i<51; $i++) {
      $ch = fread($level,1);
      if ($ch==chr(0)) break;
      $levelname.=$ch;
    }
  }
  fseek($level,130);
  $polygons = array();
  $temp = unpack("dP",fread($level,8));
  $p = round($temp['P']);
  for ($i=0; $i<$p; $i++) {
    $temp = unpack("Vj/Vvertices", fread($level, 8));
    if ($temp['j'] == 1) fseek($level,16*$temp['vertices'],SEEK_CUR);
    else {
      $t = count($polygons);
      $polygons[$t]['vertnum'] = $temp['vertices'];
      $polygons[$t]['ground'] = 0;
      for ($j=0; $j<$temp['vertices']; $j++) {
        $temp2 = unpack("dx/dy", fread($level, 16));
        $polygons[$t]['vertex'][$j]['x'] = $temp2['x'];
        $polygons[$t]['vertex'][$j]['y'] = $temp2['y'];
      }
    }
  }
  $polynum = count($polygons);
  $temp = unpack("dT", fread($level, 8));
  $objnum = round($temp['T']);
  for ($i=0; $i<$objnum; $i++) {
    $temp = unpack("dx/dy/Vtyp", fread($level, 20));
    $objects[$i]['x'] = $temp['x'];
    $objects[$i]['y'] = $temp['y'];
    $objects[$i]['typ'] = $temp['typ'];
    if ($temp['typ'] == 4) {
      $objects[$i]['x']+=0.85;
      $objects[$i]['y']-=0.6;
    }
    fseek($level,8,SEEK_CUR);
  }
  fclose($level);
  $minx = $polygons[0]['vertex'][0]['x'];
  $miny = $polygons[0]['vertex'][0]['y'];
  $levwidth = $minx;
  $levheight = $miny;
  for ($i=0; $i<$polynum; $i++)
    for($j=0; $j<$polygons[$i]['vertnum']; $j++) {
      if ($polygons[$i]['vertex'][$j]['x']>$levwidth) $levwidth = $polygons[$i]['vertex'][$j]['x'];
      if ($polygons[$i]['vertex'][$j]['x']<$minx) $minx = $polygons[$i]['vertex'][$j]['x'];
      if ($polygons[$i]['vertex'][$j]['y']>$levheight) $levheight = $polygons[$i]['vertex'][$j]['y'];
      if ($polygons[$i]['vertex'][$j]['y']<$miny) $miny = $polygons[$i]['vertex'][$j]['y'];
    }
  for ($i=0; $i<$objnum; $i++) {
    if ($objects[$i]['x']>$levwidth) $levwidth = $objects[$i]['x'];
    if ($objects[$i]['x']<$minx) $minx = $objects[$i]['x'];
    if ($objects[$i]['y']>$levheight) $levheight = $objects[$i]['y'];
    if ($objects[$i]['y']<$miny) $miny = $objects[$i]['y'];
  }

  $levwidth -= $minx;
  $levheight -= $miny;
  if (isset($_GET['width'])) $width = $_GET['width']-10;
  else $width = 300;
  if ($width<287) $width = 287;
  if ($showinfo && $width<(strlen($levelname)*6-1)) $width = strlen($levelname)*6-1;
  $mapscale = $width/$levwidth;
  if (!isset($HTTP_GET_VARS['width']) && isset($HTTP_GET_VARS['zoom']) && $HTTP_GET_VARS['zoom']*4.8 > $mapscale) $mapscale = $HTTP_GET_VARS['zoom']*4.8;

  if ($mapscale>4.8) $pictobj = true;
  else $pictobj = false;
  if (isset($HTTP_GET_VARS['drawobj'])) $pictobj = $HTTP_GET_VARS['drawobj'];

  $levwidth += 10/$mapscale;
  $minx -= 5/$mapscale;

  if ($showinfo) {
    $levheight += 54/$mapscale;
    $miny -= 38/$mapscale;
  }
  else {
    $levheight += 32/$mapscale;
    $miny -= 16/$mapscale;
  }

  for ($i=0; $i<$polynum; $i++)
    for($j=0; $j<$polygons[$i]['vertnum']; $j++) {
      $polygons[$i]['vertex'][$j]['x']-=$minx;
      $polygons[$i]['vertex'][$j]['y']-=$miny;
    }
  for ($i=0; $i<$objnum; $i++) {
    $objects[$i]['x']-=$minx;
    $objects[$i]['y']-=$miny;
  }
  for ($i=0; $i<$polynum; $i++) for ($j=0; $j<$polynum; $j++) if ($i!=$j && polyin($polygons[$i],$polygons[$j])) $polygons[$i]['ground']++;
  for ($i=0; $i<$polynum-1; $i++)
    for ($j=$polynum-1; $j>=$i; $j--)
      if ($polygons[$i]['ground']>$polygons[$j]['ground']) {
         $swap = $polygons[$j];
         $polygons[$j] = $polygons[$i];
         $polygons[$i] = $swap;
      }
  for ($i=0; $i<$polynum; $i++) $polygons[$i]['ground'] = $polygons[$i]['ground'] % 2;
  $width = round($levwidth*$mapscale);
  $height = round($levheight*$mapscale);
  $map = imagecreate($width,$height);
  $mapcolors[0] = imagecolorallocate($map,255,255,255);
  $mapcolors[1] = imagecolorallocate($map,255,255,255);
  $mapcolors[2] = imagecolorallocate($map,212,8,0);
  $mapcolors[3] = imagecolorallocate($map,0,0,0);
  $mapcolors[4] = imagecolorallocate($map,214,246,32);
  $mapcolors[5] = imagecolorallocate($map,23,18,60);
  $mapcolors[6] = imagecolorallocate($map,48,112,212);
  imageFilledRectangle($map,0,0,$width,$height,$mapcolors[5]);
  for ($i=0; $i<$polynum; $i++) {
    for ($j=0; $j<$polygons[$i]['vertnum']; $j++) {
      $screenpolygon[$j*2] = round($polygons[$i]['vertex'][$j]['x']*$mapscale);
      $screenpolygon[$j*2+1] = round($polygons[$i]['vertex'][$j]['y']*$mapscale);
    }
    imagefilledpolygon($map,$screenpolygon,$polygons[$i]['vertnum'],$mapcolors[6-$polygons[$i]['ground']]);
  }
//$pictobj = false;
  if ($pictobj) {
    $pictures[1]=imagecreatefrompng('../images/flower.png');
    $pictures[2]=imagecreatefrompng('../images/apple.png');
    $pictures[3]=imagecreatefrompng('../images/killer.png');
    $pictures[4]=imagecreatefrompng('../images/bike.png');
  }

  for ($i=0;$i<$objnum;$i++) {
    $sx = round($objects[$i]['x'] * $mapscale);
    $sy = round($objects[$i]['y'] * $mapscale);
    if ($pictobj) {
      if ($objects[$i]['typ']==4) imagecopyresized($map,$pictures[4],round(($objects[$i]['x']-1.25) * $mapscale),round(($objects[$i]['y']-1.32) * $mapscale),0,0,round(2.51*$mapscale),round(2.32*$mapscale),191,177);
      else imagecopyresized($map,$pictures[$objects[$i]['typ']],round(($objects[$i]['x']-0.4) * $mapscale),round(($objects[$i]['y']-0.4) * $mapscale),0,0,round(0.8*$mapscale),round(0.8*$mapscale),40,40);
    }
    else imagerectangle($map,$sx-1,$sy-1,$sx+1,$sy+1,$mapcolors[$objects[$i]['typ']]);
  }

  if ($showinfo) {
    ImageString($map,2,6,0,'Level: '.basename($HTTP_GET_VARS['link']),$mapcolors[0]);
    ImageString($map,2,6,11,$levelname,$mapcolors[0]);
    ImageString($map,2,6,22,' Zoom: '.(round(10*$mapscale/4.8)/10).'x',$mapcolors[0]);
  }
  //ImageString($map,2,$width-145,$height-16,'map maker online by domi',$mapcolors[0]);
  Header('Content-type: image/png');
  ImagePng($map);
  ImageDestroy($map);
?>