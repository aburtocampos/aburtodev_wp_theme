<?php get_header(); ?>

<div class="blog-page">
    <div class="blog-page-header">
        <div class="container flex-center flex-column h-100 text-center inner">
            <h1 class="blog-page-title">Blog</h1>
        </div>
    </div>

    <section class="blog-page-body">
        <div class="container inner">
            
            <!-- Search Form -->
            <form class="search-form" role="search" method="get" onsubmit="return false;">
                <input type="search" class="search-field" placeholder="Search…" name="s">
                <button type="submit" class="search-submit">Search</button>
            </form>

            <!-- Post results container -->
            <div id="posts-container" class="posts-container" >
                <!-- Posts will load here via AJAX -->
            </div>

            <!-- Pagination buttons container -->
            <div id="pagination" class="pagination"></div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
