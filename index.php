<?php
session_start();
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
include "kopasitedb.php";
include "functions.php";
include "login.php";
include "route.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Kopasite|</title>
<link href="/css/style.css" rel="stylesheet" type="text/css"/>
<link rel="icon" type="image/x-icon" href="/images/favicon.ico" />
<script src="/jquery.js"></script>
<script type="text/javascript" src="/jquery.tablesorter.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>
<body>
<?php
$url = "";
if(isset($_POST['upload'])){
	include("inc/upload.php");
}
if(isset($_POST['uploadfile'])){
	include("inc/uploadfile.php");
}
$self = $_SERVER['REQUEST_URI'];
include_once("classes/talk_class.php");
$talk = new Talk;
$talk->ki = $ki;
$talk->insert();
include_once("classes/log_class.php");
$log = new Logging;
unset($log);
include("inc/vars.php");

/*if(!isset($_SESSION['lastrec'])){
	include_once("classes/db_time_class.php");
	$result = new DBtime;
	$result->bestall("all");
	$result->rows = "TimeIndex";
	$result->orderby = "TimeIndex DESC";
	$result->limit = "0,1";
	$data = $result->select();
	foreach($data as $row){
		$_SESSION['lastrec'] = $row['TimeIndex'];
	}
}*/

?>
<center>
<div class="main_block">
<!-- top panel starts here -->
	<div class="header">
		<div class="tab">
			<div class="tp_1pxdrkornge">
				<a href="/"><img src="/images/logo.png" width="242" height="29" alt="" class="logo"/></a>
			</div>
			<div style="float:left; width:998px;">
				<div class="tp_rhtbg white" align="right">
					<br/>
					<div align="left" class="padbox" style="display: none; border: 1px solid #FFFFFF;background: #252525;width:450px; float: left;" id="notifi">
					</div>
					<!--<div align="left" class="padbox" style="display: none; border: 1px solid #FFFFFF;background: #252525;width:450px; float: left;" id="uploadbox">
						Add a new time on a Kopasite level by uploading the replay<br/>
						<form method='post' enctype='multipart/form-data' action='<?php //echo $self; ?>'>
						<input type='file' name='file' size='55'><br/>
						<input name='MAX_FILE_SIZE' value='1000000' type='hidden'>
						<input type='submit' value='Upload' name='upload'><input type="checkbox" value="true" name="secretarea"> Secret area
						</form>
						<input align="right" type="button" value="Hide" id="hideupload" class="stdbutt">
					</div>-->
					<div align="left" class="padbox" style="display: none; border: 1px solid #FFFFFF;background: #252525;width:450px; float: left;" id="searchbox">
						Search for a level or player on Kopasite<br/>
						<input type='text' name='searchtext' id='searchtext' size='55'><br/>
						<input align="right" type="button" value="Hide" id="hidesearch" class="stdbutt">
					</div>
					<!--<div align="left" class="padbox" style="display: none; border: 1px solid #FFFFFF;background: #252525;width:450px; float: left;" id="uploadfilebox">
						Upload any file to save or share it. Max file size is 7 mb.<br/>
						<form method='post' enctype='multipart/form-data' action='<?php //echo $self; ?>'>
						<input type='file' name='file' size='55'><br/>
						<input name='MAX_FILE_SIZE' value='7000000' type='hidden'>
						<table><tr>
						<td><input type="radio" value="60" name="Duration" checked="checked"> 60 days<br/>
						<input type="radio" value="3" name="Duration"> 3 days<br/>
						<input type="radio" value="0" name="Duration"> Forever</td>
						<td><input type="radio" value="Private" name="privacy" checked="checked" id="priv1"> Private<br/>
						<input type="radio" value="Public" name="privacy" id="priv2"> Public<br/>
						<input type="radio" value="Select" name="privacy" id="priv3"> Select..</td>
						<td><div style="display: none;" id="selusers"><input type="text" name="selectusers" size="20"/><br/>Type in users that<br/>can access the file.</div></td>
						<td align="right"><input type="submit" value="Upload" name="uploadfile"></td>
						</tr></table>
						Tags: <input type="text" name="tags" size="55"/>
						</form>
						<input align="right" type="button" value="Hide" id="hideuploadfile" class="stdbutt">
					</div>-->
					<?php
					if(!$morerecs){
						if(isset($error) or isset($success)){
							echo "<div align='left' class='padbox' style='border:1px solid #FFFFFF;background: #252525;width:450px; float: left;' id='uploaddone'>";
							if(isset($error)){
								echo $error;
							}else{
								echo $success;
							}
							echo "<div class='padtop' align='right'><input type='button' value='Hide' id='hideuploaddone' class='upload'>&nbsp;</div>";
							echo "</div>";
						}
					}
					/*if($loggedin){
						echo "<div class='padtop'><input type='button' value='Submit time' id='upload' class='upload'>&nbsp;<br/></div>";
					}*/
					?>
					<!--<div class="padtop"><input type="button" value="Upload file" id="uploadfile" class="upload">&nbsp;</div>-->
					<div class="padtop"><input type="button" value="Search" id="search" class="upload">&nbsp;</div>
					<script>
					/*$("#upload").click(function () {
						$("#uploadbox").show(400);
						$("#uploadfilebox").hide(400);
						$("#searchbox").hide(400);
					});
					$("#hideupload").click(function () {
						$("#uploadbox").hide(400);
					});*/

					/*$("#uploadfile").click(function () {
						$("#uploadfilebox").show(400);
						$("#uploadbox").hide(400);
						$("#searchbox").hide(400);
					});
					$("#hideuploadfile").click(function () {
						$("#uploadfilebox").hide(400);
					});*/

					$("#search").click(function () {
						$("#searchbox").show(400);
						$("#uploadfilebox").hide(400);
						$("#uploadbox").hide(400);
					})
					$("#hidesearch").click(function () {
						$("#searchbox").hide(400);
					});
					$("#searchtext").keyup(function () {
						var svalue = $("#searchtext").val();
						$("#wholesite").hide(1);
						if($("#searchtext").val() == '') {
							$("#searchdiv").hide(1);
							$("#wholesite").show(1);
						}else{
							$('#searchdiv').load('/ajax/search.php?search=' + $("#searchtext").val());
							if( $("#searchdiv").is(":hidden") ) {
								$("#searchdiv").show(1);
							}
						}
					});

					$("#hideuploaddone").click(function () {
						 $("#uploaddone").hide(400);
					});

					$("#priv3").change(function() {
						$("#selusers").show("fast");

					});	
					$("#priv2").change(function() {
						$("#selusers").hide("fast");

					});
					$("#priv1").change(function() {
						$("#selusers").hide("fast");

					});
					/*function SelectText(element) {
					    var doc = document;
					    var text = doc.getElementById(element);
					    if (doc.body.createTextRange) {
					        var range = document.body.createTextRange();
					        range.moveToElementText(text);
					        range.select();
					    } else if (window.getSelection) {
					        var selection = window.getSelection();
					        var range = document.createRange();
					        range.selectNodeContents(text);
					        selection.removeAllRanges();
					        selection.addRange(range);
					    }
					}
					SelectText('selectme');*/
					/*setInterval(function() {
						if( $("#notifi").is(":hidden") ) {
							$('#notifi').load('/ajax/notification.php');
						}
					}, 1000 * 60 * 1); // where X is your every X minutes */
					</script>
				</div>
				<div class="tp_lftbg">
					<a href="/"><p class='menutxt1'>Home</p></a>
					<a href="/records/"><p class='menutxt'>Records</p></a>
					<a href="/info/"><p class='menutxt'>Info</p></a>
					<a href="/contests/"><p class='menutxt'>Contests</p></a>
					<a href="/download/"><p class='menutxt'>Download</p></a>
					<a href="/community/"><p class='menutxt'>Community</p></a>
					<a href="/tools/"><p class='menutxt'>Tools</p></a>
				</div>
			</div>
		</div>
	</div>
