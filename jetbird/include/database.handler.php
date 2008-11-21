<?php

	/*	This file is part of Jetbird.

	    Jetbird is free software: you can redistribute it and/or modify
	    it under the terms of the GNU General Public License as published by
	    the Free Software Foundation, either version 3 of the License, or
	    (at your option) any later version.

	    Jetbird is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.

	    You should have received a copy of the GNU General Public License
	    along with Jetbird.  If not, see <http://www.gnu.org/licenses/>.
	*/
	
	class database_handler {
		var $queries = 0, $link_identifier, $name, $connected, $new_link, $die_on_fail, $last_insert_id;
		private $persistent_connect = false;
		
		function __construct($name = null, $die_on_fail = true, $new_link = true){
			// set up object
			$this->name = $name;
			$this->new_link = $new_link;
			$this->die_on_fail = $die_on_fail;
			$this->connected = false;
		}
		
		function __clone(){
			trigger_error("Cloning not allowed", E_USER_WARNING);
		}
		
		function pconnect($user, $pass, $db, $host){
			$this->persistent_connect = true;
			return $this->connect($user, $pass, $db, $host);
		}
		
		function connect($user, $pass, $db, $host = "localhost"){
			// Connect to the database
			if($this->connected){
				return $this->link_identifier;
			}
			if($this->persistent_connect){
				$this->link_identifier = @mysql_pconnect($host, $user, $pass, $new_link);	
			}else{
				$this->link_identifier = @mysql_connect($host, $user, $pass, $new_link);
			}
			if($this->link_identifier){
				$select = mysql_select_db($db, $this->link_identifier);
				if(!$select){
					trigger_error("Database <b>". $db ."</b> doesn't exist", E_USER_ERROR);
				}
				$this->connected = true;
				return $this->link_identifier;
			}else{
				$this->connected = false;
				if($this->die_on_fail){
					trigger_error('Could not connect to the database', E_USER_ERROR);
				}
				return false;
			}
		}
		
		function query($query){
			// query database
			if(!$this->connected){
				trigger_error('Not connected to a database', E_USER_ERROR);
			}
			$query = @mysql_query($query, $this->link_identifier);
			$error = mysql_error($this->link_identifier);
			if(!empty($error)){
				$backtrace = debug_backtrace();
				
				// Try to be as exact as possible, we want to know where exactly that db_handler crashed, and that's
				//  most of the time NOT in this file
				$crashed_file = 0;
				while(eregi("database.handler.php", $backtrace[$crashed_file]['file'])) $crashed_file++;
								
				echo "<b>Fatal error:</b> ". $error ." in <b>". $backtrace[$crashed_file]['file'] ."</b> on line <b>". $backtrace[$crashed_file]['line'] ."</b>";
				die();
			}
			$this->queries++;
			$this->last_insert_id = mysql_insert_id($this->link_identifier);
			return $query;
		}
		
		function fetch_array($query, $mode = MYSQL_ASSOC){
			if(is_string($query)){
				$result = $this->query($query);
				while($row = mysql_fetch_array($result, $mode)){
					$output[] = $row;
				}
				mysql_free_result($result);
			}elseif(is_resource($query)){
				$result = &$query;
				mysql_data_seek($result, 0);		// Reset pointer, needed if using same resource more than once
				while($row = mysql_fetch_array($result, $mode)){
					$output[] = $row;
				}
			}
			return $output;
		}
		
		function fetch_result($query, $row = 0){
			$output = false;
			if(is_string($query)){
				$result = $this->query($query);
				$output = mysql_result($result, $row);
				mysql_free_result($result);
			}elseif(is_resource($query)){
				$result = &$query;
				$output = mysql_result($result, $row);
			}
			return $output;
		}
		
		function num_rows($query){
			$output = false;
			if(is_string($query)){
				$result = $this->query($query);
				$output = mysql_num_rows($result);
				mysql_free_result($result);
			}elseif(is_resource($query)){
				$result = &$query;
				$output = mysql_num_rows($result);
			}
			return $output;
		}
		
		function close(){
			if($this->connected){
				$this->connected = false;
				return @mysql_close($this->link_identifier);
			}
		}
		
		function __destruct(){
			$this->close();
		}
	}

?>