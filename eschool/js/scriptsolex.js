function getState(cod,cod2)
{
	
	country=document.getElementById('country');
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('state').innerHTML="";
			document.getElementById('state').innerHTML = xmlhttp.responseText;
			getLGA(cod2);
			if(country.value.toLowerCase()=="")
			{
				document.getElementById('state').disabled="Disabled";
			}else
			{
				document.getElementById('state').disabled="";
			}
			
		}else{
			document.getElementById('state').disabled="Disabled";
 			document.getElementById('state').innerHTML="<option value=''>Loading...</option>";
		}
	}
	 //
	xmlhttp.open("GET","getState.php?country="+country.value+"&cod="+cod,true);
	xmlhttp.send();
	
	return false;
}
function getLGA(cod)
{
	state=document.getElementById('state');
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('lga').innerHTML="";
			document.getElementById('lga').innerHTML = xmlhttp.responseText;
			if(state.value.toLowerCase()=="")
			{
				document.getElementById('lga').disabled="Disabled";
			}else
			{
				document.getElementById('lga').disabled="";
			}
			
		}else{
			document.getElementById('lga').disabled="Disabled";
 			document.getElementById('lga').innerHTML="<option value=''>Loading...</option>";
		}
	}
	 //
	xmlhttp.open("GET","getLGA.php?state="+state.value+"&cod="+cod,true);
	xmlhttp.send();
	
	
	 
	return false;
}




function deleteUser()
{
	
	
table = document.getElementById('deleteUserTable');

if(document.getElementById('checkall1').value=='nil')
{
	alert("No item to be deleted"); return false;
}
	rowCount=table.rows.length-1;
	//alert(rowCount);return false;
	val="0";//alert('avda'); return false;
	flip=0;	
	for(i=1; i<rowCount; i++)
	{
		
		if(document.getElementById('checkall'+i).checked==true)
		{
			val+=","+document.getElementById('checkall'+i).value;
			flip=1;	
		}
	}
	if(flip==0)// means no item was checked to be deleted
	{
		alert("select atleast one item to delete"); return false;
	}
	else
	{
		if (!confirm("Are you sure you want to delete this selected item(s)"))
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
				table.innerHTML =xmlhttp1.responseText;
				//alert('aaa');
			}else{
				table.innerHTML="Loading...<img src='images/load.gif' />";
			}
		}
		xmlhttp1.open("GET","deleteUser.php?userIDs="+val,true);
		xmlhttp1.send();
		return false;
		
	}
	//alert(rowCount);return false;
	alert(val); return false;
}

function getDependents(id,value,url)
{
	
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(id).innerHTML="";
			document.getElementById(id).innerHTML = xmlhttp.responseText;
			
			if(value.toLowerCase()=="")
			{
				document.getElementById(id).disabled="Disabled";
			}else
			{
				document.getElementById(id).disabled="";
			}
			
		}else{
			document.getElementById(id).disabled="Disabled";
 			document.getElementById(id).innerHTML="<option value=''>Loading...</option>";
		}
	}
	 //
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	
	return false;
}