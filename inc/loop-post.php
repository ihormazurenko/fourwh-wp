<?php
    $title = strip_tags(get_the_title());
    $url = get_the_permalink();
?>
<li>
    <div class="article-box">
        <a href="article-details.html" title="Four Wheel Business is Amazing">
            <div class="article-img-wrap">
<!--                <img src="img/article_1.jpg" alt="Four Wheel Business is Amazing">-->
                <a href="<?php the_permalink(); ?>" title="<?= esc_attr($title); ?>">
                    <?php the_post_thumbnail('full', array(
                        'alt'   => esc_attr($post->post_title)
                    )); ?>
                </a>
            </div>
        </a>
        <a href="article-details.html" title="Four Wheel Business is Amazing">
            <h2 class="article-title">Four Wheel Business is Amazing</h2>
        </a>
        <div class="article-info"> Published Date: 22 september 2018 By <a href="#" title="Nikil Shorma">Nikil Shorma</a></div>
        <div class="content">
            <p>Business to popular belief, Lorem Ipsum is not simply random text.
                It has roots in a piece of classica Latin literature from 45 BC,
                making it over 2000 years old. Richard McClintock very impottant
                an trending business for sturt upIt is a long established fact that
                a reader will be distracted by the reads readable content of a page
                when looking at its layout. The point of using Lorem Ipsum is tha it has
                more-or-less normal distribution of letters, as opposed to using
                'Content here, content here', making it look like readable English.
                Many desktop publishing packages...</p>
            <p>Business to popular belief, Lorem Ipsum is not simply random text.
                It has roots in a piece of classical Latin literature from 45 BC,
                making it over 2000 years old. Richard McClintock very impottant
                and trending business for sturt upIt is a long
                established. <a class="read-more" href="article-details.html" title="Read More">Read More...</a></p>
        </div>
    </div>
</li>