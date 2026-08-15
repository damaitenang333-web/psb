<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation">
    <ul class="pagination pagination-md justify-content-center shadow-sm rounded-pill p-1 bg-white border">
        
        <!-- Tombol First (Halaman Pertama) -->
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="page-link border-0 rounded-circle mx-1 text-dark" href="<?= $pager->getFirst() ?>" aria-label="First">
                    <i class="bi bi-chevron-double-left"></i>
                </a>
            </li>
            <!-- Tombol Previous -->
            <li class="page-item">
                <a class="page-link border-0 rounded-circle mx-1 text-dark" href="<?= $pager->getPrevious() ?>" aria-label="Previous">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
        <?php endif ?>

        <!-- Angka Halaman -->
        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link border-0 rounded-circle mx-1 fw-semibold <?= $link['active'] ? 'bg-success text-white shadow-sm' : 'text-dark bg-transparent' ?>" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <!-- Tombol Next -->
        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="page-link border-0 rounded-circle mx-1 text-dark" href="<?= $pager->getNext() ?>" aria-label="Next">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
            <!-- Tombol Last (Halaman Terakhir) -->
            <li class="page-item">
                <a class="page-link border-0 rounded-circle mx-1 text-dark" href="<?= $pager->getLast() ?>" aria-label="Last">
                    <i class="bi bi-chevron-double-right"></i>
                </a>
            </li>
        <?php endif ?>
        
    </ul>
</nav>
