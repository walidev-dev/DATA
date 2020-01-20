<ul class="pagination" style="padding-top:8px">
    <?php for ($i = 1; $i <= $paginatedQuery->getPagesCount(); $i++) : ?>
        <li class="page-item <?php if ($paginatedQuery->getCurrentPage() === $i) echo 'active' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
    <?php endfor ?>
</ul>

<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink() ?>
    <?= $paginatedQuery->nextLink() ?>
</div>











<!-- <li class="page-item active"><a class="page-link" href="#">2</a></li> -->