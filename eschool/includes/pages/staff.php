<?php
$imgnumber='';

$id = @$_REQUEST["id"];
$staffCode='';
	$title='';
	
	$lname='';
	$fname='';
	$oname='';
	
	$gender='';
	$dob='';
	$maritalstatus='';
	
	$country  = '';
	$state  = '';
	$lga  = '';
	
	$address='';
	$email='';
	$mobile='';
	$errmsg='';
	$action=@$_REQUEST['Register'];
	$userid = @GetEmpID();
	$activeID='';
	
	if ($id>0 and $action =="" )
	{
		$sql ="Select * from staff where staff_id = $id";
		$rs = mysql_query($sql) or die(mysql_error());
		$staff_values = mysql_fetch_array($rs);	
		
		$imgnumber=$staff_values['passport'];
		$staffCode=$staff_values['staff_code'];
		$title=$staff_values['title'];
		
		$lname=$staff_values['surname'];
		$fname=$staff_values['firstname'];
		$oname=$staff_values['othername'];
		
		$gender=$staff_values['gender'];
		$dob=$staff_values['dob'];
		$maritalstatus=$staff_values['maritalStatus'];
		
		$country  = $staff_values['nationality'];
		$state  = $staff_values['state'];
		$lga  = $staff_values['lga'];
		
		$address=$staff_values['address'];
		$email=$staff_values['email'];
		$mobile=$staff_values['phone'];
		$activeID=$staff_values['status'];
	}
	
if($action!="")
{
	
	$imgnumber=$_POST['imgnumber'];
	$passport=$imgnumber;
	//echo $_POST['imgnumber'];die();
	//echo $role;die();print_r($_POST);die();
	$staffCode=($_POST['staffCode']);
	$title=($_POST['title']);

		
	$lname=($_POST['lname']);
	$fname=($_POST['fname']);
	$oname=($_POST['oname']);
	
	
	$gender=($_POST['gender']);
	$dob=($_POST['dob']);
	$maritalstatus=($_POST['maritalstatus']);
	
	$country  = isset($_POST['country'])?$_POST['country']:'';
	$state  = isset($_POST['state'])?$_POST['state']:'';
	$lga  = isset($_POST['lga'])?$_POST['lga']:'';
	
	$address=($_POST['address']);
	$email=($_POST['email']);
	$mobile=($_POST['mobile']);
	
		
	
	
	if(empty($passport)){
		$errmsg="Please upload a valid passport";
	}else if(empty($title)){
		$errmsg="Please select title";
	}else if(empty($lname)){
		$errmsg="Lastname field cannot be empty";
	}else if(empty($fname)){
		$errmsg="First name field cannot be empty";
	}else if(empty($gender)){
		$errmsg="Please select gender";
	}else if(empty($dob)){
		$errmsg="Please enter date of birth";
	}else if(empty($maritalstatus)){
		$errmsg="Please select marital status";
	}else if(empty($country)){
		$errmsg="Please select nationality";
	}else if(empty($state)){
		$errmsg="Please select state";
	}else if(empty($lga)){
		$errmsg="Please select local goverment area";
	}else if(empty($address)){
		$errmsg="Address field cannot be empty";
	}/*else if(!check_email_address($email)){
		$errmsg="Please enter a valid email address";
	}*/
	else if(!is_numeric($mobile)){
		$errmsg="Please enter a valid mobile number";
	}else{
	
		if(trim($action)=="Add")
		{
			$sql="insert into staff (staff_code, title, passport, surname, firstname, othername, gender, dob, maritalStatus, nationality, state, lga,address, email, phone, posted_by,posted_date) values ('$staffCode','$title','$passport','$lname','$fname','$oname','$gender','$dob','$maritalstatus','$country','$state','$lga','$address','$email','$mobile','$userid',current_timestamp())";
			
			mysql_query($sql);
			if (mysql_affected_rows()==1){//successful insert in lecturer table
				$errmsg="<font color='#005500'>Record added successfully</font>";
				$imgnumber="";
				$staffCode='';
				$title='';
	
				$lname='';
				$fname='';
				$oname='';
				
				$gender='';
				$dob='';
				$maritalstatus='';
				
				$country  = '';
				$state  = '';
				$lga  = '';
				
				$address='';
				$email='';
				$mobile='';
				
				
			}else{//unseccessful insert in lecturer table 
				$errmsg="Problem inserting record -->  ".mysql_error();
			}
		}else if($action=="Update")
		{
			$activeID=($_POST['activeID']);
		$sql="update staff set staff_code='$staffCode', title='$title', passport='$passport', surname='$lname', firstname='$fname', othername='$oname', gender='$gender', dob='$dob', maritalStatus='$maritalstatus', nationality='$country', state='$state', lga='$lga',address='$address', email='$email', phone='$mobile', status=$activeID ,last_modify_by='$userid',last_modify_date=current_timestamp() where staff_id=$id ";

		$q=mysql_query($sql);
			if ($q){//successful insert in lecturer table
				$errmsg="<font color='#005500'>Record updated successfully</font>";
								
			}else{//unseccessful insert in lecturer table 
				$errmsg="Problem updating record -->  ".mysql_error();
			}
		}else
		{
$errmsg="err";
		}
	
		
		
		
	}
}

