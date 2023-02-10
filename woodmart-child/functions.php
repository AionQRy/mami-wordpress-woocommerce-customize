<?php
/**
 * Enqueue script and styles for child theme
 */
function woodmart_child_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'woodmart-style' ), woodmart_get_theme_info( 'Version' ) );
	// wp_enqueue_style( 'icon-font-style', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/fontawesome.min.css', true );
}
add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_styles', 10010 );

function my_theme_enqueue_styles() {

    $parent_style = 'woodmart';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'primary-style',
        get_stylesheet_directory_uri() . '/css/main-style.css',
        array( $parent_style ),
        wp_get_theme()->get('1.0.0')
    );
	wp_enqueue_script( 'berry-slickjs', get_stylesheet_directory_uri() . '/js/main.js', array(), true );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles', 999 );

function seed_posts_navigation() {
	printf('<div class="content-pagination">');
	global $paged, $wp_query; $big = 9999999;
	if ( !$max_page ):
			$max_page = $wp_query->max_num_pages;
	endif;
	?>
	<span class="text-number_page"><?php esc_html_e( 'หน้า', 'fluffy' ); ?> <?php echo max( 1, get_query_var('paged') );?> <?php esc_html_e( 'จาก', 'fluffy' ); ?> <?php echo $wp_query->max_num_pages; ?></span>
	<?php
	echo '<div class="box-pagination">';
	echo paginate_links(
		array(
				'base' 		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' 	=> '?paged=%#%',
				'current'	=> max( 1, get_query_var('paged') ),
				'total' 	=> $wp_query->max_num_pages,
				'prev_text'  => '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="15 18 9 12 15 6"></polyline></svg>',
				'next_text'  => '<svg viewBox="0 0 24 24" width="24" height="24" stroke="#0074bc" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="9 18 15 12 9 6"></polyline></svg>',
		));
	echo '</div>';
	if( $paged != $max_page ):
		if( $max_page > 1 ):
	?>
	<a href="<?php echo esc_url( get_pagenum_link( $wp_query->max_num_pages ) ); ?>" class="last-number_page"><?php esc_html_e( 'หน้าสุดท้าย', 'fluffy' ); ?></a>
	<?php
		endif;
	endif;
	printf('</div>');
}


add_action( 'woocommerce_product_meta_end' , 'custom_tab', 5 );

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

}

