<?php

/**
 * Trigger this file on Plugin uninstall
 * 
 * @package ProgScrollPlugin
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// // Clear db stored data
// $books = get_posts(array(
//     'post_type' => 'book', // custom post type created on register_post_type
//     'numberposts' => -1 // -1 = all the posts
// ));

// foreach ($books as $book) {
//     // args: post_id, force_delete
//     // force delete even if in trash or draft 
//     wp_delete_post($book->ID, true);
// }

// Accsess the database via SQL
global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'book'");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT ID FROM wp_posts)");
$wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT ID FROM wp_posts)");

