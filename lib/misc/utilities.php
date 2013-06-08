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

class Lib_Misc_Utilities {

	public static function formatMilliseconds($milliseconds) {
		$seconds = floor ( $milliseconds / 1000 );
		$minutes = floor ( $seconds / 60 );
		$hours = floor ( $minutes / 60 );
		$days = floor ( $hours / 24 );
		$milliseconds = substr ( $milliseconds, - 3 );
		$seconds = $seconds % 60;
		$minutes = $minutes % 60;
		$hours = $hours % 24;
		
		$format = '%ud %02u:%02u:%02u.%03u';
		$time = sprintf ( $format, $days, $hours, $minutes, $seconds, $milliseconds );
		return $time;
	}
}