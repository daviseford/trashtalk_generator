const Config = require('./config')
const { updateBadges } = require('./utils')

const makeRecentList = () => {
  $.ajax({
    url: Config.endpoint + '/recent',
    contentType: "application/json; charset=utf-8",
    type: "GET",
    success: function (res) {
      let listRowHolder;
      if (res.data.length === 0) {
        listRowHolder = ['<li class="list-group-item text-center" id="recentid_0">No results found.</li>']
      } else {
        const r = res.data.sort((a, b) => b.createdAt - a.createdAt)
        listRowHolder = r.map(x => {
          return '<li class="list-group-item" id="recentid_' +
            x.id + '"><span class="badge">' + x.net_votes + '</span> ' +
            x.submission + '</li>';
        })
      }
      var listRowsJoined = listRowHolder.join('\n');
      $('#recent_listGroup').html(listRowsJoined);
      updateBadges();
    },
    error: function (data) {
      console.error('Error in makeRecentList', data);
    }
  });
}

module.exports = makeRecentList;