?>

<form action="" method="post" enctype="multipart/form-data">
<div class="entryTableDiv" style="width:80%; margin:auto;">
<table border="0" class="entryTable">
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
                            
			<iframe src='upload.php' marginheight='0' align="bottom"  height="" scrolling='no' frameborder='0' style=" border:0px;"  ></iframe>
			</div></td>
            <td>&nbsp;&nbsp;Staff code:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td>
    <input type="text" name="staffCode" value="<?php echo $staffCode;  ?>" required></td>
    <td>&nbsp;&nbsp;Title:<span class="required">*</span>&nbsp;&nbsp;
      <input type='hidden'  id='imgnumber' value="<?php echo $imgnumber;   ?>" name='imgnumber'  /></td>
    <td><select name="title">
      <option value="">Select Title</option>
        <option value="Mr"<?php  echo ($title=='Mr')?'selected':'';  ?>>Mr</option>
        <option value="Mrs" <?php  echo ($title=='Mrs')?'selected':'';  ?>>Mrs</option>
        <option value="Miss" <?php  echo ($title=='Miss')?'selected':'';  ?>>Miss</option>
        <option value="Dr" <?php  echo ($title=='Dr')?'selected':'';  ?>>Dr</option>
        <option value="Prof" <?php  echo ($title=='Prof')?'selected':'';  ?>>Prof</option>
    </select></td>
    
    
  </tr>
  
  <tr>
  <td>Lastname<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><input type="text" name="lname" value="<?php echo $lname; ?>" required></td>
    <td>Firstname<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><input type="text" name="fname" value="<?php echo $fname; ?>" required></td>
  <td>Other Names&nbsp;&nbsp;</td>
    <td><input type="text" name="oname" value="<?php echo $oname;   ?>" ></td>
   </tr>
  <tr>
    
  <td>Gender:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><select name="gender"><option value="">Select gender</option>
     <option value="Male"<?php  echo ($gender=='Male')?'selected':'';  ?>>Male</option>
     <option value="Female" <?php  echo ($gender=='Female')?'selected':'';  ?>>Female</option></select></td>
    
  <td>Date of Birth:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><input type="text" onClick="GetDate(this);" readonly name="dob" required value="<?php echo $dob; ?>"></td>
     <td>Marital Status:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><select name="maritalstatus"><option value="">Select status</option>
 <option value="Single"  <?php  echo ( $maritalstatus=='Single')?'selected':'';  ?> >Single</option>
 <option value="Married" <?php echo ( $maritalstatus=='Married')?'selected':''; ?> >Married</option>
 <option value="Others"  <?php echo ( $maritalstatus=='Others')?'selected':'';  ?> >Others</option>
 </select></td>
  </tr>
  <tr>
    <td>Nationality:<span class="required">*</span>&nbsp;&nbsp;</td>
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
    <td><select name="state" id="state" disabled onchange="return getLGA('<?php echo  $state;   ?>');"><option value="">Select state</option> </select></td>
    <td>LGA:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><select name="lga" id="lga" disabled ><option value="">Select LGA</option> <option value="">Select state first</option></select></td>
  </tr>
  <tr>
    <td> Contact Address:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><input type="text" name="address" required value="<?php echo $address; ?>"></td>
  <td>Email Address:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><input type="text" name="email"  value="<?php echo $email;  ?>"></td>
    <td>Phone Number:<span class="required">*</span>&nbsp;&nbsp;</td>
    <td><input type="text" name="mobile" required value="<?php echo $mobile;  ?>"></td>
  </tr> 
  
  <tr>
    <td>&nbsp;</td><td>&nbsp;</td><td>
    <?php if($id>0) { ?>
        <input type="submit" name="Register" id="addStaff" value="Update" class="art-button">&nbsp;<input name="button" type="button" value="Back" onClick="location.href='home.php?page=staff_list'" class="art-button">
		<?php } 
		else { 
		?>
        	<input type="hidden" name ="id" id = "id" value ="<?php echo $id; ?>" />
           <input type="submit" name="Register" id="addStaff" value="  Add  " class="art-button">&nbsp;
         
	<?php } ?>
    
    </td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;&nbsp;</td>
   
    </tr>
</table>
</div>
</form>