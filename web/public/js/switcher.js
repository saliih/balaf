jQuery(window).load(function(){function b(a){"boxed"==jQuery(".active-layout").attr("data-value")&&jQuery("body").css("background","url(images/patterns/"+a+") repeat")}function c(a){"wide"==a?(jQuery("body").removeClass("boxed"),jQuery(window).resize(),jQuery("body").attr("style","")):"boxed"==a&&(jQuery("body").addClass("boxed"),jQuery(window).resize(),jQuery("body").attr("style",""))}function d(a,b){"skins"==a?(jQuery(".logo a img").attr("src","images/logo.png"),jQuery("head").append('<style type="text/css">.push_options{background:'+b+"}.demo_rtl{background:"+b+"}</style>")):"skins"!=a&&(jQuery(".logo a img").attr("src","images/logo-"+a+".png"),jQuery("head").append('<style type="text/css">.push_options{background:'+b+"}.demo_rtl{background:"+b+"}</style>")),jQuery("head").append('<link rel="stylesheet" href="css/skins/'+a+'.css">')}jQuery("body").append("<div class='demo_navigation'><div class='demo_options'><!-- SKIN --><div class='nav_skin'><!--  Skins Colors --><div class='gnrl_color pt_touch clearfix'><div class='demo-title'>Skins Colors</div><div class='demo-content demo-color'><div data-name='gnrl_color' data-value='green' data-value-2='#7daf74' style='background-color: #7daf74;'></div><div data-name='gnrl_color' data-value='red' data-value-2='#d02e37' style='background-color: #d02e37;'></div><div data-name='gnrl_color' data-value='purple' data-value-2='#8e74b2' style='background-color: #8e74b2;'></div><div data-name='gnrl_color' data-value='orange' data-value-2='#fa7642' style='background-color: #fa7642;'></div><div data-name='gnrl_color' data-value='blue' data-value-2='#3498db' style='background-color: #3498db;'></div><div data-name='gnrl_color' data-value='darkred' data-value-2='#790000' style='background-color: #790000;'></div><div data-name='gnrl_color' data-value='cyan' data-value-2='#2997ab' style='background-color: #2997ab;'></div><div data-name='gnrl_color' data-value='yellow' data-value-2='#f6bb17' style='background-color: #f6bb17;'></div><div data-name='gnrl_color' data-value='lactic' data-value-2='#26bdef' style='background-color: #26bdef;'></div><div data-name='gnrl_color' data-value='pink' data-value-2='#f1505b' style='background-color: #f1505b;'></div></div></div><hr><!--  End Skins Colors --><!--  Layout --><div class='gnrl_color pt_touch clearfix'><div class='demo-title'>Layout</div><div class='demo-content demo-layout'><div data-name='gnrl_layout' data-value='wide'>Wide</div><div data-name='gnrl_layout' data-value='boxed'>Boxed</div></div></div><hr><!--  End Layout --><!--  Patterns --><div class='gnrl_color pt_touch clearfix'><div class='demo-title'>Patterns</div><div class='demo-content demo-pattern'><div data-name='gnrl_pattern' data-value='pattern1.jpg'><img alt='' src='images/patterns-x/pattern1.jpg'></div><div data-name='gnrl_pattern' data-value='pattern2.png'><img alt='' src='images/patterns-x/pattern2.png'></div><div data-name='gnrl_pattern' data-value='pattern3.png'><img alt='' src='images/patterns-x/pattern3.png'></div><div data-name='gnrl_pattern' data-value='pattern4.png'><img alt='' src='images/patterns-x/pattern4.png'></div><div data-name='gnrl_pattern' data-value='pattern5.png'><img alt='' src='images/patterns-x/pattern5.png'></div><div data-name='gnrl_pattern' data-value='pattern6.png'><img alt='' src='images/patterns-x/pattern6.png'></div><div data-name='gnrl_pattern' data-value='pattern7.png'><img alt='' src='images/patterns-x/pattern7.png'></div><div data-name='gnrl_pattern' data-value='pattern8.png'><img alt='' src='images/patterns-x/pattern8.png'></div><div data-name='gnrl_pattern' data-value='pattern9.png'><img alt='' src='images/patterns-x/pattern9.png'></div><div data-name='gnrl_pattern' data-value='pattern10.png'><img alt='' src='images/patterns-x/pattern10.png'></div><div data-name='gnrl_pattern' data-value='pattern11.png'><img alt='' src='images/patterns-x/pattern11.png'></div><div data-name='gnrl_pattern' data-value='pattern12.png'><img alt='' src='images/patterns-x/pattern12.png'></div><div data-name='gnrl_pattern' data-value='pattern13.jpg'><img alt='' src='images/patterns-x/pattern13.jpg'></div><div data-name='gnrl_pattern' data-value='pattern14.gif'><img alt='' src='images/patterns-x/pattern14.png'></div><div data-name='gnrl_pattern' data-value='pattern15.gif'><img alt='' src='images/patterns-x/pattern15.png'></div><div data-name='gnrl_pattern' data-value='pattern16.png'><img alt='' src='images/patterns-x/pattern16.png'></div><div data-name='gnrl_pattern' data-value='pattern17.png'><img alt='' src='images/patterns-x/pattern17.png'></div><div data-name='gnrl_pattern' data-value='pattern18.jpg'><img alt='' src='images/patterns-x/pattern18.jpg'></div><div data-name='gnrl_pattern' data-value='pattern19.jpg'><img alt='' src='images/patterns-x/pattern19.jpg'></div><div data-name='gnrl_pattern' data-value='pattern20.png'><img alt='' src='images/patterns-x/pattern20.png'></div></div></div><!--  End Patterns --></div><div id='purchase'><a href='https://themeforest.net/item/recipes-food-food-recipes-html-template/19235037?ref=themearabia'>Purchase this template</a></div></div><div class='clearfix'></div><div class='push_options'><a class='show_hide'><i class='fa fa-cog'></i></a></div><div class='demo_rtl'><a href='rtl/'>RTL</a></div></div>"),jQuery("head").append("<style type='text/css'>#purchase a{display: inline-block;padding: 10px;background: #f8f7f7;border: 1px solid #eae9e9;font-size: 16px;margin-top: 5px;}.demo_navigation{position:fixed;z-index:99999;left:-230px;top:15%;width:230px;border-left:none;background-color: #FFF;-moz-box-shadow: 0 8px 15px rgba(0,0,0,0.1);-webkit-box-shadow: 0 8px 15px rgba(0,0,0,0.1);box-shadow: 0 8px 15px rgba(0,0,0,0.1);}.demo_rtl {position: absolute;top: 40px;right: -37px;width: 37px;text-align: center;height: 34px;border-radius: 0 2px 2px 0;background: #7daf74;line-height: 37px;z-index: 99998;}.demo_rtl a{color: #fff;}.demo_options .demo-title{color:#171717;margin-bottom:20px;font-size:16px}.demo_options .demo-content{color:white;font-size:13px;}.nav_skin .demo-contentlabel{display:block;}.schemasa{display:block;height:42px;margin-bottom:5px;outline:medium none;overflow:hidden;text-indent:-999px;width:64px;background:transparent;}.demo_navigation img{border:1px solid #eae9e9;}.demo_navigation img.imgSelected{border-color:red;}.show_hide{cursor:pointer;width:100%;height:100%;display:block;}.push_options{-webkit-border-radius: 0 2px 2px 0;-moz-border-radius: 0 2px 2px 0;border-radius: 0 2px 2px 0;height: 37px;width: 37px;line-height: 37px;position:absolute;top:0px;right:-37px;background: #7daf74;display:block;font-size:21px;text-align:center;margin:0;padding:0}.push_options a{color:#FFF;}.push_options a i{font-size:21px}.demo_options{padding:20px;}.demo_options input[type='radio']{display:none;}.demo_options .nav_skin .demo-content div{width:13px;height:13px;float:left;margin:0 4px 4px 0;overflow:hidden;cursor:pointer;}.demo_options .nav_skin .demo-content div:last-child{margin-right:0 !important;}.bg_image div {width:50px;height:30px}.pt_touch.bg_image > div.demo-content {height:35px;}.pt_touch > div.demo-title{margin-left:0;}.demo-content_2 {height:25px !important;}.bd-span{\tfloat: left;\tbackground-color: #FFF;\tcolor: #AAA !important;\tborder: #DDD 2px solid;\tpadding: 4px 5px 5px;\tborder-radius: 2px;\toverflow: hidden;\tdisplay: inline-block;text-align: center;\tfont-size: 14px;}.bd-span:hover{border-color: #7ab317;background-color: #7ab317;\tbox-shadow: inset 0 0 0 1px #FFFFFF;\tcolor: #FFF !important;}.demo_options .nav_skin .demo-content.demo-layout div {height:35px;width:90px;padding:5px;border:1px solid #eae9e9;background-color:#f8f7f7;text-align:center;line-height:25px;font-size: 14px;color:#171717;margin-right:10px}.demo_options .nav_skin .demo-content.demo-layout div:hover {background-color:#171717;border-color:#171717;color:#FFF;}.demo_options .nav_skin .demo-content.demo-light div {height:35px;width:90px;padding:5px;border:1px solid #eae9e9;background-color:#f8f7f7;text-align:center;line-height:25px;font-size: 11px;margin-right:10px}.demo_options .nav_skin .demo-content.demo-pattern div {width: 23px;height: 23px;}.demo_options .nav_skin .demo-content.demo-pattern div img {width:17px;height:17px;}</style>");var a=!1;jQuery(".show_hide").click(function(){"0px"==jQuery(".demo_navigation").css("left")?left=-230:left=0,jQuery(".demo_navigation").animate({left:left})}),jQuery("div[data-name=gnrl_pattern]").click(function(){emerald_gnrl_gnrl_pattern=jQuery(this).attr("data-value"),0!=emerald_gnrl_gnrl_pattern&&b(emerald_gnrl_gnrl_pattern)}),jQuery("div[data-name=gnrl_layout]").click(function(){jQuery("*").removeClass("active-layout"),jQuery(this).addClass("active-layout"),emerald_gnrl_layout=jQuery(this).attr("data-value"),0!=emerald_gnrl_layout&&c(emerald_gnrl_layout)}),jQuery("div[data-name=gnrl_color]").click(function(){a=jQuery(this).attr("data-value"),emerald_gnrl_color_2=jQuery(this).attr("data-value-2"),0!=a&&d(a,emerald_gnrl_color_2)})});