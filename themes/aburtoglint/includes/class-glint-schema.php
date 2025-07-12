<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Schema generator for Glint theme.
 *
 * Generates JSON-LD markup and prints it in the <head>.
 */
class Glint_Schema {

    /**
     * Register public hooks via Glint_Loader.
     *
     * @param Glint_Loader $loader Loader instance from main theme class.
     */
    public function register( Glint_Loader $loader ) : void {
        // Print schema in <head>. Priority 20 → after Yoast/RankMath if present.
        $loader->add_action( 'wp_head', $this, 'output_schema', 20 );
    }

    /**
     * Builds a JSON-LD graph and echoes it.
     */
    public function output_schema() : void {
        // --- 1. Core organization data (you could pull this from Customizer options) ---
        $organization = [
            '@type' => 'Organization',
            '@id'   => get_home_url() . '#organization',
            'name'  => get_bloginfo( 'name' ),
            'url'   => get_home_url(),
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => get_theme_file_uri( 'public/images/mylogo.webp' ),
            ],
        ];

        // --- 2. Core website data -----------------------------------------------------
        $website = [
            '@type'         => 'WebSite',
            '@id'           => get_home_url() . '#website',
            'url'           => get_home_url(),
            'name'          => get_bloginfo( 'name' ),
            'publisher'     => [ '@id' => $organization['@id'] ],
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => get_home_url( '/?s={search_term_string}' ),
                'query-input' => 'required name=search_term_string',
            ],
        ];

        // --- 3. Merge graph and print -------------------------------------------------
        $graph = [
            '@context' => 'https://schema.org',
            '@graph'   => [ $organization, $website ],
        ];

        echo '<script type="application/ld+json">' . wp_json_encode( $graph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . PHP_EOL;
    }
}
