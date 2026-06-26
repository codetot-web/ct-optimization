<?php
/**
 * REST API endpoint for CT Optimization settings.
 *
 * @link       https://codetot.com
 * @since      1.7.0
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/includes
 */

/**
 * Handles GET/POST for plugin settings via WP REST API.
 *
 * @since 1.7.0
 */
class Codetot_Optimization_REST {

	/**
	 * The REST namespace.
	 *
	 * @var string
	 */
	private $namespace = 'codetot-optimization/v1';

	/**
	 * The option name stored in wp_options.
	 *
	 * @var string
	 */
	private $option_name = 'ct-optimization';

	/**
	 * Register routes.
	 *
	 * @since 1.7.0
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/settings',
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_settings' ),
					'permission_callback' => array( $this, 'check_admin_permission' ),
				),
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'update_settings' ),
					'permission_callback' => array( $this, 'check_admin_permission' ),
					'args'                => $this->get_update_args(),
				),
			)
		);

		register_rest_route(
			$this->namespace,
			'/settings/schema',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_schema' ),
				'permission_callback' => array( $this, 'check_admin_permission' ),
			)
		);
	}

	/**
	 * Permission callback — only admins.
	 *
	 * @return bool|WP_Error
	 */
	public function check_admin_permission() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return new WP_Error(
				'rest_forbidden',
				__( 'You do not have permission to manage plugin settings.', 'codetot-optimization' ),
				array( 'status' => 403 )
			);
		}
		return true;
	}

	/**
	 * GET /settings — return all parsed options.
	 *
	 * @return WP_REST_Response
	 */
	public function get_settings() {
		$raw   = get_option( $this->option_name, array() );
		$clean = array();

		if ( is_array( $raw ) ) {
			foreach ( $raw as $key => $value ) {
				$clean_key = str_replace( '-', '_', $key );

				if ( 'yes' === $value ) {
					$clean[ $clean_key ] = true;
				} elseif ( 'no' === $value ) {
					$clean[ $clean_key ] = false;
				} else {
					$clean[ $clean_key ] = $value;
				}
			}
		}

		return new WP_REST_Response( array( 'settings' => $clean ), 200 );
	}

	/**
	 * POST /settings — update one or more options.
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function update_settings( $request ) {
		$settings = $request->get_json_params();
		$current  = get_option( $this->option_name, array() );

		if ( ! is_array( $current ) ) {
			$current = array();
		}

		foreach ( $settings as $key => $value ) {
			// Convert camelCase or underscore keys back to the expected format.
			$db_key = str_replace( '_', '-', $key );

			// Convert boolean/true/false back to yes/no for existing format compat.
			if ( is_bool( $value ) ) {
				$current[ $db_key ] = $value ? 'yes' : 'no';
			} else {
				$current[ $db_key ] = sanitize_text_field( $value );
			}
		}

		update_option( $this->option_name, $current );

		return new WP_REST_Response(
			array(
				'success'  => true,
				'settings' => $this->flatten_settings( $current ),
			),
			200
		);
	}

	/**
	 * GET /settings/schema — return field definitions for the React UI.
	 *
	 * @return WP_REST_Response
	 */
	public function get_schema() {
		$schema = array(
			array(
				'id'       => 'global_settings',
				'title'    => __( 'Global Settings', 'codetot-optimization' ),
				'icon'     => 'admin-site',
				'fields'   => array(
					array(
						'id'    => 'disable_gutenberg_block_editor',
						'label' => __( 'Gutenberg Block Editor', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_gutenberg_widgets',
						'label' => __( 'Gutenberg Widgets', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_emoji',
						'label' => __( 'Emoji', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'hide_wordpress_version',
						'label' => __( 'WordPress Version', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_oembed',
						'label' => __( 'oEmbed', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_xmlrpc',
						'label' => __( 'XMLRPC', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_heartbeat',
						'label' => __( 'Heartbeat', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_comments',
						'label' => __( 'Comments', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_ping',
						'label' => __( 'Ping', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_feed',
						'label' => __( 'Feed', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_shortlink',
						'label' => __( 'Shortlink', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_wlw_manifest',
						'label' => __( 'WLW Manifest', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_inline_comment_style',
						'label' => __( 'Inline Comment Style', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_query_strings',
						'label' => __( 'Query Strings from Assets', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_self_pingbacks',
						'label' => __( 'Self Pingbacks', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_rest_api',
						'label' => __( 'REST API (non-auth)', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'remove_dashboard_widgets',
						'label' => __( 'Dashboard Widgets', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_attachment_pages',
						'label' => __( 'Attachment Pages', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'remove_jquery_migrate',
						'label' => __( 'jQuery Migrate', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'disable_xml_sitemaps',
						'label' => __( 'XML Sitemaps', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'remove_frontend_dashicons',
						'label' => __( 'Front-end Dashicons', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
				),
			),
			array(
				'id'     => 'assets_optimization',
				'title'  => __( 'Assets Optimization', 'codetot-optimization' ),
				'icon'   => 'admin-media',
				'fields' => array(
					array(
						'id'    => 'disable_global_styles',
						'label' => __( 'Disable Global Styles (Duotone)', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'      => 'load_lazysizes_scripts',
						'label'   => __( 'Load Lazysizes Script', 'codetot-optimization' ),
						'type'    => 'toggle',
					),
				),
			),
			array(
				'id'     => 'advanced',
				'title'  => __( 'Advanced Settings', 'codetot-optimization' ),
				'icon'   => 'admin-generic',
				'fields' => array(
					array(
						'id'    => 'enable_cdn_domain',
						'label' => __( 'Enable CDN Domain', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'          => 'cdn_domain',
						'label'       => __( 'CDN Domain', 'codetot-optimization' ),
						'type'        => 'text',
						'placeholder' => 'cdn.example.com',
					),
				),
			),
			array(
				'id'     => 'plugins',
				'title'  => __( 'Plugin Settings', 'codetot-optimization' ),
				'icon'   => 'admin-plugins',
				'fields' => array(
					array(
						'id'    => 'disable_gravity_forms_default_styles',
						'label' => __( 'Disable Gravity Forms Default Styles', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'hide_gravity_forms_menus',
						'label' => __( 'Hide Gravity Forms Menus', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
					array(
						'id'    => 'load_gravity_forms_in_footer',
						'label' => __( 'Load Gravity Forms in Footer', 'codetot-optimization' ),
						'type'  => 'toggle',
					),
				),
			),
		);

		return new WP_REST_Response( array( 'schema' => $schema ), 200 );
	}

	/**
	 * Convert DB format (yes/no keys) to flat boolean/string map.
	 *
	 * @param array $raw Raw option array.
	 * @return array
	 */
	private function flatten_settings( $raw ) {
		$flat = array();
		foreach ( $raw as $key => $value ) {
			$k = str_replace( '-', '_', $key );
			if ( 'yes' === $value ) {
				$flat[ $k ] = true;
			} elseif ( 'no' === $value ) {
				$flat[ $k ] = false;
			} else {
				$flat[ $k ] = $value;
			}
		}
		return $flat;
	}

	/**
	 * Argument definitions for the POST endpoint.
	 *
	 * @return array
	 */
	private function get_update_args() {
		return array(
			'settings' => array(
				'description' => __( 'Settings key/value pairs.', 'codetot-optimization' ),
				'type'        => 'object',
				'required'    => true,
			),
		);
	}
}
