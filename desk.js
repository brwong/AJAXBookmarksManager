function washcycle(){
	var xmltp;
	try{xmltp=new XMLHttpRequest();}
	catch(e){
		try{xmltp = new ActiveXObject("Msxml2.XMLHTTP");}
		catch(e){
			try{xmltp = new ActiveXObject("Microsoft.XMLHTTP");}
			catch(e){
				alert("Your browser does not support this particular AJAX-based page.");
				return false;
			}
		}
	}
	return xmltp;
}

function pony(argu){
	xmltp = washcycle();
	xmltp.onreadystatechange = function(){
		if(xmltp.readyState==4){//0-The request is not initialized, 1-The request has been set up, 2-The request has been sent, 3-The request is in process, 4-The request is complete
			document.getElementById('sites').innerHTML = xmltp.responseText;
			document.getElementById('statusbar').innerHTML = '';
		}
		else{
			document.getElementById('statusbar').innerHTML = 'retrieving links...<hr width="50%" align="left" />';
		}
	}
	place = "librarian.php?ha=ha&";// AJAX SERVER
	if(argu){
		place += argu;
	}
	else{
		place += "tags=fbes";
		is = document.getElementById('tags').getElementsByTagName('input')
		for(var i=0; i<is.length; i++){
			if(is[i].checked){
				place += '+'+is[i].id;
			}
		}
	}
	xmltp.open("GET", place, true);
	xmltp.send(null);
}

function check_all(on_or_off, arrg){
	is = document.getElementById('tags').getElementsByTagName('input')
	for(var i=0; i<is.length; i++){
		is[i].checked = on_or_off;
	}
	pony(arrg);
}

function showaddmark(){
	am = document.getElementById('addnewmark').style;
	if(am.display=='none'){
		am.display = '';
	}
	else{
		am.display = 'none';
	}
}

function test(){
	document.getElementById('statusbar').innerHTML = this;
}

function siteoptioncheck(){
	atleastone = false;
	allchecks = document.getElementById('sitesoptions').getElementsByTagName('input')
	for(var i=0; i<allchecks.length; i++){
		if(allchecks[i].checked){atleastone = true;break;}
	}
	if(atleastone){//show options bar
		optbar = 'apply tag: <select></select> <button>delete</button><br />';
		document.getElementById('upperoptions').innerHTML = document.getElementById('loweroptions').innerHTML = optbar;
	}
	else{//show options bar
		document.getElementById('upperoptions').innerHTML = document.getElementById('loweroptions').innerHTML = '';
	}
}