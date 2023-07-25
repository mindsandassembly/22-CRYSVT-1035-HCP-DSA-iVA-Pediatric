window.addEventListener('load', function() {

  let metaTag = document.querySelector("meta[name=viewport]");
  // console.log(metaTag);
  if (metaTag) {
    const clientWidth = document.documentElement.clientWidth;
    if (clientWidth <= 1194) {
      metaTag.setAttribute('content', 'width=device-width, initial-scale=.8, user-scalable=no');
    } else if (clientWidth < 1360) {
      metaTag.setAttribute('content', 'width=device-width, initial-scale=.8, user-scalable=no');
    } else { 
      metaTag.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
    }
  }

  var modals = document.querySelectorAll(".modal");
  var buttons = document.querySelectorAll(".modal-button");
  var closeButtons = document.querySelectorAll(".close");

  handlePageLinks();

  buttons.forEach(function(button, index) {
    button.addEventListener("click", function() {
      modals[index].style.display = "block";
      let vid = document.getElementById('vid');
      if (vid) { 
        vid.play();
      }
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