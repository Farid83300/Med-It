<?php
/**
 * Child theme functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function oceanwp_child_enqueue_parent_style() {
	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
	$theme   = wp_get_theme( 'OceanWP' );
	$version = $theme->get( 'Version' );
	// Load the stylesheet
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'oceanwp-style' ), $version );

}
add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style' );


// Déclaration de mon fichier JavaSvript
function oceanwp_child_enqueue_custom_js() {
    // Vous pouvez définir une version personnalisée ou utiliser time() pour le développement
    $version = '1.0.0'; // Changez cette valeur lorsque vous mettez à jour votre script
    
    // Enregistrer et charger le script
    wp_enqueue_script(
        'custom-js', 
        get_stylesheet_directory_uri() . '/scripts/script.js', 
        array('jquery'), // Dépendances (jQuery dans cet exemple)
        $version, 
        true // Charge le script dans le footer (recommandé pour de meilleures performances)
    );
}
add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_custom_js' );


// Shortcode pour ajouter un bouton de contact
function contact_btn( $items, $args ) {
	$items .= '<a href="/contact" class="contact-btn">Nous contacter</a>';
	return $items;
}

add_filter( 'wp_nav_menu_items', 'contact_btn', 10, 2 );