<!-- top panel ends here -->
	<?php
	if(!isset($s)){
	?>
	<div class="center">
		<div class="tab1" style="background-color:#171B02;">
			<div style="float:left; width:998px;">
				<div class="center1"> 
					<p class="lp_tpbg"></p> 
					<span class="lp_3pxgrn">
						<?php
						if(!$loggedin){
						?>
						<form method="post" action="<?php echo $url; ?>/">
						<img src="/images/lp_login.gif" width="40" height="14" alt="" class="lp_login" /><span class="padtop" align="right" style="float:right;font:11px arial;color:#ffffff;"><input type="checkbox" value="remember" name="remember" tabindex="3"/> Remember&nbsp;</span>
						<span class="lp_user">
							<span class="lp_userid">Nick </span>
							<input name="nick" type="text" class='login' tabindex="1"/>
						</span>
						<span class="lp_user" style="margin-top:5px;">
							<span class="lp_userid">Password </span>
							<input name="password" type="password" class='login' tabindex="2"/>
						</span>
						<span class="lp_user padsmall padlogin">
							<input type='submit' value='Log in' name='login' class="button" tabindex="4"/>
							<?php //<input type='submit' value='Send New Pass' name='newpass' class="button" tabindex="5"/> ?>
							</form>
						</span>
						<?php
						}else{
							echo "<span class='lp_user pad'>\n";
							echo kuski($ki, true, true, "white") . "<br />\n";
							echo "<a href='$url/user/settings/' class='white'>Settings</a><br/>\n";
							if(in_array($ki, $kopa_admins)){
								echo "<a href='$url/user/admin/' class='white'>Admin</a>\n";
								$extrabr = true;
							}
							if(in_array($ki, $kopa_secret)){
								echo "<a href='$url/user/secret/' class='white'>Secret</a>\n";
								$extrabr = true;
							}
							if($extrabr){
								echo "<br/>";
							}
							echo "<form method='post' action='$self'><input type='submit' value='Log out' name='logout' class='button'></form>\n";
							echo "</span>\n";
						}
						?>
					</span>
				</div> 
				<div class="cp_1pxhrzgrn">
					<?php
						include "index_news.php";
					?>
				</div> 
				<div class="rp_hwbg">
					<p class="head pad">Level Packs</p><br/><br/>
                    <a href="<?php echo $url; ?>/records/kinglist/Kopaka/" class="red size11 bold pad">Kopaka levels</a><br/>
					<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="/records/pack/TKT/" class="rp_buttxt2">TKT ep I</a>&nbsp;
            <img src="/images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="<?php echo $url; ?>/records/pack/TKTII/" class="rp_buttxt" >TKT ep II</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="/records/pack/DCup03/" class="rp_buttxt2">Dragstrup Cup 2003</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="/records/pack/C1337/" class="rp_buttxt2">1337 Contest</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="/records/pack/cEp/" class="rp_buttxt2">cEp levels</a>
				</div>
			</div>
			<div class="tp_middlebg"></div>  	 
		</div>	
	</div>
	<?php
	}
	?>
 <!-- center panel starts here -->
	<div class="tab1" style="float:left; background-color:#FFF;">
