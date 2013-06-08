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
	<div class='table border padding margin'>
<?php
if ($actionObject ["system"] == false) {
	$errorState = true;
	$message = ERROR_MISSING_SYSTEM_INFO;
} else if ($actionObject ["stats"] == false) {
	$errorState = true;
	$message = ERROR_MISSING_CORE_STATS;
} else {
	$showingResults = array ();
	if (! empty ( $actionObject ["stats"] ["queryhandler"] )) {
		$showingResults [] = "queryhandler";
	}
	if (! empty ( $actionObject ["stats"] ["cache"] )) {
		$showingResults [] = "cache";
	}
	$message = "Showing results from " . join ( ", ", $showingResults );
}
?>
	<div class='row head'>
			<div class='cell'>Server</div>
			<div class='cell'>Core</div>
			<div class='cell'>Solr Version</div>
			<div class='cell'>Lucene Version</div>
			<div class='cell'>Status</div>
		</div>
		<div class='row'>
			<div class='cell'><?php echo $server ?></div>
			<div class='cell'><?php echo $core ?></div>
			<div class='cell center'><?php echo $actionObject["system"]["solr-spec-version"] ?></div>
			<div class='cell center'><?php echo $actionObject["system"]["lucene-spec-version"] ?></div>
			<?php if ($errorState) { $class = "error"; } ?>
		<div class='cell center <?php echo $class; ?>'><?php echo $message ?></div>
		</div>
	</div>
</div>

<?php if (!$errorState) { ?>

<div class="container">
	<div class="section-head border padding margin">Query Handlers</div>
	<?php if (!empty($actionObject ["stats"] ["queryhandler"])) { ?>
	<div class='table border padding margin'>
		<div class='row head'>
			<div class='cell'>Name</div>
			<div class='cell'>Class</div>
			<?php foreach ($handlerStatsFields as $field) {?>
			<div class='cell'><?php echo $field['title'] ?></div>
			<?php } ?>
		</div>
		<?php
		$i = 0;
		foreach ( $actionObject ["stats"] ["queryhandler"] as $handler ) {
			$i ++;
			echo "<div class='row'>";
			echo "<div class='cell'>" . $handler ['name'];
			echo "<a onClick='toggleDisplay(desc_handler_" . $i . ");'><span class='padding-2 small'>desc</span></a>";
			echo "<span id='desc_handler_" . $i . "' class='margin medium' style='display:none;'>" . preg_replace ( "/(\s*(,|\(|\))\s*)+/", "<br>", $handler ['description'] ) . "</span>";
			echo "</div>";
			echo "<div class='cell'>" . $handler ['class'] . "</div>";
			foreach ( $handlerStatsFields as $key => $field ) {
				echo "<div class='cell center'>";
				printf ( $field ['format'], $handler [$key] );
				echo "</div>";
			}
			echo "</div>";
		}
		?>
</div>
	<?php
	} else {
		echo ERROR_NO_ACTIVE_HANDLERS;
	}
	?>
</div>

<div class="container">
	<div class="section-head border padding margin">Cache</div>
	<?php if (!empty($actionObject ["stats"] ["queryhandler"])) { ?>
	<div class='table border padding margin'>
		<div class='row head'>
			<div class='cell'>Name</div>
			<div class='cell'>Class</div>
			<?php foreach ($cacheStatsFields as $field) {?>
			<div class='cell'><?php echo $field['title'] ?></div>
			<?php } ?>
		</div>
		<?php
		$i = 0;
		foreach ( $actionObject ["stats"] ["cache"] as $cache ) {
			$i ++;
			echo "<div class='row'>";
			echo "<div class='cell'>" . $cache ['name'];
			echo "<a onClick='toggleDisplay(desc_cache_" . $i . ");'><span class='padding-2 small'>desc</span></a>";
			echo "<span id='desc_cache_" . $i . "' class='margin medium' style='display:none;'>" . preg_replace ( "/(\s*(,|\(|\))\s*)+/", "<br>", $cache ['description'] ) . "</span>";
			echo "</div>";
			echo "<div class='cell'>" . $cache ['class'] . "</div>";
			foreach ( $cacheStatsFields as $key => $field ) {
				echo "<div class='cell center'>";
				printf ( $field ['format'], $cache [$key] );
				echo "</div>";
			}
			echo "</div>";
		}
		?>
	</div>
	<?php
	} else {
		echo ERROR_NO_CACHE_INFO;
	}
	?>
</div>

<?php } ?>