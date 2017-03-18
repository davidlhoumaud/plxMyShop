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

                if (isset($plxMyShop->aProds) && is_array($plxMyShop->aProds)) {
				echo $plxMyShop->aProds[ $plxMyShop->productNumber()]['name'];

                    foreach ($plxMyShop->aProds as $k1 => $v1) {
							if ($v1['pcat'] == 1 && $v1['menu'] =='oui') {
							$cat_array[$k1] = $v1['name']; # can only get the name of a category
							}
					}

					foreach($cat_array as $k1 => $v1){
						echo '<h1 class="title_icon">'.$v1.'</h1>';
						$plxMyShop->idProduit = $k1;
 						$plxMyShop->plxShowProductContent();
						#Now we display a nice name of the categorie....
						foreach($plxMyShop->aProds as $k => $v) {
							if (	$v['group'] == $k1
								&& $v['pcat']  !=1 
								&&	$v['active']==1 
								&&	$v['readable']==1
							) {				
								$plxMyShop->donneesModeles["k"] = $k;
								$plxMyShop->modele("espacePublic/boucle/produitRubrique");
								
							}
						}
					}


                }




			?>
			
		</section>

	</main>

<?php include(dirname(__FILE__).'/footer.php'); ?>

