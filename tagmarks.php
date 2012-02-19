<html>
<head>
<title>tagging bookmarks</title>
<script type="text/javascript">
<!--
function loadtags(tid){
	taglist = document.getElementById('t'+tid);
	thelist = Array();
	if(taglist.value){thelist = taglist.value.split(";");}
	alltags = document.getElementById('rightside').getElementsByTagName('input');
	for(var i=0;i<alltags.length;i++){
		found = false;
		for(var j=0;j<thelist.length;j++){
			if(alltags[i].id == thelist[j]){
				found = true;
				break;
			}
		}
		alltags[i].checked = found;
	}
	document.getElementById('now').innerHTML = document.getElementById('name'+tid).value+'<br />'+document.getElementById('ref'+tid).value+'<br />';
}

function hider(what){
	if(what.checked){
	document.getElementById(what.name).style['display'] = 'none';
	}
	else{
	document.getElementById(what.name).style['display'] = '';
	}
}
//-->
</script>
</head>
<body>
<?php
if(count($_POST)){
	$oldxml = simplexml_load_file('locations.xml');
	foreach($oldxml->locations->loc as $place){
		$gotmarks = Array();
		foreach($_POST as $add=>$what){
			if(substr($add,2).''==$place['id'].''){
				$gotmarks[] = ltrim(substr($add,0,2),'0');
			}
			elseif(substr($add,0,4).''=='done' and substr($add,4).''==$place['id'].''){
				if(file_exists('donesites.txt')){$old = file_get_contents('donesites.txt');}
				else{$old = '';}
				if(!strstr($old,$place['id'])){
					if($place->name){$old .= $place->name . "\t";}
					$old .= $place['id'] . "\n";
					file_put_contents('donesites.txt', $old);
				}
			}
		}
		if(count($gotmarks)){
			$tags_to_place = '';
			for($i=0;$i<count($gotmarks);$i++){
				$tags_to_place .= $gotmarks[$i].'';
				if($i!=count($gotmarks)-1){
					$tags_to_place .= ';';
				}
			}
			if($place->t){
				$place->t = $tags_to_place;
			}
			else{
				$place->addChild('t', $tags_to_place);
			}
		}
		
	}
	file_put_contents('locations.xml', $oldxml->asXML());
	echo 'your tags have been successfully saved.<br />';
}
?>
<form action="tagmarks.php" method="POST">
<input type="submit" value="save" />
<div style="width:50%;float:left;">
<pre><!--<textarea cols="60" rows="100" nowrap="true">-->
<?php
$xml = simplexml_load_file('locations.xml');
$done = '';
if(file_exists('donesites.txt')){$done = file_get_contents('donesites.txt');}
$counting = 0;
foreach($xml->locations->loc as $l){
	if($counting > 20){break;}
	if($l['id']){
	if(strstr($done,$l['id'].'')){continue;}
		echo '<input type="radio" name="which" value="'.$l['id'].'" onclick="loadtags(\''.$l['id'].'\')" /> ';
		echo 'id= '.$l['id'];
	}
	else{
		echo 'id=!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
		$l['id']='wololo';
	}
	if(strstr($done,$l['id'].'')){
		echo ' <input type="checkbox" checked="checked" name="done'.$l['id'].'" onclick="hider(this)" />'."\n";
		echo '<span id="done'.$l['id'].'" style="display:none;">';
	}
	else{
		echo ' <input type="checkbox" name="done'.$l['id'].'" onclick="hider(this)" />'."\n";
		echo '<span id="done'.$l['id'].'">';
		$counting++;
	}
	echo 'name= <input type="text" style="width:75%;" name="name'.$l['id'].'" id="name'.$l['id'].'" value="';
	if($l->name){echo $l->name;}
	echo '" />'."\n";
	echo 'href= <input type="text" style="width:75%;" name="ref'.$l['id'].'" id="ref'.$l['id'].'" value="';
	if($l->ref){echo $l->ref;}
	echo '" />'."\n";
	echo 'descr=<textarea style="width:75%;" rows="3">';
	if($l->descr){echo $l->descr;}
	echo "</textarea>\n";
	echo 'tags= <input type="text" style="width:50%;" name="t'.$l['id'].'" id="t'.$l['id'].'" value="';
	if($l->t){echo $l->t;}
	echo '" />'."\n";
	echo "----------------\n</span>";
}
?>
<!--</textarea>--></pre>
</div>
<div id="rightside">
<div id="now">
still something else<br />yeaaaahhhh!!!<br />and here.
</div>
<hr /><br />
<div style="float:left;">
<?php
$tagcount = 0;
$onethird = count($xml->tags->tag)/3;
settype($onethird, 'int');
foreach($xml->tags->tag as $t){
	echo '<input type="checkbox" id="'.$t['id'].'" />'.$t.'<br />';
	$tagcount++;
	if($tagcount==$onethird || $tagcount==2*$onethird){
		echo '</div><div style="float:left;">';
	}
}
?>
</div>
</div>
<br />
<input type="submit" value="save" /><br />
</form>
</body>
</html>