<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Color and Images swatches for WooCommerce products attributes
 */

if ( ! function_exists( 'woodmart_swatches_metaboxes' ) ) {
	function woodmart_swatches_metaboxes() {
		if ( ! function_exists( 'wc_get_attribute_taxonomies' ) ) {
			return;
		}
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		foreach ( $attribute_taxonomies as $key => $value ) {

			$cmb_term = XTS\Metaboxes::add_metabox(
				array(
					'id'         => 'pa_fields_' . $value->attribute_name,
					'title'      => esc_html__( 'Extra', 'woodmart' ),
					'object'     => 'term',
					'taxonomies' => array( 'pa_' . $value->attribute_name ),
				)
			);

			$cmb_term->add_section(
				array(
					'id'       => 'general',
					'name'     => esc_html__( 'General', 'woodmart' ),
					'icon'     => 'xts-i-footer',
					'priority' => 10,
				)
			);

			$cmb_term->add_field(
				array(
					'id'       => 'swatch_notice',
					'type'     => 'notice',
					'style'    => 'desc',
					'name'     => '',
					'group'    => esc_html__( 'Swatch', 'woodmart' ),
					'content'  => esc_html__( 'Choose one of the following swatch type:', 'woodmart' ),
					'section'  => 'general',
					'priority' => 5,
				)
			);

			$cmb_term->add_field(
				array(
					'id'       => 'image',
					'type'     => 'upload',
					'name'     => esc_html__( 'Image swatch', 'woodmart' ),
					'hint'     => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'image-swatch.jpg" alt="">', 'woodmart' ), true ),
					'group'    => esc_html__( 'Swatch', 'woodmart' ),
					'section'  => 'general',
					'priority' => 10,
				)
			);

			$cmb_term->add_field(
				array(
					'id'        => 'color',
					'type'      => 'color',
					'name'      => esc_html__( 'Color swatch', 'woodmart' ),
					'hint'      => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'color-swatch.jpg" alt="">', 'woodmart' ), true ),
					'group'     => esc_html__( 'Swatch', 'woodmart' ),
					'section'   => 'general',
					'data_type' => 'hex',
					'priority'  => 20,
				)
			);
			$cmb_term->add_field(
				array(
					'id'       => 'not_dropdown',
					'name'     => esc_html__( 'Text swatch', 'woodmart' ),
					'hint'     => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'text-swatch.jpg" alt="">', 'woodmart' ), true ),
					'group'    => esc_html__( 'Swatch', 'woodmart' ),
					'section'  => 'general',
					'type'     => 'checkbox',
					'priority' => 30,
				)
			);
		}
	}

	add_action( 'init', 'woodmart_swatches_metaboxes', 10 );
}

if ( ! function_exists( 'woodmart_product_attributes_thumbnail' ) ) {
	function woodmart_product_attributes_thumbnail( $columns ) {
		if ( ! function_exists( 'wc_get_attribute_taxonomies' ) ) {
			return;
		}

		foreach ( wc_get_attribute_taxonomies() as $value ) {
			add_filter( 'manage_edit-pa_' . $value->attribute_name . '_columns', 'woodmart_product_attributes_add_thumbnail_column' );
			add_filter( 'manage_pa_' . $value->attribute_name . '_custom_column', 'woodmart_product_attributes_thumbnail_column_content', 10, 3 );
		}
	}

	add_filter( 'admin_init', 'woodmart_product_attributes_thumbnail' );
}

if ( ! function_exists( 'woodmart_product_attributes_add_thumbnail_column' ) ) {
	function woodmart_product_attributes_add_thumbnail_column( $columns ) {
		unset( $columns['cb'] );
		unset( $columns['name'] );

		$new_columns = array(
			'cb'          => '<input type="checkbox" />',
			'name'        => esc_html__( 'Name', 'woodmart' ),
			'thumbnail'   => esc_html__( 'Preview', 'woodmart' ),
		);

		$columns = $new_columns + $columns;
		return $columns;
	}
}

