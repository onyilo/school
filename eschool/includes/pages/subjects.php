<?php 
	
	$id = @$_REQUEST["id"];
	$subject_name = @trim($_REQUEST["subject_name"]);
	$activeID = @$_REQUEST["activeID"];
	$action = @$_REQUEST["submit"];
	$userid = @GetEmpID();
	$msg="";
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from subjects where subject_id = $id";
		$rs = mysql_query($sql);
		$subject_name = mysql_result($rs, 0, "subject_name");	
		$activeID = mysql_result($rs, 0, "activeID");	
	}
	
	if($subject_name=="" and $action !="" )
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Subject Name cannot be empty</font>";
	}elseif ($action!="")
		{
			$sql = "Select * from subjects where subject_name='$subject_name'" ;
			$rs = mysql_query($sql) or die(mysql_error());
			if (mysql_num_rows($rs)>0 and $action!="Update")
			{
				$record = mysql_fetch_assoc($rs);
				$msg="<font color='#ff0000' style='font-size:14px;'>". $record["subject_name"]." has been added already.</font>";
				$subject_name="";
				$action ="";
				$id = 0;
			}
			elseif($action == "Add"){
				$sql = "Insert into subjects(subject_name,posted_by,activeID) values('$subject_name','$userid','$activeID')";
				mysql_query($sql) or die(mysql_error());
				$msg="<font color='#005500' style='font-size:14px;'>Record inserted successfully</font>";
			}elseif($action == "Update")
			{
				$sql = "Update subjects Set subject_name='$subject_name',activeID='$activeID', last_modify_by='$userid', last_modify_date=current_timestamp()  where subject_id = $id";
				mysql_query($sql);
				$id = 0;
				$subject_name ="";
				$action ="";
				$msg="<font color='#005500' style='font-size:14px;'>Record updated succesfully</font>";
				}
	}
	
?>
<script type="text/javascript">
function validate(){
//Validate Required Value @39-6B39FE68
        if(document.getElementById("subject_name").value == "")
		{
				alert("Enter Subject Name");
                document.getElementById("subject_name").focus();
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
    	<td>Subject Name</td>
        <td><input name ="subject_name" id="subject_name" value ="<?php echo $subject_name; ?>"/></td>
     </tr> 
	 <tr>
		<td>Status</td>
        <td>
			<input type="radio" name ="activeID" id="activeID1" value ="1" <?php if ($activeID =="" || $activeID==1) echo "checked"; ?>/> Active 
			<input type="radio" name ="activeID" id="activeID2" value ="2" <?php if ($activeID==2) echo "checked"; ?>/>In-Active 
		</td>
  
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
        <th>Subject Name</th>
        <th>Status</th>
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from subjects";
		$rs = mysql_query($sql);
		$count=0;
		while($row = mysql_fetch_assoc($rs))
		{
			$styl=($count%2==0)?" class='trodd' ":'';
				echo "<tr $styl>";
			echo "<td>".(++$count)."</td>";
			echo "<td>".$row["subject_name"]."</td>";
			echo "<td>".($row["activeID"]==1?"Active":"In-Active")."</td>";
			echo "<td><a href='home.php?page=subjects&id=".$row["subject_id"]."'>Edit</a></td>";
			echo "</tr>";
			
		}
	?>
</table>


</body> 
</html> 