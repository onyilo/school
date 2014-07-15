<?php 
	
	$id = @$_REQUEST["id"];
	$gradeType = @trim($_REQUEST["gradeType"]);
	$activeID = @$_REQUEST["activeID"];
	$action = @$_REQUEST["submit"];
	$userid = @GetEmpID();
	$msg="";
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from GradeTypes where gradeTypeID = $id";
		$rs = mysql_query($sql);
		$gradeType = mysql_result($rs, 0, "gradeType");	
	}
	
	if($gradeType=="" and $action !="" )
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Subject Name cannot be empty</font>";
	}elseif ($action!="")
		{
			$sql = "Select * from GradeTypes where gradeType='$gradeType'" ;
			$rs = mysql_query($sql) or die(mysql_error());
			if (mysql_num_rows($rs)>0 and $action!="Delete")
			{
				$record = mysql_fetch_assoc($rs);
				$msg="<font color='#ff0000' style='font-size:14px;'>". $record["gradeType"]." has been added already.</font>";
				$gradeType="";
				$action ="";
				$id = 0;
			}
			elseif($action == "Add"){
				$sql = "Insert into GradeTypes(gradeType) values('$gradeType')";
				mysql_query($sql) or die(mysql_error());
				$msg="<font color='#005500' style='font-size:14px;'>Record inserted successfully</font>";
			}elseif($action == "Update")
			{
				$sql = "Update GradeTypes Set gradeType='$gradeType' where gradeTypeID = $id";
				mysql_query($sql);
				$id = 0;
				$gradeType ="";
				$action ="";
				$msg="<font color='#005500' style='font-size:14px;'>Record updated succesfully</font>";
				}
	}
	
?>
<script type="text/javascript">
function validate(){
//Validate Required Value @39-6B39FE68
        if(document.getElementById("gradeType").value == "")
		{
				alert("Enter Grade Type");
                document.getElementById("gradeType").focus();
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
        <td><input name ="gradeType" id="gradeType" value ="<?php echo $gradeType; ?>"/></td>
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
        <th>Grade Type</th>
      
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from GradeTypes";
		$rs = mysql_query($sql);
		$count=0;
		while($row = mysql_fetch_assoc($rs))
		{
			$styl=($count%2==0)?" class='trodd' ":'';
				echo "<tr $styl>";
			echo "<td>".(++$count)."</td>";
			echo "<td>".$row["gradeType"]."</td>";
			
			echo "<td><a href='home.php?page=GradeTypes&id=".$row["gradeTypeID"]."'>Edit</a></td>";
			echo "</tr>";
		}
	?>
</table>


</body> 
</html> 