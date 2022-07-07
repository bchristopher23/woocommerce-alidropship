<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOOCOMMERCE_ALIDROPSHIP_Admin_Auth {
	protected $settings;

	public function __construct() {
		$this->settings = VI_WOOCOMMERCE_ALIDROPSHIP_DATA::get_instance();
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 20 );
		add_filter( 'woocommerce_locate_template', array( $this, 'woocommerce_locate_template' ), 10, 3 );
	}

	private static function set( $name, $set_name = false ) {
		return VI_WOOCOMMERCE_ALIDROPSHIP_DATA::set( $name, $set_name );
	}

	public function admin_menu() {
		$menu_slug = 'vi-woocommerce-alidropship-auth';
		add_submenu_page( '',
			esc_html__( 'Auth', 'woocommerce-alidropship' ),
			esc_html__( 'Auth', 'woocommerce-alidropship' ),
			apply_filters( 'vi_wad_admin_sub_menu_capability', 'manage_woocommerce', $menu_slug ),
			$menu_slug, array(
				$this,
				'page_callback'
			) );
	}

	public static function page_callback() {
		$api_credentials = get_option( 'vi_wad_temp_api_credentials', array() );
		?>
        <div class="wrap">
            <h2><?php esc_html_e( 'Authorize WooCommerce AliExpress Dropshipping Extension', 'woocommerce-alidropship' ) ?></h2>
			<?php
			if ( ! empty( $api_credentials['consumer_key'] ) && ! empty( $api_credentials['consumer_secret'] ) ) {
				?>
                <form method="post" class="<?php echo esc_attr( self::set( 'auth-form' ) ) ?>">
                    <input type="hidden" value="<?php echo esc_attr( $api_credentials['consumer_key'] ) ?>"
                           name="vi_wad_consumer_key">
                    <input type="hidden" value="<?php echo esc_attr( $api_credentials['consumer_secret'] ) ?>"
                           name="vi_wad_consumer_secret">
                </form>
				<?php
			}
			?>
        </div>
		<?php
		delete_option( 'vi_wad_temp_api_credentials' );
	}

	public function enqueue_semantic() {
		/*Stylesheet*/
		wp_enqueue_style( 'vi-woocommerce-alidropship-form', VI_WOOCOMMERCE_ALIDROPSHIP_CSS . 'form.min.css' );
		wp_enqueue_style( 'vi-woocommerce-alidropship-table', VI_WOOCOMMERCE_ALIDROPSHIP_CSS . 'table.min.css' );
		wp_enqueue_style( 'vi-woocommerce-alidropship-icon', VI_WOOCOMMERCE_ALIDROPSHIP_CSS . 'icon.min.css' );
		wp_enqueue_style( 'vi-woocommerce-alidropship-segment', VI_WOOCOMMERCE_ALIDROPSHIP_CSS . 'segment.min.css' );
		wp_enqueue_style( 'vi-woocommerce-alidropship-button', VI_WOOCOMMERCE_ALIDROPSHIP_CSS . 'button.min.css' );
		wp_enqueue_style( 'select2', VI_WOOCOMMERCE_ALIDROPSHIP_CSS . 'select2.min.css' );
		wp_enqueue_script( 'select2-v4', VI_WOOCOMMERCE_ALIDROPSHIP_JS . 'select2.js', array( 'jquery' ), '4.0.3' );
	}

	public function admin_enqueue_scripts() {
		global $pagenow;
		$page = isset( $_REQUEST['page'] ) ? wp_unslash( sanitize_text_field( $_REQUEST['page'] ) ) : '';
		if ( $pagenow === 'admin.php' && $page === 'vi-woocommerce-alidropship-auth' ) {
			wp_enqueue_script( 'vi-woocommerce-alidropship-auth', VI_WOOCOMMERCE_ALIDROPSHIP_JS . 'auth.js', array( 'jquery' ), VI_WOOCOMMERCE_ALIDROPSHIP_VERSION );
		}
	}

	public function woocommerce_locate_template( $template, $template_name, $template_path ) {
		global $woocommerce;

		$_template = $template;

		if ( ! $template_path ) {
			$template_path = $woocommerce->template_url;
		}

		$plugin_path = VI_WOOCOMMERCE_ALIDROPSHIP_DIR . '/templates/woocommerce/';

		// Look within passed path within the theme - this is priority
		$template = locate_template(

			array(
				$template_path . $template_name,
				$template_name
			)
		);

		// Modification: Get the template from this plugin, if it exists
		if ( ! $template && file_exists( $plugin_path . $template_name ) ) {
			$template = $plugin_path . $template_name;
		}

		// Use default template
		if ( ! $template ) {
			$template = $_template;
		}

		// Return what we found
		return $template;
	}
}

