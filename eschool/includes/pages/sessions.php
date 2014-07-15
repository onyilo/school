<?php 
	
	$id = @$_REQUEST["id"];
	$session_name = @trim($_REQUEST["session_name"]);
	$activeID = @$_REQUEST["activeID"];
	$date_from = @$_REQUEST["date_from"];
	$date_to = @$_REQUEST["date_to"];
	$action = @$_REQUEST["submit"];
	$userid = @GetEmpID();
	$msg="";
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from sessions where session_id = $id";
		$rs = mysql_query($sql);
		$session_name = mysql_result($rs, 0, "session_name");	
		$date_from = mysql_result($rs, 0, "date_from");	
		$date_to = mysql_result($rs, 0, "date_to");	
		$activeID = mysql_result($rs, 0, "isActive");	
	}
	
	if($session_name=="" and $action !="" )
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Subject Name cannot be empty</font>";
	}elseif ($action!="")
		{
			$sql = "Select * from sessions where session_name='$session_name'" ;
			$rs = mysql_query($sql) or die(mysql_error());
			if (mysql_num_rows($rs)>0 and $action!="Delete" and $id<>mysql_result($rs,0,"session_id"))
			{
				$record = mysql_fetch_assoc($rs);
				$msg="<font color='#ff0000' style='font-size:14px;'>". $record["session_name"]." has been added already.</font>";
				$session_name="";
				$date_from = "";
				$date_to = "";
				$activeID="";
				$action ="";
				$id = 0;
			}
			elseif($action == "Add"){
				UpdateStatus($activeID);
				$sql = "Insert into sessions(session_name,posted_by,isActive, date_from, date_to) values('$session_name','$userid','$activeID','$date_from', '$date_to')";
				mysql_query($sql) or die(mysql_error());
				$msg="<font color='#005500' style='font-size:14px;'>Record inserted successfully</font>";
			}elseif($action == "Update")
			{
				UpdateStatus($activeID);
				$sql = "Update sessions Set session_name='$session_name',isActive='$activeID',date_from='$date_from', date_to='$date_to', last_modify_by='$userid', last_modify_date=current_timestamp()  where session_id = $id";
				mysql_query($sql);
				$id = 0;
				$session_name ="";
				$date_from = "";
				$date_to = "";
				$activeID="";
				$action ="";
				$msg="<font color='#005500' style='font-size:14px;'>Record updated succesfully</font>";
			}
	}
	
	function UpdateStatus($activeID)
	{
		if($activeID ==1 )	
		{
			$sql = "Update sessions Set isActive='2' where isActive = 1";
			mysql_query($sql) or die(mysql_error());
		}
	}
	
?>
<script type="text/javascript">
function validate(){
//Validate Required Value @39-6B39FE68
        if(document.getElementById("session_name").value == "")
		{
				alert("Enter Session Name");
                document.getElementById("session_name").focus();
                return false;
        }
		if(document.getElementById("date_from").value == "")
		{
				alert("Select Session Start Date");
                document.getElementById("date_from").focus();
                return false;
        }
		if(document.getElementById("date_to").value == "")
		{
				alert("Select Session End Date");
                document.getElementById("date_to").focus();
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
        <td><input name ="session_name" id="session_name" value ="<?php echo $session_name; ?>"/></td>
     </tr> 
	 <tr>
    	<td>Session Starts</td>
        <td><input type="date" required readonly onclick="GetDate(this);" name ="date_from" id="date_from" value ="<?php echo $date_from; ?>"/></td>
     </tr>
	 <tr>
    	<td>Session Ends</td>
        <td><input type="date" required readonly onclick="GetDate(this);" name ="date_to" id="date_to" value ="<?php echo $date_to; ?>"/></td>
     </tr>
	 <tr>
		<td>Current Session</td>
        <td>
			<input type="radio" name ="activeID" id="activeID1" value ="1" <?php if ($activeID==1) echo "checked"; ?>/> True 
			<input type="radio" name ="activeID" id="activeID2" value ="2" <?php if ($activeID =="" || $activeID==2) echo "checked"; ?>/>False 
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
        <th>Session</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Current Session</th>
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from Sessions";
		$rs = mysql_query($sql);
		$count=0;
		while($row = mysql_fetch_assoc($rs))
		{
			$styl=($count%2==0)?" class='trodd' ":'';
				echo "<tr $styl>";
			echo "<td>".(++$count)."</td>";
			echo "<td>".$row["session_name"]."</td>";
			echo "<td>".$row["date_from"]."</td>";
			echo "<td>".$row["date_to"]."</td>";
			echo "<td>".($row["isActive"]==1?"True":"False")."</td>";
			echo "<td><a href='home.php?page=sessions&id=".$row["session_id"]."'>Edit</a></td>";
			echo "</tr>";
			
		}
	?>
</table>
</body> 
</html> 