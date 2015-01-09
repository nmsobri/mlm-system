<?php $presenter = new \Mlm\Libs\Pagination\MlmPresenter($paginator); ?>

@if ($paginator->getLastPage() > 1)

<ul class="pagination alternate">
    <?php echo $presenter->render(); ?>
</ul>

@endif