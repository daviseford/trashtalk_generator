/**
 * Created by Davis on 12/31/2015.
 */
$(document).ready(function () {

    makeJumboRows(3);

    makeRecentList();
    makeTopList();
    makeRandomList();

    /* None of these are viewable without scrolling */
    $(window).ready(function () {
        $(this).one('scroll', function () {
            makeIncludedBindCount();
            makeTotalBindCount();
            makeRateMoreTableRows();
        });
    });

    $('#create_shittalk_Btn')
        .click(function (e) {
            e.preventDefault();
            var that = this;
            var parent = $(that).parent().parent();

            var shittalkText = $('#create_shittalk_Text').val();
            var shittalkText_LowerCase = shittalkText.toLowerCase();

            if (shittalkText_LowerCase.indexOf('http://') > -1 || shittalkText_LowerCase.indexOf('https://') > -1 || shittalkText_LowerCase.indexOf('www.') > -1 || shittalkText_LowerCase.indexOf('.com') > -1) {

                parent.addClass('has-error');
                $('#helpBlock2').removeClass('hidden');

            } else if (shittalkText_LowerCase.indexOf('nigger') > -1 || shittalkText_LowerCase.indexOf('faggot') > -1) {

                parent.addClass('has-error');
                $('#helpBlock3').removeClass('hidden');

            } else {


                var form = {};
                form['create_shittalk_Text'] = shittalkText;
                form['query'] = 'check_IfDuplicate';

                $.ajax({
                    url: "php/controller/controller.php",
                    contentType: "application/json; charset=utf-8",
                    type: "POST",
                    dataType: 'json',
                    data: JSON.stringify(form),
                    success: function (data) {
                        if (data < 1) { // i.e. not a duplicate
                            var form2 = {};
                            form2['create_shittalk_Text'] = shittalkText;
                            form2['query'] = 'create_Shittalk';

                            $.ajax({
                                url: "php/controller/controller.php",
                                contentType: "application/json; charset=utf-8",
                                type: "POST",
                                dataType: 'json',
                                data: JSON.stringify(form2),
                                success: function (data) {
                                    if (data === true) {
                                        console.log('Submission successful');
                                        location.reload();
                                    }
                                },
                                error: function (data) {
                                    console.log(data);
                                }
                            });
                        } else {
                            parent.addClass('has-error');
                            $('#helpBlock').removeClass('hidden');
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        });

    function makeRecentList() {
        var post = {};
        post['query'] = 'get_RecentList';
        $.ajax({
            url: "php/controller/controller.php",
            contentType: "application/json; charset=utf-8",
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(post),
            success: function (data) {
                var listRowHolder = [];
                for (var i = 0; i < data.length; i++) {
                    var listObject = data[i];
                    var id = listObject['id'] || '';
                    var netVotes = listObject['netVotes'] || '';
                    var text = listObject['text'] || '';
                    if (id !== '' && netVotes !== '' && text !== '') {
                        var listRow = '<li class="list-group-item" id="recentid_' + id + '"><span class="badge">' + netVotes + '</span> ' + text + '</li>';
                        listRowHolder.push(listRow);
                    }
                }
                var listRowsJoined = listRowHolder.join('\n');
                $('#recent_listGroup').html(listRowsJoined);
                updateBadges();
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    function makeTopList() {
        var post = {};
        post['query'] = 'get_TopList';
        $.ajax({
            url: "php/controller/controller.php",
            contentType: "application/json; charset=utf-8",
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(post),
            success: function (data) {
                var listRowHolder = [];
                for (var i = 0; i < data.length; i++) {
                    var listObject = data[i];
                    var id = listObject['id'] || '';
                    var netVotes = listObject['netVotes'] || '';
                    var text = listObject['text'] || '';
                    if (id !== '' && netVotes !== '' && text !== '') {
                        var listRow = '<li class="list-group-item" id="topid_' + id + '"><span class="badge">' + netVotes + '</span> ' + text + '</li>';
                        listRowHolder.push(listRow);
                    }
                }
                var listRowsJoined = listRowHolder.join('\n');
                $('#top_listGroup').html(listRowsJoined);
                updateBadges();
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    function makeRandomList() {
        var post = {};
        post['query'] = 'get_RandomList';
        $.ajax({
            url: "php/controller/controller.php",
            contentType: "application/json; charset=utf-8",
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(post),
            success: function (data) {
                var listRowHolder = [];
                for (var i = 0; i < data.length; i++) {
                    var listObject = data[i];
                    var id = listObject['id'] || '';
                    var netVotes = listObject['netVotes'] || '';
                    var text = listObject['text'] || '';
                    if (id !== '' && netVotes !== '' && text !== '') {
                        var listRow = '<li class="list-group-item" id="randomid_' + id + '"><span class="badge">' + netVotes + '</span> ' + text + '</li>';
                        listRowHolder.push(listRow);
                    }
                }
                var listRowsJoined = listRowHolder.join('\n');
                $('#random_listGroup').html(listRowsJoined);
                updateBadges();
            },
            error: function (data) {
                console.log(data);
            }
        });
    }


    function makeRateMoreTableRows() {
        var post = {};
        post['query'] = 'get_RateMoreTableRows';
        $.ajax({
            url: "php/controller/controller.php",
            contentType: "application/json; charset=utf-8",
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(post),
            success: function (data) {
                var rate_more_tbody = $('#rate_more_tbody');
                var tableRows = data.join('\n');
                rate_more_tbody.html(tableRows);

                rate_more_tbody.find('td .glyphicon-arrow-up')
                    .click(function (e) {
                        e.preventDefault();

                        if ($(this).is('[disabled=disabled]') !== true) {

                            var parent = $(this).parent().parent();

                            $(this).attr('disabled', 'disabled');

                            var query = {};
                            var id = parent.attr('id');
                            query['id'] = id.split('_')[1];
                            query['query'] = 'upvote_Row';

                            $.ajax({
                                url: "php/controller/controller.php",
                                contentType: "application/json; charset=utf-8",
                                type: "POST",
                                dataType: 'json',
                                data: JSON.stringify(query),
                                success: function (data) {
                                    parent.removeClass('bg-danger');
                                    parent.addClass('bg-success');
                                    checkIfRateMoreIsFull();
                                },
                                error: function (data) {
                                    console.log(data);
                                }
                            });

                        } else {
                            console.log('Already upvoted');
                        }
                    });

                rate_more_tbody.find('td .glyphicon-arrow-down')
                    .click(function (e) {
                        e.preventDefault();
                        if ($(this).is('[disabled=disabled]') !== true) {

                            var parent = $(this).parent().parent();

                            $(this).attr('disabled', 'disabled');

                            var query = {};
                            var id = parent.attr('id');
                            query['id'] = id.split('_')[1];
                            query['query'] = 'downvote_Row';
                            $.ajax({
                                url: "php/controller/controller.php",
                                contentType: "application/json; charset=utf-8",
                                type: "POST",
                                dataType: 'json',
                                data: JSON.stringify(query),
                                success: function (data) {
                                    parent.addClass('bg-danger');
                                    checkIfRateMoreIsFull();
                                },
                                error: function (data) {
                                    console.log(data);
                                }
                            });
                        } else {
                            console.log('Already downvoted');
                        }
                    });
                updateBadges();
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    function makeTotalBindCount() {
        var post = {};
        post['query'] = 'get_TotalBindCount';
        $.ajax({
            url: "php/controller/controller.php",
            contentType: "application/json; charset=utf-8",
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(post),
            success: function (data) {
                $('#TotalBindCount').text(data);
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    function makeIncludedBindCount() {
        var post = {};
        post['query'] = 'get_IncludedBindCount';
        $.ajax({
            url: "php/controller/controller.php",
            contentType: "application/json; charset=utf-8",
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(post),
            success: function (data) {
                $('#IncludedBindCount').text(data);
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    function makeJumboRows(limit) {
        var post = {};
        post['query'] = 'get_RandomRows';
        post['limit'] = limit;

        $.ajax({
            url: "php/controller/controller.php",
            contentType: "application/json; charset=utf-8",
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(post),
            success: function (data) {
                var jumbotron_tbody = $('#jumbotron_tbody');
                var rowHolder = [];
                for (var i = 0; i < data.length; i++) {
                    var currentRow = data[i];

                    var rowText = currentRow['text'] || '';
                    var rowID = currentRow['id'] || '';
                    if (rowText !== '' && rowID !== '') {
                        var spantemplate = '<tr id="jumboid_' + rowID + '"><td>' +
                            '<span class="glyphicon glyphicon-arrow-up text-success" style="font-size:2.0em;"  aria-hidden="true"> </span> ' +
                            '<span class="glyphicon glyphicon-arrow-down text-danger" style="font-size:2.0em;" aria-hidden="true"> </span>' +
                            '</td><td><h4>' + rowText + '</h4></td></tr>';

                        rowHolder.push(spantemplate)
                    }
                }
                if (rowHolder !== '') {
                    jumbotron_tbody.html(rowHolder.join('\n'));
                }


                jumbotron_tbody.find('td .glyphicon-arrow-up')
                    .click(function (e) {
                        e.preventDefault();
                        if ($(this).is('[disabled=disabled]') !== true) {

                            var parent = $(this).parent().parent();

                            $(this).attr('disabled', 'disabled');
                            parent.addClass('selected-st');

                            var query = {};
                            var id = parent.attr('id');
                            query['id'] = id.split('_')[1];
                            query['query'] = 'upvote_Row';

                            $.ajax({
                                url: "php/controller/controller.php",
                                contentType: "application/json; charset=utf-8",
                                type: "POST",
                                dataType: 'json',
                                data: JSON.stringify(query),
                                success: function () {
                                    parent.addClass('bg-success');
                                    console.log('upvoted');
                                    checkIfJumbotronIsFull();
                                },
                                error: function (data) {
                                    console.log(data);
                                }
                            });

                        } else {
                            console.log('Already upvoted');
                        }
                    });


                jumbotron_tbody.find('td .glyphicon-arrow-down')
                    .click(function (e) {
                        e.preventDefault();
                        if ($(this).is('[disabled=disabled]') !== true) {

                            var parent = $(this).parent().parent();

                            $(this).attr('disabled', 'disabled');
                            parent.addClass('selected-st');

                            var query = {};
                            var id = parent.attr('id');
                            query['id'] = id.split('_')[1];
                            query['query'] = 'downvote_Row';

                            $.ajax({
                                url: "php/controller/controller.php",
                                contentType: "application/json; charset=utf-8",
                                type: "POST",
                                dataType: 'json',
                                data: JSON.stringify(query),
                                success: function () {
                                    parent.addClass('bg-danger');
                                    console.log('downvoted');
                                    checkIfJumbotronIsFull();
                                },
                                error: function (data) {
                                    console.log(data);
                                }
                            });

                        } else {
                            console.log('Already downvoted');
                        }
                    });

            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    function checkIfJumbotronIsFull() {
        var limit = 3;
        if ($('#jumbotron_tbody').find('.selected-st').length === limit) {
            makeJumboRows(3);
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

    function updateBadges() {
        $('.badge').each(function () {
            var thisVal = $(this).text();
            if (thisVal < 0) {
                $(this).css("background-color", "#a94442");
            } else if (thisVal > 0) {
                $(this).css("background-color", "#3c763d");
            }
        });
    }

});