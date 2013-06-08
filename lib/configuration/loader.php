<?php
/**
 Copyright 2013 Nikhil Patil

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
 **/

class Lib_Configuration_Loader {
	
	private $_configuration = array ();
	
	private static $_instance = null;
	
	private function __construct() {
		$this->_configuration = require CONF_PATH;
	}
	
	public static function getInstance() {
		if (! isset ( self::$_instance )) {
			self::$_instance = new self ();
		}
		return self::$_instance;
	}
	
	public function get($key) {
		return $this->_configuration [$key];
	}
	
	public function set($key, $value) {
		$this->_configuration [$key] = $value;
	}
	
	public function clean() {
		if (! empty ( $this->_configuration ) && is_array ( $this->_configuration )) {
			foreach ( $this->_configuration as $key => $valueArray ) {
				$this->_configuration [$key] = array_unique ( $this->_configuration [$key] );
				foreach ( $valueArray as $id => $value ) {
					if (empty ( $value )) {
						unset ( $this->_configuration [$key] [$id] );
					}
				}
				asort ( $this->_configuration [$key] );
			}
			asort ( $this->_configuration );
			return true;
		} else {
			return false;
		}
	}
	
	public function write() {
		if ($this->clean ()) {
			return is_numeric ( file_put_contents ( CONF_PATH, '<?php' . PHP_EOL . 'return ' . var_export ( $this->_configuration, true ) . ';' ) );
		} else {
			return false;
		}
	}
}
