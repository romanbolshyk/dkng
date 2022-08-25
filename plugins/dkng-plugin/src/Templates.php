<?php

namespace Dkng\Wp;

class Templates {

    const CONTROLLER_V   = '1.0.1';
    const POST_TYPE_S_NM = 'Template';
    const POST_TYPE_P_NM = 'Templates';
    const POST_TYPE      = 'svn_tpl';

    protected $filters = array(
        'topic' => 0,
        'tpasst' => '',
    );
    protected $per_page  = 6;
    protected $cur_page  = 1;
    protected $topic_cat = 'tpl_topic';
    protected $asset_fld = array(
        'name' => 'asset_type',
        'key'  => 'field_60a3becb74e40',
    );

    /**
     * Actions on Init
     */
    public static function init_actions() {

        // register custom Post Types and Taxonomies
        self::register_cpt();

        // enqueve js/CSS resources
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueve_srcs' ] );

        // ajax actions
        add_action( 'wp_ajax_svnGetTemplates', [ __CLASS__, 'ajax_get_templates' ] );
    }

    /**
     * enqueve js/CSS resources
     */
    public static function enqueve_srcs() {

        if ( is_page_template( 'templates/dashboard-template.php' ) ) {
            wp_enqueue_script( 'page-tpl-scripts', SVN_PLUGIN_URL . '/assets/templates-scripts.js', array( 'jquery' ), self::CONTROLLER_V, true );
            wp_enqueue_style( 'template',   plugins_url( '../assets/template.css', __FILE__ ), 'all', date('m.d.H') );
        }
    }

    /**
     * Getter method realization
     * @param string $var
     * @return mixed
     */
    public function __get( $var ) {
        if ( isset( $this->$var ) )
            return $this->$var;
    }

    /**
     * Get Template topics list of terms
     * @return array
     */
    public function get_topics() {
        $args = array(
            'taxonomy'   => $this->topic_cat,
            'hide_empty' => true,
            'parent'     => 0,
            'orderby'    => 'name',
            'order'      => 'asc',
        );

        $terms = get_terms( $args );

        if ( !is_wp_error( $terms ) )
            return $terms;

        return false;
    }

    /**
     * Get Assets List
     * @return array
     */
    public function get_asset_types() {
        $fld_param = $this->asset_fld;

        $field = get_field_object( $fld_param[ 'key' ] );
        if ( isset( $field ) && !empty( $field[ 'choices' ] ) )
            return $field[ 'choices' ];

        return false;
    }

    /**
     * Prepare Query Args
     */
    protected function prepare_args() {

        $this->cur_page = !empty( $_POST[ 'page' ] ) ? intval( filter_input( INPUT_POST, 'page' ) ) : 1;

        if ( isset( $_POST[ 'topic' ] ) || isset( $_POST[ 'tpasst' ] ) ) {
            $this->filters = array(
                'topic'  => intval( filter_input( INPUT_POST, 'topic' ) ),
                'tpasst' => strval( filter_input( INPUT_POST, 'tpasst' ) ),
            );
        }
    }

    /**
     * Get Templates query
     * @return object WP_Query
     */
    public function get_post_query() {

        $this->prepare_args();

        $args = array(
            'post_type'      => self::POST_TYPE,
            'paged'          => $this->cur_page,
            'posts_per_page' => $this->per_page,
        );

        if ( !empty( $this->filters[ 'topic' ] ) ) {
            $args[ 'tax_query' ][] = array(
                'taxonomy' => $this->topic_cat,
                'field'    => 'term_taxonomy_id',
                'terms'    => $this->filters[ 'topic' ],
            );
        }

        if ( !empty( $this->filters[ 'tpasst' ] ) ) {
            $args[ 'meta_query' ][] = array(
                array(
                    'key'   => 'asset_type',
                    'value' => $this->filters[ 'tpasst' ],
                ),
            );
        }

        $q = new \WP_Query( $args );

        return $q;
    }

    /**
     * Get Load More button according to Wp Query
     * @param $q instance of Wp Query
     * @return text/HTML
     */
    public function get_loadmore_button( $q ) {
        ob_start();
        if ( $q->max_num_pages > $q->query_vars[ 'paged' ] ) {
            $page = $q->query_vars[ 'paged' ] + 1;
            ?>
            <a id="load_more_template" class="tplLoadMore" data-page="<?php echo $page; ?>">
                <?php echo __( 'Load More', 'dkng' ); ?>
            </a>
            <?php
        }
        return ob_get_clean();
    }

