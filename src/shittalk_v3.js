const Config = require('./config')
const Submit = require('./submit')
const PreloadedInsults = require('./preload')
const _ = require('lodash')
const ListComponent = require('./list_component')
const { send_to_ga } = require('./utils')

/**
 * Created by Davis on 12/31/2015.
 * Moved to serverless setup on 8/26/2018 :)
 * Added shittalk.cfg serverless generation on 2/03/2019
 */
$(document).ready(function () {
  const loadQuote = () => $('#funText').html(_.sample(PreloadedInsults).trim())
  const loadData = () => {
    makeJumboRows();
    ListComponent('recent', (a, b) => b.createdAt - a.createdAt)
    ListComponent('random', null)
    ListComponent('top', (a, b) => b.net_votes - a.net_votes)
    loadQuote()
  }

  loadData();

  $('#create_shittalk_Btn').click(Submit);

  // When the download button is clicked, regenerate shittalk.cfg on S3
  $('#downloadBtn').click((e) => {
    send_to_ga('shittalk_download')
    $.ajax({
      url: Config.endpoint + '/generate_cfg',
      contentType: "application/json; charset=utf-8",
      type: "GET",
      success: (res) => console.log('Regenerated shittalk.cfg'),
      error: (err) => console.error(err)
    });
  })

  function makeJumboRows() {
    $.ajax({
      url: Config.endpoint + '/old',
      contentType: "application/json; charset=utf-8",
      type: "GET",
      success: function (res) {
        assembleJumbotron(res.data);
      },
      error: (err) => console.log(err)
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
          send_to_ga(`shittalk_${isUpvote ? 'up' : 'down'}vote`)
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
    if ($('#jumbotron_tbody').find('.selected-st').length >= $('#jumbotron_tbody tr').length) {
      loadData()
    }
  }
});