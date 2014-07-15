<?php
if(!isset($_SESSION))session_start();
include("includes/connections.php");
//include('../../library/functions.php');
$id=$_GET['id'];
$aid=$_GET['aid'];
$cod=@$_GET['cod'];
$sql="SELECT * FROM classsubjectViews WHERE class_id = '$id' and arm_id = '$aid'";
$result=mysql_query($sql);
if(mysql_num_rows($result)<1)
		{
			echo "<option value=''>".mysql_error()."No Subject Assigned</option>";	
		}else
		{
			echo "<option value=''>Select Subject</option>";
			while ($val=mysql_fetch_array($result))
			{
				echo "<option value='".$val['subject_id']."'";
				//if($val['lga_id']==$cod){echo "selected='selected'";}
				echo "> ".$val['subject_name']." </option> ";	
			}
		}

?>