<!-- left panel starts here -->
		<div style="float:left; width:179px; background-color:<?php if(isset($s)){ echo "#EAEAC6"; }else{ echo "#F1F1DA"; }?>;">
			<?php
			if(isset($s)){
			?>
			<p class="soft_lp_bg"></p> 
			<span class="soft_lp_3pxdsg">
				<?php
				if(!$loggedin){
				?>
				<form method="post" action="<?php echo $self; ?>/">
				<img src="/images/soft_lp_login.gif" width="40" height="14" alt="" class="lp_login"/><span class="padtop" align="right" style="float:right;font:11px arial;color:#ffffff;"><input type="checkbox" value="remember" name="remember" tabindex="3"/> Remember&nbsp;</span>
				<span class="lp_user">
					<span class="lp_userid">Nick</span>
					<input name="nick" type="text" class='login2' tabindex="1"/>
				</span><br/>
				<span class="lp_user">
					<span class="lp_userid">Password</span>
					<input name="password" type="password" class='login2' tabindex="2"/>
				</span><br/>
				<span class="lp_user padsmall padlogin">
					<input type='submit' value='Log in' name='login' class="button" tabindex="4">
					<?php //<input type='submit' value='Send New Pass' name='newpass' class="button" tabindex="5"> ?>
					</form>
				</span>
				<?php
				}else{
					echo "<span class='lp_user pad'>";
					echo kuski($ki, true, true, "white") . "<br />";
					echo "<a href='$url/user/settings/' class='white'>Settings</a><br/>\n";
					if(in_array($ki, $kopa_admins)){
						echo "<a href='$url/user/admin/' class='white'>Admin</a>\n";
						$extrabr = true;
					}
					if(in_array($ki, $kopa_secret)){
						echo "<a href='$url/user/secret/' class='white'>Secret</a>\n";
						$extrabr = true;
					}
					if($extrabr){
						echo "<br/>";
					}
					echo "<form method='post' action='$self'><input type='submit' value='Log out' name='logout' class='button'></form>";
					echo "</span>";
				}
				?>
			</span>
			<?php
			}
			?>
			<div class="lp_brnbg" style="width:179px;">
				<p class="head white">Talk</p>
			</div>
			<div style="padding-top:9px; width:179px; background-color:<?php if(isset($s)){ echo "#EAEAC6"; }else{ echo "#F1F1DA"; }?>; float:left;">
				<?php
					include "talk.php";
				?>
			</div>	
		</div>  
