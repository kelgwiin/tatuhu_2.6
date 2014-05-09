/*
 * --------------- By Display:inline -------------
 *      Modificado para el Proyecto PEI 2012000190 
 *                      Tatu Hu
 */
(function(e,t,n){var r=e(t),i=e(n),s=["hide-on-mobile-portrait","hide-on-mobile-landscape","hide-on-mobile","hide-on-tablet-portrait","hide-on-tablet-landscape","hide-on-tablet","forced-display"];e.fn.responsiveTable=function(){var t=s.join(" "),n="."+s.join(", .");this.each(function(t){var r=e(this).closest("table"),i=r.children("thead"),o=r.children("tbody").children().children();if(r.length===0||i.length===0||o.length===0){return}r.addClass("responsive-table-on");o.removeClass(n);i.children().children().each(function(t){var n=e(this),r=[],i;for(i=0;i<s.length;++i){if(n.hasClass(s[i])){r.push(s[i])}}if(r.length>0){o.filter(":nth-child("+(t+1)+")").addClass(r.join(" "))}})});return this};e.template.addSetupFunction(function(e,t){this.findIn(e,t,".responsive-table").responsiveTable()})})(jQuery,window,document)