if ( ! function_exists( 'woodmart_product_attributes_thumbnail_column_content' ) ) {
	function woodmart_product_attributes_thumbnail_column_content( $content, $column_name, $term_id ) {
		if ( 'thumbnail' === $column_name ) {
			$color = get_term_meta( $term_id, 'color', true );
			$image = get_term_meta( $term_id, 'image', true );
			$not_dropdown = get_term_meta( $term_id, 'not_dropdown', true );
			$term_name = get_term( $term_id )->name;

			if ( is_array( $image ) && isset( $image['id'] ) ) {
				$image = wp_get_attachment_image_url( $image['id'], 'full' );
			}

			if ( $image ) {
				?>
					<div class="wd-attr-peview wd-img">
						<img src="<?php echo esc_attr( $image ); ?>">
					</div>
				<?php
			} elseif ( $color ) {
				?>
					<div class="wd-attr-peview wd-bg" style="background-color:<?php echo esc_attr( $color ); ?>;"></div>
				<?php
			} elseif ( $not_dropdown ) {
				?>
				<div class="wd-attr-peview wd-text">
					<span><?php echo esc_attr( $term_name ); ?>
				</div>
				<?php
			}
		}

		return $content;
	}
}

if ( ! function_exists( 'woodmart_has_swatches' ) ) {
	function woodmart_has_swatches( $id, $attr_name, $options, $available_variations, $swatches_use_variation_images = false ) {
		$swatches = array();

		foreach ( $options as $key => $value ) {
			$swatch = woodmart_has_swatch( $id, $attr_name, $value );

			if ( ! empty( $swatch ) ) {

				if ( $available_variations && $swatches_use_variation_images && woodmart_grid_swatches_attribute() == $attr_name ) {

					$variation = woodmart_get_option_variations( $attr_name, $available_variations, $value );

					$swatch = array_merge( $swatch, $variation );
				}

				$swatches[ $key ] = $swatch;
			}
		}

		return $swatches;
	}
}

if ( ! function_exists( 'woodmart_has_swatch' ) ) {
	function woodmart_has_swatch( $id, $attr_name, $value ) {
		$swatches = array();

		$color = $image = $not_dropdown = '';

		$term = get_term_by( 'slug', $value, $attr_name );
		if ( is_object( $term ) ) {
			$color        = get_term_meta( $term->term_id, 'color', true );
			$image        = get_term_meta( $term->term_id, 'image', true );
			$not_dropdown = get_term_meta( $term->term_id, 'not_dropdown', true );
		}

		if ( $color != '' ) {
			$swatches['color'] = $color;
		}

		if ( $image && ! is_array( $image ) || ! empty( $image['id'] ) ) {
			$swatches['image'] = $image;
		}

		if ( $not_dropdown != '' ) {
			$swatches['not_dropdown'] = $not_dropdown;
		}

		return $swatches;
	}
}