    /**
     * Ajax Get posts ( template Items )
     */
    public static function ajax_get_templates() {
        $out = array();
        $tpl = new self();
        $q   = $tpl->get_post_query();

        ob_start();
        if ( $q->have_posts() ) {
            while ( $q->have_posts() ) {
                $q->the_post();
                include( SVN_PLUGIN_TPLS . 'template-parts/cpt-templates/template-item.php' );
            }
        }
        $out[ 'html' ]   = ob_get_clean();
        $out[ 'button' ] = $tpl->get_loadmore_button( $q );

        wp_send_json( $out );
    }

    /**
     * Get Topic for single Template post
     * @return object WP_Term || boolean
     */
    public function get_the_topic() {
        $post_id = get_the_ID();
        $args    = array (
            'taxonomy'   => $this->topic_cat,
            'hide_empty' => true,
            'object_ids' => $post_id,
        );
        $terms = get_terms( $args );

        if ( !is_wp_error( $terms ) && is_array( $terms ) )
            return $terms[ 0 ];

        return false;
    }

    /**
     * Get Asset for single Template post
     * @return array || boolean
     */
    public function get_the_asset() {
        $post_id = get_the_ID();

        if ( empty( $asset_type = get_field( $this->asset_fld[ 'name' ], $post_id ) ) )
            return false;

        if ( empty( $asset = get_field( "asset_{$asset_type}", $post_id ) ) )
            return false;

        return array(
            'type' => $asset_type,
            'url'  => $asset[ 'url' ],
        );
    }

    /**
     * Function registration cpt Templates
     *
     */
    public static function register_cpt() {

        // Create post types from $post_types array
        $pnm      = __( self::POST_TYPE_S_NM, 'dkng' );
        $pnmp     = __( self::POST_TYPE_P_NM, 'dkng' );
        $cpt_slug = self::POST_TYPE;

        $args = array(
            'public'              => true,
            'supports'            => array( 'title', 'thumbnail', 'author' ),
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_rest'        => false,
            'has_archive'         => false,
            'exclude_from_search' => false,
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'rewrite'             => array( 'with_front' => false ),
            'query_var'           => true,
            'delete_with_user'    => false,
            'menu_position'       => 40,
            'menu_icon'           => 'dashicons-welcome-widgets-menus',
        );

        $args[ 'labels' ] = array(
            'name'          => $pnmp,
            'singular_name' => $pnm,
            'add_new'       => "Add New $pnm",
            'add_new_item'  => "Add New $pnm",
            'edit_item'     => "Edit $pnm",
            'new_item'      => "New $pnm",
            'all_items'     => "All $pnmp",
            'view_item'     => "View $pnmp",
            'search_items'  => "Search $pnmp",
            'not_found'     => 'Not found',
            'not_found_in_trash' => 'No found in Trash',
            'parent_item_colon'  => '',
            'menu_name'     => $pnmp
        );
        register_post_type( $cpt_slug, $args );

        // Taxonomies array
        $taxonomies = array(
            // Topic Category
            'tpl_topic' => array(
                'name_s'     => __( 'Topic', 'dkng' ),
                'name_p'     => __( 'Topics', 'dkng' ),
                'post_types' => array( $cpt_slug ),
                'params'     => array(
                    'rewrite' => array( 'with_front' => false, 'slug' => 'topic' ),
                ),
            ),
        );

        // Custom Taxonomies Default Params
        $taxonomy_defaults = array(
            'public'             => true,
            'hierarchical'       => true,
            'show_in_nav_menus'  => true,
            'query_var'          => true,
            'show_ui'            => true,
            'rewrite'            => array( 'with_front' => false ),
            'show_admin_column'  => true,
            'show_in_quick_edit' => true,
            'show_ui'            => true,
            'capabilities'       => array( 'manage_terms' ),
        );

        // Create Taxonomies from $taxonomies array
        foreach ( $taxonomies as $tax_slug => $tax ) {
            $tax_s = $tax[ 'name_s' ];
            $tax_p = $tax[ 'name_p' ];
            $tax[ 'params' ][ 'label' ] = $tax_s;
            $args = array_replace( $taxonomy_defaults, $tax[ 'params' ] );
            $args[ 'labels' ] = array(
                'name'          => "$tax_p",
                'singular_name' => "$tax_s",
                'search_items'  => "Search $tax_s",
                'popular_items' => "Popular $tax_s",
                'all_items'     => "All {$tax_s}s",
                'parent_item'   => "Parent $tax_s",
                'edit_item'     => "Edit $tax_s",
                'update_item'   => "Update $tax_s",
                'add_new_item'  => "Add New $tax_s",
                'new_item_name' => "New $tax_s",
                'separate_items_with_commas' => "Separate $tax_p with commas",
                'add_or_remove_items'        => "Add or remove $tax_p",
                'choose_from_most_used'      => "Choose from most used $tax_p"
            );

            register_taxonomy( $tax_slug, $tax[ 'post_types' ], $args );
        }
    }

}
