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

class Lib_Solr_Handler {
	
	private static $_instance = null;
	
	private function __construct() {
	}
	
	public static function getInstance() {
		if (! isset ( self::$_instance )) {
			self::$_instance = new self ();
		}
		return self::$_instance;
	}
	
	public function getCores($server) {
		$url = $server . "/admin/cores" . "?wt=json&json.nl=map";
		$response = $this->getSolrResponse ( $url );
		
		if ($response ["response_code"] == 200) {
			$parsedData = json_decode ( $response ["response_data"], true );
			return $parsedData ["status"];
		} else {
			return false;
		}
	}
	
	public function getSystemInfo($server, $coreName) {
		$url = $server . "/" . $coreName . "/admin/system" . "?wt=json&json.nl=map";
		$response = $this->getSolrResponse ( $url );
		
		if ($response ["response_code"] == 200) {
			$parsedData = json_decode ( $response ["response_data"], true );
			return $parsedData;
		} else {
			return false;
		}
	}
	
	public function getStatsFromMBeans($server, $coreName) {
		$url = $server . "/" . $coreName . "/admin/mbeans?stats=true" . "&wt=json&json.nl=map";
		$response = $this->getSolrResponse ( $url );
		
		if ($response ["response_code"] == 200) {
			$parsedData = json_decode ( $response ["response_data"], true );
			return $parsedData;
		} else {
			return false;
		}
	}
	
	public function getStatsFromJSP($server, $coreName) {
		$url = $server . "/" . $coreName . "/admin/stats.jsp";
		$response = $this->getSolrResponse ( $url );
		
		if ($response ["response_code"] == 200) {
			$xmlData = simplexml_load_string ( $response ["response_data"] );
			$key = "solr-info";
			return $xmlData->$key;
		} else {
			return false;
		}
	}
	
	public function getPingStatus($server, $coreName) {
		$url = $server . "/" . $coreName . "/admin/ping" . "?wt=json&json.nl=map";
		$response = $this->getSolrResponse ( $url );
		
		if ($response ["response_code"] == 200) {
			$parsedData = json_decode ( $response ["response_data"], true );
			return $parsedData ["status"];
		} else {
			return false;
		}
	}
	
	private function getSolrResponse($url) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_TIMEOUT, 10 );
		curl_setopt ( $curl, CURLOPT_PROXY, '' );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		$data = curl_exec ( $curl );
		$code = curl_getinfo ( $curl, CURLINFO_HTTP_CODE );
		curl_close ( $curl );
		
		return array (
				"response_code" => $code,
				"response_data" => $data 
		);
	}
}
