$('[data-toggle="tooltip"]').tooltip({animation:!0}),function(){function a(a){var n=a.split(/\n/);n.shift(),n.splice(-1,1);var t=n[0].length-n[0].trim().length,o=new RegExp(" {"+t+"}");return n=n.map(function(a){return a.match(o)&&(a=a.substring(t)),a}),n=n.join("\n")}$(window).scroll(function(){var a=$(document).scrollTop();$(".splash").css({"background-position":"0px -"+(a/3).toFixed(2)+"px"}),a>50?$("#home > .navbar").removeClass("navbar-transparent"):$("#home > .navbar").addClass("navbar-transparent")}),$("a[href='#']").click(function(a){a.preventDefault()});var n=$("<div id='source-button' class='btn btn-primary btn-xs'>&lt; &gt;</div>").click(function(){var n=$(this).parent().html();n=a(n),$("#source-modal pre").text(n),$("#source-modal").modal()});$('.bs-component [data-toggle="popover"]').popover(),$('.bs-component [data-toggle="tooltip"]').tooltip(),$(".bs-component").hover(function(){$(this).append(n),n.show()},function(){n.hide()})}();var carousel=$("#myCarousel");carousel.carousel({interval:4e3});var clickEvent=!1;carousel.on("click",".nav-pills a",function(){clickEvent=!0,$(".nav-pills").find("li").removeClass("active"),$(this).parent().addClass("active")}).on("slid.bs.carousel",function(){if(!clickEvent){var a=carousel.find(".nav-pills").children().length-1,n=carousel.find(".nav-pills").find("li.active");n.removeClass("active").next().addClass("active");var t=parseInt(n.data("slide-to"));a==t&&$("#myCarousel").find(".nav-pills").find("li").first().addClass("active")}clickEvent=!1});