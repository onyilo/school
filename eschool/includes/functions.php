<?php

function GenerateMenu()
{ 

$SQL="";
$SQL1="Select menuID from tbl_menuauthorise where menuID is not null";
$rs1 = mysql_query($SQL1);
$val = "";
  if(mysql_num_rows($rs1)>0)
  {
  $SQL = "select tbl_menu.* from tbl_menu where menuID in (select menuid from tbl_menuauthorise  where ".
  "privilegeID in (".GetAssignedPrivileges(GetEmpID()).") or privilegeID is null) ".
  "  and activeid = 1 and (parentMenuid is null   or parentmenuid =0) order by order_by";	
}
  else
  {
$SQL = "select * from tbl_menu where activeid = 1 and (parentMenuid is null   or parentmenuid =0)  order by order_by";
  }

$rs = mysql_query($SQL);

while ($row =  mysql_fetch_assoc($rs))
{
  $val = $val . "<li><a href=\"". $row["menu_href"]."\">".$row["menu_title"] ."</a>";
  $val = $val . generatesubmenu($row["menuID"]) . "</li>";
}
  return  str_replace("<ul></ul>","",$val);
}

function generatesubmenu($id)
{
	$SQL="";
	$SQL1="Select menuID from tbl_menuauthorise where menuID is not null";
	$rs1 = mysql_query($SQL1);
	$val = "";
	  if(mysql_num_rows($rs1)>0)
	  {
	  $SQL = "select tbl_menu.* from tbl_menu where menuID in (select menuid from tbl_menuauthorise  where ".
	  "privilegeID in (".GetAssignedPrivileges(GetEmpID()).") or privilegeID is null) ".
	  "  and activeid = 1 and parentMenuid = $id  order by order_by";
		
	  }
	  else
	  {
		$SQL = "select * from tbl_menu where activeid = 1 and  parentMenuid = $id order by order_by";
	}

	$val = "<ul>";

	$rs = mysql_query($SQL);

	while ($row =  mysql_fetch_assoc($rs))
	{
	  $val = $val . "<li><a href=\"". $row["menu_href"]."\">". $row["menu_title"] ."</a>";
	  $val = $val . generatesubmenu($row["menuID"]) . "</li>";
	}
	$val = $val . "</ul>";
	return $val;
}

function GetAssignedPrivileges($EmpID)
{
//$connection = new clsDBConnection1();

$SQL = "select * from vprivilegedetails where PrivilegeClassID = 1 and StatusID = 1 and employee_id='$EmpID'";
$rs = mysql_query($SQL); 
$arr = array();
$arr[] =0;
while($row = mysql_fetch_assoc($rs))
{
  $arr[] = $row["PrivilegeID"];
}
return implode($arr,",");	
}
function ValidateActivity($ActivityID)
{

	$val = "Select ActivityPrivID from vprivilegedetails where PrivilegeClassID = 1 and StatusID = 1 and employee_id='".GetEmpID()."' and ActivityPrivID = ". $ActivityID;
$rs = mysql_query($val);
if (mysql_num_rows($rs)>0)
	return true;
else
	return false;
}

function ValidateLoginActivity($empID)
{

	$val = "Select ActivityPrivID from vprivilegedetails where PrivilegeClassID = 1 and StatusID = 1 and employee_id='".$empID."' and ActivityPrivID = 3";
	//echo $val;die;
$rs = mysql_query($val);
if (mysql_num_rows($rs)>0)
	return true;
else
	return false;
}

function GetEmpID()
{
	return $_SESSION["user"]["UserID"];
}

function checkAccessToPageActivity($empID,$activityPrivID)// edit 2moro, fectch 
{

	$val = "Select ActivityPrivID from vprivilegedetails where PrivilegeClassID = 1 and StatusID = 1 and employee_id='".$empID."' and ActivityPrivID = $activityPrivID";
$rs = mysql_query($val);
if (mysql_num_rows($rs)>0)
	return true;
else
	return false;
}




function generateListBox($query,$roleID, $controlName, $className="theInput",$caption="Select Value")
{
	//echo $query; die();
	
	$val = "<select name=\"$controlName\" id=\"$controlName\" class=\"$className\"><option value=\"\">$caption</option>";
	$rs = mysql_query($query) or die(mysql_error());
	$j=0;
	while($row =  mysql_fetch_assoc($rs))
	{
		//echo $row['role_id'];
		foreach($row as $value){
			$selected=($value==$roleID)?'selected':'';
			if ($j==0)
				$val.= "<option value=\"$value\" $selected>";
			else
				$val.= "$value</option>";
			$j++;
		}
		$j=0;
	}
	$val.="</select>";
	return $val;
}


