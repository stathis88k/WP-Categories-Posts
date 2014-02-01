<?php /*
      Plugin Name: WP Categories
      Version: 0.1
      Description: Display posts of a specific category
      Author: Stathis Kapaniaris - CryoDev
      Author URI: http://www.ks-dev.net
      Plugin URI: wp-categories
      */
      
      /* Version check */
      global $wp_version;
      $exit_msg='WP Blazing Player requires WordPress 2.5 or newer.
      <a href="http://codex.wordpress.org/Upgrading_WordPress">Please
      update!</a>';
      
      if (version_compare($wp_version,"2.5","<"))
      {
           exit ($exit_msg);
      }
     
      add_shortcode('wp-categories','listPosts');
      function listPosts($attr){
          ob_start();
          extract($attr);
          $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
          query_posts("cat=$cat&posts_per_page=10&paged=$page");
          if (have_posts()) :
          while (have_posts()) : the_post();  ?>
               
                    <div class="date_title">
                        <div class="date_back">
                            <div class="month"><?php the_time('M') ?></div>
                            <div class="day"><?php the_time('d') ?></div>               
                        </div>                       
                        <h2><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                    </div>      
                      
        <?php if ( has_post_thumbnail() ) {
            $mypostimage = the_post_thumbnail( 'eventthumb', array('class' => 'eventthumb' , 'alt' => get_the_title() , 'title' => get_the_title() ));
            the_excerpt();} else { echo'<a href="'.get_permalink().'">'.category_image($post->ID,'medium').'</a>';
            the_excerpt();  } ?>    
            <div style="clear:both;"></div>
            <hr><br><br>
                
               <?php
                endwhile;?>
                <div class="navigation"><p><?php posts_nav_link('&#8734;','Next &raquo;&raquo;',' &laquo;&laquo; Previous'); ?></p></div>
                <?php else : ?>
            <?php endif; ?>
                
                
                
            
     <?php wp_reset_query(); return ob_get_clean(); } ?>
