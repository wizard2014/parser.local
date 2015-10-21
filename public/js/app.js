!function(t){function e(t){return"undefined"==typeof t.which?!0:"number"==typeof t.which&&t.which>0?!t.ctrlKey&&!t.metaKey&&!t.altKey&&8!=t.which&&9!=t.which:!1}t.expr[":"].notmdproc=function(e){return t(e).data("mdproc")?!1:!0},t.material={options:{input:!0,ripples:!0,checkbox:!0,togglebutton:!0,radio:!0,arrive:!0,autofill:!1,withRipples:[".btn:not(.btn-link)",".card-image",".navbar a:not(.withoutripple)",".dropdown-menu a",".nav-tabs a:not(.withoutripple)",".withripple"].join(","),inputElements:"input.form-control, textarea.form-control, select.form-control",checkboxElements:".checkbox > label > input[type=checkbox]",togglebuttonElements:".togglebutton > label > input[type=checkbox]",radioElements:".radio > label > input[type=radio]"},checkbox:function(e){t(e?e:this.options.checkboxElements).filter(":notmdproc").data("mdproc",!0).after("<span class=checkbox-material><span class=check></span></span>")},togglebutton:function(e){t(e?e:this.options.togglebuttonElements).filter(":notmdproc").data("mdproc",!0).after("<span class=toggle></span>")},radio:function(e){t(e?e:this.options.radioElements).filter(":notmdproc").data("mdproc",!0).after("<span class=circle></span><span class=check></span>")},input:function(n){t(n?n:this.options.inputElements).filter(":notmdproc").data("mdproc",!0).each(function(){var e=t(this);if(t(this).attr("data-hint")||e.hasClass("floating-label")){if(e.wrap("<div class=form-control-wrapper></div>"),e.after("<span class=material-input></span>"),e.hasClass("floating-label")){var n=e.attr("placeholder");e.attr("placeholder",null).removeClass("floating-label"),e.after("<div class=floating-label>"+n+"</div>")}if(e.attr("data-hint")&&e.after("<div class=hint>"+e.attr("data-hint")+"</div>"),(null===e.val()||"undefined"==e.val()||""===e.val())&&e.addClass("empty"),e.parent().next().is("[type=file]")){e.parent().addClass("fileinput");var i=e.parent().next().detach();e.after(i)}}}),t(document).on("change",".checkbox input[type=checkbox]",function(){t(this).blur()}).on("keydown paste",".form-control",function(n){e(n)&&t(this).removeClass("empty")}).on("keyup change",".form-control",function(){var e=t(this);""===e.val()&&"undefined"!=typeof e[0].checkValidity&&e[0].checkValidity()?e.addClass("empty"):e.removeClass("empty")}).on("focus",".form-control-wrapper.fileinput",function(){t(this).find("input").addClass("focus")}).on("blur",".form-control-wrapper.fileinput",function(){t(this).find("input").removeClass("focus")}).on("change",".form-control-wrapper.fileinput [type=file]",function(){var e="";t.each(t(this)[0].files,function(t,n){e+=n.name+", "}),e=e.substring(0,e.length-2),e?t(this).prev().removeClass("empty"):t(this).prev().addClass("empty"),t(this).prev().val(e)})},ripples:function(e){t(e?e:this.options.withRipples).ripples()},autofill:function(){var e=setInterval(function(){t("input[type!=checkbox]").each(function(){t(this).val()&&t(this).val()!==t(this).attr("value")&&t(this).trigger("change")})},100);setTimeout(function(){clearInterval(e)},1e4);var n;t(document).on("focus","input",function(){var e=t(this).parents("form").find("input").not("[type=file]");n=setInterval(function(){e.each(function(){t(this).val()!==t(this).attr("value")&&t(this).trigger("change")})},100)}).on("blur","input",function(){clearInterval(n)})},init:function(){t.fn.ripples&&this.options.ripples&&this.ripples(),this.options.input&&this.input(),this.options.checkbox&&this.checkbox(),this.options.togglebutton&&this.togglebutton(),this.options.radio&&this.radio(),this.options.autofill&&this.autofill(),document.arrive&&this.options.arrive&&(t.fn.ripples&&this.options.ripples&&t(document).arrive(this.options.withRipples,function(){t.material.ripples(t(this))}),this.options.input&&t(document).arrive(this.options.inputElements,function(){t.material.input(t(this))}),this.options.checkbox&&t(document).arrive(this.options.checkboxElements,function(){t.material.checkbox(t(this))}),this.options.radio&&t(document).arrive(this.options.radioElements,function(){t.material.radio(t(this))}),this.options.togglebutton&&t(document).arrive(this.options.togglebuttonElements,function(){t.material.togglebutton(t(this))}))}}}(jQuery),function(t,e,n,i){"use strict";function o(e,n){l=this,this.element=t(e),this.options=t.extend({},r,n),this._defaults=r,this._name=a,this.init()}var a="ripples",l=null,r={};o.prototype.init=function(){var n=this.element;n.on("mousedown touchstart",function(i){if(!l.isTouch()||"mousedown"!==i.type){n.find(".ripple-wrapper").length||n.append('<div class="ripple-wrapper"></div>');var o=n.children(".ripple-wrapper"),a=l.getRelY(o,i),r=l.getRelX(o,i);if(a||r){var s=l.getRipplesColor(n),c=t("<div></div>");c.addClass("ripple").css({left:r,top:a,"background-color":s}),o.append(c),function(){return e.getComputedStyle(c[0]).opacity}(),l.rippleOn(n,c),setTimeout(function(){l.rippleEnd(c)},500),n.on("mouseup mouseleave touchend",function(){c.data("mousedown","off"),"off"===c.data("animating")&&l.rippleOut(c)})}}})},o.prototype.getNewSize=function(t,e){return Math.max(t.outerWidth(),t.outerHeight())/e.outerWidth()*2.5},o.prototype.getRelX=function(t,e){var n=t.offset();return l.isTouch()?(e=e.originalEvent,1!==e.touches.length?e.touches[0].pageX-n.left:!1):e.pageX-n.left},o.prototype.getRelY=function(t,e){var n=t.offset();return l.isTouch()?(e=e.originalEvent,1!==e.touches.length?e.touches[0].pageY-n.top:!1):e.pageY-n.top},o.prototype.getRipplesColor=function(t){var n=t.data("ripple-color")?t.data("ripple-color"):e.getComputedStyle(t[0]).color;return n},o.prototype.hasTransitionSupport=function(){var t=n.body||n.documentElement,e=t.style,o=e.transition!==i||e.WebkitTransition!==i||e.MozTransition!==i||e.MsTransition!==i||e.OTransition!==i;return o},o.prototype.isTouch=function(){return/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)},o.prototype.rippleEnd=function(t){t.data("animating","off"),"off"===t.data("mousedown")&&l.rippleOut(t)},o.prototype.rippleOut=function(t){t.off(),l.hasTransitionSupport()?t.addClass("ripple-out"):t.animate({opacity:0},100,function(){t.trigger("transitionend")}),t.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){t.remove()})},o.prototype.rippleOn=function(t,e){var n=l.getNewSize(t,e);l.hasTransitionSupport()?e.css({"-ms-transform":"scale("+n+")","-moz-transform":"scale("+n+")","-webkit-transform":"scale("+n+")",transform:"scale("+n+")"}).addClass("ripple-on").data("animating","on").data("mousedown","on"):e.animate({width:2*Math.max(t.outerWidth(),t.outerHeight()),height:2*Math.max(t.outerWidth(),t.outerHeight()),"margin-left":-1*Math.max(t.outerWidth(),t.outerHeight()),"margin-top":-1*Math.max(t.outerWidth(),t.outerHeight()),opacity:.2},500,function(){e.trigger("transitionend")})},t.fn.ripples=function(e){return this.each(function(){t.data(this,"plugin_"+a)||t.data(this,"plugin_"+a,new o(this,e))})}}(jQuery,window,document),function(){function t(){$(".alert").removeClass("hide").find(".error-list").append("<li>Something went wrong! Please try again later.</li>")}$(document).on("click",".add-category",function(){var e=$(".destination"),n=$(".modal-title"),i=$(".loader"),o=$(".input-region").val(),a=$(".input-category-level").val(),l=$(".input-category").val(),r=$(this).data("title");$.ajax({type:"POST",url:"/get-started/get-category",data:{region:o,level:a,parentId:l},beforeSend:function(){i.toggleClass("visible"),e.empty(),n.empty()}}).done(function(t){var i=t.categoryList,o="";i.length>0&&($.each(i,function(t,e){o+='<span class="item"><button type="button" class="btn btn-link set-category" data-category-id="'+e.id+'" data-category-level="'+e.level+'">'+e.name+"</button></span>"}),e.append(o),n.text(r),$("#modal").modal("show"))}).fail(function(){t()}).always(function(){i.toggleClass("visible")})}),$(document).on("click",".set-category",function(){var t=$(this).data("category-id"),e=$(".input-category-level"),n=$(this).text(),i=parseInt(e.val())+1;e.val(i),$(".input-category").val(t),$(".category-list").append('<span><button type="button" class="btn btn-link edit-category" data-level="'+e.val()+'" data-category-id="'+t+'" data-target="#modal" data-title="Select category or subcategory">'+n+'</button><i class="fa fa-trash category-remove cursor-pointer" data-toggle="tooltip" data-placement="top" title="Remove"></i></span>'),$("#modal").modal("hide")}),$(document).on("click",".edit-category",function(){var e=$(".destination"),n=$(".modal-title"),i=$(".loader"),o=$(this).data("category-id"),a=$(this).parent("span").prev().find("button"),l=$(".input-region").val(),r=void 0!==a.data("level")?a.data("level"):1,s=void 0!==a.data("category-id")?a.data("category-id"):"",c=$(this).data("title");$.ajax({type:"POST",url:"/get-started/get-category",data:{region:l,level:r,parentId:s},beforeSend:function(){i.toggleClass("visible"),e.empty(),n.empty()}}).done(function(t){var i=t.categoryList,a="";i.length>0&&($.each(i,function(t,e){a+='<span class="item"><button type="button" class="btn btn-link replace-category" data-replace-with="'+o+'" data-category-id="'+e.id+'" data-category-level="'+e.level+'">'+e.name+"</button></span>"}),e.append(a),n.text(c),$("#modal").modal("show"))}).fail(function(){t()}).always(function(){i.toggleClass("visible")})}),$(document).on("click",".replace-category",function(){var t=$(this).data("category-id"),e=$(this).data("category-level"),n=$(this).text(),i=$(this).data("replace-with"),o=parseInt(e)+1;$(".input-category-level").val(o),$(".input-category").val(t),$.each($(".category-list").find("span"),function(){$(this).find("button").data("category-id")==i&&($(this).next("span").find(".category-remove").trigger("click"),$(this).replaceWith('<span><button type="button" class="btn btn-link edit-category" data-level="'+e+'" data-category-id="'+t+'" data-target="#modal" data-title="Select category or subcategory">'+n+'</button><i class="fa fa-trash category-remove cursor-pointer" data-toggle="tooltip" data-placement="top" title="Remove"></i></span>'))}),$("#modal").modal("hide")}),$(document).on("click",".category-remove",function(){$(this).parent("span").nextAll("span").addBack().fadeOut(400,function(){$(this).remove();var t=$(".category-list").children("span").last().find("button");void 0===t.data("category-id")||void 0===t.data("level")?($(".input-category").val(""),$(".input-category-level").val(1)):($(".input-category").val(t.data("category-id")),$(".input-category-level").val(t.data("level")))})})}(),function(){$("#modal").on("show.bs.modal",function(){var t=$(".destination").children(".item"),e=t.length;e>25?(t.slice(0,Math.ceil(e/3)).wrapAll('<div class="col col-md-4" />'),t.slice(Math.ceil(e/3),2*Math.ceil(e/3)).wrapAll('<div class="col col-md-4" />'),t.slice(2*Math.ceil(e/3),e).wrapAll('<div class="col col-md-4" />')):e>10?(t.slice(0,Math.ceil(e/2)).wrapAll('<div class="col col-md-6" />'),t.slice(Math.ceil(e/2),e).wrapAll('<div class="col col-md-6" />')):t.wrapAll('<div class="col col-md-12" />')})}(),function(){$("#modal").on("show.bs.modal",function(){function t(t,e){var n=$(".filter-input");if(0==n.length){var i=$("<input>").attr({"class":"filter-input form-control",type:"search",placeholder:"Filter"});$(i).appendTo(t)}n.val(""),$(i).on("change",function(){var t=$(this).val();if(t){var n=$(e).find("button:contains("+t+")").parent();$(".item",e).not(n).addClass("hide"),n.removeClass("hide")}else $(e).find(".item").removeClass("hide");return!1}).keyup(function(){$(this).trigger("change")})}$.expr[":"].contains=function(t,e,n){return(t.textContent||t.innerText||"").toUpperCase().indexOf(n[3].toUpperCase())>=0},t($("#form-filter"),$(".destination"))})}(),function(){function t(){$(".input-category").val(""),$(".input-category-level").val(1),$(".category-list").empty()}$(".get-region").on("click",function(){var t=$(".destination"),e=$(".modal-title"),n=$(".loader"),i=$(this).data("title");$.ajax({type:"POST",url:"/get-started/get-region",beforeSend:function(){n.toggleClass("visible"),t.empty(),e.empty()}}).done(function(n){var o=n.ebaySourceRegional,a="";$.each(o,function(t,e){a+='<span class="item"><button type="button" class="btn btn-link set-region" data-region="'+t+'">'+e+"</button></span>"}),t.append(a),e.text(i),$("#modal").modal("show")}).fail(function(){}).always(function(){n.toggleClass("visible")})}),$(document).on("click",".set-region",function(){t();var e=$(this).data("region"),n=$(this).text();$(".input-region").val(e),$(".get-region").text(n),$("#modal").modal("hide")})}(),$(".nav-tabs").find("a.disabled").on("click",function(t){t.preventDefault()}),$("body").tooltip({selector:'[data-toggle="tooltip"]',animation:!0}),function(){function t(){return!$(".category-list").is(":empty")}function e(){$(".submit-btn").removeClass("disabled").prop("disabled",!1)}function n(){$(".submit-btn").addClass("disabled").prop("disabled",!0)}$(".ebay-form").on("submit",function(e){t()||e.preventDefault()}),$("#modal").on("hidden.bs.modal",function(){t()?e():n()}),$(document).on("click",".category-remove",function(){setTimeout(function(){t()?e():n()},450)}),$(".num-only").on("keypress",function(t){return!/\D/.test(String.fromCharCode(t.charCode))})}(),$.material.init(),$('[data-toggle="tooltip"]').tooltip({animation:!0});