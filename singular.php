<?php 
    $show_section_info = get_field('show_section_info');
?>
<?php get_header(); ?>
    
    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section section-content content-wrapper">
        <div id="content"></div>
        <div class="container">
            <?php get_template_part('inc/section', 'info'); ?>
            <?php  
                  // If the section info content is included, and the title is included, don't show the page title
                  if (!$show_section_info) { 
                    the_title('<h1 class="section-title">', '</h1>');
                  }
                ?>
            <?php get_template_part('inc/section', 'content'); ?>
        </div>
    </section>

<?php get_footer(); ?>