<?php

add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );
function my_enqueue_scripts() {

    wp_localize_script( 'jquery', 'get',
        array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'siteurl' => get_template_directory_uri(),
        )
    );

    wp_enqueue_style( 'bootstrap',         get_template_directory_uri() . '/styles/bootstrap4/bootstrap.min.css' );
    wp_enqueue_style( 'main_styles',       get_template_directory_uri() . '/styles/main_styles.css' );
    wp_enqueue_style( 'font-awesome',      get_template_directory_uri() . '/plugins/font-awesome-4.7.0/css/font-awesome.min.css' );
    wp_enqueue_style('font-awesome-font', get_template_directory_uri() . '/plugins/font-awesome-4.7.0/fonts/fontawesome-webfont.woff2', array(), null);

    if ( ( isset( $_GET['s'])  || strpos( $_SERVER['REQUEST_URI'], 'admin' ) || strpos( $_SERVER['REQUEST_URI'], 'contact-list' ) || is_singular( array( 'articles', 'edited_articles', 'courses', 'campaigns' ) ) && !is_page() ) || is_front_page() ) {
        wp_enqueue_style( 'dashboard1',    get_template_directory_uri() . '/styles/dashboard.css' );
    }
    wp_enqueue_style( 'responsive',        get_template_directory_uri() . '/styles/responsive.css' );
    wp_enqueue_style( 'home',              get_template_directory_uri() . '/styles/home.css' );

    if ( strpos( $_SERVER['REQUEST_URI'], 'blog' ) ||  is_single() ) {
        wp_enqueue_style('blog',          get_template_directory_uri() . '/styles/blog.css');
    }

    wp_enqueue_style( 'main_styles',       get_template_directory_uri() . '/styles/main_styles.css' );

    wp_enqueue_script( 'styles',           get_template_directory_uri() . '/styles/bootstrap4/popper.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'bootstrap1',       get_template_directory_uri() . '/styles/bootstrap4/bootstrap.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'jscustom',         get_template_directory_uri() . '/js/jscustom.js', array( 'jquery' ), '', true );

}

add_filter('style_loader_tag', 'my_style_loader_tag_filter', 10, 2);

function my_style_loader_tag_filter($html, $handle) {
    if ($handle === 'font-awesome-font') {
        return str_replace("rel='stylesheet'","rel='preload' as='font' type='font/woff2'", $html);
    }
    return $html;
}

add_theme_support('menus');
add_action( 'after_setup_theme', 'theme_register_nav_menu' );
function theme_register_nav_menu() {
    register_nav_menu( 'primary',         'Головне Меню Хедера' );
    register_nav_menu( 'dkng_group',      'DKNG group Menu' );
    register_nav_menu( 'advisors_group',  'Advisors Menu' );
    register_nav_menu( 'resources_group', 'Resources Menu' );

    register_nav_menu( 'footer_top_sign_group',      'Footer Меню1 Top Menu' );
    register_nav_menu( 'footer_bottom_sign_group',   'Footer Меню2 Bottom Menu' );
    register_nav_menu( 'footer_copyright_sign_group','Footer Меню3 Copyright Menu' );
}

class My_Walker_Nav_Menu extends Walker_Nav_Menu {

