<?php
/**
 * Template Functions
 *
 * These template functions are small functions to include various
 * types of template code in the theme, abstracted and re-usable.
 */
namespace BernskioldMedia\Ilmenite_Theme;

class Template_Functions {

	/**
	 * Pagination
	 *
	 * @param  boolean $arrows Display arrows
	 * @param  boolean $ends
	 * @param  integer $pages  How many pages to show
	 * @return void
	 */
	public function pagination( $arrows = true, $ends = true, $pages = 2 ) {

        if ( is_singular() )
        	return;

        global $wp_query, $paged;

        $pagination = '';

        $max_page = $wp_query->max_num_pages;

        if ( $max_page == 1 )
        	return;

        if ( empty( $paged ) )
        	$paged = 1;

        if ( $arrows )
        	$pagination .= $this->pagination_link( $paged - 1, 'arrow' . ( ( $paged <= 1 ) ? ' unavailable' : '' ), '&laquo;', __( 'Previous Page', 'ilmenite' ) );

        if ( $ends && $paged > $pages + 1 )
        	$pagination .= $this->pagination_link( 1 );

        if ( $ends && $paged > $pages + 2 )
        	$pagination .= $this->pagination_link( 1, 'unavailable', '&hellip;' );

        for ( $i = $paged - $pages; $i <= $paged + $pages; $i++ ) {

            if ( $i > 0 && $i <= $max_page )
                $pagination .= $this->pagination_link( $i, ( $i == $paged ) ? 'current' : '' );

        }
        if ( $ends && $paged < $max_page - $pages - 1 )
        	$pagination .= $this->pagination_link( $max_page, 'unavailable', '&hellip;' );

        if ( $ends && $paged < $max_page - $pages )
        	$pagination .= $this->pagination_link( $max_page );

        if ( $arrows )
        	$pagination .= $this->pagination_link( $paged + 1, 'arrow' . ( ( $paged >= $max_page ) ? ' unavailable' : '' ), '&raquo;', __( 'Next Page', 'ilmenite' ) );

        $pagination = '<ul class="pagination">' . $pagination . '</ul>';
        $pagination = '<div class="pagination-centered">' . $pagination . '</div>';

        echo $pagination;
    }

    /**
     * Pagination Link
     *
     * Creates the special pagination link that is then used in the
     * main pagination function above.
     */
    public function pagination_link( $page, $class = '', $content = '', $title = '' ) {

        $id = sanitize_title_with_dashes( 'pagination-page-' . $page . ' ' . $class );

        $href = ( strrpos( $class, 'unavailable' ) === false && strrpos( $class, 'current' ) === false ) ? get_pagenum_link( $page ) : "#$id";

        $class = empty( $class ) ? $class : " class=\"$class\"";
        $content = ! empty( $content ) ? $content : $page;
        $title = ! empty( $title ) ? $title : sprintf( __( 'Page %s', 'ilmenite' ), $page );

        return "<li$class><a id=\"$id\" href=\"$href\" title=\"$title\">$content</a></li>\n";
    }

    /**
     * Get Text Excerpt
     *
     * Gets an excerpt of a provided text, or the post excerpt if
     * none is provided. The amount of chars are set in the function.
     *
     * @param  integer $limit Amount of words to allow
     * @param  string  $text  Text to truncate
     * @return void
     */
    public function get_excerpt( $limit = 50, $text = false ) {

        if ( $text ) {
            $excerpt = explode(' ', $text, $limit);
        } else {

        	global $post;

            $excerpt = explode(' ', get_the_excerpt(), $limit);
        }

        if ( count( $excerpt ) >= $limit ) {
        	array_pop( $excerpt );
            $excerpt = implode( " ", $excerpt ) . '...';
        } else {
            $excerpt = implode( " ", $excerpt );
        }

        $excerpt = strip_tags( preg_replace( '`\[[^\]]*\]`', '', $excerpt ) );

        return $excerpt;

    }

}