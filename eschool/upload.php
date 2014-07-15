<?php
if (isset($_FILES['image']['name']))
 {
sleep(1);

	$ftmp = $_FILES['image']['tmp_name'];
	$oname = $_FILES['image']['name'];

	$extension = pathinfo($_FILES['image']['name']);
	$extension = strtolower($extension["extension"]);
	$allowed_ext = 'jpg, jpeg, gif, png, bmp';
	$max_weight = 50*1024;
	$filename = time();
	$pixPath = "";
	$allowed_paths = explode(", ", $allowed_ext);
	$valid = 0;
	for($i = 0; $i < count($allowed_paths); $i++) {
		if ($allowed_paths[$i] == "$extension") {
			$valid = 1;
		}
	}
	//$check=
	if ($valid == 1 && $_FILES["image"]["size"] <= $max_weight) {
				$pixPath = "images/upload/".$filename.".".$extension;
	}
	

	$extenssion = strstr($oname, ".");
	$fname = ''.$_FILES['image']['name'];
	//$check=
		if($pixPath!="" && move_uploaded_file($_FILES["image"]["tmp_name"],$pixPath)){
			?>
			<html><head><script type="text/javascript">
			var par = window.parent.document;
			var images = par.getElementById('images1');
			var imgdiv = images.getElementsByTagName('div')[<?php echo (int)$_POST['imgnum']?>];
			var image = imgdiv.getElementsByTagName('img')[0];
			imgdiv.removeChild(image);
			
			par.getElementById('imgnumber').value="<?php echo $pixPath?>";
			//alert(par.getElementById('imgnumber').value);
			
			var image_new = par.createElement('img');
			image_new.src = '<?php echo $pixPath?>';
			image_new.setAttribute('width',100);
			image_new.className = 'loaded';
			
			imgdiv.appendChild(image_new);
  </script></head>
			</html>
<?php
exit();
}else if(isset($_FILES["image"]["tmp_name"]) && $pixPath==""){
?>
<html><head><script type="text/javascript">
			var par = window.parent.document;
			var images = par.getElementById('images1');
			var imgdiv = images.getElementsByTagName('div')[<?php echo (int)$_POST['imgnum']?>];
			var image = imgdiv.getElementsByTagName('img')[0];
			imgdiv.removeChild(image);
			
			par.getElementById('imgnumber').value="";
			
			var image_new = par.createElement('img');
			image_new.src = '<?php echo "images/invalidimg.png"?>';
			image_new.setAttribute('width',100);
			image_new.className = 'loaded';
			
			imgdiv.appendChild(image_new);
  </script></head>
			</html>
<?php
exit();
}
 }
?>
        <html><head>
<script type="text/javascript">
function upload(){
// hide old iframe
	var par = window.parent.document;
	var num = par.getElementsByTagName('iframe').length - 1;
	var iframe = par.getElementsByTagName('iframe')[num];
	iframe.className = 'hidden';
	//par.getElementById('iframe').removeChild(iframe);

	// create new iframe
	var new_iframe = par.createElement('iframe');
	new_iframe.src = 'upload.php';
	new_iframe.frameBorder = '2';
	par.getElementById('iframe').appendChild(new_iframe);
	//par.getElementById('iframe').height='30';// maintain height of frame
	//par.getElementById('iframe').style.overflow='scroll';
	par.getElementById('iframe').style.height='';
	//par.getElementById('iframe').style.width='200px';
	//par.getElementById('iframe').scrollTop='';
	// add image progress
	var images = par.getElementById('images1');
	var oldDivs = images.getElementsByTagName('div')[0];
	images.removeChild(oldDivs);
	var new_div = par.createElement('div');
	var new_img = par.createElement('img');
	new_img.src = 'images/indicator.gif';
	new_img.className = 'load';
	new_div.appendChild(new_img);

	images.appendChild(new_div);

	var imgnum = images.getElementsByTagName('div').length - 1;
	document.iform.imgnum.value = imgnum;
	setTimeout(document.iform.submit(),5000);
}
</script>
<style>
#file {
	width: 250px;
}   
</style>
<head><body> 
<form name="iform" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="imgnum" /> <input id="file" type="file" name="image" onChange="upload();" />

</form></body></html>