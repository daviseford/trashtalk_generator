const Config = require('./config')
const { updateBadges } = require('./utils')



const error = (error) => {
  console.error(`Error in ListComponent(${endpoint}, ${selector})`, error);
}

/**
 * endpoint: string - e.g. 'random'
 * sortFn: function|null - e.g. (a, b) => b.createdAt - a.createdAt
 */
module.exports = (endpoint, sortFn) => {
  $.ajax({
    url: `${Config.endpoint}/${endpoint}`,
    contentType: "application/json; charset=utf-8",
    type: "GET",
    error,
    success: function (res) {
      let listRowHolder;
      if (res.data.length === 0) {
        listRowHolder = [`<li class="list-group-item text-center" id="${endpoint}id_0">No results found.</li>`]
      } else {
        const r = sortFn ? res.data.sort(sortFn) : res.data
        listRowHolder = r.map(x => {
          return `<li class="list-group-item" id="${endpoint}id_${x.id}">
                    <span class="badge">${x.net_votes}</span> ${x.submission}
                  </li>`
        })
      }
      const listRowsJoined = listRowHolder.join('\n');
      $(`#${endpoint}_listGroup`).html(listRowsJoined);
      updateBadges();
    }
  })
}