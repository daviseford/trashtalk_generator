const Config = require('./config')
const { updateBadges } = require('./utils')




const makeTopList = () => {
  $.ajax({
    url: Config.endpoint + '/top',
    contentType: "application/json; charset=utf-8",
    type: "GET",
    success: function (res) {
      let listRowHolder;
      if (res.data.length === 0) {
        listRowHolder = ['<li class="list-group-item text-center" id="recentid_0">No results found.</li>']
      } else {
        listRowHolder = res.data.map(x => {
          return '<li class="list-group-item" id="topid_' + x.id + '"><span class="badge">' + x.net_votes + '</span> ' + x.submission + '</li>';
        })
      }
      const listRowsJoined = listRowHolder.join('\n');
      $('#top_listGroup').html(listRowsJoined);
      updateBadges();
    },
    error: function (data) {
      console.log(data);
    }
  });
}

module.exports = makeTopList;