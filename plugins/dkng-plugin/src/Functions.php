<?php

namespace Dkng\Wp;

class Functions {


    /**
     * Actions on Init
     */
    public function init_actions() {

        self::register_novyny();
        self::register_ogoloshennya();
        self::register_galereya();
        self::register_specialities();
        self::register_pracivnyky();
        self::register_specialities_programs();
        self::register_cemiykoldzh_vidgгky();

        add_filter('template_include', [ $this, 'template_chooser' ], 99 );

        add_action( 'wp_logout',       [ $this,  'log_out' ] );
        add_filter( 'upload_mimes',    [ $this,  'available_file_types'] , 50, 1 );
        add_filter( 'single_template', [ $this,  'get_custom_post_type_template' ], 99 );

        add_filter( 'body_class',      [ $this,  'body_class' ] );

    }



    /**
     * Register CPT Novyny
     *
     */
    public static function register_novyny() {

        $articles_url_slug          = 'novyny';
        $articles_category_url_slug = 'novyny-category';

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
        register_taxonomy( 'novyny-category', array( 'novyny' ), $taxonomy_args );

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
            'slug'         => 'novyny-tag',
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
        register_taxonomy( 'novyny-tag', array( 'novyny' ), $taxonomy_args );

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
            'slug'       => 'novyny-item',
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
            'hierarchical'       => true,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-format-aside',
            'menu_position'      =>  31,
            'has_archive'        => false,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => 'novyna' ),
            'capability_type'    => 'post',
        );

        register_post_type( 'novyny', $post_type_args );
    }


    /**
     * Register CPT CEMIJKoledzh Vidguky
     *
     */
    public static function register_cemiykoldzh_vidgгky() {

        $articles_url_slug          = 'cemijkoledzh';
        $articles_category_url_slug = 'cemijkoledzh-category';

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
        register_taxonomy( 'cemijkoledzh-category', array( 'cemijkoledzh' ), $taxonomy_args );

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
            'slug'         => 'cemijkoledzh-tag',
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
        register_taxonomy( 'cemijkoledzh-tag', array( 'cemijkoledzh' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'ЦеМійКоледж Відгуки',
            'singular_name'      => 'ЦеМійКоледж Відгуки',
            'menu_name'          => 'ЦеМійКоледж Відгуки',
            'parent_item_colon'  => 'Батьківські ЦеМійКоледж Відгуки:',
            'all_items'          => 'Всі ЦеМійКоледж Відгуки',
            'view_item'          => 'Переглянути ЦеМійКоледж Відгук',
            'add_new_item'       => 'Додати ЦеМійКоледж Відгук',
            'add_new'            => 'Додати Новий',
            'edit_item'          => 'Редагувати ЦеМійКоледж Відгук',
            'update_item'        => 'Оновити ЦеМійКоледж Відгук',
            'search_items'       => 'Шукати ЦеМійКоледж Відгук',
            'not_found'          => 'Новин не знайдено',
            'not_found_in_trash' => 'No ЦеМійКоледж Відгуків found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'cemijkoledzh-item',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'ЦеМійКоледж Відгуки',
            'description'        => 'Меню Відгуків',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'author'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-format-chat',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $articles_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'cemijkoledzh', $post_type_args );
    }

    /**
     * Register CPT ogoloshennya
     *
     */
    public static function register_ogoloshennya() {

        $ogoloshennya_url_slug          = 'ogoloshennya';
        $ogoloshennya_category_url_slug = 'ogoloshennya-category';

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
            'slug'         => $ogoloshennya_category_url_slug,
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
        register_taxonomy( 'ogoloshennya-category', array( 'ogoloshennya' ), $taxonomy_args );

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
            'slug'         => 'ogoloshennya-tag',
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
        register_taxonomy( 'ogoloshennya-tag', array( 'ogoloshennya' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Оголошення',
            'singular_name'      => 'Оголошення',
            'menu_name'          => 'Оголошення',
            'parent_item_colon'  => 'Parent ogoloshennya:',
            'all_items'          => 'Всі Оголошення',
            'view_item'          => 'Дивитись Оголошення',
            'add_new_item'       => 'Додати Оголошення',
            'add_new'            => 'Add New',
            'edit_item'          => 'Edit Оголошення',
            'update_item'        => 'Update Оголошення',
            'search_items'       => 'Search Оголошення',
            'not_found'          => 'No ogoloshennya found',
            'not_found_in_trash' => 'No Article found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'ogoloshennya-item',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'Оголошення',
            'description'        => 'ogoloshennya information pages',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'author'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-portfolio',
            'menu_position'      =>  31,
            'has_archive'        => false,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => 'ogoloshennia' ),
            'capability_type'    => 'post',
        );

        register_post_type( 'ogoloshennya', $post_type_args );
    }


    /**
     * Register CPT ogoloshennya
     *
     */
    public static function register_galereya() {

        $galereya_url_slug           = 'galereya';
        $galereya_category_url_slug  = 'galereya-category';
        $galereya_category1_url_slug = 'foto-category';

        $taxonomy_labels = array(
            'name'                       => 'Тип Галереї',
            'singular_name'              => 'Тип Галереї',
            'menu_name'                  => 'Типи Галереї',
            'all_items'                  => 'Всі Тип Галереї',
            'parent_item'                => 'Parent Category',
            'parent_item_colon'          => 'Parent Category:',
            'new_item_name'              => 'New Category Name',
            'add_new_item'               => 'Додати новий тип Галереї',
            'edit_item'                  => 'Edit Category',
            'update_item'                => 'Update Category',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $galereya_category_url_slug,
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
        register_taxonomy( $galereya_category_url_slug, array( 'galereya' ), $taxonomy_args );

        $taxonomy_labels = array(
            'name'                       => 'Категорія Фото',
            'singular_name'              => 'Категорія Фото',
            'menu_name'                  => 'Категорії Фото',
            'all_items'                  => 'Всі Категорії Фото',
            'parent_item'                => 'Parent Category',
            'parent_item_colon'          => 'Parent Category:',
            'new_item_name'              => 'New Category Name',
            'add_new_item'               => 'Додати новий тип Галереї',
            'edit_item'                  => 'Edit Category',
            'update_item'                => 'Update Category',
            'separate_items_with_commas' => 'Separate categories with commas',
            'search_items'               => 'Search categories',
            'add_or_remove_items'        => 'Add or remove categories',
            'choose_from_most_used'      => 'Choose from the most used categories',
        );

        $taxonomy_rewrite = array(
            'slug'         => $galereya_category_url_slug,
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

        register_taxonomy( $galereya_category1_url_slug, array( 'galereya' ), $taxonomy_args );

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
            'slug'         => 'galereya-tag',
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
        register_taxonomy( 'galereya-tag', array( 'galereya' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Галерея',
            'singular_name'      => 'Галерея',
            'menu_name'          => 'Галерея',
            'parent_item_colon'  => 'Parent Галерея:',
            'all_items'          => 'Вся Галерея',
            'view_item'          => 'Дивитись Галерея',
            'add_new_item'       => 'Додати Галерея',
            'add_new'            => 'Додати Галерею',
            'edit_item'          => 'Edit Галерея',
            'update_item'        => 'Update Галерея',
            'search_items'       => 'Search Галерея',
            'not_found'          => 'No Галерея found',
            'not_found_in_trash' => 'No Галерея found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'galereya-item',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'Оголошення',
            'description'        => 'ogoloshennya information pages',
            'labels'             => $post_type_labels,
            'supports'           => array( 'title',  'excerpt', 'thumbnail',  'revisions', 'author'),
            'taxonomies'         => array( 'post' ),
            'hierarchical'       => false,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-format-gallery',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $galereya_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'galereya', $post_type_args );
    }


    /**
     * Register CPT ogoloshennya
     *
     */
    public static function register_specialities() {

        $ogoloshennya_url_slug          = 'specialities';
        $ogoloshennya_category_url_slug = 'specialities-category';

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
            'slug'         => $ogoloshennya_category_url_slug,
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
            'menu_icon'          => 'dashicons-welcome-write-blog',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $ogoloshennya_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'specialities', $post_type_args );
    }

    /**
     * Register CPT ogoloshennya
     *
     */
    public static function register_pracivnyky() {

        $ogoloshennya_url_slug          = 'pracivnyky';
        $ogoloshennya_category_url_slug = 'pracivnyky-category';

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
            'slug'         => $ogoloshennya_category_url_slug,
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
        register_taxonomy( 'pracivnyky-category', array( 'pracivnyky' ), $taxonomy_args );

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
            'slug'         => 'pracivnyky-tag',
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
        register_taxonomy( 'pracivnyky-tag', array( 'pracivnyky' ), $taxonomy_args );

        $post_type_labels = array(
            'name'               => 'Працівники',
            'singular_name'      => 'Працівник',
            'menu_name'          => 'Працівники',
            'parent_item_colon'  => 'Parent Працівники:',
            'all_items'          => 'Всі Працівники',
            'view_item'          => 'Дивитись Працівника',
            'add_new_item'       => 'Додати Працівника',
            'add_new'            => 'Додати нового Працівника',
            'edit_item'          => 'Редагувати Працівника',
            'update_item'        => 'Оновити Працівника',
            'search_items'       => 'Search Працівника',
            'not_found'          => 'Працівників не знайдено',
            'not_found_in_trash' => 'No Працівники found in Trash',
        );

        $post_type_rewrite = array(
            'slug'       => 'pracivnyky-item',
            'with_front' => true,
            'pages'      => true,
            'feeds'      => true,
        );

        $post_type_args = array(
            'label'              => 'pracivnyky',
            'description'        => 'pracivnyky information pages',
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
            'rewrite'            => array( 'slug' => $ogoloshennya_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( 'pracivnyky', $post_type_args );
    }

    /**
     * Register CPT ogoloshennya
     *
     */
    public static function register_specialities_programs() {

        $ogoloshennya_url_slug          = 'speciality_detail';
        $ogoloshennya_category_url_slug = 'speciality_detail-category';

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
            'slug'         => $ogoloshennya_category_url_slug,
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
        register_taxonomy( $ogoloshennya_category_url_slug, array( $ogoloshennya_url_slug ), $taxonomy_args );

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
        register_taxonomy( 'speciality_details-tag', array( $ogoloshennya_url_slug ), $taxonomy_args );

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
            'menu_icon'          => 'dashicons-welcome-learn-more',
            'menu_position'      =>  31,
            'has_archive'        => true,
            'publicly_queryable' => true,
            'rewrite'            => array( 'slug' => $ogoloshennya_url_slug ),
            'capability_type'    => 'post',
        );

        register_post_type( $ogoloshennya_url_slug, $post_type_args );
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
        else if ( $post->post_type == 'galereya' ) {
            $single_template = dirname( __FILE__ ) . '/templates/single-galereya.php';
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
