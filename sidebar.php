<div class="sidebar">
			<?php
            if (!is_home() && !is_search() && !is_tag() && !is_page()) {
            ?>
            <ul class="category-list">
                <?php 
				if (is_single()) {
					$cat_id = get_article_category_id();
				} else
				{
					$cat_id = $cat;
				}
				$args=array(
					'child_of'=>get_category_root_id($cat_id),
					'hide_empty'=>false,
				);
				$categories=get_categories($args);
				foreach($categories as $category) {
					$slug = str_replace("-", " ", $category->slug);
					$class = "";
					if ($cat == $category->term_id)
						$class = " class='current-cat' ";
					echo '<li'.$class.'><a href="'.get_category_link( $category->term_id ).'"><span>'.$category->name.'</span></a></li>';    
				}
				?>
            </ul><?php }?>
            <div id="tag_cloud" class="widget sidebox widget_tag_cloud"><h2>热门标签</h2><div class="tagcloud">
<?php wp_tag_cloud("smallest=12&largest=12&unit=px&number=20&format=flat&orderby=count&order=DESC"); ?>
</div>
</div>
            <div class="w_comment sidebox">
            <h2>最新评论</h2>
            
            <ul>
<?php
$show_comments = 10; //评论数量
$my_email = get_bloginfo ('admin_email'); //获取博主自己的email
$i = 1;
$comments = get_comments('number=10&status=approve&type=comment'); //取得前200个评论，如果你每天的回复量超过200可以适量加大
foreach ($comments as $rc_comment) {
	//只显示非博主的评论
	if ($rc_comment->comment_author_email != $my_email) {
		?>
        <li><a href="<?php echo get_permalink($rc_comment->comment_post_ID); ?>#comment-<?php echo $rc_comment->comment_ID; ?>"><?php echo $rc_comment->comment_author; ?>: </br><?php echo convert_smilies($rc_comment->comment_content); ?></a></li>
		<?php
		if ($i == $show_comments) break; //评论数量达到退出遍历
		$i++;
	}
}
?></ul> 
</div>
<?php if(is_dynamic_sidebar()) dynamic_sidebar('mytheme_sidebar');?>
</div>