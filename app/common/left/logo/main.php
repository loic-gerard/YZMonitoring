<?php

use jin\output\webapp\context\Output;
use yz\navigation\Url;

?>

<div class="logo" onclick="javascript:document.location='<?php Url::getUrlFromCode('dashboard'); ?>';">
    <div class="img">
        <img src="<?= BASE_URL; ?>images/logotype.png">
    </div>
    <div class="nomAppz">
        <?= Output::get('nomAppz'); ?>
    </div>
</div>