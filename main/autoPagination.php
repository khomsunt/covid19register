<nav aria-label="Page navigation" class="auto-pagination">
    <ul class="pagination justify-content-end">
        <li class="page-item <?php echo ($page=="0")?"disabled":""; ?>">
        <a class="page-link previous-pagination-link">Previous</a>
        </li>
        <?php
        for ($p=0; $p < $pages; $p++) { 
        ?>
            <li class="page-item <?php echo ($page==$p)?"active":""; ?>"><a class="page-link pagination-link" page="<?php echo $p; ?>"><?php echo $p+1; ?></a></li>
        <?php
        }
        ?>
        <li class="page-item <?php echo ($page==($pages-1))?"disabled":""; ?>">
        <a class="page-link next-pagination-link">Next</a>
        </li>
    </ul>
</nav>
