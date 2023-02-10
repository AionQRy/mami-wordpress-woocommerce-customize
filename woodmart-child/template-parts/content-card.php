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