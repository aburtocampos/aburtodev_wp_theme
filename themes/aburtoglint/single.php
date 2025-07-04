<?php get_header(); ?>

<main class="single-page container">

    <?php if (have_posts()) { while (have_posts()) { the_post(); ?>

        <article id="post-<?php the_ID(); ?>" class="single-post">

            <header class="single-post-header">
                <div class="inner">
                    <a href="/blog/" title="back" class="btnback">
                        <svg fill="#000000" width="800px" height="800px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid">
                            <path d="M16.000,32.000 C7.178,32.000 -0.000,24.822 -0.000,16.000 C-0.000,7.178 7.178,-0.000 16.000,-0.000 C24.822,-0.000 32.000,7.178 32.000,16.000 C32.000,24.822 24.822,32.000 16.000,32.000 ZM16.000,2.000 C8.280,2.000 2.000,8.280 2.000,16.000 C2.000,23.720 8.280,30.000 16.000,30.000 C23.720,30.000 30.000,23.720 30.000,16.000 C30.000,8.280 23.720,2.000 16.000,2.000 ZM23.000,17.000 L11.414,17.000 L13.707,19.293 C14.098,19.684 14.098,20.316 13.707,20.707 C13.512,20.902 13.256,21.000 13.000,21.000 C12.744,21.000 12.488,20.902 12.293,20.707 L8.293,16.707 C8.201,16.615 8.128,16.505 8.077,16.382 C7.976,16.138 7.976,15.862 8.077,15.618 C8.128,15.495 8.201,15.385 8.293,15.293 L12.293,11.293 C12.684,10.902 13.316,10.902 13.707,11.293 C14.098,11.684 14.098,12.316 13.707,12.707 L11.414,15.000 L23.000,15.000 C23.552,15.000 24.000,15.448 24.000,16.000 C24.000,16.552 23.552,17.000 23.000,17.000 Z"/>
                        </svg>
                </a>
                <h1 class="single-post-title"><?php the_title(); ?></h1>
                </div>
                 
                <p class="single-post-date"><?php echo get_the_date(); ?></p>
            </header>

            <?php if (has_post_thumbnail()) { ?>
               <!-- <div class="single-post-thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </div> -->
            <?php } ?>

            <div class="single-post-content">
                <?php the_content(); ?>
            </div>

        </article>

    <?php } } else { ?>

        <p class="no-content"><?php _e('Sorry, nothing found.', 'glint'); ?></p>

    <?php } ?>

</main>

<?php get_footer(); ?>
