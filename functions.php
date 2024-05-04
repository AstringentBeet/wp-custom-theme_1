<?php 


//variable declations

//include statements
include(get_theme_file_path('/includes/front/enqueue.php'));
include(get_theme_file_path('/includes/front/head.php'));

//hook
//tells wordpress to run a function when a specific hook runs.
add_action('wp_enqueue_scripts', 'u_enqueue');
//the 5 indicates the priority. The default priority is 10, so the lower the number, the higher.
add_action('wp_head', 'u_head', 5);
