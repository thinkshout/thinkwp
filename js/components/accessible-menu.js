export default ($) => {
  const axsMenuItem = $('.accessible-menu li.menu-item-has-children');
  $('.accessible-menu li.menu-item-has-children button').attr('aria-expanded','false');

  axsMenuItem.each(function() {
    const activatingA = $(this).children('a');
    const buttonLabel = `Open submenu for “${activatingA.text()}”`
    const btn = `<button class="reset menu-chevron"><span class="screen-reader-text">${buttonLabel}</span></button>`;
    activatingA.after(btn);

    $(this).find('button').on('click', function(event){
      event.stopPropagation()
      const li = $(this).closest('li.menu-item-has-children').toggleClass('open');
      const isOpen = li.hasClass('open');
      $(this).attr('aria-expanded', isOpen ? 'true' : 'false');
      $(this).children('span.screen-reader-text').text(isOpen ? buttonLabel.replace('Open', 'Close') : buttonLabel);
    });
  });

  $('.main-navigation > .accessible-menu > .menu-item > .menu-link').on('focus', function(){
    axsMenuItem.removeClass('open').find('button').attr('aria-expanded', 'false');
  });
};