<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class VI_WOOCOMMERCE_ALIDROPSHIP_Admin_System
 */
class VI_WOOCOMMERCE_ALIDROPSHIP_Admin_System {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'menu_page' ), 20 );
	}

	public function page_callback() {
		?>
        <div class="wrap">
            <h2><?php esc_html_e( 'System Status', 'woocommerce-alidropship' ) ?></h2>
            <table cellspacing="0" id="status" class="widefat">
                <tbody>
                <tr>
                    <td data-export-label="<?php esc_html_e( 'PHP Time Limit', 'woocommerce-alidropship' ) ?>"><?php esc_html_e( 'PHP Max Execution Time', 'woocommerce-alidropship' ) ?></td>
                    <td><?php echo ini_get( 'max_execution_time' ); ?></td>
                    <td><?php esc_html_e( 'Should be greater than 100', 'woocommerce-alidropship' ) ?></td>
                </tr>
                <tr>
                    <td data-export-label="<?php esc_html_e( 'PHP Max Input Vars', 'woocommerce-alidropship' ) ?>"><?php esc_html_e( 'PHP Max Input Vars', 'woocommerce-alidropship' ) ?></td>
                    <td><?php echo ini_get( 'max_input_vars' ); ?></td>
                    <td><?php esc_html_e( 'Should be greater than 10000', 'woocommerce-alidropship' ) ?></td>
                </tr>
                <tr>
                    <td data-export-label="<?php esc_html_e( 'Memory Limit', 'woocommerce-alidropship' ) ?>"><?php esc_html_e( 'Memory Limit', 'woocommerce-alidropship' ) ?></td>
                    <td><?php echo ini_get( 'memory_limit' ); ?></td>
                    <td><?php esc_html_e( 'Should be greater than 128MB', 'woocommerce-alidropship' ) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
		<?php
	}

	/**
	 * Register a custom menu page.
	 */
	public function menu_page() {
		$menu_slug = 'woocommerce-alidropship-status';
		add_submenu_page(
			'woocommerce-alidropship',
			esc_html__( 'System Status', 'woocommerce-alidropship' ),
			esc_html__( 'System Status', 'woocommerce-alidropship' ),
			apply_filters( 'vi_wad_admin_sub_menu_capability', 'manage_options', $menu_slug ),
			$menu_slug,
			array( $this, 'page_callback' )
		);
	}
}
