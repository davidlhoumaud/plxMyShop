<?php if (!defined('PLX_ROOT')) exit; ?>

<?php include(dirname(__FILE__) . '/header.php'); ?>
 <main class="main grid" role="main">
  <section class="col sml-12">
   <article class="article static" role="article" id="static-page-<?php echo $plxShow->staticId(); ?>">
    <header>
     <h1>
      <?php $plxShow->staticTitle(); ?>
     </h1>
    </header>
    <section>
     <?php $plxShow->staticContent(); ?>
    </section>
   </article>
  </section>
  <section class="col sml-12">
<?php
    $plxMyShop = $plxShow->plxMotor->plxPlugins->aPlugins['plxMyShop'];
    $plxMyShop->donneesModeles["plxPlugin"] = $plxMyShop;

    if (isset($plxMyShop->aProds[$plxMyShop->default_lang]) && is_array($plxMyShop->aProds[$plxMyShop->default_lang])) {
     echo "<ul>";
     foreach ($plxMyShop->aProds[$plxMyShop->default_lang] as $kRubrique => $vRubrique) {
      if ( $vRubrique['menu'] === 'non' || $vRubrique['menu'] === '' || (1 !== $vRubrique["active"])) {
       continue;
      }
      $lien = $plxShow->plxMotor->urlRewrite("?".$plxMyShop->lang."product$kRubrique/{$vRubrique["url"]}");
?>
       <li>
        <a href="<?php echo htmlspecialchars($lien);?>">
         <?php echo htmlspecialchars($vRubrique['name']);?></a>
       </li>
<?php
     }
     echo "</ul>";
    }
?>
  </section>
 </main>
<?php include(dirname(__FILE__).'/footer.php'); ?>