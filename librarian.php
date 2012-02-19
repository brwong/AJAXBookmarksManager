<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");// Date in the past
$master_out = '';

// PLACE CODE HERE \/ \/ \/ \/ \/ \/

$xml = simplexml_load_file('locations.xml');
$tags = $xml->tags->tag;
$locs = $xml->locations->loc;


function format_link($link){// DEAL WITH SLASHES
	$output = '';
	$output .= '<input type="checkbox" id="'.$link['id'].'" onclick="siteoptioncheck()" /> ';// FOR EVENTUAL OPTION OF EDITING LINKS
	$output .= '<a href="'.$link->ref.'" target="_blank">';
	if(isset($link->name)){$output .= $link->name;}
	else{$output .= $link->ref;}
	$output .= '</a> <span style="font-size:60%;" onclick="">edit</span> ';
	if(isset($link->descr)){$output .= '<br /><div style="padding-left:50px;">'.$link->descr.'</div>';}// "DICTIONARY"-LIKE APPEARANCE?
	else{$output .= "<br />\n";}
	return $output;
}

$master_out .= '<span id="upperoptions"></span><span id="sitesoptions">';

if($_GET['ha']!='ha'){
	exit("there's nothing here to see. go back.");
}

if($_GET['all']=='true'){//all sites
	$master_out .= "All sites: <br />\n";
	$count = 0;
	foreach($locs as $site){
		$master_out .= format_link($site);
		$count++;
	}
	$master_out .= '<br />' . $count . ' site(s).<br /><br />';
	//exit($master_out);
}
elseif($_GET['all']=='untrue'){//all untagged sites - IS THIS NECESSARY?
	$master_out .= "All untagged sites: <br />\n";
	$count = 0;
	foreach($locs as $site){
		if(!isset($site->t)){
			$master_out .= format_link($site);
			$count++;
		}
	}
	$master_out .= '<br />' . $count . ' site(s).<br /><br />';
	//exit($master_out);
}
else{//all sites with selected tags
	$master_out .= "All sites matching the keyword(s): ";
	// get the wanted tags
	$all_wanted = array();
	foreach(explode(' ', $_GET['tags']) as $wanted){
		if($wanted=='fbes'){continue;}
		$master_out .= $wanted . ' ';
		foreach($tags as $tag){
			if($wanted==$tag){
				array_push($all_wanted, $tag['id']);
			}
		}
	}
	$master_out .= "<br /><br />\n";
	// search the locations that match all the wanted tags
	if($all_wanted){
		$count = 0;
		foreach($locs as $loc){
			$got_all = true;
			foreach($all_wanted as $check){
				if(!in_array($check, explode(';',$loc->t))){
					$got_all = false;
					break;
				}
			}
			if($got_all && isset($loc->ref)){
				$master_out .= format_link($loc);
				$count++;
			}
		}
		$master_out .= '<br />' . $count . ' site(s).<br />';
	}
}

$master_out .= '</span><span id="loweroptions"></span><br /><br />';

// END OF CODE /\ /\ /\ /\ /\ /\ /\

echo $master_out;
?>