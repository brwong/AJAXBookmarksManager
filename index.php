<html>
<head>
<title>bookmarks</title>
<style type="text/css">
<!--
body {
font-family:myriad,arial,sans-serif;
background-color:#FFFFFF;
}
#tagscol {
width:25%;
//background-color:#DDDDFF;
float:left;
font-size:90%;
}
#tagscol input{
height:11px;
}
#sitescol {
width:75%;
float:right;
//background-color:#DDFFDD;
}
//-->
</style>
<script type="text/javascript" src="desk.js"></script>
</head>
<body>

<h1>TAG-ORGANIZED BOOKMARKS</h1>
<form>
<a onclick="showaddmark()">add new bookmark<a/><br />
<div id="addnewmark" style="display:none;">
name: <input type="text" /><br />
link: <input type="text" /><br />
descr: <input type="text" /><br />
</div>
</form>
<hr width="90%" />

<?php
$xml = simplexml_load_file('locations.xml');
$tags = $xml->tags->tag;
//$locs = $xml->locations->loc;

echo '<div id="sitescol">';
echo '<div id="statusbar">status over here<hr width="50%" align="left" /></div>';
echo '<div id="sites">sites go here</div>';
echo '</div>';

echo '<div id="tagscol">';
echo "<span>TAGS</span><br />\n";
echo '<button onclick="check_all(true)">all</button> ';
echo '<button onclick="check_all(false)">none</button><br />';
echo '<button onclick="check_all(false, \'all=true\')">all bookmarks</button><br />';
echo '<button onclick="check_all(false, \'all=untrue\')">all unmarked</button>';
echo '<div id="tags">';
$alltags = Array();
foreach($tags as $tag){
	$alltags[] = $tag.'';
}
natcasesort($alltags);
foreach($alltags as $tag){
	echo '<input type="checkbox" onclick="pony()" id="'.$tag.'" /> ' . str_replace('_', ' ', $tag) . "<br />\n";
}
echo '</div>';
echo '<button onclick="check_all(true)">all</button> ';
echo '<button onclick="check_all(false)">none</button>';
echo '<br /><br /></div><br /><br />';

?>


</body>
</html>