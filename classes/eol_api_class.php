<?php

/*  EOL API Class

http://beta.elmaonline.net
Made by Kopaka 12 July 2011

*/

class EOLAPI{

	/* class variables */
	var $url;
	var $rssurl;
	var $verified;
	var $fields;
	/* required variables */
	var $levelid; // the level(s) you wanna search for, seperate by comma
	/* optional variables */
	var $bestall; // all for all times, best for only every players best time
	var $timeformat; // hs for hundreds, str for 00:00,00
	var $kuski; // by setting this you only get that players time(s), required for verify() function
	/* required variables for verify() function */
	var $eoltime; // the time you wanna search for
	

	function __construct(){ // constructor
		$this->verified = false;
		$this->url = "http://elmaonline.net/rss/?makerss=1&levelid=";
		$this->bestall = "all";
		$this->timeformat = "str";
		$this->fields = array('kuski', 'eoltime');
	}

	function addField($field){
		if(in_array($field, array('datetime'))){
			$this->fields[] = $field;
		}
	}

	function removeField($field){
		if($key = array_search($field, $this->fields)){
			unset($this->fields[$key]);
		}
	}

	private function verifyVariables(){
		if(!in_array($this->bestall, array('best', 'all'))){
			$this->bestall = "all";
		}
		if(!in_array($this->timeformat, array('str', 'hs'))){
			$this->timeformat = "str";
		}
	}

	function getTimes(){
		if($this->levelid != NULL){
			$this->verifyVariables();
			$this->rssurl = $this->url;
			foreach($this->levelid as $i){
				$this->rssurl .= $i . ",";
			}
			$this->rssurl = substr($this->rssurl, 0, -1);
			if($this->bestall == "all"){
				$this->rssurl .= "&bestall=all";
			}
			if($this->kuski != NULL){
				$this->rssurl .= "&kuski=" . $this->kuski;
			}
			if($this->timeformat == "hs"){
				$this->rssurl .= "&timeformat=" . $this->timeformat;
			}
			$rss = simplexml_load_file($this->rssurl);

			$arr = array();
			$lev = 0;
			foreach($rss->channel as $chan){
				$no = 1;
				$title = substr_replace(substr_replace(serialize($chan->title), "", 0, 36), "", -3, 3);
				foreach($chan->item as $item){
					foreach($this->fields as $f){
						$arr[$title][$no][$f] = $item->$f;
					}
					$no++;
				}
				$lev++;
			}
			return $arr;
		}else{
			return false;
		}
	}

	function verify(){
		if($this->levelid != NULL && $this->eoltime != NULL && $this->kuski != NULL){
			$this->rssurl = $this->url;
			foreach($this->levelid as $i){
				$this->rssurl .= $i . ",";
			}
			$this->rssurl = substr($this->rssurl, 0, -1);
			if($this->bestall == "all"){
				$this->rssurl .= "&bestall=all";
			}
			$this->rssurl .= "&kuski=" . $this->kuski;
			$rss = simplexml_load_file($this->rssurl);

			$items = $rss->channel->item;
			foreach($items as $item){
				if($item->kuski == $this->kuski){
					if($item->eoltime == $this->eoltime){
						$this->verified = true;
					}
				}
			}
		}
		return $this->verified;
	}

}


?>