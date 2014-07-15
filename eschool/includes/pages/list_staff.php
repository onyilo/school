  <table class="mytable" style=" margin:auto;border-collapse:collapse">
 
    <tr>
	  <th width="50px">S/No</th>
	  <th>Staff Name</th>
	  <th>Staff Code</th>
	  <th>Gender</th>
	  <th>Marital Status</th>
      <th>Address</th>
      <th>Email</th>
      <th>Phone</th> 
      <th>Status</th> 
      <th>&nbsp;</th>      
     
    </tr>
      
      	<?php
	 $sql = "select * from staff";
		//echo $sql; die();
		$query =  mysql_query($sql);
		if (mysql_num_rows($query)<1){
		
		echo "<tr><td>&nbsp;</td>
		<td colspan='6' style='text-align:center;'><b> No record found</b></td>
		</tr>";
		
	
		}else
		{
			$count=0;
			while($result=mysql_fetch_array($query))
			{
				$count++;
				$styl=($count%2==0)?" class='trodd' ":'';
			echo "<tr $styl><td>$count</td>
			<td><a href='#'>".$result['surname']." ".$result['firstname']." ".$result['othername']."</a></td>
			<td>".$result['staff_code']."</td>
			<td>".$result['gender']."</td>
			<td> ".$result['maritalStatus']."</td>
			<td> ".$result['address']."</td>
			<td>".$result['email']."</td>
			<td>".$result['phone']."</td>";
			$stat=($result["status"]==1)?"Active":"In-Active";
			echo "<td>$stat</td>";echo "<td><a href='home.php?page=staff&id=".$result["staff_id"]."'>Edit</a></td>";
			echo"</tr>";
			
			}
		}

		
	  
	  ?>
      
  </table>