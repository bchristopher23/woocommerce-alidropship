<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOOCOMMERCE_ALIDROPSHIP_DATA {
	private static $prefix;
	private $params;
	private $default;
	private static $countries;
	private static $states;
	private static $ali_states;
	protected static $instance = null;
	protected static $allow_html = null;

	/**
	 * VI_WOOCOMMERCE_ALIDROPSHIP_DATA constructor.
	 */
	public function __construct() {
		self::$prefix = 'vi-wad-';
		global $wooaliexpressdropship_settings;
		if ( ! $wooaliexpressdropship_settings ) {
			$wooaliexpressdropship_settings = get_option( 'wooaliexpressdropship_params', array() );
		}
		$this->default = array(
			'enable'                                     => '1',
			'secret_key'                                 => '',
			'fulfill_default_carrier'                    => 'EMS_ZX_ZX_US',
			'fulfill_default_phone_number'               => '',
			'fulfill_default_phone_number_override'      => '',
			'fulfill_default_phone_country'              => '',
			'fulfill_order_note'                         => 'I\'m dropshipping. Please DO NOT put any invoices, QR codes, promotions or your brand name logo in the shipments. Please ship as soon as possible for repeat business. Thank you!',
			'order_status_for_fulfill'                   => array( 'wc-completed', 'wc-on-hold', 'wc-processing' ),
			'order_status_after_ali_order'               => 'wc-completed',
			'order_status_after_sync'                    => 'wc-completed',
			'string_replace'                             => array(),
			'carrier_name_replaces'                      => array(
				'from_string' => array(),
				'to_string'   => array(),
				'sensitive'   => array(),
			),
			'carrier_url_replaces'                       => array(
				'from_string' => array(),
				'to_string'   => array(),
			),
			'attributes_mapping_origin'                  => '[]',
			'attributes_mapping_replacement'             => '[]',
			'override_hide'                              => 0,
			'override_keep_product'                      => 1,
			'override_title'                             => 0,
			'override_images'                            => 0,
			'override_description'                       => 0,
			'override_find_in_orders'                    => 1,
			'update_product_quantity'                    => 0,
			'update_product_price'                       => 0,
			'update_product_if_out_of_stock'             => '',
			'update_product_if_not_available'            => '',
			'update_product_removed_variation'           => '',
			'update_product_if_shipping_error'           => '',
			'update_product_auto'                        => 0,
			'update_product_interval'                    => 1,
			'update_product_hour'                        => rand( 0, 23 ),
			'update_product_minute'                      => rand( 0, 59 ),
			'update_product_second'                      => rand( 0, 59 ),
			'update_product_exclude_products'            => array(),
			'update_product_exclude_onsale'              => '',
			'update_product_exclude_categories'          => array(),
			'update_product_statuses'                    => array( 'publish', 'draft', 'pending' ),
			'update_order_auto'                          => 0,
			'update_order_interval'                      => 1,
			'update_order_hour'                          => rand( 0, 23 ),
			'update_order_minute'                        => rand( 0, 59 ),
			'update_order_second'                        => rand( 0, 59 ),
			'received_email'                             => '',
			'send_email_if'                              => array( 'is_offline', 'is_out_of_stock', 'price_changes' ),
			'key'                                        => '',
			'access_tokens'                              => array(),
			'access_token'                               => '',
			'split_auto_remove_attribute'                => '',
			'delete_woo_product'                         => 1,
			'shipping_company_mapping'                   => array(),
			'ali_shipping'                               => '',
			'ali_shipping_type'                          => 'new',/*none/new/new_only/add*/
			'ali_shipping_display'                       => 'popup',/*select/radio/popup*/
			'ali_shipping_option_text'                   => '[{shipping_cost}]{shipping_company} ({delivery_time})',
			'ali_shipping_show_tracking'                 => '',
			'ali_shipping_label'                         => 'Shipping',
			'ali_shipping_label_free'                    => 'Free Shipping',
			'ali_shipping_not_available_remove'          => '',
			'ali_shipping_not_available_message'         => '[{shipping_cost}] ({delivery_time})',
			'ali_shipping_not_available_cost'            => 0,
			'ali_shipping_not_available_time_min'        => 20,
			'ali_shipping_not_available_time_max'        => 30,
			'ali_shipping_select_variation_message'      => 'Please select a variation to see estimated shipping cost.',
			'ali_shipping_product_text'                  => 'Estimated shipping to {country}:',
			'ali_shipping_product_not_available_message' => 'This product can not be delivered to {country}.',
			'ali_shipping_product_enable'                => '',
			'ali_shipping_product_position'              => 'after_cart',
			'ali_shipping_product_display'               => 'popup',/*select/radio/popup*/
			'ali_shipping_company_mask'                  => '[]',
			'ali_shipping_company_mask_time'             => 0,
			'cpf_custom_meta_key'                        => '',
			'rut_meta_key'                               => '',
			'batch_request_enable'                       => '',
			'migration_link_only'                        => '',
			'restrict_products_by_vendor'                => '',
			'send_bcc_email_to_vendor'                   => '',
			'import_product_currency'                    => 'USD',
			'import_currency_rate'                       => '1',
			'import_currency_rate_CNY'                   => '',
			'exchange_rate_api'                          => 'google',
			'exchange_rate_decimals'                     => 3,
			'exchange_rate_auto'                         => 0,
			'exchange_rate_interval'                     => 1,
			'exchange_rate_hour'                         => 1,
			'exchange_rate_minute'                       => 1,
			'exchange_rate_second'                       => 1,
			'exchange_rate_shipping'                     => array(),
			'use_external_image'                         => '',
			'disable_background_process'                 => '',
			'download_description_images'                => '',
			'show_shipping_option'                       => '1',
			'shipping_cost_after_price_rules'            => '1',
			'import_product_video'                       => '1',
			'show_product_video_tab'                     => '1',
			'product_video_tab_priority'                 => '50',
			'product_video_full_tab'                     => '',
			'price_change_max'                           => '',
			'auto_order_if_payment'                      => array(),
			'show_menu_count'                            => array(
				'import_list',
				'ali_orders',
				'imported',
				'failed_images'
			),
			'auto_order_if_status'                       => array( 'wc-processing', 'wc-completed' ),
			'debug_mode'                                 => '',
		);
		$this->default = wp_parse_args( $this->default, $this->get_product_params() );
		$this->set_params( wp_parse_args( $wooaliexpressdropship_settings, $this->default ) );
	}

	public function set_params( $params ) {
		$this->params = apply_filters( 'wooaliexpressdropship_params', $params );
	}

	/**
	 * @param string $name
	 * @param string $language
	 *
	 * @return bool|mixed|void
	 */

	public function get_params( $name = '', $language = '' ) {
		if ( ! $name ) {
			return $this->params;
		} elseif ( isset( $this->params[ $name ] ) ) {
			if ( $language ) {
				$name_language = $name . '_' . $language;
				if ( isset( $this->params[ $name_language ] ) ) {
					return apply_filters( 'wooaliexpressdropship_params-' . $name_language, $this->params[ $name_language ] );
				} else {
					return apply_filters( 'wooaliexpressdropship_params-' . $name_language, $this->params[ $name ] );
				}
			} else {
				return apply_filters( 'wooaliexpressdropship_params_' . $name, $this->params[ $name ] );
			}
		} else {
			return false;
		}
	}

	/**
	 * @param bool $new
	 *
	 * @return VI_WOOCOMMERCE_ALIDROPSHIP_DATA|null
	 */
	public static function get_instance( $new = false ) {
		if ( $new || null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * @param $slug
	 *
	 * @return string
	 */
	public static function get_attribute_name_by_slug( $slug ) {
		return ucwords( str_replace( '-', ' ', $slug ) );
	}

	/**
	 * @param $url
	 *
	 * @return mixed
	 */
	public static function get_domain_from_url( $url ) {
		$url     = strtolower( $url );
		$url_arr = explode( '//', $url );
		if ( count( $url_arr ) > 1 ) {
			$url = str_replace( 'www.', '', $url_arr[1] );

		} else {
			$url = str_replace( 'www.', '', $url_arr[0] );
		}
		$url_arr = explode( '/', $url );
		$url     = $url_arr[0];

		return $url;
	}

	/**
	 * @param array $args
	 * @param bool $return_sku
	 *
	 * @return array
	 */
	public static function get_imported_products( $args = array(), $return_sku = false ) {
		$imported_products = array();
		$args              = wp_parse_args( $args, array(
			'post_type'      => 'vi_wad_draft_product',
			'posts_per_page' => - 1,
			'meta_key'       => '_vi_wad_sku',
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
			'post_status'    => array(
				'publish',
				'draft',
				'override'
			),
			'fields'         => 'ids'
		) );

		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			if ( $return_sku ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$product_id  = get_the_ID();
					$product_sku = get_post_meta( $product_id, '_vi_wad_sku', true );
					if ( $product_sku ) {
						$imported_products[] = $product_sku;
					}
				}
			} else {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$imported_products[] = get_the_ID();
				}
			}
		}
		wp_reset_postdata();

		return $imported_products;
	}

	/**Get WooCommerce product ID(s)/count from AliExpress product ID
	 *
	 * @param $aliexpress_id
	 * @param bool $is_variation
	 * @param bool $count
	 * @param bool $multiple
	 *
	 * @return array|bool|object|string|null
	 */
	public static function product_get_woo_id_by_aliexpress_id( $aliexpress_id, $is_variation = false, $count = false, $multiple = false ) {
		global $wpdb;
		if ( $aliexpress_id ) {
			$table_posts    = "{$wpdb->prefix}posts";
			$table_postmeta = "{$wpdb->prefix}postmeta";
			if ( $is_variation ) {
				$post_type = 'product_variation';
				$meta_key  = '_vi_wad_aliexpress_variation_attr';
			} else {
				$post_type = 'product';
				$meta_key  = '_vi_wad_aliexpress_product_id';
			}
			if ( $count ) {
				$query   = "SELECT count(*) from {$table_postmeta} join {$table_posts} on {$table_postmeta}.post_id={$table_posts}.ID where {$table_posts}.post_type = '{$post_type}' and {$table_posts}.post_status != 'trash' and {$table_postmeta}.meta_key = '{$meta_key}' and {$table_postmeta}.meta_value = %s";
				$results = $wpdb->get_var( $wpdb->prepare( $query, $aliexpress_id ) );
			} else {
				$query = "SELECT {$table_postmeta}.* from {$table_postmeta} join {$table_posts} on {$table_postmeta}.post_id={$table_posts}.ID where {$table_posts}.post_type = '{$post_type}' and {$table_posts}.post_status != 'trash' and {$table_postmeta}.meta_key = '{$meta_key}' and {$table_postmeta}.meta_value = %s";
				if ( $multiple ) {
					$results = $wpdb->get_results( $wpdb->prepare( $query, $aliexpress_id ), ARRAY_A );
				} else {
					$query   .= ' LIMIT 1';
					$results = $wpdb->get_var( $wpdb->prepare( $query, $aliexpress_id ), 1 );
				}
			}

			return $results;
		} else {
			return false;
		}
	}

	/**Get vi_wad_draft_product ID(s)/count from WooCommerce product ID
	 *
	 * @param $product_id
	 * @param bool $count
	 * @param bool $multiple
	 * @param array $status
	 *
	 * @return array|bool|object|string|null
	 */
	public static function product_get_id_by_woo_id(
		$product_id, $count = false, $multiple = false, $status = array(
		'publish',
		'draft',
		'override'
	)
	) {
		global $wpdb;
		if ( $product_id ) {
			$table_posts    = "{$wpdb->prefix}posts";
			$table_postmeta = "{$wpdb->prefix}postmeta";
			$post_type      = 'vi_wad_draft_product';
			$meta_key       = '_vi_wad_woo_id';
			$post_status    = '';
			if ( $status ) {
				if ( is_array( $status ) ) {
					$status_count = count( $status );
					if ( $status_count === 1 ) {
						$post_status = " AND {$table_posts}.post_status='{$status[0]}' ";
					} elseif ( $status_count > 1 ) {
						$post_status = " AND {$table_posts}.post_status IN ('" . implode( "','", $status ) . "') ";
					}
				} else {
					$post_status = " AND {$table_posts}.post_status='{$status}' ";
				}
			}

			if ( $count ) {
				$query   = "SELECT count(*) from {$table_postmeta} join {$table_posts} on {$table_postmeta}.post_id={$table_posts}.ID where {$table_posts}.post_type = '{$post_type}'{$post_status}and {$table_postmeta}.meta_key = '{$meta_key}' and {$table_postmeta}.meta_value = %s";
				$results = $wpdb->get_var( $wpdb->prepare( $query, $product_id ) );
			} else {
				$query = "SELECT {$table_postmeta}.* from {$table_postmeta} join {$table_posts} on {$table_postmeta}.post_id={$table_posts}.ID where {$table_posts}.post_type = '{$post_type}'{$post_status}and {$table_postmeta}.meta_key = '{$meta_key}' and {$table_postmeta}.meta_value = %s";
				if ( $multiple ) {
					$results = $wpdb->get_results( $wpdb->prepare( $query, $product_id ), ARRAY_A );
				} else {
					$query   .= ' LIMIT 1';
					$results = $wpdb->get_var( $wpdb->prepare( $query, $product_id ), 1 );
				}
			}

			return $results;
		} else {
			return false;
		}
	}

	/**Get vi_wad_draft_product ID that will override $product_id
	 *
	 * @param $product_id
	 *
	 * @return bool|string|null
	 */
	public static function get_overriding_product( $product_id ) {
		global $wpdb;
		if ( $product_id ) {
			$table_posts = "{$wpdb->prefix}posts";
			$query       = "SELECT ID from {$table_posts} where {$table_posts}.post_type = 'vi_wad_draft_product' and {$table_posts}.post_status = 'override' and {$table_posts}.post_parent = %s LIMIT 1";

			return $wpdb->get_var( $wpdb->prepare( $query, $product_id ), 0 );
		} else {
			return false;
		}
	}

	/**Get vi_wad_draft_product ID(s)/count from AliExpress product ID
	 *
	 * @param $aliexpress_id
	 * @param array $post_status
	 * @param bool $count
	 * @param bool $multiple
	 *
	 * @return array|string|null
	 */
	public static function product_get_id_by_aliexpress_id(
		$aliexpress_id, $post_status = array(
		'publish',
		'draft',
		'override'
	), $count = false, $multiple = false
	) {
		global $wpdb;
		$table_posts    = "{$wpdb->prefix}posts";
		$table_postmeta = "{$wpdb->prefix}postmeta";
		$post_type      = 'vi_wad_draft_product';
		$meta_key       = '_vi_wad_sku';
		$args           = array();
		$where          = array();
		if ( $post_status ) {
			if ( is_array( $post_status ) ) {
				if ( count( $post_status ) === 1 ) {
					$where[] = "{$table_posts}.post_status=%s";
					$args[]  = $post_status[0];
				} else {
					$where[] = "{$table_posts}.post_status IN (" . implode( ', ', array_fill( 0, count( $post_status ), '%s' ) ) . ")";
					foreach ( $post_status as $v ) {
						$args[] = $v;
					}
				}
			} else {
				$where[] = "{$table_posts}.post_status=%s";
				$args[]  = $post_status;
			}
		}
		if ( $aliexpress_id ) {
			$where[] = "{$table_postmeta}.meta_key = '{$meta_key}'";
			$where[] = "{$table_postmeta}.meta_value = %s";
			$args[]  = $aliexpress_id;
			if ( $count ) {
				$query   = "SELECT count(*) from {$table_postmeta} join {$table_posts} on {$table_postmeta}.post_id={$table_posts}.ID where {$table_posts}.post_type = '{$post_type}'";
				$query   .= ' AND ' . implode( ' AND ', $where );
				$results = $wpdb->get_var( $wpdb->prepare( $query, $args ) );
			} else {
				$query = "SELECT {$table_postmeta}.* from {$table_postmeta} join {$table_posts} on {$table_postmeta}.post_id={$table_posts}.ID where {$table_posts}.post_type = '{$post_type}'";
				$query .= ' AND ' . implode( ' AND ', $where );
				if ( $multiple ) {
					$results = $wpdb->get_col( $wpdb->prepare( $query, $args ), 1 );
				} else {
					$query   .= ' LIMIT 1';
					$results = $wpdb->get_var( $wpdb->prepare( $query, $args ), 1 );
				}
			}

		} else {
			$where[] = "{$table_postmeta}.meta_key = '{$meta_key}'";
			if ( $count ) {
				$query   = "SELECT count(*) from {$table_postmeta} join {$table_posts} on {$table_postmeta}.post_id={$table_posts}.ID where {$table_posts}.post_type = '{$post_type}'";
				$query   .= ' AND ' . implode( ' AND ', $where );
				$results = $wpdb->get_var( count( $args ) ? $wpdb->prepare( $query, $args ) : $query );
			} else {
				$query   = "SELECT {$table_postmeta}.* from {$table_postmeta} join {$table_posts} on {$table_postmeta}.post_id={$table_posts}.ID where {$table_posts}.post_type = '{$post_type}'";
				$query   .= ' AND ' . implode( ' AND ', $where );
				$results = $wpdb->get_col( count( $args ) ? $wpdb->prepare( $query, $args ) : $query, 1 );
			}
		}

		return $results;
	}

	/**
	 * @param $cookie
	 *
	 * @return string
	 */
	public static function modify_cookie( $cookie ) {
		if ( $cookie ) {
			$cookie_ar   = explode( '&', $cookie );
			$new_cookies = array();
			foreach ( $cookie_ar as $cookie_ar_k => $cookie_ar_v ) {
				$cookie_pat = explode( '=', $cookie_ar_v );
				switch ( $cookie_pat[0] ) {
					case 'site';
						$cookie_pat[1] = 'glo_v';
						break;
					case 'c_tp';
						$cookie_pat[1] = 'USD';
						break;
					default:
				}

				$new_cookies[] = implode( '=', $cookie_pat );
			}

			return implode( '&', $new_cookies );
		} else {
			return $cookie;
		}
	}

	/**
	 * @param $url
	 * @param array $args
	 * @param string $html
	 * @param bool $skip_ship_from_check
	 *
	 * @return array
	 */
	public static function get_data( $url, $args = array(), $html = '', $skip_ship_from_check = false ) {
		$response   = array(
			'status'  => 'success',
			'message' => '',
			'code'    => '',
			'data'    => array(),
		);
		$attributes = array(
			'sku' => '',
		);
		if ( ! $html ) {
			$args             = wp_parse_args( $args, array(
				'user-agent' => self::get_user_agent(),
				'timeout'    => 10,
			) );
			$request          = wp_remote_get( $url, $args );
			$response['code'] = wp_remote_retrieve_response_code( $request );
			if ( ! is_wp_error( $request ) ) {
				$html = $request['body'];
			} else {
				$response['status']  = 'error';
				$response['message'] = $request->get_error_messages();

				return $response;
			}
		}
		$productVariationMaps       = array();
		$listAttributes             = array();
		$listAttributesDisplayNames = array();
		$propertyValueNames         = array();
		$listAttributesNames        = array();
		$listAttributesSlug         = array();
		$listAttributesIds          = array();
		$variationImages            = array();
		$variations                 = array();
		$ignore_ship_from           = $skip_ship_from_check ? false : ( new self )->get_params( 'ignore_ship_from' );

		if ( is_array( $html ) ) {
			if ( ! empty( $html['ae_item_base_info_dto'] ) ) {
				/*Rebuild data from the new product API aliexpress.ds.product.get - since 1.0.10*/
				if ( ! empty( $html['ae_item_base_info_dto']['product_status_type'] ) && $html['ae_item_base_info_dto']['product_status_type'] === 'offline' ) {
					$response['status']  = 'error';
					$response['message'] = esc_html__( 'This product is no longer available', 'woocommerce-alidropship' );

					return $response;
				}
				if ( ! empty( $html['ae_item_base_info_dto']['product_id'] ) ) {
					$attributes['sku'] = $html['ae_item_base_info_dto']['product_id'];
				}
				$attributes['gallery'] = $html['ae_multimedia_info_dto']['image_urls'] ? explode( ';', $html['ae_multimedia_info_dto']['image_urls'] ) : array();
				if ( isset( $html['ae_multimedia_info_dto']['ae_video_dtos'], $html['ae_multimedia_info_dto']['ae_video_dtos']['ae_video_d_t_o'] ) && $html['ae_multimedia_info_dto']['ae_video_dtos']['ae_video_d_t_o'] ) {
					$attributes['video'] = $html['ae_multimedia_info_dto']['ae_video_dtos']['ae_video_d_t_o'][0];
				}

				$skuModule = isset( $html['ae_item_sku_info_dtos'] ['ae_item_sku_info_d_t_o'] ) ? $html['ae_item_sku_info_dtos'] ['ae_item_sku_info_d_t_o'] : array();
				if ( count( $skuModule ) ) {
					$productSKUPropertyList = array();
					if ( ! empty( $skuModule[0]['ae_sku_property_dtos']['ae_sku_property_d_t_o'] ) ) {
						for ( $i = 0; $i < count( $skuModule[0]['ae_sku_property_dtos']['ae_sku_property_d_t_o'] ); $i ++ ) {
							$productSKUPropertyList[] = array(
								'id'     => $skuModule[0]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][ $i ]['sku_property_id'],
								'values' => array(),
								'name'   => $skuModule[0]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][ $i ]['sku_property_name'],
							);
						}
						for ( $i = 0; $i < count( $skuModule ); $i ++ ) {
							for ( $j = 0; $j < count( $productSKUPropertyList ); $j ++ ) {
								if ( ! in_array( $skuModule[ $i ]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][ $j ]['property_value_id'], array_column( $productSKUPropertyList[ $j ]['values'], 'id' ) ) ) {
									$property_value = array(
										'id'        => isset( $skuModule[ $i ]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][ $j ]['property_value_id'] ) ? $skuModule[ $i ]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][ $j ]['property_value_id'] : '',
										'image'     => isset( $skuModule[ $i ]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][ $j ]['sku_image'] ) ? str_replace( array(
											'ae02.alicdn.com',
											'ae03.alicdn.com',
											'ae04.alicdn.com',
											'ae05.alicdn.com',
										), 'ae01.alicdn.com', $skuModule[ $i ]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][ $j ]['sku_image'] ) : '',
										'name'      => isset( $skuModule[ $i ]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][ $j ]['sku_property_value'] ) ? $skuModule[ $i ]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][ $j ]['sku_property_value'] : '',
										'ship_from' => '',
									);
									$ship_from      = self::property_value_id_to_ship_from( $skuModule[ $i ]['ae_sku_property_dtos']['ae_sku_property_d_t_o'][ $j ]['sku_property_id'], $property_value['id'] );
									if ( $ship_from ) {
										$property_value['ship_from'] = $ship_from;
									}
									$productSKUPropertyList[ $j ]['values'][] = $property_value;
								}
							}
						}
					}
					$china_id = '';
					if ( count( $productSKUPropertyList ) ) {
						for ( $i = 0; $i < count( $productSKUPropertyList ); $i ++ ) {
							$images            = array();
							$skuPropertyValues = $productSKUPropertyList[ $i ]['values'];
							$attr_parent_id    = $productSKUPropertyList[ $i ]['id'];
							$skuPropertyName   = wc_sanitize_taxonomy_name( $productSKUPropertyList[ $i ]['name'] );
							if ( strtolower( $skuPropertyName ) == 'ships-from' && $ignore_ship_from ) {
								foreach ( $skuPropertyValues as $value ) {
									if ( isset( $value['ship_from'] ) && $value['ship_from'] === 'CN' ) {
										$china_id = $value['id'];
									}
								}
								continue;
							} //point 1
							$attr = array(
								'values'   => array(),
								'slug'     => $skuPropertyName,
								'name'     => $productSKUPropertyList[ $i ]['name'],
								'position' => $i,
							);
							for ( $j = 0; $j < count( $skuPropertyValues ); $j ++ ) {
								$skuPropertyValue         = $skuPropertyValues[ $j ];
								$org_propertyValueId      = $skuPropertyValue['id'];
								$propertyValueId          = "{$attr_parent_id}:{$org_propertyValueId}";
								$propertyValueDisplayName = $skuPropertyValue['name'];
								if ( in_array( $propertyValueDisplayName, $listAttributesDisplayNames ) ) {
									$propertyValueDisplayName = "{$propertyValueDisplayName}-{$org_propertyValueId}";
								}
								$listAttributesNames[ $propertyValueId ]        = $skuPropertyName;
								$listAttributesDisplayNames[ $propertyValueId ] = $propertyValueDisplayName;
								$listAttributesIds[ $propertyValueId ]          = $attr_parent_id;
								$listAttributesSlug[ $propertyValueId ]         = $skuPropertyName;
								$attr['values'][ $propertyValueId ]             = $propertyValueDisplayName;
								$listAttributes[ $propertyValueId ]             = array(
									'name'      => $propertyValueDisplayName,
									'color'     => '',
									'image'     => '',
									'ship_from' => isset( $skuPropertyValue['ship_from'] ) ? $skuPropertyValue['ship_from'] : ''
								);
								if ( isset( $skuPropertyValue['image'] ) && $skuPropertyValue['image'] ) {
									$images[ $propertyValueId ]                  = $skuPropertyValue['image'];
									$variationImages[ $propertyValueId ]         = $skuPropertyValue['image'];
									$listAttributes[ $propertyValueId ]['image'] = $skuPropertyValue['image'];
								}
							}

							$attributes['list_attributes']               = $listAttributes;
							$attributes['list_attributes_names']         = $listAttributesNames;
							$attributes['list_attributes_ids']           = $listAttributesIds;
							$attributes['list_attributes_slugs']         = $listAttributesSlug;
							$attributes['variation_images']              = $variationImages;
							$attributes['attributes'][ $attr_parent_id ] = $attr;
							$attributes['images'][ $attr_parent_id ]     = $images;

							$attributes['parent'][ $attr_parent_id ] = $skuPropertyName;
						}
					}
					for ( $j = 0; $j < count( $skuModule ); $j ++ ) {
						$temp                  = array(
							'skuId'              => '',
							'skuAttr'            => ( isset( $skuModule[ $j ]['id'] ) && $skuModule[ $j ]['id'] !== '<none>' ) ? $skuModule[ $j ]['id'] : '',
							'skuPropIds'         => isset( $skuModule[ $j ]['ae_sku_property_dtos']['ae_sku_property_d_t_o'] ) ? array_column( $skuModule[ $j ]['ae_sku_property_dtos']['ae_sku_property_d_t_o'], 'property_value_id' ) : array(),
							'skuVal'             => array(
								'availQuantity'  => isset( $skuModule[ $j ]['sku_available_stock'] ) ? $skuModule[ $j ]['sku_available_stock'] : ( isset( $skuModule[ $j ]['ipm_sku_stock'] ) ? $skuModule[ $j ]['ipm_sku_stock'] : 0 ),
								'skuCalPrice'    => isset( $skuModule[ $j ]['sku_price'] ) ? $skuModule[ $j ]['sku_price'] : '',
								'actSkuCalPrice' => 0,
							),
							'image'              => '',
							'variation_ids'      => array(),
							'variation_ids_sub'  => array(),
							'variation_ids_slug' => array(),
							'ship_from'          => '',
							'currency_code'      => isset( $skuModule[ $j ]['currency_code'] ) ? $skuModule[ $j ]['currency_code'] : '',
						);
						$s_price               = isset( $skuModule[ $j ]['offer_sale_price'] ) ? self::string_to_float( $skuModule[ $j ]['offer_sale_price'] ) : 0;
						$offer_bulk_sale_price = isset( $skuModule[ $j ]['offer_bulk_sale_price'] ) ? self::string_to_float( $skuModule[ $j ]['offer_bulk_sale_price'] ) : 0;
						if ( $s_price > 0 && $offer_bulk_sale_price > $s_price ) {
							$s_price = $offer_bulk_sale_price;
						}
						$temp['skuVal']['actSkuCalPrice'] = $s_price;

						if ( $temp['skuPropIds'] ) {
							$temAttr        = array();
							$attrIds        = $temp['skuPropIds'];
							$parent_attrIds = explode( ';', $temp['skuAttr'] );

							if ( $china_id && ! in_array( $china_id, $attrIds ) && $ignore_ship_from ) {
								continue;
							}

							for ( $k = 0; $k < count( $attrIds ); $k ++ ) {
								$propertyValueId = explode( ':', $parent_attrIds[ $k ] )[0] . ':' . $attrIds[ $k ];
								if ( isset( $listAttributesDisplayNames[ $propertyValueId ] ) ) {
									$temAttr[ $attributes['list_attributes_slugs'][ $propertyValueId ] ] = $listAttributesDisplayNames[ $propertyValueId ];
									if ( ! empty( $attributes['variation_images'][ $propertyValueId ] ) ) {
										$temp['image'] = $attributes['variation_images'][ $propertyValueId ];
									}
								}
								if ( ! empty( $listAttributes[ $propertyValueId ]['ship_from'] ) ) {
									$temp['ship_from'] = $listAttributes[ $propertyValueId ]['ship_from'];
								}
							}
							$temp['variation_ids'] = $temAttr;
						}
						$variations [] = $temp;
					}
					$attributes['variations'] = $variations;
				}

				$attributes['description_url'] = '';
				$attributes['description']     = $html['ae_item_base_info_dto']['detail'];
				$attributes['specsModule']     = array();
				if ( isset( $html['ae_item_properties']['logistics_info_d_t_o'] ) && count( $html['ae_item_properties']['logistics_info_d_t_o'] ) ) {
					foreach ( $html['ae_item_properties']['logistics_info_d_t_o'] as $aeop_ae_product_property ) {
						if ( isset( $aeop_ae_product_property['attr_name'], $aeop_ae_product_property['attr_value'] ) ) {
							$attributes['specsModule'][] = array(
								'attrName'  => $aeop_ae_product_property['attr_name'],
								'attrValue' => $aeop_ae_product_property['attr_value'],
							);
						}
					}
				}
				$attributes['store_info']    = array(
					'name' => isset( $html['ae_store_info']['store_name'] ) ? $html['ae_store_info']['store_name'] : '',
					'url'  => '',
					'num'  => isset( $html['ae_store_info']['store_id'] ) ? $html['ae_store_info']['store_id'] : '',
				);
				$attributes['name']          = $html['ae_item_base_info_dto']['subject'];
				$attributes['currency_code'] = $html['ae_item_base_info_dto']['currency_code'];
			} elseif ( ! empty( $html['aeop_ae_product_s_k_us'] ) ) {
				/*Rebuild data from the old product API aliexpress.postproduct.redefining.findaeproductbyidfordropshipper*/
				if ( ( ! empty( $html['ws_offline_date'] ) && strtotime( $html['ws_offline_date'] ) < time() ) || ( ! empty( $html['product_status_type'] ) && $html['product_status_type'] === 'offline' ) ) {
					$response['status']  = 'error';
					$response['message'] = esc_html__( 'This product is no longer available', 'woocommerce-alidropship' );

					return $response;
				}
				if ( ! empty( $html['product_id'] ) ) {
					$attributes['sku'] = $html['product_id'];
				}
				$attributes['gallery'] = $html['image_u_r_ls'] ? explode( ';', $html['image_u_r_ls'] ) : array();
				if ( isset( $html['aeop_a_e_multimedia'], $html['aeop_a_e_multimedia']['aeop_a_e_videos'], $html['aeop_a_e_multimedia']['aeop_a_e_videos']['aeop_ae_video'] ) && $html['aeop_a_e_multimedia']['aeop_a_e_videos']['aeop_ae_video'] ) {
					$attributes['video'] = $html['aeop_a_e_multimedia']['aeop_a_e_videos']['aeop_ae_video'][0];
				}
				$skuModule = isset( $html['aeop_ae_product_s_k_us'] ['aeop_ae_product_sku'] ) ? $html['aeop_ae_product_s_k_us'] ['aeop_ae_product_sku'] : array();
				if ( count( $skuModule ) ) {
					$productSKUPropertyList = array();
					if ( ! empty( $skuModule[0]['aeop_s_k_u_propertys']['aeop_sku_property'] ) ) {
						for ( $i = 0; $i < count( $skuModule[0]['aeop_s_k_u_propertys']['aeop_sku_property'] ); $i ++ ) {
							$productSKUPropertyList[] = array(
								'id'     => $skuModule[0]['aeop_s_k_u_propertys']['aeop_sku_property'][ $i ]['sku_property_id'],
								'values' => array(),
								'name'   => $skuModule[0]['aeop_s_k_u_propertys']['aeop_sku_property'][ $i ]['sku_property_name'],
							);
						}
						for ( $i = 0; $i < count( $skuModule ); $i ++ ) {
							for ( $j = 0; $j < count( $productSKUPropertyList ); $j ++ ) {
								if ( ! in_array( $skuModule[ $i ]['aeop_s_k_u_propertys']['aeop_sku_property'][ $j ]['property_value_id_long'], array_column( $productSKUPropertyList[ $j ]['values'], 'id' ) ) ) {
									$property_value = array(
										'id'        => isset( $skuModule[ $i ]['aeop_s_k_u_propertys']['aeop_sku_property'][ $j ]['property_value_id_long'] ) ? $skuModule[ $i ]['aeop_s_k_u_propertys']['aeop_sku_property'][ $j ]['property_value_id_long'] : '',
										'image'     => isset( $skuModule[ $i ]['aeop_s_k_u_propertys']['aeop_sku_property'][ $j ]['sku_image'] ) ? str_replace( array(
											'ae02.alicdn.com',
											'ae03.alicdn.com',
											'ae04.alicdn.com',
											'ae05.alicdn.com',
										), 'ae01.alicdn.com', $skuModule[ $i ]['aeop_s_k_u_propertys']['aeop_sku_property'][ $j ]['sku_image'] ) : '',
										'name'      => isset( $skuModule[ $i ]['aeop_s_k_u_propertys']['aeop_sku_property'][ $j ]['sku_property_value'] ) ? $skuModule[ $i ]['aeop_s_k_u_propertys']['aeop_sku_property'][ $j ]['sku_property_value'] : '',
										'ship_from' => '',
									);
									$ship_from      = self::property_value_id_to_ship_from( $skuModule[ $i ]['aeop_s_k_u_propertys']['aeop_sku_property'][ $j ]['sku_property_id'], $property_value['id'] );
									if ( $ship_from ) {
										$property_value['ship_from'] = $ship_from;
									}
									$productSKUPropertyList[ $j ]['values'][] = $property_value;
								}
							}
						}
					}
					$china_id = '';
					if ( count( $productSKUPropertyList ) ) {
						for ( $i = 0; $i < count( $productSKUPropertyList ); $i ++ ) {
							$images            = array();
							$skuPropertyValues = $productSKUPropertyList[ $i ]['values'];
							$attr_parent_id    = $productSKUPropertyList[ $i ]['id'];
							$skuPropertyName   = wc_sanitize_taxonomy_name( $productSKUPropertyList[ $i ]['name'] );
							if ( strtolower( $skuPropertyName ) == 'ships-from' && $ignore_ship_from ) {
								foreach ( $skuPropertyValues as $value ) {
									if ( isset( $value['ship_from'] ) && $value['ship_from'] === 'CN' ) {
										$china_id = $value['id'];
									}
								}
								continue;
							} //point 1
							$attr = array(
								'values'   => array(),
								'slug'     => $skuPropertyName,
								'name'     => $productSKUPropertyList[ $i ]['name'],
								'position' => $i,
							);
							for ( $j = 0; $j < count( $skuPropertyValues ); $j ++ ) {
								$skuPropertyValue         = $skuPropertyValues[ $j ];
								$org_propertyValueId      = $skuPropertyValue['id'];
								$propertyValueId          = "{$attr_parent_id}:{$org_propertyValueId}";
								$propertyValueDisplayName = $skuPropertyValue['name'];
								if ( in_array( $propertyValueDisplayName, $listAttributesDisplayNames ) ) {
									$propertyValueDisplayName = "{$propertyValueDisplayName}-{$org_propertyValueId}";
								}
								$listAttributesNames[ $propertyValueId ]        = $skuPropertyName;
								$listAttributesDisplayNames[ $propertyValueId ] = $propertyValueDisplayName;
								$listAttributesIds[ $propertyValueId ]          = $attr_parent_id;
								$listAttributesSlug[ $propertyValueId ]         = $skuPropertyName;
								$attr['values'][ $propertyValueId ]             = $propertyValueDisplayName;
								$listAttributes[ $propertyValueId ]             = array(
									'name'      => $propertyValueDisplayName,
									'color'     => '',
									'image'     => '',
									'ship_from' => isset( $skuPropertyValue['ship_from'] ) ? $skuPropertyValue['ship_from'] : ''
								);
								if ( isset( $skuPropertyValue['image'] ) && $skuPropertyValue['image'] ) {
									$images[ $propertyValueId ]                  = $skuPropertyValue['image'];
									$variationImages[ $propertyValueId ]         = $skuPropertyValue['image'];
									$listAttributes[ $propertyValueId ]['image'] = $skuPropertyValue['image'];
								}
							}

							$attributes['list_attributes']               = $listAttributes;
							$attributes['list_attributes_names']         = $listAttributesNames;
							$attributes['list_attributes_ids']           = $listAttributesIds;
							$attributes['list_attributes_slugs']         = $listAttributesSlug;
							$attributes['variation_images']              = $variationImages;
							$attributes['attributes'][ $attr_parent_id ] = $attr;
							$attributes['images'][ $attr_parent_id ]     = $images;

							$attributes['parent'][ $attr_parent_id ] = $skuPropertyName;
						}
					}
					for ( $j = 0; $j < count( $skuModule ); $j ++ ) {
						$temp                  = array(
							'skuId'              => '',
							'skuAttr'            => ( isset( $skuModule[ $j ]['id'] ) && $skuModule[ $j ]['id'] !== '<none>' ) ? $skuModule[ $j ]['id'] : '',
							'skuPropIds'         => isset( $skuModule[ $j ]['aeop_s_k_u_propertys']['aeop_sku_property'] ) ? array_column( $skuModule[ $j ]['aeop_s_k_u_propertys']['aeop_sku_property'], 'property_value_id_long' ) : array(),
							'skuVal'             => array(
								'availQuantity'  => isset( $skuModule[ $j ]['s_k_u_available_stock'] ) ? $skuModule[ $j ]['s_k_u_available_stock'] : ( isset( $skuModule[ $j ]['ipm_sku_stock'] ) ? $skuModule[ $j ]['ipm_sku_stock'] : 0 ),
								'skuCalPrice'    => isset( $skuModule[ $j ]['sku_price'] ) ? $skuModule[ $j ]['sku_price'] : '',
								'actSkuCalPrice' => 0,
							),
							'image'              => '',
							'variation_ids'      => array(),
							'variation_ids_sub'  => array(),
							'variation_ids_slug' => array(),
							'ship_from'          => '',
							'currency_code'      => isset( $skuModule[ $j ]['currency_code'] ) ? $skuModule[ $j ]['currency_code'] : '',
						);
						$s_price               = isset( $skuModule[ $j ]['offer_sale_price'] ) ? self::string_to_float( $skuModule[ $j ]['offer_sale_price'] ) : 0;
						$offer_bulk_sale_price = isset( $skuModule[ $j ]['offer_bulk_sale_price'] ) ? self::string_to_float( $skuModule[ $j ]['offer_bulk_sale_price'] ) : 0;
						if ( $s_price > 0 && $offer_bulk_sale_price > $s_price ) {
							$s_price = $offer_bulk_sale_price;
						}
						$temp['skuVal']['actSkuCalPrice'] = $s_price;

						if ( $temp['skuPropIds'] ) {
							$temAttr        = array();
							$attrIds        = $temp['skuPropIds'];
							$parent_attrIds = explode( ';', $temp['skuAttr'] );

							if ( $china_id && ! in_array( $china_id, $attrIds ) && $ignore_ship_from ) {
								continue;
							}

							for ( $k = 0; $k < count( $attrIds ); $k ++ ) {
								$propertyValueId = explode( ':', $parent_attrIds[ $k ] )[0] . ':' . $attrIds[ $k ];
								if ( isset( $listAttributesDisplayNames[ $propertyValueId ] ) ) {
									$temAttr[ $attributes['list_attributes_slugs'][ $propertyValueId ] ] = $listAttributesDisplayNames[ $propertyValueId ];
									if ( ! empty( $attributes['variation_images'][ $propertyValueId ] ) ) {
										$temp['image'] = $attributes['variation_images'][ $propertyValueId ];
									}
								}
								if ( ! empty( $listAttributes[ $propertyValueId ]['ship_from'] ) ) {
									$temp['ship_from'] = $listAttributes[ $propertyValueId ]['ship_from'];
								}
							}
							$temp['variation_ids'] = $temAttr;
						}
						$variations [] = $temp;
					}
					$attributes['variations'] = $variations;
				}

				$attributes['description_url'] = '';
				$attributes['description']     = $html['detail'];
				$attributes['specsModule']     = array();
				if ( isset( $html['aeop_ae_product_propertys']['aeop_ae_product_property'] ) && count( $html['aeop_ae_product_propertys']['aeop_ae_product_property'] ) ) {
					foreach ( $html['aeop_ae_product_propertys']['aeop_ae_product_property'] as $aeop_ae_product_property ) {
						if ( isset( $aeop_ae_product_property['attr_name'], $aeop_ae_product_property['attr_value'] ) ) {
							$attributes['specsModule'][] = array(
								'attrName'  => $aeop_ae_product_property['attr_name'],
								'attrValue' => $aeop_ae_product_property['attr_value'],
							);
						}
					}
				}
				$attributes['store_info']    = array(
					'name' => isset( $html['store_info']['store_name'] ) ? $html['store_info']['store_name'] : '',
					'url'  => '',
					'num'  => isset( $html['store_info']['store_id'] ) ? $html['store_info']['store_id'] : '',
				);
				$attributes['name']          = $html['subject'];
				$attributes['currency_code'] = $html['currency_code'];
			}
		} else {
			/*Data passed from chrome extension in JSON format*/
			$ali_product_data = vi_wad_json_decode( $html );
			if ( json_last_error() ) {
				/*Data crawled directly with PHP is string. Find needed data in JSON then convert to array*/
				preg_match( '/{"actionModule".+}}/im', $html, $match_html );
				if ( count( $match_html ) === 1 && $match_html[0] ) {
					$html             = $match_html[0];
					$ali_product_data = vi_wad_json_decode( $html );
				} else {
					preg_match( '/{"widgets".+}}/im', $html, $match_html );
					if ( count( $match_html ) === 1 && $match_html[0] ) {
						$html             = preg_replace( '/<\/script>.+}}/im', '', $match_html[0] );
						$ali_product_data = vi_wad_json_decode( $html );
					} else {
						preg_match( '/_init_data_= { data: .+}/im', $html, $match_html );
						if ( count( $match_html ) === 1 && $match_html[0] ) {
							$html             = '{ "data"' . substr( $match_html[0], 19 );
							$html             = preg_replace( '/<\/script>.+}}/im', '', $html );
							$ali_product_data = vi_wad_json_decode( $html );
						}
					}
				}
			}
			if ( is_array( $ali_product_data ) && count( $ali_product_data ) ) {
				if ( isset( $ali_product_data['actionModule'] ) ) {
					$actionModule                      = isset( $ali_product_data['actionModule'] ) ? $ali_product_data['actionModule'] : array();
					$descriptionModule                 = isset( $ali_product_data['descriptionModule'] ) ? $ali_product_data['descriptionModule'] : array();
					$storeModule                       = isset( $ali_product_data['storeModule'] ) ? $ali_product_data['storeModule'] : array();
					$imageModule                       = isset( $ali_product_data['imageModule'] ) ? $ali_product_data['imageModule'] : array();
					$skuModule                         = isset( $ali_product_data['skuModule'] ) ? $ali_product_data['skuModule'] : array();
					$titleModule                       = isset( $ali_product_data['titleModule'] ) ? $ali_product_data['titleModule'] : array();
					$webEnv                            = isset( $ali_product_data['webEnv'] ) ? $ali_product_data['webEnv'] : array();
					$commonModule                      = isset( $ali_product_data['commonModule'] ) ? $ali_product_data['commonModule'] : array();
					$specsModule                       = isset( $ali_product_data['specsModule'] ) ? $ali_product_data['specsModule'] : array();
					$priceModule                       = isset( $ali_product_data['priceModule'] ) ? $ali_product_data['priceModule'] : array();
					$attributes['currency_code']       = isset( $webEnv['currency'] ) ? $webEnv['currency'] : '';
					$attributes['trade_currency_code'] = isset( $commonModule['tradeCurrencyCode'] ) ? $commonModule['tradeCurrencyCode'] : '';
					if ( $attributes['currency_code'] !== 'USD' && $attributes['trade_currency_code'] && $attributes['trade_currency_code'] !== 'USD' ) {
						$response['status']  = 'error';
						$response['message'] = esc_html__( 'Please switch AliExpress currency to USD', 'woocommerce-alidropship' );

						return $response;
					}
					if ( ! empty( $actionModule['productId'] ) ) {
						$attributes['sku'] = $actionModule['productId'];
					} elseif ( ! empty( $descriptionModule['productId'] ) ) {
						$attributes['sku'] = $descriptionModule['productId'];
					}
					if ( isset( $actionModule['itemStatus'] ) && intval( $actionModule['itemStatus'] ) > 0 ) {
						$response['status']  = 'error';
						$response['message'] = esc_html__( 'This product is no longer available', 'woocommerce-alidropship' );
					}
					$attributes['description_url'] = isset( $descriptionModule['descriptionUrl'] ) ? $descriptionModule['descriptionUrl'] : '';
					$attributes['specsModule']     = isset( $specsModule['props'] ) ? $specsModule['props'] : array();
					$attributes['store_info']      = array(
						'name' => $storeModule['storeName'],
						'url'  => $storeModule['storeURL'],
						'num'  => $storeModule['storeNum'],
					);
					$attributes['gallery']         = isset( $imageModule['imagePathList'] ) ? $imageModule['imagePathList'] : array();
					if ( ! empty( $imageModule['videoId'] ) && ! empty( $imageModule['videoUid'] ) ) {
						$attributes['video'] = array(
							'ali_member_id' => $imageModule['videoUid'],
							'media_id'      => $imageModule['videoId'],
							'media_type'    => '',
							'poster_url'    => '',
						);
					}
					self::handle_sku_module( $skuModule, $ignore_ship_from, $attributes );
					$attributes['name'] = isset( $titleModule['subject'] ) ? $titleModule['subject'] : '';
				} elseif ( isset( $ali_product_data['widgets'] ) ) {
					$widgets = $ali_product_data['widgets'];
					if ( is_array( $widgets ) && count( $widgets ) ) {
						$props = array();
						if ( isset( $widgets[0]['props']['quantity']['activity'] ) ) {
							$attributes['currency_code'] = self::aliexpress_ru_get_currency( $widgets );
							if ( isset( $widgets[0]['props']['itemStatus'] ) && $widgets[0]['props']['itemStatus'] == 2 ) {
								$response['status']  = 'error';
								$response['message'] = esc_html__( 'This product is no longer available', 'woocommerce-alidropship' );

								return $response;
							} else {
								$props                     = $widgets[0]['props'];
								$attributes['description'] = self::aliexpress_ru_get_description( $widgets );
								$attributes['specsModule'] = self::aliexpress_ru_get_specs_module( $widgets );
								$attributes['store_info']  = array(
									'name' => '',
									'url'  => '',
									'num'  => '',
								);
								$store_info                = self::aliexpress_ru_get_store_info( $widgets );
								if ( $store_info ) {
									$attributes['store_info']['name'] = isset( $store_info['name'] ) ? $store_info['name'] : '';
									$attributes['store_info']['url']  = isset( $store_info['url'] ) ? $store_info['url'] : '';
									$attributes['store_info']['num']  = isset( $store_info['storeNum'] ) ? $store_info['storeNum'] : '';
								}
							}
						} else {
							$attributes['currency_code'] = isset( $widgets[0]['children'][3]['props']['localization']['currencyProps']['selected']['currencyType'] ) ? $widgets[0]['children'][3]['props']['localization']['currencyProps']['selected']['currencyType'] : '';
							if ( isset( $widgets[0]['children'] ) && is_array( $widgets[0]['children'] ) ) {
								if ( count( $widgets[0]['children'] ) > 7 ) {
									if ( isset( $widgets[0]['children'][7]['children'] ) && is_array( $widgets[0]['children'][7]['children'] ) && count( $widgets[0]['children'][7]['children'] ) ) {
										$children = $widgets[0]['children'][7]['children'];
										if ( isset( $children[0]['props'] ) && is_array( $children[0]['props'] ) && count( $children[0]['props'] ) ) {
											$props = $children[0]['props'];
										}
										$attributes['description'] = isset( $widgets[0]['children'][10]['children'][1]['children'][1]['children'][0]['children'][0]['props']['html'] ) ? $widgets[0]['children'][10]['children'][1]['children'][1]['children'][0]['children'][0]['props']['html'] : '';
										$attributes['specsModule'] = isset( $widgets[0]['children'][10]['children'][1]['children'][1]['children'][2]['children'][0]['props']['char'] ) ? $widgets[0]['children'][10]['children'][1]['children'][1]['children'][2]['children'][0]['props']['char'] : array();
										$attributes['store_info']  = array(
											'name' => isset( $widgets[0]['children'][4]['props']['shop']['name'] ) ? $widgets[0]['children'][4]['props']['shop']['name'] : '',
											'url'  => isset( $widgets[0]['children'][4]['props']['shop']['url'] ) ? $widgets[0]['children'][4]['props']['shop']['url'] : '',
											'num'  => isset( $widgets[0]['children'][4]['props']['shop']['storeNum'] ) ? $widgets[0]['children'][4]['props']['shop']['storeNum'] : '',
										);
									}
								} else {
									$response['status']  = 'error';
									$response['message'] = esc_html__( 'This product is no longer available', 'woocommerce-alidropship' );
								}
							}
						}
						if ( $attributes['currency_code'] !== 'USD' ) {
							$response['status']  = 'error';
							$response['message'] = esc_html__( 'Please switch AliExpress currency to USD', 'woocommerce-alidropship' );

							return $response;
						}

						if ( count( $props ) ) {
							if ( ! empty( $props['id'] ) ) {
								$attributes['sku'] = $props['id'];
							}
							$attributes['gallery'] = array();
							if ( isset( $props['gallery'] ) && is_array( $props['gallery'] ) && count( $props['gallery'] ) ) {
								foreach ( $props['gallery'] as $gallery ) {
									if ( empty( $gallery['videoUrl'] ) ) {
										if ( ! empty( $gallery['imageUrl'] ) ) {
											$attributes['gallery'][] = $gallery['imageUrl'];
										}
									} else {
										preg_match( '/cloud.video.taobao.com\/play\/u\/(.*)\/p\/1\/e\/6\/t\/10301\//', $gallery['videoUrl'], $member_id_match );
										preg_match( '/\/p\/1\/e\/6\/t\/10301\/(.*).mp4/', $gallery['videoUrl'], $media_id_match );
										if ( $member_id_match && $media_id_match ) {
											$attributes['video'] = array(
												'ali_member_id' => $member_id_match[1],
												'media_id'      => $media_id_match[1],
												'media_type'    => '',
												'poster_url'    => empty( $gallery['imageUrl'] ) ? '' : $gallery['imageUrl'],
											);
										}
									}
								}
							}
							$skuModule = isset( $props['skuInfo'] ) ? $props['skuInfo'] : array();
							if ( count( $skuModule ) ) {
								$productSKUPropertyList = isset( $skuModule['propertyList'] ) ? $skuModule['propertyList'] : array();
								$china_id               = '';
								if ( is_array( $productSKUPropertyList ) && count( $productSKUPropertyList ) ) {
									for ( $i = 0; $i < count( $productSKUPropertyList ); $i ++ ) {
										$images            = array();
										$skuPropertyValues = $productSKUPropertyList[ $i ]['values'];
										$attr_parent_id    = $productSKUPropertyList[ $i ]['id'];
										$skuPropertyName   = wc_sanitize_taxonomy_name( $productSKUPropertyList[ $i ]['name'] );
										if ( strtolower( $skuPropertyName ) == 'ships-from' && $ignore_ship_from ) {
											foreach ( $skuPropertyValues as $value ) {
												if ( isset( $value['skuPropertySendGoodsCountryCode'] ) && $value['skuPropertySendGoodsCountryCode'] === 'CN' ) {
													$china_id = $value['id'];
												}
											}
											continue;
										} //point 1
										$attr = array(
											'values'   => array(),
											'slug'     => $skuPropertyName,
											'name'     => $productSKUPropertyList[ $i ]['name'],
											'position' => $i,
										);
										for ( $j = 0; $j < count( $skuPropertyValues ); $j ++ ) {
											$skuPropertyValue         = $skuPropertyValues[ $j ];
											$org_propertyValueId      = $skuPropertyValue['id'];
											$propertyValueId          = "{$attr_parent_id}:{$org_propertyValueId}";
											$propertyValueName        = $skuPropertyValue['name'];
											$propertyValueDisplayName = $skuPropertyValue['displayName'];
											if ( in_array( $propertyValueDisplayName, $listAttributesDisplayNames ) ) {
												$propertyValueDisplayName = "{$propertyValueDisplayName}-{$org_propertyValueId}";
											}
											if ( in_array( $propertyValueName, $propertyValueNames ) ) {
												$propertyValueName = "{$propertyValueName}-{$org_propertyValueId}";
											}
											$listAttributesNames[ $propertyValueId ]        = $skuPropertyName;
											$listAttributesDisplayNames[ $propertyValueId ] = $propertyValueDisplayName;
											$propertyValueNames[ $propertyValueId ]         = $propertyValueName;
											$listAttributesIds[ $propertyValueId ]          = $attr_parent_id;
											$listAttributesSlug[ $propertyValueId ]         = $skuPropertyName;
											$attr['values'][ $propertyValueId ]             = $propertyValueDisplayName;
											$attr['values_sub'][ $propertyValueId ]         = $propertyValueName;
											$listAttributes[ $propertyValueId ]             = array(
												'name'      => $propertyValueDisplayName,
												'name_sub'  => $propertyValueName,
												'color'     => isset( $skuPropertyValue['colorValue'] ) ? $skuPropertyValue['colorValue'] : '',
												'image'     => '',
												'ship_from' => isset( $skuPropertyValue['skuPropertySendGoodsCountryCode'] ) ? $skuPropertyValue['skuPropertySendGoodsCountryCode'] : ''
											);
											if ( isset( $skuPropertyValue['imageMainUrl'] ) && $skuPropertyValue['imageMainUrl'] ) {
												$images[ $propertyValueId ]                  = $skuPropertyValue['imageMainUrl'];
												$variationImages[ $propertyValueId ]         = $skuPropertyValue['imageMainUrl'];
												$listAttributes[ $propertyValueId ]['image'] = $skuPropertyValue['imageMainUrl'];
											}
										}

										$attributes['list_attributes']               = $listAttributes;
										$attributes['list_attributes_names']         = $listAttributesNames;
										$attributes['list_attributes_ids']           = $listAttributesIds;
										$attributes['list_attributes_slugs']         = $listAttributesSlug;
										$attributes['variation_images']              = $variationImages;
										$attributes['attributes'][ $attr_parent_id ] = $attr;
										$attributes['images'][ $attr_parent_id ]     = $images;

										$attributes['parent'][ $attr_parent_id ] = $skuPropertyName;
									}
								}

								$skuPriceList = isset( $skuModule['priceList'] ) ? $skuModule['priceList'] : array();
								for ( $j = 0; $j < count( $skuPriceList ); $j ++ ) {
									$temp = array(
										'skuId'              => isset( $skuPriceList[ $j ]['skuIdStr'] ) ? strval( $skuPriceList[ $j ]['skuIdStr'] ) : strval( $skuPriceList[ $j ]['skuId'] ),
										'skuAttr'            => isset( $skuPriceList[ $j ]['skuAttr'] ) ? $skuPriceList[ $j ]['skuAttr'] : '',
										'skuPropIds'         => isset( $skuPriceList[ $j ]['skuPropIds'] ) ? $skuPriceList[ $j ]['skuPropIds'] : '',
										'skuVal'             => array(
											'availQuantity'  => isset( $skuPriceList[ $j ]['availQuantity'] ) ? $skuPriceList[ $j ]['availQuantity'] : 0,
											'actSkuCalPrice' => isset( $skuPriceList[ $j ]['activityAmount']['value'] ) ? $skuPriceList[ $j ]['activityAmount']['value'] : '',
											'skuCalPrice'    => isset( $skuPriceList[ $j ]['amount']['value'] ) ? $skuPriceList[ $j ]['amount']['value'] : '',
										),
										'image'              => '',
										'variation_ids'      => array(),
										'variation_ids_sub'  => array(),
										'variation_ids_slug' => array(),
										'ship_from'          => '',
									);
									if ( $temp['skuPropIds'] ) {
										$temAttr        = array();
										$temAttrSub     = array();
										$attrIds        = explode( ',', $temp['skuPropIds'] );
										$parent_attrIds = explode( ';', $temp['skuAttr'] );

										if ( $china_id && ! in_array( $china_id, $attrIds ) && $ignore_ship_from ) {
											continue;
										}

										for ( $k = 0; $k < count( $attrIds ); $k ++ ) {
											$propertyValueId = explode( ':', $parent_attrIds[ $k ] )[0] . ':' . $attrIds[ $k ];
											if ( isset( $listAttributesDisplayNames[ $propertyValueId ] ) ) {
												$temAttr[ $attributes['list_attributes_slugs'][ $propertyValueId ] ]    = $listAttributesDisplayNames[ $propertyValueId ];
												$temAttrSub[ $attributes['list_attributes_slugs'][ $propertyValueId ] ] = $propertyValueNames[ $propertyValueId ];
												if ( ! empty( $attributes['variation_images'][ $propertyValueId ] ) ) {
													$temp['image'] = $attributes['variation_images'][ $propertyValueId ];
												}
											}
											if ( ! empty( $listAttributes[ $propertyValueId ]['ship_from'] ) ) {
												$temp['ship_from'] = $listAttributes[ $propertyValueId ]['ship_from'];
											}
										}
										$temp['variation_ids']     = $temAttr;
										$temp['variation_ids_sub'] = $temAttrSub;
									}
									$variations [] = $temp;
								}
								$attributes['variations'] = $variations;
							}
							$attributes['name'] = isset( $props['name'] ) ? $props['name'] : '';
						}
						$attributes['description_url'] = '';
					}
				} elseif ( isset( $ali_product_data['data']['data'] ) ) {
					$attributes['currency_code'] = self::aliexpress_pt_get_trade_currency( $ali_product_data['data']['data'] );
					if ( $attributes['currency_code'] !== 'USD' ) {
						$response['status']  = 'error';
						$response['message'] = esc_html__( 'Please switch AliExpress currency to USD', 'woocommerce-alidropship' );

						return $response;
					}
					$attributes['description_url'] = self::aliexpress_pt_get_description( $ali_product_data['data']['data'] );
					$attributes['specsModule']     = self::aliexpress_pt_get_specs_module( $ali_product_data['data']['data'] );
					$attributes['store_info']      = array(
						'name' => '',
						'url'  => '',
						'num'  => '',
					);
					$store_info                    = self::aliexpress_pt_get_store_info( $ali_product_data['data']['data'] );
					if ( $store_info ) {
						$attributes['store_info']['name'] = isset( $store_info['storeName'] ) ? $store_info['storeName'] : '';
						$attributes['store_info']['url']  = isset( $store_info['storeURL'] ) ? $store_info['storeURL'] : '';
						$attributes['store_info']['num']  = isset( $store_info['storeNum'] ) ? $store_info['storeNum'] : '';
					}
					$image_view = self::aliexpress_pt_get_image_view( $ali_product_data['data']['data'] );
					if ( $image_view ) {
						if ( isset( $image_view['videoInfo'] ) ) {
							$attributes['video'] = array(
								'ali_member_id' => isset( $image_view['videoInfo']['videoUid'] ) ? $image_view['videoInfo']['videoUid'] : '',
								'media_id'      => isset( $image_view['videoInfo']['videoId'] ) ? $image_view['videoInfo']['videoId'] : '',
								'media_type'    => '',
								'poster_url'    => '',
							);
						}
						$attributes['gallery'] = isset( $image_view['imagePathList'] ) ? $image_view['imagePathList'] : array();
					}
					$skuModule = self::aliexpress_pt_get_sku_module( $ali_product_data['data']['data'] );
					if ( $skuModule ) {
						self::handle_sku_module( $skuModule, $ignore_ship_from, $attributes );
					}
					$titleModule = self::aliexpress_pt_get_title_module( $ali_product_data['data']['data'] );
					if ( $titleModule ) {
						$attributes['name'] = isset( $titleModule['subject'] ) ? $titleModule['subject'] : '';
					}
					$actionModule = self::aliexpress_pt_get_action_module( $ali_product_data['data']['data'] );
					if ( $actionModule ) {
						$attributes['sku'] = isset( $actionModule['productId'] ) ? $actionModule['productId'] : '';
					}
				}
			} else {
				$descriptionModuleReg = '/"descriptionModule":(.*?),"features":{},"feedbackModule"/';
				preg_match( $descriptionModuleReg, $html, $descriptionModule );
				if ( $descriptionModule ) {
					$descriptionModule             = vi_wad_json_decode( $descriptionModule[1] );
					$attributes['sku']             = $descriptionModule['productId'];
					$attributes['description_url'] = $descriptionModule['descriptionUrl'];
				}

				$specsModuleReg = '/"specsModule":(.*?),"storeModule"/';
				preg_match( $specsModuleReg, $html, $specsModule );
				if ( $specsModule ) {
					$specsModule = vi_wad_json_decode( $specsModule[1] );
					if ( isset( $specsModule['props'] ) ) {
						$attributes['specsModule'] = $specsModule['props'];
					}
				}
				$storeModuleReg = '/"storeModule":(.*?),"titleModule"/';
				preg_match( $storeModuleReg, $html, $storeModule );
				if ( $storeModule ) {
					$storeModule              = vi_wad_json_decode( $storeModule[1] );
					$attributes['store_info'] = array(
						'name' => $storeModule['storeName'],
						'url'  => $storeModule['storeURL'],
						'num'  => $storeModule['storeNum'],
					);
				}
				$imagePathListReg = '/"imagePathList":(.*?),"name":"ImageModule"/';
				preg_match( $imagePathListReg, $html, $imagePathList );
				if ( $imagePathList ) {
					$imagePathList         = vi_wad_json_decode( $imagePathList[1] );
					$attributes['gallery'] = $imagePathList;
				}
				$videoIdReg = '/"videoId":(.+?),/';
				preg_match( $videoIdReg, $html, $videoId );
				$videoUidReg = '/"videoUid":(.+?)}/';
				preg_match( $videoUidReg, $html, $videoUid );
				if ( $videoId && $videoUid ) {
					$attributes['video'] = array(
						'ali_member_id' => $videoUid,
						'media_id'      => $videoId,
						'media_type'    => '',
						'poster_url'    => '',
					);
				}
				$skuModuleReg = '/"skuModule":(.*?),"specsModule"/';
				preg_match( $skuModuleReg, $html, $skuModule );
				if ( count( $skuModule ) == 2 ) {
					$skuModule              = vi_wad_json_decode( $skuModule[1] );
					$productSKUPropertyList = isset( $skuModule['productSKUPropertyList'] ) ? $skuModule['productSKUPropertyList'] : array();
					$china_id               = '';
					if ( is_array( $productSKUPropertyList ) && count( $productSKUPropertyList ) ) {
						for ( $i = 0; $i < count( $productSKUPropertyList ); $i ++ ) {
							$images            = array();
							$skuPropertyValues = $productSKUPropertyList[ $i ]['skuPropertyValues'];
							$attr_parent_id    = $productSKUPropertyList[ $i ]['skuPropertyId'];
							$skuPropertyName   = wc_sanitize_taxonomy_name( $productSKUPropertyList[ $i ]['skuPropertyName'] );
							if ( strtolower( $skuPropertyName ) == 'ships-from' && $ignore_ship_from ) {
								foreach ( $skuPropertyValues as $value ) {
									if ( $value['skuPropertySendGoodsCountryCode'] == 'CN' ) {
										$china_id = $value['propertyValueId'] ? $value['propertyValueId'] : $value['propertyValueIdLong'];
									}
								}
								continue;
							} //point 1
							$attr = array(
								'values'   => array(),
								'slug'     => $skuPropertyName,
								'name'     => $productSKUPropertyList[ $i ]['skuPropertyName'],
								'position' => $i,
							);
							for ( $j = 0; $j < count( $skuPropertyValues ); $j ++ ) {
								$skuPropertyValue                               = $skuPropertyValues[ $j ];
								$org_propertyValueId                            = $skuPropertyValue['propertyValueId'] ? $skuPropertyValue['propertyValueId'] : $skuPropertyValue['propertyValueIdLong'];
								$propertyValueId                                = "{$attr_parent_id}:{$org_propertyValueId}";
								$propertyValueName                              = $skuPropertyValue['propertyValueName'];
								$propertyValueDisplayName                       = $skuPropertyValue['propertyValueDisplayName'];
								$listAttributesNames[ $propertyValueId ]        = $skuPropertyName;
								$listAttributesDisplayNames[ $propertyValueId ] = $propertyValueDisplayName;
								$propertyValueNames[ $propertyValueId ]         = $propertyValueName;
								$listAttributesIds[ $propertyValueId ]          = $attr_parent_id;
								$listAttributesSlug[ $propertyValueId ]         = $skuPropertyName;
								$attr['values'][ $propertyValueId ]             = $propertyValueDisplayName;
								$attr['values_sub'][ $propertyValueId ]         = $propertyValueName;
								$listAttributes[ $propertyValueId ]             = array(
									'name'      => $propertyValueDisplayName,
									'name_sub'  => $propertyValueName,
									'color'     => isset( $skuPropertyValue['skuColorValue'] ) ? $skuPropertyValue['skuColorValue'] : '',
									'image'     => '',
									'ship_from' => isset( $skuPropertyValue['skuPropertySendGoodsCountryCode'] ) ? $skuPropertyValue['skuPropertySendGoodsCountryCode'] : ''
								);
								if ( isset( $skuPropertyValue['skuPropertyImagePath'] ) && $skuPropertyValue['skuPropertyImagePath'] ) {
									$images[ $propertyValueId ]                  = $skuPropertyValue['skuPropertyImagePath'];
									$variationImages[ $propertyValueId ]         = $skuPropertyValue['skuPropertyImagePath'];
									$listAttributes[ $propertyValueId ]['image'] = $skuPropertyValue['skuPropertyImagePath'];
								}
							}

							$attributes['list_attributes']               = $listAttributes;
							$attributes['list_attributes_names']         = $listAttributesNames;
							$attributes['list_attributes_ids']           = $listAttributesIds;
							$attributes['list_attributes_slugs']         = $listAttributesSlug;
							$attributes['variation_images']              = $variationImages;
							$attributes['attributes'][ $attr_parent_id ] = $attr;
							$attributes['images'][ $attr_parent_id ]     = $images;

							$attributes['parent'][ $attr_parent_id ] = $skuPropertyName;
						}
					}

					$skuPriceList = $skuModule['skuPriceList'];
					for ( $j = 0; $j < count( $skuPriceList ); $j ++ ) {
						$temp = array(
							'skuId'              => isset( $skuPriceList[ $j ]['skuIdStr'] ) ? strval( $skuPriceList[ $j ]['skuIdStr'] ) : strval( $skuPriceList[ $j ]['skuId'] ),
							'skuAttr'            => isset( $skuPriceList[ $j ]['skuAttr'] ) ? $skuPriceList[ $j ]['skuAttr'] : '',
							'skuPropIds'         => isset( $skuPriceList[ $j ]['skuPropIds'] ) ? $skuPriceList[ $j ]['skuPropIds'] : '',
							'skuVal'             => $skuPriceList[ $j ]['skuVal'],
							'image'              => '',
							'variation_ids'      => array(),
							'variation_ids_sub'  => array(),
							'variation_ids_slug' => array(),
							'ship_from'          => '',
						);
						if ( $temp['skuPropIds'] ) {
							$temAttr        = array();
							$temAttrSub     = array();
							$attrIds        = explode( ',', $temp['skuPropIds'] );
							$parent_attrIds = explode( ';', $temp['skuAttr'] );

							if ( $china_id && ! in_array( $china_id, $attrIds ) && $ignore_ship_from ) {
								continue;
							}

							for ( $k = 0; $k < count( $attrIds ); $k ++ ) {
								$propertyValueId = explode( ':', $parent_attrIds[ $k ] )[0] . ':' . $attrIds[ $k ];
								if ( isset( $listAttributesDisplayNames[ $propertyValueId ] ) ) {
									$temAttr[ $attributes['list_attributes_slugs'][ $propertyValueId ] ]    = $listAttributesDisplayNames[ $propertyValueId ];
									$temAttrSub[ $attributes['list_attributes_slugs'][ $propertyValueId ] ] = $propertyValueNames[ $propertyValueId ];
									if ( ! empty( $attributes['variation_images'][ $propertyValueId ] ) ) {
										$temp['image'] = $attributes['variation_images'][ $propertyValueId ];
									}
								}
								if ( ! empty( $listAttributes[ $propertyValueId ]['ship_from'] ) ) {
									$temp['ship_from'] = $listAttributes[ $propertyValueId ]['ship_from'];
								}
							}
							$temp['variation_ids']     = $temAttr;
							$temp['variation_ids_sub'] = $temAttrSub;
						}
						$variations [] = $temp;
					}
					$attributes['variations'] = $variations;
				}
				$titleModuleReg = '/"titleModule":(.*?),"webEnv"/';
				preg_match( $titleModuleReg, $html, $titleModule );
				if ( count( $titleModule ) == 2 ) {
					$titleModule        = vi_wad_json_decode( $titleModule[1] );
					$attributes['name'] = $titleModule['subject'];
				}

				$webEnvReg = '/"webEnv":(.*?)}}/';
				preg_match( $webEnvReg, $html, $webEnv );
				if ( count( $webEnv ) == 2 ) {
					$webEnv                      = vi_wad_json_decode( $webEnv[1] . '}' );
					$attributes['currency_code'] = $webEnv['currency'];
				}
			}
			if ( ! $attributes['sku'] ) {
				$search  = array( "\n", "\r", "\t" );
				$replace = array( "", "", "" );
				$html    = str_replace( $search, $replace, $html );
				$regSku  = '/window\.runParams\.productId="([\s\S]*?)";/im';
				preg_match( $regSku, $html, $match_product_sku );
				if ( count( $match_product_sku ) === 2 && $match_product_sku[1] ) {
					$attributes['sku'] = $match_product_sku[1];
					$reg               = '/var skuProducts=(\[[\s\S]*?]);/im';
					$regId             = '/<a[\s\S]*?data-sku-id="(\d*?)"[\s\S]*?>(.*?)<\/a>/im';
					$regTitle          = '/<dt class="p-item-title">(.*?)<\/dt>[\s\S]*?data-sku-prop-id="(.*?)"/im';
					$regGallery        = '/imageBigViewURL=(\[[\s\S]*?]);/im';
					$regCurrencyCode   = '/window\.runParams\.currencyCode="([\s\S]*?)";/im';
					$regDetailDesc     = '/window\.runParams\.detailDesc="([\s\S]*?)";/im';
					$regOffline        = '/window\.runParams\.offline=([\s\S]*?);/im';
					$regName           = '/class="product-name" itemprop="name">([\s\S]*?)<\/h1>/im';
					$regDescription    = '/<ul class="product-property-list util-clearfix">([\s\S]*?)<\/ul>/im';
					preg_match( $regOffline, $html, $offlineMatches );
					if ( count( $offlineMatches ) == 2 ) {
						$offline = $offlineMatches[1];
					}

					preg_match( $reg, $html, $matches );
					if ( $matches ) {
						$productVariationMaps = vi_wad_json_decode( $matches[1] );
					}

					preg_match( $regDetailDesc, $html, $detailDescMatches );
					if ( $detailDescMatches ) {
						$attributes['description_url'] = $detailDescMatches[1];
					}

					preg_match( $regDescription, $html, $regDescriptionMatches );
					if ( $regDescriptionMatches ) {
						$attributes['short_description'] = $regDescriptionMatches[0];
					}

					$reg = '/<dl class="p-property-item">([\s\S]*?)<\/dl>/im';
					preg_match_all( $reg, $html, $matches );

					if ( count( $matches[0] ) ) {
						$match_variations = $matches[0];
						$title            = '';
						$titleSlug        = '';
						$reTitle1         = '/title="(.*?)"/mi';
						$reImage          = '/bigpic="(.*?)"/mi';
						$attr_parent_id   = '';
						for ( $i = 0; $i < count( $match_variations ); $i ++ ) {
							preg_match( $regTitle, $match_variations[ $i ], $matchTitle );

							if ( count( $matchTitle ) == 3 ) {
								$title          = $matchTitle[1];
								$title          = substr( $title, 0, strlen( $title ) - 1 );
								$titleSlug      = strtolower( trim( preg_replace( '/[^\w]+/i', '-', $title ) ) );
								$attr_parent_id = $matchTitle[2];
							}

							$attr   = array();
							$images = array();
							preg_match_all( $regId, $match_variations[ $i ], $matchId );

							if ( count( $matchId ) == 3 ) {
								foreach ( $matchId[1] as $matchID_k => $matchID_v ) {
									$listAttributesNames[ $matchID_v ] = $title;
									$listAttributesIds[ $matchID_v ]   = $attr_parent_id;
									$listAttributesSlug[ $matchID_v ]  = $titleSlug;
									preg_match( $reTitle1, $matchId[2][ $matchID_k ], $title1 );

									if ( count( $title1 ) == 2 ) {
										$attr[ $matchID_v ]           = $title1[1];
										$listAttributes[ $matchID_v ] = $title1[1];
									} else {
										$end                          = strlen( $matchId[2][ $matchID_k ] ) - 13;
										$attr[ $matchID_v ]           = substr( $matchId[2][ $matchID_k ], 6, $end );
										$listAttributes[ $matchID_v ] = $attr[ $matchID_v ];
									}

									preg_match( $reImage, $matchId[2][ $matchID_k ], $image );

									if ( count( $image ) == 2 ) {
										$images[ $matchID_v ]          = $image[1];
										$variationImages[ $matchID_v ] = $image[1];
									}
								}

							}
							$attributes['list_attributes']               = $listAttributes;
							$attributes['list_attributes_names']         = $listAttributesNames;
							$attributes['list_attributes_ids']           = $listAttributesIds;
							$attributes['list_attributes_slugs']         = $listAttributesSlug;
							$attributes['variation_images']              = $variationImages;
							$attributes['attributes'][ $attr_parent_id ] = $attr;
							if ( count( $images ) > 0 ) {
								$attributes['images'][ $attr_parent_id ] = $images;
							}
							$attributes['parent'][ $attr_parent_id ]             = $title;
							$attributes['attribute_position'][ $attr_parent_id ] = $i;
							$attributes['parent_slug'][ $attr_parent_id ]        = $titleSlug;
						}
					}

					preg_match( $regGallery, $html, $matchGallery );
					if ( count( $matchGallery ) == 2 ) {
						$attributes['gallery'] = vi_wad_json_decode( $matchGallery[1] );
					}

					for ( $j = 0; $j < count( $productVariationMaps ); $j ++ ) {
						$temp = array(
							'skuId'         => isset( $productVariationMaps[ $j ]['skuIdStr'] ) ? strval( $productVariationMaps[ $j ]['skuIdStr'] ) : strval( $productVariationMaps[ $j ]['skuId'] ),
							'skuPropIds'    => isset( $productVariationMaps[ $j ]['skuPropIds'] ) ? $productVariationMaps[ $j ]['skuPropIds'] : '',
							'skuAttr'       => isset( $productVariationMaps[ $j ]['skuAttr'] ) ? $productVariationMaps[ $j ]['skuAttr'] : '',
							'skuVal'        => $productVariationMaps[ $j ]['skuVal'],
							'image'         => '',
							'variation_ids' => array(),
						);

						if ( $temp['skuPropIds'] ) {
							$temAttr = array();
							$attrIds = explode( ',', $temp['skuPropIds'] );
							for ( $k = 0; $k < count( $attrIds ); $k ++ ) {
								$temAttr[ $attributes['list_attributes_slugs'][ $attrIds[ $k ] ] ] = $attributes['list_attributes'][ $attrIds[ $k ] ];
							}
							$temp['variation_ids'] = $temAttr;
							$temp['image']         = $attributes['variation_images'][ $attrIds[0] ];
						}
						array_push( $variations, $temp );
					}
					$attributes['variations'] = $variations;
					preg_match( $regName, $html, $matchName );
					if ( count( $matchName ) == 2 ) {
						$attributes['name'] = $matchName[1];
					}
					preg_match( $regCurrencyCode, $html, $matchCurrency );
					if ( count( $matchCurrency ) == 2 ) {
						$attributes['currency_code'] = $matchCurrency[1];
					}
				}
			}
		}

		if ( $attributes['sku'] ) {
			$response['data'] = $attributes;
		} else {
			$response['status'] = 'error';
		}

		return $response;
	}

	private static function handle_sku_module( $skuModule, $ignore_ship_from, &$attributes ) {
		if ( is_array( $skuModule ) && count( $skuModule ) ) {
			$listAttributes             = array();
			$listAttributesDisplayNames = array();
			$propertyValueNames         = array();
			$listAttributesNames        = array();
			$listAttributesSlug         = array();
			$listAttributesIds          = array();
			$variationImages            = array();
			$variations                 = array();
			$productSKUPropertyList     = array();
			if ( isset( $skuModule['productSKUPropertyList'] ) ) {
				$productSKUPropertyList = $skuModule['productSKUPropertyList'];
			} elseif ( isset( $skuModule['propertyList'] ) ) {
				$productSKUPropertyList = $skuModule['propertyList'];
			}
			$china_id = '';
			if ( is_array( $productSKUPropertyList ) && count( $productSKUPropertyList ) ) {
				for ( $i = 0; $i < count( $productSKUPropertyList ); $i ++ ) {
					$images            = array();
					$skuPropertyValues = $productSKUPropertyList[ $i ]['skuPropertyValues'];
					$attr_parent_id    = $productSKUPropertyList[ $i ]['skuPropertyId'];
					$skuPropertyName   = wc_sanitize_taxonomy_name( $productSKUPropertyList[ $i ]['skuPropertyName'] );
					if ( strtolower( $skuPropertyName ) == 'ships-from' && $ignore_ship_from ) {
						foreach ( $skuPropertyValues as $value ) {
							if ( $value['skuPropertySendGoodsCountryCode'] == 'CN' ) {
								$china_id = $value['propertyValueId'] ? $value['propertyValueId'] : $value['propertyValueIdLong'];
							}
						}
						continue;
					} //point 1
					$attr = array(
						'values'   => array(),
						'slug'     => $skuPropertyName,
						'name'     => $productSKUPropertyList[ $i ]['skuPropertyName'],
						'position' => $i,
					);
					for ( $j = 0; $j < count( $skuPropertyValues ); $j ++ ) {
						$skuPropertyValue         = $skuPropertyValues[ $j ];
						$org_propertyValueId      = $skuPropertyValue['propertyValueId'] ? $skuPropertyValue['propertyValueId'] : $skuPropertyValue['propertyValueIdLong'];
						$propertyValueId          = "{$attr_parent_id}:{$org_propertyValueId}";
						$propertyValueName        = $skuPropertyValue['propertyValueName'];
						$propertyValueDisplayName = $skuPropertyValue['propertyValueDisplayName'];
						if ( in_array( $propertyValueDisplayName, $listAttributesDisplayNames ) ) {
							$propertyValueDisplayName = "{$propertyValueDisplayName}-{$org_propertyValueId}";
						}
						if ( in_array( $propertyValueName, $propertyValueNames ) ) {
							$propertyValueName = "{$propertyValueName}-{$org_propertyValueId}";
						}
						$listAttributesNames[ $propertyValueId ]        = $skuPropertyName;
						$listAttributesDisplayNames[ $propertyValueId ] = $propertyValueDisplayName;
						$propertyValueNames[ $propertyValueId ]         = $propertyValueName;
						$listAttributesIds[ $propertyValueId ]          = $attr_parent_id;
						$listAttributesSlug[ $propertyValueId ]         = $skuPropertyName;
						$attr['values'][ $propertyValueId ]             = $propertyValueDisplayName;
						$attr['values_sub'][ $propertyValueId ]         = $propertyValueName;
						$listAttributes[ $propertyValueId ]             = array(
							'name'      => $propertyValueDisplayName,
							'name_sub'  => $propertyValueName,
							'color'     => isset( $skuPropertyValue['skuColorValue'] ) ? $skuPropertyValue['skuColorValue'] : '',
							'image'     => '',
							'ship_from' => isset( $skuPropertyValue['skuPropertySendGoodsCountryCode'] ) ? $skuPropertyValue['skuPropertySendGoodsCountryCode'] : ''
						);
						if ( isset( $skuPropertyValue['skuPropertyImagePath'] ) && $skuPropertyValue['skuPropertyImagePath'] ) {
							$images[ $propertyValueId ]                  = $skuPropertyValue['skuPropertyImagePath'];
							$variationImages[ $propertyValueId ]         = $skuPropertyValue['skuPropertyImagePath'];
							$listAttributes[ $propertyValueId ]['image'] = $skuPropertyValue['skuPropertyImagePath'];
						}
					}

					$attributes['list_attributes']               = $listAttributes;
					$attributes['list_attributes_names']         = $listAttributesNames;
					$attributes['list_attributes_ids']           = $listAttributesIds;
					$attributes['list_attributes_slugs']         = $listAttributesSlug;
					$attributes['variation_images']              = $variationImages;
					$attributes['attributes'][ $attr_parent_id ] = $attr;
					$attributes['images'][ $attr_parent_id ]     = $images;

					$attributes['parent'][ $attr_parent_id ] = $skuPropertyName;
				}
			}

			$skuPriceList = array();
			if ( isset( $skuModule['skuPriceList'] ) ) {
				$skuPriceList = $skuModule['skuPriceList'];
			} elseif ( isset( $skuModule['skuList'] ) ) {
				$skuPriceList = $skuModule['skuList'];
			}
			for ( $j = 0; $j < count( $skuPriceList ); $j ++ ) {
				$temp = array(
					'skuId'              => isset( $skuPriceList[ $j ]['skuIdStr'] ) ? strval( $skuPriceList[ $j ]['skuIdStr'] ) : strval( $skuPriceList[ $j ]['skuId'] ),
					'skuAttr'            => isset( $skuPriceList[ $j ]['skuAttr'] ) ? $skuPriceList[ $j ]['skuAttr'] : '',
					'skuPropIds'         => isset( $skuPriceList[ $j ]['skuPropIds'] ) ? $skuPriceList[ $j ]['skuPropIds'] : '',
					'skuVal'             => $skuPriceList[ $j ]['skuVal'],
					'image'              => '',
					'variation_ids'      => array(),
					'variation_ids_sub'  => array(),
					'variation_ids_slug' => array(),
					'ship_from'          => '',
				);
				if ( $temp['skuPropIds'] ) {
					$temAttr        = array();
					$temAttrSub     = array();
					$attrIds        = explode( ',', $temp['skuPropIds'] );
					$parent_attrIds = explode( ';', $temp['skuAttr'] );

					if ( $china_id && ! in_array( $china_id, $attrIds ) && $ignore_ship_from ) {
						continue;
					}

					for ( $k = 0; $k < count( $attrIds ); $k ++ ) {
						$propertyValueId = explode( ':', $parent_attrIds[ $k ] )[0] . ':' . $attrIds[ $k ];
						if ( isset( $listAttributesDisplayNames[ $propertyValueId ] ) ) {
							$temAttr[ $attributes['list_attributes_slugs'][ $propertyValueId ] ]    = $listAttributesDisplayNames[ $propertyValueId ];
							$temAttrSub[ $attributes['list_attributes_slugs'][ $propertyValueId ] ] = $propertyValueNames[ $propertyValueId ];
							if ( ! empty( $attributes['variation_images'][ $propertyValueId ] ) ) {
								$temp['image'] = $attributes['variation_images'][ $propertyValueId ];
							}
						}
						if ( ! empty( $listAttributes[ $propertyValueId ]['ship_from'] ) ) {
							$temp['ship_from'] = $listAttributes[ $propertyValueId ]['ship_from'];
						}
					}
					$temp['variation_ids']     = $temAttr;
					$temp['variation_ids_sub'] = $temAttrSub;
				}
				$variations [] = $temp;
			}
			$attributes['variations'] = $variations;
		}
	}

	/**
	 * @return string
	 */
	public static function get_user_agent() {
		$user_agent_list = get_option( 'vi_wad_user_agent_list' );
		if ( ! $user_agent_list ) {
			$user_agent_list = '["Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.100 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64; rv:67.0) Gecko\/20100101 Firefox\/67.0","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit\/605.1.15 (KHTML, like Gecko) Version\/12.1.1 Safari\/605.1.15","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.80 Safari\/537.36","Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (X11; Ubuntu; Linux x86_64; rv:67.0) Gecko\/20100101 Firefox\/67.0","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10.14; rv:67.0) Gecko\/20100101 Firefox\/67.0","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.100 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; WOW64) AppleWebKit\/537.36 (KHTML, like Gecko) HeadlessChrome\/60.0.3112.78 Safari\/537.36","Mozilla\/5.0 (Windows NT 6.1; rv:60.0) Gecko\/20100101 Firefox\/60.0","Mozilla\/5.0 (Windows NT 6.1; Win64; x64; rv:67.0) Gecko\/20100101 Firefox\/67.0","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.90 Safari\/537.36","Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.100 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/64.0.3282.140 Safari\/537.36 Edge\/17.17134","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (X11; Linux x86_64; rv:67.0) Gecko\/20100101 Firefox\/67.0","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.131 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/64.0.3282.140 Safari\/537.36 Edge\/18.17763","Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.80 Safari\/537.36","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit\/605.1.15 (KHTML, like Gecko) Version\/12.1 Safari\/605.1.15","Mozilla\/5.0 (Windows NT 10.0; WOW64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit\/605.1.15 (KHTML, like Gecko) Version\/12.1.1 Safari\/605.1.15","Mozilla\/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.100 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; WOW64; Trident\/7.0; rv:11.0) like Gecko","Mozilla\/5.0 (X11; Linux x86_64; rv:60.0) Gecko\/20100101 Firefox\/60.0","Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/73.0.3683.103 Safari\/537.36 OPR\/60.0.3255.151","Mozilla\/5.0 (Windows NT 6.1; WOW64; Trident\/7.0; rv:11.0) like Gecko","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.80 Safari\/537.36","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10.13; rv:67.0) Gecko\/20100101 Firefox\/67.0","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/73.0.3683.103 Safari\/537.36","Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.80 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/62.0.3202.94 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.157 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64; rv:66.0) Gecko\/20100101 Firefox\/66.0","Mozilla\/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko\/20100101 Firefox\/68.0","Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/72.0.3626.109 Safari\/537.36","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.90 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/73.0.3683.103 Safari\/537.36 OPR\/60.0.3255.109","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/73.0.3683.103 Safari\/537.36 OPR\/60.0.3255.170","Mozilla\/5.0 (Windows NT 6.3; Win64; x64; rv:67.0) Gecko\/20100101 Firefox\/67.0","Mozilla\/5.0 (Windows NT 10.0; WOW64; rv:67.0) Gecko\/20100101 Firefox\/67.0","Mozilla\/5.0 (iPad; CPU OS 12_3_1 like Mac OS X) AppleWebKit\/605.1.15 (KHTML, like Gecko) Version\/12.1.1 Mobile\/15E148 Safari\/604.1","Mozilla\/5.0 (Windows NT 6.1; WOW64) AppleWebKit\/537.36 (KHTML, like Gecko) HeadlessChrome\/60.0.3112.78 Safari\/537.36","Mozilla\/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.100 Safari\/537.36","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.100 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; WOW64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 YaBrowser\/19.6.1.153 Yowser\/2.5 Safari\/537.36","Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/70.0.3538.77 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; WOW64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/73.0.3683.103 YaBrowser\/19.4.3.370 Yowser\/2.5 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; WOW64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 YaBrowser\/19.6.0.1574 Yowser\/2.5 Safari\/537.36","Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Ubuntu Chromium\/74.0.3729.169 Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (Windows NT 6.1) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.131 Safari\/537.36","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14) AppleWebKit\/605.1.15 (KHTML, like Gecko) Version\/12.0 Safari\/605.1.15","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/73.0.3683.86 Safari\/537.36","Mozilla\/5.0 (Linux; U; Android 4.3; en-us; SM-N900T Build\/JSS15J) AppleWebKit\/534.30 (KHTML, like Gecko) Version\/4.0 Mobile Safari\/534.30","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit\/605.1.15 (KHTML, like Gecko) Version\/12.0.3 Safari\/605.1.15","Mozilla\/5.0 (Windows NT 6.1) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.100 Safari\/537.36","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit\/605.1.15 (KHTML, like Gecko) Version\/11.1.2 Safari\/605.1.15","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.80 Safari\/537.36","Mozilla\/5.0 (Windows NT 6.1; WOW64; rv:67.0) Gecko\/20100101 Firefox\/67.0","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_2) AppleWebKit\/605.1.15 (KHTML, like Gecko) Version\/12.0.2 Safari\/605.1.15","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.100 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko\/20100101 Firefox\/45.0","Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.90 Safari\/537.36","Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.157 Safari\/537.36","Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.90 Safari\/537.36","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_14_2) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.169 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/72.0.3626.121 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/73.0.3683.86 Safari\/537.36","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/75.0.3770.100 Safari\/537.36","Mozilla\/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko\/20100101 Firefox\/60.0","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10.12; rv:67.0) Gecko\/20100101 Firefox\/67.0","Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_15) AppleWebKit\/605.1.15 (KHTML, like Gecko) Version\/13.0 Safari\/605.1.15","Mozilla\/5.0 (Windows NT 6.1; rv:67.0) Gecko\/20100101 Firefox\/67.0","Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/73.0.3683.103 Safari\/537.36 OPR\/60.0.3255.151","Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/73.0.3683.103 Safari\/537.36 OPR\/60.0.3255.170","Mozilla\/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/74.0.3729.131 Safari\/537.36","Mozilla\/5.0 (Windows NT 6.1; WOW64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/73.0.3683.103 YaBrowser\/19.4.3.370 Yowser\/2.5 Safari\/537.36","Mozilla\/5.0 (Windows NT 6.1; WOW64; rv:56.0) Gecko\/20100101 Firefox\/56.0","Mozilla\/5.0 (Windows NT 6.1; WOW64; rv:56.0) Gecko\/20100101 Firefox\/56.0"]';
			update_option( 'vi_wad_user_agent_list', $user_agent_list );
		}
		$user_agent_list_array = vi_wad_json_decode( $user_agent_list );
		$return_agent          = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36';
		$last_used             = get_option( 'vi_wad_last_used_user_agent', 0 );
		if ( $last_used == count( $user_agent_list_array ) - 1 ) {
			$last_used = 0;
			shuffle( $user_agent_list_array );
			update_option( 'vi_wad_user_agent_list', json_encode( $user_agent_list_array ) );
		} else {
			$last_used ++;
		}
		update_option( 'vi_wad_last_used_user_agent', $last_used );
		if ( isset( $user_agent_list_array[ $last_used ] ) && $user_agent_list_array[ $last_used ] ) {
			$return_agent = $user_agent_list_array[ $last_used ];
		}

		return $return_agent;
	}

	/**
	 * @param string $sku
	 *
	 * @return bool
	 */
	public static function sku_exists( $sku = '' ) {
		$sku_exists = false;
		if ( $sku ) {
			$id_from_sku = wc_get_product_id_by_sku( $sku );
			$product     = $id_from_sku ? wc_get_product( $id_from_sku ) : false;
			$sku_exists  = $product && 'importing' !== $product->get_status();
		}

		return $sku_exists;
	}

	public static function set( $name, $set_name = false ) {
		if ( is_array( $name ) ) {
			return implode( ' ', array_map( array( 'VI_WOOCOMMERCE_ALIDROPSHIP_DATA', 'set' ), $name ) );
		} else {
			if ( $set_name ) {
				return esc_attr( str_replace( '-', '_', self::$prefix . $name ) );
			} else {
				return esc_attr( self::$prefix . $name );
			}
		}
	}

	public function get_product_params() {
		return array(
			'product_status'            => 'publish',
			'catalog_visibility'        => 'visible',
			'product_gallery'           => 1,
			'product_categories'        => array(),
			'product_shipping_class'    => '',
			'product_tags'              => array(),
			'product_description'       => 'item_specifics_and_description',
			'product_sku'               => '{ali_product_id}',
			'variation_visible'         => '',
			'manage_stock'              => '1',
			'ignore_ship_from'          => 0,
			'price_from'                => array( 0 ),
			'price_to'                  => array( '' ),
			'plus_value'                => array( 200 ),
			'plus_sale_value'           => array( - 1 ),
			'plus_value_type'           => array( 'percent' ),
			'price_default'             => array(
				'plus_value'      => 2,
				'plus_sale_value' => 1,
				'plus_value_type' => 'multiply',
			),
			'auto_generate_unique_sku'  => '1',
			'simple_if_one_variation'   => '',
			'use_global_attributes'     => '1',
			'format_price_rules_enable' => '',
			'format_price_rules_test'   => 0,
			'format_price_rules'        => array(),
		);
	}

	public function get_default( $name = "" ) {
		if ( ! $name ) {
			return $this->default;
		} elseif ( isset( $this->default[ $name ] ) ) {
			return apply_filters( 'wooaliexpressdropship_params_default_' . $name, $this->default[ $name ] );
		} else {
			return false;
		}
	}

	/**
	 * @param $string_number
	 *
	 * @return float
	 */
	public static function string_to_float( $string_number ) {
		return floatval( str_replace( ',', '', $string_number ) );
	}

	/**
	 * @param $price
	 * @param bool $is_product_price
	 *
	 * @return float|int
	 */
	public function process_exchange_price( $price, $is_product_price = true ) {
		if ( ! $price ) {
			return $price;
		}
		$rate = floatval( $this->get_params( 'import_currency_rate' ) );
		if ( $rate ) {
			$price = $price * $rate;
		}
		if ( $is_product_price && $this->get_params( 'format_price_rules_enable' ) ) {
			self::format_price( $price );
		}

		return round( $price, wc_get_price_decimals() );
	}

	protected static function calculate_price_base_on_type( $price, $value, $type ) {
		$match_value = floatval( $value );
		switch ( $type ) {
			case 'fixed':
				$price = $price + $match_value;
				break;
			case 'percent':
				$price = $price * ( 1 + $match_value / 100 );
				break;
			case 'multiply':
				$price = $price * $match_value;
				break;
			default:
				$price = $match_value;
		}

		return $price;
	}

	/**
	 * @param $price
	 * @param bool $is_sale_price
	 *
	 * @return float|int
	 */
	public function process_price( $price, $is_sale_price = false ) {
		if ( ! $price ) {
			return $price;
		}
		$original_price  = $price;
		$price_default   = $this->get_params( 'price_default' );
		$price_from      = $this->get_params( 'price_from' );
		$price_to        = $this->get_params( 'price_to' );
		$plus_value_type = $this->get_params( 'plus_value_type' );

		if ( $is_sale_price ) {
			$plus_sale_value = $this->get_params( 'plus_sale_value' );
			$level_count     = count( $price_from );
			if ( $level_count > 0 ) {
				/*adjust price rules since version 1.0.1.1*/
				if ( ! is_array( $price_to ) || count( $price_to ) !== $level_count ) {
					if ( $level_count > 1 ) {
						$price_to   = array_values( array_slice( $price_from, 1 ) );
						$price_to[] = '';
					} else {
						$price_to = array( '' );
					}
				}
				$match = false;
				for ( $i = 0; $i < $level_count; $i ++ ) {
					if ( $price >= $price_from[ $i ] && ( $price_to[ $i ] === '' || $price <= $price_to[ $i ] ) ) {
						$match = $i;
						break;
					}
				}
				if ( $match !== false ) {
					if ( $plus_sale_value[ $match ] < 0 ) {
						$price = 0;
					} else {
						$price = self::calculate_price_base_on_type( $price, $plus_sale_value[ $match ], $plus_value_type[ $match ] );
					}
				} else {
					$plus_sale_value_default = isset( $price_default['plus_sale_value'] ) ? $price_default['plus_sale_value'] : 1;
					if ( $plus_sale_value_default < 0 ) {
						$price = 0;
					} else {
						$price = self::calculate_price_base_on_type( $price, $plus_sale_value_default, isset( $price_default['plus_value_type'] ) ? $price_default['plus_value_type'] : 'multiply' );
					}
				}
			}
		} else {
			$plus_value  = $this->get_params( 'plus_value' );
			$level_count = count( $price_from );
			if ( $level_count > 0 ) {
				/*adjust price rules since version 1.0.1.1*/
				if ( ! is_array( $price_to ) || count( $price_to ) !== $level_count ) {
					if ( $level_count > 1 ) {
						$price_to   = array_values( array_slice( $price_from, 1 ) );
						$price_to[] = '';
					} else {
						$price_to = array( '' );
					}
				}
				$match = false;
				for ( $i = 0; $i < $level_count; $i ++ ) {
					if ( $price >= $price_from[ $i ] && ( $price_to[ $i ] === '' || $price <= $price_to[ $i ] ) ) {
						$match = $i;
						break;
					}
				}
				if ( $match !== false ) {
					$price = self::calculate_price_base_on_type( $price, $plus_value[ $match ], $plus_value_type[ $match ] );
				} else {
					$price = self::calculate_price_base_on_type( $price, isset( $price_default['plus_value'] ) ? $price_default['plus_value'] : 2, isset( $price_default['plus_value_type'] ) ? $price_default['plus_value_type'] : 'multiply' );
				}
			}
		}

		return apply_filters( 'vi_wad_processed_price', $price, $is_sale_price, $original_price );
	}

	public static function format_price( &$price ) {
		$applied = array();
		if ( $price ) {
			$instance = self::get_instance();
			$rules    = $instance->get_params( 'format_price_rules' );
			if ( is_array( $rules ) && count( $rules ) ) {
				$decimals        = wc_get_price_decimals();
				$price           = self::string_to_float( $price );
				$int_part        = intval( $price );
				$decimal_part    = number_format( $price - $int_part, $decimals );
				$int_part_length = strlen( $int_part );
				if ( $decimals > 0 ) {
					foreach ( $rules as $key => $rule ) {
						if ( $rule['part'] === 'fraction' ) {
							if ( ( ! $rule['from'] && ! $rule['to'] ) || ( $price >= $rule['from'] && $price <= $rule['to'] ) || ( ! $rule['from'] && $price <= $rule['to'] ) || ( ! $rule['to'] && $price >= $rule['from'] ) ) {
								$compare_value = $decimal_part;
								$string        = substr( strval( $decimal_part ), 2 );
								if ( ( $rule['value_from'] === '' && $rule['value_to'] === '' ) || ( $compare_value >= self::string_to_float( ".{$rule['value_from']}" ) && $compare_value <= self::string_to_float( ".{$rule['value_to']}" ) ) || ( $rule['value_from'] === '' && $compare_value <= self::string_to_float( ".{$rule['value_to']}" ) ) || ( $rule['value_to'] === '' && $compare_value >= self::string_to_float( ".{$rule['value_from']}" ) ) ) {
									while ( ( $pos = strpos( $rule['value'], 'x' ) ) !== false ) {
										$replace = 'y';
										if ( $pos < strlen( $string ) ) {
											$replace = substr( $string, $pos, 1 );
										}
										$rule['value'] = substr_replace( $rule['value'], $replace, $pos, 1 );
									}
									$price        = $int_part + self::string_to_float( ".{$rule['value']}" );
									$decimal_part = $price - $int_part;
									$applied[]    = $key;
									break;
								}
							}
						}
					}
				}

				foreach ( $rules as $key => $rule ) {
					if ( $rule['part'] === 'integer' ) {
						if ( $price >= $rule['from'] && $price <= $rule['to'] ) {
							if ( $rule['value_from'] === '' && $rule['value_to'] === '' ) {
								$max = min( $int_part_length - 1, strlen( $rule['value'] ) );
								if ( $max > 0 ) {
									$compare_value = intval( substr( $int_part, $int_part_length - $max ) );
									$string        = strval( zeroise( $compare_value, $max ) );
									$rule['value'] = zeroise( $rule['value'], $max );
									while ( ( $pos = strpos( $rule['value'], 'x' ) ) !== false ) {
										$replace = 'y';
										if ( $pos < strlen( $string ) ) {
											$replace = substr( $string, $pos, 1 );
										}
										$rule['value'] = substr_replace( $rule['value'], $replace, $pos, 1 );
									}
									$price     = $int_part - $compare_value + intval( $rule['value'] ) + $decimal_part;
									$applied[] = $key;
									break;
								}
							} else {
								$max = min( $int_part_length, max( strlen( $rule['value_from'] ), strlen( $rule['value_to'] ), strlen( $rule['value'] ) ) );
								if ( $max > 0 ) {
									$compare_value = intval( substr( $int_part, $int_part_length - $max ) );
									$string        = strval( zeroise( $compare_value, $max ) );
									$rule['value'] = zeroise( $rule['value'], $max );
									if ( ( $compare_value >= intval( $rule['value_from'] ) && $compare_value <= intval( $rule['value_to'] ) ) ) {
										while ( ( $pos = strpos( $rule['value'], 'x' ) ) !== false ) {
											$replace = 'y';
											if ( $pos < strlen( $string ) ) {
												$replace = substr( $string, $pos, 1 );
											}
											$rule['value'] = substr_replace( $rule['value'], $replace, $pos, 1 );
										}
										$price     = $int_part - $compare_value + intval( $rule['value'] ) + $decimal_part;
										$applied[] = $key;
										break;
									}
								}
							}
						}
					}
				}
			}
		}

		return $applied;
	}

	/**
	 * @param $sku
	 * @param $variation_ids
	 *
	 * @return string
	 */
	public static function process_variation_sku( $sku, $variation_ids ) {
		$return = '';
		if ( is_array( $variation_ids ) && count( $variation_ids ) ) {
			foreach ( $variation_ids as $key => $value ) {
				$variation_ids[ $key ] = wc_sanitize_taxonomy_name( $value );
			}
			$return = $sku . '-' . implode( '-', $variation_ids );
		}

		return $return;
	}

	private static function get_product_description_from_url( $description_url ) {
		$request     = wp_remote_get(
			$description_url,
			array(
				'user-agent' => self::get_user_agent(),
				'timeout'    => 10,
			)
		);
		$description = '';
		if ( ! is_wp_error( $request ) ) {
			if ( isset( $request['body'] ) && $request['body'] ) {
				$body        = preg_replace( '/<script\>[\s\S]*?<\/script>/im', '', $request['body'] );
				$description = $body;
			}
		}

		return $description;
	}

	/**Download product description from url
	 *
	 * @param $product_id
	 * @param $description_url
	 * @param $description
	 * @param $product_description
	 */
	public static function download_description( $product_id, $description_url, $description, $product_description ) {
		if ( $description_url && $product_id ) {
			$request = wp_remote_get(
				$description_url,
				array(
					'user-agent' => self::get_user_agent(),
					'timeout'    => 10,
				)
			);
			if ( ! is_wp_error( $request ) && get_post_type( $product_id ) === 'vi_wad_draft_product' ) {
				if ( isset( $request['body'] ) && $request['body'] ) {
					$body = preg_replace( '/<script\>[\s\S]*?<\/script>/im', '', $request['body'] );
					preg_match_all( '/src="([\s\S]*?)"/im', $body, $matches );
					if ( isset( $matches[1] ) && is_array( $matches[1] ) && count( $matches[1] ) ) {
						update_post_meta( $product_id, '_vi_wad_description_images', array_values( array_unique( $matches[1] ) ) );
					}
					$instance    = self::get_instance();
					$str_replace = $instance->get_params( 'string_replace' );
					if ( isset( $str_replace['to_string'] ) && is_array( $str_replace['to_string'] ) && $str_replace_count = count( $str_replace['to_string'] ) ) {
						for ( $i = 0; $i < $str_replace_count; $i ++ ) {
							if ( $str_replace['sensitive'][ $i ] ) {
								$body = str_replace( $str_replace['from_string'][ $i ], $str_replace['to_string'][ $i ], $body );
							} else {
								$body = str_ireplace( $str_replace['from_string'][ $i ], $str_replace['to_string'][ $i ], $body );
							}
						}

					}
					if ( $product_description === 'item_specifics_and_description' || $product_description === 'description' ) {
						$description .= $body;
						wp_update_post( array( 'ID' => $product_id, 'post_content' => $description ) );
					}
				}
			}
		}
	}

	/**
	 * @return bool
	 */
	public static function get_disable_wp_cron() {
		return defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON === true;
	}

	/**Download image from url
	 *
	 * @param $image_id
	 * @param $url
	 * @param int $post_parent
	 * @param array $exclude
	 * @param string $post_title
	 * @param null $desc
	 *
	 * @return array|bool|int|object|string|WP_Error|null
	 */
	public static function download_image( &$image_id, $url, $post_parent = 0, $exclude = array(), $post_title = '', $desc = null ) {
		global $wpdb;
		$instance = self::get_instance();
		if ( $instance->get_params( 'use_external_image' ) && class_exists( 'EXMAGE_WP_IMAGE_LINKS' ) ) {
			$external_image = EXMAGE_WP_IMAGE_LINKS::add_image( $url, $image_id, $post_parent );
			$thumb_id       = $external_image['id'] ? $external_image['id'] : new WP_Error( 'exmage_image_error', $external_image['message'] );
		} else {
			$new_url   = $url;
			$parse_url = wp_parse_url( $new_url );
			$scheme    = empty( $parse_url['scheme'] ) ? 'http' : $parse_url['scheme'];
			$image_id  = "{$parse_url['host']}{$parse_url['path']}";
			$new_url   = "{$scheme}://{$image_id}";
			preg_match( '/[^\?]+\.(jpg|JPG|jpeg|JPEG|jpe|JPE|gif|GIF|png|PNG|webp|WEBP)/', $new_url, $matches );
			if ( ! is_array( $matches ) || ! count( $matches ) ) {
				preg_match( '/[^\?]+\.(jpg|JPG|jpeg|JPEG|jpe|JPE|gif|GIF|png|PNG|webp|WEBP)/', $url, $matches );
				if ( is_array( $matches ) && count( $matches ) ) {
					$new_url  .= "?{$matches[0]}";
					$image_id .= "?{$matches[0]}";
				}
			}

			$thumb_id = self::get_id_by_image_id( $image_id );
			if ( ! $thumb_id ) {
				$thumb_id = vi_wad_upload_image( $new_url, $post_parent, $exclude, $post_title, $desc );
				if ( ! is_wp_error( $thumb_id ) ) {
					update_post_meta( $thumb_id, '_vi_wad_image_id', $image_id );
				}
			} elseif ( $post_parent ) {
				$table_postmeta = "{$wpdb->prefix}posts";
				$wpdb->query( $wpdb->prepare( "UPDATE {$table_postmeta} set post_parent=%s WHERE ID=%s AND post_parent = 0 LIMIT 1", array(
					$post_parent,
					$thumb_id
				) ) );
			}
		}

		return $thumb_id;
	}

	/**
	 * @param $image_id
	 * @param bool $count
	 * @param bool $multiple
	 *
	 * @return array|bool|object|string|null
	 */
	public static function get_id_by_image_id( $image_id, $count = false, $multiple = false ) {
		global $wpdb;
		if ( $image_id ) {
			$table_posts    = "{$wpdb->prefix}posts";
			$table_postmeta = "{$wpdb->prefix}postmeta";
			$post_type      = 'attachment';
			$meta_key       = "_vi_wad_image_id";
			if ( $count ) {
				$query   = "SELECT count(*) from {$table_postmeta} join {$table_posts} on {$table_postmeta}.post_id={$table_posts}.ID where {$table_posts}.post_type = '{$post_type}' and {$table_posts}.post_status != 'trash' and {$table_postmeta}.meta_key = '{$meta_key}' and {$table_postmeta}.meta_value = %s";
				$results = $wpdb->get_var( $wpdb->prepare( $query, $image_id ) );
			} else {
				$query = "SELECT {$table_postmeta}.* from {$table_postmeta} join {$table_posts} on {$table_postmeta}.post_id={$table_posts}.ID where {$table_posts}.post_type = '{$post_type}' and {$table_posts}.post_status != 'trash' and {$table_postmeta}.meta_key = '{$meta_key}' and {$table_postmeta}.meta_value = %s";
				if ( $multiple ) {
					$results = $wpdb->get_results( $wpdb->prepare( $query, $image_id ), ARRAY_A );
				} else {
					$query   .= ' LIMIT 1';
					$results = $wpdb->get_var( $wpdb->prepare( $query, $image_id ), 1 );
				}
			}

			return $results;
		} else {
			return false;
		}
	}

	/**Get available shipping company
	 *
	 * @param string $slug
	 *
	 * @return array|mixed|string
	 */
	public static function get_shipping_companies( $slug = '' ) {
		$shipping_companies = apply_filters( 'vi_wad_aliexpress_shipping_companies', array(
			'AE_CAINIAO_STANDARD'      => "Cainiao Expedited Standard",
			'AE_CN_SUPER_ECONOMY_G'    => "Cainiao Super Economy Global",
			'ARAMEX'                   => "ARAMEX",
			'CAINIAO_CONSOLIDATION_SA' => "AliExpress Direct(SA)",
			'CAINIAO_CONSOLIDATION_AE' => "AliExpress Direct(AE)",
			'CAINIAO_ECONOMY'          => "AliExpress Saver Shipping",
			'CAINIAO_PREMIUM'          => "AliExpress Premium Shipping",
			'CAINIAO_STANDARD'         => "AliExpress Standard Shipping",
			'CHP'                      => "Swiss Post",
			'CPAM'                     => "China Post Registered Air Mail",
			'DHL'                      => "DHL",
			'DHLECOM'                  => "DHL e-commerce",
			'EMS'                      => "EMS",
			'EMS_ZX_ZX_US'             => "ePacket",
			'E_EMS'                    => "e-EMS",
			'FEDEX'                    => "Fedex IP",
			'FEDEX_IE'                 => "Fedex IE",
			'GATI'                     => "GATI",
			'POST_NL'                  => "PostNL",
			'PTT'                      => "Turkey Post",
			'SF'                       => "SF Express",
			'SF_EPARCEL'               => "SF eParcel",
			'SGP'                      => "Singapore Post",
			'SUNYOU_ECONOMY'           => "SunYou Economic Air Mail",
			'TNT'                      => "TNT",
			'TOLL'                     => "DPEX",
			'UBI'                      => "UBI",
			'UPS'                      => "UPS Express Saver",
			'UPSE'                     => "UPS Expedited",
			'USPS'                     => "USPS",
			'YANWEN_AM'                => "Yanwen Special Line-YW",
			'YANWEN_ECONOMY'           => "Yanwen Economic Air Mail",
			'YANWEN_JYT'               => "China Post Ordinary Small Packet Plus",
			'POLANDPOST_PL'            => "Poland Post",
			'ROYAL_MAIL'               => "Royal Mail",
			'Other'                    => "Seller's Shipping Method",
		) );
		if ( $slug ) {
			return isset( $shipping_companies[ $slug ] ) ? $shipping_companies[ $slug ] : '';
		} else {
			natcasesort( $shipping_companies );

			return $shipping_companies;
		}
	}

	public static function get_masked_shipping_companies() {
		$instance           = self::get_instance();
		$shipping_companies = $instance->get_params( 'ali_shipping_company_mask' );
		if ( $shipping_companies ) {
			$shipping_companies = vi_wad_json_decode( $shipping_companies );
			if ( ! is_array( $shipping_companies ) || ! count( $shipping_companies ) ) {
				$shipping_companies = self::get_default_masked_shipping_companies();
			} else {
				uasort( $shipping_companies, 'VI_WOOCOMMERCE_ALIDROPSHIP_DATA::sort_by_column_origin' );
			}
		} else {
			$shipping_companies = self::get_shipping_companies();
		}

		return $shipping_companies;
	}

	public static function get_default_masked_shipping_companies() {
		$company_mask           = array();
		$get_shipping_companies = self::get_shipping_companies();
		foreach ( $get_shipping_companies as $key => $value ) {
			$company_mask[ $key ] = array( 'origin' => $value, 'new' => '' );
		}

		return $company_mask;
	}

	public static function count_posts( $status ) {
		$args_publish = array(
			'post_type'      => 'vi_wad_draft_product',
			'post_status'    => $status,
			'order'          => 'DESC',
			'meta_key'       => '_vi_wad_woo_id',
			'orderby'        => 'meta_value_num',
			'fields'         => 'ids',
			'posts_per_page' => 1,
		);
		$the_query    = new WP_Query( $args_publish );
		$total        = isset( $the_query->found_posts ) ? $the_query->found_posts : 0;
		wp_reset_postdata();

		return $total;
	}

	public static function wp_remote_get( $url, $args = array() ) {
		$return  = array(
			'status' => 'error',
			'data'   => '',
			'code'   => '',
		);
		$args    = array_merge( array(
				'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36',
				'timeout'    => 3,
			)
			, $args );
		$request = wp_remote_get(
			$url, $args
		);
		if ( is_wp_error( $request ) ) {
			$return['data'] = $request->get_error_message();
			$return['code'] = $request->get_error_code();
		} else {
			$return['code'] = wp_remote_retrieve_response_code( $request );
			if ( $return['code'] === 200 ) {
				$return['status'] = 'success';
				$return['data']   = json_decode( $request['body'], true );
			}
		}

		return $return;
	}

	/**
	 * @param bool $count
	 * @param string $status
	 * @param int $limit
	 * @param int $offset
	 *
	 * @return array|string|null
	 */
	public static function get_ali_orders( $count = true, $status = 'to_order', $limit = 0, $offset = 0 ) {
		$instance = self::get_instance();
		global $wpdb;
		$woocommerce_order_items    = $wpdb->prefix . "woocommerce_order_items";
		$woocommerce_order_itemmeta = $wpdb->prefix . "woocommerce_order_itemmeta";
		$posts                      = $wpdb->prefix . "posts";
		$postmeta                   = $wpdb->prefix . "postmeta";
		$select                     = "DISTINCT {$posts}.ID";

		$query                    = "FROM {$posts} LEFT JOIN {$woocommerce_order_items} ON {$posts}.ID={$woocommerce_order_items}.order_id";
		$query                    .= " LEFT JOIN {$woocommerce_order_itemmeta} ON {$woocommerce_order_items}.order_item_id={$woocommerce_order_itemmeta}.order_item_id";
		$query                    .= " WHERE {$posts}.post_type='shop_order' AND {$woocommerce_order_itemmeta}.meta_key='_vi_wad_aliexpress_order_id'";
		$order_status_for_fulfill = $instance->get_params( 'order_status_for_fulfill' );
		if ( $order_status_for_fulfill ) {
			$query .= " AND {$posts}.post_status IN ( '" . implode( "','", $order_status_for_fulfill ) . "' )";
		}
		if ( $status === 'to_order' ) {
			$query .= " AND {$woocommerce_order_itemmeta}.meta_value=''";
		}
//		else {
//			$query = "FROM {$posts} LEFT JOIN {$woocommerce_order_items} ON {$posts}.ID={$woocommerce_order_items}.order_id LEFT JOIN {$woocommerce_order_itemmeta} ON {$woocommerce_order_items}.order_item_id={$woocommerce_order_itemmeta}.order_item_id left JOIN `{$postmeta}` on `{$woocommerce_order_itemmeta}`.`meta_value`=`{$postmeta}`.`post_id` WHERE `{$woocommerce_order_itemmeta}`.`meta_key`='_product_id' and `{$postmeta}`.`meta_key`='_vi_wad_aliexpress_product_id' ";
//		}
		if ( $count ) {
			$query = "SELECT COUNT({$select}) {$query}";

			return $wpdb->get_var( $query );
		} else {
			$query = "SELECT {$select} {$query}";
			if ( $limit ) {
				$query .= " LIMIT {$offset},{$limit}";
			}

			return $wpdb->get_col( $query, 0 );
		}
	}

	public static function get_aliexpress_product_url( $sku ) {
		return "https://www.aliexpress.com/item/{$sku}.html";
	}

	public static function get_aliexpress_order_detail_url( $aliexpress_order_id ) {
		return "https://trade.aliexpress.com/order_detail.htm?orderId={$aliexpress_order_id}";
	}

	public static function get_aliexpress_tracking_url( $aliexpress_order_id ) {
		return "http://track.aliexpress.com/logisticsdetail.htm?tradeId={$aliexpress_order_id}";
	}

	public static function get_to_order_aliexpress_url( $order_id, $ali_pid ) {
		return add_query_arg( array(
			'fromDomain'  => urlencode( site_url() ),
			'orderID'     => $order_id,
			'fromProduct' => $ali_pid
		), 'https://www.aliexpress.com' );
	}

	public static function get_get_tracking_url( $aliexpress_order_id = '' ) {
		return add_query_arg( array(
			'fromDomain'          => urlencode( site_url() ),
			'tradeId'             => $aliexpress_order_id,
			'getTracking'         => 'manual',
			'redirectOrderStatus' => 'all',
		), 'https://www.aliexpress.com/p/order/index.html' );
	}

	public static function get_update_product_url( $product_id, $update_all = true ) {
		$args = array(
			'fromDomain' => urlencode( site_url() ),
			'action'     => 'update_product',
		);
		if ( ! $update_all ) {
			$args['product_id'] = $product_id;
			$shipping_info      = get_post_meta( $product_id, '_vi_wad_shipping_info', true );
			$args['ali_id']     = get_post_meta( $product_id, '_vi_wad_sku', true );
			if ( $shipping_info && ! empty( $shipping_info['country'] ) ) {
				$args['from_country'] = VI_WOOCOMMERCE_ALIDROPSHIP_Admin_API::filter_country( $shipping_info['country'] );
			}
		}

		return add_query_arg( $args, self::get_aliexpress_product_url( get_post_meta( $product_id, '_vi_wad_sku', true ) ) );
	}

	public static function ali_ds_default_params() {
		return array(
			'format'      => 'json',
			'method'      => 'aliexpress.trade.buy.placeorder',
			'partner_id'  => 'apidoc',
			'sign_method' => 'md5',
			'v'           => '2.0',
		);
	}

	public static function ali_ds_get_url( $batch = false ) {
		if ( $batch ) {
			return is_ssl() ? 'https://eco.taobao.com/router/batch' : 'http://gw.api.taobao.com/router/batch';
		} else {
			return is_ssl() ? 'https://eco.taobao.com/router/rest' : 'http://gw.api.taobao.com/router/rest';
		}
	}

	public static function ali_ds_request( $body ) {
		$return  = array(
			'status' => 'error',
			'data'   => '',
			'code'   => '',
		);
		$default = self::ali_ds_default_params();
		$body    = array_merge( $default, $body );
		$args    = array(
			'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36',
			'timeout'    => 60,
			'body'       => $body,
		);
		$request = wp_remote_post(
			self::ali_ds_get_url(), $args
		);
		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			$data    = vi_wad_json_decode( $request['body'], true );
			$res_key = str_replace( '.', '_', $body['method'] ) . '_response';
			if ( isset( $data[ $res_key ] ) ) {
				$response = $data[ $res_key ];
				$result   = $response['result'];
				if ( isset( $result['error_message'] ) ) {
					$return['data'] = $result['error_message'];
					$return['code'] = $result['error_code'];
				} else {
					$return['status'] = 'success';
					$return['data']   = $result;
				}
			} elseif ( isset( $data['error_response'] ) ) {
				if ( isset( $data['error_response']['code'] ) ) {
					$return['code'] = $data['error_response']['code'];
				}
				if ( isset( $data['error_response']['msg'] ) ) {
					$return['data'] = $data['error_response']['msg'];
				}
			}
		} else {
			$return['data'] = $request->get_error_message();
		}

		return $return;
	}

	/**Get signature to use with AliExpress API
	 *
	 * @param $args
	 * @param string $type
	 *
	 * @return array
	 */
	public static function ali_ds_get_sign( $args, $type = 'place_order' ) {
		$return = array(
			'status' => 'error',
			'data'   => '',
			'code'   => '',
		);
		switch ( $type ) {
			case 'get_order':
				$url = VI_WOOCOMMERCE_ALIDROPSHIP_GET_SIGNATURE_GET_ORDER_URL;
				break;
			case 'get_product':
				$url = VI_WOOCOMMERCE_ALIDROPSHIP_GET_SIGNATURE_GET_PRODUCT_URL;
				break;
			case 'get_product_v2':
				$url = VI_WOOCOMMERCE_ALIDROPSHIP_GET_SIGNATURE_GET_PRODUCT_URL_V2;
				break;
			case 'place_order_batch':
				$url = VI_WOOCOMMERCE_ALIDROPSHIP_GET_SIGNATURE_PLACE_ORDER_BATCH_URL;
				break;
			case 'place_order':
			default:
				$url = VI_WOOCOMMERCE_ALIDROPSHIP_GET_SIGNATURE_PLACE_ORDER_URL;
		}

		$request = wp_remote_post( $url, array(
			'body'       => $args,
			'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36',
			'timeout'    => 30,
		) );
		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			$body           = vi_wad_json_decode( $request['body'] );
			$return['code'] = $body['code'];
			$return['data'] = $body['msg'];
			if ( $body['code'] == 200 ) {
				$return['status'] = 'success';
			}
		} else {
			$return['code'] = $request->get_error_code();
			$return['data'] = $request->get_error_message();
		}

		return $return;
	}

	public static function sanitize_taxonomy_name( $name ) {
		return urldecode( function_exists( 'mb_strtolower' ) ? mb_strtolower( urlencode( wc_sanitize_taxonomy_name( $name ) ) ) : strtolower( urlencode( wc_sanitize_taxonomy_name( $name ) ) ) );
	}

	public static function get_attributes_mapping_origin() {
		$instance                  = self::get_instance();
		$attributes_mapping_origin = $instance->get_params( 'attributes_mapping_origin' );
		if ( $attributes_mapping_origin ) {
			$attributes_mapping_origin = vi_wad_json_decode( stripslashes( $attributes_mapping_origin ) );
		}
		if ( ! is_array( $attributes_mapping_origin ) ) {
			$attributes_mapping_origin = array();
		}


		return $attributes_mapping_origin;
	}

	public static function get_attributes_mapping_replacement() {
		$instance                       = self::get_instance();
		$attributes_mapping_replacement = $instance->get_params( 'attributes_mapping_replacement' );
		if ( $attributes_mapping_replacement ) {
			$attributes_mapping_replacement = vi_wad_json_decode( $attributes_mapping_replacement );
		}
		if ( ! is_array( $attributes_mapping_replacement ) ) {
			$attributes_mapping_replacement = array();
		}

		return $attributes_mapping_replacement;
	}

	public static function strtolower( $string ) {
		return function_exists( 'mb_strtolower' ) ? mb_strtolower( $string ) : strtolower( $string );
	}

	public static function find_attribute_replacement( $origin, $replacement, $value, $attribute_slug ) {
		$value = self::strtolower( $value );
		if ( isset( $origin[ $attribute_slug ] ) ) {
			$search = array_search( $value, $origin[ $attribute_slug ] );
			if ( $search !== false ) {
				return $replacement[ $attribute_slug ][ $search ];
			}
		}

		return false;
	}

	/** Supported exchange API
	 * @return mixed
	 */
	public static function get_supported_exchange_api() {
		return apply_filters( 'vi_wad_get_supported_exchange_api',
			array(
				'google'       => esc_html__( 'Google finance', 'woocommerce-alidropship' ),
				'yahoo'        => esc_html__( 'Yahoo finance', 'woocommerce-alidropship' ),
				'cuex'         => esc_html__( 'Cuex', 'woocommerce-alidropship' ),
				'transferwise' => esc_html__( 'TransferWise', 'woocommerce-alidropship' ),
			)
		);
	}

	/**
	 * Get exchange rate based on selected API
	 *
	 * @param string $api
	 * @param string $target_currency
	 * @param bool $decimals
	 * @param string $source_currency
	 *
	 * @return bool|int|mixed|void
	 */
	public static function get_exchange_rate( $api = 'google', $target_currency = '', $decimals = false, $source_currency = 'USD' ) {
		if ( $decimals === false ) {
			$decimals = self::get_instance()->get_params( 'exchange_rate_decimals' );
		}
		$rate = false;
		if ( ! $target_currency ) {
			$target_currency = get_woocommerce_currency();
		}
		if ( self::strtolower( $target_currency ) === self::strtolower( $source_currency ) ) {
			$rate = 1;
		} else {
			switch ( $api ) {
				case 'yahoo':
					$get_rate = self::get_yahoo_exchange_rate( $target_currency, $source_currency );
					break;
				case 'cuex':
					$get_rate = self::get_cuex_exchange_rate( $target_currency, $source_currency );
					break;
				case 'transferwise':
					$get_rate = self::get_transferwise_exchange_rate( $target_currency, $source_currency );
					break;
				case 'google':
					$get_rate = self::get_google_exchange_rate( $target_currency, $source_currency );
					break;
				default:
					$get_rate = array(
						'status' => 'error',
						'data'   => false,
					);
			}
			if ( $get_rate['status'] === 'success' && $get_rate['data'] ) {
				$rate = $get_rate['data'];
			}
			$rate = apply_filters( 'vi_wad_get_exchange_rate', round( $rate, $decimals ), $api );
		}

		return $rate;
	}

	/**
	 * @param $target_currency
	 * @param string $source_currency
	 *
	 * @return array
	 */
	private static function get_google_exchange_rate( $target_currency, $source_currency = 'USD' ) {
		$response = array(
			'status' => 'error',
			'data'   => false,
		);
		$url      = 'https://www.google.com/async/currency_v2_update?vet=12ahUKEwjfsduxqYXfAhWYOnAKHdr6BnIQ_sIDMAB6BAgFEAE..i&ei=kgAGXN-gDJj1wAPa9ZuQBw&yv=3&async=source_amount:1,source_currency:' . self::get_country_freebase( $source_currency ) . ',target_currency:' . self::get_country_freebase( $target_currency ) . ',lang:en,country:us,disclaimer_url:https%3A%2F%2Fwww.google.com%2Fintl%2Fen%2Fgooglefinance%2Fdisclaimer%2F,period:5d,interval:1800,_id:knowledge-currency__currency-v2-updatable,_pms:s,_fmt:pc';
		$request  = wp_remote_get(
			$url, array(
				'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36',
				'timeout'    => 10
			)
		);
		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			preg_match( '/data-exchange-rate=\"(.+?)\"/', $request['body'], $match );
			if ( is_array( $match ) && count( $match ) > 1 ) {
				$response['status'] = 'success';
				$response['data']   = $match[1];
			} else {
				$response['data'] = esc_html__( 'Preg_match fails', 'woocommerce-alidropship' );
			}
		} else {
			$response['data'] = $request->get_error_message();
		}

		return $response;
	}

	/**
	 * @param $target_currency
	 * @param string $source_currency
	 *
	 * @return array
	 */
	private static function get_yahoo_exchange_rate( $target_currency, $source_currency = 'USD' ) {
		$response = array(
			'status' => 'error',
			'data'   => false,
		);
		$now      = current_time( 'timestamp', true );
		$url      = 'https://query1.finance.yahoo.com/v8/finance/chart/' . $source_currency . $target_currency . '=X?symbol=' . $source_currency . $target_currency . '%3DX&period1=' . ( $now - 60 * 86400 ) . '&period2=' . $now . '&interval=1d&includePrePost=false&events=div%7Csplit%7Cearn&lang=en-US&region=US&corsDomain=finance.yahoo.com';

		$request = wp_remote_get(
			$url, array(
				'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36',
				'timeout'    => 10
			)
		);

		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			$body   = vi_wad_json_decode( $request['body'] );
			$result = isset( $body['chart']['result'][0]['indicators']['quote'][0]['open'] ) ? array_filter( $body['chart']['result'][0]['indicators']['quote'][0]['open'] ) : ( isset( $body['chart']['result'][0]['meta']['previousClose'] ) ? array( $body['chart']['result'][0]['meta']['previousClose'] ) : array() );
			if ( count( $result ) && is_array( $result ) ) {
				$response['status'] = 'success';
				$response['data']   = end( $result );
			}
		} else {
			$response['data'] = $request->get_error_message();
		}

		return $response;
	}

	/**
	 * @param $target_currency
	 * @param string $source_currency
	 *
	 * @return array
	 */
	private static function get_transferwise_exchange_rate( $target_currency, $source_currency = 'USD' ) {
		$response = array(
			'status' => 'error',
			'data'   => false,
		);
		$url      = "https://transferwise.com/api/v1/payment/calculate?amount=1&sourceCurrency={$source_currency}&targetCurrency={$target_currency}";

		$request = wp_remote_get(
			$url, array(
				'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36',
				'timeout'    => 10,
				'headers'    => array(
					'x-authorization-key' => 'dad99d7d8e52c2c8aaf9fda788d8acdc'
				)
			)
		);

		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			$body = vi_wad_json_decode( wp_remote_retrieve_body( $request ) );
			if ( isset( $body['transferwiseRate'] ) ) {
				$response['status'] = 'success';
				$response['data']   = $body['transferwiseRate'];
			}
		} else {
			$response['data'] = $request->get_error_message();
		}

		return $response;
	}

	/**
	 * @param $target_currency
	 * @param string $source_currency
	 *
	 * @return array
	 */
	private static function get_cuex_exchange_rate( $target_currency, $source_currency = 'USD' ) {
		$response        = array(
			'status' => 'error',
			'data'   => false,
		);
		$target_currency = self::strtolower( $target_currency );
		$source_currency = self::strtolower( $source_currency );
		$date            = date( 'Y-m-d', current_time( 'timestamp' ) );
		$url             = "https://api.cuex.com/v1/exchanges/{$source_currency}?to_currency={$target_currency}&from_date={$date}&l=en";

		$request = wp_remote_get(
			$url, array(
				'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36',
				'timeout'    => 10,
			)
		);

		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			$body = vi_wad_json_decode( wp_remote_retrieve_body( $request ) );
			if ( isset( $body['data'][0]['rate'] ) ) {
				$response['status'] = 'success';
				$response['data']   = $body['data'][0]['rate'];
			}
		} else {
			$response['data'] = $request->get_error_message();
		}

		return $response;
	}

	/**
	 * @param string $country_code
	 *
	 * @return array|bool|string
	 */
	private static function get_country_freebase( $country_code = '' ) {
		$countries = array(
			"AED" => "/m/02zl8q",
			"AFN" => "/m/019vxc",
			"ALL" => "/m/01n64b",
			"AMD" => "/m/033xr3",
			"ANG" => "/m/08njbf",
			"AOA" => "/m/03c7mb",
			"ARS" => "/m/024nzm",
			"AUD" => "/m/0kz1h",
			"AWG" => "/m/08s1k3",
			"AZN" => "/m/04bq4y",
			"BAM" => "/m/02lnq3",
			"BBD" => "/m/05hy7p",
			"BDT" => "/m/02gsv3",
			"BGN" => "/m/01nmfw",
			"BHD" => "/m/04wd20",
			"BIF" => "/m/05jc3y",
			"BMD" => "/m/04xb8t",
			"BND" => "/m/021x2r",
			"BOB" => "/m/04tkg7",
			"BRL" => "/m/03385m",
			"BSD" => "/m/01l6dm",
			"BTC" => "/m/05p0rrx",
			"BWP" => "/m/02nksv",
			"BYN" => "/m/05c9_x",
			"BZD" => "/m/02bwg4",
			"CAD" => "/m/0ptk_",
			"CDF" => "/m/04h1d6",
			"CHF" => "/m/01_h4b",
			"CLP" => "/m/0172zs",
			"CNY" => "/m/0hn4_",
			"COP" => "/m/034sw6",
			"CRC" => "/m/04wccn",
			"CUC" => "/m/049p2z",
			"CUP" => "/m/049p2z",
			"CVE" => "/m/06plyy",
			"CZK" => "/m/04rpc3",
			"DJF" => "/m/05yxn7",
			"DKK" => "/m/01j9nc",
			"DOP" => "/m/04lt7_",
			"DZD" => "/m/04wcz0",
			"EGP" => "/m/04phzg",
			"ETB" => "/m/02_mbk",
			"EUR" => "/m/02l6h",
			"FJD" => "/m/04xbp1",
			"GBP" => "/m/01nv4h",
			"GEL" => "/m/03nh77",
			"GHS" => "/m/01s733",
			"GMD" => "/m/04wctd",
			"GNF" => "/m/05yxld",
			"GTQ" => "/m/01crby",
			"GYD" => "/m/059mfk",
			"HKD" => "/m/02nb4kq",
			"HNL" => "/m/04krzv",
			"HRK" => "/m/02z8jt",
			"HTG" => "/m/04xrp0",
			"HUF" => "/m/01hfll",
			"IDR" => "/m/0203sy",
			"ILS" => "/m/01jcw8",
			"INR" => "/m/02gsvk",
			"IQD" => "/m/01kpb3",
			"IRR" => "/m/034n11",
			"ISK" => "/m/012nk9",
			"JMD" => "/m/04xc2m",
			"JOD" => "/m/028qvh",
			"JPY" => "/m/088n7",
			"KES" => "/m/05yxpb",
			"KGS" => "/m/04k5c6",
			"KHR" => "/m/03_m0v",
			"KMF" => "/m/05yxq3",
			"KRW" => "/m/01rn1k",
			"KWD" => "/m/01j2v3",
			"KYD" => "/m/04xbgl",
			"KZT" => "/m/01km4c",
			"LAK" => "/m/04k4j1",
			"LBP" => "/m/025tsrc",
			"LKR" => "/m/02gsxw",
			"LRD" => "/m/05g359",
			"LSL" => "/m/04xm1m",
			"LYD" => "/m/024xpm",
			"MAD" => "/m/06qsj1",
			"MDL" => "/m/02z6sq",
			"MGA" => "/m/04hx_7",
			"MKD" => "/m/022dkb",
			"MMK" => "/m/04r7gc",
			"MOP" => "/m/02fbly",
			"MRO" => "/m/023c2n",
			"MUR" => "/m/02scxb",
			"MVR" => "/m/02gsxf",
			"MWK" => "/m/0fr4w",
			"MXN" => "/m/012ts8",
			"MYR" => "/m/01_c9q",
			"MZN" => "/m/05yxqw",
			"NAD" => "/m/01y8jz",
			"NGN" => "/m/018cg3",
			"NIO" => "/m/02fvtk",
			"NOK" => "/m/0h5dw",
			"NPR" => "/m/02f4f4",
			"NZD" => "/m/015f1d",
			"OMR" => "/m/04_66x",
			"PAB" => "/m/0200cp",
			"PEN" => "/m/0b423v",
			"PGK" => "/m/04xblj",
			"PHP" => "/m/01h5bw",
			"PKR" => "/m/02svsf",
			"PLN" => "/m/0glfp",
			"PYG" => "/m/04w7dd",
			"QAR" => "/m/05lf7w",
			"RON" => "/m/02zsyq",
			"RSD" => "/m/02kz6b",
			"RUB" => "/m/01hy_q",
			"RWF" => "/m/05yxkm",
			"SAR" => "/m/02d1cm",
			"SBD" => "/m/05jpx1",
			"SCR" => "/m/01lvjz",
			"SDG" => "/m/08d4zw",
			"SEK" => "/m/0485n",
			"SGD" => "/m/02f32g",
			"SLL" => "/m/02vqvn",
			"SOS" => "/m/05yxgz",
			"SRD" => "/m/02dl9v",
			"SSP" => "/m/08d4zw",
			"STD" => "/m/06xywz",
			"SZL" => "/m/02pmxj",
			"THB" => "/m/0mcb5",
			"TJS" => "/m/0370bp",
			"TMT" => "/m/0425kx",
			"TND" => "/m/04z4ml",
			"TOP" => "/m/040qbv",
			"TRY" => "/m/04dq0w",
			"TTD" => "/m/04xcgz",
			"TWD" => "/m/01t0lt",
			"TZS" => "/m/04s1qh",
			"UAH" => "/m/035qkb",
			"UGX" => "/m/04b6vh",
			"USD" => "/m/09nqf",
			"UYU" => "/m/04wblx",
			"UZS" => "/m/04l7bl",
			"VEF" => "/m/021y_m",
			"VND" => "/m/03ksl6",
			"XAF" => "/m/025sw2b",
			"XCD" => "/m/02r4k",
			"XOF" => "/m/025sw2q",
			"XPF" => "/m/01qyjx",
			"YER" => "/m/05yxwz",
			"ZAR" => "/m/01rmbs",
			"ZMW" => "/m/0fr4f"
		);
		if ( $country_code ) {
			return isset( $countries[ $country_code ] ) ? $countries[ $country_code ] : '';
		} else {
			return $countries;
		}
	}

	public static function get_domain_name() {
		if ( ! empty( $_SERVER['HTTP_HOST'] ) ) {
			$name = $_SERVER['HTTP_HOST'];
		} elseif ( ! empty( $_SERVER['SERVER_NAME'] ) ) {
			$name = $_SERVER['SERVER_NAME'];
		} else {
			$name = self::get_domain_from_url( get_bloginfo( 'url' ) );
		}

		return $name;
	}

	public static function filter_allowed_html( $tags ) {
		$tags = array_merge_recursive( $tags, array(
				'input'  => array(
					'type'         => 1,
					'id'           => 1,
					'name'         => 1,
					'class'        => 1,
					'placeholder'  => 1,
					'autocomplete' => 1,
					'style'        => 1,
					'value'        => 1,
					'size'         => 1,
					'checked'      => 1,
					'disabled'     => 1,
					'readonly'     => 1,
					'data-*'       => 1,
				),
				'form'   => array(
					'method' => 1,
					'id'     => 1,
					'class'  => 1,
					'action' => 1,
					'data-*' => 1,
				),
				'select' => array(
					'id'       => 1,
					'name'     => 1,
					'class'    => 1,
					'multiple' => 1,
					'data-*'   => 1,
				),
				'option' => array(
					'value'    => 1,
					'selected' => 1,
					'data-*'   => 1,
				),
			)
		);
		foreach ( $tags as $key => $value ) {
			if ( $key === 'input' ) {
				$tags[ $key ]['data-*']   = 1;
				$tags[ $key ]['checked']  = 1;
				$tags[ $key ]['disabled'] = 1;
				$tags[ $key ]['readonly'] = 1;
			} elseif ( in_array( $key, array( 'div', 'span', 'a', 'form', 'select', 'option', 'tr', 'td' ) ) ) {
				$tags[ $key ]['data-*'] = 1;
			}
		}

		return $tags;
	}

	public static function wp_kses_post( $content ) {
		if ( self::$allow_html === null ) {
			self::$allow_html = wp_kses_allowed_html( 'post' );
			self::$allow_html = self::filter_allowed_html( self::$allow_html );
		}

		return wp_kses( $content, self::$allow_html );
	}

	/**Get WooCommerce countries in English
	 * @return mixed
	 */
	public static function get_countries() {
		if ( self::$countries === null ) {
			unload_textdomain( 'woocommerce' );
			self::$countries = apply_filters( 'woocommerce_countries', include WC()->plugin_path() . '/i18n/countries.php' );
			if ( apply_filters( 'woocommerce_sort_countries', true ) ) {
				wc_asort_by_locale( self::$countries );
			}
			$locale = determine_locale();
			$locale = apply_filters( 'plugin_locale', $locale, 'woocommerce' );
			load_textdomain( 'woocommerce', WP_LANG_DIR . '/woocommerce/woocommerce-' . $locale . '.mo' );
			load_plugin_textdomain( 'woocommerce', false, plugin_basename( dirname( WC_PLUGIN_FILE ) ) . '/i18n/languages' );
		}

		return self::$countries;
	}

	/**Get WooCommerce states in English
	 *
	 * @param $cc
	 *
	 * @return bool|mixed
	 */
	public static function get_states( $cc ) {
		if ( self::$states === null ) {
			unload_textdomain( 'woocommerce' );
			self::$states = apply_filters( 'woocommerce_states', include WC()->plugin_path() . '/i18n/states.php' );
			$locale       = determine_locale();
			$locale       = apply_filters( 'plugin_locale', $locale, 'woocommerce' );
			load_textdomain( 'woocommerce', WP_LANG_DIR . '/woocommerce/woocommerce-' . $locale . '.mo' );
			load_plugin_textdomain( 'woocommerce', false, plugin_basename( dirname( WC_PLUGIN_FILE ) ) . '/i18n/languages' );
		}

		if ( ! is_null( $cc ) ) {
			return isset( self::$states[ $cc ] ) ? self::$states[ $cc ] : false;
		} else {
			return self::$states;
		}
	}

	/**Allows only numbers
	 *
	 * @param $phone
	 *
	 * @return string
	 */
	public static function sanitize_phone_number( $phone ) {
		return preg_replace( '/[^\d]/', '', $phone );
	}

	/**
	 * @param $woo_id
	 * @param $ship_to
	 * @param string $ship_from
	 * @param int $quantity
	 * @param string $province
	 * @param string $city
	 *
	 * @return array|mixed
	 */
	public static function get_ali_shipping_by_woo_id( $woo_id, $ship_to, $ship_from = '', $quantity = 1, $province = '', $city = '' ) {
		$ali_id  = get_post_meta( $woo_id, '_vi_wad_aliexpress_product_id', true );
		$freight = array();
		if ( $ali_id ) {
			$freight_ext = get_post_meta( $woo_id, '_vi_wad_freight_ext', true );
//			if ( ! $freight_ext ) {
//				$ald_id      = self::product_get_id_by_woo_id( $woo_id );
//				$freight_ext = self::get_freight_ext( $ald_id );
//				if ( $freight_ext ) {
//					update_post_meta( $woo_id, '_vi_wad_freight_ext', $freight_ext );
//				}
//			}
			$freight = self::get_ali_shipping( $ali_id, $ship_to, $ship_from, $quantity, $freight_ext, $province, $city );
		}

		return $freight;
	}

	/**
	 * @param $ali_id
	 * @param $ship_to
	 * @param string $ship_from
	 * @param int $quantity
	 * @param string $freight_ext
	 * @param string $province
	 * @param string $city
	 *
	 * @return array|mixed
	 */
	public static function get_ali_shipping( $ali_id, $ship_to, $ship_from = '', $quantity = 1, $freight_ext = '', $province = '', $city = '' ) {
		$now         = time();
		$shipping_id = "{$ali_id}_{$ship_to}_{$quantity}";
		if ( $province ) {
			$shipping_id .= "{_$province}";
		}
		if ( $city ) {
			$shipping_id .= "{_$city}";
		}
		$shipping_info = VI_WOOCOMMERCE_ALIDROPSHIP_Ali_Shipping_Info_Table::get_row_by_shipping_id( $shipping_id );
		$need_update   = true;
		if ( $shipping_info ) {
			if ( $now - $shipping_info['time'] < 600 ) {
				$need_update = false;
			} else {
				$shipping_info['time'] = $now;
			}
		} else {
			$shipping_info = array(
				'time'    => $now,
				'freight' => array(),
			);
		}

		if ( $need_update ) {
			$get_freight = self::get_freight( $ali_id, $ship_to, '', $quantity, 'USD', $freight_ext, $province, $city );
			if ( $get_freight['status'] === 'success' ) {
				$shipping_info['freight'] = self::adjust_ali_freight( $get_freight['freight'] );
				VI_WOOCOMMERCE_ALIDROPSHIP_Ali_Shipping_Info_Table::insert( $shipping_id, $shipping_info, $ali_id );
			}
		}
		if ( count( $shipping_info['freight'] ) && $ship_from ) {
			foreach ( $shipping_info['freight'] as $key => $value ) {
				if ( $ship_from === 'CN' ) {
					if ( $value['ship_from'] && $value['ship_from'] !== 'CN' ) {
						unset( $shipping_info['freight'][ $key ] );
					}
				} elseif ( in_array( $ship_from, array( 'GB', 'UK' ) ) ) {
					if ( ! in_array( $value['ship_from'], array( 'GB', 'UK' ) ) ) {
						unset( $shipping_info['freight'][ $key ] );
					}
				} elseif ( $value['ship_from'] !== $ship_from ) {
					unset( $shipping_info['freight'][ $key ] );
				}
			}
			$shipping_info['freight'] = array_values( $shipping_info['freight'] );
		}

		return $shipping_info['freight'];
	}

	private static function adjust_ali_freight( $freight ) {
		$saved_freight = array();
		foreach ( $freight as $freight_k => $freight_v ) {
			$saved_freight[] = array(
				'company'       => $freight_v['serviceName'],
				'company_name'  => $freight_v['company'],
				'shipping_cost' => self::get_freight_amount( $freight_v ),
				'delivery_time' => $freight_v['time'],
				'display_type'  => $freight_v['displayType'],
				'tracking'      => $freight_v['tracking'],
				'ship_from'     => isset( $freight_v['sendGoodsCountry'] ) ? $freight_v['sendGoodsCountry'] : '',
			);
		}

		return $saved_freight;
	}

	/**
	 * Check if shipping cost is available in USD
	 * If not, convert it from available currency
	 * Exchange rate here is automatically fetched from available APIs, expires in 24 hours and not shown to users
	 *
	 * @param $freight_v
	 *
	 * @return mixed|string
	 */
	public static function get_freight_amount( $freight_v ) {
		global $wooaliexpressdropship_settings;
		$freight_amount = '';
		if ( isset( $freight_v['standardFreightAmount']['value'], $freight_v['standardFreightAmount']['currency'] ) && $freight_v['standardFreightAmount']['currency'] === 'USD' ) {
			$freight_amount = $freight_v['standardFreightAmount']['value'];
		} elseif ( isset( $freight_v['freightAmount']['value'], $freight_v['freightAmount']['currency'] ) && $freight_v['freightAmount']['currency'] === 'USD' ) {
			$freight_amount = $freight_v['freightAmount']['value'];
		} elseif ( isset( $freight_v['previewFreightAmount']['value'], $freight_v['previewFreightAmount']['currency'] ) && $freight_v['previewFreightAmount']['currency'] === 'USD' ) {
			$freight_amount = $freight_v['previewFreightAmount']['value'];
		}
		if ( $freight_amount === '' ) {
			$currency = '';
			if ( isset( $freight_v['standardFreightAmount']['value'], $freight_v['standardFreightAmount']['currency'] ) ) {
				$freight_amount = $freight_v['standardFreightAmount']['value'];
				$currency       = $freight_v['standardFreightAmount']['currency'];
			} elseif ( isset( $freight_v['freightAmount']['value'], $freight_v['freightAmount']['currency'] ) ) {
				$freight_amount = $freight_v['freightAmount']['value'];
				$currency       = $freight_v['freightAmount']['currency'];
			} elseif ( isset( $freight_v['previewFreightAmount']['value'], $freight_v['previewFreightAmount']['currency'] ) ) {
				$freight_amount = $freight_v['previewFreightAmount']['value'];
				$currency       = $freight_v['previewFreightAmount']['currency'];
			}
			if ( $currency && $freight_amount ) {
				$instance               = self::get_instance();
				$exchange_rate_shipping = $instance->get_params( 'exchange_rate_shipping' );
				$now                    = time();
				$rate                   = $old_rate = '';
				if ( $currency === 'CNY' ) {
					/*This is CNY/USD rate while we need USD/CNY rate*/
					$import_currency_rate_CNY = $instance->get_params( 'import_currency_rate_CNY' );
					if ( $import_currency_rate_CNY ) {
						$rate = 1 / $import_currency_rate_CNY;
					}
				}
				if ( ! $rate ) {
					if ( isset( $exchange_rate_shipping[ $currency ] ) ) {
						$old_rate = $exchange_rate_shipping[ $currency ]['value'];
						if ( $exchange_rate_shipping[ $currency ]['time'] > $now ) {
							$rate = $exchange_rate_shipping[ $currency ]['value'];
						}
					}
				}
				if ( ! $rate ) {
					/*This is USD/{$currency} rate*/
					foreach ( array( 'yahoo', 'google', 'cuex', 'transferwise' ) as $api ) {
						$rate = self::get_exchange_rate( $api, $currency, 2 );
						if ( $rate ) {
							$params                                        = $instance->get_params();
							$params['exchange_rate_shipping'][ $currency ] = array(
								'time'  => $now + DAY_IN_SECONDS,
								'value' => $rate,
							);
							$wooaliexpressdropship_settings                = $params;
							update_option( 'wooaliexpressdropship_params', $params );
							self::get_instance( true );
							break;
						}
					}
				}
				if ( ! $rate ) {
					$rate = $old_rate;
				}
				if ( $rate ) {
					$freight_amount = $freight_amount / $rate;
					$freight_amount = round( $freight_amount, 2 );
				}
			}
		}

		return $freight_amount;
	}

	/**
	 * @param $ali_product_id
	 * @param $country
	 * @param string $from_country two-letters country code: CN, US, ...
	 * @param int $quantity
	 * @param string $currency
	 * @param string $freight_ext
	 * @param string $province
	 * @param string $city
	 *
	 * @return array
	 */
	public static function get_freight( $ali_product_id, $country, $from_country = '', $quantity = 1, $currency = 'USD', $freight_ext = '', $province = '', $city = '' ) {
		$response = array(
			'status'  => 'error',
			'freight' => array(),
			'code'    => '',
		);
		$args     = array(
			'productId'     => $ali_product_id,
			'country'       => VI_WOOCOMMERCE_ALIDROPSHIP_Admin_API::filter_country( $country ),
			'tradeCurrency' => $currency,
			'count'         => $quantity,
			'provinceCode'  => '',
			'cityCode'      => '',
//			'minPrice'      => '1',
//			'maxPrice'      => '1',
		);
		if ( in_array( $country, apply_filters( 'vi_wad_aliexpress_supported_shipping_by_province_city', array( 'BR' ) ), true ) ) {
			if ( $province ) {
				$provinceCode = self::get_aliexpress_province_code( $country, $province );
				if ( $provinceCode ) {
					$cityCode = self::get_aliexpress_city_code( $country, $provinceCode, $city );
					if ( $cityCode ) {
						$args['provinceCode'] = $provinceCode;
						$args['cityCode']     = $cityCode;
					}
				}
			}
		}
		if ( $freight_ext ) {
			$args['ext'] = $freight_ext;
		} else {
			$ald_id = self::product_get_id_by_aliexpress_id( $ali_product_id );
			if ( $ald_id ) {
				$freight_ext = self::get_freight_ext( $ald_id, $currency );
				if ( $freight_ext ) {
					$args['ext'] = $freight_ext;
				}
			}
		}

		if ( $from_country ) {
			$args['sendGoodsCountry'] = $from_country;
		}
//		$request          = self::wp_remote_get( add_query_arg( $args, 'https://www.aliexpress.com/aeglodetailweb/api/logistics/freight?provinceCode=&cityCode=&sellerAdminSeq=239419167&userScene=PC_DETAIL_SHIPPING_PANEL&displayMultipleFreight=false&ext={"disCurrency":"USD","p3":"USD","p6":"' . self::get_ali_tax( $country ) . '"}' ) );
//		$request          = self::wp_remote_get( add_query_arg( $args, 'https://www.aliexpress.com/aeglodetailweb/api/logistics/freight?count=1&provinceCode=&cityCode=&sellerAdminSeq=239419167&userScene=PC_DETAIL_SHIPPING_PANEL&displayMultipleFreight=false' ) );
		$request          = self::wp_remote_get( add_query_arg( $args, 'https://www.aliexpress.com/aeglodetailweb/api/logistics/freight' ) );
		$response['code'] = $request['code'];
		if ( $request['status'] === 'success' ) {
			$data = $request['data'];
			if ( isset( $data['body'] ) && isset( $data['body']['freightResult'] ) && is_array( $data['body']['freightResult'] ) ) {
				$response['status']  = 'success';
				$response['freight'] = $data['body']['freightResult'];
			} else {
				$response['code'] = 404;
			}
		}

		return $response;
	}

	public static function get_aliexpress_city_code( $country, $state_code, $city ) {
		$ali_states = self::get_state( $country );
		$city_code  = '';
		if ( $country && $state_code && $city ) {
			$found_state = false;
			foreach ( $ali_states['addressList'] as $key => $value ) {
				if ( $state_code === $value['c'] ) {
					$found_state = $key;
					break;
				}
			}
			if ( $found_state !== false ) {
				if ( isset( $ali_states['addressList'][ $found_state ]['children'] ) && is_array( $ali_states['addressList'][ $found_state ]['children'] ) && count( $ali_states['addressList'][ $found_state ]['children'] ) ) {
					$search   = mb_strtolower( $city );
					$search_1 = array( $search, remove_accents( $search ) );
					foreach ( $ali_states['addressList'][ $found_state ]['children'] as $key => $value ) {
						if ( in_array( mb_strtolower( $value['n'] ), $search_1, true ) ) {
							$city_code = $value['c'];
							break;
						}
					}
				}
			}
		}

		return $city_code;
	}

	public static function get_aliexpress_province_code( $country, $state ) {
		$province_code = '';
		if ( $country && $state ) {
			$ali_states = self::get_state( $country );
			if ( count( $ali_states ) ) {
				if ( function_exists( 'mb_strtolower' ) ) {
					$search   = mb_strtolower( $state );
					$search_1 = array( $search, remove_accents( $search ) );
					foreach ( $ali_states['addressList'] as $key => $value ) {
						if ( in_array( mb_strtolower( $value['n'] ), $search_1, true ) ) {
							$province_code = $value['c'];
							break;
						}
					}
				} else {
					$search   = strtolower( $state );
					$search_1 = array( $search, remove_accents( $search ) );
					foreach ( $ali_states['addressList'] as $key => $value ) {
						if ( in_array( strtolower( $value['n'] ), $search_1, true ) ) {
							$province_code = $value['c'];
							break;
						}
					}
				}
			}
		}

		return $province_code;
	}

	private static function get_freight_ext( $ald_id, $currency = 'USD' ) {
		$variations  = get_post_meta( $ald_id, '_vi_wad_variations', true );
		$freight_ext = '';
		if ( $variations ) {
			$price_array = array_filter( array_merge( array_column( $variations, 'sale_price' ), array_column( $variations, 'regular_price' ) ) );
			if ( count( $price_array ) ) {
				$min_price = min( $price_array );
				if ( $min_price ) {
					$min_price   = self::string_to_float( $min_price );
					$freight_ext = '{"p1":"' . number_format( $min_price, 2 ) . '","p3":"' . $currency . '","disCurrency":"' . $currency . '","p6":""}';
				}
			}
		}

		return $freight_ext;
	}

	/**
	 * @param $time
	 *
	 * @return int
	 */
	public static function get_shipping_cache_time( $time ) {
		return $time + rand( 0, 600 );
	}

	public static function get_state( $cc ) {
		if ( self::$ali_states === null ) {
			ini_set( 'memory_limit', - 1 );
			self::$ali_states = file_get_contents( VI_WOOCOMMERCE_ALIDROPSHIP_ASSETS_DIR . 'ali-states.json' );
			self::$ali_states = vi_wad_json_decode( self::$ali_states );
		}

		return isset( self::$ali_states[ $cc ] ) ? self::$ali_states[ $cc ] : array();
	}

	/**
	 * Create ALD products(added to import list): Import via chrome extension, reimport, override
	 *
	 * @param $data
	 * @param $shipping_info
	 * @param array $post_data
	 *
	 * @return int|WP_Error
	 */
	public function create_product( $data, $shipping_info, $post_data = array() ) {
		$sku                 = isset( $data['sku'] ) ? sanitize_text_field( $data['sku'] ) : '';
		$title               = isset( $data['name'] ) ? sanitize_text_field( $data['name'] ) : '';
		$description_url     = isset( $data['description_url'] ) ? stripslashes( $data['description_url'] ) : '';
		$short_description   = isset( $data['short_description'] ) ? wp_kses_post( stripslashes( $data['short_description'] ) ) : '';
		$description         = isset( $data['description'] ) ? wp_kses_post( stripslashes( $data['description'] ) ) : '';
		$specsModule         = isset( $data['specsModule'] ) ? stripslashes_deep( $data['specsModule'] ) : array();
		$gallery             = isset( $data['gallery'] ) ? stripslashes_deep( $data['gallery'] ) : array();
		$variation_images    = isset( $data['variation_images'] ) ? stripslashes_deep( $data['variation_images'] ) : array();
		$variations          = isset( $data['variations'] ) ? stripslashes_deep( $data['variations'] ) : array();
		$attributes          = isset( $data['attributes'] ) ? stripslashes_deep( $data['attributes'] ) : array();
		$list_attributes     = isset( $data['list_attributes'] ) ? stripslashes_deep( $data['list_attributes'] ) : array();
		$store_info          = isset( $data['store_info'] ) ? stripslashes_deep( $data['store_info'] ) : array();
		$currency_code       = isset( $data['currency_code'] ) ? strtoupper( stripslashes_deep( $data['currency_code'] ) ) : '';
		$video               = isset( $data['video'] ) ? $data['video'] : array();
		$str_replace         = $this->get_params( 'string_replace' );
		$description_setting = $this->get_params( 'product_description' );
		if ( count( $specsModule ) ) {
			ob_start();
			?>
            <div class="product-specs-list-container">
                <ul class="product-specs-list util-clearfix">
					<?php
					foreach ( $specsModule as $specs ) {
						?>
                        <li class="product-prop line-limit-length"><span
                                    class="property-title"><?php echo esc_html( isset( $specs['attrName'] ) ? $specs['attrName'] : $specs['title'] ) ?>:&nbsp;</span><span
                                    class="property-desc line-limit-length"><?php echo esc_html( isset( $specs['attrValue'] ) ? $specs['attrValue'] : $specs['value'] ) ?></span>
                        </li>
						<?php
					}
					?>
                </ul>
            </div>
			<?php
			$short_description .= ob_get_clean();
			$short_description = apply_filters( 'vi_wad_import_product_short_description', $short_description, $data );
		}
		$desc_images = array();
		switch ( $description_setting ) {
			case 'none':
				$description = '';
				break;
			case 'item_specifics':
				$description = $short_description;
				break;
			case 'description':
				if ( $description_url ) {
					$description .= self::get_product_description_from_url( $description_url );
				}
				break;
			case 'item_specifics_and_description':
			default:
				if ( $description_url ) {
					$description .= self::get_product_description_from_url( $description_url );
				}
				$description = $short_description . $description;
		}
		$description = apply_filters( 'vi_wad_import_product_description', $description, $data );
		if ( $description ) {
			preg_match_all( '/src="([\s\S]*?)"/im', $description, $matches );
			if ( isset( $matches[1] ) && is_array( $matches[1] ) && count( $matches[1] ) ) {
				$desc_images = array_values( array_unique( $matches[1] ) );
			}
		}
		if ( isset( $str_replace['to_string'] ) && is_array( $str_replace['to_string'] ) && $str_replace_count = count( $str_replace['to_string'] ) ) {
			for ( $i = 0; $i < $str_replace_count; $i ++ ) {
				if ( $str_replace['sensitive'][ $i ] ) {
					$description = str_replace( $str_replace['from_string'][ $i ], $str_replace['to_string'][ $i ], $description );
					$title       = str_replace( $str_replace['from_string'][ $i ], $str_replace['to_string'][ $i ], $title );
				} else {
					$description = str_ireplace( $str_replace['from_string'][ $i ], $str_replace['to_string'][ $i ], $description );
					$title       = str_ireplace( $str_replace['from_string'][ $i ], $str_replace['to_string'][ $i ], $title );
				}
			}
		}
		$post_id = wp_insert_post( array_merge( array(
			'post_title'   => $title,
			'post_type'    => 'vi_wad_draft_product',
			'post_status'  => 'draft',
			'post_excerpt' => '',
			'post_content' => $description,
		), $post_data ), true );
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			if ( count( $desc_images ) ) {
				update_post_meta( $post_id, '_vi_wad_description_images', $desc_images );
			}
			if ( $video ) {
				update_post_meta( $post_id, '_vi_wad_video', $video );
			}

			update_post_meta( $post_id, '_vi_wad_sku', $sku );
			update_post_meta( $post_id, '_vi_wad_attributes', $attributes );
			update_post_meta( $post_id, '_vi_wad_list_attributes', $list_attributes );
			if ( $shipping_info['freight'] ) {
				update_post_meta( $post_id, '_vi_wad_shipping_info', $shipping_info );
			}
			$gallery = array_unique( array_filter( $gallery ) );
			if ( count( $gallery ) ) {
				update_post_meta( $post_id, '_vi_wad_gallery', $gallery );
			}
			update_post_meta( $post_id, '_vi_wad_variation_images', $variation_images );
			if ( is_array( $store_info ) && count( $store_info ) ) {
				update_post_meta( $post_id, '_vi_wad_store_info', $store_info );
			}
			if ( count( $variations ) ) {
				$variations_news = array();
				foreach ( $variations as $key => $variation ) {
					$variations_new            = array();
					$variations_new['image']   = $variation['image'];
					$variations_new['sku']     = self::process_variation_sku( $sku, $variation['variation_ids'] );
					$variations_new['sku_sub'] = self::process_variation_sku( $sku, $variation['variation_ids_sub'] );
					$variations_new['skuId']   = $variation['skuId'];
					$variations_new['skuAttr'] = $variation['skuAttr'];
					$skuVal                    = isset( $variation['skuVal'] ) ? $variation['skuVal'] : array();
					if ( $currency_code === 'USD' && isset( $skuVal['skuMultiCurrencyCalPrice'] ) ) {
						$variations_new['regular_price'] = $skuVal['skuMultiCurrencyCalPrice'];
						$variations_new['sale_price']    = isset( $skuVal['actSkuMultiCurrencyCalPrice'] ) ? $skuVal['actSkuMultiCurrencyCalPrice'] : '';
						if ( isset( $skuVal['actSkuMultiCurrencyBulkPrice'] ) && self::string_to_float( $skuVal['actSkuMultiCurrencyBulkPrice'] ) > self::string_to_float( $variations_new['sale_price'] ) ) {
							$variations_new['sale_price'] = $skuVal['actSkuMultiCurrencyBulkPrice'];
						}
					} else {
						$variations_new['regular_price'] = isset( $skuVal['skuCalPrice'] ) ? $skuVal['skuCalPrice'] : '';
						$variations_new['sale_price']    = ( isset( $skuVal['actSkuCalPrice'], $skuVal['actSkuBulkCalPrice'] ) && self::string_to_float( $skuVal['actSkuBulkCalPrice'] ) > self::string_to_float( $skuVal['actSkuCalPrice'] ) ) ? $skuVal['actSkuBulkCalPrice'] : ( isset( $skuVal['actSkuCalPrice'] ) ? $skuVal['actSkuCalPrice'] : '' );
						if ( isset( $skuVal['skuAmount']['currency'], $skuVal['skuAmount']['value'] ) && $skuVal['skuAmount']['currency'] === 'USD' && $skuVal['skuAmount']['value'] ) {
							$variations_new['regular_price'] = $skuVal['skuAmount']['value'];
							if ( isset( $skuVal['skuActivityAmount']['currency'], $skuVal['skuActivityAmount']['value'] ) && $skuVal['skuActivityAmount']['currency'] === 'USD' && $skuVal['skuActivityAmount']['value'] ) {
								$variations_new['sale_price'] = $skuVal['skuActivityAmount']['value'];
							}
						}
					}
					$variations_new['stock']          = isset( $skuVal['availQuantity'] ) ? absint( $skuVal['availQuantity'] ) : 0;
					$variations_new['attributes']     = isset( $variation['variation_ids'] ) ? $variation['variation_ids'] : array();
					$variations_new['attributes_sub'] = isset( $variation['variation_ids_sub'] ) ? $variation['variation_ids_sub'] : array();
					$variations_new['ship_from']      = isset( $variation['ship_from'] ) ? $variation['ship_from'] : '';
					$variations_news[]                = $variations_new;
				}
				update_post_meta( $post_id, '_vi_wad_variations', $variations_news );
			}
			self::update_attributes_list( $attributes );
		}

		return $post_id;
	}

	/**
	 * Update attributes list for Attributes mapping function
	 *
	 * @param $attributes
	 */
	public static function update_attributes_list( $attributes ) {
		$attributes_list = get_transient( 'vi_wad_product_attributes_list' );
		if ( $attributes_list !== false ) {
			$attributes_list = vi_wad_json_decode( $attributes_list );
			foreach ( $attributes as $key => $attribute ) {
				if ( isset( $attribute['slug'] ) ) {
					if ( ! isset( $attributes_list[ $attribute['slug'] ] ) ) {
						$attributes_list[ $attribute['slug'] ] = array();
					}
					if ( is_array( $attribute['values'] ) ) {
						$attributes_list[ $attribute['slug'] ] = array_values( array_unique( array_merge( $attributes_list[ $attribute['slug'] ], array_map( 'strtolower', $attribute['values'] ) ) ) );
					}
				}
			}
			set_transient( 'vi_wad_product_attributes_list', json_encode( $attributes_list ) );
		}
	}

	public static function get_ali_country_locale( $country_code ) {
		$country_code = strtolower( $country_code );
		$locale       = array(
			'id' => 'id',
			'kr' => 'ko',
			'ma' => 'ar',
			'de' => 'de',
			'es' => 'es',
			'fr' => 'fr',
			'it' => 'it',
			'nl' => 'nl',
			'br' => 'pt',
			'vn' => 'vi',
			'il' => 'he',
			'jp' => 'ja',
			'pl' => 'pl',
			'ru' => 'ru',
			'ar' => 'es',
			'at' => 'de',
			'tr' => 'tr',
		);

		return isset( $locale[ $country_code ] ) ? $locale[ $country_code ] : '';
	}

	public static function get_ali_tax( $country_code ) {
		$country_code = strtolower( $country_code );
		$rates        = array(
			/*US*/
//			'us' => 10,
			/*New Zealand*/
//			'nz' => 15,
			/*Australia*/
//			'au' => 10,
			/*EU*/
			'at' => 20,
			'be' => 21,
			'cz' => 21,
			'dk' => 25,
			'ee' => 20,
			'fi' => 24,
			'fr' => 20,
			'de' => 19,
			'gr' => 24,
			'hu' => 27,
			'is' => 24,
			'ie' => 23,
			'it' => 22,
			'lv' => 21,
			'lu' => 17,
			'nl' => 21,
			'no' => 25,
			'pl' => 23,
			'pt' => 23,
			'sk' => 20,
			'si' => 22,
			'es' => 21,
			'se' => 25,
			'ch' => 7.7,
			/*United Kingdom*/
//			'uk' => 20,
		);

		return isset( $rates[ $country_code ] ) ? $rates[ $country_code ] / 100 : '';
	}

	/**
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	public static function sort_by_column_origin( $a, $b ) {
		return strnatcasecmp( $a['origin'], $b['origin'] );
	}

	private static function property_value_id_to_ship_from( $property_id, $property_value_id ) {
		$ship_from = '';
		if ( $property_id == 200007763 ) {
			switch ( $property_value_id ) {
				case 203372089:
					$ship_from = 'PL';
					break;
				case 201336100:
				case 201441035:
					$ship_from = 'CN';
					break;
				case 201336103:
					$ship_from = 'RU';
					break;
				case 100015076:
					$ship_from = 'BE';
					break;
				case 201336104:
					$ship_from = 'ES';
					break;
				case 201336342:
					$ship_from = 'FR';
					break;
				case 201336106:
					$ship_from = 'US';
					break;
				case 201336101:
					$ship_from = 'DE';
					break;
				case 203124901:
					$ship_from = 'UA';
					break;
				case 201336105:
					$ship_from = 'UK';
					break;
				case 201336099:
					$ship_from = 'AU';
					break;
				case 203287806:
					$ship_from = 'CZ';
					break;
				case 201336343:
					$ship_from = 'IT';
					break;
				case 203054831:
					$ship_from = 'TR';
					break;
				case 203124902:
					$ship_from = 'AE';
					break;
				case 100015009:
					$ship_from = 'ZA';
					break;
				case 201336102:
					$ship_from = 'ID';
					break;
				case 202724806:
					$ship_from = 'CL';
					break;
				case 203054829:
					$ship_from = 'BR';
					break;
				case 203124900:
					$ship_from = 'VN';
					break;
				case 203124903:
					$ship_from = 'IL';
					break;
				case 100015000:
					$ship_from = 'SA';
					break;
				case 5581:
					$ship_from = 'KR';
					break;
				default:
			}
		}

		return $ship_from;
	}

	public static function bump_request_timeout() {
		return 60;
	}

	public static function get_schedule_time_from_local_time( $hour, $minute, $second ) {
		$gmt_offset          = intval( get_option( 'gmt_offset' ) );
		$schedule_time_local = strtotime( 'today' ) + HOUR_IN_SECONDS * absint( $hour ) + MINUTE_IN_SECONDS * absint( $minute ) + absint( $second );
		if ( $gmt_offset < 0 ) {
			$schedule_time_local -= DAY_IN_SECONDS;
		}
		$schedule_time = $schedule_time_local - HOUR_IN_SECONDS * $gmt_offset;
		if ( $schedule_time < time() ) {
			$schedule_time += DAY_IN_SECONDS;
		}

		return $schedule_time;
	}

	public static function is_sku_attr_equal( $sku_attr_1, $sku_attr_2 ) {
		$equal          = false;
		$sku_attr_1_arr = explode( ';', $sku_attr_1 );
		foreach ( $sku_attr_1_arr as &$skuAttr_v ) {
			$skuAttr_v = explode( '#', $skuAttr_v )[0];
		}
		$sku_attr_2_arr = explode( ';', $sku_attr_2 );
		foreach ( $sku_attr_2_arr as &$skuAttr_v ) {
			$skuAttr_v = explode( '#', $skuAttr_v )[0];
		}
		if ( count( $sku_attr_1_arr ) === count( array_intersect( $sku_attr_1_arr, $sku_attr_2_arr ) ) ) {
			$equal = true;
		}

		return $equal;
	}

	/**
	 * Must use this method instead of array_search because there may be differences in the order of attributes in sku ID of the same variation
	 * E.G: 14:771#BK;5:361386;200007763:201336100 and 14:771#BK;200007763:201336100;5:361386
	 *
	 * @param $skuAttr
	 * @param $search_skuAttrs
	 *
	 * @return bool|int|string
	 */
	public static function search_sku_attr( $skuAttr, $search_skuAttrs ) {
		$search      = false;
		$skuAttr_arr = explode( ';', $skuAttr );
		foreach ( $skuAttr_arr as &$skuAttr_v ) {
			$skuAttr_v = explode( '#', $skuAttr_v )[0];
		}
		$skuAttr_arr_count = count( $skuAttr_arr );
		foreach ( $search_skuAttrs as $key => $value ) {
			if ( $value ) {
				$value_arr = explode( ';', $value );
				foreach ( $value_arr as &$skuAttr_v ) {
					$skuAttr_v = explode( '#', $skuAttr_v )[0];
				}
				if ( $skuAttr_arr_count === count( array_intersect( $skuAttr_arr, $value_arr ) ) ) {
					$search = $key;
					break;
				}
			}
		}

		return $search;
	}

	public static function aliexpress_ru_get_currency( $widgets ) {
		global $wad_count;
		$wad_count ++;
		$currency = '';
		foreach ( $widgets as $key => $value ) {
			if ( ! is_array( $value ) ) {
				continue;
			}
			if ( $key === 'currencyProps' ) {
				$currency = isset( $value['selected']['currencyType'] ) ? $value['selected']['currencyType'] : '';
				break;
			}
			$currency = self::aliexpress_ru_get_currency( $value );
			if ( $currency ) {
				break;
			}
		}

		return $currency;
	}

	public static function aliexpress_ru_get_description( $widgets ) {
		$description = null;
		foreach ( $widgets as $key => $value ) {
			if ( $key === 'html' ) {
				$description = $value ? $value : '';
				break;
			}
			if ( is_array( $value ) ) {
				$description = self::aliexpress_ru_get_description( $value );
			}
			if ( isset( $description ) ) {
				break;
			}
		}

		return $description;
	}

	public static function aliexpress_ru_get_specs_module( $widgets ) {
		$specs_module = null;
		foreach ( $widgets as $key => $value ) {
			if ( $key === 'char' ) {
				$specs_module = $value ? $value : array();
				break;
			}
			if ( is_array( $value ) ) {
				$specs_module = self::aliexpress_ru_get_specs_module( $value );
			}
			if ( isset( $specs_module ) ) {
				break;
			}
		}

		return $specs_module;
	}

	public static function aliexpress_ru_get_store_info( $widgets ) {
		$store_info = null;
		foreach ( $widgets as $key => $value ) {
			if ( $key === 'shop' ) {
				$store_info = $value;
				break;
			}
			if ( is_array( $value ) ) {
				$store_info = self::aliexpress_ru_get_store_info( $value );
			}
			if ( isset( $store_info ) ) {
				break;
			}
		}

		return $store_info;
	}

	public static function wpml_get_original_object_id( $object_id, $object_type = 'product' ) {
		$wpml_id = '';
		if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
			global $sitepress;
			$default_lang     = apply_filters( 'wpml_default_language', null );
			$current_language = apply_filters( 'wpml_current_language', null );
			if ( $current_language && $current_language !== $default_lang ) {
				$wpml_object_id = apply_filters(
					'wpml_object_id', $object_id, $object_type, false, $sitepress->get_default_language()
				);
				if ( $wpml_object_id != $object_id ) {
					$wpml_object = $object_type === 'product' ? wc_get_product( $wpml_object_id ) : get_post( $wpml_object_id );
					if ( $wpml_object ) {
						$wpml_id = $wpml_object_id;
					}
				}
			}
		}

		return $wpml_id;
	}

	public static function aliexpress_pt_get_trade_currency( $data ) {
		$currency = '';
		foreach ( $data as $key => $value ) {
			if ( ! is_array( $value ) ) {
				continue;
			}
			if ( substr( $key, 0, 9 ) === 'shipping_' ) {
				if ( isset( $value['type'] ) && $value['type'] === 'shipping' ) {
					if ( isset( $value['fields'], $value['fields']['tradeCurrency'] ) && $value['fields']['tradeCurrency'] ) {
						$currency = $value['fields']['tradeCurrency'];
						break;
					}
				}
			}
			$currency = self::aliexpress_pt_get_trade_currency( $value );
			if ( $currency ) {
				break;
			}
		}

		return $currency;
	}

	public static function aliexpress_pt_get_specs_module( $data ) {
		$specs = null;
		foreach ( $data as $key => $value ) {
			if ( ! is_array( $value ) ) {
				continue;
			}
			if ( substr( $key, 0, 10 ) === 'specsInfo_' ) {
				if ( isset( $value['type'] ) && $value['type'] === 'specsInfo' ) {
					if ( isset( $value['fields'], $value['fields']['specs'] ) ) {
						$specs = $value['fields']['specs'];
						break;
					}
				}
			}
			$specs = self::aliexpress_pt_get_specs_module( $value );
			if ( isset( $specs ) ) {
				break;
			}
		}

		return $specs;
	}

	public static function aliexpress_pt_get_description( $data ) {
		$desc = null;
		foreach ( $data as $key => $value ) {
			if ( ! is_array( $value ) ) {
				continue;
			}
			if ( substr( $key, 0, 12 ) === 'description_' ) {
				if ( isset( $value['type'] ) && $value['type'] === 'description' ) {
					if ( isset( $value['fields'], $value['fields']['detailDesc'] ) ) {
						$desc = $value['fields']['detailDesc'];
						break;
					}
				}
			}
			$desc = self::aliexpress_pt_get_description( $value );
			if ( isset( $desc ) ) {
				break;
			}
		}

		return $desc;
	}

	public static function aliexpress_pt_get_store_info( $data ) {
		$store_info = null;
		foreach ( $data as $key => $value ) {
			if ( ! is_array( $value ) ) {
				continue;
			}
			if ( substr( $key, 0, 15 ) === 'storeRecommend_' ) {
				if ( isset( $value['type'] ) && $value['type'] === 'storeRecommend' ) {
					if ( isset( $value['fields'] ) ) {
						$store_info = $value['fields'];
						break;
					}
				}
			}
			$store_info = self::aliexpress_pt_get_store_info( $value );
			if ( isset( $store_info ) ) {
				break;
			}
		}

		return $store_info;
	}

	public static function aliexpress_pt_get_image_view( $data ) {
		$image_view = null;
		foreach ( $data as $key => $value ) {
			if ( ! is_array( $value ) ) {
				continue;
			}
			if ( substr( $key, 0, 10 ) === 'imageView_' ) {
				if ( isset( $value['type'] ) && $value['type'] === 'imageView' ) {
					if ( isset( $value['fields'] ) ) {
						$image_view = $value['fields'];
						break;
					}
				}
			}
			$image_view = self::aliexpress_pt_get_image_view( $value );
			if ( isset( $image_view ) ) {
				break;
			}
		}

		return $image_view;
	}

	public static function aliexpress_pt_get_sku_module( $data ) {
		$sku_module = null;
		foreach ( $data as $key => $value ) {
			if ( ! is_array( $value ) ) {
				continue;
			}
			if ( substr( $key, 0, 4 ) === 'sku_' ) {
				if ( isset( $value['type'] ) && $value['type'] === 'sku' ) {
					if ( isset( $value['fields'] ) ) {
						$sku_module = $value['fields'];
						break;
					}
				}
			}
			$sku_module = self::aliexpress_pt_get_sku_module( $value );
			if ( isset( $sku_module ) ) {
				break;
			}
		}

		return $sku_module;
	}

	public static function aliexpress_pt_get_title_module( $data ) {
		$title_module = null;
		foreach ( $data as $key => $value ) {
			if ( ! is_array( $value ) ) {
				continue;
			}
			if ( substr( $key, 0, 12 ) === 'titleBanner_' ) {
				if ( isset( $value['type'] ) && $value['type'] === 'titleBanner' ) {
					if ( isset( $value['fields'] ) ) {
						$title_module = $value['fields'];
						break;
					}
				}
			}
			$title_module = self::aliexpress_pt_get_title_module( $value );
			if ( isset( $title_module ) ) {
				break;
			}
		}

		return $title_module;
	}

	public static function aliexpress_pt_get_action_module( $data ) {
		$action_module = null;
		foreach ( $data as $key => $value ) {
			if ( ! is_array( $value ) ) {
				continue;
			}
			if ( substr( $key, 0, 14 ) === 'actionButtons_' ) {
				if ( isset( $value['type'] ) && $value['type'] === 'actionButtons' ) {
					if ( isset( $value['fields'] ) ) {
						$action_module = $value['fields'];
						break;
					}
				}
			}
			$action_module = self::aliexpress_pt_get_action_module( $value );
			if ( isset( $action_module ) ) {
				break;
			}
		}

		return $action_module;
	}
}