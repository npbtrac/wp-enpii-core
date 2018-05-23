<?php
/**
 * Created by PhpStorm.
 * User: hungtran
 * Date: 4/4/16
 * Time: 3:46 PM
 */
while ( have_posts() ) : the_post();
    echo '<li>';
    the_title();
    echo '</li>';
endwhile;

// Reset Query
wp_reset_query();
?>
