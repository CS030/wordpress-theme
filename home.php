<?php
/**
 * Custom Blog homepage
 */

/**
 * Add filters if user is logged in
 */
if (is_user_logged_in()) {

	global $wp_query;

	$modifications = array();

	if (!empty($_GET['cat'])) {

		$cat_id = get_field('news_category', 'option');

		if (get_cat_ID($_GET['cat'])) {
			$cat_id = get_cat_ID($_GET['cat']);
		}

		$modifications['category__in'] = $cat_id;
		$args = array_merge($wp_query->query_vars, $modifications);
		query_posts($args);
	}

	add_action( 'beans_main_prepend_markup', 'cs_add_filters' );
}

function cs_add_filters() {

	$categories = get_categories(array(
		'child_of' => get_field('news_category', 'option')
	));
?>
	<div class="uk-container uk-container-center">
		<div class="filter">
			<span class="filter__label">Filter artikelen op: </span>
			<ul class="filter__nav uk-subnav uk-subnav-pill" id="filters">
				<li class="filter__nav-item <?php echo !isset($_GET['cat'])?'uk-active':''; ?>"><a href="?">Alles</a></li>
				<?php foreach($categories as $category) : ?>
					<li class="filter__nav-item <?php echo ($_GET['cat'] === $category->slug)?'uk-active':''; ?>"><a href="?cat=<?php echo $category->slug ?>"><?php echo $category->name ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<hr>
	</div>
<?php
}

beans_load_document();
