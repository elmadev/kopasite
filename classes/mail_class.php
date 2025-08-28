<?php

class Email{

	var $headers;
	var $message;
	var $to;
	var $headline;
	var $from;
	var $frommail;
	var $wrap;

	function __construct(){ // constructor
		$this->wrap = 70;
	}

	function sendMail(){
		if($this->message != "" && $this->to != "" && $this->headline != "" && $this->from != "" && $this->frommail != ""){
			$this->headers = "MIME-Version: 1.0\n";
			$this->headers .= "Content-type: text/plain; charset=iso-8859-1\n";
			$this->headers .= "From: ".$this->from." <".$this->frommail.">\n";
			$this->headers .= "X-Mailer: PHP's mail() Function\n";

			$this->message = wordwrap($this->message, $this->wrap);
			mail($this->to, $this->headline, $this->message, $this->headers);
			return true;
		}else{
			return false;
		}
	}

}

?>