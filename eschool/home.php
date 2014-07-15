<?php
if(!isset($_SESSION))session_start();
include("includes/connections.php");
include("includes/functions.php");
//fix_magic_quotes ($var = NULL, $sybase = NULL);
/*if(!isset($_SESSION['user']))// block unauthorized access
{
	$_SESSION['msg']="<font color='#FF0000' style='font-size:14px;'>Unauthorized access, please login</font>";
	header("Location:index.php");
}*/

//check autentication

$menu = (isset($_GET['menu']) && $_GET['menu'] != '') ? $_GET['menu'] : '';
$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : '';

//checking authorise privilege
/*if(!AuthorisePage($page))
{
	session_destroy();
	session_start();
	$_SESSION['msg']="<font color='#FF0000' style='font-size:14px;'>Unauthorized access, please contact admin</font>";
	header("Location:index.php");exit;
}*/
//fetching page url
	$content 	= '404.php';		
	$pageTitle 	= '';
	$headMsg="";

$sql="select * from tbl_paramurl where param='$page'";
$rest=mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($rest) <1)// checking to see if page parameter does not exist in database
{
	$content 	= '404.php';		
	$pageTitle 	= 'Page not found - School Management Software';
	$headMsg="Page not found ";
	
}else// page exist
{
	$val=mysql_fetch_array($rest);
	//extract($val);
	$isActive=$val['activeID'];
	if($isActive!=1)//if page has been disable
	{
		$headMsg="Page not found [Page has has been disable]";
	}else //page exist
	{
		$paramID=$val['paramID'];
		$content 	= $val['url'];		
		$pageTitle 	= $val['title'];
		$headMsg=$val['header_message'];
		
	}
	
	
}

  include("includes/pages/header.php");
   include("includes/pages/nav.php");
 ?>
<div class="art-layout-cell art-content"><article class="art-post art-article">
          <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon" style="color:#169CE3; font-weight:bold"> 
								
                                 <span>  <?php  echo isset($headMsg)?$headMsg:" "; ?> </span>
                                 </h2>		
										
                                    </div>                      
                                                
                
<?php
  include("includes/pages/$content");
 ?>

</article></div>
                    </div>
                </div>
            </div>
    </div>


</div>
<?php
  include("includes/pages/footer.php");
 ?>

</body></html>