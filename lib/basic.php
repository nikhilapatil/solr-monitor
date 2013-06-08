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

// Current version
define ( "VERSION", "0.1" );

// Configuration file path
define ( "CONF_PATH", "./conf/solr.php" );

// Error messages
define ( "ERROR_MISSING_CORE_INFO", "Cores could not be loaded" );
define ( "ERROR_UPDATING_CONF_FILE", "Error updating configuration file at " . CONF_PATH . " Please check file permissions" );
define ( "ERROR_MISSING_SYSTEM_INFO", "System info could not be retrieved. Solr older than 1.4?" );
define ( "ERROR_MISSING_CORE_STATS", "Stats for this core could not be retrieved" );
define ( "ERROR_NO_ACTIVE_HANDLERS", "There are no active handlers on this core" );
define ( "ERROR_NO_CACHE_INFO", "Details about cache unavailable" );

// Autoloader
function __autoload($class) {
	require_once strtolower ( str_replace ( '_', DIRECTORY_SEPARATOR, $class ) ) . '.php';
}
