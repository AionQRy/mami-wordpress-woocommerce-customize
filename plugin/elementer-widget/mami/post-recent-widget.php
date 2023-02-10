<?php
namespace Elementor;

class recent_customer extends Widget_Base {

    public function get_name() {
		return 'recent_customer';
	}

	public function get_title() {
		return __( 'Recent Customer' );
	}

	public function get_icon() {
		return 'eicon-post-list';
    }


   public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_enqueue_style( 'post-recent-widget', plugin_dir_url( __DIR__  ) . '../css/mami/post-recent-widget.css','1.1.0');
  }

   public function get_style_depends() {
    //  wp_register_style( 'post-recent-widget', plugin_dir_url( __DIR__  ) . 'css/mami/post-recent-widget.css','1.1.0');
     return [ 'post-recent-widget' ];
   }




	protected function _register_controls() {
		$mine = array();
    $categories = get_categories(array(
			'orderby'   => 'name',
			'order'     => 'ASC'
		));

		foreach ($categories as $category ) {
	     $mine[$category->term_id] = $category->name;
		}

			$this->start_controls_section(
				'content_section',
				[
					'label' => __( 'Content', 'post-plus' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

      $this->add_control(
        'open_lightbox',
        [
          'type' => \Elementor\Controls_Manager::SELECT,
          'label' => esc_html__( 'Style', 'yp-core' ),
          'options' => [
            'card' => esc_html__( 'Card', 'yp-core' ),
            'full' => esc_html__( 'Full', 'yp-core' ),
          ],
          'card' => 'Card',
        ]
      );

        // Post categories.
		$this->add_control(
			'category',
			[
        'label' => '<i class="fa fa-folder"></i> ' . __( 'Category', 'yp-core' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => 'none',
        'options'   => $mine,
				'multiple' => false,
			]
		);

    $this->add_control(
        'per_posts',
        [
          'label' => __( 'Posts Per Page', 'yp-core' ),
          'type' => \Elementor\Controls_Manager::TEXT,
          'default' => __( '5', 'yp-core' ),
          'placeholder' => __( 'เช่น 5', 'yp-core' ),
        ]
      );

      $this->add_control(
          'post_offset',
          [
            'label' => __( 'Offset', 'yp-core' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( '', 'yp-core' ),
            'placeholder' => __( 'เช่น 1', 'yp-core' ),
          ]
        );
      
        $this->add_responsive_control(
          'column',
          [
            'type' => \Elementor\Controls_Manager::TEXT,
            'label' => esc_html__( 'Column', 'yp-core' ),
  
            'devices' => [ 'desktop', 'tablet', 'mobile' ],
            'desktop_default' => 1,
            'tablet_default' => 3,
            'mobile_default' => 2,
          ]
        );

        $this->end_controls_section();
		}

	protected function render() {
    $settings = $this->get_settings_for_display();
    $offset = $settings['post_offset'];
    if ($offet == '') {
      $offet = 0;
    }
    $num_posts = $settings['num_posts'];
    if ($num_posts == '') {
        $num_posts = 1;
    }
    $cat_x = $settings['category'];
    if ($cat_x == '') {
        $cat_x = 0;
    }
    $style = $settings['open_lightbox'];
    $column_desktop = $settings['column'];
    $column_tablet = $settings['column_tablet'];
    $column_mobile = $settings['column_mobile'];
    ?>
    <div class="main-post_grid main-post_grid_v1">
    </div>
    <?php
    $args = array(
    'post_type' => array( 'post'),
    'tax_query'         => array(
           array(
               'taxonomy'  => 'category',
               'field'     => 'term_id',
               'terms'     => $cat_x
           )
         ),
    'posts_per_page'  => $settings['per_posts'],
    'offset'    => $offset,
    'orderby'    => 'date',
    'order'    => 'DESC'
    );
    query_posts( $args );
    ?>


    <div class="vc_posts card style-1 v1 post_grid <?php if($style == 'full'): echo 'full-card'; endif;?> card-a">
        <div class="vc_posts-wrapper <?php echo $c_class; ?>" style="grid-template-columns: repeat(<?php echo $column_desktop; ?>, 1fr);">
      <?php if ( have_posts()) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
          <?php $term = get_the_terms(get_the_ID(), 'category'); ?>

                <article id="card-post_<?php echo get_the_ID(); ?>" class="card-post_blog">
                <div class="croped-box">
                <div class="featured-croped">
    <a href="<?php the_permalink(); ?>">
      <div class="in-croped">
        <div class="divide-obj"></div>
    <?php if(has_post_thumbnail()) { the_post_thumbnail();} else { echo '<img src="' . esc_url( get_stylesheet_directory_uri()) .'/img/thumb.png" alt="'. get_the_title() .'" />'; }?>
      </div>
    </a>
  </div>
                </div>

  <div class="vcps-info">
      <div class="term-box">
      <ul class="nav-sub-term-yp">
            <?php
            if( $term ):
            $i = 0;
            foreach ( $term as $term_id ) {
            $i++;
            $slug = $term_id->slug;
            // if($slug == 'uncategorized'){ continue; }
                if($i <= 3):
                ?>
                <li class="<?php echo $term_id->slug; ?>"><?php echo $term_id->name; ?></li>
                <?php
                endif;
            } 
        else: 
            ?>
            <li class="none-cat"><?php echo esc_html__( 'ไม่มีหมวดหมู่', 'yp-core' ); ?></li>
            <?php
        endif;?>
        </ul>
      </div>
      <div class="title-box">
        <h3 class="vc-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>
      </div>

    <div class="p_excerpt">
      <?php the_excerpt(); ?>
    </div>

    <div class="grid-info">
        <a class="vc-view-more" href="<?php echo get_permalink( get_the_ID() ); ?>">
            <?php echo esc_html__( 'More', 'yp-core' ); ?>
            <svg xmlns=" http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
        </a>
    </div>
  </div>
</article>


        <?php endwhile; ?>
        <?php endif; ?>
        <?php wp_reset_query(); ?>


      </div>

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
                            );
                            query_posts( $args_relate );
                            // The Loop
                             if ( have_posts()) : 
                                ?>
                                 <div class="slider-related-posts">
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
    </div>
    
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

    <style>
/*ipad*/
@media (max-width: 1024px){
  .post_grid.card-a .vc_posts-wrapper {
    grid-template-columns: repeat(<?php echo $column_tablet; ?>, 1fr) !important;
}
}
/*iphone8 (smartphone)*/
@media (max-width: 575.98px) {
  .post_grid.card-a .vc_posts-wrapper {
    grid-template-columns: repeat(<?php echo $column_mobile; ?>, 1fr) !important;
}
}
/*iphone5 (small smartphone)*/
@media (max-width: 360px) {
}
 </style>
		<?php
    }

	protected function _content_template() {}


}
