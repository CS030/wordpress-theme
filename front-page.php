<?php
/**
 * Custom homepage
 */

// Enqueue UIkit components.
add_action( 'beans_uikit_enqueue_scripts', 'cs_view_enqueue_uikit_assets' );

function cs_view_enqueue_uikit_assets() {
	// Enqueue cover and slidshow UIkit components used in the slideshow section.
	beans_uikit_enqueue_components( array( 'cover' ) );
	beans_uikit_enqueue_components( array( 'slideshow' ), 'add-ons' );
}

// remove main content
//beans_remove_markup( 'theme_content' );
beans_remove_action('beans_content_template');
beans_remove_action('beans_fixed_wrap[_main]');

// Add the subheader slider.
add_action( 'beans_header_append_markup', 'cs_view_subheader_slider' );

function cs_view_subheader_slider() {
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
add_action( 'beans_main_append_markup', 'cs_view_highlight' );

function cs_view_highlight() {

	$highlight = get_field('highlight');

	if (have_rows('highlight')) :
?>
<div class="uk-container uk-container-center">
	<div class="uk-grid uk-grid-large">
<?php
		while (have_rows('highlight')) : the_row();
			// same for all
			$title = get_sub_field('title');

			// Text highlight
			if( get_row_layout() == 'text' ):
				$content = get_sub_field('content');
?>
		<div class="uk-width-large-1-3">
			<div class="uk-panel uk-panel-header highlight">
				<h3 class="uk-panel-title"><?php echo $title ?></h3>
				<?php echo $content ?>
			</div>
		</div>
<?php
			endif;

			// Video highlight
			if( get_row_layout() == 'video' ):
				$vimeoId = get_sub_field('vimeo');
?>
		<div class="uk-width-large-1-3">
			<div class="uk-panel uk-panel-header highlight">
				<h3 class="uk-panel-title"><?php echo $title?></h3>
				<div style="padding:56.25% 0 0 0;position:relative;">
					<iframe src="https://player.vimeo.com/video/<?php echo $vimeoId; ?>?color=ffffff&title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				</div>

				Bekijk al onze video's op <a href="https://vimeo.com/user51613890">Vimeo</a>
				<script src="//player.vimeo.com/api/player.js"></script>
			</div>
		</div>
<?php
			endif;

			// News highlight
			if( get_row_layout() == 'news' ):
				$categoryId = get_sub_field('category');

				global $post;

				$posts = get_posts(
					array(
						'posts_per_page' => 3,
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
								'terms' => array($categoryId),
								'field' => 'term_id',
								'include_children' => is_user_logged_in() ? true : false
							)
						)
					)
				);
?>
			<div class="uk-width-large-1-3">
				<div class="uk-panel uk-panel-header highlight">
					<h3 class="uk-panel-title"><?php echo $title ?></h3>

					<div class="news">
					<?php foreach ($posts as $post) : setup_postdata($post); //begin The Loop ?>
						<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="news__item">
							<div class="news__content">
								<h3 class="news__title"><?php the_title(); ?></h3>
								<p class="news__intro"><?php echo get_the_excerpt(); ?></p>
							</div>

							<div class="news__date">
								<span class="news__date-day"><?php echo get_the_date('j'); ?></span>
								<span class="news__date-month"><?php echo get_the_date('F'); ?></span>
								<span class="news__date-year"><?php echo get_the_date('Y'); ?></span>
							</div>
						</a>
					<?php endforeach; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
<?php
		endif;
endwhile;
?>
		</div>
	</div>
<?php
	endif;
}

add_action( 'beans_main_append_markup', 'cs_view_sponsoren' );

function cs_view_sponsoren() {
	$sponsoren = get_field('sponsoren');

	if ($sponsoren) :
?>
<section class="uk-container uk-container-center">
	<div class="uk-grid uk-grid-large">
		<div class="uk-width-large-1-1">
			<div class="uk-panel uk-panel-header">

				<h2 class="uk-panel-title">Partners</h2>

				<div class="uk-grid uk-flex-middle">
<?php
		foreach( $sponsoren as $sponsor):
			$imgUrl = $sponsor["logo"]["sizes"]["medium"];
?>
					<div class="uk-width-large-1-3 uk-width-1-2 uk-text-center">
						<?php if ($sponsor["page"]) : ?><a href="<?php echo $sponsor["page"]; ?>"><?php endif; ?>
							<img src="<?php echo $imgUrl; ?>" class="image image--sponsor" alt="<?php echo $sponsor["name"]; ?>">
						<?php if ($sponsor["page"]) : ?></a><?php endif; ?>
					</div>
<?php
		endforeach;
?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
	endif;
}

add_action( 'beans_main_append_markup', 'cs_view_ledenvooredel' );

function cs_view_ledenvooredel() {
	$ledenvoordeel = get_field('ledenvoordeel');

	if ($ledenvoordeel) :
?>
<section class="uk-container uk-container-center uk-margin-large-top">
	<div class="uk-grid uk-grid-large">
		<div class="uk-width-large-1-1">
			<div class="uk-panel uk-panel-header">

				<h2 class="uk-panel-title">Ledenvoordeel</h2>

				<div class="uk-grid uk-flex-middle">
<?php
		foreach( $ledenvoordeel as $voordeel):
			$imgUrl = $voordeel["logo"]["sizes"]["medium"];
?>
					<div class="uk-width-large-1-3 uk-width-1-2 uk-text-center">
						<?php if ($voordeel["page"]) : ?><a href="<?php echo $voordeel["page"]; ?>"><?php endif; ?>
							<img src="<?php echo $imgUrl; ?>" class="image image--sponsor" alt="<?php echo $voordeel["name"]; ?>">
						<?php if ($voordeel["page"]) : ?></a><?php endif; ?>
					</div>
<?php
		endforeach;
?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
	endif;
}


// Remove sidebar by setting the layout to content only.
beans_add_filter( 'beans_layout', 'c' );

// Load document which is always needed at the bottom of template files.
beans_load_document();
