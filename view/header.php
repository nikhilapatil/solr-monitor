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
<html>
<head>
<title>Solr Monitor <?php echo VERSION; ?></title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<!-- Github Fork Image -->
<a href="https://github.com/nikhilapatil/solr-monitor" target="_blank">
<img alt="Fork me on GitHub" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" style="position: absolute; top: 0; right: 0; border: 0;z-index:99999999;"></img>
</a>
<div class="logo padding margin">
Solr Monitor <?php echo VERSION; ?>
</div>
<div class="menu border padding margin">
<?php if ($requestType == "summary") { ?>
Summary
<?php } else { ?>
<a class="menu-link" href="index.php?method=summary">Summary</a>
<?php } ?>
 | 
<?php if ($requestType == "configure") { ?>
Configure
<?php } else { ?>
<a class="menu-link" href="index.php?method=configure">Configure</a>
<?php } ?>
</div>
