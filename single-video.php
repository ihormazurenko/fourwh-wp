<?php
get_header();

$title               = get_the_title();
$video_type          = get_field('video_type');
$video_id            = get_field('video_id');
$site_url            = get_site_url();
$current_url        = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$referrer           = '';

?>

    <section class="section section-hero inverse video" style="background: black;">
        <div id="content"></div>
        <div class="container">
            <h1 class="section-title smaller line"><?php echo $title; ?></h1>
            <div class="videoWrapper">
                <?php if($video_type =='YouTube') : ?>

                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php print $video_id; ?>?&autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                <?php else:  ?>

                <iframe src="https://player.vimeo.com/video/<?php print $video_id; ?>?autoplay=1&title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" allow="autoplay" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

                <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="section content-wrapper section-how-video-details">
        <div class="container">

            <div class="section-desc content">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
                <?php endwhile; else: endif; ?>
            </div>

            <div class="categories">
                <ul>
                    <li>
                    <?php
                        //check if referrer was from the current site and show back button if so.

                        if(isset($_SERVER['HTTP_REFERER'])) :
                            $referrer = $_SERVER['HTTP_REFERER'];
                        endif;

                        //check if the site domain is in the referrer url and was not a page refresh
                        if (strpos($referrer, $site_url) !== false && $referrer != $current_url) : ?>

                            <a class="btn blue small" href="<?php print $_SERVER['HTTP_REFERER']; ?>"><i class="fas fa-arrow-left"></i> Return to videos</a></li>

                        <?php
                        else : ?>
                            <a class="btn blue small" href="<?php print $site_url; ?>/videos/"><i class="fas fa-arrow-left"></i> Return to videos</a></li>

                        <?php
                        endif; ?>

                </ul>
            </div>

        </div>
    </section>

<?php get_footer(); ?>
