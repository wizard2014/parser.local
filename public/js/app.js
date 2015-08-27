!function(t){function n(t){return"undefined"==typeof t.which?!0:"number"==typeof t.which&&t.which>0?!t.ctrlKey&&!t.metaKey&&!t.altKey&&8!=t.which&&9!=t.which:!1}t.expr[":"].notmdproc=function(n){return t(n).data("mdproc")?!1:!0},t.material={options:{input:!0,ripples:!0,checkbox:!0,togglebutton:!0,radio:!0,arrive:!0,autofill:!1,withRipples:[".btn:not(.btn-link)",".card-image",".navbar a:not(.withoutripple)",".dropdown-menu a",".nav-tabs a:not(.withoutripple)",".withripple"].join(","),inputElements:"input.form-control, textarea.form-control, select.form-control",checkboxElements:".checkbox > label > input[type=checkbox]",togglebuttonElements:".togglebutton > label > input[type=checkbox]",radioElements:".radio > label > input[type=radio]"},checkbox:function(n){t(n?n:this.options.checkboxElements).filter(":notmdproc").data("mdproc",!0).after("<span class=checkbox-material><span class=check></span></span>")},togglebutton:function(n){t(n?n:this.options.togglebuttonElements).filter(":notmdproc").data("mdproc",!0).after("<span class=toggle></span>")},radio:function(n){t(n?n:this.options.radioElements).filter(":notmdproc").data("mdproc",!0).after("<span class=circle></span><span class=check></span>")},input:function(i){t(i?i:this.options.inputElements).filter(":notmdproc").data("mdproc",!0).each(function(){var n=t(this);if(t(this).attr("data-hint")||n.hasClass("floating-label")){if(n.wrap("<div class=form-control-wrapper></div>"),n.after("<span class=material-input></span>"),n.hasClass("floating-label")){var i=n.attr("placeholder");n.attr("placeholder",null).removeClass("floating-label"),n.after("<div class=floating-label>"+i+"</div>")}if(n.attr("data-hint")&&n.after("<div class=hint>"+n.attr("data-hint")+"</div>"),(null===n.val()||"undefined"==n.val()||""===n.val())&&n.addClass("empty"),n.parent().next().is("[type=file]")){n.parent().addClass("fileinput");var o=n.parent().next().detach();n.after(o)}}}),t(document).on("change",".checkbox input[type=checkbox]",function(){t(this).blur()}).on("keydown paste",".form-control",function(i){n(i)&&t(this).removeClass("empty")}).on("keyup change",".form-control",function(){var n=t(this);""===n.val()&&"undefined"!=typeof n[0].checkValidity&&n[0].checkValidity()?n.addClass("empty"):n.removeClass("empty")}).on("focus",".form-control-wrapper.fileinput",function(){t(this).find("input").addClass("focus")}).on("blur",".form-control-wrapper.fileinput",function(){t(this).find("input").removeClass("focus")}).on("change",".form-control-wrapper.fileinput [type=file]",function(){var n="";t.each(t(this)[0].files,function(t,i){n+=i.name+", "}),n=n.substring(0,n.length-2),n?t(this).prev().removeClass("empty"):t(this).prev().addClass("empty"),t(this).prev().val(n)})},ripples:function(n){t(n?n:this.options.withRipples).ripples()},autofill:function(){var n=setInterval(function(){t("input[type!=checkbox]").each(function(){t(this).val()&&t(this).val()!==t(this).attr("value")&&t(this).trigger("change")})},100);setTimeout(function(){clearInterval(n)},1e4);var i;t(document).on("focus","input",function(){var n=t(this).parents("form").find("input").not("[type=file]");i=setInterval(function(){n.each(function(){t(this).val()!==t(this).attr("value")&&t(this).trigger("change")})},100)}).on("blur","input",function(){clearInterval(i)})},init:function(){t.fn.ripples&&this.options.ripples&&this.ripples(),this.options.input&&this.input(),this.options.checkbox&&this.checkbox(),this.options.togglebutton&&this.togglebutton(),this.options.radio&&this.radio(),this.options.autofill&&this.autofill(),document.arrive&&this.options.arrive&&(t.fn.ripples&&this.options.ripples&&t(document).arrive(this.options.withRipples,function(){t.material.ripples(t(this))}),this.options.input&&t(document).arrive(this.options.inputElements,function(){t.material.input(t(this))}),this.options.checkbox&&t(document).arrive(this.options.checkboxElements,function(){t.material.checkbox(t(this))}),this.options.radio&&t(document).arrive(this.options.radioElements,function(){t.material.radio(t(this))}),this.options.togglebutton&&t(document).arrive(this.options.togglebuttonElements,function(){t.material.togglebutton(t(this))}))}}}(jQuery),function(t,n,i,o){"use strict";function e(n,i){r=this,this.element=t(n),this.options=t.extend({},s,i),this._defaults=s,this._name=a,this.init()}var a="ripples",r=null,s={};e.prototype.init=function(){var i=this.element;i.on("mousedown touchstart",function(o){if(!r.isTouch()||"mousedown"!==o.type){i.find(".ripple-wrapper").length||i.append('<div class="ripple-wrapper"></div>');var e=i.children(".ripple-wrapper"),a=r.getRelY(e,o),s=r.getRelX(e,o);if(a||s){var p=r.getRipplesColor(i),l=t("<div></div>");l.addClass("ripple").css({left:s,top:a,"background-color":p}),e.append(l),function(){return n.getComputedStyle(l[0]).opacity}(),r.rippleOn(i,l),setTimeout(function(){r.rippleEnd(l)},500),i.on("mouseup mouseleave touchend",function(){l.data("mousedown","off"),"off"===l.data("animating")&&r.rippleOut(l)})}}})},e.prototype.getNewSize=function(t,n){return Math.max(t.outerWidth(),t.outerHeight())/n.outerWidth()*2.5},e.prototype.getRelX=function(t,n){var i=t.offset();return r.isTouch()?(n=n.originalEvent,1!==n.touches.length?n.touches[0].pageX-i.left:!1):n.pageX-i.left},e.prototype.getRelY=function(t,n){var i=t.offset();return r.isTouch()?(n=n.originalEvent,1!==n.touches.length?n.touches[0].pageY-i.top:!1):n.pageY-i.top},e.prototype.getRipplesColor=function(t){var i=t.data("ripple-color")?t.data("ripple-color"):n.getComputedStyle(t[0]).color;return i},e.prototype.hasTransitionSupport=function(){var t=i.body||i.documentElement,n=t.style,e=n.transition!==o||n.WebkitTransition!==o||n.MozTransition!==o||n.MsTransition!==o||n.OTransition!==o;return e},e.prototype.isTouch=function(){return/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)},e.prototype.rippleEnd=function(t){t.data("animating","off"),"off"===t.data("mousedown")&&r.rippleOut(t)},e.prototype.rippleOut=function(t){t.off(),r.hasTransitionSupport()?t.addClass("ripple-out"):t.animate({opacity:0},100,function(){t.trigger("transitionend")}),t.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){t.remove()})},e.prototype.rippleOn=function(t,n){var i=r.getNewSize(t,n);r.hasTransitionSupport()?n.css({"-ms-transform":"scale("+i+")","-moz-transform":"scale("+i+")","-webkit-transform":"scale("+i+")",transform:"scale("+i+")"}).addClass("ripple-on").data("animating","on").data("mousedown","on"):n.animate({width:2*Math.max(t.outerWidth(),t.outerHeight()),height:2*Math.max(t.outerWidth(),t.outerHeight()),"margin-left":-1*Math.max(t.outerWidth(),t.outerHeight()),"margin-top":-1*Math.max(t.outerWidth(),t.outerHeight()),opacity:.2},500,function(){n.trigger("transitionend")})},t.fn.ripples=function(n){return this.each(function(){t.data(this,"plugin_"+a)||t.data(this,"plugin_"+a,new e(this,n))})}}(jQuery,window,document),function(){function t(t,n){var i=["/ebay"],o="/get-started";return n=n||window.location.pathname,!(n!=o||-1==i.indexOf(t))}function n(t){$.ajax({type:"POST",url:t,beforeSend:function(){}}).done(function(t){console.log(t)}).fail(function(){}).always(function(){})}!1 in window&&alert("The browser doesn't supports the hashchange event!");var i=window.location.pathname,o=window.location.hash.split("#")[1];$(window).on("hashchange",function(){var i=window.location.hash.split("#")[1];t(i)&&n(i)}),t(o,i)&&n(o)}(),$(".nav-tabs").find("a.disabled").on("click",function(t){t.preventDefault()}),$('[data-toggle="tooltip"]').tooltip({animation:!0}),$.material.init();