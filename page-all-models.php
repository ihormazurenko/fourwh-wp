<?php
/**
 * Template Name: All Models
 */
get_header();

    $instruction_line   = get_field('instruction-line');
    $boxes              = get_field('boxes');
?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section-all-models">

        <div class="instruction-line">
            <div class="container">
                <h3><?php echo trim($instruction_line) ? $instruction_line : __('Select Your Platform', 'fw_campers'); ?></h3>
            </div>
        </div>

        <?php if (is_array($boxes) && count($boxes) > 0) { ?>
            <ul class="all-models-list">
                <?php foreach ($boxes as $box) {
                    $details    = $box['details'];
                    $title      = trim($details['title']) ? $details['title'] : '';
                    $esc_title  = strip_tags(esc_attr($title));
                    ?>
                    <li>
                        <?php if ($details['link']) echo "<a href='".esc_url($details['link'])."' title='{$esc_title}'>"; ?>
                            <div class="all-models-box">
                                <div class="all-models-box-img centered-img">
                                    <?php
                                        if ($box['image']) {
                                            echo wp_get_attachment_image($box['image']['id'], 'large', false, array('alt' => $esc_title));
                                        }
                                    ?>
                                </div>
                                <div class="all-models-box-info">
                                    <?php if ($title || $details['description']) { ?>
                                        <div class="all-models-box-desc">
                                            <?php
                                                if ($title) echo "<h2>{$title}</h2>";
                                                if (trim($details['description'])) echo "<p>{$details['description']}</p>";
                                            ?>
                                        </div>
                                    <?php }
                                    if ($details['link']) { ?>
                                        <div class="explore-link-box">
                                            <span class="explore-link"><i class="fas fa-chevron-right"></i><?php _e('Explore', 'fw_campers'); ?></span>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php if ($details['link']) echo '</a>'; ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>

    </section>

<?php get_footer(); ?>