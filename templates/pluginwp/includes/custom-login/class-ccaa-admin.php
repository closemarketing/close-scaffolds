<?php
/**
 * Admin defaults
 *
 * Has functions customize the WordPress Admins
 *
 * @author   closemarketing
 * @category Functions
 * @package  Admin
 */

/**
 * Class for admin fields
 */
class CLOSE_WPAdmin {

	/**
	 * Construct of Class
	 */
	public function __construct() {
		// Customizes Admin.
		add_action( 'admin_head', array( $this, 'hide_menu_editor' ) );

		// Disable default dashboard widgets.
		add_action( 'wp_dashboard_setup', array( $this, 'add_custom_dashboard_widget' ) );
		add_action( 'admin_init', array( $this, 'disable_default_dashboard_widgets' ) );
		add_filter( 'admin_footer_text', array( $this, 'closemarketing_footer_admin' ) );

		// Different colour of status entry.
		add_filter( 'user_contactmethods', array( $this, 'remove_profile_fields' ), 10, 1 );
		add_action( 'wp_head', array( $this, 'change_bar_color' ) );
		add_action( 'admin_head', array( $this, 'change_bar_color' ) );
		add_action( '_admin_menu', array( $this, 'remove_editor_menu' ), 1 );
		add_action( 'admin_init', array( $this, 'customize_meta_boxes' ) );
		add_action( 'wp_dashboard_setup', array( $this, 'dashboard_widgets' ) );
		add_filter( 'the_excerpt_rss', array( $this, 'rss_post_thumbnail' ) );
		add_filter( 'the_content_feed', array( $this, 'rss_post_thumbnail' ) );
		add_action( 'admin_footer', array( $this, 'posts_status_color' ) );
		add_action( 'after_setup_theme', array( $this, 'remove_posts_formats' ), 100 );

		add_action( 'login_head', array( $this, 'custom_login_logo' ), 99 );

		// Add Access to Editor.
		$role_object = get_role( 'editor' );
		if ( ! is_null( $role_object ) ) {
			// add $cap capability to this role object.
			$role_object->add_cap( 'edit_theme_options' );
			$role_object->add_cap( 'gform_full_access' );
		}

		// Thumbnails in columns admin.
		if ( function_exists( 'add_theme_support' ) ) {
			add_filter( 'manage_posts_columns', array( $this, 'posts_columns' ), 5 );
			add_filter( 'manage_pages_columns', array( $this, 'posts_columns' ), 5 );
		}

		// Add custom post types count action to WP Dashboard.
		add_action( 'dashboard_glance_items', array( $this, 'custom_posttype_glance_items' ) );

		// Changes in Attachments.
		add_action( 'admin_init', array( $this, 'imagelink_setup' ), 10 );
		add_action( 'add_attachment', array( $this, 'set_image_meta_upon_image_upload' ) );

		// Deactive notifications to admin that password has change.
		if ( ! function_exists( 'wp_password_change_notification' ) ) {
			/**
			 * Deactive Notifications to admin
			 *
			 * @return void
			 */
			function wp_password_change_notification() {}
		}
	}

	/**
	 * # Functions
	 * ---------------------------------------------------------------------------------------------------- */

	/**
	 * Customizes the dashboard.
	 *
	 * @return void
	 */
	public function custom_dashboard_widget() {
		echo '<p>Contacto: <strong>858 958 383</strong>. <a href="mailto:info@close.marketing" target="_blank">Correo</a> | <a href="https://close.marketing/ayuda/?utm_source=WordPresAdmin" target="_blank">Tutoriales y ayuda</a> | <a href="https://www.facebook.com/closemarketing" target="_blank">Facebook</a></p>';
	}

	/**
	 * Hide menus for editor
	 *
	 * @return void
	 */
	public function hide_menu_editor() {
		$role_object = get_role( 'editor' );
		if ( ! is_null( $role_object ) ) {
			$role_object->add_cap( 'edit_theme_options' );
		}

		if ( current_user_can( 'editor' ) ) {
			remove_submenu_page( 'themes.php', 'themes.php' ); // hide the theme selection submenu.
			remove_submenu_page( 'themes.php', 'customize.php?return=%2Fwp-admin%2Ftools.php&#038;autofocus%5Bcontrol%5D=background_image' ); // hide the background submenu.
			// these are theme-specific. Can have other names or simply not exist in your current theme.
			remove_submenu_page( 'themes.php', 'yiw_panel' );
		}
	}

	/**
	 * Adds Closemarketing dashboard
	 *
	 * @return void
	 */
	public function add_custom_dashboard_widget() {
		wp_add_dashboard_widget(
			'custom_dashboard_widget',
			'Contactar con Close·marketing',
			array( $this, 'custom_dashboard_widget' )
		);
	}

