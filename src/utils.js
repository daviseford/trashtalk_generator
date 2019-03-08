const send_to_ga = (val) => {
  try {
    ga('send', 'event', 'button', 'click', val);
  } catch (err) {
    // pass
  }
}

const updateBadges = () => {
  $('.badge').each(function () {
    const val = parseInt($(this).text() || 0, 10);
    const status = val === 0 ? 'secondary' : val > 0 ? 'success' : 'danger'
    const badgeClass = `badge badge-pill badge-${status}`
    $(this).attr('class', badgeClass);
  });
}

module.exports = {
  updateBadges,
  send_to_ga,
}