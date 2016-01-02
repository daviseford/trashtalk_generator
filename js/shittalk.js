/**
 * Created by Davis on 12/31/2015.
 */
$(document).ready(function () {

    $('#create_shittalk_Btn')
        .button()
        .click(function (e) {
            e.preventDefault();
            var form = {};
            form['create_shittalk_Text'] = $('#create_shittalk_Text').val();
            form['query'] = 'create_Shittalk';

            var request = queryController(form);
            request.done(function (data) {
                console.log(data);
                if (data === true) {
                    console.log('happy dance!');
                    location.reload();
                }
            });
        });

    $('.glyphicon-arrow-up')
        .button()
        .click(function (e) {
            e.preventDefault();
            console.log('upvoted!');
            var text = $(this).attr("title");
            console.log(text);

            var query = {};
            query['text'] = text;
            query['query'] = 'upvote_Row';
            var request = queryController(query);
            request.done(function (data) {
                console.log(data);
                console.log('YAY!!!!');
                location.reload();
            })
        });

    $('.glyphicon-arrow-down')
        .button()
        .click(function (e) {
            e.preventDefault();
            console.log('downvoted!');
            var text = $(this).attr("title");
            console.log(text);

            var query = {};
            query['text'] = text;
            query['query'] = 'downvote_Row';
            var request = queryController(query);
            request.done(function (data) {
                console.log(data);
                console.log('YAY!!!!');
                location.reload();
            })
        });

    function queryController(query) {
        return $.ajax({
            url: "php/controller/controller.php",
            contentType: "application/json; charset=utf-8",
            method: "POST",
            dataType: 'json',
            data: JSON.stringify(query),
            error: function (data) {
                console.log(data);
            }
        });
    }

});