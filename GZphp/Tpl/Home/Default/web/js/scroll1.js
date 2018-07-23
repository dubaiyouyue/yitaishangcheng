// JavaScript Document图片滚动  新闻+作品+新影响人


$(function(){
	$("div.v_show").each(function(){
		var page = 1;
		var i = 3; //每版放3个图片

		var len = $(this).find("div.v_content_list li").length;
		var page_count = Math.ceil(len / i);
		if(len <= i){$(this).find("div.prev,div.next").hide();}
		if(len <= i){
			$(this).find("div.ipage").hide();
		}else{
			var str ='';
			for (var i=0; i<page_count; i++){
				if(i == 0){
					str += "<li class='current'><a href='javascript:;'>"+i+"</a></li>";
				}else{
					str += "<li><a href='javascript:;'>"+i+"</a></li>";
				}
				
			}
			$(this).find("ol.ipage").append(str);
		}
   });
	$("div.v_show1").each(function(){
		var len = $(this).find("div.v_content_list1 li").length;
		if(len <= 5){$(this).find("div.prev,div.next,div.prev1,div.next1").hide();}
   });
   $("div.v_show2").each(function(){
	   	var page = 1;
		var i = 1; //每版放1个图片
		var len = $(this).find("div.v_content_list2 li").length;
		var page_count = Math.ceil(len / i);
		if(len <= 1){$(this).find("div.prev2,div.next2").hide();}
		if(len <= i){
			$(this).find("div.ipage").hide();
		}else{
			var str ='';
			for (var i=0; i<page_count; i++){
				if(i == 0){
					str += "<li class='current'><a href='javascript:;'>"+i+"</a></li>";
				}else{
					str += "<li><a href='javascript:;'>"+i+"</a></li>";
				}
				
			}
			$(this).find("ol.ipage").append(str);
		}
   });
     $("div.v_show3").each(function(){
		var len = $(this).find("div.v_content_list3 li").length;
		if(len <= 2){$(this).find("div.prev,div.next").hide();}
   });
});

$(function(){
    var page = 1;
    var i = 4; //每版放4个图片
    //向后 按钮
    $("div.next1").click(function(){    //绑定click事件
	     var $parent = $(this).parents("div.v_show1");//根据当前点击元素获取到父元素
		 var $v_show = $parent.find("div.v_content_list1"); //寻找到“视频内容展示区域”
		 var $v_content = $parent.find("div.v_content1"); //寻找到“视频内容展示区域”外围的DIV元素
		 var v_width = $v_content.width() ;
		 var len = $v_show.find("li").length;
		 var page_count = Math.ceil(len / i) ;   //只要不是整数，就往大的方向取最小的整数
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
			  if( page == page_count ){  //已经到最后一个版面了,如果再向后，必须跳转到第一个版面。
				$v_show.animate({ left : '0px'}, "slow"); //通过改变left值，跳转到第一个版面
				page = 1;
				}else{
				$v_show.animate({ left : '-='+v_width }, "slow");  //通过改变left值，达到每次换一个版面
				page++;
			 }
		 }
		 $parent.find("div").eq((page-1)).addClass("current").siblings().removeClass("current");
   });
    //往前 按钮
    $("div.prev1").click(function(){
	     var $parent = $(this).parents("div.v_show1");//根据当前点击元素获取到父元素
		 var $v_show = $parent.find("div.v_content_list1"); //寻找到“视频内容展示区域”
		 var $v_content = $parent.find("div.v_content1"); //寻找到“视频内容展示区域”外围的DIV元素
		 var v_width = $v_content.width();
		 var len = $v_show.find("li").length;
		 var page_count = Math.ceil(len / i) ;   //只要不是整数，就往大的方向取最小的整数
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
		 	 if( page == 1 ){  //已经到第一个版面了,如果再向前，必须跳转到最后一个版面。
				$v_show.animate({ left : '-='+v_width*(page_count-1) }, "slow");
				page = page_count;
			}else{
				$v_show.animate({ left : '+='+v_width }, "slow");
				page--;
			}
		}
		$parent.find("div").eq((page-1)).addClass("current").siblings().removeClass("current");
    });
});



