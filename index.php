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

// Here we start.

// Headers
header ( 'Content-type: text/html; charset=UTF-8' );
header ( 'Cache-Control: no-cache, must-revalidate' );

require_once './lib/basic.php';

$_conf = Lib_Configuration_Loader::getInstance ();
$servers = $_conf->get ( "servers" );

$handler = Lib_Solr_Handler::getInstance ();

/* Set request type */
$requestType = "summary";
if (! empty ( $_GET ['method'] )) {
	$requestType = $_GET ['method'];
}
if (empty ( $servers )) {
	$requestType = "configure";
}

include 'view/header.php';

$actionObject = array ();

switch ($requestType) {
	case "configure" :
		include 'view/configure.php';
		break;
	
	case "details" :
		$server = $_GET ['server'];
		$core = $_GET ['name'];
		
		$handlerStatsFields = array (
				'avgTimePerRequest' => array (
						'title' => 'Average time per request',
						'format' => '%f' 
				),
				'avgRequestsPerSecond' => array (
						'title' => 'Average requests per second',
						'format' => '%f' 
				) 
		);
		
		$cacheStatsFields = array (
				'size' => array (
						'title' => 'Size',
						'format' => '%s' 
				),
				'warmupTime' => array (
						'title' => 'Warmup Time',
						'format' => '%s' 
				),
				'cumulative_lookups' => array (
						'title' => 'Lookups',
						'format' => '%s' 
				),
				'cumulative_hits' => array (
						'title' => 'Hits',
						'format' => '%s' 
				),
				'cumulative_hitratio' => array (
						'title' => 'Hit Ratio',
						'format' => '%s' 
				),
				'cumulative_inserts' => array (
						'title' => 'Inserts',
						'format' => '%s' 
				),
				'cumulative_evictions' => array (
						'title' => 'Evictions',
						'format' => '%s' 
				) 
		);
		
		$system = $handler->getSystemInfo ( $server, $core );
		
		if ($system === false) {
			$actionObject ["system"] = false;
		} else {
			
			$solr_version = $system ["lucene"] ["solr-spec-version"];
			$lucene_version = $system ["lucene"] ["lucene-spec-version"];
			
			$actionObject ["system"] ["solr-spec-version"] = $solr_version;
			$actionObject ["system"] ["lucene-spec-version"] = $lucene_version;
			
			if (preg_match ( "/^\d+\.\d+/", $solr_version, $matches )) {
				$solr_version_main = $matches [0];
			} else {
				$solr_version_main = 3.1;
			}
			
			if ($solr_version_main >= 3.1) {
				$stats = $handler->getStatsFromMBeans ( $server, $core );
				
				if ($stats === false) {
					$actionObject ["stats"] = false;
				} else {
					
					$sHandlers = $stats ["solr-mbeans"] ["QUERYHANDLER"];
					
					foreach ( $sHandlers as $handlerName => $sHander ) {
						
						if (! is_array ( $sHander ["stats"] )) {
							continue;
						}
						
						$sHandlerArray = array_intersect_key ( $sHander ["stats"], array_flip ( array_keys ( $handlerStatsFields ) ) );
						if (! is_numeric ( $sHandlerArray ["avgTimePerRequest"] ) || $sHandlerArray ["avgTimePerRequest"] == 0) {
							continue;
						}
						
						$sHandlerArray ['name'] = $handlerName;
						$sHandlerArray ['class'] = $sHander ["class"];
						$sHandlerArray ['description'] = $sHander ["description"];
						
						$actionObject ["stats"] ["queryhandler"] [$sHander ["class"]] = $sHandlerArray;
					}
					
					$sCacheList = $stats ["solr-mbeans"] ["CACHE"];
					
					foreach ( $sCacheList as $cacheName => $sCache ) {
						
						if (! is_array ( $sCache ["stats"] )) {
							continue;
						}
						
						$sCacheArray = array_intersect_key ( $sCache ["stats"], array_flip ( array_keys ( $cacheStatsFields ) ) );
						if (! is_numeric ( $sCacheArray ["size"] )) {
							continue;
						}
						
						$sCacheArray ['name'] = $cacheName;
						$sCacheArray ['class'] = $sCache ["class"];
						$sCacheArray ['description'] = $sCache ["description"];
						
						$actionObject ["stats"] ["cache"] [] = $sCacheArray;
					}
				}
			} else {
				$stats = $handler->getStatsFromJSP ( $server, $core );
				
				if ($stats === false) {
					$actionObject ["stats"] = false;
				} else {
					
					$sHandlers = $stats->QUERYHANDLER->entry;
					
					$t = array_keys ( $handlerStatsFields );
					
					foreach ( $sHandlers as $sHander ) {
						
						$sHandlerArray = array ();
						
						foreach ( $sHander->stats->stat as $stat ) {
							if (in_array ( ( string ) $stat->attributes ()->name, $t )) {
								$sHandlerArray [( string ) $stat->attributes ()->name] = trim ( ( string ) $stat );
							}
						}
						if (! is_numeric ( $sHandlerArray ["avgTimePerRequest"] ) || $sHandlerArray ["avgTimePerRequest"] == 0) {
							continue;
						}
						
						$sHandlerArray ['name'] = trim ( $sHander->name );
						$sHandlerArray ['class'] = trim ( $sHander->class );
						$sHandlerArray ['description'] = trim ( $sHander->description );
						
						$actionObject ["stats"] ["queryhandler"] [( string ) $sHander->class] = $sHandlerArray;
					}
					
					$sCacheList = $stats->CACHE->entry;
					
					$t = array_keys ( $cacheStatsFields );
					
					foreach ( $sCacheList as $sCache ) {
						
						$sCacheArray = array ();
						
						foreach ( $sCache->stats->stat as $stat ) {
							if (in_array ( ( string ) $stat->attributes ()->name, $t )) {
								$sCacheArray [( string ) $stat->attributes ()->name] = trim ( ( string ) $stat );
							}
						}
						if (! is_numeric ( $sCacheArray ["size"] )) {
							continue;
						}
						
						$sCacheArray ['name'] = trim ( $sCache->name );
						$sCacheArray ['class'] = trim ( $sCache->class );
						$sCacheArray ['description'] = trim ( $sCache->description );
						
						$actionObject ["stats"] ["cache"] [] = $sCacheArray;
					}
				}
			}
		}
		
		include 'view/details.php';
		break;
	
	case "summary" :
	default :
		foreach ( $servers as $server ) {
			$cores = $handler->getCores ( $server );
			
			if ($cores === false) {
				$actionObject [$server] = false;
			} else {
				
				foreach ( $cores as $core ) {
					$ping = $handler->getPingStatus ( $server, $core ['name'] );
					$coreReport ['ping'] = $ping;
					
					$coreReport ['name'] = $core ['name'];
					$coreReport ['idx_numDocs'] = $core ['index'] ['numDocs'];
					$coreReport ['uptime'] = $core ['uptime'];
					
					$actionObject [$server] [] = $coreReport;
				}
			}
		}
		
		include 'view/summary.php';
}

include 'view/footer.php';
