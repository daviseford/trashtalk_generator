const send_to_ga = (val) => {
  try {
    ga('send', 'event', 'button', 'click', val);
  } catch (err) {
    // pass
  }
}

const updateBadges = () => {
    $('.badge').each(function () {
      var thisVal = $(this).text();
      if (thisVal < 0) {
        $(this).css("background-color", "#a94442");
      } else if (thisVal > 0) {
        $(this).css("background-color", "#3c763d");
      }
    });
  }

  module.exports = {
      updateBadges,
      send_to_ga,
  }