<?php

function scanDirImage($dir,$subdir) {
    $dh  = opendir($dir);
    $str="";
    while (false !== ($filename = readdir($dh))) {
        if (is_dir($dir.$filename)) {
            if ($filename!='.' && $filename!='..' && $filename!='.thumbs') {
                $str.=  "<p onclick=\\'if(document.getElementById(\"".$filename."\").style.display==\"none\") document.getElementById(\"".$filename."\").style.display=\"block\"; else document.getElementById(\"".$filename."\").style.display=\"none\";\\' style=\\'padding:3px;border:1px solid #999;background-color:#dfdfdf;cursor:pointer;\\'>".$filename."&nbsp;&rsaquo;".
                "<div id=\\'".$filename."\\' style=\\'display:none;\\'>".scanDirImage($dir.$filename."/",$subdir.$filename."/")."</div>".
                "</p>";
            }
        } else {
            if ($filename!='.thumbs') {
                $str.= "<p><img onclick=\\'selectImage(\"data/images/".$subdir.$filename."\");\\' style=\\'width:150px;height:auto;cursor:pointer;\\' src=\\'http://".$_SERVER['HTTP_HOST']."/data/images/".$subdir.$filename."\\'></p>";
            }
        }
    }
    return $str;
}
$html= '<h1 style="text-align:center;font-weight:bold;">S&eacute;lectionner une image de pr&eacute;sentation</h1>';
$html.=scanDirImage('../../../data/images/','');
$html.= "<span style=\\'position:fixed;top:400px;width:590px;text-align:center;padding:3px;border:1px solid #999;background-color:#dfdfdf;cursor:pointer;\\' onclick=\\'block_select_image.style.display=\"none\";\\'>Fermer</span>";
echo "document.getElementById('block_select_image').innerHTML='".$html."';
document.getElementById('block_select_image').style.display=\"block\";";
?>
