/**
 * Created by salah on 20/09/2017.
 */
$(document).ready(function () {
    $('.pieCharts').on('click',function (event) {
        var id = $(this).attr('data-value');
        var placeholder = $("#placeholder");
        $.ajax({
            url : Routing.generate('pie_charts',{id:id}),
            type : 'POST', // Le type de la requête HTTP, ici devenu POST
            dataType : 'json',
            success:function (data) {
                if(data.length) {
                    $('#myModal').modal();
                    $.plot(placeholder, data, {
                        series: {
                            pie: {
                                innerRadius: 0.5,
                                show: true
                            }
                        },
                        legend: {
                            show: false
                        }
                    });
                }
            }
        });
        return false;
    });
});
function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
        + label
        + "<br>"
        + Math.round(series.percent) + "%</div>";
}