<!-- left panel ends here -->
<!-- content panel starts here -->	
		<div class="cp_tab">
			<div style="width:624px; float:left;">
				<?php
				if(isset($s)){
				?>
				<span style="float:left; padding-bottom:15px; background-color:#0C0E01; width:624px;"> 
					<?php
						include "headlines.php";
					?>
				</span>
				<div style="float:left; padding:13px 0 12px 0; background-color:#EE9A00;">
					<?php
						include "menu.php";
					?>
				</div>
				<?php
				}
				?>
				<div id="searchdiv"></div>
				<div class="cp_mansuit" id="wholesite">
					<?php
					if(isset($s)){
						$sections = array("records", "news", "info", "contests", "download", "community", "tools", "user", "help");
						if(in_array($s, $sections)){
							include "$s.php";
						}else{
							$four0four = true;
						}
						if($four0four){
							headline("404");
							echo "<div class='stdbox'>Page does not exist.<img src='$url/images/404.png' /></div>\n";
						}
					}else{
						include "index_newest_times.php";
					}
					?>
				</div>
				<?php
				if($morerecs){
					echo "<div class='stdbox' id='morerecs'><p class='head red'>Upload Report</p><div class='footer'></div>\n";
					echo "$success $error\n";
					echo "<input align='right' type='button' value='Hide upload report' id='hideuprep' class='stdbutt'></div>\n";
					?><script>
					$("#wholesite").hide(1);
					$("#hideuprep").click(function () {
						$("#morerecs").hide(400);
						$("#wholesite").show(400);
					});
					</script><?php
				}
				?>
				<div style="padding-bottom:10px; background-color:#3F5262; float:left;">
					<?php
					if(!isset($s)){
					include "tips.php";
					}
					?>
				</div>
			</div>
		</div>   
