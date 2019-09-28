document.addEventListener("DOMContentLoaded", function(event) {

  /*
  ** Start mobile filters
  */
  let filtersFab = document.querySelector('.js-filters-fab'),
      sidebar = document.querySelector('.js-sidebar');


  filtersFab.addEventListener('click', function() {
    sidebar.classList.toggle('is-active');
    console.log('Clicked');
  });
  //end


});
