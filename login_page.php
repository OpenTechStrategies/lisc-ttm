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
<div id="login_here" align="center">
    <!--
    Fairly routine login page.
    -->
    <form name='login_form' id='login_form' action="/" method="post">
        <table>
            <tr>
                <td colspan="2" align="center">
                    <h3>TTM Login</h3>
                </td>
            </tr>
            <tr>
                <td width="100" align="right">
                    Username:
                </td>
                <td>
                    <input type="text" name="username" id="username" maxlength="50" />
                </td>
            </tr>
            <tr>
                <td width="100" align="right">
                    Password:
                </td>
                <td>
                    <input type="password" name="password" id="password" maxlength="50" />
                </td>
                <td width=150>
                    <!--
                    Link to page where users can reset their own passwords.
                    -->
                    <a href="/reset_password.php">Change Password</a>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <div id="login_error" style="color: #ff0000;"></div>
                    <input type="submit" value="Log In" id="login_submit_button"/>
                </td>
            </tr>
        </table>
    </form>

<br/>
<br/>

    <form action="/enlace/participants/survey.php" method="get">
        <table>
            <tr>
                <td colspan="2" align="center">
                    <h3>Take a Survey</h3>
                </td>
            </tr>
            <tr>
                <td width="100" align="right">
                    Survey Code:
                </td>
                <td>
                    <input type="text" name="code" id="code" maxlength="50" />
                </td>
                <td width=150></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Take Survey">
                </td>
            </tr>
        </table>
    </form>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

    (function($){

        $(document).ready(function() {
            $('#username').focus();

            $('#login_form').on('submit',function(e){
                e.preventDefault();
                $('#ajax_loader').fadeIn('slow');
                if (log_in_form_check()) {
                    $.post(
                        '/ajax/login_submit.php',
                        {
                            username: $('#username').val(),
                            password: $('#password').val()
                        },
                        function(response) {
                            if (response == '0') {
                                window.location.href = '/';
                            } else {
                                $('#ajax_loader').fadeOut('slow');
                                $('#password').val('');
                                $('#login_error').html(response);
                                $('#login_error').slideDown('slow').delay(2000);
                                $('#login_submit_button').fadeIn('slow');
                            }
                        }
                    );
                }
            });
        });

        //login script
        function log_in_form_check() {
            $('#login_submit_button').fadeOut('slow');
            if ($('#username').val().length < 1) {
                $('#login_error').html('Please enter a valid username');
                $('#login_error').slideDown('slow').delay(2000).slideUp('slow');
                $('#username').focus();
            } else if ($('#password').val().length < 1) {
                $('#login_error').html('Please enter a valid password');
                $('#login_error').slideDown('slow').delay(2000).slideUp('slow');
                $('#password').focus();
            } else {
                return true;
            }
            $('#ajax_loader').hide();
            $('#login_submit_button').fadeIn('slow');
            return false;
        }

    })(jQuery)

</script>
