<?php
/**
 * Template for displaying search forms in Memo
 *
 * @package WordPress
 * @subpackage Memo
 * @since Memo 1.0
 */

?>

<?php $unique_id = esc_attr( memo_unique_id( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group input-group-flat">
        <span class="input-group-btn">
            <button class="btn btn-default btn-sm" type="submit"><i class="fa fa-search"></i></button>
        </span>
        <input type="search" id="<?php echo $unique_id; ?>" class="form-control-sm" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'memo' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    </div>
</form>