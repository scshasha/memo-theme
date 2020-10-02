<?php
/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Memo
 * @since Memo 1.0
 */

get_header();
?>

    
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="row mb-5">
        <div class="col-md-9">
            <h1 class="page-title title"><?php echo the_title(); ?></h1>
        </div>
        <div class="col-md-3">
            <?php get_search_form() ?>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12 course-status">
            <span class="mr-5">All</span>
            <span class="mr-5 active">Current</span>
            <span class="mr-5">Pending</span>
            <span class="mr-0">Completed</span>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <h2 class="title mb-5 muted">May</h2>
            <h5 class="strong"><a href="#" class="underline">Lorem ipsum dolor sit amet consectetur adipisicing elit.</a></h5>
            <small>May 17, 2020</small>
        </div>
        <div class="col-md-4">
            <h2 class="title mb-5 muted">Jul</h2>
            <h5 class="strong"><a href="#">Ea, voluptatem sint officiis similique expedita doloribus!</a></h5>
            <small>Jul 29, 2020</small>
        </div>
        <div class="col-md-4">
            <h2 class="title mb-5 muted">Oct</h2>
            <h5 class="strong"><a href="#">At facere ullam. Reprehenderit, pariatur?</a></h5>
            <small>Oct 10, 2020</small>
        </div>
    </div>
</main>
<?php get_footer(); ?>