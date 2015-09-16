<?php
/**
 * Footer code and content
 *
 * @package Opti
 */
?>		</section>
	</section>
</section>

<footer role="contentinfo">
	<section class="row">
<?php
 	if ( is_active_sidebar( 'sidebar-2' ) ) {
		echo '<section class="col">';
		dynamic_sidebar( 'sidebar-2' );
		echo '</section>';
 	}
	if ( is_active_sidebar( 'sidebar-3' ) ) {
		echo '<section class="col">';
		dynamic_sidebar( 'sidebar-3' );
		echo '</section>';
	}
	if ( is_active_sidebar( 'sidebar-4' ) ) {
		echo '<section class="col">';
		dynamic_sidebar( 'sidebar-4' );
		echo '</section>';
	}
	if ( is_active_sidebar( 'sidebar-5' ) ) {
		echo '<section class="col">';
		dynamic_sidebar( 'sidebar-5' );
		echo '</section>';
	}
?>
	</section>
	<section id="footer-wrap">
		<section class="row">
			 <p>&copy; Tom Copeland <?php echo date("Y"); ?></p>
		</section>
	</section>
</footer>
<?php wp_footer(); ?>
<script type="text/javascript">
    (function($){
        jQuery('.tom .excerpt-wrap .postmetadata').next('p').prepend('<strong><em>Answer:</em></strong> ');

            if (jQuery('article').length < 10) {
                jQuery('.nav-previous').hide()
            }

    })(jQuery)
</script>
<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
    var sc_project=10555262;
    var sc_invisible=1;
    var sc_security="f6f9bd53";
    var scJsHost = (("https:" == document.location.protocol) ?
        "https://secure." : "http://www.");
    document.write("<sc"+"ript type='text/javascript' src='" + scJsHost+
    "statcounter.com/counter/counter.js'></"+"script>");
</script>
<noscript><div class="statcounter"><a title="shopify analytics"
                                      href="http://statcounter.com/shopify/" target="_blank"><img
                class="statcounter" src="http://c.statcounter.com/10555262/0/f6f9bd53/1/"
                alt="shopify analytics"></a></div></noscript>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-19239484-1', 'auto');
    ga('send', 'pageview');

</script>
</html>