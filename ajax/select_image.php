<?php


if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION["plxMyShop"]["cheminImages"])) {
	exit();
}

function scanDirImage($dir, $subdir, $base) {
	$dh  = opendir("$base$dir");
	$str = "";
	
	while (false !== ($filename = readdir($dh))) {
		
		if (in_array($filename, array(".", "..", ".thumbs"))) {
			continue;
		}
		
		if (is_dir("$base$dir/$filename")) {
			$str.=  "<p onclick=\\'if(document.getElementById(\"$filename\").style.display==\"none\") document.getElementById(\"$filename\").style.display=\"block\"; else document.getElementById(\"$filename\").style.display=\"none\";\\' style=\\'padding:3px;border:1px solid #999;background-color:#dfdfdf;cursor:pointer;\\'>$subdir/$filename&nbsp;&rsaquo;".
			"<div id=\\'$filename\\' style=\\'display:none;\\'>"
				.scanDirImage("$dir/$filename", "$subdir/$filename", $base)
				."</div>".
			"</p>";
		} else {
			$str.= "<p><img onclick=\\'selectImage(\"$dir/$filename\");\\' style=\\'width:150px;height:auto;cursor:pointer;\\' src=\\'{$_SESSION["plxMyShop"]["urlImages"]}$dir/$filename\\'></p>";
		}
	}
	
	return $str;
}

$html  = '<h1 style="text-align:center;font-weight:bold;">S&eacute;lectionner une image de pr&eacute;sentation</h1>';
$html .= scanDirImage("", "", $_SESSION["plxMyShop"]["cheminImages"]);
$html .= "<span style=\\'position:fixed;top:400px;width:590px;text-align:center;padding:3px;border:1px solid #999;background-color:#dfdfdf;cursor:pointer;\\' onclick=\\'block_select_image.style.display=\"none\";\\'>Fermer</span>";

echo "document.getElementById('block_select_image').innerHTML='".$html."';
document.getElementById('block_select_image').style.display=\"block\";";
