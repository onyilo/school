<?php 
	
	$id = @$_REQUEST["id"];
	$arm_name = @$_REQUEST["arm_name"];
	$action = @$_REQUEST["submit"];
	$userid = @GetEmpID();
	$msg="";
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from arms where arm_id = $id";
		$rs = mysql_query($sql);
		$arm_name = mysql_result($rs, 0, "arm_name");	
	}
	
	if($arm_name=="" and $action !="" )
	{
		$msg="<font color='#550000' style='font-size:14px;'>Arms name cannot be empty</font>";
	}else{
		
		if($action == "Add")
		{
			$sql = "Insert into Arms(arm_name,posted_by) values('$arm_name','$userid')";
			mysql_query($sql);
			$msg="<font color='#005500' style='font-size:14px;'>Record inserted succesfully</font>";
		}
		elseif($action == "Update")
		{
			$sql = "Update arms Set Arm_Name='$arm_name', last_modify_by='$userid', last_modify_date=current_timestamp()  where arm_id = $id";
			mysql_query($sql);
			$id = 0;
			$arm_name ="";
			$action ="";
			$msg="<font color='#005500' style='font-size:14px;'>Record updated succesfully</font>";
		}
	}
	
?>
<script type="text/javascript">
function validate(){
//Validate Required Value @39-6B39FE68
        if(document.getElementById("arm_name").value == "")
		{
				alert("Enter Arm Name");
                document.getElementById("arm_name").focus();
                return false;
        }
}
</script>
<form action="" onSubmit="return validate();" method="post">
<table class="detail-table" style="margin:auto;">
<tr>
    	<td colspan="2" style="text-align:center;"><?php echo $msg; ?></td>
        
     </tr> 
     <tr>
    	<td>Name</td>
        <td><input name ="arm_name" id="arm_name" value ="<?php echo $arm_name; ?>"/></td>
     </tr> 
	<tr>
    <td colspan="2"  style="text-align:center">
		<?php if($id>0) { ?>
        	<input type="submit" name ="submit" id = "submit" value ="Update" class="art-button" />
		<?php } 
		else { 
		?>
        	<input type="hidden" name ="id" id = "id" value ="<?php echo $id; ?>" />
            <input type="submit" name ="submit" id = "submit" value ="Add" class="art-button" />
         
	<?php } ?>
        </td>
	</tr> 
</table> 
</form>
<table class="mytable" style=" margin:auto;border-collapse:collapse">
	<tr>
    	<th>S/No</th>
        <th>Arm Name</th>
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from arms";
		$rs = mysql_query($sql);
		$count=0;
		while($row = mysql_fetch_assoc($rs))
		{
			$styl=($count%2==0)?" class='trodd' ":'';
				echo "<tr $styl>";
			echo "<td>".(++$count)."</td>";
			echo "<td>".$row["arm_name"]."</td>";
			echo "<td><a href='home.php?page=arms&id=".$row["arm_id"]."'>Edit</a></td>";
			echo "</tr>";
			
		}
	?>
</table>


</body> 
</html> 