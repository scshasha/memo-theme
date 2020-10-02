<?php

if (! defined( 'ABSPATH' ) ) {
    exit('Silence is golden');
}


/**
 * -----------------------------------------------------------
 * COURSE SEARCH FILTER
 * -----------------------------------------------------------
 * // Shortcode: [memo_course_filter_search_form category="course" course_status="all" per_page="3" pagination="on"]
 */

if (! function_exists( 'memo_course_filter_search_shortcode' ) ) {
    function memo_course_filter_search_shortcode() {

        memo_course_filter_search_scripts();

        ob_start();
        ?>

<!-- <form class="form-inline">
  <i class="fas fa-search" aria-hidden="true"></i>
  <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search"
    aria-label="Search">
</form> -->

        <div id="memo-ajax-course-filter-search">
            <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" method="get" id="course-search-form">
                <i class="fa fa-search" aria-hidden="true"></i>
                <input id="search-input" name="search_terms" class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search"
                aria-label="Search">
            </form>
        </div>

        <?php
        return ob_get_clean();
    }
    add_shortcode( 'memo_course_filter_search_form', 'memo_course_filter_search_shortcode' );
}

if (! function_exists( 'memo_course_filter_search_scripts' ) ) {
    function memo_course_filter_search_scripts()
    {
        wp_enqueue_script( 'memo-ajax-course-filter-search', get_stylesheet_directory_uri() . '/assets/js/course-filter.js', array(), '1.0', true );
        wp_localize_script( 'memo-ajax-course-filter-search', 'ajax_url', admin_url( 'admin-ajax.php' ) );

    }
}


if (! function_exists( 'memo_course_filter_search_callback' ) ) {

    
    add_action( 'wp_ajax_memo_course_filter_search','memo_course_filter_search_callback' );
    add_action( 'wp_ajax_nopriv_memo_course_filter_search', 'memo_course_filter_search_callback' );

    function memo_course_filter_search_callback()
    {
        header( "Content-Type: application/json" );

        // $result = ['no posts found'];
        // echo json_encode( $result );
        // die;

        $wp_status_terms = get_terms(
            array(
                'taxonomy' => 'status',
                'hide_empty' => false,
            )
        );

        $wp_category_terms = get_terms(
            array(
                'taxonomy' => 'category',
                'hide_empty' => false,
            )
        );

        $meta_query = array('relation' => 'AND' );

        if ( isset( $_GET[ 's' ] ) ) {
            $terms = sanitize_text_field( $_GET[ 's' ] );

            // title | status | category


            $search_meta = ( $terms );

            foreach( $terms as $term ) {
                foreach( $search_meta as $meta_value) {
                    if ( strtolower( $meta_value ) === strtolower( $term->name ) ) {

                        // $meta_query[] = array(
                        //     'key' => 'course_status',
                        //     'value' => $term->term_id,
                        //     'compare' => '=',
                        // );

                    }
                }
            }

            $meta_query[] = array(
                // 'key' => 'post_content',
                // 'value' => $terms,
                // 'compare' => 'LIKE',
            );
            $tax_query = array();
    
            $tax_query[] = array(
            //     array(
            //         'taxonomy' => 'category',
            //         'field' => 'slug',
            //         'terms' => $search_meta,
            //         'operator'  => 'IN',
            //     ),
                array(
                    'taxonomy' => 'status',
                    'field' => 'slug',
                    'terms' => $search_meta,
                    'operator'  => 'IN',
                ),
            );

            if ( isset( $_GET ) && ( isset( $_GET[ 'paged' ] ) && ! empty( $_GET[ 'paged' ] ) ) ) {
                $paged = (int) esc_html( $_GET[ 'paged' ] );
            } else {
                $paged = 1;
            }
            set_query_var( 'paged', $paged );

            $args = array(
                'post_type' => 'course',
                'post_status' => 'publish',
                'no_found_rows' => false,
                'paged' => $paged,
                'posts_per_page' => 3,
                'meta_query' => $meta_query,
                'tax_query' => $tax_query,
            );

            
            $query = new WP_Query( $args );
            
            
            $result = [];
            if ( $query->have_posts() ) {
                // echo json_encode($query);
                // die;
                while ( $query->have_posts()  ) {

                    $query->the_post();

                    $cats - strip_tags( get_the_category_list(", ") );

                    $result[] = array(
                        "id" => get_the_ID(),
                        "title" => get_the_title(),
                        "content" => get_post_meta(get_the_ID(), 'course_content', TRUE),
                        "permalink" => get_permalink(),
                        "course_status" => get_post_meta(get_the_ID(), 'course_status', TRUE),
                        "month" => 'Nov',//substr( explode( ' ', date( 'F j, Y', strtotime( get_field('course_start_date') ) ) )[0] , 0, 3 ),
                        "course_start_date" => 'November 19, 2021', //substr( explode( ' ', date( 'F j, Y', strtotime( get_field('course_start_date') ) ) )[0] , 0, 3 ),
                        "featured_img" => wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'full' ),
                    );

                }
                wp_reset_query();
    
                echo json_encode( $result );
            }
            else {
                // $result = ['no posts found'];
                echo json_encode( $result );
            }
            wp_die();
        }
    }

    
}


