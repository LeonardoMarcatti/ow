$('form').on('change', function (p) {
    let id = Number($('#select').val());
    if (id != 0) {
        $.ajax({
            type: "post",
            url: "getuserinfo.php",
            data: "id=" + id,
            success: function (response) {
                let data = JSON.parse(response);
                if (data.length > 0) {
                    let createdData = data[0].created_at.split('-');
                    let createdDay = createdData[2].split(' ');
                    let content = '';
                    $('#user_info').html('<p>Email: ' + data[0].email + '</p><p>Cadastrado em: ' + createdDay[0] + '/' + createdData[1] + '/' + createdData[0] + '</p>');
                    $.each(data, function (i, v) {
                        let newdata = v.moved.split('-');
                        let day = newdata[2].split(' ');
                    });
                } else {
                    $('#user_info').html('');
                };                
            }
        });
    };
});

