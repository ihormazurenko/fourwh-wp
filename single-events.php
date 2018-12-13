<?php
get_header();

$title = get_the_title();
$url = get_permalink();
$date = get_the_date(get_option('date_format'));

$archive_year  = get_the_time('Y');
$archive_month = get_the_time('m');
$archive_day   = get_the_time('d');

?>

    <section class="section content-wrapper section-event">
        <div class="container">

            <h1 class="section-title smaller line">All Of Mistaken Idea Of Pleasure</h1>







            <div class="video-list content">

                <div class="list-item">

                    <div class="image">
                        <img src="<?php echo get_bloginfo('template_url'); ?>/img/calendar-thumbnail.jpg" alt="">
                    </div>
                    <div class="text">

                        <ul>
                            <li><i class="far fa-calendar-alt"></i> September 27, 2018 @ 4:30 pm PST</li>
                            <li><i class="fas fa-map-marker"></i> British Columbia, Canada</li>

                        </ul>
                        <h5>Location</h5>
                        <div class="address">Coffee House 4432 More Rd. #1243, <br />San Francisco, CA 95835</div>
                        <h5>Details</h5>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour or randomised </p>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour or randomised </p>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour or randomised </p>
                    </div>

                </div>



            </div>




        </div>
    </section>

<?php get_footer(); ?>