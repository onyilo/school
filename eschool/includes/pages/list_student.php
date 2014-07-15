 <table class="mytable" style=" margin:auto;border-collapse:collapse">
  
    <tr>
	  <th width="50px">S/No.</th>
	  
      <th>Full Name</th>
     <th>Registration Number</th>
	  <th>Gender</th> 
      <th>Student Address</th>
	  <th>Class</th>
      <th>Guardian Name</th>
      <th>Guardian Phone Number</th>
      <th>Status</th> 
      <th>&nbsp;</th> 
     
    </tr>
      
      	<?php
	$sql = "select * from student";
		//echo $sql; die();
		$query =  mysql_query($sql);
		if (mysql_num_rows($query)<1){
		
		echo "<tr><td>&nbsp;</td><td colspan='6' style='text-align:center;'><b> No record found</b></td></tr>";
		return;
	
		}
		$count=0;
		while($result=mysql_fetch_array($query))
		{
			$count++;
		$styl=($count%2==0)?" class='trodd' ":'';
			echo "<tr $styl><td>$count</td>
		
        <td><a href='#' name='student_id'>".$result['surname']." ".$result['firstname']." ".$result['othername']."</a></td>
        <td>".$result['reg_no']."</td>
        <td>".$result['gender']."</td>
		<td> ".$result['student_address']."</td>
		<td>".getClassArmName($result['class_id'].','.$result['arm_id'])."</td>
		<td> ".$result['guardian_name']."</td>
        <td>".$result['guardian_phone']."</td>";
		
        $stat=($result["statusID"]==1)?"Active":"In-Active";
		
			echo "<td>$stat</td>";echo "<td><a href='home.php?page=student&id=".$result["student_id"]."'>Edit</a></td>";
			echo"</tr>";
        
		}
	  
	  ?>
      
  </table>