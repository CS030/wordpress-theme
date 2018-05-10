<?php

// Enqueue UIkit components.
add_action( 'beans_uikit_enqueue_scripts', 'example_view_enqueue_uikit_assets' );

function example_view_enqueue_uikit_assets() {
	// Enqueue cover and slidshow UIkit components used in the slideshow section.
	beans_uikit_enqueue_components( array( 'cover' ) );
	beans_uikit_enqueue_components( array( 'slideshow' ), 'add-ons' );
}

// remove main content
//beans_remove_markup( 'theme_content' );
beans_remove_action('beans_content_template');
beans_remove_action('beans_fixed_wrap[_main]');

// Add the subheader slider.
add_action( 'beans_header_append_markup', 'example_view_subheader_slider' );

function example_view_subheader_slider() {
	?>
	<section class="uk-slidenav-position" data-uk-slideshow="{autoplay:true, height: 320, kenburns:true}">
		<ul class="uk-slideshow uk-overlay-active">
			<li>
				<img src="<?=get_stylesheet_directory_uri()?>/assets/images/header_image_1.jpg">
			</li>
			<li>
				<img src="<?=get_stylesheet_directory_uri()?>/assets/images/header_image_2.jpg">
			</li>
		</ul>
	</section>
	<?php
}


// Add the subheader custom static content.
add_action( 'beans_main_append_markup', 'example_view_subheader_content' );

function example_view_subheader_content() {
	global $post;

	$cat_id = get_cat_ID('Nieuws');

	$posts = get_posts(
		array(
			'posts_per_page' => 3,
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'terms' => array($cat_id),
					'field' => 'term_id',
					'include_children' => is_user_logged_in() ? true : false
				)
			)
		)
	);
?>
<div class="uk-container uk-container-center">
	<div class="uk-grid uk-grid-large">

		<div class="uk-width-large-1-3">
			<div class="uk-panel uk-panel-header">
				<h3 class="uk-panel-title">Laatste nieuws</h3>
				<?php foreach ($posts as $post) : setup_postdata($post); //begin The Loop ?>
					<article class="uk-article">
					<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><h3 class=""><?php the_title(); ?></h3></a>
						<span class="uk-article-meta"><?php the_date(); ?></span>
						<?php the_excerpt(); ?>
						<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">Lees meer</a>
					</article>
				<?php endforeach; wp_reset_postdata(); ?>
			</div>
		</div>

		<div class="uk-width-large-1-3">
			<div class="uk-panel uk-panel-header">
				<h3 class="uk-panel-title">Video</h3>
				<div style="width:100%;height:0;padding-bottom:56%;position:relative;">
					<iframe src="https://giphy.com/embed/3ohs884D1B78fiNIS4" width="100%" height="100%" style="position:absolute" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
				</div>
				<p>Bekijk al onze video's op <a href="https://vimeo.com/user51613890" target="_blank">Vimeo</a></p>
			</div>
		</div>

		<div class="uk-width-large-1-3">
			<div class="uk-panel uk-panel-header">
				<h3 class="uk-panel-title">Sponsoren</h3>

				<!--
				<iframe height="160" width="100%" frameborder="0" allowtransparency="true" scrolling="no" src="https://www.strava.com/clubs/cs030/latest-rides/967dd20fefc282bc01f53764ee8c3a66e1bce83e?show_rides=false"></iframe>
				-->
			</div>
		</div>
	</div>
</div>
<div class="uk-container uk-container-center">
	<div class="uk-grid uk-grid-large">
		<div class="uk-width-large-1-1 uk-visible-large">
			<div class="uk-panel uk-panel-header">

				<h2 class="uk-panel-title">Sponsoren</h2>

				<div class="uk-flex uk-flex-middle">
					<div class="uk-width-large-1-5 uk-text-center">
						<a href=""><img src="<?=get_stylesheet_directory_uri()?>/assets/images/sponsoren/fonq.png" class="image image--sponsor"></a>
					</div>
					<div class="uk-width-large-1-5 uk-text-center">
						<a href=""><img src="<?=get_stylesheet_directory_uri()?>/assets/images/sponsoren/de-fietsenmaker.png" class="image image--sponsor"></a>
					</div>
					<div class="uk-width-large-1-5 uk-text-center">
						<a href=""><img src="<?=get_stylesheet_directory_uri()?>/assets/images/sponsoren/platformation.png" class="image image--sponsor"></a>
					</div>
					<div class="uk-width-large-1-5 uk-text-center">
						<a href=""><img src="<?=get_stylesheet_directory_uri()?>/assets/images/sponsoren/giant-store-utrecht.png" class="image image--sponsor"></a>
					</div>
					<div class="uk-width-large-1-5 uk-text-center">
						<a href=""><img src="<?=get_stylesheet_directory_uri()?>/assets/images/sponsoren/beers-and-barrels.png" class="image image--sponsor"></a>
					</div>
				</div>

			</div>
		</div>

	</div>
</div>
<?php
}


// Remove sidebar by setting the layout to content only.
beans_add_filter( 'beans_layout', 'c' );

// Load document which is always needed at the bottom of template files.
beans_load_document();