	/**
	 * Disables default dashboards
	 *
	 * @return void
	 */
	public function disable_default_dashboard_widgets() {
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'sf_announce', 'dashboard', 'normal' );
		remove_meta_box( 'so-dashboard-news', 'dashboard', 'normal' );
	}

	/**
	 * Shows customized footer for Closemarketing
	 *
	 * @return void
	 */
	public function closemarketing_footer_admin() {
		echo 'Close·marketing - Dise&ntilde;o y Marketing ' . esc_html( date( 'Y' ) );
		echo '. Realizado sobre Gestor Contenidos WordPress.';
	}

	/**
	 * Customize Author fields
	 *
	 * @param array $contactmethods Array of methods contact.
	 * @return array $contactmethods
	 */
	public function remove_profile_fields( $contactmethods ) {
		unset( $contactmethods['aim'] );
		unset( $contactmethods['myspace'] );
		unset( $contactmethods['pinterest'] );
		unset( $contactmethods['soundcloud'] );
		unset( $contactmethods['tumblr'] );
		unset( $contactmethods['jabber'] );
		unset( $contactmethods['yim'] );

		return $contactmethods;
	}

	/**
	 * Customizes Login logo
	 *
	 * @return void
	 */
	public function custom_login_logo() {
		echo '<style type="text/css">
		h1 a { background-image:url(' . esc_url( {{PREFIX_UPPER}}_PLUGIN_URL ) . 'includes/custom-login/logo-login.svg) !important; width: 320px !important; background-size: 320px !important; }
		body.login {background: #D4ECED; }
		.login label {color:#0A878B;}
		.login form { background: white; border: 3px solid #0A878B;}
		.wp-core-ui .button-primary {background-color: #0A878B; border-color: #0A878B;}
		.wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover {  background-color: #0A878B;border-color: #0A878B; }
		.login #backtoblog a, .login #nav a { color: white; }
		.login #backtoblog a:hover, .login #nav a:hover { color: white; }
		.galogin-powered,.galogin-or {display: none;}
		</style>';
	}

	/**
	 * Change admin bar color
	 *
	 * @return void
	 */
	public function change_bar_color() {
		$server_host = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
		$tldcal = explode( '.', $server_host );
		$tld    = end( $tldcal );

		if ( 'localhost' == $server_host || 'loc' === $tld || 'local' === $tld ) {
			// local.
			$color = 'red';
		} elseif ( 0 === strpos( $server_host, 'beta' ) ) {
			$color = 'orange';
		} else {
			// live.
			$color = '#D4ECED';
		}
		echo '<style>
			#wpadminbar { background: ' . esc_html( $color ) . ' !important; }
			#adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, #adminmenu .wp-menu-arrow, #adminmenu .wp-menu-arrow div, #adminmenu li.current a.menu-top, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, .folded #adminmenu li.current.menu-top, .folded #adminmenu li.wp-has-current-submenu {
				background: ' . esc_html( $color ) . ' !important;
			}
			#adminmenu .wp-submenu a:focus, #adminmenu .wp-submenu a:hover, #adminmenu a:hover, #adminmenu li.menu-top>a:focus,#adminmenu li.menu-top:hover, #adminmenu li.opensub>a.menu-top, #adminmenu li>a.menu-top:focus, #adminmenu li a:focus div.wp-menu-image:before, #adminmenu li.opensub div.wp-menu-image:before, #adminmenu li:hover div.wp-menu-image:before {
				color: ' . esc_html( $color ) . ' !important;
			}
			.wc-install.ultp-pro-notice, .license-warning.notice.notice-error.is-dismissible {	display: none; }			#wpadminbar #wp-admin-bar-wp-logo>.ab-item {
				padding: 0;
				background-image: url( ' . esc_url( {{PREFIX_UPPER}}_PLUGIN_URL ) . 'includes/custom-login/logo-mini.svg) !important;
				background-size: 88%;
				background-position: center;
				background-repeat: no-repeat;
				opacity: 1;
				width: 100px;
			  }
			  #wpadminbar #wp-admin-bar-wp-logo>.ab-item .ab-icon:before {
				content: " ";
				top: 2px;
			}
			</style>';
	}

	/**
	 * Disable menu editor
	 *
	 * @return void
	 */
	public function remove_editor_menu() {
		remove_action( 'admin_menu', '_add_themes_utility_last', 101 );
	}

	/**
	 * Customize Metaboxes
	 *
	 * @return void
	 */
	public function customize_meta_boxes() {
		$current_user = wp_get_current_user();

		// If current user level is less than 3, remove the postcustom meta box.
		if ( $current_user->user_level < 3 ) {
			remove_meta_box( 'postcustom', 'post', 'normal' );
		}

		remove_meta_box( 'trackbacksdiv', 'post', 'normal' );
	}

	/**
	 * Remove unnecesary widgets
	 *
	 * @return void
	 */
	public function dashboard_widgets() {
		global $wp_meta_boxes;
		// remove unnecessary widgets.
		// var_dump( $wp_meta_boxes['dashboard'] ); // use to get all the widget IDs.
		unset(
			$wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'],
			$wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'],
			$wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']
		);
		// add a custom dashboard widget.
		wp_add_dashboard_widget(
			'dashboard_custom_feed',
			'Noticias de Closemarketing',
			array( $this, 'dashboard_custom_feed_output' )
		); // add new RSS feed output.
	}

	/**
	 * Feed from closemarketing
	 *
	 * @return void
	 */
	public function dashboard_custom_feed_output() {
		echo '<div class="rss-widget">';
		wp_widget_rss_output(
			array(
				'url'          => 'https://close.marketing/feed/',
				'title'        => __( 'Close·marketing News', 'closemarketing-custom-admin' ),
				'items'        => 2,
				'show_summary' => 1,
				'show_author'  => 0,
				'show_date'    => 1,
			)
		);
		echo '</div>';
	}

	/**
	 * Adds image to a feed content
	 *
	 * @param string $content Content of post in feed.
	 * @return string $content
	 */
	public function rss_post_thumbnail( $content ) {
		global $post;
		if ( has_post_thumbnail( $post->ID ) ) {
			$content = '<p>' . get_the_post_thumbnail( $post->ID ) .
			'</p>' . get_the_excerpt();
		}

		return $content;
	}

	/**
	 * Status color for posts in admin
	 *
	 * @return void
	 */
	public function posts_status_color() {
		echo '
		<style>
		.status-draft { background: #FCE3F2 !important; }
		.status-pending { background: #87C5D6 !important; }
		.status-publish { /* by default */ }
		.status-future { background: #C6EBF5 !important; }
		.status-private { background: #F2D46F; }
		</style>';
	}

	/**
	 * Thumbnail column
	 *
	 * @param array $columns Columns of post type admin.
	 * @return array $columns
	 */
	public function posts_columns( $columns ) {
		$columns['cmk_post_thumbnail'] = __( 'Thumbnail', 'closemarketing-custom-admin' );
		return $columns;
	}

	/**
	 * Show thumnbail in post type column
	 *
	 * @param array  $column_name column name of post type.
	 * @param string $id ID of post.
	 * @return void
	 */
	public function posts_custom_column( $column_name, $id ) {
		if ( 'cmk_post_thumbnail' === $column_name ) {
			the_post_thumbnail( array( 125, 80 ) );
		}

	}

	/**
	 * Showing all custom posts count
	 *
	 * @return array $glances Array of post types
	 */
	public function custom_posttype_glance_items() {
		$glances = array();

		$args = array(
			'public'   => true, // Showing public post types only.
			'_builtin' => false, // Except the build-in wp post types (page, post, attachments).
		);

		// Getting your custom post types.
		$post_types = get_post_types( $args, 'object', 'and' );

		foreach ( $post_types as $post_type ) {
			// Counting each post.
			$num_posts = wp_count_posts( $post_type->name );

			// Number format.
			$num = number_format_i18n( $num_posts->publish );
			// Text format.
			$text = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $num_posts->publish ) );

			// If use capable to edit the post type.
			if ( current_user_can( 'edit_posts' ) ) {
				// Show with link.
				$glance = '<a class="' . $post_type->name . '-count" href="' . admin_url( 'edit.php?post_type=' . $post_type->name ) . '">' . $num . ' ' . $text . '</a>';
			} else {
				// Show without link.
				$glance = '<span class="' . $post_type->name . '-count">' . $num . ' ' . $text . '</span>';
			}

			// Save in array.
			$glances[] = $glance;
		}

		// Return them.
		return $glances;
	}

	/**
	 * # Attachments
	 * ---------------------------------------------------------------------------------------------------- */

	/**
	 * Automatically set the image Title, Alt-Text, Caption & Description upon upload
	 *
	 * @param string $post_ID Post id of attachment.
	 * @return void
	 */
	public function set_image_meta_upon_image_upload( $post_ID ) {

		if ( wp_attachment_is_image( $post_ID ) ) {

			// Sanitize the title: remove hyphens, underscores & extra.
			$my_image_title = get_post( $post_ID )->post_title;

			// Remove spaces.
			$my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ', $my_image_title );

			// Sanitize the title: capitalize first letter of every word (other letters lower case).
			$my_image_title = ucwords( strtolower( $my_image_title ) );
			$my_image_meta = array(
				'ID' => $post_ID,
				'post_title' => $my_image_title,
			);

			// Set the image Alt-Text.
			update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );

			// Set the image meta (e.g. Title, Excerpt, Content).
			wp_update_post( $my_image_meta );
		}
	}

	/**
	 * Disables image link
	 *
	 * @return void
	 */
	public function imagelink_setup() {
		$image_set = get_option( 'image_default_link_type' );

		if ( 'none' !== $image_set ) {
			update_option( 'image_default_link_type', 'none' );
		}
	}

	/**
	 * Remove Posts Formats
	 *
	 * @return void
	 */
	public function remove_posts_formats() {
		remove_theme_support( 'post-formats' );
	}

}

new CLOSE_WPAdmin();
