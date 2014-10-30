<?php
//test session here, send to error page, exit
/*
 * We set the timezone here, though I'm fairly certain we also set it anywhere we needed to use
 * date().
 */
date_default_timezone_set('America/Chicago');
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>LISC TTM Data Center</title>
<link href="/styles/styles.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="/images/favicon.ico"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>

<!--[if IE]>
<script src="<?//echo ($_SERVER['DOCUMENT_ROOT'] . '/include/excanvas_r3/excanvas.js')?>"></script>
<![endif]-->
    </head>
    <body>
        <img src="/images/ajax-loader.gif" width="40" height="40" alt="Loading..." id="ajax_loader" style="display: none; position: fixed; top: 0; left: 0;" />

		<hr class="divider">        
        <div id="header">

            <span><a href="/index.php">Testing the Model Data Center</a></span>
			<a href="http://lisc-chicago.org/" ><img src="/images/lisc-chicago-logo.gif" id="lisc_logo" /></a>

        </div>			
		<hr class="divider">
		<div id="main_wrapper">