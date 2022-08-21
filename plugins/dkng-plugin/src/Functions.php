<?php

namespace Dkng\Wp;

class Functions {


    /**
     * Actions on Init
     */
    public function init_actions() {

        self::register_campaigns();
        self::register_articles();
        self::register_news();
        self::register_announces();
        self::register_specialities();
        self::register_specialities_programs();
        self::register_courses();
        self::register_webinars();

        add_filter('template_include',  [ $this, 'template_chooser' ], 99 );

        add_filter( 'manage_recomendations_posts_columns',          [ $this, 'recomendations_table'] );
        add_action( 'manage_recomendations_posts_custom_column',    [ $this, 'recomendations_table_values' ], 10, 2 );

        add_action( 'wp_logout',       [ $this,  'log_out' ] );
        add_filter( 'upload_mimes',    [ $this,  'available_file_types'] , 50, 1 );
        add_filter( 'single_template', [ $this,  'get_custom_post_type_template' ], 99 );

        add_filter( 'body_class',      [ $this,  'body_class' ] );

    }

    /**
     * Function registration CPT Campaigns
     *
     */
    public function register_campaigns() {

        $campaigns_url_slug          = 'campaigns';
        $campaigns_category_url_slug = 'campaigns-category';

        $taxonomy_labels = array(
            'name'                       => 'Category',
            'singular_name'              => 'Category',
            'menu_name'                  => 'Categories',
            'all_items'                  => 'All Categories',
            'parent_item'                => 'Parent Category',
            'parent_item_colon'          => 'Parent Category:',
            'new_item_name'              => 'New Category Name',
            'add_new_item'               => 'Add New Category',
            'edit_item'                  => 'Edit Category',
            'update_item'                => 'Update Category',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $campaigns_category_url_slug,
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'campaigns-category', array( 'campaigns' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Campaigns',
            'singular_name'      => 'Campaign',
            'menu_name'          => 'Campaigns',
            'parent_item_colon'  => 'Parent Campaigns:',
            'all_items'          => 'All Campaigns',
            'view_item'          => 'View Campaign',
            'add_new_item'       => 'Add Campaign',
            'add_new'            => 'Add New',
            'edit_item'          => 'Edit Campaign',
            'update_item'        => 'Update Campaign',
            'search_items'       => 'Search Campaign',
            'not_found'          => 'No Campaigns found',
            'not_found_in_trash' => 'No Campaigns found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'campaigns',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'campaigns',
            'description'        => 'Campaigns information pages',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'author'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-buddicons-buddypress-logo',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $campaigns_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'campaigns', $post_type_args );

    }

    /**
     * Register CPT Articles
     *
     */
    public static function register_articles() {

        $articles_url_slug          = 'articles';
        $articles_category_url_slug = 'articles-category';

        $taxonomy_labels = array(
            'name'                       => 'Category',
            'singular_name'              => 'Category',
            'menu_name'                  => 'Categories',
            'all_items'                  => 'All Categories',
            'parent_item'                => 'Parent Category',
            'parent_item_colon'          => 'Parent Category:',
            'new_item_name'              => 'New Category Name',
            'add_new_item'               => 'Add New Category',
            'edit_item'                  => 'Edit Category',
            'update_item'                => 'Update Category',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $articles_category_url_slug,
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'articles-category', array( 'articles' ), $taxonomy_args );

        $articles_types_url_slug = 'articles-types';

        $taxonomy_labels = array(
            'name'                       => 'Original/Cloned Articles',
            'singular_name'              => 'Article Type',
            'menu_name'                  => 'Article Types',
            'all_items'                  => 'All Article Types',
            'parent_item'                => 'Parent Article Type',
            'parent_item_colon'          => 'Parent Article Type:',
            'new_item_name'              => 'New Article Type Name',
            'add_new_item'               => 'Add New Article Type',
            'edit_item'                  => 'Edit Article Type',
            'update_item'                => 'Update Article Type',
            'separate_items_with_commas' => 'Separate Article Types with commas',
            'search_items'               => 'Search Article Types',
            'add_or_remove_items'        => 'Add or remove Article Types',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $articles_types_url_slug,
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );

        register_taxonomy( 'articles-types', array( 'articles' ), $taxonomy_args );

        $taxonomy_labels = array(
            'name'                       => 'Tag',
            'singular_name'              => 'Tag',
            'menu_name'                  => 'Tags',
            'all_items'                  => 'All Tags',
            'parent_item'                => 'Parent Tag',
            'parent_item_colon'          => 'Parent Tag:',
            'new_item_name'              => 'New Tag Name',
            'add_new_item'               => 'Add New Tag',
            'edit_item'                  => 'Edit Tag',
            'update_item'                => 'Update Tag',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => 'articles-tag',
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'articles-tag', array( 'articles' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Articles',
            'singular_name'      => 'articles',
            'menu_name'          => 'Articles',
            'parent_item_colon'  => 'Parent Articles:',
            'all_items'          => 'All Articles',
            'view_item'          => 'View Article',
            'add_new_item'       => 'Add Article',
            'add_new'            => 'Add New',
            'edit_item'          => 'Edit Article',
            'update_item'        => 'Update Article',
            'search_items'       => 'Search Article',
            'not_found'          => 'No Articles found',
            'not_found_in_trash' => 'No Article found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'articles-item',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'articles',
            'description'        => 'Articles information pages',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'author'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-list-view',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $articles_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'articles', $post_type_args );
    }


    /**
     * Register CPT News
     *
     */
    public static function register_news() {

        $articles_url_slug          = 'news';
        $articles_category_url_slug = 'news-category';

        $taxonomy_labels = array(
            'name'                       => 'Category',
            'singular_name'              => 'Category',
            'menu_name'                  => 'Categories',
            'all_items'                  => 'All Categories',
            'parent_item'                => 'Parent Category',
            'parent_item_colon'          => 'Parent Category:',
            'new_item_name'              => 'New Category Name',
            'add_new_item'               => 'Add New Category',
            'edit_item'                  => 'Edit Category',
            'update_item'                => 'Update Category',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $articles_category_url_slug,
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'news-category', array( 'news' ), $taxonomy_args );

        $taxonomy_labels = array(
            'name'                       => 'Tag',
            'singular_name'              => 'Tag',
            'menu_name'                  => 'Tags',
            'all_items'                  => 'All Tags',
            'parent_item'                => 'Parent Tag',
            'parent_item_colon'          => 'Parent Tag:',
            'new_item_name'              => 'New Tag Name',
            'add_new_item'               => 'Add New Tag',
            'edit_item'                  => 'Edit Tag',
            'update_item'                => 'Update Tag',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => 'news-tag',
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'news-tag', array( 'news' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Новини',
            'singular_name'      => 'Новини',
            'menu_name'          => 'Новини',
            'parent_item_colon'  => 'Батьківські Новини:',
            'all_items'          => 'Всі Новини',
            'view_item'          => 'Переглянути Новину',
            'add_new_item'       => 'Додати Новину',
            'add_new'            => 'Додати Нову',
            'edit_item'          => 'Редагувати Новину',
            'update_item'        => 'Оновити Новину',
            'search_items'       => 'Шукати Новину',
            'not_found'          => 'Новин не знайдено',
            'not_found_in_trash' => 'No Новини found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'news-item',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'Новини',
            'description'        => 'Меню Новин',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'author'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-list-view',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $articles_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'news', $post_type_args );
    }

    /**
     * Register CPT Announces
     *
     */
    public static function register_announces() {

        $announces_url_slug          = 'announces';
        $announces_category_url_slug = 'announces-category';

        $taxonomy_labels = array(
            'name'                       => 'Category',
            'singular_name'              => 'Category',
            'menu_name'                  => 'Categories',
            'all_items'                  => 'All Categories',
            'parent_item'                => 'Parent Category',
            'parent_item_colon'          => 'Parent Category:',
            'new_item_name'              => 'New Category Name',
            'add_new_item'               => 'Add New Category',
            'edit_item'                  => 'Edit Category',
            'update_item'                => 'Update Category',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $announces_category_url_slug,
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'announces-category', array( 'announces' ), $taxonomy_args );

        $taxonomy_labels = array(
            'name'                       => 'Tag',
            'singular_name'              => 'Tag',
            'menu_name'                  => 'Tags',
            'all_items'                  => 'All Tags',
            'parent_item'                => 'Parent Tag',
            'parent_item_colon'          => 'Parent Tag:',
            'new_item_name'              => 'New Tag Name',
            'add_new_item'               => 'Add New Tag',
            'edit_item'                  => 'Edit Tag',
            'update_item'                => 'Update Tag',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => 'announces-tag',
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'announces-tag', array( 'announces' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Оголошення',
            'singular_name'      => 'Оголошення',
            'menu_name'          => 'Оголошення',
            'parent_item_colon'  => 'Parent Announces:',
            'all_items'          => 'Всі Оголошення',
            'view_item'          => 'Дивитись Оголошення',
            'add_new_item'       => 'Додати Оголошення',
            'add_new'            => 'Add New',
            'edit_item'          => 'Edit Оголошення',
            'update_item'        => 'Update Оголошення',
            'search_items'       => 'Search Оголошення',
            'not_found'          => 'No Announces found',
            'not_found_in_trash' => 'No Article found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'announces-item',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'Оголошення',
            'description'        => 'Announces information pages',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'author'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-list-view',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $announces_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'announces', $post_type_args );
    }

    /**
     * Register CPT Announces
     *
     */
    public static function register_specialities() {

        $announces_url_slug          = 'specialities';
        $announces_category_url_slug = 'specialities-category';

        $taxonomy_labels = array(
            'name'                       => 'Category',
            'singular_name'              => 'Category',
            'menu_name'                  => 'Categories',
            'all_items'                  => 'All Categories',
            'parent_item'                => 'Parent Category',
            'parent_item_colon'          => 'Parent Category:',
            'new_item_name'              => 'New Category Name',
            'add_new_item'               => 'Add New Category',
            'edit_item'                  => 'Edit Category',
            'update_item'                => 'Update Category',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $announces_category_url_slug,
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'specialities-category', array( 'specialities' ), $taxonomy_args );

        $taxonomy_labels = array(
            'name'                       => 'Tag',
            'singular_name'              => 'Tag',
            'menu_name'                  => 'Tags',
            'all_items'                  => 'All Tags',
            'parent_item'                => 'Parent Tag',
            'parent_item_colon'          => 'Parent Tag:',
            'new_item_name'              => 'New Tag Name',
            'add_new_item'               => 'Add New Tag',
            'edit_item'                  => 'Edit Tag',
            'update_item'                => 'Update Tag',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => 'specialities-tag',
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'specialities-tag', array( 'specialities' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Спеціальності',
            'singular_name'      => 'Спеціальність',
            'menu_name'          => 'Спеціальності',
            'parent_item_colon'  => 'Parent Спеціальності:',
            'all_items'          => 'Всі Спеціальності',
            'view_item'          => 'Дивитись Спеціальність',
            'add_new_item'       => 'Додати Спеціальність',
            'add_new'            => 'Додати нову Спеціальність',
            'edit_item'          => 'Редагувати Спеціальність',
            'update_item'        => 'Оновити Спеціальність',
            'search_items'       => 'Search Спеціальність',
            'not_found'          => 'Спеціальностей не знайдено',
            'not_found_in_trash' => 'No Article found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'specialities-item',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'Specialities',
            'description'        => 'Specialities information pages',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'author'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-list-view',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $announces_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'specialities', $post_type_args );
    }

    /**
     * Register CPT Announces
     *
     */
    public static function register_specialities_programs() {

        $announces_url_slug          = 'speciality_detail';
        $announces_category_url_slug = 'speciality_detail-category';

        $taxonomy_labels = array(
            'name'                       => 'Category',
            'singular_name'              => 'Category',
            'menu_name'                  => 'Categories',
            'all_items'                  => 'All Categories',
            'parent_item'                => 'Parent Category',
            'parent_item_colon'          => 'Parent Category:',
            'new_item_name'              => 'New Category Name',
            'add_new_item'               => 'Add New Category',
            'edit_item'                  => 'Edit Category',
            'update_item'                => 'Update Category',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $announces_category_url_slug,
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( $announces_category_url_slug, array( $announces_url_slug ), $taxonomy_args );

        $taxonomy_labels = array(
            'name'                       => 'Tag',
            'singular_name'              => 'Tag',
            'menu_name'                  => 'Tags',
            'all_items'                  => 'All Tags',
            'parent_item'                => 'Parent Tag',
            'parent_item_colon'          => 'Parent Tag:',
            'new_item_name'              => 'New Tag Name',
            'add_new_item'               => 'Add New Tag',
            'edit_item'                  => 'Edit Tag',
            'update_item'                => 'Update Tag',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => 'specialities-tag',
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'speciality_details-tag', array( $announces_url_slug ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Освітні Програми',
            'singular_name'      => 'Освітня Програма',
            'menu_name'          => 'Освітні Програми',
            'parent_item_colon'  => 'Parent Освітні Програми:',
            'all_items'          => 'Всі Освітні Програми',
            'view_item'          => 'Дивитись Освітню Програму',
            'add_new_item'       => 'Додати Освітню Програмуь',
            'add_new'            => 'Додати нову Освітню Програму',
            'edit_item'          => 'Редагувати Освітню Програму',
            'update_item'        => 'Оновити Освітню Програму',
            'search_items'       => 'Search Освітню Програму',
            'not_found'          => 'Освітні Програм не знайдено',
            'not_found_in_trash' => 'No Article found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'specialities-item',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'Speciality Programs',
            'description'        => 'Speciality Programs information pages',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'author'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-list-view',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $announces_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( $announces_url_slug, $post_type_args );
    }

    /**
     * Register CPT Edited Articles
     *
     */
    public static function register_edited_articles() {

        $edited_articles_url_slug          = 'edited_articles';
        $edited_articles_category_url_slug = 'edited_articles-category';

        $taxonomy_labels = array(
            'name'                       => 'Category',
            'singular_name'              => 'Category',
            'menu_name'                  => 'Categories',
            'all_items'                  => 'All Categories',
            'parent_item'                => 'Parent Category',
            'parent_item_colon'          => 'Parent Category:',
            'new_item_name'              => 'New Category Name',
            'add_new_item'               => 'Add New Category',
            'edit_item'                  => 'Edit Category',
            'update_item'                => 'Update Category',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $edited_articles_category_url_slug,
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'edited_articles-category', array( 'edited_articles' ), $taxonomy_args );

        $taxonomy_labels = array(
            'name'                       => 'Tag',
            'singular_name'              => 'Tag',
            'menu_name'                  => 'Tags',
            'all_items'                  => 'All Tags',
            'parent_item'                => 'Parent Tag',
            'parent_item_colon'          => 'Parent Tag:',
            'new_item_name'              => 'New Tag Name',
            'add_new_item'               => 'Add New Tag',
            'edit_item'                  => 'Edit Tag',
            'update_item'                => 'Update Tag',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => 'edited_articles-tag',
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'edited_articles-tag', array( 'edited_articles' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Edited Articles',
            'singular_name'      => 'Edited articles',
            'menu_name'          => 'Edited Articles',
            'parent_item_colon'  => 'Parent Edited Articles:',
            'all_items'          => 'All Edited Articles',
            'view_item'          => 'View Edited Article',
            'add_new_item'       => 'Add Edited Article',
            'add_new'            => 'Add New',
            'edit_item'          => 'Edit Edited Article',
            'update_item'        => 'Update Edited Article',
            'search_items'       => 'Search Edited Article',
            'not_found'          => 'No Edited Articles found',
            'not_found_in_trash' => 'No Edited Article found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'edited_articles-item',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'edited_articles',
            'description'        => 'edited_articles information pages',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-edit',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $edited_articles_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'edited_articles', $post_type_args );
    }

    /**
     * Function creating CPT Courses
     *
     */
    public function register_courses() {

        $courses_url_slug          = 'courses';
        $courses_category_url_slug = 'courses-category';

        $taxonomy_labels = array(
            'name'                       => 'Category',
            'singular_name'              => 'Category',
            'menu_name'                  => 'Categories',
            'all_items'                  => 'All Categories',
            'parent_item'                => 'Parent Category',
            'parent_item_colon'          => 'Parent Category:',
            'new_item_name'              => 'New Category Name',
            'add_new_item'               => 'Add New Category',
            'edit_item'                  => 'Edit Category',
            'update_item'                => 'Update Category',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $courses_category_url_slug,
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'courses-category', array( 'courses' ), $taxonomy_args );

        $taxonomy_labels = array(
            'name'                       => 'Tag',
            'singular_name'              => 'Tag',
            'menu_name'                  => 'Tags',
            'all_items'                  => 'All Tags',
            'parent_item'                => 'Parent Tag',
            'parent_item_colon'          => 'Parent Tag:',
            'new_item_name'              => 'New Tag Name',
            'add_new_item'               => 'Add New Tag',
            'edit_item'                  => 'Edit Tag',
            'update_item'                => 'Update Tag',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => 'courses-tag',
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'courses-tag', array( 'courses' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Courses',
            'singular_name'      => 'Courses',
            'menu_name'          => 'Courses',
            'parent_item_colon'  => 'Parent Courses:',
            'all_items'          => 'All Courses',
            'view_item'          => 'View Course',
            'add_new_item'       => 'Add New review',
            'add_new'            => 'Add New',
            'edit_item'          => 'Edit Course',
            'update_item'        => 'Update Course',
            'search_items'       => 'Search Course',
            'not_found'          => 'No courses found',
            'not_found_in_trash' => 'No courses found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'courses-item',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'Courses',
            'description'        => 'Courses information pages',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-portfolio',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $courses_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'courses', $post_type_args );

    }

    /**
     * Register CPT webinars
     *
     */
    public function register_webinars() {

        $webinars_url_slug          = 'webinars';
        $webinars_category_url_slug = 'webinars-category';

        $taxonomy_labels = array(
            'name'                       => 'Category',
            'singular_name'              => 'Category',
            'menu_name'                  => 'Categories',
            'all_items'                  => 'All Categories',
            'parent_item'                => 'Parent Category',
            'parent_item_colon'          => 'Parent Category:',
            'new_item_name'              => 'New Category Name',
            'add_new_item'               => 'Add New Category',
            'edit_item'                  => 'Edit Category',
            'update_item'                => 'Update Category',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $webinars_category_url_slug,
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'webinars-category', array( 'webinars' ), $taxonomy_args );

        $taxonomy_labels = array(
            'name'                       => 'Tag',
            'singular_name'              => 'Tag',
            'menu_name'                  => 'Tags',
            'all_items'                  => 'All Tags',
            'parent_item'                => 'Parent Tag',
            'parent_item_colon'          => 'Parent Tag:',
            'new_item_name'              => 'New Tag Name',
            'add_new_item'               => 'Add New Tag',
            'edit_item'                  => 'Edit Tag',
            'update_item'                => 'Update Tag',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => 'webinars-tag',
            'with_front'   => true,
            'hierarchical' => true,
        );

        $taxonomy_args = array(
            'labels'            => $taxonomy_labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var'         => true,
            'show_tagcloud'     => true,
            'rewrite'           => $taxonomy_rewrite,
        );
        register_taxonomy( 'webinars-tag', array( 'webinars' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Webinars',
            'singular_name'      => 'Webinars',
            'menu_name'          => 'Webinars',
            'parent_item_colon'  => 'Parent Webinars:',
            'all_items'          => 'All Webinars',
            'view_item'          => 'View Webinar',
            'add_new_item'       => 'Add New Webinar',
            'add_new'            => 'Add New',
            'edit_item'          => 'Edit Webinar',
            'update_item'        => 'Update Webinar',
            'search_items'       => 'Search Webinar',
            'not_found'          => 'No Webinars found',
            'not_found_in_trash' => 'No Webinars found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'webinars-item',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'Webinars',
            'description'        => 'Webinars information pages',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-buddicons-buddypress-logo',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $webinars_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'webinars', $post_type_args );
    }


    /**
     * Replace page templates for single posts from plugin
     *
     * @param $single_template
     * @return string
     */
    public function get_custom_post_type_template( $single_template ) {
        global $post;

        if ( $post->post_type == 'post' ) {
            $single_template = dirname( __FILE__ ) . '/templates/single.php';
        }
        else if ( $post->post_type == 'articles' ) {
            $single_template = dirname( __FILE__ ) . '/templates/single-articles.php';
        }
        else if ( $post->post_type == 'svn_tpl' ) {
            $single_template = dirname( __FILE__ ) . '/templates/single-svn_tpl.php';
        }
        else if ( $post->post_type == 'courses' ) {
            $single_template = dirname( __FILE__ ) . '/templates/single-courses.php';
        }
        else if ( $post->post_type == 'edited_articles' ) {
            $single_template = dirname( __FILE__ ) . '/templates/single-edited_articles.php';
        }
        else if ( ( $post->post_type == 'campaigns' ) || ( $post->post_type == 'cloned_campaigns' )  ) {
            $single_template = dirname( __FILE__ ) . '/templates/single-campaigns.php';
        }

        return $single_template;
    }

    /**
     * Changing mime types for wordpress
     *
     * @param $mime_types
     * @return array
     */
    public function available_file_types( $mime_types ) {
        $mimes_to_exclude = array(
            "gif" => "image/gif",
            "bmp" => "image/bmp",
            "tiff|tif" => "image/tiff",
            "heic" => "image/heic",
            "asf|asx" => "video/x-ms-asf",
            "wmv" => "video/x-ms-wmv",
            "wmx" => "video/x-ms-wmx",
            "wm" => "video/x-ms-wm",
            "divx" => "video/divx",
            "flv" => "video/x-flv",
            "mov|qt" => "video/quicktime",
            "ogv" => "video/ogg",
            "webm" => "video/webm",
            "mkv" => "video/x-matroska",
            "3gp|3gpp" => "video/3gpp",
            "3g2|3gp2" => "video/3gpp2",
            "tsv" => "text/tab-separated-values",
            "ics" => "text/calendar",
            "rtx" => "text/richtext",
            "css" => "text/css",
            "htm|html" => "text/html",
            "vtt" => "text/vtt",
            "dfxp" => "application/ttaf+xml",
            "ra|ram" => "audio/x-realaudio",
            "wav" => "audio/wav",
            "ogg|oga" => "audio/ogg",
            "flac" => "audio/flac",
            "mid|midi" => "audio/midi",
            "wma" => "audio/x-ms-wma",
            "wax" => "audio/x-ms-wax",
            "mka" => "audio/x-matroska",
            "rtf" => "application/rtf",
            "js" => "application/javascript",
            "class" => "application/java",
            "tar" => "application/x-tar",
            "zip" => "application/zip",
            "gz|gzip" => "application/x-gzip",
            "rar" => "application/rar",
            "7z" => "application/x-7z-compressed",
            "psd" => "application/octet-stream",
            "xcf" => "application/octet-stream",
            "wri" => "application/vnd.ms-write",
            "mdb" => "application/vnd.ms-access",
            "mpp" => "application/vnd.ms-project",
            "dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template",
            "dotm" => "application/vnd.ms-word.template.macroEnabled.12",
            "xlsm" => "application/vnd.ms-excel.sheet.macroEnabled.12",
            "xlsb" => "application/vnd.ms-excel.sheet.binary.macroEnabled.12",
            "xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
            "xltm" => "application/vnd.ms-excel.template.macroEnabled.12",
            "xlam" => "application/vnd.ms-excel.addin.macroEnabled.12",
            "sldx" => "application/vnd.openxmlformats-officedocument.presentationml.slide",
            "sldm" => "application/vnd.ms-powerpoint.slide.macroEnabled.12",
            "onetoc|onetoc2|onetmp|onepkg" => "application/onenote",
            "oxps" => "application/oxps",
            "xps" => "application/vnd.ms-xpsdocument",
            "ods" => "application/vnd.oasis.opendocument.spreadsheet",
            "odg" => "application/vnd.oasis.opendocument.graphics",
            "odc" => "application/vnd.oasis.opendocument.chart",
            "odb" => "application/vnd.oasis.opendocument.database",
            "odf" => "application/vnd.oasis.opendocument.formula",
            "wp|wpd" => "application/wordperfect",
            "key" => "application/vnd.apple.keynote",
            "numbers" => "application/vnd.apple.numbers",
            "pages" => "application/vnd.apple.pages"
        );
        $mime_types_out = array_diff( $mime_types, $mimes_to_exclude );
        $mime_types_out['svg']  = 'image/svg+xml';
        $mime_types_out['png']  = 'image/png';

        return $mime_types_out;
    }

    /**
     * Function logout of user
     *
     */
    public function log_out() {
        wp_redirect( get_site_url() );
        exit();
    }


    /**
     * Add new columns for cpt recomendations in admin panel
     *
     * @param $column
     * @return mixed
     */
    public function recomendations_table( $column ) {

        $column['phase']   = 'Phase of recomendation';

        return $column;
    }


    /**
     * Function setting values in admin panel for articles cpt
     *
     * @param $column
     */
    public function recomendations_table_values ( $column ) {

        global $post;

        $type_article = get_field( 'thing_to_do_phase', $post->ID );

        if ( $column  == 'phase' ) {
            echo ucfirst( $type_article );
        }
    }



    /**
     * Function for body class
     *
     * @param $classes
     * @return array
     */
    public function body_class( $classes ) {

        global $post;
        $current_url = $_SERVER['REQUEST_URI'];
        $body_class  = ( ( strpos( $current_url, 'login' ) ) || ( strpos( $current_url, 'contact' ) )  ) ? "profile-page" : '';

        if ( $post->post_type == 'page' ) {
            $body_class .= ' page-' . $post->post_name;
        }

        $classes[] = $body_class;
        if ( is_single() && 'articles' == get_post_type() && !is_user_logged_in() ) {
            $classes[] = ' not-logged-in-articles';

        }

        return $classes;
    }


    /**
     * Function substring string by parameters
     *
     * @param $phrase
     * @param $max_words
     * @return string
     */
    public static function trunc_text_by_words( $phrase, $max_words ) {
        $phrase_array = explode(' ',$phrase);
        if ( count( $phrase_array ) > $max_words && $max_words > 0 )
            $phrase = implode( ' ', array_slice( $phrase_array, 0, $max_words ) ) . '...';
        return $phrase;
    }

    /**
     * Function template choosing
     *
     * @param $template
     * @return mixed|string
     */
    public  function template_chooser( $template ) {
        global $wp_query;
        $post_type = get_query_var('post_type');

        if ( isset($_GET['s'] ) ) {
            $path = plugin_dir_path(__FILE__)  . 'templates/search.php';
            return $path;
        }

        return $template;
    }

}
