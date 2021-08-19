/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function() {
  let masthead, container, button, menu, links, site, buttonLabel;

  site = document.getElementsByTagName("html")[0];

  masthead = document.getElementById("masthead");

  container = document.getElementById("site-navigation");
  if (!container) {
    return;
  }

  button = container.getElementsByTagName("button")[0];
  if ("undefined" === typeof button) {
    return;
  }
  
  buttonLabel = button.querySelector("span.screen-reader-text");

  menu = container.getElementsByTagName("ul")[0];

  // Hide menu toggle button if menu is empty and return early.
  if ("undefined" === typeof menu) {
    button.style.display = "none";
    return;
  }

  menu.setAttribute("aria-expanded", "false");
  if (-1 === menu.className.indexOf("nav-menu")) {
    menu.className += " nav-menu";
  }

  button.onclick = function() {
    if (-1 !== container.className.indexOf("toggled")) {
      container.className = container.className.replace(" toggled", "");
      button.setAttribute("aria-expanded", "false");
      buttonLabel.innerHTML = `${buttonLabel.innerHTML.replace('Close', 'Open')}`;
      menu.setAttribute("aria-expanded", "false");
      masthead.classList.remove("menu-toggled");
      site.classList.remove("scroll-locked");
    } else {
      container.className += " toggled";
      button.setAttribute("aria-expanded", "true");
      buttonLabel.innerHTML = `${buttonLabel.innerHTML.replace('Open', 'Close')}`;
      menu.setAttribute("aria-expanded", "true");
      masthead.classList.add("menu-toggled");
      site.classList.add("scroll-locked");
    }
  };

  // Get all the link elements within the menu.
  links = menu.getElementsByTagName("a");

  // Each time a menu link is focused or blurred, toggle focus.
  for (let i = 0, len = links.length; i < len; i++) {
    links[i].addEventListener("focus", toggleFocus, true);
    links[i].addEventListener("blur", toggleFocus, true);
  }

  /**
   * Sets or removes .focus class on an element.
   */
  function toggleFocus() {
    let self = this;

    // Move up through the ancestors of the current link until we hit .nav-menu.
    while (-1 === self.className.indexOf("nav-menu")) {
      // On li elements toggle the class .focus.
      if ("li" === self.tagName.toLowerCase()) {
        if (-1 !== self.className.indexOf("focus")) {
          self.className = self.className.replace(" focus", "");
        } else {
          self.className += " focus";
        }
      }

      self = self.parentElement;
    }
  }

  /**
   * Toggles `focus` class to allow submenu access on tablets.
   */
  (function(container) {
    let touchStartFn;
    let parentLink = container.querySelectorAll(
      ".menu-item-has-children > a, .page_item_has_children > a"
    );

    if ("ontouchstart" in window) {
      touchStartFn = function(e) {
        const menuItem = this.parentNode;

        if (!menuItem.classList.contains("focus")) {
          e.preventDefault();
          for (let i = 0; i < menuItem.parentNode.children.length; ++i) {
            if (menuItem === menuItem.parentNode.children[i]) {
              continue;
            }
            menuItem.parentNode.children[i].classList.remove("focus");
          }
          menuItem.classList.add("focus");
        } else {
          menuItem.classList.remove("focus");
        }
      };

      for (let i = 0; i < parentLink.length; ++i) {
        parentLink[i].addEventListener("touchstart", touchStartFn, false);
      }
    }
  })(container);
})();
