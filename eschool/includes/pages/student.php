<?php
$imgnumber='';

$id = @$_REQUEST["id"];

	$regno="";
			
	$lname="";
	$fname="";
	$oname="";
	$gender="";
	
	$eyear="";
	$eclass="";
	$cclass="";

	$country  = "";
	$state  ="";
	$lga  = "";
	
	$dob="";
	$saddress="";
	
	$gname="";
	$gaddress="";
	$gphone="";
	$gmail="";
	$errmsg='';
	$action=@$_REQUEST['registration'];
	$userid = @GetEmpID();
	$activeID='';
	
	if ($id>0 and $action =="" )
	{
		$sql = "SELECT * FROM student WHERE student_id =".$id;
		$result = mysql_query($sql) or die(mysql_error());
		$rest=mysql_fetch_array($result);
		extract($rest);	
		$passport=$imgnumber=$image_url;
		
		//echo $rest['passport'];die();
		//print_r($_POST);die();
		$regno=$reg_no;
		$lname=$surname; $fname=$firstname; $oname=$othername;
		$gname=$guardian_name; 
		$gaddress=$guardian_address; 
		$gphone=$guardian_phone;
		$gmail=$guardian_email;
		
		$saddress=$student_address;
		$eyear=$entry_year;
		$eclass=$entry_class_id;	
		$cclass=$class_id.",".$arm_id;
		
		$country  = $country_id;
		$state=$stateID;
		$lga=$LGAID;
		$activeID=$statusID;
	}
	
	if($action!="")
	{
		
		$imgnumber=$_POST['imgnumber'];
		$passport=$imgnumber;
		//echo $_POST['imgnumber'];die();
		//echo $role;die();print_r($_POST);die();
		$regno=($_POST['regno']);
				
		$lname=($_POST['lname']);
		$fname=($_POST['fname']);
		$oname=($_POST['oname']);
		$gender=($_POST['gender']);
		
		$eyear=($_POST['eyear']);
		$eclass=($_POST['eclass']);
		$cclass=($_POST['cclass']);
		
		
		$country  = isset($_POST['country'])?$_POST['country']:'';
		$state  = isset($_POST['state'])?$_POST['state']:'';
		$lga  = isset($_POST['lga'])?$_POST['lga']:'';
		
		$dob=($_POST['dob']);
		$saddress=($_POST['saddress']);
		
		$gname=($_POST['gname']);
		$gaddress=($_POST['gaddress']);
		$gphone=($_POST['gphone']);
		$gmail=($_POST['gmail']);
		
		//validate entry
		if(empty($passport)){
			$errmsg="Please upload a valid passport";
		}else if(empty($lname)){
			$errmsg="Last name field cannot be empty";
		}else if(empty($fname)){
			$errmsg="First name field cannot be empty";
		}else if(empty($gender)){
			$errmsg="Please select gender";
		}
		else if(empty($eyear)){
			$errmsg="Please select student's year of entry";
		}
		else if(empty($eclass)){
			$errmsg="Please select student's entry class";
		}
		else if(empty($cclass)){
			$errmsg="Please select student's current class";
		}
		else if(empty($country)){
			$errmsg="Please select nationality";
		}else if(empty($state)){
			$errmsg="Please select state";
		}else if(empty($lga)){
			$errmsg="Please select local goverment area";
		}
		else if(empty($dob)){
			$errmsg="Please enter date of birth";
		}
		else if(empty($saddress)){
			$errmsg="Student's address cannot be empty";
		}
		else if(empty($gname)){
			$errmsg="Guardian name cannot be empty ";
		}else if(empty($gaddress)){
			$errmsg="Guardians address cannot be empty";
		}else if(!is_numeric($gphone)){
			$errmsg="Please enter a valid mobile number";
		}/*else if(!check_email_address($gmail)){
			$errmsg="Please enter a valid email address";
		}*/
		else{
			list($class_id,$arms_id)=explode(',',$cclass);
			if(trim($action)=="Add")
			{
				//print_r($_POST);die;
					$sql="insert into student 
				(reg_no, surname, firstname, othername,guardian_name,guardian_phone,guardian_address,class_id,arm_id, gender, dob,student_address, guardian_email, image_url, entry_year, entry_class_id, country_id, stateID, LGAID, posted_by,posted_date) values 		('$regno','$lname','$fname','$oname','$gname','$gphone','$gaddress','$class_id','$arms_id','$gender','$dob','$saddress','$gmail','$passport','$eyear','$eclass','$country','$state','$lga','$userid',current_timestamp())";
				//die("$sql");
				mysql_query($sql) or die(mysql_error());
				if (mysql_affected_rows()==1){//successful insert in students table
					$errmsg="<font color='#00CC00'>Record ($lname $fname $oname) has been added successfully</font>";
					
					$regno="";
			
					$lname="";
					$fname="";
					$oname="";
					$gender="";
					
					$eyear="";
					$eclass="";
					$cclass="";
				
					$country  = "";
					$state  ="";
					$lga  = "";
					
					$dob="";
					$saddress="";
					
					$gname="";
					$gaddress="";
					$gphone="";
					$gmail="";
					$imgnumber="";
					
				}else{//unseccessful insert in lecturer table 
					$errmsg="Problem inserting record -->  ".mysql_error();
				}
			}else if($action=="Update")
			{
			$activeID=($_POST['activeID']);
				$sql="update student set  reg_no='$regno', surname='$lname', firstname='$fname', othername='$oname',guardian_name='$gname',guardian_phone='$gphone',guardian_address='$gaddress',class_id='$class_id',arm_id='$arms_id', gender='$gender', dob='$dob',student_address='$saddress', guardian_email='$gmail', image_url='$passport', entry_year='$eyear', entry_class_id='$eclass', country_id='$country', stateID='$state', LGAID='$lga',statusID=$activeID, last_modify_by='$userid', last_modify_date=current_timestamp() where student_id=$id ";
		
				$q=mysql_query($sql);
					if ($q){//successful insert in lecturer table
						$errmsg="<font color='#005500'>Record updated successfully</font>";
										
					}else{//unseccessful insert in lecturer table 
						$errmsg="Problem updating record -->  ".mysql_error();
					}
			}
			
			
			
			
		}
	}
	
	
