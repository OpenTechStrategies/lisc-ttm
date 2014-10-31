<?php
require_once("../siteconfig.php");
?>
<?php

/*make a new campaign */
    include "../include/dbconnopen.php";
    $name_sqlsafe=mysqli_real_escape_string($cnnEnlace, $_POST['name']);
    $make_campaign="INSERT INTO Campaigns (
                Campaign_Name) VALUES(
                '" . $name_sqlsafe ."')";
    //echo $make_campaign;
    mysqli_query($cnnEnlace, $make_campaign);
    $id= mysqli_insert_id($cnnEnlace);
    include "../include/dbconnclose.php";



?>
<!--Once a new campaign has been added, it needs events.  Make those here: -->
                                              
<span class="helptext">Dates must be entered in the format YYYY-MM-DD.</span>                                              
Name: <input type="text" id="event" ><br>
<input type="button" value="Add Event" onclick="
                $.post(
                '../ajax/add_event.php',
                {
                    campaign_id: '<?echo $id;?>',
                    date: document.getElementById('first_program_date').value,
                    event_name: document.getElementById('event').value
                },
                function (response){
                    //alert('response');
                    document.getElementById('show_ok').innerHTML += 'Thank you for adding '+document.getElementById('event').value + ' <br>';
                    document.getElementById('first_campaign_date').value = '';
                    document.getElementById('first_campaign_date').focus();
                }
            );"><br/>
<div id="show_ok"></div>
<br/><br/>

<!--Link to campaign profile.-->
Or, <a href="javascript:;" onclick="
                                                  $.post(
                                                    '../ajax/set_campaign_id.php',
                                                    {
                                                        id: '<?echo $id;?>',
                                                        page: 'search'
                                                    },
                                                    function (response){
                                                        if (response!='1'){
                                                            document.getElementById('show_error').innerHTML = response;
                                                        }
                                                        window.location='campaign_profile.php';
                                                    }
                                              )">go to campaign profile</a>.<br/><br/>