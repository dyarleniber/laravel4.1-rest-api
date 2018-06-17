<?php

	$presenter = new PaginationController($paginator);

?>

<?php

	if ($paginator->getLastPage() > 1) {

?>

	<ul class="pagination justify-content-center">
		<?php echo $presenter->render(); ?>
	</ul>

<?php

	}

?>