/**
 * Created by sarra on 13/06/17.
 */
$(document).ready(function () {
    $('.urlzone .box-header').append('<div class="box-tools pull-right"><button type="button" id="loadtyoutube" class="btn btn-box-tool"><i class="fa fa-refresh"></i></button></div>');
    $('#loadtyoutube').on('click', function (event) {
        var url = $('input[id$=_url]').val();
        if (url != "") {
            $.ajax({
                url : Routing.generate('jsonyoutube'),
                type : 'POST', // Le type de la requête HTTP, ici devenu POST
                data : 'url=' + url, // On fait passer nos variables, exactement comme en GET, au script more_com.php
                dataType : 'json',
                success:function (data) {
                    debugger;
                }
            });

        }
    });
//
});