/**
 * -----------------------------------------------------------
 * ENQUEUE STYLES
 * -----------------------------------------------------------
 */
add_action('wp_enqueue_scripts', 'memo_register_styles');
if (! function_exists( 'memo_register_styles' )) {
    function memo_register_styles()
    {
        wp_enqueue_style('memo-stylesheet', get_template_directory_uri() . '/style.css', array('memo-bootstrap', 'memo-layout', 'memo-font-awesome'), wp_get_theme()->get('Version'), 'all');
        wp_enqueue_style('memo-bootstrap', get_template_directory_uri() . '/assets/dist/css/bootstrap.min.css', array(), null, 'all');
        wp_enqueue_style('memo-layout', get_template_directory_uri() . '/assets/css/layout.css', array('memo-bootstrap'), "1.0", 'all');
        wp_enqueue_style('memo-font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css', array('memo-bootstrap', 'memo-layout'), "1.0", 'all');
    }
}

/**
 * -----------------------------------------------------------
 * ENQUEUE SCRIPTS
 * -----------------------------------------------------------
 */
add_action('wp_enqueue_scripts', 'memo_register_scripts');
if (! function_exists( 'memo_register_scripts' )) {
    function memo_register_scripts()
    {
        wp_enqueue_script('memo-jquery', get_template_directory_uri() . '/assets/js/jquery-2.1.1.min.js', array(), "2.1.1", true);
        wp_enqueue_script('memo-jquery-ui', get_template_directory_uri() . '/assets/js/jquery-ui.min.js', array('memo-jquery'), null, true);
        wp_enqueue_script('memo-popper', get_template_directory_uri() . '/assets/js/popper-1.16.0.min.js', array(
            'jquery', 'memo-jquery'
        ), "1.16.0", true);
        wp_enqueue_script('memo-bootstrap', get_template_directory_uri() . '/assets/dist/js/bootstrap.min.js', array(
            'jquery', 'memo-jquery'
        ), null, true);
        // wp_enqueue_script('memo-bootstrap-bundle', get_template_directory_uri() . '/assets/dist/js/bootstrap.bundle.min.js', array(
        //     'jquery', 'memo-jquery'
        // ), null, true);
        wp_enqueue_script('memo-layout', get_template_directory_uri() . '/assets/js/layout.js', array(
            'jquery', 'memo-jquery'
        ), null, true);
        wp_enqueue_script('memo-main', get_template_directory_uri() . '/assets/js/main.js', array(
            'jquery', 'memo-jquery'
        ), null, true);

    }
}


/**
 * -----------------------------------------------------------
 * REGISTER MENUS
 * -----------------------------------------------------------
 */

