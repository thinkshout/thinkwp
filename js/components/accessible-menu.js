export default ($) => {
  const axsMenuItem = $('.accessible-menu li.menu-item-has-children');
  $('.accessible-menu li.menu-item-has-children button').attr('aria-expanded','false');

  axsMenuItem.each(function() {
    const activatingA = $(this).children('a');
    const btn = '<button class="reset menu-chevron" tabindex="2"><span class="visually-hidden">show submenu for “' + activatingA.text() + '”</span></button>';
    activatingA.after(btn);

    $(this).find('button').on('click', function(event){
      event.stopPropagation()
      const li = $(this).closest('li.menu-item-has-children').toggleClass('open');
      $(this).attr('aria-expanded', li.hasClass('open') ? 'true' : 'false');
    });
  });

  $('.menu-block-wrapper > ul.menu > li > a').on('focus', function(){
    axsMenuItem.removeClass('open').find('button').attr('aria-expanded', 'false');
  });
};