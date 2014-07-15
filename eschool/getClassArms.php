<?php
if(!isset($_SESSION))session_start();
include("includes/connections.php");
//include('../../library/functions.php');
$id=$_GET['id'];
$cod=@$_GET['cod'];
$sql="SELECT * FROM classarmsview WHERE class_id = '$id' ";
$result=mysql_query($sql);
if(mysql_num_rows($result)<1)
		{
			echo "<option value=''>".mysql_error()."No Arms available</option>";	
		}else
		{
			echo "<option value=''>Select Arms</option>";
			while ($val=mysql_fetch_array($result))
			{
				echo "<option value='".$val['arm_id']."'";
				//if($val['lga_id']==$cod){echo "selected='selected'";}
				echo "> ".$val['arm_name']." </option> ";	
			}
		}

?>