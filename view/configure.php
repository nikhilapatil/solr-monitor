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

if (! empty ( $_POST ) && is_array ( $_POST ['servers'] )) {
	$servers = $_POST ['servers'];
	$_conf->set ( "servers", $servers );
	if (! $_conf->write ()) {
		echo "<div class='error'>" . ERROR_UPDATING_CONF_FILE . "</div>";
	} else {
		$servers = $_conf->get ( "servers" );
	}
}

?>
<div class="container width-3">
	<div style="display: none;" id="server-tpl">
		<div class="margin">
			<input class="padding-2 border width-2" type="text" name="servers[]">
		</div>
	</div>
	<div class="section-head border padding margin">Server list</div>
	<div class="border padding margin">
		<form method="post" style="margin: 0;">
			<div id="servers">
<?php
if (! empty ( $servers )) {
	foreach ( $servers as $server ) {
		?>
		<div class="margin">
					<input class="padding-2 border width-2" type="text"
						name="servers[]" value="<?php echo $server ?>">
				</div>
<?php
	}
} else {
	?>
		<div class="margin">
					<input class="padding-2 border width-2" type="text"
						name="servers[]">
				</div>
<?php
}
?>
			</div>
			<div class="small">e.g. http://192.168.1.1:8983/solr</div>
			<div class="margin">
				<input type="button" class="border" style="padding: 0 10px;"
					value="Add Another" onClick="addMoreText();"> <input type="submit"
					class="border" style="padding: 0 10px;" value="Save">
			</div>
		</form>
	</div>
</div>