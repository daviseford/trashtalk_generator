
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
      updateBadges
  }