<?php 
/*
 Plugin Name: Transport Movers Pro Posttype
 Plugin URI: https://www.buywptemplates.com/
 Description: Creating new post type for Transport Movers Pro Theme.
 Author: Buy WP Templates
 Version: 1.0
 Author URI: https://www.buywptemplates.com/
*/

define( 'TRANSPORT_MOVERS_PRO_POSTTYPE_VERSION', '1.0' );

add_action( 'init', 'transport_movers_pro_posttype_create_post_type' );

function transport_movers_pro_posttype_create_post_type() {
  register_post_type( 'faq',
  array(
    'labels' => array(
      'name' => __( 'Faq','transport-movers-pro-posttype' ),
      'singular_name' => __( 'Faq','transport-movers-pro-posttype' )
      ),
    'capability_type' => 'post',
    'menu_icon'  => 'dashicons-media-spreadsheet',
    'public' => true,
    'supports' => array(
      'title',
      'editor',
      'thumbnail'
      )
    )
  );
  register_post_type( 'testimonials',
	array(
		'labels' => array(
			'name' => __( 'Testimonials','transport-movers-pro-posttype-pro' ),
			'singular_name' => __( 'Testimonials','transport-movers-pro-posttype-pro' )
			),
		'capability_type' => 'post',
		'menu_icon'  => 'dashicons-businessman',
		'public' => true,
		'supports' => array(
			'title',
			'editor',
			'thumbnail'
			)
		)
	);
}
/* Testimonial section */
/* Adds a meta box to the Testimonial editing screen */
function transport_movers_pro_posttype_bn_testimonial_meta_box() {
	add_meta_box( 'transport-movers-pro-posttype-pro-testimonial-meta', __( 'Enter Designation', 'transport-movers-pro-posttype-pro' ), 'transport_movers_pro_posttype_bn_testimonial_meta_callback', 'testimonials', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'transport_movers_pro_posttype_bn_testimonial_meta_box');
}

