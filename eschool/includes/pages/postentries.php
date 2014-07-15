<?php 
	
	$id = @$_REQUEST["id"];
	$subject_id = @$_REQUEST["subject_id"];
	$class_id = @$_REQUEST["class_id"];
	$arm_id = @$_REQUEST["arm_id"];
	$staff_id = @$_REQUEST["staff_id"];
	$userID = @GetEmpID();
	$action = @$_REQUEST["submit"];
	
	$msg="";
	if ($action =="Cancel" )
	{
		$id = 0;
		$class_id ="";
		$subject_id = "";
		$action ="";
		$arm_id = "";
		$staff_id = "";
	}
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from teaches where id = $id";
		$rs = mysql_query($sql);
		$subject_id = mysql_result($rs, 0, "subject_id");	
		$class_id = mysql_result($rs, 0, "class_id");
		$arm_id = mysql_result($rs, 0, "arm_id");
		$staff_id = mysql_result($rs, 0, "staff_id");
	}
	
	if($subject_id=="" and $action !="")
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Subject must be selected</font>";
	}
	elseif($class_id=="" and $action !="")
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Section must be selected</font>";
	}
	elseif($arm_id=="" and $action !="")
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Arm must be selected</font>";
	}
	elseif($staff_id=="" and $action !="")
	{
		$msg="<font color='#ff0000' style='font-size:14px;'>Staff must be selected</font>";
	}
	elseif ($action !=""){
	
		$sql = "Select * from teachesview where subject_id='$subject_id' and arm_id='$arm_id' and class_id='$class_id'" ;
		$rs = mysql_query($sql);
		if (mysql_num_rows($rs)>0 and $action!="Delete")
		{
			$record = mysql_fetch_assoc($rs);
			$msg="<font color='#ff0000' style='font-size:14px;'>". $record["class_name"]." ".$record["arm_name"]." already has ".$record["subject_name"]." assigned to it.</font>";
			$id = 0;
			$class_id ="";
			$subject_id = "";
			$action ="";
			$arm_id = "";
			$staff_id = "";
			$action ="";
		}
		elseif($action == "Add")
		{
			$sql = "Insert into teaches(subject_id,class_id, arm_id, staff_id, c_session_id, posted_by) values('$subject_id','$class_id','$arm_id', '$staff_id','".getCurrentSession()."','$userID')";
			mysql_query($sql) or die(mysql_error());
			$msg="<font color='#005500' style='font-size:14px;'>Record Inserted Successfully</font>";
		}
		elseif($action == "Update")
		{
			$sql = "Update teaches Set subject_id='$subject_id', class_id='$class_id', arm_id='$arm_id', staff_id='$staff_id',last_modify_by='$userID',last_modify_date=Current_Timestamp() where id = $id";
			mysql_query($sql);
			$id = 0;
			$class_id ="";
			$subject_id = "";
			$action ="";
			$arm_id = "";
			$staff_id = "";
			$msg="<font color='#005500' style='font-size:14px;'>Record Updated Successfully</font>";
		}
		elseif($action == "Delete")
		{
			$sql = "Delete from teaches where id= $id";
			mysql_query($sql);
			$id = 0;
			$class_id ="";
			$subject_id = "";
			$action ="";
			$arm_id = "";
			$staff_id = "";
			
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
		if(document.getElementById("class_id").value == "")
		{
				alert("Select Class");
                document.getElementById("class_id").focus();
                return false;
        }
		 if(document.getElementById("OfferTypeID").value == "")
		{
				alert("Select Offer Type");
                document.getElementById("OfferTypeID").focus();
                return false;
        }
		 if(document.getElementById("arm_id").value == "")
		{
				alert("Select Arm");
                document.getElementById("arm_id").focus();
                return false;
        }
		
}
  $(function() {
    function log( message ) {
      //$( "<div>" ).text( message ).prependTo( "#log" );
      $("#staff_id").val(message);
    }
 
    $( "#staffname" ).autocomplete({
		  source: "getStaffs.php",
		  minLength: 1,
		  select: function( event, ui ) {
		  log( ui.item.id ?ui.item.id :"" );
      }
	  
    });
	
	
		
  });
  function changeStaffID(){
		 alert('aa');
		  $( "#staffname" ).autocomplete({
		  source: "getStaffs.php",
		  minLength: 1,
		  select: function( event, ui ) {
		  log( ui.item.id ?ui.item.id :"" );
      }
	  
    });
		 return false;
	}
</script>

<table class="mytable" style=" margin:auto;border-collapse:collapse">
	<tr>
    	<th>S/No</th>
        <th>Subject</th>
        <th>Class</th>
        <th>Arm</th>
        <th>Teacher Name</th>
        <th></th>
    </tr>
    <?php
    	$sql ="Select * from teachesview where staff_id='".GetStaffID().".";
		$rs = mysql_query($sql) or die(mysql_error());
		$count=0;
		
		if(mysql_num_rows($rs)<1)
		{
			$styl=($count%2==0)?" class='trodd' ":'';
					echo "<tr $styl>";
				echo "<td colspan='6' style=' font-size:16px; color:red;'>No record found</td>";
				echo "</tr>";
		}else
		{
			while($row = mysql_fetch_assoc($rs))
			{
				$styl=($count%2==0)?" class='trodd' ":'';
					echo "<tr $styl>";
				echo "<td>".(++$count)."</td>";
				echo "<td>".$row["subject_name"]."</td>";
				echo "<td>".$row["class_name"]."</td>";
				echo "<td>".$row["arm_name"]."</td>";
			echo "<td>".$row["surname"]." ".$row["firstname"]." ".$row["othername"]."</td>";
				echo "<td><a href='home.php?page=teaches&id=".$row["id"]."'>Edit</a></td>";
				echo "</tr>";
			
			}
		}
		
	?>
</table>
</body> 
</html> 