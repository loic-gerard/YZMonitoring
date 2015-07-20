<?php
use jin\output\webapp\context\Output;

?>

<title><?php echo Output::get('title'); ?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?= BASE_URL; ?>css/app.css" media="screen" rel="stylesheet" />
<link rel="stylesheet" href="<?= BASE_URL; ?>extlibs/mailihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css" />
<?php echo Output::get('css', true, ''); ?>
<script src="<?= BASE_URL; ?>js/jquery-1.11.2.min.js"></script>
<script src="<?= BASE_URL; ?>extlibs/mailihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= BASE_URL; ?>js/main.js"></script>
<?php echo Output::get('js', true, ''); ?>
