window.addEventListener('load', function() {

  var modals = document.querySelectorAll(".modal");
  var buttons = document.querySelectorAll(".modal-button");
  var closeButtons = document.querySelectorAll(".close");

  handlePageLinks();

  buttons.forEach(function(button, index) {
    button.addEventListener("click", function() {
      modals[index].style.display = "block";
    });
  });

  closeButtons.forEach(function(closeButton) {
    closeButton.addEventListener("click", function() {
      modals.forEach(function(modal) {
        modal.style.display = "none";
      });
    });
  });

  var thisHref, slideName;
  function handlePageLinks(){
      document.querySelectorAll('.page-link').forEach(item => {
          item.addEventListener('click', event => {
              if ('ontouchstart' in document.documentElement){
                  event.preventDefault();
                  thisHref = item.getAttribute('href').replace('../','');
                  slideName = thisHref + '.zip'
                  com.veeva.clm.gotoSlide(slideName,"");
                  return;
              }
          });
      });
  }

});