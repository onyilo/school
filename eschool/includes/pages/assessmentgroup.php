<?php 
	
	$id = @$_REQUEST["id"];
	$score = @trim($_REQUEST["score"]);
	$assessment_group_name = @trim($_REQUEST["assessment_group_name"]);
	$section_id = @$_REQUEST["section_id"];
	$activeID = @$_REQUEST["activeID"];
	$userID = @GetEmpID();
	$action = @$_REQUEST["submit"];
	$c_session_id=getCurrentSession();
	
	$msg="";
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from assessmentgroup where assessgroupID = $id and c_session_id=$c_session_id";
		$rs = mysql_query($sql);
		$assessment_group_name = mysql_result($rs, 0, "assessment_group_name");	
		$score = mysql_result($rs, 0, "score");
		$session_id = mysql_result($rs, 0, "session_id");
		$activeID = mysql_result($rs, 0, "activeID");
	}
	
	if($section_id=="" and $action !="")
	{
		$msg="<font color='#550000' style='font-size:14px;'>Please select section</font>";
	}
	elseif($assessment_group_name=="" and $action !="")
	{
		$msg="<font color='#550000' style='font-size:14px;'>Assessment group name cannot be empty</font>";
	}
	elseif(!is_numeric($score) and $score<1 and $action !="")
	{
		$msg="<font color='#550000' style='font-size:14px;'>Please enter a valid score</font>";
	}
	elseif($activeID=="" and $action !="")
	{
		$msg="<font color='#550000' style='font-size:14px;'>Status must be selected</font>";
	}
	else{
		
		if($action == "Add")
		{
			$sql = "Insert into assessmentgroup(AssessGroupName,score,section_id,activeID, posted_by) values('$assessment_group_name','$score','$section_id','$activeID','$userID')";
			mysql_query($sql);
			$msg="<font color='#005500' style='font-size:14px;'>Record Inserted Succesfully</font>";
		}
		elseif($action == "Update")
		{
			$sql = "Update assessmentgroup Set AssessGroupName='$assessment_group_name', ActiveID='$activeID', section_id='$section_id', score='$score', last_modify_by='$userID' where assessgroupID = $id";
			mysql_query($sql);
			$id = 0;
			$assessment_group_name ="";
			$activeID="";
			$score = "";
			$section_id = "";
			$action ="";
			$msg="<font color='#005500' style='font-size:14px;'>Record Updated Successfully</font>";
		}
	}
	
?>
<script type="text/javascript">
function validate(){
//Validate Required Value @39-6B39FE68
        if(document.getElementById("class_name").value == "")
		{
				alert("Enter Class Name");
                document.getElementById("class_name").focus();
                return false;
        }
		 if(document.getElementById("class_abbr").value == "")
		{
				alert("Enter class Short Name");
                document.getElementById("class_abbr").focus();
                return false;
        }
		 if(document.getElementById("section_id").value == "")
		{
				alert("Select Section");
                document.getElementById("section_id").focus();
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
    	<td>Section:</td>
        <td><?php echo GenerateListBox("Select section_id, section_name  from sections where activeID=1", "$section_id","section_id","","Select Section"); ?></td>
     </tr> 
	<tr>
	<tr>
    	<td>Assessment Name:</td>
        <td><input name ="assessment_group_name" id="assessment_group_name" value ="<?php echo $assessment_group_name; ?>"/></td>
     </tr> 
	<tr>
	  <tr>
		<td>Score</td>
        <td><input name ="score" id="score" value ="<?php echo $score; ?>"/></td>
     </tr> 
	<tr>
		<td>Status</td>
        <td>
			<input type="radio" name ="activeID" id="activeID1" value ="1" <?php if ($activeID =="" || $activeID==1) echo "checked"; ?>/> Active 
			<input type="radio" name ="activeID" id="activeID2" value ="2" <?php if ($activeID==2) echo "checked"; ?>/>In-Active 
		</td>
    	<td></td>
        <td></td>
     </tr> 
    <td colspan="2"  style="text-align:right">
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
<table class="mytable" style="margin:auto;border-collapse:collapse">
	<tr>
    	<th>S/No</th>
        <th>Section Name</th>
        <th>Assessment Name</th>
        <th>Score</th>
        <th>Status</th>
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from assessmentgroup where activeID=1 group by section_id order by section_id,AssessGroupName";
		$rs = mysql_query($sql);
		$count=0;
		$flag='';
		
		while($row = mysql_fetch_assoc($rs))
		{
			$styl=($count%2==0)?" class='trodd' ":'';
				echo "<tr $styl>";
			echo "<td>".(++$count)."</td>";
			echo "<td>".$row["AssessGroupName"]."</td>";
			echo "<td>".$row["AssessGroupName"]."</td>";
			echo "<td>".$row["section_name"]."</td>";
			echo "<td>".($row["ActiveID"]==1?"Active":"In-Active")."</td>";
			echo "<td><a href='home.php?page=classes&id=".$row["class_id"]."'>Edit</a></td>";
			echo "</tr>";
			
		}
	?>
</table>


</body> 
</html> 