//generate select fields2
function generateListBoxWithEvent($query, $roleID, $controlName,  $className="theInput", $theEvent,$caption="Select")
{
	//echo $query; die();
	if($className=="")
	{
		$className = "theInput";	
	}
	
	$val = "<select name=\"$controlName\" id=\"$controlName\" class=\"$className\" onChange=\"$theEvent;\"><option value=''>$caption</option>";
	$rs = mysql_query($query);
	$j=0;
	if($rs)
	{
	while($row =  mysql_fetch_assoc($rs))
	{
		//echo $row['role_id'];
		foreach($row as $value){
			$selected=($value==$roleID)?'selected':'';
			if ($j==0)
				$val.= "<option value=\"$value\" $selected>";
			else
				$val.= "$value</option>";
			$j++;
		}
		$j=0;
	}
	$val.="</select>";
	}
	else
	{
		$val = "<option>No records</option>";
	}
	return $val;
}

function generateListBoxWith2Events($query, $roleID, $controlName,  $className="theInput", $onChange, $onLoad)
{
	//echo $query; die();
	if($className=="")
	{
		$className = "theInput";	
	}
	
	$val = "<select name=\"$controlName\" id=\"$controlName\" class=\"$className\" onChange=\"$onChange;\" onLoad=\"$onLoad;\"><option value=''>Select</option>";
	$rs = mysql_query($query);
	$j=0;
	if(mysql_num_rows($rs) > 0)
	{
	while($row =  mysql_fetch_assoc($rs))
	{
		//echo $row['role_id'];
		foreach($row as $value){
			$selected=($value==$roleID)?'selected':'';
			if ($j==0)
				$val.= "<option value=\"$value\" $selected>";
			else
				$val.= "$value</option>";
			$j++;
		}
		$j=0;
	}
	$val.="</select>";
	}
	else
	{
		$val = "<option>No records</option>";
	}
	return $val;
}

//functions strip slashes

function fix_magic_quotes ($var = NULL, $sybase = NULL)
{
	// if sybase style quoting isn't specified, use ini setting
	if ( !isset ($sybase) )
	{
		$sybase = ini_get ('magic_quotes_sybase');
	}

	// if no var is specified, fix all affected superglobals
	if ( !isset ($var) )
	{
		// if magic quotes is enabled
		if ( get_magic_quotes_gpc () )
		{
			// workaround because magic_quotes does not change $_SERVER['argv']
			$argv = isset($_SERVER['argv']) ? $_SERVER['argv'] : NULL; 

			// fix all affected arrays
			foreach ( array ('_ENV', '_REQUEST', '_GET', '_POST', '_COOKIE', '_SERVER') as $var )
			{
				$GLOBALS[$var] = fix_magic_quotes ($GLOBALS[$var], $sybase);
			}

			$_SERVER['argv'] = $argv;

			// turn off magic quotes, this is so scripts which
			// are sensitive to the setting will work correctly
			ini_set ('magic_quotes_gpc', 0);
		}

		// disable magic_quotes_sybase
		if ( $sybase )
		{
			ini_set ('magic_quotes_sybase', 0);
		}

		// disable magic_quotes_runtime
		//set_magic_quotes_runtime (0);
		if (version_compare(PHP_VERSION, '5.3.0', '<')) {
			$mqr=get_magic_quotes_runtime();
			set_magic_quotes_runtime(0);
		}
		
		if (version_compare(PHP_VERSION, '5.3.0', '<')) {
			set_magic_quotes_runtime($mqr);
		}
		return TRUE;
	}

	// if var is an array, fix each element
	if ( is_array ($var) )
	{
		foreach ( $var as $key => $val )
		{
			$var[$key] = fix_magic_quotes ($val, $sybase);
		}

		return $var;
	}

	// if var is a string, strip slashes
	if ( is_string ($var) )
	{
		return $sybase ? str_replace ('\'\'', '\'', $var) : stripslashes ($var);
	}

	// otherwise ignore
	return $var;
}


/**************************
	2nd Paging Functions 
***************************/

function getPagingQuery2($sql, $itemPerPage = 10)
{
	if (isset($_GET['stage']) && (int)$_GET['stage'] > 0) {
		$stage = (int)$_GET['stage'];
	} else {
		$stage = 1;
	}
	
	// start fetching from this row number
	$offset = ($stage - 1) * $itemPerPage;
	
	return $sql . " LIMIT $offset, $itemPerPage";
}

