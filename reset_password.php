<?php include "header.php"; ?>

<!--
Give username and password, then enter new password twice (to prevent typos).  Sends
to another file to update the users table with the new password.
-->

<table align="center">
    <tr>
        <td>
            Username:
        </td>
        <td>
            <input type="text" name="username" id="user">
        </td>
    </tr>
    <tr>
        <td>
            Current Password:
        </td>
        <td>
            <input type="password" name="current_pw" id="password">
        </td>
    </tr>
    <tr>
        <td>
            New Password:
        </td>
        <td>
            <input type="password" name="new_pw" id="new">
        </td>
    </tr>
    <tr>
        <td>
            Confirm New Password:
        </td>
        <td>
            <input type="password" name="new_pw_2" id="confirm">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" value="Submit" onclick="
                   $.post(
                       '/ajax/change_password.php',
                       {
                           username: document.getElementById('user').value,
                           current_pw: document.getElementById('password').value,
                           new_pw: document.getElementById('new').value,
                           new_pw_2: document.getElementById('confirm').value
                       },
                       function (response){
                           document.getElementById('show_response').innerHTML = response;
                       }
                );
           ">
        </td>
    </tr>
</table>
          <!--  </form>-->
          <div id="show_response"></div>
<?php include "footer.php" ?>
