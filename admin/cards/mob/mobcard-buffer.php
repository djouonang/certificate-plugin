<?php ob_start(); ?>

<?php include plugin_dir_path( __FILE__ ) . 'huetcard.php'; ?>

<?php  $card_preview = ob_get_clean();