/* Adds a meta box for custom post */
function transport_movers_pro_posttype_bn_testimonial_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'transport_movers_pro_posttype_testimonial_meta_nonce' );
  $bn_stored_meta = get_post_meta( $post->ID );
	$desigstory = get_post_meta( $post->ID, 'transport_movers_pro_posttype_testimonial_desigstory', true );
	?>
	<div id="testimonials_custom_stuff">
		<table id="list">
			<tbody id="the-list" data-wp-lists="list:meta">
				<tr id="meta-1">
					<td class="left">
						<?php esc_html_e( 'Designation', 'transport-movers-pro-posttype-pro' )?>
					</td>
					<td class="left" >
						<input type="text" name="transport_movers_pro_posttype_testimonial_desigstory" id="transport_movers_pro_posttype_testimonial_desigstory" value="<?php echo esc_attr( $desigstory ); ?>" />
					</td>
				</tr>
        <tr id="meta-3">
          <td class="left">
            <?php esc_html_e( 'Facebook Url', 'transport-movers-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="url" name="meta-facebookurl" id="meta-facebookurl" value="<?php echo esc_url($bn_stored_meta['meta-facebookurl'][0]); ?>" />
          </td>
        </tr>
        <tr id="meta-4">
          <td class="left">
            <?php esc_html_e( 'Linkedin URL', 'transport-movers-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="url" name="meta-linkdenurl" id="meta-linkdenurl" value="<?php echo esc_url($bn_stored_meta['meta-linkdenurl'][0]); ?>" />
          </td>
        </tr>
        <tr id="meta-5">
          <td class="left">
            <?php esc_html_e( 'Twitter Url', 'transport-movers-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="url" name="meta-twitterurl" id="meta-twitterurl" value="<?php echo esc_url( $bn_stored_meta['meta-twitterurl'][0]); ?>" />
          </td>
        </tr>
        <tr id="meta-6">
          <td class="left">
            <?php esc_html_e( 'GooglePlus URL', 'transport-movers-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="url" name="meta-googleplusurl" id="meta-googleplusurl" value="<?php echo esc_url($bn_stored_meta['meta-googleplusurl'][0]); ?>" />
          </td>
        </tr>
			</tbody>
		</table>
	</div>
	<?php
}
/* Saves the custom meta input */
function transport_movers_pro_posttype_bn_metadesig_save( $post_id ) {
	if (!isset($_POST['transport_movers_pro_posttype_testimonial_meta_nonce']) || !wp_verify_nonce($_POST['transport_movers_pro_posttype_testimonial_meta_nonce'], basename(__FILE__))) {
		return;
	}
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}
  // Save facebookurl
  if( isset( $_POST[ 'meta-facebookurl' ] ) ) {
      update_post_meta( $post_id, 'meta-facebookurl', esc_url_raw($_POST[ 'meta-facebookurl' ]) );
  }
  // Save linkdenurl
  if( isset( $_POST[ 'meta-linkdenurl' ] ) ) {
      update_post_meta( $post_id, 'meta-linkdenurl', esc_url_raw($_POST[ 'meta-linkdenurl' ]) );
  }
  if( isset( $_POST[ 'meta-twitterurl' ] ) ) {
      update_post_meta( $post_id, 'meta-twitterurl', esc_url_raw($_POST[ 'meta-twitterurl' ]) );
  }
  // Save googleplusurl
  if( isset( $_POST[ 'meta-googleplusurl' ] ) ) {
      update_post_meta( $post_id, 'meta-googleplusurl', esc_url_raw($_POST[ 'meta-googleplusurl' ]) );
  }
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	// Save desig.
	if( isset( $_POST[ 'transport_movers_pro_posttype_testimonial_desigstory' ] ) ) {
		update_post_meta( $post_id, 'transport_movers_pro_posttype_testimonial_desigstory', sanitize_text_field($_POST[ 'transport_movers_pro_posttype_testimonial_desigstory']) );
	}
}
add_action( 'save_post', 'transport_movers_pro_posttype_bn_metadesig_save' );
/* Testimonials shortcode */
function transport_movers_pro_posttype_testimonial_func( $atts ) {
	$testimonial = '';
	$testimonial = '<div class="row">';
	$query = new WP_Query( array( 'post_type' => 'testimonials') );

    if ( $query->have_posts() ) :

	$k=1;
	$new = new WP_Query('post_type=testimonials');

	while ($new->have_posts()) : $new->the_post();
        $thumb_url = '';
      	$post_id = get_the_ID();
      	$excerpt = wp_trim_words(get_the_excerpt(),25);
      	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'large' );
		    if(has_post_thumbnail()) { $thumb_url = $thumb['0']; }
      	$desigstory= get_post_meta($post_id,'transport_movers_pro_posttype_testimonial_desigstory',true);
        
        $testimonial .= '
          <div class="col-md-4 col-sm-12 text-center">
            <div class=" testimonial_box w-100 mb-3 p-3">
             <div class="image-box media">';
              if(has_post_thumbnail()){
                $testimonial .= '<img src="'.esc_url($thumb_url).'" alt="testimonial-thumbnail" />';
              }
              $testimonial .= '</div>
              <div class="content_box w-100">
                <h4 class="testimonial_name mt-0"><a href="'.get_the_permalink().'">'.get_the_title() .'</a></h4>
                <div class="short_text pt-3"><p>'.$excerpt.'</p></div>
                <div class="testimonial-box">
                  <p class="font-weight-bold">'.esc_html($desigstory).'</p>
                </div>
              </div>
            </div>
          </div>';
		if($k%3 == 0){
			$testimonial.= '<div class="clearfix"></div>';
		}
      $k++;
  endwhile;
  else :
  	$testimonial = '<h2 class="center">'.esc_html__('Post Not Found','transport-movers-pro-posttype-pro').'</h2>';
  endif;
  $testimonial .= '</div>';
  return $testimonial;
}
add_shortcode( 'testimonials', 'transport_movers_pro_posttype_testimonial_func' );
add_action( 'transport_movers_pro_posttype_plugins_loaded', 'transport_movers_pro_posttype_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function transport_movers_pro_posttype_load_textdomain() {
  load_plugin_textdomain( 'transport-movers-pro-posttype-pro', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
/* Faq shortcode */
function transport_movers_pro_faq_func( $atts ) {
  $faq = '';
  $faq = '<div id="accordion" class="row">';
  $query = new WP_Query( array( 'post_type' => 'faq') );
    if ( $query->have_posts() ) :
  $k=1;
  $new = new WP_Query('post_type=faq');

  while ($new->have_posts()) : $new->the_post();
        $post_id = get_the_ID();
        $excerpt = wp_trim_words(get_the_excerpt(),25);
        $desigstory= get_post_meta($post_id,'transport_movers_pro_posttype_testimonial_desigstory',true);
        $faq .= '<div class="panel panel-default col-md-12">
          <div class="panel-heading" role="tab" id="heading'.esc_attr($k).'">
            <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.esc_attr($k).'" aria-expanded="false" aria-controls="collapse'.esc_attr($k).'">
              '.get_the_title().'
            </a>
          </h4>
          </div>
          <div id="collapse'.esc_attr($k).'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading'.esc_attr($k).'">
            <div class="panel-body">
              <p>'.get_the_content().'</p>
            </div>
          </div>
        </div>';
    if($k%2 == 0){
      $faq.= '<div class="clearfix"></div>';
    }
      $k++;
  endwhile;
  else :
    $faq = '<h2 class="center">'.esc_html__('Post Not Found','transport-movers-pro').'</h2>';
  endif;
  $faq .= '</div>';
  return $faq;
}
add_shortcode( 'faq', 'transport_movers_pro_faq_func' );