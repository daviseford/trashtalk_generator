const { updateBadges } = require('./utils')

/**
 * selector: string - e.g. 'random', 'recent', 'top'
 * 
 */
module.exports = (selector, data) => {
  let listRowHolder;
  if (data.length === 0) {
    listRowHolder = [`<li class="list-group-item text-center" id="${selector}id_0">No results found.</li>`]
  } else {
    listRowHolder = data.map(x => {
      return `
          <li class="list-group-item" id="${selector}id_${x.id}">
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
  $(`#${selector}_listGroup`).html(listRowHolder.join('\n'));
  updateBadges();
}