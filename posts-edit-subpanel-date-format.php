<?php

/*
Plugin Name: Posts Edit SubPanel Date Format
Plugin URI: http://www.vizteck.com/blog/2010/06/17/wordpress-plugin-contribution-by-vizteck/
Description: Posts/Pages Edit SubPanel Date Format synchronize the wordpress date format with date format in date column of posts edit subpanel.
Version: 2.0
Author: Vizteck Solutions
Author URI: http://www.vizteck.com

Copyright (C) 2010 vizteck.com (khurramfraz AT gmail DOT com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.

*/


add_filter('manage_posts_columns', 'custom_manage_custom_columns');
add_action('manage_posts_custom_column', 'custom_manage_custom_column', 10, 2);

add_filter('manage_pages_columns', 'custom_manage_custom_columns');
add_action('manage_pages_custom_column', 'custom_manage_custom_column', 10, 2);

function custom_manage_custom_columns($defaults) {
    $defaults = array_change_key_name( 'date', 'date_new',$defaults );
    return $defaults;
}

function custom_manage_custom_column($column_name, $post_id) {
    global $wpdb;
    $post_type = get_post_type($post_id);

    if( $column_name == 'date_new' ) {
        $query = "SELECT post_status FROM $wpdb->posts ".
                "WHERE post_type='$post_type' ".
                "AND ID='$post_id'";
        $p = $wpdb->get_results($query);
        the_time(get_option('date_format', 'd/m/Y'));
        echo '<br>';
        $post_stati  = array(	//	array( adj, noun )
                'publish' => __('Published'),
                'future' => __('Scheduled'),
                'pending' => __('Pending Review'),
                'draft' => __('Draft'),
                'private' => __('Private'),
                'trash' => __('Trash')
        );
        echo $post_stati[$p[0]->post_status];
    }
}

function array_change_key_name( $orig, $new, &$array )
{
  foreach ( $array as $k => $v )
  $return[ ( $k === $orig ) ? $new : $k ] = $v;
  return ( array ) $return;
}
?>
