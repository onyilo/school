<?php 
	
	$id = @$_REQUEST["id"];
	$class_id = @$_REQUEST["class_id"];
	$arm_id = @$_REQUEST["arm_id"];
	$userID = @GetEmpID();
	$action = @$_REQUEST["submit"];
	
	$msg="";
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from Class_Arms where id = $id";
		$rs = mysql_query($sql);
		$class_id = mysql_result($rs, 0, "class_id");	
		$arm_id = mysql_result($rs, 0, "arm_id");
	}
	
	if($class_id=="" and $action !="")
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Class must be selected</font>";
	}
	elseif($arm_id=="" and $action !="")
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Arm must be selected</font>";
	}elseif ($action !=""){
	
		$sql = "Select * from classarmsview where class_id='$class_id' and arm_id='$arm_id'";
		$rs = mysql_query($sql);
		if (mysql_num_rows($rs)>0 and $action!="Delete")
		{
			$record = mysql_fetch_assoc($rs);
			$msg="<font color='#ff0000' style='font-size:14px;'>". $record["class_name"]."  already has this arm assigned to it.</font>";
			$id = 0;
			$arm_id ="";
			$class_id = "";
			$action ="";
		}
		elseif($action == "Add")
		{
			$sql = "Insert into Class_arms(class_id,arm_id, posted_by) values('$class_id','$arm_id','$userID')";
			mysql_query($sql);
			$msg="<font color='#005500' style='font-size:14px;'>Record Inserted Succesfully</font>";
		}
		elseif($action == "Update")
		{
			$sql = "Update Class_arms Set class_id='$class_id', arm_id='$arm_id', last_modify_by='$userID',last_modify_date=Current_Timestamp() where id = $id";
			mysql_query($sql);
			$id = 0;
			$arm_id ="";
			$class_id = "";
			$action ="";
			$msg="<font color='#005500' style='font-size:14px;'>Record Updated Successfully</font>";
		}
		elseif($action == "Delete")
		{
			$sql = "Delete from Class_arms where id= $id";
			mysql_query($sql);
			$id = 0;
			$arm_id ="";
			$class_id = "";
			$action ="";
			$msg="<font color='#005500' style='font-size:14px;'>Record Deleted Successfully</font>";
		}
	}
	
?>
<script type="text/javascript">
function validate(){
//Validate Required Value @39-6B39FE68
        if(document.getElementById("class_id").value == "")
		{
				alert("Select Class");
                document.getElementById("class_id").focus();
                return false;
        }
		 if(document.getElementById("arm_id").value == "")
		{
				alert("Select Arm");
                document.getElementById("arm_id").focus();
                return false;
        }
</script>
<form action="" onSubmit="return validate();" method="post">
<table class="detail-table" style="margin:auto;">
<tr>
    	<td colspan="2" style="text-align:center;"><?php echo $msg; ?></td>
     </tr> 
     <tr>
	  <tr>
		<td>Class</td>
        <td><?php echo GenerateListBox("Select class_id, class_name from classes", "$class_id","class_id","","Select Class"); ?></td>
     </tr> 
	<tr>
	  <tr>
		<td>Arm</td>
        <td><?php echo GenerateListBox("Select arm_id, arm_name from arms", "$arm_id","arm_id","","Select Arm"); ?></td>
     </tr>  
    <td colspan="2"  style="text-align:right">
		<?php if($id>0) { ?>
        	<input type="submit" name ="submit" id = "submit" value ="Update" class="art-button" />
        	<input type="submit" name ="submit" id = "submit" value ="Delete" class="art-button" />
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
        <th>Class Name</th>
        <th>Arm Name</th>
       
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from classarmsview";
		$rs = mysql_query($sql);
		$count=0;
		while($row = mysql_fetch_assoc($rs))
		{
			$styl=($count%2==0)?" class='trodd' ":'';
				echo "<tr $styl>";
			echo "<td>".(++$count)."</td>";
			echo "<td>".$row["class_name"]."</td>";
			echo "<td>".$row["arm_name"]."</td>";
			echo "<td><a href='home.php?page=classarmconfig&id=".$row["id"]."'>Edit</a></td>";
			echo "</tr>";
			
		}
	?>
</table>


</body> 
</html> 