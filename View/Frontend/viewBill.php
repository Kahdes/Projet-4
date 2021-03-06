<?php $this->title = "Billet simple pour l'Alaske : billet"; ?>
<?php $this->description = "Découvrez l'histoire du dernier livre de Jean Forteroche : 'Billet simple pour l'Alaska' au travers de ce billet"; ?>

<section class="row bill">
	<article class="col-xs-12">
		<?php
			foreach($bill as $b) {
		?>
				<h1 class="panel-heading" id="bill-title">
					<?= $b['titre'];?>					
				</h1>

				<p id="bill-date">
					<em>
						Publié le : <?= $b['dateFR'];?>
					</em>
				</p>

				<hr/>
				
				<div class="panel-body" id="bill-body">
					<?= $b['contenu'];?>
				</div>
				
				<div id="bill-pagination">
					<ul class="pagination">

			<?php
				$count = 1;
				foreach ($list as $l) {
					if ($l['id'] === $_GET['id']) {
			?>
						<li id="bill-<?=$l['id'];?>">
							<a id="bill-active" href="index.php?action=bill&amp;id=<?= $l['id'];?>" title="Vers '<?=$l['titre'];?>'"><?=$count;?></a>
						</li>
			<?php
					} else {
			?>
						<li id="bill-<?=$l['id'];?>">
							<a href="index.php?action=bill&amp;id=<?= $l['id'];?>" title="Vers '<?=$l['titre'];?>'"><?=$count;?></a>
						</li>
			<?php
					}
				$count++;
				} 
			?>
					</ul>
				</div>				
		<?php
			}
		?>
	</article>
</section>

<?php require_once('View/Frontend/addComments.php'); ?>
<?php require_once('View/Frontend/comments.php'); ?>