?>

<form action="" method="post" enctype="multipart/form-data">
<div style="width:80%; margin:auto;">
<table border="0" class="entryTable" >
  <tr>
    
    <th colspan="6" style="color:#F00;">
	<?php echo $errmsg; ?></th>
  </tr>
    <tr>
    <td colspan="2">&nbsp;</td><td colspan="4" ><div id='images1' align="center">
        <div id='pprt'><img src="<?php echo ($imgnumber!="")?"".$imgnumber:"images/emptyImg.png"; ?>" alt='Passport' id='defaultimg'  style=" width:105px; height:110px;" /></div>
		</div>
        <br/>
        <b>Image size: Less than 50kb</b><br/><b>Image type:JPEG, GIF or PNG only</b></td>
    </tr>
     <?php 
 if($id>0)
 {
	 ?> <tr>
     <td>&nbsp;</td><td>&nbsp;</td>
     <td> Status: 
			<input type="radio" name ="activeID" id="activeID1" value ="1" <?php if ($activeID =="" || $activeID==1) echo "checked"; ?>/> Active 
			<input type="radio" name ="activeID" id="activeID2" value ="2" <?php if ($activeID==2) echo "checked"; ?>/>In-Active 
		</td>
        <td>&nbsp;</td>
    <td colspan="2">&nbsp;&nbsp;</td>
       </tr>
     <?php
 }
 ?>
   <tr>
     <td>Passport<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><div id='iframe' style=" width:250px; overflow:hidden; height:50px;">
                            
			<iframe src='upload.php' marginheight='0'  align="top"  height="10" scrolling='no' frameborder='0' style=" border:0px;"  ></iframe>
			</div></td>
            <td>&nbsp;&nbsp;Registration Number<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><input type="text" name="regno" value="<?php echo $regno;  ?>" required></td>
    
     <td>Gender<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><select name="gender"><option value="">Select gender</option>
     <option value="Male"<?php  echo ($gender=='Male')?'selected':'';  ?>>Male</option>
     <option value="Female" <?php  echo ($gender=='Female')?'selected':'';  ?>>Female</option></select></td>
    
  </tr>
  
  <tr>
  <td>First Name<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><input type="text" name="fname" value="<?php echo $fname; ?>" required></td>
    <td>Other Names&nbsp;&nbsp;</td>
    <td><input type="text" name="oname" value="<?php echo $oname;  ?>" required></td>
 <td>&nbsp;&nbsp;Last Name:<span class="required">*</span>&nbsp;&nbsp;
      <input type='hidden'  id='imgnumber' value="<?php echo $imgnumber; ?>" name='imgnumber'  /></td>
    <td>
    <input type="text" name="lname" value="<?php echo $lname; ?>" required></td>
   </tr>
  <tr>
    
  
    
  <td>Entry Year<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><select name="eyear" id="eyear">
    <option value=""> Select Year</option>
	<?php
	$yr=date('Y');
	for ($i=$yr; $i>=1980; $i--)
	{
		$seleted=($eyear==$i)?" selected='selected' ":"";
		echo "<option value='$i' $seleted> $i </option>\n";
	}
	  ?></select></td>
    
    <td>Entry Class<span class="required">*</span>&nbsp;&nbsp;</td>
    <td>
	<?php
	$query="select class_id, class_name from classes";
	//$roleID=$eclass;
	echo generateListBox($query,$eclass,'eclass',  $className="theInput");
	?>
    </td>
     <td>Current Class:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><?php
	$query="select IDs, className from classarmsview";
	echo generateListBox($query,$cclass,'cclass',  $className="theInput");
	?></td>
  </tr>
  <tr>
    <td>Nationality<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><select name="country"  id="country"  onchange="return getState('<?php echo $state;   ?>','<?php echo $lga;   ?>');"><option value="">Select country</option> 
    
                               <?php
			$sql="select * from country order by Name ASC";
			$result=mysql_query($sql);
			while ($val=mysql_fetch_array($result))
			{
				
				echo "<option value='".$val['Code']."'";
				if($val['Code']=='NGA'){echo "selected='selected'";}
				echo ">".$val['Name']." </option> ";	
			}
		
		?>
    </select></td> 
    <!-- auto loading the state options since nigeria is initially selected -->
	<script type="text/javascript">
    getState('<?php echo $state;   ?>','<?php echo $lga;   ?>');
    </script>
  <td>State of Origin:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><select name="state" id="state" disabled onchange="return getLGA('<?php echo $state;   ?>');"><option value="">Select state</option> </select></td>
    <td>LGA:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><select name="lga" id="lga" disabled ><option value="">Select LGA</option> <option value="">Select state first</option></select></td>
  </tr>
  <tr><td>Student Address:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><input type="text" name="saddress" required value="<?php echo $saddress;  ?>"></td>
  <td>Date of Birth<span class="required">*</span>&nbsp;&nbsp;</td>
  
    <td><input type="text" onClick="GetDate(this);" readonly name="dob" required value="<?php echo $dob; ?>"></td>
    
    
    <td> Guardian Name<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><input type="text" name="gname" required value="<?php echo $gname;  ?>"></td>
  
    
  </tr>
  <tr>
  <td>Guardian Address:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><input type="text" name="gaddress" required value="<?php echo $gaddress; ?>"></td>
  <td>Guardian Phone Number:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><input type="text" name="gphone" required value="<?php  echo $gphone;  ?>"></td>
  
  <td>Guardian Email:&nbsp;&nbsp;</td>
    <td><input type="text" name="gmail" value="<?php  echo $gmail;  ?>"></td>
 
  </tr>
   
  <tr>
    <td>&nbsp;</td><td>&nbsp;</td>
    <td>
    <?php if($id>0) { ?>
        <input type="submit" name="registration" id="registration" value="Update" class="art-button">&nbsp;<input name="button" type="button" value="Back" onClick="location.href='home.php?page=student_list'" class="art-button">
		<?php } 
		else { 
		?>
        	<input type="hidden" name ="id" id = "id" value ="<?php echo $id; ?>" />
          <input type="submit" name="registration" id="registration" value="   Add   " class="art-button">
         
	<?php } ?>
    </td>
    <td colspan="2">&nbsp;&nbsp;</td><td>&nbsp;</td>
   
    </tr>
</table>
</div>
</form>