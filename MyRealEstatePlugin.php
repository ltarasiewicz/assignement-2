<?php

/**
 * Plugin Name: My Real Estate Plugin
 * Description: A plugin that helps real estate agencies handle their business
 * Version: 0.0.1
 * Author: Łukasz Tarasiewicz
 * Licence: GPL2
 */

add_action('admin_init', 'add_real_estate_metaboxes');
add_action('init', 'add_houses_taxonomy');
add_action('init', 'add_real_estate_post_type');
add_action('save_post', 'save_real_estate');
add_action('post_edit_form_tag', 'add_enctype');
add_action('single_template', 'real_estate_single_template');
add_action('wp_enqueue_scripts', 'enqueue_uploader_scripts');

register_taxonomy_for_object_type('houses', 'real_estate');

add_shortcode('real_estate_form', 'show_real_estate_form');

function enqueue_uploader_scripts() {  
    wp_enqueue_style('uploadfile_min_css', plugins_url(null, __FILE__) . '/uploader/css/uploadfile.min.css');
    wp_enqueue_script('jQuery-local', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
    wp_enqueue_script('uploader_script', plugins_url(null, __FILE__) . '/uploader/js/jquery.uploadfile.min.js');
}


function show_real_estate_form() {
    $uid = 'temp_' . uniqid();
    ?>

    <script>
        
        jQuery(document).ready(function() {
            jQuery('#fileuploader').uploadFile({
                url:"YOUR_FILE_UPLOAD_URL",
                fileName:"myfile"
            }); //end uploadFile       
        }); //end ready          
    </script>
    
    <form id="ajax_form">
        <table>
            <tr>
                <td> Tytuł:</td>
                <td><input type="text" size="60" name="real_estate_title" /></td>              
            </tr>       
            <tr>
                <td> Cena:</td>
                <td><input type="text" size="60" name="real_estate_price" /></td>              
            </tr>
            <tr>
                <td> Metraż:</td>
                <td><input type="text" size="60" name="real_estate_area" /></td>              
            </tr>
            <tr>
                <td> Adres:</td>
                <td><input type="text" size="60" name="real_estate_address" /></td>              
            </tr>
            <tr>
                <td> Opis:</td>
                <td><textarea name="real_estate_description" form="ajax_form"></textarea></td>
            </tr>
            <tr>
                <td> Zdjęcia:</td>
                <td>
                    <div id="fileuploader">Upload</div>
                </td>
            </tr>  
        </table>
        <input id="res" class="button" type="submit" name="res" value="Wyślij"/>
    </form>
    
    <?php
}

function real_estate_single_template($single_template) {
    if (get_post_type() == 'real_estate') {
        $single_template = dirname(__FILE__) . '/single-real_estate.php';
    }
    return $single_template;
}

function add_enctype() {
    echo ' enctype="multipart/form-data"';
}

function add_real_estate_metaboxes() {
    
    add_meta_box('real_estate_area', 'Metraż', 'show_real_estate_area', 'real_estate', 'normal', 'high');
    
    add_meta_box('real_estate_price', 'Cena', 'show_real_estate_price', 'real_estate', 'normal', 'high');
    
    add_meta_box('real_estate_address', 'Address', 'show_real_estate_address', 'real_estate', 'normal', 'high');
    
    add_meta_box('real_estate_picture', 'Zdjęcie', 'show_real_estate_picture', 'real_estate', 'normal', 'high');
    
    function show_real_estate_picture($real_estate) {
        
        $picture = esc_html(get_post_meta($real_estate->ID, 'real_estate_picture', true));
        
        ?>
        <table>
            <tr>             
                <td id="photo">
                    <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        $('#photo').load('../wp-content/plugins/MyRealEstatePlugin/RetrievePhotos.php?id=<?php echo $real_estate->ID; ?>');
                        
                    }) //end ready
                    </script>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="file" name="real_estate_picture[]" id="real_estate_picture" value="Dodaj zdjęcie" />
                </td>
            </tr>
        </table>
        <?php
    }
    
    function show_real_estate_address($real_estate) {
        $address = esc_html(get_post_meta($real_estate->ID, 'real_estate_address', true));
        ?>
        <table>
            <tr>
                <td><input type="text" size="80" name="real_estate_address" value="<?php echo $address; ?>" /></td>
            </tr>
        </table>
        <?php
    }
    
    function show_real_estate_price($real_estate) {
        
        $price = esc_html(get_post_meta($real_estate->ID, 'real_estate_price', true));
        ?>
        <table>
            <tr>
                <td><input type="text" size="80" name="real_estate_price" value="<?php echo $price; ?>" />m<sup>PLN</sup></td>
            </tr>
        </table>
        <?php
    }
    
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




