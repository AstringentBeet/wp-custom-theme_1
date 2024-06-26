<?php 


//variable declations

//include statements
include(get_theme_file_path('/includes/front/enqueue.php'));
include(get_theme_file_path('/includes/front/head.php'));
include(get_theme_file_path('/includes/setup.php'));

//hook
//tells wordpress to run a function when a specific hook runs.
add_action('wp_enqueue_scripts', 'u_enqueue');
//the 5 indicates the priority. The default priority is 10, so the lower the number, the higher.
add_action('wp_head', 'u_head', 5);

add_action('after_setup_theme', 'u_setup_theme');

add_filter( 'default_wp_template_part_areas', 'themeslug_template_part_areas' );

function themeslug_template_part_areas( array $areas ) {
	$areas[] = array(
		'area'        => 'sidebar',
		'area_tag'    => 'section',
		'label'       => __( 'Sidebar', 'themeslug' ),
		'description' => __( 'Custom description', 'themslug' ),
		'icon'        => 'sidebar'
	);

	return $areas;
}