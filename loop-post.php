<?php 
    $title = strip_tags(get_the_title()); 
    $url = get_the_permalink();
?>

<article class="post">
    <header>
        <h2><a href="<?php the_permalink(); ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h2>
    </header>

    <section class="clearfix">
      <?php if( has_post_thumbnail() ) { ?>
        <div class="media">
            <span class="date-label"><span><?php the_time('d'); ?></span><?php the_time('M'); ?></span>
            <a href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
                <?php the_post_thumbnail('medium'); ?>
            </a>
        </div>
      <?php } else { ?>
        <div class="media empty">
            <span class="date-label"><span><?php the_time('d'); ?></span><?php the_time('M'); ?></span>
        </div>
      <?php } ?>
        
      <?php the_excerpt(); ?>

    </section>

    <footer>
        <a href="<?php the_permalink(); ?>" class="btn orange">READ MORE</a>
    </footer>

</article>