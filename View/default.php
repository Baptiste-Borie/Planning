<?php
include_once "header.php" ?>
<section id="main-section">
    <?php
    if (isset($page)) {
        require("./View/" . $page . ".php");
    }
    ?>
</section>
<?php include_once "footer.php" ?>