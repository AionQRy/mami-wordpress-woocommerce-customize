<?php
namespace Elementor;

class recent_post_nocat extends Widget_Base {

    public function get_name() {
		return 'recent_post_nocat';
	}

	public function get_title() {
		return __( 'Recent Post No Category' );
	}

	public function get_icon() {
		return 'eicon-post-list';
    }


  //  public function __construct($data = [], $args = null)
  // {
  //   parent::__construct($data, $args);
  //   wp_enqueue_style( 'post-recent-widget', plugin_dir_url( __DIR__  ) . '../css/mami/post-recent-widget.css','1.1.0');
  // }

//    public function get_style_depends() {
//     //  wp_register_style( 'post-recent-widget', plugin_dir_url( __DIR__  ) . 'css/mami/post-recent-widget.css','1.1.0');
//      return [ 'post-recent-widget' ];
//    }
    public function get_style_depends() {
    wp_register_style( 'post-recent-widget', plugin_dir_url( __DIR__  ) . '/css/mami/post-recent-widget.css','1.1.0');
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


        $this->end_controls_section();
		}

	protected function render() {
    $settings = $this->get_settings_for_display();
    $offset = $settings['post_offset'];
    if ($offet == '') {
      $offet = 0;
    }
    ?>
    <div class="main-post_grid main-post_grid_v1">
    </div>
    <?php
    $args = array(
    'post_type' => array( 'post'),
    'posts_per_page'  => $settings['per_posts'],
    'offset'    => $offset,
    'orderby'    => 'date',
    'order'    => 'DESC'
    );
    query_posts( $args );
    ?>


    <div class="vc_posts card style-1 v1 post_grid two-column-c">
        <div class="vc_posts-wrapper">
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
    </div>

		<?php
    }

	protected function _content_template() {}


}
