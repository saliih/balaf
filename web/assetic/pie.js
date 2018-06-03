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
    $('.share_twitter').on('click',function (event) {
        var url = $(this).attr('href');
        getRequest(url, {}, function(result) {alert('done')});
        return false;
    })
});
function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
        + label
        + "<br>"
        + Math.round(series.percent) + "%</div>";
}

function getRequest(url, _data, success_function, params, extraParams) {
    params = params || {};
   /* var showloader = typeof(params.showloader) != "undefined" ? params.showloader : true;
    if (showloader) {
        showLoader(true);
    }*/
    var parameters = {
        async: true,
        url: url,
        type: params.type || "POST",
        data: _data,
        success: function (data) {
            if (data === "is_not_logged") {
                successDialog("Nyellow", Translator.trans("Session expired", {}, 'javascript')+"! "+Translator.trans("Please login again", {}, 'javascript')+".", BootstrapDialog.TYPE_WARNING, undefined, function () {
                    window.location.href = "login";
                });
            } else {
                if (typeof (success_function) == "function") {
                    success_function(data);
                }
            }
        },
        error: function (xhr) {
            errorDialog(Translator.trans("Error contacting server", {}, 'javascript'), Translator.trans("Error encountered", {}, 'javascript')+' : ' + xhr.responseText);
        },
        complete: function () {
            if (showloader) {
                showLoader(false);
            }
        }
    };
    if (typeof(extraParams) == "object") {
        $.extend(parameters, extraParams);
    }
    $.ajax(parameters);
}
