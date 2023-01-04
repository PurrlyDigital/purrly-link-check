<?php

/** @var array $strings */

if( ! defined( 'ABSPATH' ) ) {
	exit();
}

$pluginVersion = md5( get_file_data( $this->pluginPath . '/purrly_link_check.php', [ 'Version' ] )[ 0 ] );
$logoPath      = $this->pluginURL . '/assets/img/SleepyCat250.png?' . $pluginVersion;

wp_register_style( 'purrly_link_check_admin', $this->pluginURL . '/assets/css/admin.css', [], $pluginVersion );
wp_enqueue_style( 'purrly_link_check_admin' );

?>

<div class="wrap">
    <h1 class="page-title purrly">
        <img src="<?= $logoPath; ?>" alt="" width="50" height="auto"><?= $this->strings[ 'settings_heading_h1' ]; ?></h1>
    <form method="post" action="options.php">
		<?php
		settings_fields( 'purrly_link_check_settings' );
		do_settings_sections( 'purrly_link_check' );
		submit_button();
		?>
    </form>
</div>
