<?php
/**
 * Plugin Name: Edwiser — Enroll on Processing
 * Plugin URI: https://github.com/MindfulDesign-me/edwiser-enroll-on-processing
 * Description: Optionally enrolls Moodle courses when a WooCommerce order reaches Processing (Edwiser Bridge Pro). Settings: Edwiser Bridge → Settings → Woo Integration.
 * Author: Mindful Design
 * Author URI: https://mindfuldesign.me
 * Version: 1.0.0
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package Edwiser_Enroll_On_Processing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Option key stored inside eb_woo_int_settings (same option as other Woo Integration fields).
 */
const EB_EOP_SETTING_ID = 'wi_enroll_on_processing';

/**
 * Resolve Edwiser Bridge Pro version for Bridge_Woocommerce_Order_Manager constructor.
 *
 * @return string
 */
function eb_eop_get_eb_pro_version() {
	if ( defined( 'EB_PRO_PLUGIN_VERSION' ) ) {
		return EB_PRO_PLUGIN_VERSION;
	}
	if ( function_exists( 'get_plugin_data' ) ) {
		$path = WP_PLUGIN_DIR . '/edwiser-bridge-pro/edwiser-bridge-pro.php';
		if ( file_exists( $path ) ) {
			$data = get_plugin_data( $path, false, false );
			if ( ! empty( $data['Version'] ) ) {
				return $data['Version'];
			}
		}
	}
	return '1.0.0';
}

/**
 * Whether “enroll on Processing” is enabled.
 *
 * @return bool
 */
function eb_eop_is_enabled() {
	$settings = get_option( 'eb_woo_int_settings', array() );
	return isset( $settings[ EB_EOP_SETTING_ID ] ) && 'yes' === $settings[ EB_EOP_SETTING_ID ];
}

/**
 * Instantiate Edwiser order manager when the class is available.
 *
 * @return \app\wisdmlabs\edwiserBridgePro\includes\wooInt\Bridge_Woocommerce_Order_Manager|null
 */
function eb_eop_get_order_manager() {
	if ( ! class_exists( '\app\wisdmlabs\edwiserBridgePro\includes\wooInt\Bridge_Woocommerce_Order_Manager' ) ) {
		return null;
	}
	$slug = 'edwiser_bridge_pro';
	return new \app\wisdmlabs\edwiserBridgePro\includes\wooInt\Bridge_Woocommerce_Order_Manager( $slug, eb_eop_get_eb_pro_version() );
}

/**
 * After Edwiser handles order status, optionally enroll on Processing using the same logic as Completed.
 *
 * @param int    $order_id   Order ID.
 * @param string $old_status Previous status.
 * @param string $new_status New status.
 */
function eb_eop_maybe_enroll_on_processing( $order_id, $old_status, $new_status ) {
	if ( ! eb_eop_is_enabled() ) {
		return;
	}
	if ( 'processing' !== $new_status ) {
		return;
	}
	if ( empty( $order_id ) ) {
		return;
	}
	$order = wc_get_order( $order_id );
	if ( ! $order ) {
		return;
	}
	if ( $order->get_meta( '_is_processed', true ) ) {
		return;
	}

	$manager = eb_eop_get_order_manager();
	if ( ! $manager ) {
		return;
	}

	$manager->handle_order_complete( (int) $order_id );
}

add_action( 'wooint_after_order_status_changed', 'eb_eop_maybe_enroll_on_processing', 10, 3 );

/**
 * Add checkbox to Edwiser → Settings → Woo Integration.
 *
 * @param array $settings Settings field definitions.
 * @return array
 */
function eb_eop_register_settings_fields( $settings ) {
	if ( ! is_array( $settings ) ) {
		return $settings;
	}

	$extra = array(
		array(
			'title' => __( 'Course enrollment timing', 'edwiser-enroll-on-processing' ),
			'type'  => 'title',
			'desc'  => '',
			'id'    => 'eb_eop_enrollment_timing',
		),
		array(
			'title'    => __( 'Enroll when order is Processing', 'edwiser-enroll-on-processing' ),
			'desc'     => __( 'Enroll learners in Moodle as soon as the order reaches <strong>Processing</strong> (paid / ready to fulfill). Use this if orders that include courses stay in Processing until physical items ship. If disabled, enrollment follows Edwiser default (when the order is <strong>Completed</strong>).', 'edwiser-enroll-on-processing' ),
			'id'       => EB_EOP_SETTING_ID,
			'default'  => 'no',
			'type'     => 'checkbox',
			'autoload' => false,
		),
		array(
			'type' => 'sectionend',
			'id'   => 'eb_eop_enrollment_timing',
		),
	);

	return array_merge( $settings, $extra );
}

add_filter( 'wooint_settings_fields', 'eb_eop_register_settings_fields', 20 );
