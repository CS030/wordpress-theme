<?php
/*
// Enqueue UIkit components.
add_action( 'beans_uikit_enqueue_scripts', 'example_view_enqueue_uikit_assets' );

function example_view_enqueue_uikit_assets() {
	// Enqueue cover and slidshow UIkit components used in the slideshow section.
	beans_uikit_enqueue_components( array( 'cover' ) );
	beans_uikit_enqueue_components( array( 'slideshow' ), 'add-ons' );
}

// remove main content
*/
//beans_remove_markup( 'theme_content' );
beans_remove_action('beans_content_template');
beans_remove_action('beans_fixed_wrap[_main]');

/*
// Add the subheader slider.
add_action( 'beans_main_append_markup', 'example_view_subheader_slider' );

function example_view_subheader_slider() {
	?>
	<div class="uk-slidenav-position" data-uk-slideshow="{autoplay:true}">
		<ul class="uk-slideshow">
			<li><img src="https://getuikit.com/docs/images/placeholder_800x400_1.jpg"></li>
			<li><img src="https://getuikit.com/docs/images/placeholder_800x400_2.jpg"></li>
			<li><img src="https://getuikit.com/docs/images/placeholder_800x400_3.jpg"></li>
		</ul>
		<a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
		<a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
		<ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-center">
			<li data-uk-slideshow-item="0"><a href=""></a></li>
			<li data-uk-slideshow-item="1"><a href=""></a></li>
			<li data-uk-slideshow-item="2"><a href=""></a></li>
		</ul>
	</div>
	<?php
}
*/

// Add the subheader custom static content.
add_action( 'beans_main_append_markup', 'example_view_subheader_content' );

function example_view_subheader_content() {
	global $post;
	$posts = get_posts( array( 'posts_per_page' => 3 ) );
	//print_r($posts);
?>
<div class="uk-container uk-container-center">
	<div class="uk-grid uk-grid-large">
		<div class="uk-width-large-1-3">
			<div class="uk-panel uk-panel-header">
				<h3 class="uk-panel-title">Strava</h3>

				[Widget of iets anders]
				<!--
				<iframe src="https://www.strava.com/clubs/cs030/latest-rides/967dd20fefc282bc01f53764ee8c3a66e1bce83e?show_rides=true" width="300" height="454" frameborder="0" scrolling="no"></iframe>
				-->
			</div>
		</div>
		<div class="uk-width-large-1-3">
			<div class="uk-panel uk-panel-header">
				<h3 class="uk-panel-title">Laatste blog posts</h3>
				<?php foreach ($posts as $post) : setup_postdata($post); //begin The Loop ?>
					<article class="uk-article">
						<h3 class=""><?php the_title(); ?></h3>
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
	</div>
</div>
<?php
}


// Remove sidebar by setting the layout to content only.
beans_add_filter( 'beans_layout', 'c' );

// Load document which is always needed at the bottom of template files.
beans_load_document();
