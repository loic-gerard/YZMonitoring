<?php
use yz\data\Appz;
use yz\navigation\Url;
?>

<div class="menu">
    <?php foreach(Appz::getAppz() AS $app){ ?>
        <a href="<?= BASE_URL.'/'.$app['url']; ?>" class="item <?php if($app['selected']){ echo 'selected'; } ?>"><?= $app['title']; ?></a>
    <?php } ?>
</div>  