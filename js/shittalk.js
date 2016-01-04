/**
 * Created by Davis on 12/31/2015.
 */
$(document).ready(function () {

    $('#create_shittalk_Btn')
        .button()
        .click(function (e) {
            e.preventDefault();
            var that = this;

            var shittalkText = $('#create_shittalk_Text').val();
            var shittalkText_LowerCase = shittalkText.toLowerCase();

            if (S(shittalkText_LowerCase).contains('http://') || S(shittalkText_LowerCase).contains('www.') || S(shittalkText_LowerCase).contains('.com')) {

                $(that).parent().parent().addClass('has-error');
                $('#helpBlock2').removeClass('hidden');

            } else if (S(shittalkText_LowerCase).contains('nigger')) {

                $(that).parent().parent().addClass('has-error');
                $('#helpBlock3').removeClass('hidden');

            } else {


                var form = {};
                form['create_shittalk_Text'] = shittalkText;
                form['query'] = 'check_IfDuplicate';

                var duplicateRequest = queryController(form);
                duplicateRequest.done(function (data) {
                    console.log(data);
                    var number = data + 0;

                    if (data < 1) {
                        var form2 = {};
                        form2['create_shittalk_Text'] = shittalkText;
                        form2['query'] = 'create_Shittalk';

                        var request = queryController(form2);
                        request.done(function (data) {
                            //console.log(data);
                            if (data === true) {
                                console.log('submission successful');
                                location.reload();
                            }
                        });
                    } else {
                        $(that).parent().parent().addClass('has-error');
                        $('#helpBlock').removeClass('hidden');
                    }

                });
            }
        });

    makeJumboRows(3);

    function makeJumboRows(limit) {
        var post = {};
        post['query'] = 'get_RandomRows';
        post['limit'] = limit;
        var request = queryController(post);
        request.done(function (data) {
            //console.log(data);
            var rowHolder = [];
            for (var i = 0; i < data.length; i++) {
                var currentRow = data[i];

                var biased = currentRow['biased'] || '';
                if (biased === true) {
                    console.log('Biased');
                }

                var rowText = currentRow['text'] || '';
                if (rowText !== '') {
                    var spantemplate = '<tr id="jumboid_' + currentRow['id'] + '"><td>' +
                        '<span class="glyphicon glyphicon-arrow-up text-success" style="font-size:2.0em;"  aria-hidden="true"> </span> ' +
                        '<span class="glyphicon glyphicon-arrow-down text-danger" style="font-size:2.0em;" aria-hidden="true"> </span>' +
                        '</td><td><h4>' + currentRow['text'] + '</h4></td></tr>';

                    rowHolder.push(spantemplate)
                }
            }
            if (rowHolder !== '') {
                $('#jumbotron_tbody').html(rowHolder);
            }


            $('#jumbotron_tbody').find('td .glyphicon-arrow-up')
                .button()
                .click(function (e) {
                    e.preventDefault();

                    if ($(this).is('[disabled=disabled]') !== true) {

                        //console.log('upvoted!');
                        var text = $(this).parent().next().text();
                        var parent = $(this).parent().parent();
                        ////console.log(text);

                        $(this).attr('disabled', 'disabled');
                        $(this).parent().parent().addClass('selected-st');

                        var query = {};
                        var id = $(this).parent().parent().attr('id');
                        query['id'] = id.split('_')[1];
                        query['query'] = 'upvote_Row';
                        var request = queryController(query);
                        request.done(function (data) {
                            //console.log(data);
                            parent.addClass('bg-success');
                            checkIfJumbotronIsFull();

                        })
                    } else {
                        console.log('already upvoted');
                    }
                });


            $('#jumbotron_tbody').find('td .glyphicon-arrow-down')
                .button()
                .click(function (e) {
                    e.preventDefault();
                    if ($(this).is('[disabled=disabled]') !== true) {
                        ////console.log('downvoted!');
                        var text = $(this).parent().next().text();
                        var parent = $(this).parent().parent();
                        //console.log(text);

                        $(this).attr('disabled', 'disabled');
                        $(this).parent().parent().addClass('selected-st');

                        var query = {};
                        var id = $(this).parent().parent().attr('id');
                        query['id'] = id.split('_')[1];
                        query['query'] = 'downvote_Row';
                        var request = queryController(query);
                        request.done(function (data) {
                            //console.log(data);
                            parent.addClass('bg-danger');
                            checkIfJumbotronIsFull();
                        });
                    } else {
                        console.log('already downvoted');
                    }
                });


        });
    }

    function checkIfJumbotronIsFull() {
        var limit = 3;
        if ($('#jumbotron_tbody').find('.selected-st').length === limit) {
            makeJumboRows(3);
            //console.log('making jumbo rows in checkIfJumboFull');
        }
    }

    function checkIfRateMoreIsFull() {
        var limit = 25;
        var tbody = $('#rate_more_tbody');
        var tbodySuccessCount = tbody.find('.bg-success').length;
        var tbodyDangerCount = tbody.find('.bg-danger').length;
        var rowsUsed = tbodyDangerCount + tbodySuccessCount;
        if (rowsUsed === limit) {
            location.reload();
        }
    }


    $('#recent_listGroup').find('.glyphicon-arrow-up')
        .button()
        .click(function (e) {
            e.preventDefault();

            if ($(this).is('[disabled=disabled]') !== true) {

                ////console.log('upvoted!');
                var parent = $(this).parent();
                var text = parent.text();

                ////console.log(text);

                $(this).attr('disabled', 'disabled');

                var query = {};
                var id = $(this).parent().attr('id');
                query['id'] = id.split('_')[1];
                query['query'] = 'upvote_Row';
                var request = queryController(query);
                request.done(function (data) {
                    //console.log(data);
                    //var origBadgeVal = parent.find('.badge').text();
                    //parent.find('.badge').text(origBadgeVal+1);
                    parent.removeClass('list-group-item-danger');
                    parent.addClass('list-group-item-success');
                })
            } else {
                console.log('already upvoted');
            }
        });

    $('#recent_listGroup').find('.glyphicon-arrow-down')
        .button()
        .click(function (e) {
            e.preventDefault();

            if ($(this).is('[disabled=disabled]') !== true) {

                ////console.log('upvoted!');
                var parent = $(this).parent();
                var text = parent.text();

                ////console.log(text);

                $(this).attr('disabled', 'disabled');

                var query = {};
                var id = $(this).parent().attr('id');
                query['id'] = id.split('_')[1];
                query['query'] = 'downvote_Row';
                var request = queryController(query);
                request.done(function (data) {
                    //console.log(data);
                    parent.removeClass('list-group-item-success');
                    parent.addClass('list-group-item-danger');
                })
            } else {
                console.log('already downvoted');
            }
        });


    $('#top_listGroup').find('.glyphicon-arrow-up')
        .button()
        .click(function (e) {
            e.preventDefault();

            if ($(this).is('[disabled=disabled]') !== true) {

                ////console.log('upvoted!');
                var parent = $(this).parent();
                var text = parent.text();

                ////console.log(text);

                $(this).attr('disabled', 'disabled');

                var query = {};
                var id = $(this).parent().attr('id');
                query['id'] = id.split('_')[1];
                query['query'] = 'upvote_Row';
                var request = queryController(query);
                request.done(function (data) {
                    //console.log(data);
                    parent.removeClass('list-group-item-danger');
                    parent.addClass('list-group-item-success');
                })
            } else {
                console.log('already upvoted');
            }
        });

    $('#top_listGroup').find('.glyphicon-arrow-down')
        .button()
        .click(function (e) {
            e.preventDefault();

            if ($(this).is('[disabled=disabled]') !== true) {

                //console.log('downvoted!');
                var parent = $(this).parent();
                var text = parent.text();

                ////console.log(text);

                $(this).attr('disabled', 'disabled');

                var query = {};
                var id = $(this).parent().attr('id');
                query['id'] = id.split('_')[1];
                query['query'] = 'downvote_Row';
                var request = queryController(query);
                request.done(function (data) {
                    //console.log(data);
                    parent.removeClass('list-group-item-success');
                    parent.addClass('list-group-item-danger');
                })
            } else {
                console.log('already downvoted');
            }
        });


    $('#rate_more_tbody').find('td .glyphicon-arrow-up')
        .button()
        .click(function (e) {
            e.preventDefault();

            if ($(this).is('[disabled=disabled]') !== true) {

                //console.log('upvoted!');
                var text = $(this).parent().next().text();
                var parent = $(this).parent().parent();
                //console.log(text);

                $(this).attr('disabled', 'disabled');

                var query = {};
                var id = $(this).parent().parent().attr('id');
                query['id'] = id.split('_')[1];
                query['query'] = 'upvote_Row';
                var request = queryController(query);
                request.done(function (data) {
                    //console.log(data);
                    parent.removeClass('bg-danger');
                    parent.addClass('bg-success');
                    checkIfRateMoreIsFull();
                })
            } else {
                console.log('already upvoted');
            }
        });

    $('#rate_more_tbody').find('td .glyphicon-arrow-down')
        .button()
        .click(function (e) {
            e.preventDefault();
            if ($(this).is('[disabled=disabled]') !== true) {
                //console.log('downvoted!');
                var text = $(this).parent().next().text();
                var parent = $(this).parent().parent();
                //console.log(text);

                $(this).attr('disabled', 'disabled');

                var query = {};
                var id = $(this).parent().parent().attr('id');
                query['id'] = id.split('_')[1];
                query['query'] = 'downvote_Row';
                var request = queryController(query);
                request.done(function (data) {
                    //console.log(data);
                    parent.addClass('bg-danger');
                    checkIfRateMoreIsFull();
                });
            } else {
                console.log('already downvoted');
            }
        });

    $('.badge').each(function () {
        var that = this;
        var thisVal = $(this).text();
        if (thisVal < 0) {
            $(this).css("background-color", "#a94442");
        } else if (thisVal > 0) {
            $(this).css("background-color", "#3c763d");
        }
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