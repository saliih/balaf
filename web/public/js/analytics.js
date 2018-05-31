
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