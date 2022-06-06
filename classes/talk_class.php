<?php
$k = $_SESSION['kopanick'];
if ($k != '') {
	$getk = mysql_query("SELECT Kuski, Team, KuskiIndex, Country FROM kuski WHERE Kuski = '$k'") or die(mysql_error());
	$rowk = mysql_fetch_array($getk);
	$ki = $rowk['KuskiIndex'];
	$kt = $rowk['Team'];
	$kc = $rowk['Country'];
}
$loggedin = checklogin();
include_once("db_comment_class.php");


class Talk{

	var $type;
	var $bigsmall;
	var $size;

	var $id;
	var $ki;
	var $layout;
	var $limit;

	function Talk(){ // constructor
		$this->bigsmall = "small";
		$this->size = "20";
		$this->type = "chat";
		$this->layout = "std";
		$this->limit = 0;
	}

	function writeBox(){
		if($GLOBALS['loggedin']){
			echo "<form method='post' action='$self'>";
			echo "<p class='head1 pad'>Write comment<br/>";
			if($this->bigsmall == "small"){
			echo "<input type='text' name='comment' size='".$this->size."' /><br/>";
			}else{
				echo "<textarea rows='".round(($this->size / 4), 0)."' cols='".$this->size."' name='comment' wrap='physical'></textarea><br/>";
			}
			echo "</p>";
			if($this->type == "kuski"){
				echo "<p class='pad size11'><input type='checkbox' name='private' value='true' class='button' /> Private message</p>";
			}
			echo "<input type='submit' name='writecomment' value='Send' class='button' /></p>";
			echo "<input type='hidden' name='type' value='".$this->type."' />";
			echo "<input type='hidden' name='id' value='".$this->id."' />";
			echo "</form>";
		}
	}

	function insert(){
		if(isset($_POST['writecomment'])){
			$dbobject = new Comment;
			$fieldarray = array('KuskiIndex' => $this->ki, 'Comment' => hax($_POST['comment']));
			if($_POST['private']){
				$fieldarray['Private'] = 1;
			}
			if($_POST['type'] == "level"){
				$fieldarray['LevelIndex'] = hax($_POST['id']);
			}
			if($_POST['type'] == "kuski"){
				$fieldarray['KuskiCommentIndex'] = hax($_POST['id']);
			}
			if($_POST['type'] == "pack"){
				$fieldarray['LevelPackIndex'] = hax($_POST['id']);
			}
			$dbobject->insert($fieldarray);
		}
	}

	function echoTalks(){
		echo "<table>";
		$result = new Comment;
		if($this->type == "kuski"){
			$result->where = "KuskiCommentIndex = '".$this->id."'";
		}
		if($this->type == "pack"){
			$result->where = "LevelPackIndex = '".$this->id."'";
		}
		if($this->type == "level"){
			$result->where = "LevelIndex = '".$this->id."'";
		}
		$result->orderby = "Datetime DESC";
		if($this->limit != 0){
			$result->limit = "0,".$this->limit;
		}
		$data = $result->select();
		foreach($data as $row){
			if($row['Private'] == 1){
				$this->id = $row['KuskiCommentIndex'];
				if($row['KuskiIndex'] != $this->ki && $this->id != $this->ki){
					continue;
				}else{
					$priv = " [P]";
				}
			}else{
				$priv = "";
			}
			if($this->layout == "std"){
				echo "<tr><td>[".$row['Datetime']."]".$priv." (".kuski($row['KuskiIndex'], false).") ".$row['Comment']."</td></tr>";
			}
			if($this->layout == "chat"){
				echo "<span class='lp_buttxt'><img src='".$GLOBALS['url']."/images/cp_rndbut.gif' width='6' height='6' alt='' class='cp_rndbut'/></span>";
				echo "<p class='head1'>".kuski($row['KuskiIndex'], false)." >> ";
				if($row['LevelIndex'] != 0){
					echo lev($row['LevelIndex']);
				}elseif($row['LevelPackIndex'] != 0){
					echo levpack($row['LevelPackIndex'], "short");
				}elseif($row['KuskiCommentIndex'] != 0){
					echo kuski($row['KuskiCommentIndex'], false);
				}else{
					echo "Chat";
				}
				echo "<br/></p><p class='pad size11'>".$row['Comment']."<br/></p>";
			}
		}
		echo "</table>";
	}

}

?>