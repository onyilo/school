<?php 
	
	$id = @$_REQUEST["id"];
	$grade = @trim($_REQUEST["grade"]);
	$gradeTypeID = @trim($_REQUEST["gradeTypeID"]);
	$Remark = @trim($_REQUEST["Remark"]);
	$score_to = @trim($_REQUEST["score_to"]);
	$score_from = @trim($_REQUEST["score_from"]);
	
	$action = @$_REQUEST["submit"];
	$userid = @GetEmpID();
	$msg="";
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from Grades where grade_id = $id";
		$rs = mysql_query($sql);
		$gradeTypeID = mysql_result($rs, 0, "gradeTypeID");	
		$grade = mysql_result($rs, 0, "grade");	
		$Remark = mysql_result($rs, 0, "Remark");	
		$score_to = mysql_result($rs, 0, "score_to");	
		$score_from = mysql_result($rs, 0, "score_from");	
		
	}
	
	if($grade=="" and $action !="" )
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Grade cannot be empty</font>";
	}
	if($gradeTypeID=="" and $action !="" )
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Grade Type must be selected</font>";
	}
	if($Remark=="" and $action !="" )
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Remark cannot be empty</font>";
	}
	if($score_from=="" and $action !="" )
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Lower Score Limit cannot be empty</font>";
	}
	if($score_from=="" and $action !="" )
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Upper Score Limit cannot be empty</font>";
	}
	elseif ($action!="")
		{
			/*$sql = "Select * from Grades where gradeTypeID='$gradeType'" ;
			$rs = mysql_query($sql) or die(mysql_error());
			if (mysql_num_rows($rs)>0 and $action!="Delete")
			{
				$record = mysql_fetch_assoc($rs);
				$msg="<font color='#ff0000' style='font-size:14px;'>". $record["gradeType"]." has been added already.</font>";
				$gradeType="";
				$action ="";
				$id = 0;
			}
			else*/if($action == "Add"){
				$sql = "Insert into Grades(grade,gradeTypeID, remark, score_from, score_to) values('$grade','$gradeTypeID','$Remark', '$score_from', '$score_to')";
				mysql_query($sql) or die(mysql_error());
				$msg="<font color='#005500' style='font-size:14px;'>Record inserted successfully</font>";
				
			}elseif($action == "Update")
			{
				$sql = "Update Grades Set grade='$grade',gradeTypeID='$gradeTypeID', remark='$Remark', score_from='$score_from', score_to='$score_to' where grade_id = $id";
				mysql_query($sql);
				$id = 0;
				$gradeTypeID = "";	
				$grade = "";	
				$Remark = "";	
				$score_to = "";	
				$score_from = "";
				$action ="";
				$msg="<font color='#005500' style='font-size:14px;'>Record updated succesfully</font>";
				}
	}
	
?>
<script type="text/javascript">
function validate(){
//Validate Required Value @39-6B39FE68
		if(document.getElementById("grade").value == "")
		{
				alert("Enter Grade");
                document.getElementById("grade").focus();
                return false;
        }
        if(document.getElementById("gradeTypeID").value == "")
		{
				alert("Select Grade Type");
                document.getElementById("gradeTypeID").focus();
                return false;
        }
		if(document.getElementById("Remark").value == "")
		{
				alert("Enter Remark");
                document.getElementById("Remark").focus();
                return false;
        }
		
		if(document.getElementById("score_from").value == "")
		{
				alert("Enter Lower Score Limit");
                document.getElementById("score_from").focus();
                return false;
        }
		if(document.getElementById("score_to").value == "")
		{
				alert("Enter Upper Score Limit");
                document.getElementById("score_to").focus();
                return false;
        }
}
</script>
<form action="" onSubmit="return validate();" method="post">
<table class="detail-table" style="margin:auto;">
<tr>
    	<td colspan="4" style="text-align:center;"><?php echo $msg; ?></td>
        
     </tr> 
     <tr>
    	<td>Name</td>
        <td><input name ="grade" id="grade" value ="<?php echo $grade; ?>"/></td>
		<td>Grade Type</td>
        <td>
			<?php echo GenerateListBox("Select gradeTypeID, gradeType from gradeTypes", "$gradeTypeID","gradeTypeID","","Select Grade Type"); ?>
		</td>
	 </tr>
	 <tr>	
    	<td>Remark</td>
        <td colspan="3"><input name ="Remark" id="Remark" value ="<?php echo $Remark; ?>"/></td>
     </tr>
	 <tr>
    	<td>Lower Score Limit</td>
        <td><input name ="score_from" id="score_from" value ="<?php echo $score_from; ?>"/></td>
		<td>Upper Score Limit</td>
        <td><input name ="score_to" id="score_to" value ="<?php echo $score_to; ?>"/></td>
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
        <th>Grade </th>
        <th>Grade Type</th>
        <th>Remark</th>
        <th>Lower Limit</th>
        <th>Upper Limit</th>
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from gradeviews";
		$rs = mysql_query($sql);
		$count=0;
		while($row = mysql_fetch_assoc($rs))
		{
			$styl=($count%2==0)?" class='trodd' ":'';
				echo "<tr $styl>";
			echo "<td>".(++$count)."</td>";
			echo "<td>".$row["grade"]."</td>";
			echo "<td>".$row["gradeType"]."</td>";
			echo "<td>".$row["remark"]."</td>";
			echo "<td>".$row["score_from"]."</td>";
			echo "<td>".$row["score_to"]."</td>";
			
			echo "<td><a href='home.php?page=grades&id=".$row["grade_id"]."'>Edit</a></td>";
			echo "</tr>";
		}
	?>
</table>


</body> 
</html> 