<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'VI_WOOCOMMERCE_ALIDROPSHIP_BACKGROUND_GET_PRODUCT_DATA' ) ) {
	class VI_WOOCOMMERCE_ALIDROPSHIP_BACKGROUND_GET_PRODUCT_DATA extends WP_Background_Process {
		/**
		 * @var string
		 */
		protected $action = 'vi_wad_get_product_data';

		/**
		 * Task
		 *
		 * Override this method to perform any actions required on each
		 * queue item. Return the modified item for further processing
		 * in the next pass through. Or, return false to remove the
		 * item from the queue.
		 *
		 * @param mixed $item Queue item to iterate over
		 *
		 * @return mixed
		 */
		protected function task( $item ) {
			$woo_product_id = isset( $item['woo_product_id'] ) ? $item['woo_product_id'] : '';
			try {
				if ( $woo_product_id ) {
					vi_wad_set_time_limit();
					$id             = VI_WOOCOMMERCE_ALIDROPSHIP_DATA::product_get_id_by_woo_id( $woo_product_id );
					$ali_product_id = strval( get_post_meta( $woo_product_id, '_vi_wad_aliexpress_product_id', true ) );
					if ( $id && $ali_product_id ) {
						VI_WOOCOMMERCE_ALIDROPSHIP_Admin_Ali_DS_API_Update_Product::update_product_by_id( array(
							'id'     => $id,
							'woo_id' => $woo_product_id,
							'ali_id' => $ali_product_id,
						), '',false );
					}
				}
				sleep( 1 );

				return false;
			} catch ( Error $e ) {
				VI_WOOCOMMERCE_ALIDROPSHIP_Admin_Log::error_log( 'Uncaught error: ' . $e->getMessage() . ' on ' . $e->getFile() . ':' . $e->getLine() );

				return false;
			} catch ( Exception $e ) {

				return false;
			}
		}

		/**
		 * Is the updater running?
		 *
		 * @return boolean
		 */
		public function is_process_running() {
			return parent::is_process_running();
		}

		/**
		 * Is the queue empty
		 *
		 * @return boolean
		 */
		public function is_queue_empty() {
			return parent::is_queue_empty();
		}

		/**
		 * Complete
		 *
		 * Override if applicable, but ensure that the below actions are
		 * performed, or, call parent::complete().
		 */
		protected function complete() {
			if ( $this->is_queue_empty() && ! $this->is_process_running() ) {
//				set_transient( 'vi_wad_background_import_product', time() );
			}
			// Show notice to user or perform some other arbitrary task...
			parent::complete();
		}

		/**
		 * Delete all batches.
		 *
		 * @return VI_WOOCOMMERCE_ALIDROPSHIP_BACKGROUND_GET_PRODUCT_DATA
		 */
		public function delete_all_batches() {
			global $wpdb;

			$table  = $wpdb->options;
			$column = 'option_name';

			if ( is_multisite() ) {
				$table  = $wpdb->sitemeta;
				$column = 'meta_key';
			}

			$key = $wpdb->esc_like( $this->identifier . '_batch_' ) . '%';

			$wpdb->query( $wpdb->prepare( "DELETE FROM {$table} WHERE {$column} LIKE %s", $key ) ); // @codingStandardsIgnoreLine.

			return $this;
		}

		/**
		 * Kill process.
		 *
		 * Stop processing queue items, clear cronjob and delete all batches.
		 */
		public function kill_process() {
			if ( ! $this->is_queue_empty() ) {
				$this->delete_all_batches();
				wp_clear_scheduled_hook( $this->cron_hook_identifier );
			}
		}
	}
}
