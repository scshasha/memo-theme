<?php
/**
 * Template Name: Courses Layout
 * 
 * 
 */
get_header(); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="row mb-5">
        <div class="col-md-9">
            <h1 class="page-title"><?php echo the_title(); ?></h1>
        </div>
        <div class="col-md-3">
            <?php echo do_shortcode( '[memo_course_filter_search_form category="course" course_status="all" per_page="3" pagination="on"]' ); ?>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12 course-status">
            <span class="mr-5<?php echo (!isset($_GET['course_status']) || $_GET['course_status'] === 'all') ? ' active':''; ?>">
                <a href="?course_status=all" class="">All</a>
            </span>
            <span class="mr-5<?php echo (isset($_GET) && isset($_GET['course_status']) && $_GET['course_status'] === 'current') ? ' active':''; ?>">
                <a href="?course_status=current" class="">Current</a>
            </span>
            <span class="mr-5<?php echo (isset($_GET) && isset($_GET['course_status']) && $_GET['course_status'] === 'pending') ? ' active':''; ?>">
                <a href="?course_status=pending" class="">Pending</a>
            </span>
            <span class="mr-0<?php echo (isset($_GET) && isset($_GET['course_status']) && $_GET['course_status'] === 'completed') ? ' active':''; ?>">
                <a href="?course_status=completed" class="">Completed</a>
            </span>
        </div>
    </div>
    <div id="search_response_wrapper">
        <?php echo do_shortcode('[cademy_course_block]'); ?>
    </div>
</main>
<?php get_footer(); ?>