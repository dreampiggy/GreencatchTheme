	$(function(){	
		//highlight
		hljs.initHighlightingOnLoad();
		
		//to-top
		$(window).scroll(function(){
			if ($(this).scrollTop() >= 30) {
				if (!$(".to-top").hasClass("topbtnfadein"))
					$(".to-top").removeClass("topbtnfadeout topbtnhide").addClass("topbtnfadein topbtnshow").removeClass("topbtnfadein");
				//$(".to-top").stop().animate({bottom: 30, opacity: 100});
			} else {
				if (!$(".to-top").hasClass("topbtnfadeout"))
					$(".to-top").removeClass("topbtnfadein topbtnshow").addClass("topbtnfadeout topbtnhide").removeClass("topbtnfadeout");
			}
		})
		$(".to-top").click(function(){
			$("body, html").stop().animate({scrollTop:0});
		});
		
		//poshytip
		$('.widget a').poshytip({
			className: 'tip-twitter',
			showTimeout: 1,
			alignTo: 'target',
			alignX: 'center',
			alignY: 'bottom',
			offsetY: 5,
			allowTipHover: false,
		});
		
		//menu
		var idxY = 0;
		var hasCheck = true;
		$(".nav ul li").each(function(){
			var navY = $(this).position().top;
			if ($(this).hasClass("current-cat") || hasCheck) {
				hasCheck = false;
				idxY = navY;
				$("#nav-current").css({top: idxY+15});
			}
			if(screen.width > 640){
			$(this).mouseenter(function(){
				$("#nav-current").stop().animate({top: navY+15}, 300);
			});}
		});
		if(screen.width > 640){
		$(".nav ul").mouseleave(function(){
			$("#nav-current").stop().animate({top: idxY+15}, 500);
		});}
		
		//side icon
		$(".icon-category").click(function(){
			if ($(this).hasClass("list-open")) {
				$(this).removeClass('list-open').children('span').html('展开页面目录');
				$(".list .menu").stop().animate({left: 110}, 500);
			}
			else {
				$(this).addClass('list-open').children('span').html('关闭页面目录');
				if ($('.sns-weibo').hasClass('sns-weibo-open'))
				{
					$('.sns-weibo').click();
				}
				$(".list .menu").stop().animate({left: 320}, 500);
			}
		});
		$(".sns-weibo").click(function(){
			if ($(this).hasClass("sns-weibo-open")) {
				$(this).removeClass('sns-weibo-open').children('span').html('展开微博窗口');
				$(".weibo-show").stop().animate({left: 60}, 500);
			}
			else {
				$(this).addClass('sns-weibo-open').children('span').html('关闭微博窗口');
				if ($('.icon-category').hasClass('list-open'))
				{
					$('.icon-category').click();
				}
				$(".weibo-show").stop().animate({left: 320}, 500);
			}
		});
		$(".sns-rss").click(function(){
			location.href = "http://1.dreampiggy.sinaapp.com/rss";
		});
		document.addEventListener("touchstart", function(){}, true);
		
		//weibo-show
		var screenHeight = $(window).height();
		$("iframe[name=weiboshow]").attr('src','http://widget.weibo.com/weiboshow/index.php?language=&width=350&height=800&fansRow=1&ptype=1&speed=0&skin=10&isTitle=1&noborder=0&isWeibo=1&isFans=0&uid=2809718372&verifier=af8051c9&dpc=1');
	
		//loading 
		$('.loading').animate({'width':'95%'},9000);
		$(window).load(function()
		{
			$('.circle-loading').fadeOut(300);
			$('.loading').stop().animate({'width':'100%'},300,function()
			{
				$(this).fadeOut(300);
			});
		});
	});
	