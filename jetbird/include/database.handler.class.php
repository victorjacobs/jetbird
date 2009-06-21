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
		var $queries = 0, $link_identifier, $connected, $new_link, $die_on_fail, $last_insert_id;
		private $persistent_connect = false, $database;
		
		public function __construct($die_on_fail = true, $new_link = true){
			// set up object
			$this->new_link = $new_link;
			$this->die_on_fail = $die_on_fail;
			$this->connected = false;
		}
		
		public function __clone(){
			trigger_error("Cloning not allowed", E_USER_WARNING);
		}
		
		public function pconnect($user, $pass, $db, $host){
			$this->persistent_connect = true;
			return $this->connect($user, $pass, $db, $host);
		}
		
		public function connect($user, $pass, $db, $host = "localhost"){
			$this->database = $db;
			// Connect to the database
			if($this->connected){
				return $this->link_identifier;
			}
			if($this->persistent_connect){
				$this->link_identifier = @mysql_pconnect($host, $user, $pass, $this->new_link);	
			}else{
				$this->link_identifier = @mysql_connect($host, $user, $pass, $this->new_link);
			}
			if($this->link_identifier){
				$select = @mysql_select_db($db, $this->link_identifier);
				// Don't throw an error when the database doesn't exist, maybe we are installing
				$this->db_exists = $select;
				
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
		
		public function query($query){
			// query database
			// TODO escape input.
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
		
		public function fetch_array($query, $mode = MYSQL_ASSOC){
			$output = false;
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
		
		public function fetch_result($query, $row = 0){
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
		
		public function num_rows($query){
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
		
		public function close(){
			if($this->connected){
				$this->connected = false;
				return @mysql_close($this->link_identifier);
			}
		}
		
		public function export_structure($file, $exported_db_name = "jetbird"){
			// Only enable this function when debugging
			if(!_JB_DEBUG || !$this->connected){
				return false;
			}
			
			if(($fh = @fopen($file, "w")) === false){
				trigger_error($file ." is not writable", E_USER_ERROR);
			}
			
			// Database create, the dump will create a db called $exported_db_name
			list($database_create) = $this->fetch_array("SHOW CREATE DATABASE ". $this->database);
			$database_create = str_replace($this->database, $exported_db_name, $database_create['Create Database']);
			
			$tables = $this->fetch_array("SHOW TABLES");
			foreach($tables as $table){
				$table_name = $table['Tables_in_'. $this->database];
				
				list($table_structure_temp) = $this->fetch_array("SHOW CREATE TABLE ". $table_name);
				// This is a fresh database, so don't include AUTO_INCREMENT values
				$table_structure[] = preg_replace('$AUTO_INCREMENT=[0-9]+ $', "", $table_structure_temp['Create Table']);
			}
			
			// Build output
			$output = '/* Database structure of '. $this->database .' generated by Jetbird\'s database_handler class on '. date("c") .' */'. "\n\n";
			$output .= $database_create .";\n";
			$output .= "USE `$exported_db_name`;\n\n";
			
			foreach($table_structure as $table){
				$output .= $table .";\n\n";
			}
			
			$output = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $output);
			
			$success = @fwrite($fh, $output);
			fclose($fh);
			
			return $success;
		}
		
		public function import($file){
			
		}
		
		public function __destruct(){
			$this->close();
		}
	}

?>