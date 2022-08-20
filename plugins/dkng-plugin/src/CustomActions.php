<?php

namespace Dkng\Wp;

class CustomActions {


    /**
     * Actions on Init
     */
    public function init_actions() {

        add_action( 'wp_ajax_contact_page',              [ $this,  'contact_page_function' ] );
        add_action( 'wp_ajax_nopriv_contact_page',       [ $this,  'contact_page_function' ] );

        add_action( 'wp_ajax_load_posts_by_ajax',        [ $this,  'load_posts_by_ajax_callback' ] );
        add_action( 'wp_ajax_nopriv_load_posts_by_ajax', [ $this,  'load_posts_by_ajax_callback' ] );

        add_action( 'wp_ajax_filtering_articles',        [ $this,  'filtering_articles_function' ] );
        add_action( 'wp_ajax_nopriv_filtering_articles', [ $this,  'filtering_articles_function' ] );

    }


    /**
     * Callback function for loading posts
     *
     */
    public function load_posts_by_ajax_callback() {

        $paged           = (int)$_POST['page'];
        $count_per_page  = 20;
        $get_cat         = ( !empty( $_POST['get_cat'] ) )  ? $_POST['get_cat']  : '';
        $cpt_type        = ( !empty( $_POST['cpt_type'] ) ) ? $_POST['cpt_type'] : '';
        $get_original_edited = ( !empty( $_POST['get_original_edited'] ) ) ? $_POST['get_original_edited'] : '';

        $campaign_type   = false;
        $user            = wp_get_current_user();
        $user_company    = get_field( 'name', 'user_' . $user->ID );
        $company_sorted  = strtolower( str_replace( ' ', '__', $user_company ) );
        $company_sorted  = strtolower( str_replace( '&', '_and_', $company_sorted ) );
        $excluded_articles = array();

        $posts_not_in    = array();
        $posts_in        = array();

        if ( $cpt_type == 'articles' ) {
            $post_type   = 'articles';
            $mytaxonomy  = 'articles-category';

            $cloned_articles   = get_user_meta( $user->ID, 'user_cloned_articles', true );
            $cloned_articles   = !empty( $cloned_articles ) ? array_keys( $cloned_articles ) : array();

            $articles_prepare = new \WP_Query( array (
                'post_type'      => 'articles',
                'fields'         => 'ids',
                'posts_per_page' => -1,
            ) );

            foreach ( $articles_prepare->posts as $article ) {
                $uncompanies_list  = get_post_meta( $article, 'uncompanies_list', true );

                if (
                    (
                        !empty( $uncompanies_list ) && is_array( $uncompanies_list )
                        && ( array_key_exists( $company_sorted, $uncompanies_list ) )
                    ) || ( $uncompanies_list == 'none' ) ) {
                    $excluded_articles[] = $article;
                }
            }

            if ( $get_original_edited == 'original' ) {
                $posts_not_in  = $cloned_articles;
                $posts_in      = array();
            }
            elseif ( $get_original_edited == 'edited' ) {
                $posts_in      = $cloned_articles;
                $posts_not_in  = array();
            }

            $excluded_articles = array_merge( $posts_not_in, $excluded_articles );
        }
        else if ( $cpt_type == 'courses' ) {
            $post_type   = 'courses';
            $mytaxonomy  = 'courses-category';
        }
        else if ( $cpt_type == 'campaigns' ) {
            $post_type   = 'campaigns';
            $mytaxonomy  = 'campaigns-category';
            $campaign_type = ( !empty( $_POST['campaign_type'] ) ) ? $_POST['campaign_type'] : '';
        }

        if ( $cpt_type == 'post' ) {
            $count_per_page  = 4;
            $post_type   = 'post';
            $mytaxonomy  = 'category';
        }

        $args = $this->set_args_params( $get_cat, $post_type, $count_per_page, $paged, $mytaxonomy, $excluded_articles, $posts_in, $campaign_type );

        if ( ( $_POST['total_count'] + $count_per_page ) < ( $count_per_page * $paged ) ) {
            wp_die();
        }

        $my_posts  = new \WP_Query( $args );
        $totalpost = $my_posts->found_posts ;

        $result = $this->set_html_layout( $my_posts, $mytaxonomy, $cpt_type, $paged, $count_per_page, $totalpost );
        wp_send_json( $result, 200);

    }


