<?php
if(!isset($_SESSION))session_start();
include("includes/connections.php");
//include('../../library/functions.php');
$state=$_GET['state'];
$cod=$_GET['cod'];
if (strtolower($state)=='')
	{
		echo "<option value='select'>Select state first</option>";
	}else
	{
$sql="SELECT * FROM lga WHERE state_id = '$state' ORDER BY local_govt ASC";
$result=mysql_query($sql);
if(mysql_num_rows($result)<1)
		{
			echo "<option value='Nil'>".mysql_error()."No LGA available</option>";	
		}else
		{
			echo "<option value=''>Select</option>";
			while ($val=mysql_fetch_array($result))
			{
				echo "<option value='".$val['lga_id']."'";
				if($val['lga_id']==$cod){echo "selected='selected'";}
				echo "> ".$val['local_govt']." </option> ";	
			}
		}

	}
?>