$(function(){
    var page = 1;
    var i = 1; //每版放1个图片
	
	    //分页 按钮
    $("ol.ipage li").click(function(){    //绑定click事件
	     var $parent = $(this).parents("div.v_show2");//根据当前点击元素获取到父元素
		 var $v_show = $parent.find("div.v_content_list2"); //寻找到“视频内容展示区域”
		 var $v_content = $parent.find("div.v_content2"); //寻找到“视频内容展示区域”外围的DIV元素
		 var v_width = $v_content.width();
			
		 var len = $v_show.find("li").length;
		 var page_count = Math.ceil(len / i) ;  //只要不是整数，就往大的方向取最小的整数
		 page = $parent.find("ol.ipage li").index(this) + 1;
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
				$v_show.animate({ left : '-'+(page-1)*v_width}, "slow"); 
				page = page;
		 }
		 $parent.find("ol.ipage li").eq((page-1)).addClass("current").siblings().removeClass("current");
   });
	
    //向后 按钮
    $("div.next2").click(function(){    //绑定click事件
	     var $parent = $(this).parents("div.v_show2");//根据当前点击元素获取到父元素
		 var $v_show = $parent.find("div.v_content_list2"); //寻找到“视频内容展示区域”
		 var $v_content = $parent.find("div.v_content2"); //寻找到“视频内容展示区域”外围的DIV元素
		 var v_width = $v_content.width() ;
		 var len = $v_show.find("li").length;
		 var page_count = Math.ceil(len / i) ;   //只要不是整数，就往大的方向取最小的整数
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
			  if( page == page_count ){  //已经到最后一个版面了,如果再向后，必须跳转到第一个版面。
				$v_show.animate({ left : '0px'}, "slow"); //通过改变left值，跳转到第一个版面
				page = 1;
				}else{
				$v_show.animate({ left : '-='+v_width }, "slow");  //通过改变left值，达到每次换一个版面
				page++;
			 }
		 }
		 $parent.find("ol.ipage li").eq((page-1)).addClass("current").siblings().removeClass("current");
   });
    //往前 按钮
    $("div.prev2").click(function(){
	     var $parent = $(this).parents("div.v_show2");//根据当前点击元素获取到父元素
		 var $v_show = $parent.find("div.v_content_list2"); //寻找到“视频内容展示区域”
		 var $v_content = $parent.find("div.v_content2"); //寻找到“视频内容展示区域”外围的DIV元素
		 var v_width = $v_content.width();
		 var len = $v_show.find("li").length;
		 var page_count = Math.ceil(len / i) ;   //只要不是整数，就往大的方向取最小的整数
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
		 	 if( page == 1 ){  //已经到第一个版面了,如果再向前，必须跳转到最后一个版面。
				$v_show.animate({ left : '-='+v_width*(page_count-1) }, "slow");
				page = page_count;
			}else{
				$v_show.animate({ left : '+='+v_width }, "slow");
				page--;
			}
		}
		$parent.find("ol.ipage li").eq((page-1)).addClass("current").siblings().removeClass("current");
    });
});



$(function(){
    var page = 1;
    var i = 2; //每版放2个图片
    //向后 按钮
    $("div.next3").click(function(){    //绑定click事件
	     var $parent = $(this).parents("div.v_show3");//根据当前点击元素获取到父元素
		 var $v_show = $parent.find("div.v_content_list3"); //寻找到“视频内容展示区域”
		 var $v_content = $parent.find("div.v_content3"); //寻找到“视频内容展示区域”外围的DIV元素
		 var v_width = $v_content.width() ;
		 var len = $v_show.find("li").length;
		 var page_count = Math.ceil(len / i) ;   //只要不是整数，就往大的方向取最小的整数
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
			  if( page == page_count ){  //已经到最后一个版面了,如果再向后，必须跳转到第一个版面。
				$v_show.animate({ left : '0px'}, "slow"); //通过改变left值，跳转到第一个版面
				page = 1;
				}else{
				$v_show.animate({ left : '-='+v_width }, "slow");  //通过改变left值，达到每次换一个版面
				page++;
			 }
		 }
		 $parent.find("div").eq((page-1)).addClass("current").siblings().removeClass("current");
   });
    //往前 按钮
    $("div.prev3").click(function(){
	     var $parent = $(this).parents("div.v_show3");//根据当前点击元素获取到父元素
		 var $v_show = $parent.find("div.v_content_list3"); //寻找到“视频内容展示区域”
		 var $v_content = $parent.find("div.v_content3"); //寻找到“视频内容展示区域”外围的DIV元素
		 var v_width = $v_content.width();
		 var len = $v_show.find("li").length;
		 var page_count = Math.ceil(len / i) ;   //只要不是整数，就往大的方向取最小的整数
		 if( !$v_show.is(":animated") ){    //判断“视频内容展示区域”是否正在处于动画
		 	 if( page == 1 ){  //已经到第一个版面了,如果再向前，必须跳转到最后一个版面。
				$v_show.animate({ left : '-='+v_width*(page_count-1) }, "slow");
				page = page_count;
			}else{
				$v_show.animate({ left : '+='+v_width }, "slow");
				page--;
			}
		}
		$parent.find("div").eq((page-1)).addClass("current").siblings().removeClass("current");
    });
});

