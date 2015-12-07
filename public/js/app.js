!function(t){function e(t){return"undefined"==typeof t.which?!0:"number"==typeof t.which&&t.which>0?!t.ctrlKey&&!t.metaKey&&!t.altKey&&8!=t.which&&9!=t.which:!1}function o(e){t(e).closest(".form-group").addClass("is-focused")}function r(e){t(e).closest(".form-group").removeClass("is-focused")}t.expr[":"].notmdproc=function(e){return t(e).data("mdproc")?!1:!0},t.material={options:{input:!0,ripples:!0,checkbox:!0,togglebutton:!0,radio:!0,arrive:!0,autofill:!1,withRipples:[".btn:not(.btn-link)",".card-image",".navbar a:not(.withoutripple)",".dropdown-menu a",".nav-tabs a:not(.withoutripple)",".withripple",".pagination li:not(.active):not(.disabled) a:not(.withoutripple)"].join(","),inputElements:"input.form-control, textarea.form-control, select.form-control",checkboxElements:".checkbox > label > input[type=checkbox]",togglebuttonElements:".togglebutton > label > input[type=checkbox]",radioElements:".radio > label > input[type=radio]"},checkbox:function(e){t(e?e:this.options.checkboxElements).filter(":notmdproc").data("mdproc",!0).after("<span class='checkbox-material'><span class='check'></span></span>")},togglebutton:function(e){t(e?e:this.options.togglebuttonElements).filter(":notmdproc").data("mdproc",!0).after("<span class='toggle'></span>")},radio:function(e){t(e?e:this.options.radioElements).filter(":notmdproc").data("mdproc",!0).after("<span class='circle'></span><span class='check'></span>")},input:function(e){t(e?e:this.options.inputElements).filter(":notmdproc").data("mdproc",!0).each(function(){var e=t(this),o=e.closest(".form-group");0===o.length&&(e.wrap("<div class='form-group'></div>"),o=e.closest(".form-group")),e.attr("data-hint")&&(e.after("<p class='help-block'>"+e.attr("data-hint")+"</p>"),e.removeAttr("data-hint"));var r={"input-lg":"form-group-lg","input-sm":"form-group-sm"};if(t.each(r,function(t,r){e.hasClass(t)&&(e.removeClass(t),o.addClass(r))}),e.hasClass("floating-label")){var n=e.attr("placeholder");e.attr("placeholder",null).removeClass("floating-label");var i=e.attr("id"),a="";i&&(a="for='"+i+"'"),o.addClass("label-floating"),e.after("<label "+a+"class='control-label'>"+n+"</label>")}(null===e.val()||"undefined"==e.val()||""===e.val())&&o.addClass("is-empty"),o.append("<span class='material-input'></span>"),o.find("input[type=file]").length>0&&o.addClass("is-fileinput")})},attachInputEventHandlers:function(){t(".form-group .checkbox label").hover(function(){o(this)},function(){r(this)}),t(document).on("change",".checkbox input[type=checkbox]",function(){t(this).blur()}).on("keydown paste",".form-control",function(o){e(o)&&t(this).closest(".form-group").removeClass("is-empty")}).on("keyup change",".form-control",function(){var e=t(this),o=e.closest(".form-group"),r="undefined"==typeof e[0].checkValidity||e[0].checkValidity();""===e.val()&&r?o.addClass("is-empty"):o.removeClass("is-empty"),r?o.removeClass("has-error"):o.addClass("has-error")}).on("focus",".form-control, .form-group.is-fileinput",function(){o(this)}).on("blur",".form-control, .form-group.is-fileinput",function(){r(this)}).on("change",".form-group input",function(){var e=t(this);if("file"!=e.attr("type")){var o=e.closest(".form-group"),r=e.val();r?o.removeClass("is-empty"):o.addClass("is-empty")}}).on("change",".form-group.is-fileinput input[type='file']",function(){var e=t(this),o=e.closest(".form-group"),r="";t.each(this.files,function(t,e){r+=e.name+", "}),r=r.substring(0,r.length-2),r?o.removeClass("is-empty"):o.addClass("is-empty"),o.find("input.form-control[readonly]").val(r)})},ripples:function(e){t(e?e:this.options.withRipples).ripples()},autofill:function(){var e=setInterval(function(){t("input[type!=checkbox]").each(function(){var e=t(this);e.val()&&e.val()!==e.attr("value")&&e.trigger("change")})},100);setTimeout(function(){clearInterval(e)},1e4)},attachAutofillEventHandlers:function(){var e;t(document).on("focus","input",function(){var o=t(this).parents("form").find("input").not("[type=file]");e=setInterval(function(){o.each(function(){var e=t(this);e.val()!==e.attr("value")&&e.trigger("change")})},100)}).on("blur",".form-group input",function(){clearInterval(e)})},init:function(){var e=t(document);t.fn.ripples&&this.options.ripples&&this.ripples(),this.options.input&&(this.input(),this.attachInputEventHandlers()),this.options.checkbox&&this.checkbox(),this.options.togglebutton&&this.togglebutton(),this.options.radio&&this.radio(),this.options.autofill&&(this.autofill(),this.attachAutofillEventHandlers()),document.arrive&&this.options.arrive&&(t.fn.ripples&&this.options.ripples&&e.arrive(this.options.withRipples,function(){t.material.ripples(t(this))}),this.options.input&&e.arrive(this.options.inputElements,function(){t.material.input(t(this))}),this.options.checkbox&&e.arrive(this.options.checkboxElements,function(){t.material.checkbox(t(this))}),this.options.radio&&e.arrive(this.options.radioElements,function(){t.material.radio(t(this))}),this.options.togglebutton&&e.arrive(this.options.togglebuttonElements,function(){t.material.togglebutton(t(this))}))}}}(jQuery),function(t,e,o,r){"use strict";function n(e,o){a=this,this.element=t(e),this.options=t.extend({},s,o),this._defaults=s,this._name=i,this.init()}var i="ripples",a=null,s={};n.prototype.init=function(){var o=this.element;o.on("mousedown touchstart",function(r){if(!a.isTouch()||"mousedown"!==r.type){o.find(".ripple-container").length||o.append('<div class="ripple-container"></div>');var n=o.children(".ripple-container"),i=a.getRelY(n,r),s=a.getRelX(n,r);if(i||s){var c=a.getRipplesColor(o),l=t("<div></div>");l.addClass("ripple").css({left:s,top:i,"background-color":c}),n.append(l),function(){return e.getComputedStyle(l[0]).opacity}(),a.rippleOn(o,l),setTimeout(function(){a.rippleEnd(l)},500),o.on("mouseup mouseleave touchend",function(){l.data("mousedown","off"),"off"===l.data("animating")&&a.rippleOut(l)})}}})},n.prototype.getNewSize=function(t,e){return Math.max(t.outerWidth(),t.outerHeight())/e.outerWidth()*2.5},n.prototype.getRelX=function(t,e){var o=t.offset();return a.isTouch()?(e=e.originalEvent,1===e.touches.length?e.touches[0].pageX-o.left:!1):e.pageX-o.left},n.prototype.getRelY=function(t,e){var o=t.offset();return a.isTouch()?(e=e.originalEvent,1===e.touches.length?e.touches[0].pageY-o.top:!1):e.pageY-o.top},n.prototype.getRipplesColor=function(t){var o=t.data("ripple-color")?t.data("ripple-color"):e.getComputedStyle(t[0]).color;return o},n.prototype.hasTransitionSupport=function(){var t=o.body||o.documentElement,e=t.style,n=e.transition!==r||e.WebkitTransition!==r||e.MozTransition!==r||e.MsTransition!==r||e.OTransition!==r;return n},n.prototype.isTouch=function(){return/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)},n.prototype.rippleEnd=function(t){t.data("animating","off"),"off"===t.data("mousedown")&&a.rippleOut(t)},n.prototype.rippleOut=function(t){t.off(),a.hasTransitionSupport()?t.addClass("ripple-out"):t.animate({opacity:0},100,function(){t.trigger("transitionend")}),t.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){t.remove()})},n.prototype.rippleOn=function(t,e){var o=a.getNewSize(t,e);a.hasTransitionSupport()?e.css({"-ms-transform":"scale("+o+")","-moz-transform":"scale("+o+")","-webkit-transform":"scale("+o+")",transform:"scale("+o+")"}).addClass("ripple-on").data("animating","on").data("mousedown","on"):e.animate({width:2*Math.max(t.outerWidth(),t.outerHeight()),height:2*Math.max(t.outerWidth(),t.outerHeight()),"margin-left":-1*Math.max(t.outerWidth(),t.outerHeight()),"margin-top":-1*Math.max(t.outerWidth(),t.outerHeight()),opacity:.2},500,function(){e.trigger("transitionend")})},t.fn.ripples=function(e){return this.each(function(){t.data(this,"plugin_"+i)||t.data(this,"plugin_"+i,new n(this,e))})}}(jQuery,window,document),function(t){var e=-1,o=-1,r=function(t){return parseFloat(t)||0},n=function(e){var o=1,n=t(e),i=null,a=[];return n.each(function(){var e=t(this),n=e.offset().top-r(e.css("margin-top")),s=a.length>0?a[a.length-1]:null;null===s?a.push(e):Math.floor(Math.abs(i-n))<=o?a[a.length-1]=s.add(e):a.push(e),i=n}),a},i=function(e){var o={byRow:!0,property:"height",target:null,remove:!1};return"object"==typeof e?t.extend(o,e):("boolean"==typeof e?o.byRow=e:"remove"===e&&(o.remove=!0),o)},a=t.fn.matchHeight=function(e){var o=i(e);if(o.remove){var r=this;return this.css(o.property,""),t.each(a._groups,function(t,e){e.elements=e.elements.not(r)}),this}return this.length<=1&&!o.target?this:(a._groups.push({elements:this,options:o}),a._apply(this,o),this)};a._groups=[],a._throttle=80,a._maintainScroll=!1,a._beforeUpdate=null,a._afterUpdate=null,a._apply=function(e,o){var s=i(o),c=t(e),l=[c],u=t(window).scrollTop(),d=t("html").outerHeight(!0),p=c.parents().filter(":hidden");return p.each(function(){var e=t(this);e.data("style-cache",e.attr("style"))}),p.css("display","block"),s.byRow&&!s.target&&(c.each(function(){var e=t(this),o="inline-block"===e.css("display")?"inline-block":"block";e.data("style-cache",e.attr("style")),e.css({display:o,"padding-top":"0","padding-bottom":"0","margin-top":"0","margin-bottom":"0","border-top-width":"0","border-bottom-width":"0",height:"100px"})}),l=n(c),c.each(function(){var e=t(this);e.attr("style",e.data("style-cache")||"")})),t.each(l,function(e,o){var n=t(o),i=0;if(s.target)i=s.target.outerHeight(!1);else{if(s.byRow&&n.length<=1)return void n.css(s.property,"");n.each(function(){var e=t(this),o="inline-block"===e.css("display")?"inline-block":"block",r={display:o};r[s.property]="",e.css(r),e.outerHeight(!1)>i&&(i=e.outerHeight(!1)),e.css("display","")})}n.each(function(){var e=t(this),o=0;s.target&&e.is(s.target)||("border-box"!==e.css("box-sizing")&&(o+=r(e.css("border-top-width"))+r(e.css("border-bottom-width")),o+=r(e.css("padding-top"))+r(e.css("padding-bottom"))),e.css(s.property,i-o))})}),p.each(function(){var e=t(this);e.attr("style",e.data("style-cache")||null)}),a._maintainScroll&&t(window).scrollTop(u/d*t("html").outerHeight(!0)),this},a._applyDataApi=function(){var e={};t("[data-match-height], [data-mh]").each(function(){var o=t(this),r=o.attr("data-mh")||o.attr("data-match-height");e[r]=r in e?e[r].add(o):o}),t.each(e,function(){this.matchHeight(!0)})};var s=function(e){a._beforeUpdate&&a._beforeUpdate(e,a._groups),t.each(a._groups,function(){a._apply(this.elements,this.options)}),a._afterUpdate&&a._afterUpdate(e,a._groups)};a._update=function(r,n){if(n&&"resize"===n.type){var i=t(window).width();if(i===e)return;e=i}r?-1===o&&(o=setTimeout(function(){s(n),o=-1},a._throttle)):s(n)},t(a._applyDataApi),t(window).bind("load",function(t){a._update(!1,t)}),t(window).bind("resize orientationchange",function(t){a._update(!0,t)})}(jQuery),function(t){var e={};try{if(!t&&module&&module.exports){var t=require("jquery"),o=require("jsdom").jsdom;t=t(o().parentWindow)}}catch(r){}!function(t,e){"use strict";var o={};e.forbiddenSequences=["0123456789","abcdefghijklmnopqrstuvwxyz","qwertyuiop","asdfghjkl","zxcvbnm","!@#$%^&*()_+"],o.wordNotEmail=function(t,e,o){return e.match(/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)$/i)?o:0},o.wordLength=function(t,e,o){var r=e.length,n=Math.pow(r,t.rules.raisePower);return r<t.common.minChar&&(n+=o),n},o.wordSimilarToUsername=function(e,o,r){var n=t(e.common.usernameField).val();return n&&o.toLowerCase().match(n.replace(/[\-\[\]\/\{\}\(\)\*\+\=\?\:\.\\\^\$\|\!\,]/g,"\\$&").toLowerCase())?r:0},o.wordTwoCharacterClasses=function(t,e,o){return e.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)||e.match(/([a-zA-Z])/)&&e.match(/([0-9])/)||e.match(/(.[!,@,#,$,%,\^,&,*,?,_,~])/)&&e.match(/[a-zA-Z0-9_]/)?o:0},o.wordRepetitions=function(t,e,o){return e.match(/(.)\1\1/)?o:0},o.wordSequences=function(o,r,n){var i,a=!1;return r.length>2&&(t.each(e.forbiddenSequences,function(e,o){if(!a){var n=[o,o.split("").reverse().join("")];t.each(n,function(t,e){for(i=0;i<r.length-2;i+=1)e.indexOf(r.toLowerCase().substring(i,i+3))>-1&&(a=!0)})}}),a)?n:0},o.wordLowercase=function(t,e,o){return e.match(/[a-z]/)&&o},o.wordUppercase=function(t,e,o){return e.match(/[A-Z]/)&&o},o.wordOneNumber=function(t,e,o){return e.match(/\d+/)&&o},o.wordThreeNumbers=function(t,e,o){return e.match(/(.*[0-9].*[0-9].*[0-9])/)&&o},o.wordOneSpecialChar=function(t,e,o){return e.match(/[!,@,#,$,%,\^,&,*,?,_,~]/)&&o},o.wordTwoSpecialChar=function(t,e,o){return e.match(/(.*[!,@,#,$,%,\^,&,*,?,_,~].*[!,@,#,$,%,\^,&,*,?,_,~])/)&&o},o.wordUpperLowerCombo=function(t,e,o){return e.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)&&o},o.wordLetterNumberCombo=function(t,e,o){return e.match(/([a-zA-Z])/)&&e.match(/([0-9])/)&&o},o.wordLetterNumberCharCombo=function(t,e,o){return e.match(/([a-zA-Z0-9].*[!,@,#,$,%,\^,&,*,?,_,~])|([!,@,#,$,%,\^,&,*,?,_,~].*[a-zA-Z0-9])/)&&o},e.validation=o,e.executeRules=function(o,r){var n=0;return t.each(o.rules.activated,function(i,a){if(a){var s,c,l=o.rules.scores[i],u=e.validation[i];t.isFunction(u)||(u=o.rules.extra[i]),t.isFunction(u)&&(s=u(o,r,l),s&&(n+=s),(0>s||!t.isNumeric(s)&&!s)&&(c=o.ui.spanError(o,i),c.length>0&&o.instances.errors.push(c)))}}),n}}(t,e);try{module&&module.exports&&(module.exports=e)}catch(r){}var n={};n.common={},n.common.minChar=6,n.common.usernameField="#username",n.common.userInputs=[],n.common.onLoad=void 0,n.common.onKeyUp=void 0,n.common.zxcvbn=!1,n.common.zxcvbnTerms=[],n.common.debug=!1,n.rules={},n.rules.extra={},n.rules.scores={wordNotEmail:-100,wordLength:-50,wordSimilarToUsername:-100,wordSequences:-20,wordTwoCharacterClasses:2,wordRepetitions:-25,wordLowercase:1,wordUppercase:3,wordOneNumber:3,wordThreeNumbers:5,wordOneSpecialChar:3,wordTwoSpecialChar:5,wordUpperLowerCombo:2,wordLetterNumberCombo:2,wordLetterNumberCharCombo:2},n.rules.activated={wordNotEmail:!0,wordLength:!0,wordSimilarToUsername:!0,wordSequences:!0,wordTwoCharacterClasses:!1,wordRepetitions:!1,wordLowercase:!0,wordUppercase:!0,wordOneNumber:!0,wordThreeNumbers:!0,wordOneSpecialChar:!0,wordTwoSpecialChar:!0,wordUpperLowerCombo:!0,wordLetterNumberCombo:!0,wordLetterNumberCharCombo:!0},n.rules.raisePower=1.4,n.ui={},n.ui.bootstrap2=!1,n.ui.bootstrap4=!1,n.ui.colorClasses=["danger","warning","success"],n.ui.showProgressBar=!0,n.ui.showPopover=!1,n.ui.popoverPlacement="bottom",n.ui.showStatus=!1,n.ui.spanError=function(t,e){"use strict";var o=t.ui.errorMessages[e];return o?'<span style="color: #d52929">'+o+"</span>":""},n.ui.popoverError=function(e){"use strict";var o="<div>Errors:<ul class='error-list' style='margin-bottom: 0;'>";return t.each(e,function(t,e){o+="<li>"+e+"</li>"}),o+="</ul></div>"},n.ui.errorMessages={wordLength:"Your password is too short",wordNotEmail:"Do not use your email as your password",wordSimilarToUsername:"Your password cannot contain your username",wordTwoCharacterClasses:"Use different character classes",wordRepetitions:"Too many repetitions",wordSequences:"Your password contains sequences"},n.ui.verdicts=["Weak","Normal","Medium","Strong","Very Strong"],n.ui.showVerdicts=!0,n.ui.showVerdictsInsideProgressBar=!1,n.ui.useVerdictCssClass=!1,n.ui.showErrors=!1,n.ui.container=void 0,n.ui.viewports={progress:void 0,verdict:void 0,errors:void 0},n.ui.scores=[14,26,38,50];var i={};!function(t,e){"use strict";var o=["error","warning","success"];e.getContainer=function(e,o){var r;return r=t(e.ui.container),r&&1===r.length||(r=o.parent()),r},e.findElement=function(t,e,o){return e?t.find(e).find(o):t.find(o)},e.getUIElements=function(t,o){var r,n,i;return t.instances.viewports?t.instances.viewports:(r=e.getContainer(t,o),i={},n=t.ui.bootstrap4?"progress.progress":"div.progress",i.$progressbar=e.findElement(r,t.ui.viewports.progress,n),t.ui.showVerdictsInsideProgressBar&&(i.$verdict=i.$progressbar.find("span.password-verdict")),t.ui.showPopover||(t.ui.showVerdictsInsideProgressBar||(i.$verdict=e.findElement(r,t.ui.viewports.verdict,"span.password-verdict")),i.$errors=e.findElement(r,t.ui.viewports.errors,"ul.error-list")),t.instances.viewports=i,i)},e.initProgressBar=function(o,r){var n=e.getContainer(o,r),i="<div class='progress'><div class='";o.ui.bootstrap2||o.ui.bootstrap4||(i+="progress-"),i+="bar'>",o.ui.bootstrap4&&(i="<progress class='progress' value='0' max='100'>"),o.ui.showVerdictsInsideProgressBar&&(i+="<span class='password-verdict'></span>"),i+=o.ui.bootstrap4?"</progress>":"</div></div>",o.ui.viewports.progress?n.find(o.ui.viewports.progress).append(i):t(i).insertAfter(r)},e.initHelper=function(o,r,n,i){var a=e.getContainer(o,r);i?a.find(i).append(n):t(n).insertAfter(r)},e.initVerdict=function(t,o){e.initHelper(t,o,"<span class='password-verdict'></span>",t.ui.viewports.verdict)},e.initErrorList=function(t,o){e.initHelper(t,o,"<ul class='error-list'></ul>",t.ui.viewports.errors)},e.initPopover=function(t,e){e.popover("destroy"),e.popover({html:!0,placement:t.ui.popoverPlacement,trigger:"manual",content:" "})},e.initUI=function(t,o){t.ui.showPopover?e.initPopover(t,o):(t.ui.showErrors&&e.initErrorList(t,o),t.ui.showVerdicts&&!t.ui.showVerdictsInsideProgressBar&&e.initVerdict(t,o)),t.ui.showProgressBar&&e.initProgressBar(t,o)},e.updateProgressBar=function(o,r,n,i){var a=e.getUIElements(o,r).$progressbar,s=a.find(".progress-bar"),c="progress-";o.ui.bootstrap2&&(s=a.find(".bar"),c=""),t.each(o.ui.colorClasses,function(t,e){o.ui.bootstrap4?a.removeClass(c+e):s.removeClass(c+"bar-"+e)}),o.ui.bootstrap4?(a.addClass(c+o.ui.colorClasses[n]),a.val(i)):(s.addClass(c+"bar-"+o.ui.colorClasses[n]),s.css("width",i+"%"))},e.updateVerdict=function(t,o,r,n){var i=e.getUIElements(t,o).$verdict;i.removeClass(t.ui.colorClasses.join(" ")),r>-1&&i.addClass(t.ui.colorClasses[r]),i.html(n)},e.updateErrors=function(o,r){var n=e.getUIElements(o,r).$errors,i="";t.each(o.instances.errors,function(t,e){i+="<li>"+e+"</li>"}),n.html(i)},e.updatePopover=function(t,e,o){var r=e.data("bs.popover"),n="",i=!0;return t.ui.showVerdicts&&!t.ui.showVerdictsInsideProgressBar&&o.length>0&&(n="<h5><span class='password-verdict'>"+o+"</span></h5>",i=!1),t.ui.showErrors&&(t.instances.errors.length>0&&(i=!1),n+=t.ui.popoverError(t.instances.errors)),i?void e.popover("hide"):(t.ui.bootstrap2&&(r=e.data("popover")),void(r.$arrow&&r.$arrow.parents("body").length>0?e.find("+ .popover .popover-content").html(n):(r.options.content=n,e.popover("show"))))},e.updateFieldStatus=function(e,r,n){var i=e.ui.bootstrap2?".control-group":".form-group",a=r.parents(i).first();t.each(o,function(t,o){e.ui.bootstrap2||(o="has-"+o),a.removeClass(o)}),n=o[n],e.ui.bootstrap2||(n="has-"+n),a.addClass(n)},e.percentage=function(t,e){var o=Math.floor(100*t/e);return o=0>=o?1:o,o=o>100?100:o},e.getVerdictAndCssClass=function(t,e){var o,r,n;return 0>=e?(o=0,n=-1,r=t.ui.verdicts[0]):e<t.ui.scores[0]?(o=0,n=0,r=t.ui.verdicts[0]):e<t.ui.scores[1]?(o=0,n=1,r=t.ui.verdicts[1]):e<t.ui.scores[2]?(o=1,n=2,r=t.ui.verdicts[2]):e<t.ui.scores[3]?(o=1,n=3,r=t.ui.verdicts[3]):(o=2,n=4,r=t.ui.verdicts[4]),[r,o,n]},e.updateUI=function(t,o,r){var n,i,a,s;n=e.getVerdictAndCssClass(t,r),a=0===r?"":n[0],n=n[1],s=t.ui.useVerdictCssClass?n:-1,t.ui.showProgressBar&&(i=e.percentage(r,t.ui.scores[3]),e.updateProgressBar(t,o,n,i),t.ui.showVerdictsInsideProgressBar&&e.updateVerdict(t,o,s,a)),t.ui.showStatus&&e.updateFieldStatus(t,o,n),t.ui.showPopover?e.updatePopover(t,o,a):(t.ui.showVerdicts&&!t.ui.showVerdictsInsideProgressBar&&e.updateVerdict(t,o,s,a),t.ui.showErrors&&e.updateErrors(t,o))}}(t,i);var a={};!function(t,o){"use strict";var r,a;r=function(o){var r,n,a,s,c=t(o.target),l=c.data("pwstrength-bootstrap"),u=c.val();void 0!==l&&(l.instances.errors=[],0===u.length?s=0:l.common.zxcvbn?(r=[],t.each(l.common.userInputs.concat([l.common.usernameField]),function(e,o){var n=t(o).val();n&&r.push(n)}),r=r.concat(l.common.zxcvbnTerms),s=zxcvbn(u,r).entropy):s=e.executeRules(l,u),i.updateUI(l,c,s),n=i.getVerdictAndCssClass(l,s),a=n[2],n=n[0],l.common.debug&&console.log(s+" - "+n),t.isFunction(l.common.onKeyUp)&&l.common.onKeyUp(o,{score:s,verdictText:n,verdictLevel:a}))},o.init=function(e){return this.each(function(o,a){var s=t.extend(!0,{},n),c=t.extend(!0,s,e),l=t(a);c.instances={},l.data("pwstrength-bootstrap",c),l.on("keyup",r),l.on("change",r),l.on("paste",r),i.initUI(c,l),t.trim(l.val())&&l.trigger("keyup"),t.isFunction(c.common.onLoad)&&c.common.onLoad()}),this},o.destroy=function(){this.each(function(e,o){var r=t(o),n=r.data("pwstrength-bootstrap"),a=i.getUIElements(n,r);a.$progressbar.remove(),a.$verdict.remove(),a.$errors.remove(),r.removeData("pwstrength-bootstrap")})},o.forceUpdate=function(){this.each(function(t,e){var o={target:e};r(o)})},o.addRule=function(e,o,r,n){this.each(function(i,a){var s=t(a).data("pwstrength-bootstrap");s.rules.activated[e]=n,s.rules.scores[e]=r,s.rules.extra[e]=o})},a=function(e,o,r){this.each(function(n,i){t(i).data("pwstrength-bootstrap").rules[o][e]=r})},o.changeScore=function(t,e){a.call(this,t,"scores",e)},o.ruleActive=function(t,e){a.call(this,t,"activated",e)},t.fn.pwstrength=function(e){var r;return o[e]?r=o[e].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof e&&e?t.error("Method "+e+" does not exist on jQuery.pwstrength-bootstrap"):r=o.init.apply(this,arguments),r}}(t,a)}(jQuery),function(){$(".key-form-toggle").on("click",function(){$(".api-key-form").toggleClass("hide")});var t=$(".api-key-form-item"),e=$(".keys-btn");t.on("submit",function(t){t.preventDefault();var o=$(this).find(".token"),r=$(this).find(".vendor"),n=$(this).find(".access-key");$.ajax({type:"POST",url:"/user/settings/profile",data:{vendor:r.val(),key:n.val(),token:o.val()},beforeSend:function(){e.attr("disabled",!0).addClass("disabled")}}).done(function(t){t.token&&o.val(t.token),n.val("")}).fail(function(){}).always(function(){e.removeAttr("disabled").removeClass("disabled")})})}(),function(){function t(t,o,r){$.ajax({type:"POST",url:"/get-started/get-category",data:t,beforeSend:o}).done(function(t){r(t)}).fail(function(){e()}).always(function(){$(".loader").toggleClass("visible")})}function e(){$(".alert").removeClass("hide").find(".error-list").append("<li>Something went wrong! Please try again later.</li>")}$(document).on("click",".add-category",function(){var e=$(".destination"),o=$(".modal-title"),r=$(".loader"),n=$(".input-region").val(),i=$(".input-category-level").val(),a=$(".input-category").val(),s=$(this).data("title"),c={region:n,level:i,parentId:a};t(c,function(){r.toggleClass("visible"),e.empty(),o.empty()},function(t){var r=t.categoryList,n="";r.length>0&&($.each(r,function(t,e){n+='<span class="item"><button type="button" class="btn btn-link set-category" data-category-id="'+e.id+'" data-category-level="'+e.level+'">'+e.name+"</button></span>"}),e.append(n),o.text(s),$("#modal").modal("show"))})}),$(document).on("click",".set-category",function(){var e=$(this).data("category-id"),o=$(".input-category-level"),r=$(this).text(),n=$(".input-region").val(),i=parseInt(o.val())+1;o.val(i),$(".input-category").val(e),$(".category-list").append('<span><button type="button" class="btn btn-link edit-category" data-level="'+o.val()+'" data-category-id="'+e+'" data-target="#modal" data-title="Select category or subcategory">'+r+'</button><i class="fa fa-trash category-remove cursor-pointer" data-toggle="tooltip" data-placement="top" title="Remove"></i></span>');var a={region:n,level:i,parentId:e};t(a,function(){$(".loader").toggleClass("visible")},function(t){var e=t.categoryList;0==e.length&&$(".add-category").addClass("hide"),$("#modal").modal("hide")})}),$(document).on("click",".edit-category",function(){var e=$(".destination"),o=$(".modal-title"),r=$(".loader"),n=$(this).data("category-id"),i=$(this).parent("span").prev().find("button"),a=$(".input-region").val(),s=void 0!==i.data("level")?i.data("level"):1,c=void 0!==i.data("category-id")?i.data("category-id"):"",l=$(this).data("title"),u={region:a,level:s,parentId:c};t(u,function(){r.toggleClass("visible"),e.empty(),o.empty()},function(t){var r=t.categoryList,i="";r.length>0&&($.each(r,function(t,e){i+='<span class="item"><button type="button" class="btn btn-link replace-category" data-replace-with="'+n+'" data-category-id="'+e.id+'" data-category-level="'+e.level+'">'+e.name+"</button></span>"}),e.append(i),o.text(l),$("#modal").modal("show"))})}),$(document).on("click",".replace-category",function(){var e=$(this).data("category-id"),o=$(this).data("category-level"),r=$(this).text(),n=$(this).data("replace-with"),i=$(".input-region").val(),a=parseInt(o)+1;$(".input-category-level").val(a),$(".input-category").val(e),$.each($(".category-list").find("span"),function(){$(this).find("button").data("category-id")==n&&($(this).next("span").find(".category-remove").trigger("click"),$(this).replaceWith('<span><button type="button" class="btn btn-link edit-category" data-level="'+a+'" data-category-id="'+e+'" data-target="#modal" data-title="Select category or subcategory">'+r+'</button><i class="fa fa-trash category-remove cursor-pointer" data-toggle="tooltip" data-placement="top" title="Remove"></i></span>'))});var s={region:i,level:a,parentId:e};t(s,function(){$(".loader").toggleClass("visible")},function(t){var e=t.categoryList;0==e.length?$(".add-category").addClass("hide"):$(".add-category").removeClass("hide"),$("#modal").modal("hide")})}),$(document).on("click",".category-remove",function(){$(this).parent("span").nextAll("span").addBack().fadeOut(400,function(){$(this).remove();var t=$(".category-list").children("span").last().find("button");void 0===t.data("category-id")||void 0===t.data("level")?($(".input-category").val(""),$(".input-category-level").val(1)):($(".input-category").val(t.data("category-id")),$(".input-category-level").val(t.data("level"))),$(".add-category").removeClass("hide")})})}(),function(){$("#modal").on("show.bs.modal",function(){var t=$(".destination").children(".item"),e=t.length;e>25?(t.slice(0,Math.ceil(e/3)).wrapAll('<div class="col col-md-4" />'),t.slice(Math.ceil(e/3),2*Math.ceil(e/3)).wrapAll('<div class="col col-md-4" />'),t.slice(2*Math.ceil(e/3),e).wrapAll('<div class="col col-md-4" />')):e>10?(t.slice(0,Math.ceil(e/2)).wrapAll('<div class="col col-md-6" />'),t.slice(Math.ceil(e/2),e).wrapAll('<div class="col col-md-6" />')):t.wrapAll('<div class="col col-md-12" />')})}(),function(){$("#modal").on("show.bs.modal",function(){function t(t,e){var o=$(".filter-input");if(0==o.length){var r=$("<input>").attr({"class":"filter-input form-control",type:"search",placeholder:"Filter"});$(r).appendTo(t)}o.val(""),$(r).on("change",function(){var t=$(this).val();if(t){var o=$(e).find("button:contains("+t+")").parent();$(".item",e).not(o).addClass("hide"),o.removeClass("hide")}else $(e).find(".item").removeClass("hide");return!1}).keyup(function(){$(this).trigger("change")})}$.expr[":"].contains=function(t,e,o){return(t.textContent||t.innerText||"").toUpperCase().indexOf(o[3].toUpperCase())>=0},t($("#form-filter"),$(".destination"))})}(),function(){$(".dropdown").on("click",function(){var t=$(this).find("i").last();t.hasClass("fa-caret-down")?t.removeClass("fa-caret-down").addClass("fa-caret-up"):t.removeClass("fa-caret-up").addClass("fa-caret-down")}),$("html").on("click",function(){var t=$(".dropdown");t.hasClass("open")&&t.find("i").last().removeClass("fa-caret-up").addClass("fa-caret-down")})}(),function(){var t=$(".notification-form");t.on("submit",function(t){t.preventDefault()});var e=$(".notification-checkbox"),o=t.find(".token");e.on("click",function(){$.ajax({type:"POST",url:"/user/settings/notification",data:{token:o.val()},beforeSend:function(){e.attr("disabled",!0).parents(".checkbox").addClass("disabled")}}).done(function(t){t.token&&o.val(t.token)}).fail(function(){}).always(function(){e.removeAttr("disabled").parents(".checkbox").removeClass("disabled")})})}(),function(){var t={};t.ui={showVerdictsInsideProgressBar:!0},$(".register-form").find(":password").first().pwstrength(t)}(),function(){$(".price-header").matchHeight(),$(".toggle-checkbox").on("click",function(){var t=$(".price-block-without-key"),e=$(".price-block-with-key");$(this).prop("checked")?(t.addClass("hide"),e.removeClass("hide")):(e.addClass("hide"),t.removeClass("hide")),$(".price-header").matchHeight()})}(),function(){function t(){$(".input-category").val(""),$(".input-category-level").val(1),$(".category-list").empty()}$(".get-region").on("click",function(){var t=$(".destination"),e=$(".modal-title"),o=$(".loader"),r=$(this).data("title");$.ajax({type:"POST",url:"/get-started/get-region",beforeSend:function(){o.toggleClass("visible"),t.empty(),e.empty()}}).done(function(o){var n=o.ebaySourceRegional,i="";$.each(n,function(t,e){i+='<span class="item"><button type="button" class="btn btn-link set-region" data-region="'+t+'">'+e+"</button></span>"}),t.append(i),e.text(r),$("#modal").modal("show")}).fail(function(){}).always(function(){o.toggleClass("visible")})}),$(document).on("click",".set-region",function(){t();var e=$(this).data("region"),o=$(this).text();$(".input-region").val(e),$(".get-region").text(o),$("#modal").modal("hide")})}(),function(){function t(t){var e=$(".register-form").find(".submit-btn");t?e.removeClass("disabled").prop("disabled",!1):e.addClass("disabled").prop("disabled",!0)}var e={set:function(t,e){return localStorage.setItem(t,JSON.stringify(e))},get:function(t){return JSON.parse(localStorage.getItem(t))},remove:function(t){return localStorage.removeItem(t)}},o=$(".agree-checkbox");o.on("click",function(){$(".register-form");$(this).is(":checked")?(t(!0),e.set("terms-agree",!0)):(t(!1),e.set("terms-agree",!1))});var r=e.get("terms-agree");r&&(t(!0),o.trigger("click"))}(),$(".nav-tabs").find("a.disabled").on("click",function(t){t.preventDefault()}),$("body").tooltip({selector:'[data-toggle="tooltip"]',animation:!0}),function(){function t(){return!$(".category-list").is(":empty")}function e(){$(".submit-btn").removeClass("disabled").prop("disabled",!1)}function o(){$(".submit-btn").addClass("disabled").prop("disabled",!0)}$(".ebay-form").on("submit",function(e){t()||e.preventDefault()}),$("#modal").on("hidden.bs.modal",function(){t()?e():o()}),$(document).on("click",".category-remove",function(){setTimeout(function(){t()?e():o()},450)}),$(".num-only").on("keypress",function(t){return!/\D/.test(String.fromCharCode(t.charCode))})}(),$.material.init(),$('[data-toggle="tooltip"]').tooltip({animation:!0});