    /**
     * Starts the element output.
     *
     * @since 3.0.0
     * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
     *
     * @see Walker::start_el()
     *
     * @param string   $output Passed by reference. Used to append additional content.
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent    = ( $depth ) ? str_repeat( $t, $depth ) : '';

        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title  = apply_filters( 'the_title', $item->title, $item->ID );
        $title  = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
        $title1 = str_replace( ' ', '_', $title );


        if ( strpos( $item->url ,'-dashboard') !== false ){
            $block_class = 'dashboard_block';
        }

        $class = ( strtolower($item->title) == 'schedule a demo') ? 'btn btn-primary login ' : '';


        $item_output = $args->before;
        $item_output .= '<a'. $attributes .' class="' . $block_class . ' ' . $class . '">';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}

class My_Walker_Mobile_Menu extends Walker_Nav_Menu {

    /**
     * Starts the element output.
     *
     * @since 3.0.0
     * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
     *
     * @see Walker::start_el()
     *
     * @param string   $output Passed by reference. Used to append additional content.
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent    = ( $depth ) ? str_repeat( $t, $depth ) : '';

        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

        $output .= $indent . '<li class="menu_item">';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output = $args->before;
        $item_output .= '<a'. $attributes . ' >';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}

class My_Walker_Mobile_Header_Menu extends Walker_Nav_Menu {

    /**
     * Starts the element output.
     *
     * @since 3.0.0
     * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
     *
     * @see Walker::start_el()
     *
     * @param string   $output Passed by reference. Used to append additional content.
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent    = ( $depth ) ? str_repeat( $t, $depth ) : '';

        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

        $output .= $indent . '<li class="menu_item">';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );


        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        if ( strpos( $item->url ,'-dashboard') !== false ){
            $block_class = 'dashboard_block';
        }

        $class = ( strtolower($item->title) == 'login') ? ' login ' : '';


        $item_output = $args->before;
        $item_output .= '<a'. $attributes .' class="' . $block_class . ' ' . $class . '">';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}



/**
 * Get share URL
 */
if (!function_exists('get_share_url')) {
    function get_share_url($network, $args) {
        switch ($network) {
            case 'facebook':
                return 'http://www.facebook.com/sharer.php?u=' . $args['url'];
                break;
            case 'twitter':
                return 'https://twitter.com/intent/tweet?url=' . $args['url'] . '&text=' . urlencode($args['title']);
                break;
            case 'googleplus':
                return 'https://plus.google.com/share?url=' . $args['url'] . '&text=' . urlencode($args['title']);
                break;
            case 'pinterest':
                return 'http://pinterest.com/pin/create/button/?url=' . $args['url'] . '&media=' . $args['image'] . '&description=' . urlencode($args['title']);
                break;
            case 'tumblr':
                return 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . $args['url'] . '&title=' . urlencode($args['title']);
                break;
            case 'skype':
                return 'https://web.skype.com/share?url=' . $args['url'] . '&text=' . urlencode($args['title']);
                break;
            case 'linkedin':
                return 'https://www.linkedin.com/shareArticle?mini=true&url=' . $args['url'] . '&title=' . urlencode($args['title']);
                break;
            case 'mail':
                return 'https://mail.google.com/mail/?view=cm&to=' . '' . '&su=' . urlencode($args['title']) . '&body=' . $args['url'];
                break;
            default:
                return false;
        }
    }
}

function get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
    return $attachment[0];
}

/**
 *  Add favicon to the admin panel
 */
function sv_add_favicon() {
    if ( has_site_icon() ) {
        printf( '<link rel="icon" type="image/png" href="%s">', get_site_icon_url( 16 ) );
    } else {
        printf( '<link rel="icon" type="image/x-icon"  href="%s">', get_template_directory_uri() . '/favicon.ico' );
    }
}

add_action( 'login_head', 'sv_add_favicon' );
add_action( 'admin_head', 'sv_add_favicon' );



/**
 * WordPress Breadcrumbs
 */
function custom_breadcrumbs() {

    $separator              = '/';
    $breadcrumbs_id         = 'tsh_breadcrumbs';
    $breadcrumbs_class      = 'tsh_breadcrumbs';
    $home_title             = "Головна";

    // Add here you custom post taxonomies
    $tsh_custom_taxonomy    = 'product_cat';

    global $post,$wp_query;

    // Hide from front page
    if ( !is_front_page() ) {

        echo '<ul id="' . $breadcrumbs_id . '" class="' . $breadcrumbs_class . '">';

        // Home
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title('', false) . '</strong></li>';

        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

            // For Custom post type
            $post_type = get_post_type();

            // Custom post type name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';

            }

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';

        } else if ( is_single() ) {

            $post_type = get_post_type();
            $href = '';

            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                if ( $post_type == 'novyny' ) {
                    $href = get_site_url() . '/novyny';
                } if ( $post_type == 'ogoloshennya' ) {
                    $href = get_site_url() . '/ogoloshennya';
                }

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '">
                    <a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $href . '" title="' . $post_type_object->labels->name . '">
                    ' . $post_type_object->labels->name .
                    '</a></li>';

            }

            // Get post category
            $category = get_the_category();

            if(!empty($category)) {

                // Last category post is in
                $last_category = $category[count($category) - 1];

                // Parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                }

            }

            $taxonomy_exists = taxonomy_exists($tsh_custom_taxonomy);
            if(empty($last_category) && !empty($tsh_custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms( $post->ID, $tsh_custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $tsh_custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;

            }

            // If the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

                // Post is in a custom taxonomy
            } else if(!empty($cat_id)) {

                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            } else {

                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            }

        } else if ( is_category() ) {

            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){

                // Get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents order
                $anc = array_reverse($anc);

                // Parent pages
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                }

                // Render parent pages
                echo $parents;

                // Active page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';

            } else {

                // Just display active page if not parents pages
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';

            }

        } else if ( is_tag() ) { // Tag page

            // Tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Return tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';

        } else if ( get_query_var('paged') ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }

        echo '</ul>';
    }
}