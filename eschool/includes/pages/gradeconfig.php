<?php 
	
	$id = @$_REQUEST["id"];
	$section_id = @trim($_REQUEST["section_id"]);
	$gradeTypeID = @trim($_REQUEST["gradeTypeID"]);
	
	
	$action = @$_REQUEST["submit"];
	$userid = @GetEmpID();
	$msg="";
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from gradetypedetails where id = $id";
		$rs = mysql_query($sql);
		$gradeTypeID = mysql_result($rs, 0, "gradeTypeID");	
		$section_id = mysql_result($rs, 0, "section_id");	
		
	}
	
	if($section_id=="" and $action !="" )
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Section must selected</font>";
	}
	if($gradeTypeID=="" and $action !="" )
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Grading Type must be selected</font>";
	}
	
	elseif ($action!="")
		{
			/*$sql = "Select * from section_ids where gradeTypeID='$section_idType'" ;
			$rs = mysql_query($sql) or die(mysql_error());
			if (mysql_num_rows($rs)>0 and $action!="Delete")
			{
				$record = mysql_fetch_assoc($rs);
				$msg="<font color='#ff0000' style='font-size:14px;'>". $record["section_idType"]." has been added already.</font>";
				$section_idType="";
				$action ="";
				$id = 0;
			}
			else*/if($action == "Add"){
				$sql = "Insert into gradetypedetails(section_id,gradeTypeID) values('$section_id','$gradeTypeID')";
				mysql_query($sql) or die(mysql_error());
				$msg="<font color='#005500' style='font-size:14px;'>Record inserted successfully</font>";
				
			}elseif($action == "Update")
			{
				$sql = "Update gradetypedetails Set section_id='$section_id',gradeTypeID='$gradeTypeID' where id = $id";
				mysql_query($sql);
				$id = 0;
				$gradeTypeID = "";	
				$section_id = "";	
				$action ="";
				$msg="<font color='#005500' style='font-size:14px;'>Record updated succesfully</font>";
				}
	}
	
?>
<script type="text/javascript">
function validate(){
//Validate Required Value @39-6B39FE68
		if(document.getElementById("section_id").value == "")
		{
				alert("Enter Section");
                document.getElementById("section_id").focus();
                return false;
        }
        if(document.getElementById("gradeTypeID").value == "")
		{
				alert("Select section_id Type");
                document.getElementById("gradeTypeID").focus();
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
    	<td>Section</td>
        <td>
			<?php echo GenerateListBox("Select section_id, section_name from sections", "$section_id","section_id","","Select Section"); ?>
		</td>
		<td>Grade Type</td>
        <td>d
			<?php echo GenerateListBox("Select gradeTypeID, gradeType from gradeTypes", "$gradeTypeID","gradeTypeID","","Select Grading Type"); ?>
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
        <th>Section </th>
        <th>Grading System</th>
        
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from gradetypedetailView ";
		$rs = mysql_query($sql);
		$count=0;
		while($row = mysql_fetch_assoc($rs))
		{
			$styl=($count%2==0)?" class='trodd' ":'';
				echo "<tr $styl>";
			echo "<td>".(++$count)."</td>";
			echo "<td>".$row["section_name"]."</td>";
			echo "<td>".$row["gradeType"]."</td>";
			echo "<td><a href='home.php?page=gradeconfig&id=".$row["ID"]."'>Edit</a></td>";
			echo "</tr>";
		}
	?>
</table>


</body> 
</html> 