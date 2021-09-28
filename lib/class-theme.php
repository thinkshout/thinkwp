<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package thinkwp
 */

/**
 * Theme class that instantiates with actions, filters, and other definitions
 */
class Theme {
	/**
	 * Scripts version number used primarily in cache busting for updates
	 *
	 * @var string $scripts_version the version string attached to scripts and styles. Structure Site Wide Version.Feature Set.Breaking Patch.Non-breaking patch.
	 */
	public $scripts_version = '1.0.0';
	/**
	 * Scripts directory for use in enqueuing
	 *
	 * @var string $scripts_dir the directory path
	 */
	public $scripts_dir = 'dist';
	/**
	 * Construct the class adding actions, filters, and other initiation code
	 */
	public function __construct() {
		if ( file_exists( __DIR__ . '/dist_dev' ) ) {
			$this->scripts_dir = 'dist_dev';
		}
		// Theme activation and deactivation hooks
		register_activation_hook( __FILE__, [ $this, 'thinkwp_activate' ] );

		// Actions, Filters, and Theme Setup!
		add_action( 'init', [ $this, 'thinkwp_init' ] );
		add_action( 'init', [ $this, 'register_post_types' ] );
		add_action( 'init', [ $this, 'register_taxonomies' ] );
		add_action( 'after_setup_theme', [ $this, 'thinkwp_setup' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'thinkwp_scripts' ] );
		add_action( 'after_setup_theme', [ $this, 'thinkwp_content_width' ], 0 );

		// Initiate Timber!
		new ThemeTimber();
	}

	/**
	 * Theme activation hook
	 */
	public function thinkwp_activate() {
		$style_guide_page = array(
			'post_title'  => 'Style Guide',
			'post_status' => 'private',
			'post_author' => 1,
			'post_type'   => 'page'
		);
		wp_insert_post( $style_guide_page );
		// Add any additional activation code here
	}

	/**
	 * Fires after WordPress has finished loading but before any headers are sent.
	 */
	public function thinkwp_init() {}

	/**
	 * Register a custom post type
	 *
	 * @param string  $name The plaintext name of the post type.
	 * @param string  $names The plural plaintext name of the post type.
	 * @param string  $dashicon The slug of the dashicon you want you use for this post type.
	 * @param integer $position The numerical position or area in the admin menu that this post type should appear in.
	 * @param boolean $public True if this post type is queryable and should appear user in searches.
	 * @param array   $taxonomies The WordPress taxonomies this post type uses.
	 * @param array   $supports The WordPress features this post type uses.
	 */
	public function add_post_type( $name, $names, $dashicon, $position, $public = true, $taxonomies = [ 'category' ], $supports = [ 'title' ] ) {
		$type_args = array(
			'labels'              => array(
				'name'                  => $names,
				'singular_name'         => $name,
				'add_new'               => 'Add ' . $name,
				'add_new_item'          => 'Add New ' . $name,
				'edit_item'             => 'Edit ' . $name,
				'new_item'              => 'New ' . $name,
				'view_item'             => 'View ' . $name,
				'search_items'          => 'Search ' . $names,
				'not_found'             => 'No ' . $names . ' found',
				'not_found_in_trash'    => 'No ' . $names . ' in the trash',
				'all_items'             => 'All ' . $names,
				'archives'              => $names,
				'insert_into_item'      => 'Insert into ' . $name,
				'uploaded_to_this_item' => 'Upload to ' . $name,
				'featured_image'        => 'Featured Image',
				'set_featured_image'    => 'Set Featured Image',
				'remove_featured_image' => 'Remove Featured Image',
				'use_featured_image'    => 'Use as featured image',
			),
			'description'         => 'An object that includes all details about a ' . $name . ' type',
			'exclude_from_search' => false,
			'public'              => $public,
			'publicly_queryable'  => $public,
			'has_archive'         => $public,
			'show_ui'             => $public,
			'show_in_nav_menus'   => $public,
			'show_in_menu'        => $public,
			'show_in_admin_bar'   => $public,
			'show_in_rest'        => in_array( 'editor', $supports, true ),
			'menu_position'       => $position,
			'menu_icon'           => $dashicon,
			'taxonomies'          => $taxonomies,
			'rewrite'             => array( 'slug' => strtolower( $names ) ),
			'supports'            => $supports,
		);
		$type      = array(
			'name' => $name,
			'args' => $type_args,
		);
		register_post_type( $type['name'], $type['args'] );
	}

