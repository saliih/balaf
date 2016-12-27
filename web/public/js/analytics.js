(function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
    a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

ga('create', 'UA-77458398-1', 'auto');
ga('send', 'pageview');
$(document).ready(function () {
    $(".fancybox").fancybox({
        'width': '300',
        'height': '200',
        'autoScale': false,
        'transitionIn': 'none',
        'transitionOut': 'none',
        'type': 'iframe',
        'href': "https://www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/tounsiaNet/&amp;width=350&amp;height=350&amp;colorscheme=dark&amp;show_faces=true&amp;border_color=%2399c844&amp;stream=false&amp;header=false&amp;appId=1788355211393444"
    });
    if ($('#fancyboxiframe').length)
        $('#fancyboxiframe').trigger("click");
});