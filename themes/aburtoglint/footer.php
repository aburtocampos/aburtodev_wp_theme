<footer class="footer ">
   <div class="prefooter container">
      
            <div class="col-left">
               <h3>Let’s Build Something Great Together</h3>
            </div>
            <div class="col-right">
               <a href="https://wa.me/+50588503574">Contact me</a>
			   <a href="mailto:info@aburto.dev">Email me</a>
            </div>

   </div>
    <div class="foo">
       <h4>Web Designer and Developer</h4>
        <?php
                wp_nav_menu([
                  'theme_location' => 'footer_menu',
                  'menu_class' => 'menu-navigation',
                  'container' => false,
                  'fallback_cb' => false,
                  'items_wrap' => '<ul class="%2$s">%3$s</ul>'
               ]);
              ?>
    </div>
  
    <div class="contain">
       <p>Copyright © 2025 Aburto | All rights reserved.</p> 
    </div>
</footer>

<?php wp_footer(); ?>
</body  >
</html>