if ( ! function_exists( 'woodmart_get_option_variations' ) ) {
	function woodmart_get_option_variations( $attribute_name, $available_variations, $option = false, $product_id = false ) {
		$swatches_to_show = array();
		$product_image_id = get_post_thumbnail_id( $product_id );

		foreach ( $available_variations as $key => $variation ) {
			$option_variation = array();
			$attr_key         = 'attribute_' . $attribute_name;
			if ( ! isset( $variation['attributes'][ $attr_key ] ) ) {
				return;
			}

			$val = $variation['attributes'][ $attr_key ]; // red green black ..

			if ( ! empty( $variation['image']['src'] ) ) {
				$option_variation = array(
					'variation_id' => $variation['variation_id'],
					'is_in_stock'  => $variation['is_in_stock'],
					'image_src'  => $variation['image']['src'],
					'image_srcset'  => $variation['image']['srcset'],
					'image_sizes'  => $variation['image']['sizes'],
				);
			}

			// Get only one variation by attribute option value
			if ( $option ) {
				if ( $val != $option ) {
					continue;
				} else {
					return $option_variation;
				}
			} else {
				// Or get all variations with swatches to show by attribute name
				$swatch                   = woodmart_has_swatch( $product_id, $attribute_name, $val );
				$swatches_to_show[ $val ] = array_merge( $swatch, $option_variation );

			}
		}

		return $swatches_to_show;

	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Show attribute swatches list
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_swatches_list' ) ) {
	function woodmart_swatches_list( $attribute_name = false ) {
		global $product;

		$id = $product->get_id();

		if ( empty( $id ) || ! $product->is_type( 'variable' ) ) {
			return false;
		}

		if ( ! $attribute_name ) {
			$attribute_name = woodmart_grid_swatches_attribute();
		}

		if ( empty( $attribute_name ) ) {
			return false;
		}

		// Swatches cache
		$cache          = apply_filters( 'woodmart_swatches_cache', true );
		$transient_name = 'woodmart_swatches_cache_' . $id;

		if ( $cache ) {
			$available_variations = get_transient( $transient_name );
		} else {
			$available_variations = array();
		}

		if ( ! $available_variations ) {
			$available_variations = $product->get_available_variations();
			if ( $cache ) {
				set_transient( $transient_name, $available_variations, apply_filters( 'woodmart_swatches_cache_time', WEEK_IN_SECONDS ) );
			}
		}

		if ( empty( $available_variations ) ) {
			return false;
		}

		$swatches_to_show = woodmart_get_option_variations( $attribute_name, $available_variations, false, $id );

		if ( empty( $swatches_to_show ) ) {
			return false;
		}
		$out           = '';
		$wrapper_class = '';

		$swatch_size      = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_size' );
		$swatch_style     = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_style' );
		$swatch_dis_style = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_dis_style' );
		$swatch_shape     = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_shape' );

		if ( ! $swatch_size ) {
			$swatch_size = 'default';
		}

		if ( ! $swatch_style ) {
			$swatch_style = '1';
		}

		if ( ! $swatch_dis_style ) {
			$swatch_dis_style = '1';
		}

		if ( ! $swatch_shape ) {
			$swatch_shape = 'round';
		}

		woodmart_enqueue_inline_style( 'woo-mod-swatches-style-' . $swatch_style );
		woodmart_enqueue_inline_style( 'woo-mod-swatches-dis-' . $swatch_dis_style );

		$wrapper_class .= ' wd-bg-style-' . $swatch_style;
		$wrapper_class .= ' wd-text-style-' . $swatch_style;
		$wrapper_class .= ' wd-dis-style-' . $swatch_dis_style;
		$wrapper_class .= ' wd-size-' . $swatch_size;
		$wrapper_class .= ' wd-shape-' . $swatch_shape;
		$wrapper_class .= woodmart_get_old_classes( ' swatches-on-grid' );

		$out .= '<div class="wd-swatches-grid wd-swatches-product' . esc_attr( $wrapper_class ) . '">';

		if ( apply_filters( 'woodmart_swatches_on_grid_right_order', true ) ) {
			$terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'slugs' ) );

			$swatches_to_show_tmp = $swatches_to_show;

			$swatches_to_show = array();

			foreach ( $terms as $id => $slug ) {
				// Fixed php notice
				if ( ! isset( $swatches_to_show_tmp[ $slug ] ) ) {
					continue;
				}
				$swatches_to_show[ $slug ] = $swatches_to_show_tmp[ $slug ];
			}
		}
		
		$index = 0;

		foreach ( $swatches_to_show as $key => $swatch ) {
			$style = '';
			$class = '';
			$image = '';

			$swatch_limit = woodmart_get_opt( 'swatches_limit_count' );
			if ( woodmart_get_opt( 'swatches_limit' ) && count( $swatches_to_show ) > (int) $swatch_limit ) {
				if ( $index >= $swatch_limit ) {
					$class .= ' wd-hidden';
				}
				if ( $index === (int) $swatch_limit ) {
					woodmart_enqueue_inline_style( 'woo-opt-limit-swatches' );
					woodmart_enqueue_js_script( 'swatches-limit' );
					$out .= '<div class="wd-swatch-divider">+' . ( count( $swatches_to_show ) - (int) $swatch_limit ) . '</div>';
				}
			}

			$index++;

			if ( ! empty( $swatch['color'] ) ) {
				$style  = 'background-color:' . $swatch['color'];
				$class .= ' wd-bg';
				$class .= woodmart_get_old_classes( ' swatch-with-bg' );
			} elseif ( woodmart_get_opt( 'swatches_use_variation_images' ) && isset( $swatch['image_src'] ) ) {
				$image = wp_get_attachment_image( get_post_thumbnail_id( $swatch['variation_id'] ), 'woocommerce_thumbnail' );
				if ( ! empty( $image ) ) {
					$class .= ' wd-bg';
					$class .= woodmart_get_old_classes( ' swatch-with-bg' );
				}
			} elseif ( ! empty( $swatch['image'] ) && ! is_array( $swatch['image'] ) || ! empty( $swatch['image']['id'] ) ) {
				if ( isset( $swatch['image']['id'] ) ) {
					$image = wp_get_attachment_image( $swatch['image']['id'], 'full' );
				} else {
					$image = '<img src="' . $swatch['image'] . '" alt="' . esc_attr__( 'Swatch image', 'woodmart' ) . '">';
				}

				$class .= ' wd-bg';
				$class .= woodmart_get_old_classes( ' swatch-with-bg' );
			} else {
				$class .= ' wd-text';
				$class .= woodmart_get_old_classes( ' text-only' );
			}

			$data = '';

			if ( isset( $swatch['image_src'] ) ) {
				$data  .= 'data-image-src="' . $swatch['image_src'] . '"';
				$data  .= ' data-image-srcset="' . $swatch['image_srcset'] . '"';
				$data  .= ' data-image-sizes="' . $swatch['image_sizes'] . '"';

				if ( ! $swatch['is_in_stock'] ) {
					$class .= ' variation-out-of-stock';
				}
			}

			if ( in_array( $swatch_size, array( 'default', 'large', 'xlarge' ), true ) ) {
				$class .= woodmart_get_old_classes( ' swatch-size-' . $swatch_size );
			}

			$class .= woodmart_get_old_classes( ' woodmart-swatch swatch-on-grid' );

			$term = get_term_by( 'slug', $key, $attribute_name );

			woodmart_enqueue_js_script( 'swatches-on-grid' );

			ob_start();
			?>
			<div class="wd-swatch wd-tooltip<?php echo esc_attr( $class ); ?>" <?php echo wp_kses( $data, true ); ?>>
				<?php if ( $style || $image ) : ?>
					<span class="wd-swatch-bg" style="<?php echo esc_attr( $style ); ?>">
						<?php if ( $image ) : ?>
							<?php echo wp_kses( $image, true ); ?>
						<?php endif; ?>
					</span>
				<?php endif; ?>
				<span class="wd-swatch-text">
					<?php echo wp_kses( $term->name, true ); ?>
				</span>
			</div>
			<?php

			$out .= ob_get_clean();
		}

		$out .= '</div>';

		return $out;

	}
}

