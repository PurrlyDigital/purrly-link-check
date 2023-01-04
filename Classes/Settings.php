<?php

namespace purrly_link_check\Classes;

if( ! defined( 'ABSPATH' ) ) {
	die();
}

class Settings extends Base {

	public array $strings;
	public array $transients;

	public function __construct() {

		parent::__construct();

		$this->transients = $this->get_transients();
		$this->strings    = $this->get_strings();

		add_action( 'admin_init', [ $this, 'register_settings' ] );
		add_action( 'admin_menu', [ $this, 'add_admin_pages' ] );

	}

	public function add_admin_pages() {

		add_options_page( 'Purrly Link Check', $this->strings[ 'settings_menu' ], 'manage_options', 'purrly_link_check', [
			$this,
			'admin_index',
		] );

	}

	public function register_settings() {

		register_setting( 'purrly_link_check_settings', 'purrly_link_check_settings', [ 'type' => 'array' ] );

		add_settings_section(
			'purrly_link_check_settings_section',
			$this->strings[ 'settings' ],
			[
				$this,
				'settings_section',
			],
			'purrly_link_check'
		);

		add_settings_field(
			'purrly_link_check_settings_internal_links_only',
			$this->strings[ 'settings_internal_links_only' ],
			[
				$this,
				'settings_field_internal_links_only',
			],
			'purrly_link_check',
			'purrly_link_check_settings_section',
			[
				'label_for' => 'purrly_link_check_settings_internal_links_only',
			]
		);

		add_settings_field(
			'purrly_link_check_settings_check_frequency',
			$this->strings[ 'settings_check_frequency' ],
			[
				$this,
				'settings_field_check_frequency',
			],
			'purrly_link_check',
			'purrly_link_check_settings_section',
			[
				'label_for' => 'purrly_link_check_settings_check_frequency',
			]
		);

	}

	public function settings_field_check_frequency( $args ) {

		$options   = get_option( 'purrly_link_check_settings' );
		$value     = $options[ 'check_frequency' ] ?? 'monthly';
		$frequency = [
			'monthly'   => $this->strings[ 'settings_check_frequency_monthly' ],
			'quarterly' => $this->strings[ 'settings_check_frequency_quarterly' ],
			'yearly'    => $this->strings[ 'settings_check_frequency_yearly' ],
		];

		$output = '<select name="purrly_link_check_settings[check_frequency]" id="purrly_link_check_settings_check_frequency">';

		foreach( $frequency as $key => $label ) {
			$output .= '<option value="' . $key . '" ' . selected( $value, $key, FALSE ) . '>' . $label . '</option>';
		}

		$output .= '</select>';
		$output .= '<p class="description">' . $this->strings[ 'settings_check_frequency_description' ] . '</p>';

		echo $output;
	}

	public function settings_field_internal_links_only() {

		$options   = get_option( $this->settingsName );
		$optionKey = 'internal_links_only';

		if( ! isset( $options[ $optionKey ] ) ) {
			$options[ $optionKey ] = 1;
		}
		?>
        <input type="checkbox" name="<?php echo $this->settingsName . '[' . $optionKey . ']'; ?>" id="<?php echo $this->settingsName . '_' . $optionKey; ?>" value="1" <?php checked( $options[ $optionKey ], 1 ); ?>>
        <p><?= $this->strings[ 'settings_internal_links_only_description' ]; ?></p>
		<?php

	}

	public function settings_section() {

		echo "<p>" . $this->strings[ 'settings_intro' ] . "</p>";

	}

	public function settings_field() {

		echo 'Settings Field';

	}

	public function admin_index() {

		// require template
		require_once( $this->pluginPath . '/templates/admin.php' );

	}

	private function get_transients() {

		$transients = [
			'text_domain' => 'purrly_link_check_plugin_text_domain_cache',
			'plugin_name' => 'purrly_link_check_plugin_name_cache',
		];

		return apply_filters( 'purrly_link_check_transients', $transients );
	}

	private function get_strings(): array {

		$pluginTextDomain = get_transient( $this->transients[ 'text_domain' ] );
		$pluginName       = get_transient( $this->transients[ 'plugin_name' ] );

		if( ! $pluginTextDomain ) {
			$pluginTextDomain = get_file_data( $this->pluginPath . '/purrly_link_check.php', [ 'Text Domain' ] )[ 0 ];
			set_transient( $this->transients[ 'text_domain' ], $pluginTextDomain, 86400 );
		}

		if( ! $pluginName ) {
			$pluginName = get_file_data( $this->pluginPath . '/purrly_link_check.php', [ 'Plugin Name' ] )[ 0 ];
			set_transient( $this->transients[ 'plugin_name' ], $pluginName, 86400 );
		}

		$strings = [
			'settings_intro'                           => sprintf( __( 'Welcome to the %s settings screen! From here, you can customize the behavior of the link checker plugin to suit your needs.', $pluginTextDomain ), $pluginName ),
			'settings_heading_h1'                      => sprintf( __( 'Settings for %s', $pluginTextDomain ), $pluginName ),
			'settings'                                 => __( 'Settings', $pluginTextDomain ),
			'settings_menu'                            => __( 'Link Check', $pluginTextDomain ),
			'settings_internal_links_only'             => __( 'Check internal links only', $pluginTextDomain ),
			'settings_internal_links_only_description' => __( 'If checked, only internal links will be checked. If unchecked, all links will be checked.', $pluginTextDomain ),
			'settings_check_frequency'                 => __( 'Check frequency', $pluginTextDomain ),
			'settings_check_frequency_monthly'         => __( 'Monthly', $pluginTextDomain ),
			'settings_check_frequency_quarterly'       => __( 'Quarterly', $pluginTextDomain ),
			'settings_check_frequency_yearly'          => __( 'Yearly', $pluginTextDomain ),
			'settings_check_frequency_description'     => __( 'How often should the link checker run?', $pluginTextDomain ),
		];

		return apply_filters( 'purrly_link_check_strings', $strings );

	}

}