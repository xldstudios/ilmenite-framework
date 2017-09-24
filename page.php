<?php
/**
 * Displays Page
 **/
namespace BernskioldMedia\ClientName\Theme;

get_header(); ?>

<main class="main" role="main">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'components/page/content-page' ); ?>

		<?php endwhile; ?>

	<?php endif; ?>

	<?php get_sidebar(); ?>

</main>

<?php get_footer(); ?>
