<?php get_header(); ?>

<article id="proyecto-<?php the_ID(); ?>" class="single-project">
    <h1><?php the_title(); ?></h1>
    <?php the_post_thumbnail(); ?>
    <div><?php the_content(); ?></div>
    <?php
$url_site = get_post_meta(get_the_ID(), '_project_url_site', true);
if ($url_site) {
    echo '<p><a href="' . esc_url($url_site) . '" target="_blank" rel="noopener noreferrer">' . __('Visit Project Site', 'glint') . '</a></p>';
}
?>

</article>

<?php get_footer(); ?>