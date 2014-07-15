<?php
if(!isset($_SESSION))session_start();
include("includes/connections.php");
//include("includes/functions.php");
$username="";
$password="";

if(isset($_POST['login']))
{
	
	$username=trim($_POST['username']);
	$password=$_POST['password'];
	
	if($username=="")
	{
		$msg="<font color='#FF0000' style='font-size:14px;'>Username cannot be empty</font>";
	}else if($password=="")
	{
		$msg="<font color='#FF0000' style='font-size:14px;'>Password cannot be empty</font>";
	}else
	{
		$sql="select * from fwnusers where email='$username' and password='".md5($password)."'";
		$rs=mysql_query($sql) or die(mysql_error());
		
		if(mysql_num_rows($rs)<1)
		{
			$msg="<font color='#FF0000' style='font-size:14px;'>Invalid username or/and password</font>";
		}
		else 
		{
			$result=mysql_fetch_assoc($rs);
			if($result['activeID']!=1)
			{
				$msg="<font color='#FF0000' style='font-size:14px;'>Sorry, your account has been disabled by admin</font>";
			}elseif(!ValidateLoginActivity($result["UserID"]))
			{

				$msg="<font color='#FF0000' style='font-size:14px;'>You are not authorised to use this application</font>";
			}
			
			else
			{
				$_SESSION['user']=$result;
				//header("Location: ". LoginPath());exit;
			}
		}
		
	}
}

?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US"><head><!-- Created by Artisteer v4.1.0.60046 -->
    <meta charset="utf-8">
    <title>Home</title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">

    <!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="css/style.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="style.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="css/style.responsive.css" media="all">
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Quattrocento+Sans&amp;subset=latin">


    <script src="js/jquery.js"></script>
    <script src="js/script.js"></script>
    <script src="js/script.responsive.js"></script>



<style>.art-content .art-postcontent-0 .layout-item-0 { border-top-width:1px;border-top-style:solid;border-top-color:#C0BAC5;margin-top: 10px;margin-bottom: 10px;  }
.art-content .art-postcontent-0 .layout-item-1 { padding-right: 10px;padding-left: 10px;  }
.ie7 .art-post .art-layout-cell {border:none !important; padding:0 !important; }
.ie6 .art-post .art-layout-cell {border:none !important; padding:0 !important; }

</style></head>
<body>
<div id="art-main">
<header class="art-header">

    <div class="art-shapes">
        <div class="art-object1933869376" data-left="97.53%"></div>
<div class="art-object1660401362" data-left="100%"></div>
<div class="art-object1478666302" data-left="0.87%"></div>

            </div>

<h1 class="art-headline" data-left="55.15%">
    <a href="#">Electronic School Manager</a>
</h1>
<h2 class="art-slogan" data-left="64.39%">Powered by Wave Matrix</h2>





                        
                    
</header>
<nav class="art-nav">
    <div class="art-nav-inner">
    <ul class="art-hmenu"><li><a href="home.html" class="active">Home</a><ul class="active"><li><a href="home/new-page.html">Subpage 1</a></li><li><a href="home/new-page-2.html">Subpage 2</a></li><li><a href="home/new-page-3.html">Subpage 3</a></li></ul></li><li><a href="blog.html">Blog</a></li></ul> 
        </div>
    </nav>
<div class="art-sheet clearfix">
            <div class="art-layout-wrapper">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-sidebar1"><div class="art-vmenublock clearfix">
        <div class="art-vmenublockheader">
            <h3 class="t">VMenu</h3>
        </div>
        <div class="art-vmenublockcontent">
<ul class="art-vmenu"><li><a href="home.html" class="active">Home</a><ul class="active"><li><a href="home/new-page.html">Subpage 1</a></li><li><a href="home/new-page-2.html">Subpage 2</a></li><li><a href="home/new-page-3.html">Subpage 3</a></li></ul></li><li><a href="blog.html">Blog</a></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content">
                        <article class="art-post art-article">
                                
                                                
              
        
        <fieldset  class="content-fieldset" style=" margin:auto; width:40%;  ">
            <legend style="font-size:18px; font-weight:bolder;">:: Login Details</legend>
            <form action="" method="post" name="loginForm">
            <table border="0" style=" border:none;" class="login-table">
            <tr>
           
            <td colspan="3" style="text-align:right">
			<?php echo isset($msg)?$msg:"&nbsp; ";
	 if(isset($_SESSION['msg'])){
		 echo $_SESSION['msg'];
		 unset($_SESSION['msg']);
		 }
	 ?></td>
            </tr>
            
            <tr><td rowspan="3" style="width:30%;">
            <img src="images/key.fw.png" style="width:90%;border:none; margin:auto;">
            </td>
            <td>Username:</td>
            <td><input type="text" name="username" id="username" value="<?php echo isset($username)?$username:''; ?>" /></td>
            </tr>
            <tr>
            <td>Password:</td>
            <td><input type="password" name="password" id="password" /></td>
            </tr>
             <tr>
           
            <td>&nbsp;</td> <td style="text-align:right"> <input type="submit" name="login" value="Login" class="art-button" /></td>
            </tr>
            </table>
            </form>
            <br><br>
            </fieldset>
    



</article></div>
                    </div>
                </div>
            </div>
    </div>
<footer class="art-footer">
  <div class="art-footer-inner">
<p><a href="#">Link1</a> | <a href="#">Link2</a> | <a href="#">Link3</a></p>
<p>Copyright © 2014. All Rights Reserved.</p>
    <p class="art-page-footer">
        <span id="art-footnote-links"><a href="http://www.artisteer.com/" target="_blank">Web Template</a> created with Artisteer.</span>
    </p>
  </div>
</footer>

</div>


</body></html>