	/**
	 * Add Custom Post Types
	 */
	public function register_post_types() {
		// $this->add_post_type( 'Project', 'Projects', 'dashicons-megaphone', 5, true, [], [ 'title', 'editor', 'author' ] );
	}

	/**
	 * Register a custom taxonomy
	 *
	 * @param string  $name The plaintext name of the taxonomy.
	 * @param string  $names The plural plaintext name of the taxonomy.
	 * @param boolean $hierarchical True if this taxonomy can have children.
	 * @param boolean $public True if this taxonomy is queryable and should appear user in searches.
	 * @param array   $post_types The post types this taxonomy is registered to.
	 */
	public function add_custom_taxonomy( $name, $names, $hierarchical = true, $public = true, $post_types = [ 'post' ] ) {
		$labels = array(
			'name'              => $names,
			'singular_name'     => $name,
			'search_items'      => 'Search ' . $names,
			'all_items'         => 'All ' . $names,
			'parent_item'       => $hierarchical ? 'Parent ' . $name : null,
			'parent_item_colon' => $hierarchical ? 'Parent ' . $name . ':' : null,
			'edit_item'         => 'Edit ' . $name,
			'update_item'       => 'Update ' . $name,
			'add_new_item'      => 'Add New ' . $name,
			'new_item_name'     => 'New ' . $name . ' Name',
			'menu_name'         => $names,
		);

		register_taxonomy(
			$names,
			$post_types,
			array(
				'hierarchical'      => $hierarchical,
				'labels'            => $labels,
				'show_ui'           => $public,
				'show_in_rest'      => $public,
				'show_admin_column' => $public,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => $names ),
			)
		);
	}

	/**
	 * Register custom taxonomies
	 */
	public function register_taxonomies() {
		// $this->add_custom_taxonomy( 'Project Type', 'Project Types', false, true, [ 'project' ] );
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	public function thinkwp_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on thinkwp, use a find and replace
		 * to change 'thinkwp' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'thinkwp', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'thinkwp' ),
				'menu-2' => esc_html__( 'Footer Menu', 'thinkwp' ),
				'menu-3' => esc_html__( 'Footer Copyright', 'thinkwp' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/**
		 * Set up the WordPress core custom background feature.
		 */
		add_theme_support(
			'custom-background',
			apply_filters(
				'thinkwp_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		/**
		 * Add theme support for selective refresh for widgets.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
	/**
	 * Enqueue scripts and styles.
	 */
	public function thinkwp_scripts() {
		wp_enqueue_style( 'thinkwp-styles', get_template_directory_uri() . "/$this->scripts_dir/main.css", [], $this->scripts_version );
		wp_enqueue_script( 'thinkwp-scripts', get_template_directory_uri() . "/$this->scripts_dir/main.min.js", [ 'jquery' ], $this->scripts_version, true );

		wp_localize_script(
			'thinkwp-scripts',
			'thinkwp',
			array(
				'themeBase' => get_theme_file_uri(),
				'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
			)
		);

		wp_enqueue_script( 'alpinejs', 'https://unpkg.com/alpinejs@3.4.1/dist/cdn.min.js', [], '3.4.1', false );
		wp_enqueue_script( 'thinkwp-alpine', get_template_directory_uri() . '/js/alpine.js', [], $this->scripts_version, false );

		wp_enqueue_script( 'thinkwp-navigation', get_template_directory_uri() . '/js/navigation.js', [], $this->scripts_version, true );

		wp_enqueue_script( 'thinkwp-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', [], $this->scripts_version, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	public function thinkwp_content_width() {
		// This variable is intended to be overruled from themes.
		// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
		$GLOBALS['content_width'] = apply_filters( 'thinkwp_content_width', 640 );
	}
}