<? 
include "../../header.php";
	include "../header.php";
       //print_r($_COOKIE);
?>

<!--Obsolete.  Never used the category profile.-->

<script type="text/javascript">
        $(document).ready(function() {
                $('#ajax_loader').hide();
            });
            
            $(document).ajaxStart(function() {
                $('#ajax_loader').fadeIn('slow');
            });
            
            $(document).ajaxStop(function() {
                $('#ajax_loader').fadeOut('slow');
            });
</script>

<h3>Category Profile</h3>
<span align="left">
<?
include "../include/dbconnopen.php";
$category_sqlsafe=mysqli_real_escape_string($cnnLSNA, $_COOKIE['category']);
$get_related_subcategories = "SELECT * FROM Categories INNER JOIN (Category_Subcategory_Links, Subcategories) ON
    Categories.Category_ID=Category_Subcategory_Links.Category_ID AND 
    Category_Subcategory_Links.Subcategory_ID=Subcategories.Subcategory_ID
    WHERE Category_Subcategory_Links.Category_ID='" . $category_sqlsafe . "'";
$related_subcategories = mysqli_query($cnnLSNA, $get_related_subcategories);
$category=0;
while ($sub = mysqli_fetch_array($related_subcategories)){
        if ($category != $sub['Category_ID']){
            $category = $sub['Category_ID'];?>
<h4><?echo $sub['Category_Name'];?></h4>
                <?
        }
        ?><a href="javascript:;" onclick="
                                                  $.post(
                                                    '../ajax/set_program_id.php',
                                                    {
                                                        id: '<?echo $sub['Subcategory_ID'];?>'
                                                    },
                                                    function (response){
                                                        //alert(response);
                                                        if (response!='1'){
                                                            document.getElementById('show_error').innerHTML = response;
                                                        }
                                                        window.location='programs.php';
                                                    }
                                              )"><?echo $sub['Subcategory_Name'] . "<br>";?></a><?
}
include "../include/dbconnclose.php";
?>
</span>
<span align="right">
    <?
    //get the total number of people involved in this category of work
    $count_participants = "SELECT * FROM Categories INNER JOIN (Category_Subcategory_Links, Subcategories, Participants_Subcategories) ON
                        Categories.Category_ID=Category_Subcategory_Links.Category_ID AND 
                        Category_Subcategory_Links.Subcategory_ID=Subcategories.Subcategory_ID
                        AND Subcategories.Subcategory_ID=Participants_Subcategories.Subcategory_ID
                        WHERE Category_Subcategory_Links.Category_ID='" . $category_sqlsafe . "' GROUP BY Participant_ID";
    include "../include/dbconnopen.php";
    $count = mysqli_query($cnnLSNA, $count_participants);
    $num = mysqli_num_rows($count);
    echo "Total number of unique participants in these programs: " . $num;
    include "../include/dbconnclose.php";
    ?>
</span>