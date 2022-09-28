<?php
    $today = date('Ymd');
    $args = array(
        'post_type'     => 'post',
        'numberposts' 	=> -1,
        'category_name' => 'events',
        'nopaging'      => true,
        'orderby'       => 'meta_value',
        'order'         => 'ASC',
        'meta_key'      => 'start_date', //ACF date field
        'meta_query'    => array( array(
            'key'       => 'start_date', 
            'value'     => $today, 
            'compare'   => '>=', 
            'type'      => 'DATE'
        ))
    );
    $upcoming_events = get_posts( $args ); ?>


<div class="swiper eventSwiper">
    <div class="swiper-wrapper">

    <?php foreach($upcoming_events as $event) { 
        // Post defaults
        $eventTitle = $event->post_title;
        $eventFeatureImage = get_the_post_thumbnail( $event, 'large' );
        $eventShortDescription = wp_trim_words($event->$post_content, 20, '...');
        // Extra ACF fields
        $theDay = get_field('day', $event);
        $theMonth = get_field('month', $event);
        $theCategory = get_field('category', $event);
        $theTime = get_field('time', $event);
    ?>

    <div class="swiper-slide">
        <a class="single-event" href="<?php echo the_permalink($event); ?>">
            <div class="card-top">
                <div class="theDate">
                    <span><?php echo $theMonth; ?></span>
                    <span><?php echo $theDay; ?></span>
                </div>
                <?php echo $eventFeatureImage; ?>
            </div>
            <div class="card-bottom">
                <p>Giba Events</p>
                <h3><?php echo $eventTitle; ?></h3>
                <div class="description">
                    <p><?php echo $theCategory; ?></p>
                    <p><?php echo $eventShortDescription; ?></p>
                </div>
                <div class="theTime">
                    <span><i class="fas fa-clock"></i> <?php echo $theTime; ?></span>
                </div>
            </div>
            
        </a>
    </div>

    <?php }
    
    wp_reset_postdata(); ?>

    </div>
</div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".eventSwiper", {
    spaceBetween: 10,
    slidesPerView: 1,
    autoplay: {
        delay: 3500,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        1200: {
            slidesPerView: 4,
            spaceBetween: 40,
            loop: true,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
        },
        600: {
            slidesPerView: 2,
            spaceBetween: 20,
            loop: true,
        }
    }
    });
    $(".eventSwiper").hover(function() {
        (this).swiper.autoplay.stop();
    }, function() {
        (this).swiper.autoplay.start();
    });
</script>