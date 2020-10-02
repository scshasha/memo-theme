<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Memo
 * @since Memo 1.0
 */

get_header();
?>

    
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="row mb-5">
        <div class="col-md-8">
            <h1 class="page-title title"><?php the_title(); ?></h1>
        </div>
        <div class="col-md-4">
            <?php // get_search_form() ?>
        </div>
    </div>

    <div class="row mb-5">
    </div>

    <div class="row mt-5">

        
        <?php
            if ( have_posts() )
            {
                while( have_posts() )
                {
                    the_post();
                    the_content();
                }
            }
        ?>
    </div>
</main>
<?php get_footer(); ?>