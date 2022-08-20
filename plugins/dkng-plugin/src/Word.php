<?php

namespace Dkng\Wp;

class Word {


    /**
     * Actions on Init
     */
    public function init_actions() {

        add_action( 'wp_ajax_word_export',         [ $this,  'word_export_function' ] );
        add_action( 'wp_ajax_nopriv_word_export',  [ $this,  'word_export_function' ] );

    }

    /**
     * Function exporting post data to Word document
     *
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function word_export_function() {

       if ( empty( $_POST['post_id'] ) ) {
           return;
       }

       $post_id  = (int)$_POST['post_id'];
       $post     = get_post( $post_id );

       $php_word = new \PhpOffice\PhpWord\PhpWord();

       $section  = $this->add_content( $php_word, $post );

       $font_style = new \PhpOffice\PhpWord\Style\Font();
       $font_style->setBold(true);
       $font_style->setName('Tahoma');
       $font_style->setSize(13);

       $my_text_element = $section->addText( $post->post_content );
       $my_text_element->setFontStyle($font_style);
       
       $obj_writer = \PhpOffice\PhpWord\IOFactory::createWriter( $php_word, 'Word2007' );
       $upload_dir = wp_upload_dir();
       $file_url   = $upload_dir['path'] . '/'. $post->post_name . '.docx';
       $file_path  = $upload_dir['url']  . '/'. $post->post_name . '.docx';

       ob_clean();
       $obj_writer->save( $file_url );
       wp_send_json( [ 'file_url' => $file_path ], 200 );
   }

   public function add_content ( $php_word, $post ) {

       $section = $php_word->addSection();

       $section->addText (
           $post->post_title,
           array( 'name' => 'Tahoma', 'size' => 14, 'color' => '1B2232', 'bold' => true )
       );

       if ( get_the_post_thumbnail_url( $post->ID, 'thumbnail' ) ) {
           $section->addImage( get_the_post_thumbnail_url( $post->ID, 'thumbnail' ),
               array( 'align'=>'left')
           );
       }
       $section->addText (
           $post->post_excerpt,
           array( 'name' => 'Tahoma', 'size' => 12, 'color' => '1B2232', 'bold' => false )
       );

       return $section;
   }

}
