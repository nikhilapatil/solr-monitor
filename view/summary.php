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
?>
<div class="container">
	<div class='table border padding margin' id="summary">
		<div class='row head'>
			<div class='cell'>
				Server <span class="medium"><a href="#" class="event-link"
					onClick="sortTable('summary','server','asc')">&uarr;</a>/<a
					href="#" class="event-link"
					onClick="sortTable('summary','server','desc')">&darr;</a></span>
			</div>
			<div class='cell'>
				Core <span class="medium"><a href="#" class="event-link"
					onClick="sortTable('summary','core','asc')">&uarr;</a>/<a href="#"
					class="event-link" onClick="sortTable('summary','core','desc')">&darr;</a></span>
			</div>
			<div class='cell'>Ping</div>
			<div class='cell'>Documents</div>
			<div class='cell'>Uptime</div>
		</div>
<?php
foreach ( $actionObject as $server => $cores ) {
	if ($cores === false) {
		echo "<div class='row'>";
		echo "<div class='cell' name='server'>" . $server . "</div>";
		echo "<div class='cell center error'>" . ERROR_MISSING_CORE_INFO . "</div>";
		echo "</div>";
	} else {
		foreach ( $cores as $coreReport ) {
			echo "<div class='row'>";
			echo "<div class='cell' name='server'>" . $server . "</div>";
			echo "<div class='cell' name='core'><a href='index.php?method=details&name=" . urlencode ( $coreReport ['name'] ) . "&server=" . urlencode ( $server ) . "'>" . $coreReport ['name'] . "</a></div>";
			if ($coreReport ['ping'] == "OK") {
				$class = "ping";
			} else {
				$class = "error";
			}
			echo "<div class='cell center " . $class . "'>" . $coreReport ['ping'] . "</div>";
			echo "<div class='cell'>" . $coreReport ['idx_numDocs'] . "</div>";
			echo "<div class='cell'>" . Lib_Misc_Utilities::formatMilliseconds ( $coreReport ['uptime'] ) . "</div>";
			echo "</div>";
		}
	}
}
?>
</div>
</div>