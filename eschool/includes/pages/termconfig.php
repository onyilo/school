<?php 
	
	$id = @$_REQUEST["id"];
	$session_id = @$_REQUEST["session_id"];
	$term_id = @$_REQUEST["term_id"];
	$activeID = @$_REQUEST["activeID"];
	$date_from = @$_REQUEST["date_from"];
	$date_to = @$_REQUEST["date_to"];
	$userID = @GetEmpID();
	$action = @$_REQUEST["submit"];
	
	$msg="";
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from c_session where c_session_id = $id";
		$rs = mysql_query($sql);
		$session_id = mysql_result($rs, 0, "session_id");	
		$term_id = mysql_result($rs, 0, "term_id");
		$activeID = mysql_result($rs, 0, "isActive");
		$date_from = mysql_result($rs, 0, "date_from");
		$date_to = mysql_result($rs, 0, "date_to");
	}
	
	if($session_id=="" and $action !="")
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Session must be selected</font>";
	}
	elseif($term_id=="" and $action !="")
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Term must be selected</font>";
	}
	
	elseif ($action !=""){
	
		$sql = "Select * from CurrrentSessionView where session_id='$session_id' and term_id='$term_id'";
		$rs = mysql_query($sql);
		if (mysql_num_rows($rs)>0 and $action!="Delete" and $id<>mysql_result($rs,0,"c_session_id"))
		{
			$record = mysql_fetch_assoc($rs);
			$msg="<font color='#ff0000' style='font-size:14px;'>". $record["session_name"]." Section already has ".$record["term_name"]." assigned to it.</font>";
			$id = 0;
			$term_id ="";
			$session_id = "";
			$date_from = "";
			$date_to = "";
			$activeID = "";
			$action ="";
		}
		elseif($action == "Add")
		{
			UpdateStatus($activeID);
			$sql = "Insert into c_session(session_id,term_id, posted_by, isActive, date_from, date_to) values('$session_id','$term_id','$userID', '$activeID','$date_from', '$date_to')";
			mysql_query($sql);
			$msg="<font color='#005500' style='font-size:14px;'>Record Inserted Successfully</font>";
		}
		elseif($action == "Update")
		{
			UpdateStatus($activeID);
			$sql = "Update c_session Set session_id='$session_id', term_id='$term_id', date_from='$date_from', date_to='$date_to', isActive='$activeID', last_modify_by='$userID',last_modify_date=Current_Timestamp() where c_session_id = $id";
			mysql_query($sql);
			$id = 0;
			$term_id ="";
			$session_id = "";
			$date_from = "";
			$date_to = "";
			$activeID = "";
			$action ="";
			$msg="<font color='#005500' style='font-size:14px;'>Record Updated Successfully</font>";
		}/*
		elseif($action == "Delete")
		{
			$sql = "Delete from c_session where id= $id";
			mysql_query($sql);
			$id = 0;
			$term_id ="";
			$session_id = "";
			$action ="";
			$msg="<font color='#005500' style='font-size:14px;'>Record Deleted Successfully</font>";
		}*/
	}
	
	function UpdateStatus($activeID)
	{
		if($activeID ==1 )	
		{
			$sql = "Update c_session Set isActive='2' where isActive = 1";
			mysql_query($sql) or die(mysql_error());
		}
	}
	
?>
<script type="text/javascript">
function validate(){
//Validate Required Value @39-6B39FE68
        if(document.getElementById("session_id").value == "")
		{
				alert("Select Subject");
                document.getElementById("session_id").focus();
                return false;
        }
		 if(document.getElementById("term_id").value == "")
		{
				alert("Select Section");
                document.getElementById("term_id").focus();
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
	  <tr>
		<td>Session</td>
        <td><?php echo GenerateListBox("Select session_id, session_name from Sessions where isActive=1", "$session_id","session_id","","Select Session"); ?></td>
		<td>Term</td>
        <td><?php echo GenerateListBox("Select term_id, term_name from term ", "$term_id","term_id","","Select Term"); ?></td>
     </tr> 
	 <tr>
    	<td>Session Starts</td>
        <td><input required readonly onclick="GetDate(this);" name ="date_from" id="date_from" value ="<?php echo $date_from; ?>"/></td>
    
    	<td>Session Ends</td>
        <td><input required readonly onclick="GetDate(this);" name ="date_to" id="date_to" value ="<?php echo $date_to; ?>"/></td>
     </tr>
	<tr>
		<td>Current Term</td>
        <td colspan="3">
			<input type="radio" name ="activeID" id="activeID1" value ="1" <?php if ($activeID==1) echo "checked"; ?>/> True 
			<input type="radio" name ="activeID" id="activeID2" value ="2" <?php if ($activeID =="" || $activeID==2) echo "checked"; ?>/>False 
		</td>
     </tr>
    <td colspan="4"  style="text-align:right">
		<?php if($id>0) { ?>
        	<input type="submit" name ="submit" id = "submit" value ="Update" class="art-button" />
        	<!--<input type="submit" name ="submit" id = "submit" value ="Delete" class="art-button" />-->
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
        <th>Term</th>
        <th>Session</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Current Term</th>
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from CurrrentSessionView order by 1 desc  ";
		$rs = mysql_query($sql);
		$count=0;
		while($row = mysql_fetch_assoc($rs))
		{
			$styl=($count%2==0)?" class='trodd' ":'';
				echo "<tr $styl>";
			echo "<td>".(++$count)."</td>";
			echo "<td>".$row["term_name"]."</td>";
			echo "<td>".$row["session_name"]."</td>";
			echo "<td>".$row["date_from"]."</td>";
			echo "<td>".$row["date_to"]."</td>";
			echo "<td>".($row["isActive"]==1?"True":"False")."</td>";
			echo "<td><a href='home.php?page=term_config&id=".$row["c_session_id"]."'>Edit</a></td>";
			echo "</tr>";
			
		}
	?>
</table>


</body> 
</html> 