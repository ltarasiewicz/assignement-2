<?php

/**
 * Plugin Name: My Real Estate Plugin
 * Description: A plugin that helps real estate agencies handle their business
 * Version: 0.0.1
 * Author: Łukasz Tarasiewicz
 * Licence: GPL2
 */



function add_real_estate_metaboxes() {
    add_meta_box('real_estate_area', 'Metraż', 'show_real_estate_area', 'real_estate', 'normal', 'high');
    
    function show_real_estate_area($real_estate) {

        $area = esc_html(get_post_meta($real_estate->ID, 'real_estate_area', true));
        ?>
        <table>
            <tr>
                <td><input type="text" size="80" name="real_estate_area" value="<?php echo $area; ?>" />m<sup>2</sup></td>
            </tr>
        </table>
        <?php
    }    
}

add_action('admin_init', 'add_real_estate_metaboxes');

function add_houses_taxonomy() {
    
    $labels = array(
        'name'  => _x('Rodzaje nieruchomości', 'houses_domy', 'text_domain'),
        'singular_name' =>  _x('Rodzaj nieruchomości', 'houses_domy', 'text_domain'),
        'search_items'  => __('Szukaj nieruchomości', 'text_domain'),
        'popular_items' =>  __('Popularne nieruchomości', 'text_domain'),
        'all_items' =>  __('Wszystkie nieruchomości', 'text_domain'),
        'parent_item'   =>  __('Groupa', 'text_domain'),
        'parent_item_colon' =>  __('Groupa', 'text_domain'),     
        'edit_item' =>  __('Edytuj', 'text_domain'),
        'update_item'   =>  __('Zmień', 'text_domain'),
        'add_new_item'  =>  __('Dodaj nowy rodzaj', 'text_domain'),
        'new_item_name' =>  __('Nowy rodzaj', 'text_domain'),
        'add_or_remove_items'   =>  __('Dodaj lub usuń rodzaj', 'text_domain'),
        'choose_from_most_used' =>  __('Najpopularniejsze', 'text_domain'),
        'menu_name' =>  __('Radzaje', 'text_domain'),
    );
    
    $args = array(
        'public'    =>  true,
        'labels'    =>  $labels,
        'draft' => true,
        'show_in_nav_menus' => true,
        'hierarchical' => true,
        'show_tagcloud' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'show_admin_column' => false,        
    );
    
    register_taxonomy('houses', 'real_estate', $args);
}

add_action('init', 'add_houses_taxonomy');

function add_real_estate_post_type() {
    register_post_type('real_estate', array(
        'labels' => array(
            'name'  =>  'Nieruchomości',
            'add_new'   =>  'Dodaj',
            'add_new_item'  =>  'Dodaj nową nieruchomość',
            'edit_item' =>  'Edytuj nieruchomość',
            'new_item'  =>  'Nowa nieruchomość',
            'view_item' =>  'Pokaż nieruchomość',
            'search_items'  =>  'Szukaj nieruchomości',
            'not_found' =>  'Nieruchomość nie została znaleziona',
            'not_found_in_trash'    =>  'Nieruchomość nie została znaleziona w koszu',
            'parent_item_colon' =>  'Poprzednia nieruchoność',            
        ),
        'description'   =>  'Rodzaj postów do zarządzania nieruchomościami',
        'public'    =>  true,
        'menu_position' =>  20,
        'supports'  =>  array('title', 'editor', 'comments', 'thumbnail'),
        'has_archive'   =>  true,
        'show_in_nav_menus' =>  true,
        'taxonomies'    =>  array('Domy'),      
        )
    );          
}

add_action('init', 'add_real_estate_post_type');