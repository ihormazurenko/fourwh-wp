<?php
$current_fp     = get_query_var('flocation');
$campers_list   = '';
$find_dealer_id = 391;

if ($current_fp == 'showroom') {
	$show_our_showroom  = get_field('show_our_showroom');
	$our_showroom       = $show_our_showroom ? get_field('our_showroom') : '';

	if ($our_showroom && is_array($our_showroom) && count($our_showroom) > 0) {
		$campers_list = $our_showroom['campers_list'] ? $our_showroom['campers_list'] : '';
	}


} elseif ($current_fp == 'campers-for-sale') {
	$show_campers_for_sale  = get_field('show_campers_for_sale');
	$campers_for_sale       = $show_campers_for_sale ? get_field('campers_for_sale') : '';

  if ($campers_for_sale && is_array($campers_for_sale) && count($campers_for_sale) > 0) {
      $campers_list = $campers_for_sale['campers_list'] ? $campers_for_sale['campers_list'] : '';
  }
}


if ( $campers_list && is_array( $campers_list ) && count( $campers_list ) > 0 ) :
	?>
	<div class="inventory-detail-list-wrap">
		<ul class="inventory-detail-list">
			<?php


			foreach ( $campers_list as $detail ) :
		        $photos = $video = $video_url = $video_thumb_url = '';
		        $photo_count = 0;

						$title = $detail['title'];
						$description = $detail['description'];
						$type = $detail['video_photo_switch'] ? strtolower($detail['video_photo_switch']) : 'photo';

				if ($type === 'video') {
		            $video = ($detail['video'] && is_array($detail['video']) && count($detail['video']) > 0) ? $detail['video'] : '';
		            if ($video){
		                $video_url       = trim($video['url']) ? $video['url'] : '';
		                $video_thumb_url = $video['thumbnail'] ? $video['thumbnail']['sizes']['medium_large'] : getVideoThumbnail($video_url, 'small');
		            }
		        } else {
		            $photos       = (isset($detail['photo']) && is_array($detail['photo']) && count($detail['photo']) > 0) ? $detail['photo'] : '';
		            $photo_count  = count($detail['photo']);
		        }

				?>
				<li class="full-inventory-info">
					<div class="inventory-detail-box">
						<div class="left-box">
							<?php 
							if ($photos) {

								if ($photo_count > 1) {
									echo '<div class="dealer-slider">
                          <div class="swiper-container">
                              <div class="swiper-wrapper">';
								}

								foreach ($photos as $key => $photo) :
									$image_id = $photo['ID'] ? $photo['ID'] : '';
									$image_url = $photo['sizes']['max-width-2800'] ? $photo['sizes']['max-width-2800'] : $photo['url'];
									$image_class = $photo['width'] > $photo['height'] ? 'wider' : '';

									if ($photo_count > 1) {
										echo '<div class="swiper-slide centered-img">'.wp_get_attachment_image( $image_id, 'size-720_720', false, array('class' => 'dealer-slide-img')).'</div>';
									} else {
										?>
										<div class="centered-img <?php echo $image_class; ?>">
											<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
										</div>
										<?php
									}

								endforeach;

								if ($photo_count > 1) {
									echo '  
                              </div>
                              <div class="swiper-pagination"></div>
                              <div class="swiper-button-prev"></div>
                              <div class="swiper-button-next"></div>
                          </div>
                      </div>';
								}
              } elseif ($video_url) {
                echo '<a href="' . $video_url . '?autoplay=1&muted=0&loop=1" class="youtube-video blue" title="' . esc_attr(strip_tags($title)) . '">
                        <div class="video-preview">
                          <img class="dealer-slide-img" src="' . $video_thumb_url . '" alt="' . esc_attr(strip_tags($title)) . '">
                        </div>';
                echo '</a>';
              }
//                    endif;
//              else if ($video_url):

//               echo '<a href="' . $video_url . '?autoplay=1&muted=0&loop=1" class="youtube-video blue" title="' . esc_attr(strip_tags($title)) . '">
//                        <div class="video-preview">
//                          <img src="' . $video_thumb_url . '" alt="' . esc_attr(strip_tags($title)) . '">
//                        </div>';
//                echo '</a>';

//							endif;

							?>
						</div>
						<div class="right-box">
							<div class="inventory-info-wrap">

								<?php if ( $title ) { ?>
									<h3 class="inventory-detail-title"><?php echo $title; ?></h3>
								<?php } ?>
									<?php
									if ( $description ) {
									  echo '<div class="inventory-info-box content">';
                      echo $description;
                    echo '</div>';
									}
									?>
							</div>
						</div>
					</div>
				</li>
			<?php
			endforeach;
			?>
		</ul>
    <?php if ($current_fp == 'campers-for-sale') { echo '<div class="centered-btn-box"><a href="'.get_permalink($find_dealer_id).'?dealer-id='.get_the_ID().'" class="btn blue-light back-btn" title="'.__('Back to dealer locations','fw_campers').'"><i class="fas fa-angle-left"></i>'.__('Back to dealer locations','fw_campers').'</a></div>'; } ?>
	</div>
<?php
endif;
