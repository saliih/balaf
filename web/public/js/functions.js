/**
 * Created by salah on 24/05/2016.
 */
jQuery(document).ready(function ($) {
    "use strict";

    $(function () {
        if ($('#b-news').length > 0)
            $('#b-news').vTicker();
    });
    if ($('a[data-rel]').length > 0)
        $('a[data-rel]').each(function () {
            $(this).attr('rel', $(this).data('rel'));
        });
    jQuery(document).ready(function () {
        if (jQuery('.mycarousel').length > 0)
            jQuery('.mycarousel').jcarousel({wrap: 'circular'});
    });
    if ($('.defaultCountdown').length) {
        var austDay = new Date();
        austDay = new Date(2014, 7 - 1, 26);
        $('.defaultCountdown').countdown({until: austDay, format: 'dHMS'});
        $('#year').text(austDay.getFullYear());
    }
    if ($('.bxslider').length) {
        $('.bxslider').bxSlider({mode: 'fade', auto: true, pagerCustom: '#bx-pager'});
    }
    if ($('.percentage').length) {
        $('.percentage').easyPieChart({
            animate: 1000, onStep: function (value) {
                this.$el.find('span').text(~~value);
            }
        });
    }
    $('#back-top').click(function () {
        $('body,html').animate({scrollTop: 0}, 800);
        return false;
    });
    if ($("[data-toggle='tooltip']").length > 0) {
        $("[data-toggle='tooltip']").tooltip();
        if ($(".gallery").length) {
            $("a[rel^='prettyPhoto']").prettyPhoto();
        }
    }
});
$(window).load(function () {
    if ($('#carousel').length > 0)
        $('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 135,
            itemMargin: 0,
            asNavFor: '.slider'
        });
    if ($('.slider').length > 0)
        $('.slider').flexslider({
            animation: "slide",
            controlNav: true,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel"
        });
    if ($('#carousel2').length > 0)
        $('#carousel2').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 131,
            itemMargin: 0,
            asNavFor: '#slider2'
        });
    if ($('#slider2').length > 0)
        $('#slider2').flexslider({
            animation: "slide",
            controlNav: true,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel2"
        });
});
$(window).load(function () {
    if ($('.flexslider').length > 0)
    $('.flexslider').flexslider({animation: "slide"});
});/*
var lineChartData = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [{
        fillColor: "rgba(220,220,220,0.5)",
        strokeColor: "rgba(220,220,220,1)",
        pointColor: "rgba(220,220,220,1)",
        pointStrokeColor: "#fff",
        data: [65, 59, 90, 81, 56, 55, 40]
    }]
}
var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData);*/
