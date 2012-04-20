<?php
	function connect_db(){
		$conn = mysql_connect('localhost','root','m_f/g+jlwSUvMSt_+');
		mysql_select_db('friend');
		mysql_query("set names 'utf8'",$conn); 
		return $conn;
	}

?>
