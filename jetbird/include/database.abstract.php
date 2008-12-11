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
	
	abstract class database_handler_abstract{
		var $queries = 0, $link_identifier, $name, $connected, $new_link, $die_on_fail, $last_insert_id;
		private $persistent_connect = false;
		
		// These should be implemented in the class
		abstract public function connect($user, $pass, $db, $host = "localhost");
		abstract public function query($query);
		abstract public function fetch_array($query, $mode = MYSQL_ASSOC);
		abstract public function fetch_result($query, $row = 0);
		abstract public function num_rows($query);
		abstract public function close();
		
		// Common funcions
		public function __construct($name = null, $die_on_fail = true, $new_link = true){
			// set up object
			$this->name = $name;
			$this->new_link = $new_link;
			$this->die_on_fail = $die_on_fail;
			$this->connected = false;
		}
		
		public function pconnect($user, $pass, $db, $host){
			$this->persistent_connect = true;
			return $this->connect($user, $pass, $db, $host);
		}
		
		public function __clone(){
			trigger_error("Cloning not allowed", E_USER_WARNING);
		}
		
		public function __destruct(){
			$this->close();
		}
		
	}

?>