/**
 * Particleground demo
 * @author Jonathan Nicol - @mrjnicol
 */

$(document).ready(function() {
  $('#particles').particleground({
    dotColor: '#fff',
    lineColor: '#fff'
  });
  $('#particles').css({
    'height': $(window).height()+'px',
    'background-color': '#48b38c'
  });
});