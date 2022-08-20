<?php
/**
 * The template for displaying 404 pages (Not Found)
 */
get_header('custom'); ?>
  <div id="content" class="row align-items-center justify-content-center page404" style="height: 100%;">
    <div class="container text-center">
      <h1 class="text-white">Uh oh. Looks like that page can't be found.
        <br>Head back to our <a href="<?php echo home_url();?>">home page</a>  to find what you're looking for
        or send us an email at <a href="mailto:info@fmail.com" target="_blank">info@fmail.com.com</a> </h1>
    </div>
  </div>
  </div>
<?php get_footer('custom');
wp_footer(); ?>