<!-- content panel ends here -->
<!-- right panel starts here -->
		<?php
		if(isset($s)){
		?>
		<div class="rp_hwbg<?php if(isset($s)){ echo " rp_hwbgborder"; } ?>">
			<a href="<?php echo $url; ?>/records/kinglist/" class="black head pad">Level Packs</a><br/><br/>
			<a href="<?php echo $url; ?>/records/kinglist/Kopaka/" class="red size11 bold pad">Kopaka levels</a><br/>
			<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/TKT/" class="rp_buttxt2">TKT ep I</a>&nbsp;
            <img src="/images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="<?php echo $url; ?>/records/pack/TKTII/" class="rp_buttxt" >TKT ep II</a><br/>
			<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/DCup03/" class="rp_buttxt2">Dragstrup Cup 2003</a><br/>
			<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/C1337/" class="rp_buttxt2">1337 Contest</a><br/>
			<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/cEp/" class="rp_buttxt2">cEp levels</a>
		</div>
		<?php
		}
		if(!$noright){
		?>
		<div class="right<?php if(isset($s)){ echo " rightborder"; } ?>">
			<div style="padding-bottom:17px; float:left; background-color:#F7F9EC; width:193px;<?php if(isset($s)){ echo "border-bottom:5px solid #A8C809;"; } ?>">
				<a href="<?php echo $url; ?>/records/kinglist/Contest/" class="red size11 bold pad">Contest Levels</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/FSDC1L/" class="rp_buttxt">eLopa</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/ILDC/" class="rp_buttxt">ILDC</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/dakar/" class="rp_buttxt" >Dakar Cup</a>&nbsp;
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="<?php echo $url; ?>/records/pack/dakar2/" class="rp_buttxt" >Dakar Cup 2</a><br/>
				<a href="<?php echo $url; ?>/records/kinglist/Internal/" class="red size11 bold pad">Internal Mixes</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/MIRROR/" class="rp_buttxt">Mirror</a>&nbsp;
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="<?php echo $url; ?>/records/pack/MAX/" class="rp_buttxt" >Max</a>&nbsp;
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="<?php echo $url; ?>/records/pack/INTilt/" class="rp_buttxt" >Tilted</a><br/>
				<a href="<?php echo $url; ?>/records/kinglist/LevelPack/" class="red size11 bold pad">Level Packs</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/wke/" class="rp_buttxt" >WkE levels</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/umiz/" class="rp_buttxt" >umiz</a>&nbsp;
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="<?php echo $url; ?>/records/pack/qumiz/" class="rp_buttxt" >qumiz</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/OBLP/" class="rp_buttxt" >OBLP</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/NP/" class="rp_buttxt" >NP</a>&nbsp;
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="<?php echo $url; ?>/records/pack/Qsla/" class="rp_buttxt" >Qsla</a>&nbsp;
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="<?php echo $url; ?>/records/pack/Gsla/" class="rp_buttxt" >Gsla</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/Shareware/" class="rp_buttxt" >Shareware</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/GS/" class="rp_buttxt" >Great Sticks</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/semen/" class="rp_buttxt" >semen</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/VSK/" class="rp_buttxt" >VSK</a><br/>
                <img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/BZAL/" class="rp_buttxt" >BlaZtek Adventure</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/kachi/" class="rp_buttxt" >kachi</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/Haru/" class="rp_buttxt" >Haru Pack</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/Pab/" class="rp_buttxt" >Pab Level Pack</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/Jeppe/" class="rp_buttxt" >Handpicked Jeppe battles</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/GAB/" class="rp_buttxt" >GAB</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/Found/" class="rp_buttxt" >Found Internals</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/HALF1/" class="rp_buttxt" >HALF1</a>&nbsp;
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="<?php echo $url; ?>/records/pack/HALF2/" class="rp_buttxt" >HALF2</a><br/>
				<a href="<?php echo $url; ?>/records/kinglist/Pipe/" class="red size11 bold pad">Pipe Levels</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/EPLP/" class="rp_buttxt" >EPLP</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/Tube/" class="rp_buttxt" >Tube</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/FMPi/" class="rp_buttxt" >FinMan Pipes</a><br/>
                <img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/RIP/" class="rp_buttxt" >Random igge Pipes</a><br/>
				<a href="<?php echo $url; ?>/records/kinglist/Hoyla/" class="red size11 bold pad">H�yl� Levels</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/vzhoyl/" class="rp_buttxt" >veezay h�yl�</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/hoyl/" class="rp_buttxt" >H�yl Pack</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/RHP/" class="rp_buttxt" >Raven H�yl� Pack</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/FMH/" class="rp_buttxt" >FinMan H�yl� levels</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/danpe/" class="rp_buttxt" >danpe levels</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/Ilevs/" class="rp_buttxt" >I-levels</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/Bhoyl/" class="rp_buttxt" >Bliz H�yl�</a><br/>
                <img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/AZHP/" class="rp_buttxt" >Alma Zero H�yl� Pack</a>
				<a href="<?php echo $url; ?>/records/kinglist/Moposite/" class="red size11 bold pad">Moposite</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/MCHM/" class="rp_buttxt" >H�yl� Mission</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/MOPCU/" class="rp_buttxt" >Custom Levels</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/Lost/" class="rp_buttxt" >Lost Internals</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/MCLE/" class="rp_buttxt" >MC Levels</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/MOPLGR/" class="rp_buttxt" >LGR Levels</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/top10/" class="rp_buttxt" >Official Top 10</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/LOM/" class="rp_buttxt" >Level Of the Month</a><br/>
				<img src="/images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="<?php echo $url; ?>/records/pack/WCup/" class="rp_buttxt" >World Cup</a><br/>
			</div> 
		</div>
		<?php
		}
		?>
<!-- right panel ends here -->
	</div>
<!-- central panel ends here -->
<!-- footer panel starts here -->
	<div class="tab">
		<div class="fp_1pxbg">
			<p>
				<a href="/info/about_kopasite/" class="fp_txt white">About Kopasite</a>
				<span class="fp_sep">|</span>
				<a href="/records/" class="fp_txt white">Kinglist</a>
				<span class="fp_sep">|</span>
				<a href="/help/" class="fp_txt white">Help</a>
				<span class="fp_sep">|</span>
				<a href="/info/contact/" class="fp_txt white">Contact Kopasite</a>
				<span class="fp_sep">|</span>
				<a href="/help/privacy/" class="fp_txt white">Privacy Policy</a>
				<span class="fp_sep">|</span>
				<a href="/info/site_map/" class="fp_txt white">Sitemap</a>
			</p>
			&copy; Copyright Kopasite.net 2002 - <?php echo date("Y"); ?>. All rights reserved.
		</div>
	 </div>
	</div>
</center>
</body>
</html>