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
      <link href="/styles/styles.css" rel="stylesheet" type="text/css" />
        <link href="/include/jquery/1.9.1/css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css" />
        <script src="/include/jquery/1.9.1/js/jquery-1.8.2.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.core.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="/include/jquery/1.9.1/development-bundle/ui/jquery.ui.datepicker.js" type="text/javascript"></script>
        
        <!--
        this is just like datepicker_simple, but includes its own input box (with datepicker).  Useful when this 
        item needs to appear (with calendar).
        -->
        
        <span id="add_date">Add Date: <input type="text" id="first_program_date"></span> 
		<script>
            //on search events
	$(function() {
                $("#first_program_date").datepicker({changeYear: true});
		$( "#date_start" ).datepicker({changeYear: true});
                $( "#date_end" ).datepicker({changeYear: true});
                $( "#start" ).datepicker({changeYear: true});
                $( "#end" ).datepicker({changeYear: true});
		$(".hasDatepickers").datepicker({changeYear: true});
	});
        </script>