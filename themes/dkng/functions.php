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
//    wp_enqueue_style( 'owl-theme-default', get_template_directory_uri() . '/plugins/OwlCarousel2-2.2.1/owl.theme.default.css' );
//    wp_enqueue_style( 'bootstrap-slider',  get_template_directory_uri() . '/plugins/bootstrap-slider/bootstrap-slider.min.css' );
    //TODO Check after front
    if ( isset( $_GET['s'])  || strpos( $_SERVER['REQUEST_URI'], 'admin' ) || strpos( $_SERVER['REQUEST_URI'], 'contact-list' ) || is_singular( array( 'articles', 'edited_articles', 'courses', 'campaigns' ) ) && !is_page() ) {
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
//    wp_enqueue_script( 'easing',           get_template_directory_uri() . '/plugins/easing/easing.js', array( 'jquery' ), '', true );
//    wp_enqueue_script( 'bootstrap-slider', get_template_directory_uri() . '/plugins/bootstrap-slider/bootstrap-slider.min.js', array( 'jquery' ), '', true );
//    
    //services
    if (is_page_template('templates/services.php')) {
        wp_enqueue_style( 'owl-carousel',      get_template_directory_uri() . '/plugins/OwlCarousel2-2.2.1/owl.carousel.css' );
        wp_enqueue_script( 'owl-carousel-js',  get_template_directory_uri() . '/plugins/OwlCarousel2-2.2.1/owl.carousel.js', array( 'jquery' ), '', true );
        wp_enqueue_style( 'animate',           get_template_directory_uri() . '/plugins/OwlCarousel2-2.2.1/animate.css' );
    }

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

        if ( strtolower($item->title) == 'about us' ) {
            $block_class = 'a_about_block';
        }
        else if ( strtolower($item->title) == 'contact us' ) {
            $block_class = 'a_contact_block';
        }
        else if ( strpos( $item->url ,'platform') !== false ) {
            $block_class = 'a_the_platform_block';
        }
        else {
            $block_class = 'a_'.strtolower($item->title).'_block ';
        }

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

        if ( strtolower($item->title) == 'about us' ) {
            $block_class = 'a_about_block';
        }
        else if ( strtolower($item->title) == 'contact us' ) {
            $block_class = 'a_contact_block';
        }
        else {
            $block_class = 'a_'.strtolower($item->title).'_block ';
        }

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
 * Function checking if timezone is valid
 *
 * @param $timezoneId
 * @return bool
 */
function isValidTimezoneId( $timezoneId ) {
    try{
        new \DateTimeZone( $timezoneId );
    }catch(Exception $e){
        return FALSE;
    }
    return TRUE;
}

//Filter for custom password reset result page
add_filter( 'lostpassword_redirect', 'change_lostpassword_redirect_url' );
function change_lostpassword_redirect_url( $lostpassword_redirect ){
	$lostpassword_redirect = home_url( '/check-email' );

	return $lostpassword_redirect;
}
