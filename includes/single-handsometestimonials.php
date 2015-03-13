<?php
/**
 * Template Name: Testimonial Template
 *
 * The single-template for displaying a single testimonial 
 *
 * @package     handsometestimonials
 * @copyright   Copyright (c) 2014, Kevin Marshall
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 *
 */


get_header(); ?>
    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">

            <!-- The Loop -->
            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <!-- Display Testimonial Title with Thumbnail -->
                    <header class="entry-header">
                        <?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
                            <div class="entry-thumbnail">
                                <?php the_post_thumbnail(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( is_single() ) : ?>
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <?php else : ?>
                                <h1 class="entry-title">
                                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                            </h1>
                        <?php endif; // is_single() ?>
                    </header><!-- .entry-header -->
                
                    <!--Display Testimonial Meta Data-->
                    <div class="entry-meta">
                        <?php 
                            $subtitle = get_post_meta( get_the_ID(), '_subtitle_meta_value_key', true );
                            $subtitle_link = get_post_meta( get_the_ID(), '_subtitle_link_meta_value_key', true );
                            $display_subtitle_w_link = '<a href="'.$subtitle_link.'" target="blank">'.$subtitle.'</a>';
                            $testimonial_short =  get_post_meta( get_the_ID(), '_testimonialshort_meta_value_key', true ); 

                            //if subtitle_link exists, display subtitle hyperlinked
                            if ($subtitle_link != null) {
                                echo '<p><b>'.$display_subtitle_w_link.'</b></p>';
                            } else {
                                echo '<p><b>'.$subtitle.'</b></p>';
                            }

                            echo '<p>'.$testimonial_short.'</p>';
                        ?>
                    </div><!-- .entry-meta -->

                    <!--Display Long Testimonial / Case Study (*currently not enabled) -->
                    <div class="entry-content">
                        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'hndtst_loc' ) ); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'handsometestimonials' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                    </div><!-- .entry-content -->

                    <footer class="entry-meta">
                        <?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
                    </footer><!-- .entry-meta -->

                    <?php comments_template(); ?>

                </article><!-- #post -->

            <?php endwhile; ?><!-- end loop -->

        </div><!-- #content -->
    </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>