add_action('init', 'memo_menus');
if (! function_exists( 'memo_menus' )) {
    function memo_menus()
    {
        $locations = [
            'primary' => __("Primary Sidebar Menu", 'memo'),
            'profile' => __("Profile Sidebar Menu", 'memo'),
        ];
        register_nav_menus($locations);
    }
}

/**
 * -----------------------------------------------------------
 * REGISTER CUSTOM POST TYPES
 * -----------------------------------------------------------
 */
// add_action('init', 'memo_custom_post_type');
if (! function_exists( 'memo_custom_post_type' )) {
    function memo_custom_post_type()
    {
        $labels = [
            'name' => _x('Courses', 'Post Type General Name', 'memo'),
            'singular_name' => _x('Course', 'Post Type Singular Name', 'memo'),
            'menu_name' => _x('Courses', 'memo'),
            'parent_item_colon' => _x('Parent Course', 'memo'),
            'add_new_item' => _x('Add New Course', 'memo'),
            'add_new' => _x('Add New', 'memo'),
            'edit_item' => _x('Edit Course', 'memo'),
            'update_item' => _x('Update Course', 'memo'),
            'search_items' => _x('Search Courses', 'memo'),
            'not_found' => _x('Not Found', 'memo'),
            'not_found_in_trash' => _x('Not found in Trash', 'memo'),
        ]; // UI Labels

        $args = [
            'label' => _x('courses', 'memo'),
            'labels' => $labels,
            'description' => _x('Courses and updates', 'memo'),
            'supports' => [
                'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields',
            ],
            'rewrite' => ['slug' => 'courses'],
            'menu_icon' => 'dashicons-welcome-learn-more',
            'public' => true,
            'hierarchical' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicaly_queryable' => true,
            'capability_type' => 'page',
            'taxonomies' => [
                'category', 'topics'
            ],
        ];
        register_post_type('courses', $args);
    }
}


/**
 * -----------------------------------------------------------
 * ADD THEME SUPPORT
 * -----------------------------------------------------------
 */
add_action('after_setup_theme', 'memo_theme_support');
if (! function_exists( 'memo_theme_support' )) {
    function memo_theme_support()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('html5', [
            'comment-list', 'search-form', 'comment-form'
        ]);
        add_theme_support('title-tag');
        add_theme_support('custom-logo');
        add_theme_support('post-formats', [
            'aside', 'gallery', 'link', 'chat', 'quote', 'audio'
        ]);
    }
}


/**
 * -----------------------------------------------------------
 * SET EXCERPT FILTER
 * -----------------------------------------------------------
 */
add_filter('excerpt_length', 'memo_set_excerpt_length');
if (! function_exists( 'memo_set_excerpt_length' )) {
    function memo_set_excerpt_length()
    {
        return 20;
    }
}


/**
 * -----------------------------------------------------------
 * FILTER TO DISPLAY MULTIPLE POST TYPES ON CATEGORY PAGE
 * -----------------------------------------------------------
 * 
 * By default WordPress' category page only displays the "Posts"
 * post type. Therefore we need to tell it to include our custom 
 * post type(s).
 */
add_filter('pre_get_posts', 'memo_query_post_type');
if (! function_exists( 'memo_query_post_type' )) {
    function memo_query_post_type($query)
    {
        if (is_category()) {
            $post_type = get_query_var('post_type');
            if ($post_type) {
                $post_type = $post_type;
            } else {
                $post_type = ['nav_menu_item', 'post', 'courses'];
            }
            $query->set('post_type', $post_type);
        }
        return $query;
    }

}

/**
 * Gets unique ID.
 *
 * This is a PHP implementation of Underscore's uniqueId method. *
 *
 * @param string $prefix Prefix for the returned ID.
 * @return string Unique ID.
 */
function memo_unique_id( $prefix = '' ) {
	static $id_counter = 0;
	if ( function_exists( 'wp_unique_id' ) ) {
		return wp_unique_id( $prefix );
	}
	return $prefix . (string) ++$id_counter;
}
