const Config = require('./config')
const Submit = require('./submit')
/**
 * Created by Davis on 12/31/2015.
 */
$(document).ready(function () {


  $.ajax({
    url: Config.endpoint,
    contentType: "application/json; charset=utf-8",
    type: "GET",
    success: function (res) {
      console.log(res)

      const sortedResults = res.data.sort(function (a, b) {
        // Turn your strings into dates, and then subtract them
        // to get a value that is either negative, positive, or zero.
        return new Date(b.createdAt) - new Date(a.createdAt);
      });
      const recent = sortedResults.slice(0, 21)

      const splitObj = {
        recent,
      }
console.log(splitObj)
      
    },
    error: function (data) {
      console.error('Error in fetch', data);
    }
  });




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

  $('#create_shittalk_Btn').click(Submit);

  function makeRecentList() {
    $.ajax({
      url: Config.endpoint + '/recent',
      contentType: "application/json; charset=utf-8",
      type: "GET",
      success: function (res) {
        console.log(res)

        const sortedResults = res.data.sort(function (a, b) {
          // Turn your strings into dates, and then subtract them
          // to get a value that is either negative, positive, or zero.
          return new Date(b.createdAt) - new Date(a.createdAt);
        });

        var listRowHolder = sortedResults.map(x => {
          return '<li class="list-group-item" id="recentid_' +
            x.id + '"><span class="badge">' + x.net_votes + '</span> ' +
            x.submission + '</li>';
        })
        var listRowsJoined = listRowHolder.join('\n');
        $('#recent_listGroup').html(listRowsJoined);
        updateBadges();
      },
      error: function (data) {
        console.error('Error in makeRecentList', data);
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
            var send = sendVote.bind(this);
            send(true, false);
          });

        rate_more_tbody.find('td .glyphicon-arrow-down')
          .click(function (e) {
            e.preventDefault();
            var send = sendVote.bind(this);
            send(false, false);
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
        console.log('jumob data', data)
        assembleJumbotron(data);
      },
      error: function (err) {
        console.log('error', err)
      }
    });
  }

  function assembleJumbotron(data) {
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
        var send = sendVote.bind(this);
        send(true, true);
      });


    jumbotron_tbody.find('td .glyphicon-arrow-down')
      .click(function (e) {
        e.preventDefault();
        var send = sendVote.bind(this);
        send(false, true);
      });
  }

  function sendVote(isUpvote, isJumbo) {
    if ($(this).is('[disabled=disabled]') !== true) {
      var parent = $(this).parent().parent();
      $(this).attr('disabled', 'disabled');
      if (isJumbo) {
        parent.addClass('selected-st');
      }

      var query = {};
      var id = parent.attr('id');
      query['id'] = id.split('_')[1];
      query['query'] = isUpvote ? 'upvote_Row' : 'downvote_Row';

      $.ajax({
        url: "php/controller/controller.php",
        contentType: "application/json; charset=utf-8",
        type: "POST",
        dataType: 'json',
        data: JSON.stringify(query),
        success: function () {
          parent.addClass(isUpvote ? 'bg-success' : 'bg-danger');
          if (isJumbo) {
            checkIfJumbotronIsFull();
          } else {
            checkIfRateMoreIsFull();
          }
        },
        error: function (data) {
          console.log(data);
        }
      });
    }
  }

  function checkIfJumbotronIsFull() {
    if ($('#jumbotron_tbody').find('.selected-st').length === 3) {
      makeJumboRows(3);
    }
  }

  function checkIfRateMoreIsFull() {
    var tbody = $('#rate_more_tbody');
    var tbodySuccessCount = tbody.find('.bg-success').length;
    var tbodyDangerCount = tbody.find('.bg-danger').length;
    var rowsUsed = tbodyDangerCount + tbodySuccessCount;
    if (rowsUsed === 25) {
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