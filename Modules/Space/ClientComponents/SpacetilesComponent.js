$(document).ready(function () {

    var id_space = mumuxGetUrlParameters()[1];

    $('#lf-space-tile-config-a').attr("href", mumuxconfig.clienturl + "spaceconfig/" + id_space);
    $('#lf-space-tile-users-a').attr("href", mumuxconfig.clienturl + "spaceusers/" + id_space);

    $(this).authAjax({
        url: mumuxconfig.apiurl + "/spaces/" + id_space + "/tools",
        type: 'GET',
        data: '',
        success: function (result) {

            data = result.tools;

            if (!data) {
                $('#lf-space-tile-tool-div').html("");
                return;
            }
            toolscount = data.length;
            html = "";
            for (i = 0; i < toolscount; i++) {

                
                html += '<div class="col-md-3 text-center">';
                html += '    <a class="lf-space-tile" style="background-color: '+data[i].color+'" href="'+data[i].name + '/' +id_space + '">';
                html += '        <i class="fa '+data[i].icon +' fa-3x"></i>';
                html += '        <br/>';
                html += '        <span>'+data[i].name +'</span>';
                html += '    </a>';
                html += '</div>';    

            }
            $('#lf-space-tile-tool-div').html(html);
        }
    });

});