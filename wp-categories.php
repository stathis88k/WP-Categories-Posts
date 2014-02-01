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
     
      //specify the shortcode and the function that it will be used
      add_shortcode('wp-categories','listPosts');
      
      //create the method
      function listPosts($attr){
          /* Turn on the output buffering
            We use this so the output of the shortcode will appear in the place we want.
            Without this the output of the function will appear always on the top of the content
            Alternatively you can return the content of the method as a string */
          ob_start();
          
          //Extract the variables given in the short code so we can use them as independent variables
          extract($attr);
          
          //This line is used so we can display the posts in multiple pages if 
          //they are more than a specific number we define in the nest line
          $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
          
          //get the posts from the category we asked.
          //Set also how many posts you want to display in one page
          query_posts("cat=$cat&posts_per_page=10&paged=$page");
          
          if (have_posts()) :
          while (have_posts()) : the_post();  
          
          /* 
          The following part inside the while loop is how you are going to display each post on the list
          This is up to what you want to display and how. Here I give a basic example of what I did.
          */
           ?>
             <div class="date_title">
                  <div class="date">
                   <div class="month"><?php the_time('M') ?></div>
                      <div class="day"><?php the_time('d') ?></div>               
                   </div>                       
                  <a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
            </div>      
                      
        <?php the_excerpt();  } ?>    
            <div style="clear:both;"></div>
            <hr>
        <?php
               
          // end the while loop
        
         endwhile;
                
         //Add the navigation buttons if the posts are more than one page
       ?>
            
       <div class="navigation"><p><?php posts_nav_link('&#8734;','Next &raquo;&raquo;',' &laquo;&laquo; Previous'); ?></p></div>
      <?php
          //do something else if the category has no posts
          else : ?>
      <?php endif; ?>

     <?php
     
     // reset the query so you will not get something more. Otherwise the content of the posts will be displayed after
      wp_reset_query(); 
      
      //finally return the buffer contents and delete the output buffer
      return ob_get_clean(); 
} // end of the function
?>
