<?php
if(!isset($_SESSION))session_start();
include("includes/connections.php");
	//include('../../library/functions.php');
	$country=$_GET['country'];
	$cod=$_GET['cod'];
	if (strtolower($country)=='')
	{
		echo "<option value=''>Select country first</option>";
	}else
	{
		$sql="SELECT * FROM city WHERE CountryCode = '$country' ORDER BY Name ASC";
		$result=mysql_query($sql);
		if(mysql_num_rows($result)<1)
		{
			echo "<option value=''>".mysql_error()." No state available</option>";	
		}else
		{
			echo "<option value=''>Select</option>";
			while ($val=mysql_fetch_array($result))
			{
				echo "<option value='".$val['ID']."'";
				if($val['ID']==$cod){echo "selected='selected'";}
				
			echo 	"> ".$val['Name']." </option> ";	
			}
		}

	}
?>