    /**
     * Function filtering articles
     *
     */
    public function filtering_articles_function( ) {
        $post   = $_POST;
        parse_str ( $post['data'], $params );

        $count_per_page        = 20;
        if ( $post['js_type'] == 'load_more' ) {
            $article_cat       = ( !empty( $post['topic'] ) ) ? $post['topic'] : '';
            $article_type      = ( !empty( $post['type'] ) )  ? $post['type']  : '';
            $article_sort      = ( !empty( $post['sort'] ) )  ? $post['sort']  : '';
            $article_original_edited = ( !empty( $post['original_edited'] ) )  ? $post['original_edited']  : '';
            $paged             = (int)$post['page'];
        }
        else {
            $paged             = 1;
            $article_cat       = ( !empty( $params['topic'] ) ) ? $params['topic'] : '';
            $article_type      = ( !empty( $params['type'] ) )  ? $params['type']  : '';
            $article_sort      = ( !empty( $params['sort'] ) )  ? $params['sort']  : '';
            $article_original_edited = ( !empty( $params['original_edited'] ) )  ? $params['original_edited']  : '';
        }

        $user              = wp_get_current_user();

        $cloned_articles   = get_user_meta( $user->ID, 'user_cloned_articles', true );
        $cloned_articles   = !empty( $cloned_articles ) ? array_keys( $cloned_articles ) : array();

        $user_company      = get_field( 'name', 'user_' . $user->ID );
        $company_sorted    = strtolower( str_replace( ' ', '__', $user_company ) );
        $company_sorted    = strtolower( str_replace( '&', '_and_', $company_sorted ) );
        $excluded_articles = array();

        $archived_posts    = get_user_meta( $user->ID, 'archived_articles', true );
        $archived_posts    = !empty( $archived_posts ) ? $archived_posts : array();

        $post_type         = 'articles';
        $mytaxonomy        = 'articles-category';

        $posts_not_in      = array();
        $posts_in          = array();
        /* Old functionality - for now not used
        if ( $article_sort == 'archived' ) {
            $posts_not_in  = array();
        }
        elseif ( $article_sort == 'new' ) {
            $posts_not_in = $archived_posts;
        }
        */

        if ( $article_original_edited == 'original' ) {
            $posts_not_in  = $cloned_articles;
            $posts_in      = array();
        }
        elseif ( $article_original_edited == 'edited' ) {
            $posts_in      = $cloned_articles;
            $posts_not_in  = array();
        }

        $arr = array (
            'post_type'      => 'articles',
            'post_status'    => 'publish',
            'fields'         => 'ids',
            'post__not_in'   => $posts_not_in,
            'post__in'       => $posts_in,
            'posts_per_page' => -1,
        );
        $articles_prepare = new \WP_Query( $arr );

        foreach ( $articles_prepare->posts as $article ) {
            $acf_type         = get_field( 'article_type', $article );
            $acf_type         = empty( $acf_type ) ? 'article' : $acf_type;
            $uncompanies_list = get_post_meta( $article, 'uncompanies_list', true );

            if (
                (
                    (
                        !empty( $uncompanies_list ) && is_array( $uncompanies_list )
                        &&
                        ( array_key_exists( $company_sorted, $uncompanies_list ) )
                    )
                    || ( $uncompanies_list == 'none' )
                )
                || ( ( $article_type != 'all' ) && ( $acf_type != $article_type ) )
                || ( ( $article_sort == 'archived' ) && !in_array( strval( $article ), $archived_posts )  )
                || ( ( $article_sort == 'new' ) && in_array( strval( $article ), $archived_posts )  )
            ) {
                $excluded_articles[] = $article;
            }

        }

        $excluded_articles = array_merge( $posts_not_in, $excluded_articles );
        $args = $this->set_args_params( $article_cat, $post_type, $count_per_page, $paged, $mytaxonomy, $excluded_articles, $posts_in );

        if ( ( $_POST['total_count'] + $count_per_page ) < ( $count_per_page * $paged ) ) {
            wp_die();
        }

        $my_posts  = new \WP_Query( $args );
        $totalpost = $my_posts->found_posts;

        $result    = $this->set_html_layout_filtering( $my_posts, $mytaxonomy, $post_type, $paged, $count_per_page, $totalpost, $article_cat, $article_type, $article_sort );
        wp_send_json( $result, 200);

    }

