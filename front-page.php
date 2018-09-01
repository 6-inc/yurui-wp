<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

get_header();

$container   = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
    <?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

    <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

        <div class="row">

            <?php
                $args = array(
                    'category_name' => '未分類',
                    'posts_per_page' => -1,
                    );
                $frontposts = new WP_Query( $args );
                $count = 0;
                if( $frontposts->have_posts() ): ?>
                <h2>未分類の記事はこちら</h2>
                <ul class="col-12">
                    <?php while ( $frontposts->have_posts() ) : $frontposts->the_post(); ?>
                        <li>
                            <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
                        </li>
                        <?php $count += 1; ?>
                    <?php endwhile; ?>
                </ul>
                <?php endif;
                wp_reset_postdata(); ?>

            <!-- Do the left sidebar check and opens the primary div -->
            <?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

            <main class="site-main" id="main">

                <?php if ( have_posts() ) : ?>
                    <div class="row">
                        
                    
                        <?php /* Start the Loop */ ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <article <?php post_class(array( 'col-md-4' )); ?> id="post-<?php the_ID(); ?>">

                                <header class="entry-header">

                                    <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
                                    '</a></h2>' ); ?>

                                    <?php if ( 'post' == get_post_type() ) : ?>

                                        <div class="entry-meta">
                                            <?php understrap_posted_on(); ?>
                                        </div><!-- .entry-meta -->

                                    <?php endif; ?>

                                </header><!-- .entry-header -->

                                <?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

                                <div class="entry-content">

                                    <?php
                                    the_excerpt();
                                    ?>

                                    <?php
                                    wp_link_pages( array(
                                        'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
                                        'after'  => '</div>',
                                    ) );
                                    ?>

                                </div><!-- .entry-content -->

                                <footer class="entry-footer">

                                    <?php understrap_entry_footer(); ?>

                                </footer><!-- .entry-footer -->

                            </article><!-- #post-## -->


                        <?php endwhile; ?>

                    <?php else : ?>

                        <?php get_template_part( 'loop-templates/content', 'none' ); ?>
                    
                    </div>
                <?php endif; ?>

            </main><!-- #main -->

            <!-- The pagination component -->
            <?php understrap_pagination(); ?>

        <!-- Do the right sidebar check -->
        <?php get_template_part( 'global-templates/right-sidebar-check' ); ?>
        

    </div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
