<script src="<?php bloginfo('template_url'); ?>/scripts/jquery.js?ver=1.9.1"></script>
<script src="<?php bloginfo('template_url'); ?>/scripts/jquery.poshytip.min.js?ver=1.2"></script>
<script src="<?php bloginfo('template_url'); ?>/scripts/custom.js?ver=1.0"></script>
    <?php
		if (is_single()) {
	?><script>
	//文章页图片自适应
	function responsiveImg() {
		var img_count=($('.article-content').find('img')).length;
		if (img_count != 0) {
		var maxwidth=$(".article-content").width();
		for (var i=0;i<=img_count-1;i++) {
			var max_width=$('.article-content img:eq('+i+')');
				if (max_width.width() > maxwidth) {
					max_width.addClass('responsive-img');
				}
			}
		}
	}
	$(function(){
		responsiveImg();
		window.onresize = function(){
			responsiveImg();
		}
	});
    </script><?php
		}
	?>
    <?php wp_footer(); ?>
</body>
</html>
    