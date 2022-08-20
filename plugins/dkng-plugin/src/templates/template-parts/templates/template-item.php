<?php
/**
 * Template Part for single loop post item
 * Post Type: Template ( svn_tpl )
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $tpl ) )
    return;

$asset = $tpl->get_the_asset();
?>
<div class="item">

    <?php /* PDF
      <div class="item-image ">
      <object data="https://test.viewdemo.co/wp/seven-group/wp-content/uploads/2020/12/Its-the-Season-for-Gifting-Strategies-for-a-Change-in-Estate-Taxes.pdf#view=Fit" type="application/pdf" width="100%" height="850">
      </object>
      </div>
     */ ?>
    <?php /* DOC, PPT
      <div class="item-image ">
      <iframe src="https://docs.google.com/gview?url=https://test.viewdemo.co/wp/seven-group/wp-content/uploads/2020/12/The-IRA-Roth-Conversion-Retirement-Planning-Tool.docx&embedded=true" frameborder="0">
      </iframe>
      </div>
     */ ?>
    <?php /* PNG
      <div class="item-image ">
      <img src="https://test.viewdemo.co/wp/seven-group/wp-content/uploads/2021/02/ipad-size@2-1.png" alt="image">
      </div>
     */ ?>
    <?php
    if ( !empty( $asset ) ) {
        ob_start();
        switch ( $asset[ 'type' ] ) {
            case 'pdf' :
                ?>
                <object data="<?php echo $asset[ 'url' ]; ?>#view=Fit"
                        type="application/pdf"
                        width="110%"
                        height="850">
                </object>
                <?php
                break;
            case 'png' :
                ?>
                <img src="<?php echo $asset[ 'url' ]; ?>" alt="image">
                <?php
                break;
            default :
                ?>
                <iframe src="https://docs.google.com/gview?url=<?php echo $asset[ 'url' ]; ?>&embedded=true" frameborder="0">
                </iframe>
                <?php
                break;
        }
        $tem_image_content = ob_get_clean();
    }
    if ( !empty( $tem_image_content ) ) {
        ?>
        <div class="item-image ">
            <?php echo $tem_image_content; ?>
        </div>
    <?php } ?>

    <div class="item-content">
        <?php if ( !empty( $topic = $tpl->get_the_topic() ) ) { ?>
            <span class="item-topic">
                <?php echo $topic->name; ?>
            </span>
        <?php } ?>
        <h4 class="item-title">
            <?php the_title(); ?>
        </h4>
        <div class="item-btn-wrap">
            <a href="#" class="btn btn-view">
                <?php _e( 'View', 'dkng' ); ?>
            </a>
            <a class="btn btn-pdf-download btn-download" href="<?php echo $asset[ 'url' ]; ?>" download>
                <?php _e( 'Download', 'dkng' ); ?>
            </a>
        </div>
    </div>
</div>
