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
                            <h2><?php single_cat_title(); ?></h2>
                        </div>
                    </div>
                    <div class="column-2">

                    </div>
                </div>   
                <div class="grid-column grid-banner">
                    <div class="column-1">
                    <?php
                        $args = array(
                        'post_type' => array( 'post'),
                        'posts_per_page'  => 1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field'    => 'term_id',
                                'terms'    => get_queried_object_id(),
                            ),
                        ),
                        'orderby'    => 'rand',
                        'order'    => 'DESC'
                        );
                        query_posts( $args );
                        ?>
                         <?php if ( have_posts()) : ?>
                            <?php while ( have_posts() ) : the_post(); ?>
                            <?php $term = get_the_terms(get_the_ID(), 'category');
                                get_template_part( 'template-parts/content','card');
                            endwhile; ?>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
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
                        if ( have_posts() ) : ?>
                        <div class="project-wrapper taxonomy-post_project_catgory">
                        <?php
                        while ( have_posts() ) :
                            the_post();

                            /*
                            * Include the Post-Type-specific template for the content.
                            * If you want to override this in a child theme, then include a file
                            * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                            */
                                get_template_part( 'template-parts/content','card');

                        endwhile;
                        ?>
                        </div>
                        <?php
                        wp_reset_postdata();
                        seed_posts_navigation();
                        ?>
                        <?php else: ?>
                            <?php get_template_part( 'template-parts/content','none');?>
                        <?php endif; ?>
                    </div>
                    <div class="column-2">
                        <h3 class="h-c2"><?php echo esc_html__( 'LASTEST', 'woodmart-child'  ); ?></h3>
                        <div class="post-list_archive vc_posts card style-1 v1 post_grid two-column-c">
                        <?php
                        $args2 = array(
                        'post_type' => array( 'post'),
                        'posts_per_page'  => 5,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field'    => 'term_id',
                                'terms'    => get_queried_object_id(),
                            ),
                        ),
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
                        <a href="<?php echo get_home_url(); ?>/lifestyle/" class="btn-green-bor"><?php echo esc_html__( 'See More', 'woodmart-child'  ); ?></a>
                    </div>
                </div>      
            
                </div>
            </div>
        </div>
    </main><!-- #main -->
<?php
get_footer();
