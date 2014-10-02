<script>
    function delete(name, id)
    {
        if(confirm('Czy napewno chcesz usunąć to zdjęcie?'))
        {
            jQuery.ajax({
                type: 'POST',
                url: '../wp-content/plugins/RealEstateSB/delete_photo.php',
                data: {
                    name: id,
                    id: id                   
                },
            }); // end ajax
        }
    }
</script>

<?php
if( isset($_GET['id']) ) {
    $id = $_GET['id'];
    
    if( file_exists('uploads/' . $id . '/') ) {
        $folder = opendir('uploads/' . $id . '/');
        $i = 0;
        
        while( false !== ($file = readdir($folder)) ) {
            
            if (($file != '.') && ($file != '..')) {
                $temp = explode('.', $file);
                echo '<div class="picture-box" id="' . $temp[0] . '">';
                echo '<a href="../wp-content/plugins/MyRealEstatePlugin/uploads/'.$_GET["id"].'/'.$file.'" data-lightbox="'.$temp[0].'" >
                <img src="../wp-content/plugins/MyRealEstatePlugin/uploads/'.$_GET["id"].'/'.$file.'">
                </a><br>';
                ?>
                    <a onClick="return delete_photo(<?php echo $file; ?>, <?php echo $_GET['id']; ?>)">Usuń zdjęcie</a>
                </div>
                <?php             
            }
            $i++;
        }        
    }
    closedir($folder);
}