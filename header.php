<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
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
