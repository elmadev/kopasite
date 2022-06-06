<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Kopasite|</title>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>
<body>
<?php
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('kopasite', $link) or die(mysql_error());
include "functions.php";
include "route.php";

?>
<center>
<div class="main_block">
<!-- top panel starts here -->
	<div class="header">
		<div class="tab">
			<div class="tp_1pxdrkornge">
				<a href="#"><img src="images/logo.png" width="242" height="29" alt="" class="logo"/></a>
			</div>
			<div style="float:left; width:998px;">
				<p class="tp_rhtbg"></p>
				<p class="tp_lftbg">
					<a href="#"><p class='menutxt1'>Home</p></a>
					<a href="#"><p class='menutxt'>Records</p></a>
					<a href="#"><p class='menutxt'>Info</p></a>
					<a href="#"><p class='menutxt'>Contests</p></a>
					<a href="#"><p class='menutxt'>Download</p></a>
					<a href="#"><p class='menutxt'>Community</p></a>
					<a href="#"><p class='menutxt'>Tools</p></a>				
				</p>						
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
					<p class="lp_3pxgrn">
						<img src="images/lp_login.gif" width="40" height="14" alt="" class="lp_login" />
						<span class="lp_user">
							<span class="lp_userid">Nick </span>
							<input name="txtbox" type="text" style="width:90px; height:12px; border:0; float:left; margin:0 0 0 7px;"/>
						</span>
						<span class="lp_user" style="margin-top:5px;">
							<span class="lp_userid">Password </span>
							<input name="txtbox" type="text" style="width:90px; height:12px; border:0; float:left; margin:0 0 0 7px;"/>
						</span>
						<span class="lp_user">
							<a href="#" style="color:#E7EFB9;float:left;width:85px;margin:15px 0 0 15px;">Forgot Password</a>
							<a href="#"><img src="images/lp_enterbut.png" width="70" height="22" alt="" class="lp_enterbut"/></a>
						</span> 
					</p>
				</div> 
				<div class="cp_1pxhrzgrn">
					<?php
						include "news.php";
					?>  
				</div> 
				<div class="rp_hwbg">
					<p class="head pad">Level Packs</p><br/><br/>
					<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt2">The Kopa Trilogy</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt2">Dragstrup Cup 2003</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt2">1337 Contest</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt2">cEp levels</a>
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
			<p class="soft_lp_3pxdsg">
				<img src="images/soft_lp_login.gif" width="40" height="14" alt="" class="lp_login"/>
				<span class="lp_user">
					<span class="lp_userid">Nick</span>
					<input name="txtbox" type="text" style="width:90px;height:12px;"/>
				</span><br/>
				<span class="lp_user">
					<span class="lp_userid">Password</span>
					<input name="txtbox" type="text" style="width:90px;height:12px;"/>
				</span><br/>
				<span class="lp_user">
					<a href="#" style="color:#E7EFB9;float:left;width:85px;margin:12px 0 0 15px;">forget password</a>
					<a href="#"><img src="images/lp_enterbut.png" width="70" height="22" alt="" class="lp_enterbut"/></a>
				</span>
			</p>
			<?php
			}
			?>
			<div class="lp_brnbg">
				<p class="head white">Talk</p>
			</div>
			<div style="padding-top:9px; background-color:<?php if(isset($s)){ echo "#EAEAC6"; }else{ echo "#F1F1DA"; }?>; float:left;">
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
					$head = upperfirst($s);
					echo "<p class='head white pad'>$head</p>";
					?>
				</span>
				<div style="float:left; padding:13px 0 12px 0; background-color:#EE9A00;">
					<p style="width:208px;float:left;font:11px/14px arial;color:#000000; float:left;">
						<img src="images/out_cp_bul.gif" width="5" height="5" alt="" class="out_cp_bul"/><a href="#" style="color:#000000">Why Outsource</a><br>
						<img src="images/out_cp_bul.gif" width="5" height="5" alt="" class="out_cp_bul"/><a href="#" style="color:#000000">Offshore Project Management</a>
					</p>
					<p style="width:208px;float:left;font:11px/14px arial;color:#000000; float:left;">
						<img src="images/out_cp_bul.gif" width="5" height="5" alt="" class="out_cp_bul"/><a href="#" style="color:#000000">Dedicated Development Center</a><br>
						<img src="images/out_cp_bul.gif" width="5" height="5" alt="" class="out_cp_bul"/><a href="#" style="color:#000000">Onsight-Offshore Methodology</a>
					</p>
					<p style="width:208px;float:left;font:11px/14px arial;color:#000000; float:left;">
						<img src="images/out_cp_bul.gif" width="5" height="5" alt="" class="out_cp_bul"/><a href="#" style="color:#000000">Dedicated Development Center</a><br>
						<img src="images/out_cp_bul.gif" width="5" height="5" alt="" class="out_cp_bul"/><a href="#" style="color:#000000">Onsight-Offshore Methodology</a>
					</p>
				</div>
				<?php
				}
				?>
				<div class="cp_mansuit">
					<p class="head red pad">Newest Times</p><br/><br/>
						<?php
							include "newest_times.php";
						?>
				</div>
				<div style="padding-bottom:10px; background-color:#3F5262; float:left;">
					<?php
						include "tips.php";
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
			<p class="head pad">Level Packs</p><br/><br/>
			<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt2">The Kopa Trilogy</a><br/>
			<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt2">Dragstrup Cup 2003</a><br/>
			<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt2">1337 Contest</a><br/>
			<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt2">cEp levels</a>
		</div>
		<?php
		}
		?>
		<div class="right<?php if(isset($s)){ echo " rightborder"; } ?>">
			<div style="padding-bottom:17px; float:left; background-color:#F7F9EC; width:193px;<?php if(isset($s)){ echo "border-bottom:5px solid #A8C809;"; } ?>">
				<a href="#" class="rp_buttxt2 bold pad">Contest Levels</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt">eLopa</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt">ILDC</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >Dakar Cup</a>&nbsp;
				<img src="images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="#" class="rp_buttxt" >Dakar Cup 2</a><br/>
				<a href="#" class="rp_buttxt2 bold pad">Internal Mixes</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt">Mirror</a>&nbsp;
				<img src="images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="#" class="rp_buttxt" >Max</a>&nbsp;
				<img src="images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="#" class="rp_buttxt" >Tilted</a><br/>
				<a href="#" class="rp_buttxt2 bold pad">Level Packs</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >WkE levels</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >umiz</a>&nbsp;
				<img src="images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="#" class="rp_buttxt" >qumiz</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >OBLP</a>&nbsp;
				<img src="images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="#" class="rp_buttxt" >EPLP</a>&nbsp;
				<img src="images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="#" class="rp_buttxt" >NP</a>&nbsp;
				<img src="images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="#" class="rp_buttxt" >Qsla</a>&nbsp;
				<img src="images/rp_but.gif" width="4" height="6" alt="" class=""/>&nbsp;<a href="#" class="rp_buttxt" >Gsla</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >Tube</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >Shareware</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >FinMan Pipes</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >Great Sticks</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >semen</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >VSK</a><br/>
				<a href="#" class="rp_buttxt2 bold pad">Höylä Levels</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >veezay höylä</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >HP</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >Raven Höylä Pack</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >FinMan Höylä levels</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >danpe levels</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >I-levels</a><br/>
				<img src="images/rp_but.gif" width="4" height="6" alt="" class="rp_but"/><a href="#" class="rp_buttxt" >Bliz Höylä</a>
			</div> 
		</div>
<!-- right panel ends here -->
	</div>
<!-- central panel ends here -->
<!-- footer panel starts here -->
	<div class="tab">
		<div class="fp_1pxbg">
			<p>
				<a href="#" class="fp_txt">About Kopasite</a>
				<span class="fp_sep">|</span>
				<a href="#" class="fp_txt">Kinglist</a>
				<span class="fp_sep">|</span>
				<a href="#" class="fp_txt">Help</a>
				<span class="fp_sep">|</span>
				<a href="#" class="fp_txt">Contact Kopasite</a>
				<span class="fp_sep">|</span>
				<a href="#" class="fp_txt">Privacy Policy</a>
				<span class="fp_sep">|</span>
				<a href="#" class="fp_txt">Sitemap</a>
			</p>
			&copy; Copyright Kopasite.net 2010. All rights reserved.
		</div>
	 </div>
	</div>
</center>
</body>
</html>