function custom_tab() {
  global $product;
  $benefit = get_field('benefit', $product->ID);
  $ingredients = get_field('ingredients', $product->ID);
  $faq = get_field('faq', $product->ID);
  $shipping_return = get_field('shipping_return', $product->ID);
  $filter = get_page_by_path( $filter_slug, OBJECT, 'search-filter-widget' );

  if ( function_exists( 'pll_the_languages' ) ) {
	if (get_locale() == 'th') {
	  $url_fq = '/frequently-asked-questions/';
	  $url_shp = '/refund_returns/';
	}
	if (get_locale() != 'en') {
	  $url_fq = '/frequently-asked-questions/';
	  $url_shp = '/refund_returns/';
	}
  }
  else {
	$filter_id = $filter->ID;
  }
  ?>
  <div class="tab-custom_tab">
	<div class="tab-custom_title">
		<div class="tab-list" data-tab-target="#benefit"><?php esc_html_e('Benefit','woodmart-child'); ?></div>
		<div class="tab-list" data-tab-target="#ingredients"><?php esc_html_e('Ingredients','woodmart-child'); ?></div>
	</div>
	<div class="tab-custom_detail">
		<div id="benefit" class="list-detail" data-tab-content>
			<?php if($benefit):?>
				<?php echo $benefit; ?>
			<?php else: ?>
				<?php esc_html_e('ไม่มีข้อมูล','woodmart-child'); ?>
			<?php endif; ?>
		</div>
		<div id="ingredients" class="list-detail" data-tab-content>
			<?php if($ingredients):?>
				<?php echo $ingredients; ?>
			<?php else: ?>
				<?php esc_html_e('ไม่มีข้อมูล','woodmart-child'); ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="link-faqs link-ex">
		<div id="btn-faqs" class="btn-link-faqs" data-tab-tg="#link-faqs">
		<div class="div-bar">
				<?php esc_html_e('FAQs','woodmart-child'); ?>
				<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1 plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
				<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1 minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
			</div>
			<div id="link-faqs" class="detail-link-faqs" data-tab-tgcontent>
			<?php if($faq):?>
				<?php echo $faq; ?>
			<?php else: ?>
				<?php esc_html_e('ไม่มีข้อมูล','woodmart-child'); ?>
			<?php endif; ?>
		</div>
		</div>
	</div>
	<div class="link-faqs link-shipping">
		<div id="btn-shipping" class="btn-link-shipping" data-tab-tg="#link-shipping">
			<div class="div-bar">
				<?php esc_html_e('Shipping & Return','woodmart-child'); ?>
				<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1 plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
				<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1 minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
			</div>
			<div id="link-shipping" class="detail-link-shipping" data-tab-tgcontent>
			<?php if($shipping_return):?>
				<?php echo $shipping_return; ?>
			<?php else: ?>
				<?php esc_html_e('ไม่มีข้อมูล','woodmart-child'); ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
  </div>

  <script>
	jQuery(document).ready(function($) {

		const tabs = document.querySelectorAll('[data-tab-tg]')
		const tabContents = document.querySelectorAll('[data-tab-tgcontent]')

		tabs.forEach(tab => {
		tab.addEventListener('click', () => {
			const target = document.querySelector(tab.dataset.tabTarget)
			tabContents.forEach(tabContent => {
			tabContent.classList.remove('active')
			})
			tabs.forEach(tab => {
			tab.classList.remove('active')
			})
			tab.classList.add('active')
			target.classList.add('active')
		})
		})

		});

  </script>
  <?php
}

/**
 * Change number of related products output
 */
function woo_related_products_limit() {
	global $product;

	  $args['posts_per_page'] = 3;
	  return $args;
  }
  add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
	function jk_related_products_args( $args ) {
	  $args['posts_per_page'] = 3; // 4 related products
	  $args['columns'] = 3; // arranged in 2 columns
	  return $args;
  }


  function polylang_dropdown() {
  	if ( ! function_exists( 'pll_the_languages' ) ) return;

  	  // Gets the pll_the_languages() raw code
  	  $languages = pll_the_languages( array(
  	    'display_names_as'       => 'name',
  	    'hide_if_no_translation' => 0,
  			'show_flags' => 1,
  	    'raw'                    => true
  	  ) );
  		// print_r($languages);

  	  // $output = '';

  	  // Checks if the $languages is not empty
  	  if ( ! empty( $languages ) ) {

  	    // Creates the $output variable with languages container
  	  ?>
      <div class="languages-yp">

      <?php

  	    // Runs the loop through all languages

         foreach ( $languages as $language ) {
           $id             = $language['id'];
           $name           = $language['name'];
           $url            = $language['url'];
           $current        = $language['current_lang'] ? ' languages__item--current' : '';
           $no_translation = $language['no_translation'];
           ?>
           <?php if ($current): ?>
              <!-- <img src="<php echo YP_DIRECTORY_URL.'/assets/img/'.$language['slug']; ?>.svg" alt="<php echo $name; ?>"> -->
               <div class="list_lang">

               <?php
                foreach ( $languages as $language ) {

                     // Variables containing language data
                     $id             = $language['id'];
                     $name           = $language['name'];
                     $url            = $language['url'];
                     $current        = $language['current_lang'] ? ' languages__item--current' : '';
                     $no_translation = $language['no_translation'];

                         ?>

                         <a href="<?php echo $url; ?>" class="languages__item <?php echo $current; ?>">
                           <?php echo $language['flag']; ?>
                         </a>
                         <?php
                   }
                  ?>

                </div>
           <?php endif; ?>
           <?php } ?>
        </div>

  <?php
  }
  	  // return $output;
  }

  add_shortcode( 'polylang_dropdown', 'polylang_dropdown' );
