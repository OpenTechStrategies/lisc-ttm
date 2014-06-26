<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('#username').focus();
    });
</script>
<div id="login_here" align="center">
    <!--
    Fairly routine login page.
    -->
    <table>
        <tr>
            <td colspan="2" align="center">
                <h3>TTM Login</h3>
            </td>
        </tr>
        <tr>
            <td>
                Username:
            </td>
            <td>
                <input type="text" name="username" id="username" maxlength="50"
                       onkeydown="
                               if ((event.which == 13) || (event.keyCode == 13)) {
                                   return log_in_submit_form();
                               }" />
            </td>
        </tr>
        <tr>
            <td>
                Password:
            </td>
            <td>
                <input type="password" name="password" id="password" maxlength="50"
                       onkeydown="
                               if ((event.which == 13) || (event.keyCode == 13)) {
                                   return log_in_submit_form();
                               }" />
            </td>
            <td>
                <!--
                Link to page where users can reset their own passwords.
                -->
                <a href="reset_password.php">Change Password</a>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <div id="login_error" style="color: #ff0000;"></div>
                <input type="button" value="Log In" id="login_submit_button" onclick="return log_in_submit_form();" />
            </td>
        </tr>
    </table></div>
<script type="text/javascript">
    //login script
    function log_in_form_check() {
        $('#login_submit_button').fadeOut('slow');
        if (document.getElementById('username').value.length < 1) {
            document.getElementById('login_error').innerHTML = 'Please enter a valid username';
            $('#login_error').slideDown('slow').delay(2000).slideUp('slow');
            document.getElementById('username').focus();
            $('#ajax_loader').hide();
            $('#login_submit_button').fadeIn('slow');
            return false;
        }
        if (document.getElementById('password').value.length < 1) {
            document.getElementById('login_error').innerHTML = 'Please enter a valid password';
            $('#login_error').slideDown('slow').delay(2000).slideUp('slow');
            document.getElementById('password').focus();
            $('#ajax_loader').hide();
            $('#login_submit_button').fadeIn('slow');
            return false;
        }
        return true;
    }

    function log_in_submit_form() {
        $('#ajax_loader').fadeIn('slow');
        if (log_in_form_check()) {
            $.post(
                    './ajax/login_submit.php',
                    {
                        username: document.getElementById('username').value,
                        password: document.getElementById('password').value
                    },
            function(response) {
                if (response != '0') {
                    window.location.href = '/';
                } else {
                    $('#ajax_loader').fadeOut('slow');
                    document.getElementById('password').value = '';
                    document.getElementById('login_error').innerHTML = 'Invalid username / password';
                    $('#login_error').slideDown('slow').delay(2000).slideUp('slow');
                    $('#login_submit_button').fadeIn('slow');
                }
            }
            );
        }
    }
</script>
