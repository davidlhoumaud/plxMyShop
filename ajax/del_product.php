<?php session_start();
if (isset($_SESSION['prods']) && isset($_POST['pid']) && !isset($_POST['killcartsession'])) {
    $prods=array();
    $ncart=0;
    $accessproduct=true;
    foreach ($_SESSION['prods'] as $k => $v) {
        $prodtmp=str_pad($_SESSION['prods'][$k],3,"0",STR_PAD_LEFT);
        if ( ($prodtmp!=$_POST['pid']) || ($prodtmp==$_POST['pid'] && !$accessproduct) ){
            $prods[]=$_SESSION['prods'][$k];
            $ncart++;
        } else if ($prodtmp==$_POST['pid'] && $accessproduct) {
            $accessproduct=false;
        }
    }
    unset($_SESSION['prods']);
    unset($_SESSION['ncart']);
    $_SESSION['prods']=$prods;
    $_SESSION['ncart']=$ncart;

} else if (isset($_SESSION['prods']) && !isset($_POST['pid']) && isset($_POST['killcartsession'])) {
    unset($_SESSION['prods']);
    unset($_SESSION['ncart']);
}
?>