/*
	Get the links to navigate between one result page to another.
	Supply a value for $strGet if the page url already contain some
	GET values for example if the original page url is like this :
	
	http://www.phpwebcommerce.com/plaincart/index.php?c=12
	
	use "c=12" as the value for $strGet. But if the url is like this :
	
	http://www.phpwebcommerce.com/plaincart/index.php
	
	then there's no need to set a value for $strGet
	
	
*/
function getPagingLink2($sql, $itemPerPage = 10, $strGet = '')
{
	$result        = mysql_query($sql);
	$pagingLink    = '';
	$totalResults  = mysql_num_rows($result);
	$totalPages    = ceil($totalResults / $itemPerPage);
	
	// how many link pages to show
	$numLinks      = 10;

		
	// create the paging links only if we have more than one page of results
	if ($totalPages > 1) {
	
		$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ;
		

		if (isset($_GET['stage']) && (int)$_GET['stage'] > 0) {
			$pageNumber = (int)$_GET['stage'];
		} else {
			$pageNumber = 1;
		}
		
		// print 'previous' link only if we're not
		// on page one
		if ($pageNumber > 1) {
			$stage = $pageNumber - 1;
			if ($stage > 1) {
				$prev = " <a href=\"$self?$strGet&stage=$stage\">Prev</a> ";
			} else {
				$prev = " <a href=\"$self?$strGet\">Prev</a> ";
			}	
				
			$first = " <a href=\"$self?$strGet\">First</a> ";
		} else {
			$prev  = ''; // we're on page one, don't show 'previous' link
			$first = ''; // nor 'first page' link
		}
	
		// print 'next' link only if we're not
		// on the last page
		if ($pageNumber < $totalPages) {
			$stage = $pageNumber + 1;
			$next = " <a href=\"$self?$strGet&stage=$stage\">Next</a> ";
			$last = " <a href=\"$self?$strGet&stage=$totalPages\">Last</a> ";
		} else {
			$next = ''; // we're on the last page, don't show 'next' link
			$last = ''; // nor 'last page' link
		}

		$start = $pageNumber - ($pageNumber % $numLinks) + 1;
		$end   = $start + $numLinks - 1;		
		
		$end   = min($totalPages, $end);
		
		$pagingLink = array();
		for($stage = $start; $stage <= $end; $stage++)	{
			if ($stage == $pageNumber) {
				$pagingLink[] = "<a href='#' class='active'>$stage</a> ";   // no need to create a link to current page
			} else {
				if ($stage == 1) {
					$pagingLink[] = " <a href=\"$self?$strGet\">$stage</a> ";
				} else {	
					$pagingLink[] = " <a href=\"$self?$strGet&stage=$stage\">$stage</a> ";
				}	
			}
	
		}
		
		$pagingLink = implode('  |  ', $pagingLink);
		
		// return the page navigation link
		$pagingLink = $first . $prev . $pagingLink . $next . $last;
	}
	
	return $pagingLink;
}

function encrypt($pure_string) {
    $dirty = array("+", "/", "=");
    $clean = array("_PLUS_", "_SLASH_", "_EQUALS_");
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $_SESSION['iv'] = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $_SESSION['encryption-key'], utf8_encode($pure_string), MCRYPT_MODE_ECB, $_SESSION['iv']);
    $encrypted_string = base64_encode($encrypted_string);
    return str_replace($dirty, $clean, $encrypted_string);
}

function decrypt($encrypted_string) { 
    $dirty = array("+", "/", "=");
    $clean = array("_PLUS_", "_SLASH_", "_EQUALS_");

    $string = base64_decode(str_replace($clean, $dirty, $encrypted_string));

    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $_SESSION['encryption-key'],$string, MCRYPT_MODE_ECB, $_SESSION['iv']);
    return $decrypted_string;
}

function LoginPath()
{

	$val = "Select pagepath from vprivilegedetails where (pagepath is not null or pagepath <>'') and PrivilegeClassID = 1 and StatusID = 1 and employee_id='".GetEmpID()."' order by order_by";
$rs = mysql_query($val);
if (mysql_num_rows($rs)>0)
	return mysql_result($rs,0);
else
	return "home.php?page=unknown";
}
function AuthorisePage($paramValue)
{
	$val = "SELECT * FROM tbl_menuauthorise TMA, tbl_menuparam TMP WHERE param = '$paramValue' and TMP.menuID = TMA.menuID and (PrivilegeID in (".GetAssignedPrivileges(GetEmpID()).") or privilegeID is null)";
	//echo $val;die();
	$rs = mysql_query($val);
	//echo $val;die;
	if (mysql_num_rows($rs)>0)
		return true;
	else
		return false;
	
}

function displayStaffdata()
{
	$sql = "select * from staff";
		//echo $sql; die();
		$query =  mysql_query($sql);
		if (mysql_num_rows($query)<1){
		
		echo "<tr><td><input name='checkall1' id='checkall1' type='checkbox' value='nil'></td><td colspan='6' style='text-align:center;'><b> No record found</b></td></tr>";
		return;
	
		}
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

function getClassArmName($id)
{
	$sql = "select className from classarmsview where IDs = '$id'";
	$thequery = mysql_query($sql);
	$className=mysql_error();
	if($thequery)
	{
		if(mysql_num_rows($thequery) > 0 )
		{
			$row = mysql_fetch_assoc($thequery);
			extract($row);
		}
		else
		{
			$name = "No class Found";	
		}
	}
	return $className;
}

function getCurrentSession()
{
	$sql = "select c_session_id from c_session where isActive = 1";
		//echo $sql; die();
		$query =  mysql_query($sql) or die(mysql_error());
		
			if(mysql_num_rows($query)>0)
			{
				$rs=mysql_fetch_array($query);
				return $rs['c_session_id'];
			}
		return 0;
	
}
function getSectionName($id=0)
{
	$sql = "select * from sections where section_id=$id";
		//echo $sql; die();
		$query =  mysql_query($sql);
		if(mysql_num_rows($query)>0)
		{
			$rs=mysql_fetch_array($query);
			return $rs['section_name'];
		}
		return '';
	
}
?>
