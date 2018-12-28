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

  makeJumboRows(5);
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

  function makeJumboRows(limit) {

    $.ajax({
      url: Config.endpoint + '/old',
      contentType: "application/json; charset=utf-8",
      type: "GET",
      success: function (res) {
        assembleJumbotron(res.data);
      },
      error: function (err) {
        console.log('error', err)
      }
    });
  }

  function assembleJumbotron(data) {
    const jumbotron_tbody = $('#jumbotron_tbody');
    const rowHolder = data.filter(x => !!x.submission && x.submission.trim() !== '').map(x => {
      return '<tr id="jumboid_' + x.id + '"><td>' +
        '<span class="glyphicon glyphicon-arrow-up text-success" style="font-size:2.0em;"  aria-hidden="true"> </span> ' +
        '<span class="glyphicon glyphicon-arrow-down text-danger" style="font-size:2.0em;" aria-hidden="true"> </span>' +
        '</td><td><h4 id="jumboh4_' + x.id + '">' + x.submission + '</h4></td></tr>';
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

      const id = parent.attr('id').split('_')[1];
      const submission = $(`#jumboh4_${id}`).text()
      const suffix = isUpvote ? 'upvote' : 'downvote';

      $.ajax({
        url: Config.endpoint + '/' + suffix,
        contentType: "application/json; charset=utf-8",
        type: "POST",
        data: JSON.stringify({ id, submission }),
        dataType: 'json',
        success: function (data) {
          parent.addClass(isUpvote ? 'bg-success' : 'bg-danger');
          checkIfJumbotronIsFull();
          return false;
        },
        error: function (data) {
          console.error(data);
          return false;
        }
      });
    }
  }

  const checkIfJumbotronIsFull = () => {
    const jumboLimit = 5;
    if ($('#jumbotron_tbody').find('.selected-st').length >= jumboLimit) {
      makeJumboRows(jumboLimit);
      makeRecentList();
      makeTopList();
    }
  }

});