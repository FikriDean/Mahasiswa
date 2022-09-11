$( document ).ready(function() {
  const width = window.screen.width;

  width <= 1200 ? $('#head').hide() : $('#head').show();

  live-search
  ajax
  const keyword = document.getElementById('input-search');
  const table = document.getElementById('table');

  keyword.addEventListener('keyup', function() {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        table.innerHTML = xhr.responseText;
      }
    }

    xhr.open("GET", "data.php?keyword=" + keyword.value, true);
    xhr.send();
  })

  // jquery
  $('#input-search').on('keyup', function() {
    $('#table').load('data.php?keyword=' + $(this).val());
  })

  
});