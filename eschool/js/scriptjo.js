function nextTerm()
{	
		if (!confirm("You are about to close the current term and move to a new term.\nPlease note that this process can not be reversed.\nAre you sure you want to proceed?"))
		{
			return false;
		}
		
		if(window.XMLHttpRequest){
			xmlhttp1 = new XMLHttpRequest();
		}else{
			xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp1.onreadystatechange = function(){
			if(xmlhttp1.readyState==4 && xmlhttp1.status==200){
				//document.getElementById('update_name').innerHTML="Loading...";
				document.getElementById('tableDiv').innerHTML =xmlhttp1.responseText;
				//alert('aaa');
			}else{
				document.getElementById('tableDiv').innerHTML="Loading...<img src='../../images/ajaxLoading.gif' />";
			}
		}
		xmlhttp1.open("GET","nextterm.php",true);
		xmlhttp1.send();
		//return false;	
	}	

