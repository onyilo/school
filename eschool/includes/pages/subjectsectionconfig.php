<?php 
	
	$id = @$_REQUEST["id"];
	$subject_id = @$_REQUEST["subject_id"];
	$section_id = @$_REQUEST["section_id"];
	$userID = @GetEmpID();
	$action = @$_REQUEST["submit"];
	
	$msg="";
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from subjectsectiondetails where id = $id";
		$rs = mysql_query($sql);
		$subject_id = mysql_result($rs, 0, "subject_id");	
		$section_id = mysql_result($rs, 0, "section_id");
	}
	
	if($subject_id=="" and $action !="")
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Subject must be selected</font>";
	}
	elseif($section_id=="" and $action !="")
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Section must be selected</font>";
	}
	
	elseif ($action !=""){
	
		$sql = "Select * from subjectSectionViews where subject_id='$subject_id' and section_id='$section_id'";
		$rs = mysql_query($sql);
		if (mysql_num_rows($rs)>0 and $action!="Delete")
		{
			$record = mysql_fetch_assoc($rs);
			$msg="<font color='#ff0000' style='font-size:14px;'>". $record["section_name"]." Section already has ".$record["subject_name"]." assigned to it.</font>";
			$id = 0;
			$section_id ="";
			$subject_id = "";
			$action ="";
		}
		elseif($action == "Add")
		{
			$sql = "Insert into subjectsectiondetails(subject_id,section_id, posted_by) values('$subject_id','$section_id','$userID')";
			mysql_query($sql);
			$msg="<font color='#005500' style='font-size:14px;'>Record Inserted Successfully</font>";
		}
		elseif($action == "Update")
		{
			$sql = "Update subjectsectiondetails Set subject_id='$subject_id', section_id='$section_id', last_modify_by='$userID',last_modify_date=Current_Timestamp() where id = $id";
			mysql_query($sql);
			$id = 0;
			$section_id ="";
			$subject_id = "";
			$action ="";
			$msg="<font color='#005500' style='font-size:14px;'>Record Updated Successfully</font>";
		}
		elseif($action == "Delete")
		{
			$sql = "Delete from subjectsectiondetails where id= $id";
			mysql_query($sql);
			$id = 0;
			$section_id ="";
			$subject_id = "";
			$action ="";
			$msg="<font color='#005500' style='font-size:14px;'>Record Deleted Successfully</font>";
		}
	}
	
?>
<script type="text/javascript">
function validate(){
//Validate Required Value @39-6B39FE68
        if(document.getElementById("subject_id").value == "")
		{
				alert("Select Subject");
                document.getElementById("subject_id").focus();
                return false;
        }
		 if(document.getElementById("section_id").value == "")
		{
				alert("Select Section");
                document.getElementById("section_id").focus();
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
		<td>Subject</td>
        <td><?php echo GenerateListBox("Select subject_id, subject_name from subjects where activeID=1", "$subject_id","subject_id","","Select Subject"); ?></td>
     </tr> 
	<tr>
	  <tr>
		<td>Section</td>
        <td><?php echo GenerateListBox("Select section_id, section_name from sections where activeID=1", "$section_id","section_id","","Select Section"); ?></td>
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
        <th>Subject Name</th>
        <th>Section Name</th>
       
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from subjectSectionViews ";
		$rs = mysql_query($sql);
		$count=0;
		while($row = mysql_fetch_assoc($rs))
		{
			$styl=($count%2==0)?" class='trodd' ":'';
				echo "<tr $styl>";
			echo "<td>".(++$count)."</td>";
			echo "<td>".$row["subject_name"]."</td>";
			echo "<td>".$row["section_name"]."</td>";
			echo "<td><a href='home.php?page=subjectsectionconfig&id=".$row["id"]."'>Edit</a></td>";
			echo "</tr>";
			
		}
	?>
</table>


</body> 
</html> 