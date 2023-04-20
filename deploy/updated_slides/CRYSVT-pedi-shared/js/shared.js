window.addEventListener('load', function() {
  // var metaTag;
  if (document.documentElement.clientWidth < 1360) {
      // alert(document.documentElement.clientWidth);
      let metaTag = document.getElementsByTagName('meta');

      // metaTag=document.createElement('meta');
      // metaTag.name = "viewport";
      metaTag.content = "width=device-width, initial-scale=.8";
      // document.getElementsByTagName('head')[0].appendChild(metaTag);

  } 

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