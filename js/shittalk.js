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
            // scroll
            makeIncludedBindCount();
            makeTotalBindCount();
            makeRateMoreTableRows();
            //console.log('scrolled');
        });
    });

    $('#create_shittalk_Btn')
        .button()
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

                var duplicateRequest = queryController(form);
                duplicateRequest.done(function (data) {
                    //console.log(data);

                    if (data < 1) { // i.e. not a duplicate
                        var form2 = {};
                        form2['create_shittalk_Text'] = shittalkText;
                        form2['query'] = 'create_Shittalk';

                        var request = queryController(form2);
                        request.done(function (data) {
                            //console.log(data);
                            if (data === true) {
                                console.log('Submission successful');
                                location.reload();
                            }
                        });
                    } else {
                        parent.addClass('has-error');
                        $('#helpBlock').removeClass('hidden');
                    }

                });
            }
        });


    function makeRecentList() {
        var post = {};
        post['query'] = 'get_RecentList';
        var request = queryController(post);
        request.done(function (data) {
            var listRows = data.join('\n');
            $('#recent_listGroup').html(listRows);
            updateBadges();
        });
    }

    function makeTopList() {
        var post = {};
        post['query'] = 'get_TopList';
        var request = queryController(post);
        request.done(function (data) {
            var listRows = data.join('\n');
            $('#top_listGroup').html(listRows);
            updateBadges();
        });
    }

    function makeRandomList() {
        var post = {};
        post['query'] = 'get_RandomList';
        var request = queryController(post);
        request.done(function (data) {
            var listRows = data.join('\n');
            $('#random_listGroup').html(listRows);
            updateBadges();
        });
    }


    function makeRateMoreTableRows() {
        var post = {};
        post['query'] = 'get_RateMoreTableRows';
        var request = queryController(post);
        request.done(function (data) {
            var rate_more_tbody = $('#rate_more_tbody');
            var tableRows = data.join('\n');
            rate_more_tbody.html(tableRows);

            rate_more_tbody.find('td .glyphicon-arrow-up')
                .button()
                .click(function (e) {
                    e.preventDefault();

                    if ($(this).is('[disabled=disabled]') !== true) {

                        //console.log('upvoted!');
                        var parent = $(this).parent().parent();

                        $(this).attr('disabled', 'disabled');

                        var query = {};
                        var id = parent.attr('id');
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
                        console.log('Already upvoted');
                    }
                });

            rate_more_tbody.find('td .glyphicon-arrow-down')
                .button()
                .click(function (e) {
                    e.preventDefault();
                    if ($(this).is('[disabled=disabled]') !== true) {

                        //console.log('downvoted!');
                        var parent = $(this).parent().parent();

                        $(this).attr('disabled', 'disabled');

                        var query = {};
                        var id = parent.attr('id');
                        query['id'] = id.split('_')[1];
                        query['query'] = 'downvote_Row';
                        var request = queryController(query);
                        request.done(function (data) {
                            //console.log(data);
                            parent.addClass('bg-danger');
                            checkIfRateMoreIsFull();
                        });
                    } else {
                        console.log('Already downvoted');
                    }
                });
            updateBadges();
        });
    }

    function makeTotalBindCount() {
        var post = {};
        post['query'] = 'get_TotalBindCount';
        var request = queryController(post);
        request.done(function (data) {
            var count = data;
            $('#TotalBindCount').text(count);
        });
    }

    function makeIncludedBindCount() {
        var post = {};
        post['query'] = 'get_IncludedBindCount';
        var request = queryController(post);
        request.done(function (data) {
            var count = data;
            $('#IncludedBindCount').text(count);
        });
    }

    function makeJumboRows(limit) {
        var post = {};
        post['query'] = 'get_RandomRows';
        post['limit'] = limit;
        var request = queryController(post);
        request.done(function (data) {
            //console.log(data);
            var jumbotron_tbody = $('#jumbotron_tbody');
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
                jumbotron_tbody.html(rowHolder);
            }


            jumbotron_tbody.find('td .glyphicon-arrow-up')
                .button()
                .click(function (e) {
                    e.preventDefault();
                    if ($(this).is('[disabled=disabled]') !== true) {

                        //console.log('upvoted!');
                        var parent = $(this).parent().parent();

                        $(this).attr('disabled', 'disabled');
                        parent.addClass('selected-st');

                        var query = {};
                        var id = parent.attr('id');
                        query['id'] = id.split('_')[1];
                        query['query'] = 'upvote_Row';
                        var request = queryController(query);
                        request.done(function (data) {
                            //console.log(data);
                            parent.addClass('bg-success');
                            checkIfJumbotronIsFull();

                        })
                    } else {
                        console.log('Already upvoted');
                    }
                });


            jumbotron_tbody.find('td .glyphicon-arrow-down')
                .button()
                .click(function (e) {
                    e.preventDefault();
                    if ($(this).is('[disabled=disabled]') !== true) {

                        ////console.log('downvoted!');
                        var parent = $(this).parent().parent();

                        $(this).attr('disabled', 'disabled');
                        parent.addClass('selected-st');

                        var query = {};
                        var id = parent.attr('id');
                        query['id'] = id.split('_')[1];
                        query['query'] = 'downvote_Row';
                        var request = queryController(query);
                        request.done(function (data) {
                            //console.log(data);
                            parent.addClass('bg-danger');
                            checkIfJumbotronIsFull();
                        });
                    } else {
                        console.log('Already downvoted');
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