<?php 
	
	$id = @$_REQUEST["id"];
	$section_name = @$_REQUEST["section_name"];
	$activeID = @$_REQUEST["activeID"];
	$action = @$_REQUEST["submit"];
	
	$msg="";
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from sections where section_id = $id";
		$rs = mysql_query($sql);
		$section_name = mysql_result($rs, 0, "section_name");	
		$activeID = mysql_result($rs, 0, "ActiveID");	
	}
	
	if($section_name=="" and $action !="")
	{
		$msg="<font color='#550000' style='font-size:14px;'>Section Name cannot be empty</font>";
	}else{
		
		if($action == "Add")
		{
			$sql = "Insert into sections(section_name,ActiveID) values('$section_name','$activeID')";
			mysql_query($sql);
			$msg="<font color='#005500' style='font-size:14px;'>Record inserted succesfully</font>";
		}
		elseif($action == "Update")
		{
			$sql = "Update sections Set section_Name='$section_name', ActiveID='$activeID' where section_id = $id";
			mysql_query($sql);
			$id = 0;
			$section_name ="";
			$activeID="";
			$action ="";
			$msg="<font color='#005500' style='font-size:14px;'>Record updated succesfully</font>";
		}
	}
	
?>
<script type="text/javascript">
function validate(){
//Validate Required Value @39-6B39FE68
        if(document.getElementById("section_name").value == "")
		{
				alert("Enter Section Name");
                document.getElementById("section_name").focus();
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
        <td><input name ="section_name" id="section_name" value ="<?php echo $section_name; ?>"/></td>
     </tr> 
	<tr>
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
<table class="mytable" style=" margin:auto;border-collapse:collapse">
	<tr>
    	<th>S/No</th>
        <th>Section Name</th>
        <th>Status</th>
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from sections";
		$rs = mysql_query($sql);
		$count=0;
		while($row = mysql_fetch_assoc($rs))
		{
			$styl=($count%2==0)?" class='trodd' ":'';
				echo "<tr $styl>";
			echo "<td>".(++$count)."</td>";
			echo "<td>".$row["section_name"]."</td>";
			echo "<td>".($row["ActiveID"]==1?"Active":"In-Active")."</td>";
			echo "<td><a href='home.php?page=sections&id=".$row["section_id"]."'>Edit</a></td>";
			echo "</tr>";
			
		}
	?>
</table>


</body> 
</html> 