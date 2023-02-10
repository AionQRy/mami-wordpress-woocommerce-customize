<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package archive
 */
get_header();
// $term_id = get_queried_object()->term_id;
?>

	<main id="primary" class="main-list main-archive-post">
        <div class="main-archive_post">
            <div class="v-container">   
                <div class="grid-column">
                    <div class="column-1">
                        <?php if ( function_exists('yoast_breadcrumb') ) {
                            yoast_breadcrumb( '<div class="box-breadcrumb"><p id="breadcrumbs">','</p></div>' );
                        } ?> 
                        <div class="title-archive">
                            <h2><?php echo get_the_title(); ?></h2>
                        </div>
                    </div>
                    <div class="column-2">

                    </div>
                </div>   
                <div class="grid-column grid-banner">
                    <div class="column-1">
                        <div class="featured-croped featurepost-img">
                            <div class="in-croped">
                                <div class="divide-obj"></div>
                            <?php if(has_post_thumbnail()) { the_post_thumbnail();} else { echo '<img src="' . esc_url( get_stylesheet_directory_uri()) .'/img/thumb.png" alt="'. get_the_title() .'" />'; }?>
                            </div>
                        </div>
                    </div>
                    <div class="column-2">
                        <?php 
                            // if (get_locale() == 'en_US') {
                            //     // drink tea
                            // }else{
                                
                            // }
                            echo do_shortcode( '[elementor-template id="10531"]' );
                            echo do_shortcode( '[elementor-template id="10534"]' );
                        ?>
                    </div>
                </div>  
                <div class="grid-column">
                    <div class="column-1">
                            <?php
                            while ( have_posts() ) :
                            the_post();
                            ?>
                            <div class="content-section_post">
                                    <?php
                                    the_content();
                                    ?>
                            </div>
                            <div class="seed-share">
                                <div class="s-title">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                                    <?php esc_html_e( 'Share', 'woodmart-child' ); ?>
                                </div>
                                <?php 
                                    if(function_exists('seed_social')) {seed_social();}
                                ?>
                            </div>

                        <?php
                            endwhile; // End of the loop.
                            ?>
                                <?php
                            $terms = get_the_terms( get_the_ID(), 'category' );
                            if ( !empty( $terms ) ){
                                $term = array_shift( $terms );
                            }
                            $args_relate = array(
                            'posts_per_page'    => 6,
                            'post_type'         => 'post',
                            'order'             => 'DESC',
                            'orderby'           => 'rand',
                            'post__not_in' => array( get_the_ID() ),
                            'tax_query'         => array(
                                array(
                                'taxonomy'  => 'category',
                                'field'     => 'slug',
                                'terms'     => array( $term->slug )
                                )
                            )
                            );
                            query_posts( $args_relate );
                            // The Loop
                             if ( have_posts()) : 
                                ?>
                            <div class="related-posts">
                                

                                <div class="vc_posts card style-1 v1 post_grid <?php if($style == 'full'): echo 'full-card'; endif;?> card-a">
                                <h3 class="h-c2"><?php echo esc_html__( 'RELATED STORIES', 'woodmart-child'  ); ?></h3>
                                    <div class="vc_posts-wrapper">
                                    <?php
                                        while ( have_posts() ) : the_post();
                                        get_template_part( 'template-parts/content','card');
                                        endwhile;
                                    ?>
                        
                                    </div>
                                </div>                     
                            </div>
                            <?php
                            endif;
                            // Reset Query
                            wp_reset_query();
                    ?>
                                    <?php
                            $terms = get_the_terms( get_the_ID(), 'category' );
                            if ( !empty( $terms ) ){
                                $term = array_shift( $terms );
                            }
                            $args_relate = array(
                            'posts_per_page'    => 6,
                            'post_type'         => 'post',
                            'order'             => 'DESC',
                            'orderby'           => 'rand',
                            'post__not_in' => array( get_the_ID() ),
                            'tax_query'         => array(
                                array(
                                'taxonomy'  => 'category',
                                'field'     => 'slug',
                                'terms'     => array( $term->slug )
                                )
                            )
                            );
                            query_posts( $args_relate );
                            // The Loop
                             if ( have_posts()) : 
                                ?>
                                 <div class="slider-related-posts">
                              <h3 class="h-c2"><?php echo esc_html__( 'RELATED STORIES', 'woodmart-child'  ); ?></h3>
                            <div class="swiper myRelated">
                                
                                    <div class="vc_posts card style-1 v1 post_grid card-a swiper-wrapper">
                                        <?php
                                            while ( have_posts() ) : the_post();
                                            echo '<div class="swiper-slide">';
                                            get_template_part( 'template-parts/content','card');
                                            echo '</div>';
                                            endwhile;
                                        ?>
                                    </div>
                                    <div class="related-pagination">
                                        <div class="related-swiper-button-next">
                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                        </div>
                                        <div class="related-swiper-button-prev">
                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                        </div>
                                    </div>
                                                  
                            </div>
                            </div>
                            <?php
                            endif;
                            // Reset Query
                            wp_reset_query();
                    ?>

                            <!-- Swiper JS -->
                            <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

                            <!-- Initialize Swiper -->
                            <script>
                            var swiper = new Swiper(".myRelated", {
                                slidesPerView: 2,
                                spaceBetween: 10,
                                navigation: {
                                    nextEl: ".related-swiper-button-next",
                                    prevEl: ".related-swiper-button-prev",
                                },
                            });
                            </script>
                   
                    </div>
                    <div class="column-2">
                        <h3 class="h-c2"><?php echo esc_html__( 'LASTEST', 'woodmart-child'  ); ?></h3>
                        <div class="post-list_archive vc_posts card style-1 v1 post_grid two-column-c">
                        <?php
                        $args2 = array(
                        'post_type' => array( 'post'),
                        'posts_per_page'  => 5,
                        'orderby'    => 'rand',
                        'order'    => 'DESC'
                        );
                        query_posts( $args2 );
                        ?>
                         <?php if ( have_posts()) : ?>
                            <?php while ( have_posts() ) : the_post(); ?>
                            <?php $term = get_the_terms(get_the_ID(), 'category');
                                get_template_part( 'template-parts/content','card');
                            endwhile; ?>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                        </div>   
                    </div>
                </div>      
            
                </div>
            </div>
        </div>
    </main><!-- #main -->
<?php
get_footer();
