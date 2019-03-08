const Config = require('./config')
const { updateBadges } = require('./utils')

/**
 * endpoint: string - e.g. 'random'
 * sortFn: function|null - e.g. (a, b) => b.createdAt - a.createdAt
 */
module.exports = (endpoint, sortFn) => {
  $.ajax({
    url: `${Config.endpoint}/${endpoint}`,
    contentType: "application/json; charset=utf-8",
    type: "GET",
    error: (err) => console.error(err),
    success: function (res) {
      let listRowHolder;
      if (res.data.length === 0) {
        listRowHolder = [`<li class="list-group-item text-center" id="${endpoint}id_0">No results found.</li>`]
      } else {
        const r = sortFn ? res.data.sort(sortFn) : res.data
        listRowHolder = r.map(x => {
          return `
          <li class="list-group-item" id="${endpoint}id_${x.id}">
            <div class="row h-100">
              <div class="col-2 align-middle align-self-center">
                <h5>
                  <span class="badge badge-pill badge-secondary">${x.net_votes}</span>
                </h5>
              </div>
              <div class="col"><span>${x.submission}</span></div>
            </div>
          </li>`
        })
      }
      const listRowsJoined = listRowHolder.join('\n');
      $(`#${endpoint}_listGroup`).html(listRowsJoined);
      updateBadges();
    }
  })
}