    /**
     * Setting args params for query
     *
     * @param $get_cat
     * @param $post_type
     * @param $count_per_page
     * @param $paged
     * @param $mytaxonomy
     * @param array $excluded_articles
     * @param array $included_articles
     * @param $campaign_type
     *
     * @return array
     */
    public function set_args_params( $get_cat, $post_type, $count_per_page, $paged, $mytaxonomy, $excluded_articles = array(), $included_articles = array(), $campaign_type = false  ) {

        if ( $post_type == 'campaigns' ) {
            $user        = wp_get_current_user();
            $category_in = ( !empty( $campaign_type ) && ( $campaign_type == 'cloned' ) ) ? 'IN' : 'NOT IN';
            $add_author  = ( !empty( $campaign_type ) && ( $campaign_type == 'cloned' ) ) ? array( 'author' => $user->ID ) : array();

            $add_array = array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'campaigns-category',
                        'field'    => 'slug',
                        'terms'    => array( 'cloned' ),
                        'operator' => $category_in,
                    ),
                ),
            );

            $args = array (
                'post_type'      => $post_type,
                'post_status'    => 'publish',
                'posts_per_page' => $count_per_page,
                'post__not_in'   => $excluded_articles,
                'paged'          => $paged,
            );

            if ( ( !empty( $campaign_type ) && ( $campaign_type == 'cloned' ) ) ) {
                $args = array_merge( $args, $add_array, $add_author );
            }
            else {
                $args = array_merge( $args, $add_array );
            }

        }
        else {
            if ( $get_cat == 'all' ) {
                $args = array (
                    'post_type'      => $post_type,
                    'post_status'    => 'publish',
                    'posts_per_page' => $count_per_page,
                    'post__not_in'   => $excluded_articles,
                    'post__in'       => $included_articles,
                    'paged'          => $paged,
                );

                if ( $post_type == 'articles' ) {
                    $array_originals = array(
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'articles-types',
                                'field'    => 'slug',
                                'terms'    => array( 'original' ),
                                'operator' => 'IN',
                            ),
                        )
                    );
                    $args = array_merge( $args, $array_originals );
                }

            }
            else {

                if ( $post_type == 'articles' ) {
                    $taxonomy_arr = array(
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => $mytaxonomy,
                                'field'    => 'slug',
                                'terms'    => $get_cat,
                            ),
                            array(
                                'taxonomy' => 'articles-types',
                                'field'    => 'slug',
                                'terms'    => array( 'original' ),
                                'operator' => 'IN',
                            )
                        )
                    );
                }
                else {
                    $taxonomy_arr = array(
                        'tax_query' => array (
                            array (
                                'taxonomy' => $mytaxonomy,
                                'field'    => 'slug',
                                'terms'    => $get_cat,
                            ),
                        )
                    );
                }

                $args = array (
                    'post_type'      => $post_type,
                    'post_status'    => 'publish',
                    'posts_per_page' => $count_per_page,
                    'post__not_in'   => $excluded_articles,
                    'post__in'       => $included_articles,
                    'paged'          => $paged,
                );


                $args = array_merge( $args, $taxonomy_arr );
            }
        }

        return $args;
    }

    /**
     * Setting html layout of different cpt for Ajax requests
     *
     * @param $my_posts
     * @param $mytaxonomy
     * @param $cpt_type
     * @param $paged
     * @param $count_per_page
     * @param $totalpost
     *
     * @return array|void
     */
    public function set_html_layout( $my_posts, $mytaxonomy, $cpt_type, $paged, $count_per_page, $totalpost ) {

        /** Courses CPT part */
        $user                = wp_get_current_user();
        $completed_courses   = get_user_meta( $user->ID, 'completed_courses' );
        $progressing_courses = get_user_meta( $user->ID, 'progressing_courses' );

        $user_campaigns      = get_user_meta( $user->ID, 'user_campaigns', true );
        $user_campaigns      = ( !empty( $user_campaigns ) ) ? $user_campaigns : array();
        /**  */

        if ( $my_posts->posts ) {
            ob_start();
            $i = 0;
            foreach ( $my_posts->posts as $post ) {
                /** Common data for CPT Courses / Articles */
                $approval        = get_field_object('approval_post', $post->ID );
                $key             = $approval['value'];
                $approve_status  = $approval['choices'][$key];
                $categories      = get_the_terms( $post->ID, $mytaxonomy);
                $post_status     = ( get_post_status( $post->ID ) == 'publish' ) ? 'Published' : 'Unpublished';

                if ( !empty( $categories ) ) {
                    foreach( $categories as $cat ){
                        $cat_list[$post->ID][] = $cat->name;
                    }
                }
                $cats_string = ( $cat_list[$post->ID] ) ? implode( ", ", $cat_list[$post->ID] ) : '';
                /**  */

                /** Courses CPT part */
                $lessons        = get_field( 'lessons', $post->ID );
                $number_lessons = ( $lessons ) ? count($lessons) : 0;

                if ( in_array( $post->ID, $progressing_courses[0] ) ) {
                    $status = 'In Progress';
                }
                else if ( in_array( $post->ID, $completed_courses[0] ) ) {
                    $status = 'Completed';
                }
                else {
                    $status = 'New';
                }
                /**  */

                if ( $cpt_type == 'articles' ) {
                    $article = $post;
                    include 'templates/template-parts/ajax-items/article_item.php';
                } else if ( $cpt_type == 'courses' ) {
                    $course = $post;
                    require 'templates/template-parts/ajax-items/course_item.php';
                } else if ( $cpt_type == 'campaigns' ) {
                    $i++;

                    $title      = get_the_title( $post->ID );
                    $link       = get_permalink( $post->ID );
                    $start_date = get_field( 'start_date_email', $post->ID );
                    $thumbnail  = get_the_post_thumbnail_url( $post->ID );

                    $campaign   = $post->ID;
                    $status     = ( !empty( $user_campaigns['active'] ) && array_key_exists( $post->ID, $user_campaigns['active'] ) ) ? __( 'Active', 'dkng' ) : __( 'Not Active', 'dkng' );
                    $status     = ( !empty( $user_campaigns['finished'] ) && in_array( $post->ID, $user_campaigns['finished'] ) )     ? __( 'Completed', 'dkng' ) : $status;
                    $status     = ( !empty( $user_campaigns['draft'] ) && array_key_exists( $post->ID, $user_campaigns['draft'] ) )     ? __( 'Draft', 'dkng' ) : $status;
                    $ribbon_background = '';

                    $post_terms = wp_get_object_terms( $campaign, 'campaigns-category', array('fields' => 'slugs') );

                    if ( $status === 'Not Active' ) {
                        $ribbon_background = 'background-color: #c3cedd;';
                    } elseif( $status === 'Completed' ) {
                        $ribbon_background = 'background-color: #0645c7;';
                    }

                    $index = ( ( $paged - 1 ) * $count_per_page ) + $i;

                    require 'templates/template-parts/ajax-items/campaign_item.php'; ?>
                <?php } else if ( $cpt_type == 'post' ) {
                     require 'templates/template-parts/ajax-items/post_item.php'; ?>
                <?php }
            }

            $result['html']  = ob_get_clean();
            $result['count'] = ( $paged > 1 ) ? count( $my_posts->posts ) + ( ( $paged - 1 ) * $count_per_page) : count( $my_posts->posts ) * $paged;
            $result['total'] = $count_per_page * $paged;
            $result['all']   = $totalpost;
            $result['page']  = $paged;

            wp_reset_postdata();

            return $result;
        }
    }

    /**
     * Setting html layout of filtering for Ajax requests
     *
     * @param $my_posts
     * @param $mytaxonomy
     * @param $cpt_type
     * @param $paged
     * @param $count_per_page
     * @param $totalpost
     * @param $article_cat
     * @param $article_type1
     * @param $article_sort
     *
     * @return array|void
     */
    public function set_html_layout_filtering( $my_posts, $mytaxonomy, $cpt_type, $paged, $count_per_page, $totalpost, $article_cat, $article_type1, $article_sort ) {
        $paged = (int)$paged;

        $user             = wp_get_current_user();
        $cloned_articles  = get_user_meta( $user->ID, 'user_cloned_articles', true );
        $cloned_articles  = !empty( $cloned_articles ) ? $cloned_articles : array();

        if ( !empty( $my_posts->posts ) ) {
            ob_start();

            foreach ( $my_posts->posts as $post ) {
                /** Common data for Articles */
                $approval        = get_field_object('approval_post', $post->ID );
                $key             = $approval['value'];
                $approve_status  = $approval['choices'][$key];
                $categories      = get_the_terms( $post->ID, $mytaxonomy);
                $post_status     = ( get_post_status( $post->ID ) == 'publish' ) ? 'Published' : 'Unpublished';

                if ( !empty( $categories ) ) {
                    foreach( $categories as $cat ){
                        $cat_list[$post->ID][] = $cat->name;
                    }
                }
                $cats_string = ( $cat_list[$post->ID] ) ? implode( ", ", $cat_list[$post->ID] ) : '';

                $article_type = get_field( 'article_type', $post->ID );
                $article_type = empty( $article_type ) ? 'all' : $article_type;

                $article   = $post;

                require  'templates/template-parts/ajax-items/article_item.php';
            }

            $result['html']  = ob_get_clean();
            $result['count'] = ( $paged > 1 ) ? count( $my_posts->posts ) + ( ( $paged - 1 ) * $count_per_page) : count( $my_posts->posts ) * $paged;
            $result['total'] = $count_per_page * $paged;
            $result['all']   = (int)$totalpost;
            $result['page']  = $paged;

            $result['article_cat']  = $article_cat;
            $result['article_type'] = $article_type1;
            $result['article_sort'] = $article_sort;

            wp_reset_postdata();

            return $result;
        }
    }

    /**
     * Function updating articles companies for sorting in admin panel
     *
     * @param $user_id
     * @param $company_name
     * @return bool
     */
    public function update_articles_company( $user_id, $company_name ) {

        $articles =  new \WP_Query( array ( 'post_type' => 'edited_articles', 'posts_per_page' => -1 ) );

        foreach ( $articles->posts as $article ) {

            if ( (int)$article->post_author == (int)$user_id ) {
                update_field( 'author_company', $company_name, $article->ID );

                $new_permalink = get_permalink( $article->ID );
                $new_permalink =  explode( '/edited_articles/', $new_permalink );
                $index         =  strpos( $new_permalink[1], '/'  );
                if ( $index > 1 ) {
                    $article_url = substr($new_permalink[1], $index+1 );
                    $new_permalink  = "edited_articles/$company_name/$article_url";
                    update_post_meta( $article->ID, 'custom_permalink', $new_permalink );
                }
            }

        }

        return true;

    }


    /**
     * Function callback for contact page
     *
     */
    public function contact_page_function() {

        if ( empty( $_POST['data'] ) ) {
            return;
        }

        parse_str ( $_POST['data'], $params );

        if ( !filter_var( $params["email"], FILTER_VALIDATE_EMAIL ) ) {
            wp_send_json( array('error'=> false, 'message' => 'Not correct email address.'), 500 );
        }

        Mail::prepare_mail_info( $params);

        wp_send_json( array( 'error'=> false, 'message' => 'Done.', 'data' => $params ), 200 );

    }

}
