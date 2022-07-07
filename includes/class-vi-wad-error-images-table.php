<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'VI_WOOCOMMERCE_ALIDROPSHIP_Error_Images_Table' ) ) {
	class VI_WOOCOMMERCE_ALIDROPSHIP_Error_Images_Table {
		public static function create_table() {
			global $wpdb;
			$table = $wpdb->prefix . 'vi_wad_error_product_images';

			$query = "CREATE TABLE IF NOT EXISTS {$table} (
                             `id` bigint(20) NOT NULL AUTO_INCREMENT,
                             `product_id` bigint(20) NOT NULL,
                             `product_ids` longtext NOT NULL,
                             `image_src` longtext NOT NULL,
                             `set_gallery` tinyint(1) NOT NULL,
                             PRIMARY KEY  (`id`)
                             )";

			$wpdb->query( $query );
		}

		public static function insert( $product_id, $product_ids, $image_src, $set_gallery ) {
			global $wpdb;
			$table = $wpdb->prefix . 'vi_wad_error_product_images';
			$wpdb->insert( $table,
				array(
					'product_id'  => $product_id,
					'product_ids' => $product_ids,
					'image_src'   => $image_src,
					'set_gallery' => $set_gallery,
				),
				array(
					'%d',
					'%s',
					'%s',
					'%d',
				)
			);

			return $wpdb->insert_id;
		}

		public static function delete( $id ) {
			global $wpdb;
			$table  = $wpdb->prefix . 'vi_wad_error_product_images';
			$delete = $wpdb->delete( $table,
				array(
					'id' => $id,
				),
				array(
					'%d',
				)
			);

			return $delete;
		}

		public static function get_row( $id ) {
			global $wpdb;
			$table = $wpdb->prefix . 'vi_wad_error_product_images';
			$query = "SELECT * FROM {$table} WHERE id=%s LIMIT 1";

			return $wpdb->get_row( $wpdb->prepare( $query, $id ), ARRAY_A );
		}

		public static function get_rows( $limit = 0, $offset = 0, $count = false, $product_id = '', $used_for = '' ) {
			global $wpdb;
			$table  = $wpdb->prefix . 'vi_wad_error_product_images';
			$select = '*';
			switch ( $used_for ) {
				case 'gallery':
					$used_for = 1;
					break;
				case 'description':
					$used_for = 2;
					break;
				case 'featured_image':
					$used_for = 0;
					break;
				default:
					$used_for = '';
			}
			$args  = array();
			$where = array();
			if ( $product_id ) {
				$where[] = "{$table}.product_id=%s";
				$args[]  = $product_id;
			}
			if ( $used_for !== '' ) {
				$where[] = "{$table}.set_gallery=%s";
				$args[]  = $used_for;
			}
			if ( $count ) {
				$select = 'count(*)';
				$query  = "SELECT {$select} FROM {$table}";
				if ( count( $args ) ) {
					$query = $wpdb->prepare( "$query WHERE " . implode( 'AND ', $where ), $args );
				}

				return $wpdb->get_var( $query );
			} else {
				$query = "SELECT {$select} FROM {$table}";
				if ( count( $args ) ) {
					$query = $wpdb->prepare( "$query WHERE " . implode( 'AND ', $where ), $args );
				}
				if ( $limit ) {
					$query .= " LIMIT {$offset},{$limit}";
				}

				return $wpdb->get_results( $query, ARRAY_A );
			}
		}

		public static function get_products_ids( $search = '', $limit = 50 ) {
			global $wpdb;
			$table       = $wpdb->prefix . 'vi_wad_error_product_images';
			$table_posts = $wpdb->prefix . 'posts';
			if ( $search ) {
				$query = "SELECT distinct product_id FROM {$table} left join {$table_posts} on {$table}.product_id={$table_posts}.ID where {$table_posts}.post_title like %s LIMIT 0, {$limit}";
				$query = $wpdb->prepare( $query, '%' . $wpdb->esc_like( $search ) . '%' );
			} else {
				$query = "SELECT distinct product_id FROM {$table}";
			}

			return $wpdb->get_col( $query, 0 );
		}
	}
}
