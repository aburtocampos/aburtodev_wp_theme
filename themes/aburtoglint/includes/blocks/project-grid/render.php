<?php
if (!defined('ABSPATH')) exit;

$atts = wp_parse_args($attributes, [
  'itemsToShow' => 6,
  'postType' => 'project',
  'category' => '',
  'linkTitle' => true,
  'linkImage' => true,
]);

$paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;

$args = [
  'post_type' => $atts['postType'],
  'posts_per_page' => $atts['itemsToShow'],
  'paged' => $paged,
];

if (!empty($atts['category'])) {
  $args['tax_query'] = [[
    'taxonomy' => $atts['postType'] . '_category',
    'field'    => 'term_id',
    'terms'    => intval($atts['category']),
  ]];
}

$query = new WP_Query($args);

if ($query->have_posts()) {
  echo '<div class="project-grid container">';
  while ($query->have_posts()) {
    $query->the_post();
    $url = get_post_meta(get_the_ID(), '_project_url_site', true);
    $link = esc_url($url ?: get_permalink());

      echo '<div class="project-grid-item">';

      if (has_post_thumbnail()) {
        echo $atts['linkImage'] ? '<a href="' . $link . '">' : '';
        the_post_thumbnail('full');
        echo $atts['linkImage'] ? '</a>' : '';
      }

      echo $atts['linkTitle']
        ? '<h3 class="linkTitle"><a href="' . $link . '">' . get_the_title() . '</a></h3>'
        : '<h3 class="linkTitle">' . get_the_title() . '</h3>';

    //  the_excerpt();
      echo '</div>';
  }
  echo '</div>'; // end .project-grid

  $total_pages = $query->max_num_pages;

  if ($total_pages > 1) {
    echo '<div class="project-grid-pagination" 
      data-total="' . esc_attr($total_pages) . '" 
      data-page="' . esc_attr($paged) . '" 
      data-posttype="' . esc_attr($atts['postType']) . '" 
      data-items="' . esc_attr($atts['itemsToShow']) . '" 
      data-category="' . esc_attr($atts['category']) . '">';

    if ($paged > 1) {
      echo '<button class="grid-prev">Before</button>';
    }

    if ($paged < $total_pages) {
      echo '<button class="grid-next">Next</button>';
    }

    echo '</div>';
  }

  wp_reset_postdata();
} else {
  echo '<p>No items found.</p>';
}
