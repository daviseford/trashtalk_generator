const Config = require('./config')
const Submit = require('./submit')
const makeTopList = require('./top')
const makeRecentList = require('./recent')
const { updateBadges } = require('./utils')

/**
 * Created by Davis on 12/31/2015.
 * Moved to serverless setup on 8/26/2018 :)
 */
$(document).ready(function () {

  makeJumboRows(3);
  makeRecentList();
  makeTopList();
  // makeRandomList();

  $('#create_shittalk_Btn').click(Submit);


  // function makeRandomList() {
  //   var post = {};
  //   post['query'] = 'get_RandomList';
  //   $.ajax({
  //     url: "php/controller/controller.php",
  //     contentType: "application/json; charset=utf-8",
  //     type: "POST",
  //     dataType: 'json',
  //     data: JSON.stringify(post),
  //     success: function (data) {
  //       var listRowHolder = [];
  //       for (var i = 0; i < data.length; i++) {
  //         var listObject = data[i];
  //         var id = listObject['id'] || '';
  //         var netVotes = listObject['netVotes'] || '';
  //         var text = listObject['text'] || '';
  //         if (id !== '' && netVotes !== '' && text !== '') {
  //           var listRow = '<li class="list-group-item" id="randomid_' + id + '"><span class="badge">' + netVotes + '</span> ' + text + '</li>';
  //           listRowHolder.push(listRow);
  //         }
  //       }
  //       var listRowsJoined = listRowHolder.join('\n');
  //       $('#random_listGroup').html(listRowsJoined);
  //       updateBadges();
  //     },
  //     error: function (data) {
  //       console.log(data);
  //     }
  //   });
  // }

  // TODO:
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
    rowHolder = data.map(x => {
      return '<tr id="jumboid_' + x.id + '"><td>' +
        '<span class="glyphicon glyphicon-arrow-up text-success" style="font-size:2.0em;"  aria-hidden="true"> </span> ' +
        '<span class="glyphicon glyphicon-arrow-down text-danger" style="font-size:2.0em;" aria-hidden="true"> </span>' +
        '</td><td><h4>' + x.submission + '</h4></td></tr>';
    })


    jumbotron_tbody.html(rowHolder.join('\n'));


    jumbotron_tbody.find('td .glyphicon-arrow-up')
      .click(function (e) {
        e.preventDefault();
        var send = sendVote.bind(this);
        send(true);
      });


    jumbotron_tbody.find('td .glyphicon-arrow-down')
      .click(function (e) {
        e.preventDefault();
        var send = sendVote.bind(this);
        send(false);
      });
  }

  function sendVote(isUpvote) {
    if ($(this).is('[disabled=disabled]') !== true) {
      var parent = $(this).parent().parent();
      $(this).attr('disabled', 'disabled');

      parent.addClass('selected-st');

      var id = parent.attr('id').split('_')[1];
      // query['id'] = id.split('_')[1];
      const action = isUpvote ? 'upvote' : 'downvote';

      $.ajax({
        url: Config.endpoint + '/' + action + '/' + id,
        contentType: "application/json; charset=utf-8",
        type: "POST",
        dataType: 'json',
        data: JSON.stringify({ id }),
        success: function () {
          parent.addClass(isUpvote ? 'bg-success' : 'bg-danger');
          checkIfJumbotronIsFull();
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




});