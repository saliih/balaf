/**
 * Created by salah on 20/09/2017.
 */
$(document).ready(function () {
    $('.pieCharts').on('click',function (event) {
        var id = $(this).attr('data-value');
        var placeholder = $("#placeholder");
        var placeholder2 = $("#placeholder2");
        $.ajax({
            url : Routing.generate('pie_charts',{id:id}),
            type : 'POST', // Le type de la requête HTTP, ici devenu POST
            dataType : 'json',
            success:function (data) {
                if(data.mobile.length) {
                    $('#myModal').modal();
                    $.plot(placeholder, data.mobile, {
                        series: {
                            pie: {
                                show: true
                            }
                        },
                        legend: {
                            show: false
                        }
                    });
                    var colors = ["#FF0000","#FFFF00","#ffbf34","#4b5fff","#78ff56","#ff6ce4","#c72dff","#b1ffe2","#d8ff5c","#FF0000","#bbbbff","#05ff15"];
                    var newData = [];
                    $.each(data.views,function (index,element) {
                        newData.push({data:[element],color:colors[Math.floor(Math.random()*colors.length)]})
                    });
                    $.plot(placeholder2, newData, {
                        series: {
                            bars: {
                                show: true,
                                barWidth: 0.6,
                                align: "center",
                                lineWidth: 0,
                                fill:true
                            }
                        },
                        xaxis: {
                            mode: "categories",
                            tickLength: 0,
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