function save_real_estate($id) {  

    if( count($_POST) && get_post_type($id) == 'real_estate' ) {
        
        $area = esc_html(get_post_meta($id, 'real_estate_area', true));
        $price = esc_html(get_post_meta($id, 'real_estate_price', true));
        $address = esc_html(get_post_meta($id, 'real_estate_address', true));

        $new_area = sanitize_text_field($_POST['real_estate_area']);
        $new_price = sanitize_text_field($_POST['real_estate_price']);  
        $new_address = sanitize_text_field($_POST['real_estate_address']);  

        update_post_meta($id, 'real_estate_area', $new_area, $area);
        update_post_meta($id, 'real_estate_price', $new_price, $price);
        update_post_meta($id, 'real_estate_address', $new_address, $address);

        $allowedExt = array('jpg', 'png', 'jpeg', 'gif');
        $picture = $_FILES['real_estate_picture']['name'];

        for($i=0; $i<count($_FILES['real_estate_picture']['name']); $i++) {

            $temp = explode('.', $_FILES['real_estate_picture']['name'][$i]);
            $extension = end($temp);
            
            //if the error code is anything but int 4 ('No file was uploaded') or 0 ('No error')          
            if($_FILES['real_estate_picture']['error'][$i]  != 4 && $_FILES['real_estate_picture']['error'][$i]  != 0) {
                var_dump($_FILES);
                exit('There is an error with the picture upload. Error code: ' . $_FILES['real_estate_picture']['error'][$i] . '</br>');

            } else {
                if ((($_FILES["real_estate_picture"]["type"][$i] == "image/gif") || 
                        ($_FILES["real_estate_picture"]["type"][$i] == "image/jpeg") || 
                        ($_FILES["real_estate_picture"]["type"][$i] == "image/jpg") || 
                        ($_FILES["real_estate_picture"]["type"][$i] == "image/pjpeg") || 
                        ($_FILES["real_estate_picture"]["type"][$i] == "image/x-png") || 
                        ($_FILES["real_estate_picture"]["type"][$i] == "image/png")) && 
                        ($_FILES["real_estate_picture"]["size"][$i] < 40000000) && in_array($extension, $allowedExt)) {

                    echo 'Upload: ' . $_FILES['real_estate_picture']['name'][$i] . '</br>';
                    echo 'Type: ' . $_FILES['real_estate_picture']['type'][$i] . '</br>';
                    echo 'Size: ' . $_FILES['real_estate_picture']['size'][$i] . '</br>';
                    echo 'Temporary name: ' . $_FILES['real_estate_picture']['tmp_name'][$i] . '</br>';

                    if(file_exists('../wp-content/plugins/MyRealEstatePlugin/uploads/' . $id . '/' . $_FILES['real_estate_picture']['name'][$i])) {
                        echo $_FILES['real_estate_picture']['name'][$i] . ' already exists.';
                    } else {
                        if( ! file_exists('../wp-content/plugins/MyRealEstatePlugin/uploads/' . $id) ) {
                            mkdir('../wp-content/plugins/MyRealEstatePlugin/uploads/' . $id, 0777, true);
                        }
                        $uniqueId = uniqid();
                        $ext = end(explode('.', $_FILES['real_estate_picture']['name'][$i]));
                        move_uploaded_file($_FILES['real_estate_picture']['tmp_name'][$i], '../wp-content/plugins/MyRealEstatePlugin/uploads/' . $id .'/' . $uniqueId . '.' . $ext);
                        echo 'Picture saved in ' . '../wp-content/plugins/MyRealEstatePlugin/uploads/' . $id .'/' . $uniqueId . '.' . $ext;
                        }             
                } else {
                    echo 'Invalid type of file';
                }                      
            }
        }
    }
}

