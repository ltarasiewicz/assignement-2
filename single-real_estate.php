<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
                                ?>
                                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                            <header class="entry-header">
                                                    <?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) ) : ?>
                                                    <div class="entry-meta">
                                                            <span class="cat-links"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'twentyfourteen' ) ); ?></span>
                                                    </div>
                                                    <?php
                                                            endif;

                                                            if ( is_single() ) :
                                                                    the_title( '<h1 class="entry-title">', '</h1>' );
                                                            else :
                                                                    the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
                                                            endif;
                                                    ?>

                                                    <div class="entry-meta">
                                                            <?php
                                                                    if ( 'post' == get_post_type() )
                                                                            twentyfourteen_posted_on();

                                                                    if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
                                                            ?>
                                                            <?php
                                                                    endif;

                                                                    edit_post_link( __( 'Edit', 'twentyfourteen' ), '<span class="edit-link">', '</span>' );
                                                            ?>
                                                    </div><!-- .entry-meta -->
                                            </header><!-- .entry-header -->

                                            <?php if ( is_search() ) : ?>
                                            <div class="entry-summary">
                                                    <?php the_excerpt(); ?>
                                            </div><!-- .entry-summary -->
                                            <?php else : ?>
                                            <div class="entry-content">
                                                <link rel="stylesheet" type="text/css" href="wp-content/plugins/RealEstateSB/style.css">
                                                <link rel="stylesheet" type="text/css" href="wp-content/plugins/RealEstateSB/lightbox/css/lightbox.css">
                                                <script language="javascript" type="text/javascript" src="wp-content/plugins/RealEstateSB/lightbox/js/lightbox.js"></script>

                                                <?php
                                                //echo "<pre>"; var_dump($wpdb); echo '</pre>';
                                                $price = get_post_meta( get_the_ID(), "real_estate_price", true);
                                                echo "<p>Cena: " . $price . "zł</p>";
                                                
                                                $area = get_post_meta( get_the_ID(), "real_estate_area", true);
                                                echo "<p>Metraż: " . $area . "m<sup>2</sup></p>";
                                                
                                                $address = get_post_meta( get_the_ID(), "real_estate_address", true);
                                                echo "<p>Adres: " . $address . "</p>";
                                                
                                                the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyfourteen' ) );
                                                
                                                
                                                if(file_exists("wp-content/plugins/MyRealEstatePlugin/uploads/". get_the_ID() ."/"))
                                                {
                                                    $folder=opendir("wp-content/plugins/MyRealEstatePlugin/uploads/". get_the_ID() ."/");
                                                    $i = 0;
                                                    while (false !== ($file = readdir($folder))) 
                                                    {
                                                        if (($file !=".")&&($file !=".."))
                                                        { 
                                                            $temp = explode(".", $file);
                                                            echo '<div class="picture-box" id="'.$temp[0].'">';
                                                            echo '<a href="wp-content/plugins/MyRealEstatePlugin/uploads/'. get_the_ID() .'/'.$file.'" data-lightbox="'.$temp[0].'" >
                                                                <img src="wp-content/plugins/MyRealEstatePlugin/uploads/'. get_the_ID() .'/'.$file.'">
                                                                </a><br>';
                                                            ?>  
                                                                </div> <?php
                                                        }
                                                        $i++;
                                                    }
                                                    closedir($folder);
                                                }
                                                                                                                                              
                                                ?>
                                            </div><!-- .entry-content -->
                                            <?php endif; ?>

                                            <?php the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' ); ?>
                                    </article><!-- #post-## --><?php
                                        
                                        
                                        
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
