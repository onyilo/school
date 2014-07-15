<?php 
	
	$id = @$_REQUEST["id"];
	$class_name = @$_REQUEST["class_name"];
	$class_abbr = @$_REQUEST["class_abbr"];
	$section_id = @$_REQUEST["section_id"];
	$activeID = @$_REQUEST["activeID"];
	$userID = @GetEmpID();
	$action = @$_REQUEST["submit"];
	
	$msg="";
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from Classes where class_id = $id";
		$rs = mysql_query($sql);
		$class_name = mysql_result($rs, 0, "class_name");	
		$activeID = mysql_result($rs, 0, "activeID");
		$class_abbr = mysql_result($rs, 0, "class_abbr");
		$section_id = mysql_result($rs, 0, "section_id");
	}
	
	if($class_name=="" and $action !="")
	{
		$msg="<font color='#550000' style='font-size:14px;'>Class Name cannot be empty</font>";
	}
	elseif($class_abbr=="" and $action !="")
	{
		$msg="<font color='#550000' style='font-size:14px;'>Class Short Name cannot be empty</font>";
	}
	elseif($section_id=="" and $action !="")
	{
		$msg="<font color='#550000' style='font-size:14px;'>Section must be selected</font>";
	}
	elseif($activeID=="" and $action !="")
	{
		$msg="<font color='#550000' style='font-size:14px;'>Status must be selected</font>";
	}
	else{
		
		if($action == "Add")
		{
			$sql = "Insert into Classes(class_name,class_abbr,section_id,activeID, posted_by) values('$class_name','$class_abbr','$section_id','$activeID','$userID')";
			mysql_query($sql);
			$msg="<font color='#005500' style='font-size:14px;'>Record Inserted Succesfully</font>";
		}
		elseif($action == "Update")
		{
			$sql = "Update Classes Set class_Name='$class_name', ActiveID='$activeID', section_id='$section_id', class_abbr='$class_abbr', last_modify_by='$userID',last_modify_date=Current_Timestamp() where class_id = $id";
			mysql_query($sql);
			$id = 0;
			$class_name ="";
			$activeID="";
			$class_abbr = "";
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
    	<td>Class Name</td>
        <td><input name ="class_name" id="class_name" value ="<?php echo $class_name; ?>"/></td>
     </tr> 
	<tr>
	<tr>
    	<td>Short Name</td>
        <td><input name ="class_abbr" id="class_abbr" value ="<?php echo $class_abbr; ?>"/></td>
     </tr> 
	<tr>
	  <tr>
		<td>Section</td>
        <td><?php echo GenerateListBox("Select section_id, section_name from sections where activeid=1", "$section_id","section_id","","Select Section"); ?></td>
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
        <th>Class Name</th>
        <th>Short Name</th>
        <th>Section</th>
        <th>Status</th>
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from ClassViews";
		$rs = mysql_query($sql);
		$count=0;
		while($row = mysql_fetch_assoc($rs))
		{
			$styl=($count%2==0)?" class='trodd' ":'';
				echo "<tr $styl>";
			echo "<td>".(++$count)."</td>";
			echo "<td>".$row["class_name"]."</td>";
			echo "<td>".$row["class_abbr"]."</td>";
			echo "<td>".$row["section_name"]."</td>";
			echo "<td>".($row["ActiveID"]==1?"Active":"In-Active")."</td>";
			echo "<td><a href='home.php?page=classes&id=".$row["class_id"]."'>Edit</a></td>";
			echo "</tr>";
			
		}
	?>
</table>


</body> 
</html> 