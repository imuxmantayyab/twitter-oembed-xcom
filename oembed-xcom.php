<?php
/**
 * Plugin Name: Twitter oEmbed-xcom
 * Plugin URI: https://example.com/plugins/the-basics/
 * Description: Handle the Twitter card using X.com with this plugin.
 * Version: 1.10.3
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: Muhammad Usman Tayyab
 * Author URI: https://author.example.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI: https://example.com/my-plugin/
 * Text Domain: my-basics-plugin
 * Domain Path: /tocom
 */

function twitter_embed_replacer_handler($matches, $attr, $url, $rawattr) {

    $twitter_url = str_replace('https://x.com', 'https://twitter.com', $url);

    $twitter_response = wp_safe_remote_get('https://publish.twitter.com/oembed?url=' . $twitter_url);
    
    if (!is_wp_error($twitter_response)) {
        $response_code = wp_remote_retrieve_response_code($twitter_response);
        if (200 === $response_code) {
            $twitter_data = wp_remote_retrieve_body($twitter_response);
            $decoded = json_decode($twitter_data);
            return $decoded->html;
        } else {
            return "Oops!Facing an error in fetching the oEmbed data from the modified Twitter URL";
        }
    }
    return "Oops!Facing an error in fetching the oEmbed data from the modified Twitter URL";
}

wp_embed_register_handler('twitter_embed_replacer', '#https?://x\.com/.*#i', 'twitter_embed_replacer_handler');
