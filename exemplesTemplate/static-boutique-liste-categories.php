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
					
					echo "<ul>";
					
					foreach ($plxMyShop->aProds as $kRubrique => $vRubrique) {
						
						if (	$vRubrique['menu'] === 'non'
							||	$vRubrique['menu'] === ''
							||	(1 !== $vRubrique["active"])
						) {
							continue;
						}
						
						$lien = $plxShow->plxMotor->urlRewrite("index.php?product$kRubrique/{$vRubrique["url"]}");
						
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

