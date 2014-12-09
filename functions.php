<?php
if (!function_exists( 'greencatch_setup' )) :
function greencatch_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files
	 */
	load_theme_textdomain( '_s', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => 'Primary Menu',
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
	
}
endif; // greencatch_setup
add_action( 'after_setup_theme', 'greencatch_setup' );

/* not used

function custom_posts_per_page($query){
	$cat_root_id = get_category_root_id(get_queried_object_id());
    if($cat_root_id == getCategoryId('news')){
        $query->set('posts_per_page',5);
    } else {
		$query->set('posts_per_page',8);
	}
}
add_action('pre_get_posts','custom_posts_per_page');
*/

/******************************
**
**
**	Page Navigation
**
**
*******************************/
function pagenavi() {
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
        'base' => @add_query_arg('paged','%#%'),
        'format' => '',
        'total' => $wp_query->max_num_pages,
        'current' => $current,
        'show_all' => false,
		'end_size'=>'1',   
        'mid_size'=>'5',
        'type' => 'plain',
        'prev_next' => false
    );
	//echo $wp_query->max_num_pages;
    //if( $wp_rewrite->using_permalinks() )
     //   $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array('s'=>get_query_var('s'));
	previous_posts_link('&laquo;','');
    echo paginate_links($pagination);
	next_posts_link('&raquo;','');
	if( $pagination['total']>1 ){
	}
}
/******************************
**
**
**	Custom the Excerpt's Fomat
**
**
*******************************/
function utf8Substr($str, $from, $len)
{
   return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
   '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
   '$1',$str);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'improved_trim_excerpt');
function improved_trim_excerpt($text) {
        global $post;
        if ( '' == $text ) {
                $text = get_the_content('');
                $text = apply_filters('the_content', $text);
                $text = str_replace('\]\]\>', ']]&gt;', $text);
                $text = strip_tags($text, '<p><a>');
                $excerpt_length = 400;
                if (strlen($text)> $excerpt_length) {
                        $words = utf8Substr($text,0,$excerpt_length);
                        $text = $words."&nbsp;&nbsp;&nbsp;&nbsp;[......]";
                }
        }
        return $text;
}
/******************************
**
**
**	Custom Sidebar
**
**
*******************************/
function wp_sidebar(){
	register_sidebar(array(
		'id'=>'mytheme_sidebar',
		'name'=>'全局侧栏',
		'class'=>'box-content',
		'before_widget' => '<div id="%1$s" class="widget sidebox %2$s">',
		//html after widget
		'after_widget'  => '</div>',
		//html before widget
		'before_title'  => '<h2>',
		//html after widget
		'after_title'   => '</h2>'
	));
}
add_action('widgets_init','wp_sidebar');
/******************************
**
**
**	Print tags
**
**
*******************************/
function tagtext() {
	global $post;
	$gettags = get_the_tags($post->ID);
	if($gettags) {
	foreach ($gettags as $tag) {
		$posttag[] = $tag->name;
		}
		$tags = implode( ',', $posttag );
		return $tags;
	}
}
/******************************
**
**
**	Get Article Category Id
**
**
*******************************/
function get_article_category_ID(){
    $category=get_the_category();
    return $category[0]->cat_ID;
}
/******************************
**
**
**	Get Category Root Id
**
**
*******************************/
function get_category_root_id($cat)
{
	$this_category = get_category($cat);   // get current category
	while($this_category->category_parent) // if has parent, continue
	{
		$this_category = get_category($this_category->category_parent); // change the parent as current
	}
	return $this_category->term_id; // return root id
}
remove_action('wp_head', 'wp_generator');
function remove_wordpress_version() { return ''; } add_filter('the_generator', 'remove_wordpress_version');
/******************************
**
**
**	Theme option
**
**
*******************************/
add_action('admin_menu', 'mytheme_page');
function mytheme_page (){
	if ( count($_POST) > 0 && isset($_POST['mytheme_settings']) ){
		$options = array ('keywords','description');
		foreach ( $options as $opt ){
			delete_option ( 'mytheme_'.$opt, $_POST[$opt] );
			add_option ( 'mytheme_'.$opt, $_POST[$opt] );	
		}
	}
	add_theme_page(__('主题选项'), __('主题选项'), 'edit_themes', basename(__FILE__), 'mytheme_settings');
}
function mytheme_settings(){
	include_once('admin/panel.php');
}
//remove admin bar
if (!function_exists('df_disable_admin_bar')) {
    function df_disable_admin_bar() {
        // for the admin page
        remove_action('admin_footer', 'wp_admin_bar_render', 1000);
        // for the front-end
        remove_action('wp_footer', 'wp_admin_bar_render', 1000);
        // css override for the admin page
        function remove_admin_bar_style_backend() {
            echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
        }
        add_filter('admin_head','remove_admin_bar_style_backend');
        // css override for the frontend
        function remove_admin_bar_style_frontend() {
            echo '<style type="text/css" media="screen">
            html { margin-top: 0px !important; }
            * html body { margin-top: 0px !important; }
            </style>';
        }
        add_filter('wp_head','remove_admin_bar_style_frontend', 99);
      }
}
show_admin_bar(false);
add_action('init','df_disable_admin_bar');
//Enable link manager
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
?>