if ( ! function_exists( 'woodmart_clear_swatches_cache_save_post' ) ) {
	function woodmart_clear_swatches_cache_save_post( $post_id ) {
		if ( ! apply_filters( 'woodmart_swatches_cache', true ) ) {
			return;
		}

		$transient_name = 'woodmart_swatches_cache_' . $post_id;

		delete_transient( $transient_name );
	}

	add_action( 'save_post', 'woodmart_clear_swatches_cache_save_post' );
}

if ( ! function_exists( 'woodmart_clear_swatches_cache_on_product_object_save' ) ) {
	function woodmart_clear_swatches_cache_on_product_object_save( $data ) {
		if ( ! apply_filters( 'woodmart_swatches_cache', true ) ) {
			return;
		}
		$post_id = $data->get_id();
		$transient_name = 'woodmart_swatches_cache_' . $post_id;
		delete_transient( $transient_name );
	}

	add_action( 'woocommerce_after_product_object_save', 'woodmart_clear_swatches_cache_on_product_object_save' );
}

if ( ! function_exists( 'woodmart_get_active_variations' ) ) {
	function woodmart_get_active_variations( $attribute_name, $available_variations ) {
		$results = array();

		if ( ! $available_variations ) {
			return $results;
		}

		foreach ( $available_variations as $variation ) {
			$attr_key = 'attribute_' . $attribute_name;
			if ( isset( $variation['attributes'][ $attr_key ] ) ) {
				$results[] = $variation['attributes'][ $attr_key ];
			}
		}

		return $results;
	}
}
