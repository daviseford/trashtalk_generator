const _ = require('lodash')
const { send_to_ga } = require('./utils')
const Config = require('./config')
const CreateListComponent = require('./list_component')
const PreloadedInsults = require('./preload')
const Submit = require('./submit')

/**
 * Created by Davis on 12/31/2015.
 * Moved to serverless setup on 8/26/2018 :)
 * Added shittalk.cfg serverless generation on March 3rd, 2019
 * Added Bootstrap4 on March 8th, 2019
 */
$(document).ready(function () {
  const loadQuote = () => $('#funText').html(_.sample(PreloadedInsults).trim())
  const loadData = () => {
    makeJumboRows();
    CreateListComponent('recent', (a, b) => b.createdAt - a.createdAt)
    CreateListComponent('random', null)
    CreateListComponent('top', (a, b) => b.net_votes - a.net_votes)
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
    const rowHolder = data.filter(x => x.submission && x.submission.trim() !== '').map(x => {
      return `
        <tr id="jumboid_${x.id}">
          <td class="align-middle">
            <span class="oi oi-arrow-thick-top text-success" style="font-size:2.0em;" aria-hidden="true"> </span>
            <span class="oi oi-arrow-thick-bottom text-danger" style="font-size:2.0em;" aria-hidden="true"> </span>
          </td>
          <td class="align-middle">
            <h5 id="jumboh5_${x.id}">${x.submission}</h5>
          </td>
        </tr>
        `
    })

    jumbotron_tbody.html(rowHolder.join('\n'));

    jumbotron_tbody.find('td .oi-arrow-thick-top')
      .click(function (e) {
        e.preventDefault();
        const send = sendVote.bind(this);
        send(true);
      });

    jumbotron_tbody.find('td .oi-arrow-thick-bottom')
      .click(function (e) {
        e.preventDefault();
        const send = sendVote.bind(this);
        send(false);
      });
  }

  function sendVote(isUpvote) {
    if ($(this).is('[disabled=disabled]') !== true) {
      const table_row = $(this).parent().parent();
      $(this).attr('disabled', 'disabled');

      const id = table_row.attr('id').split('_')[1];
      const submission = $(`#jumboh5_${id}`).text()
      const suffix = isUpvote ? 'upvote' : 'downvote';

      // Hide both voting arrows
      $(this).parent().children().attr('class', 'd-none')

      // Turn submission text to a legible color (it's on a dark background now!)
      $(`#jumboh5_${id}`).attr('class', 'text-light')

      // Add background color
      table_row.addClass('selected-st');
      table_row.addClass(isUpvote ? 'bg-success' : 'bg-danger');

      $.ajax({
        url: `${Config.endpoint}/${suffix}`,
        contentType: "application/json; charset=utf-8",
        type: "POST",
        data: JSON.stringify({ id, submission }),
        dataType: 'json',
        success: function (data) {
          checkIfJumbotronIsFull();
          send_to_ga(`shittalk_${suffix}`)
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