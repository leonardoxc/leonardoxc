function createjsDOMenu() {
  mainMenu = new jsDOMenu(120);
  with (mainMenu) {
    addMenuItem(new menuItem("Item 1", "", "example.htm"));
    addMenuItem(new menuItem("Item 2", "item2", "example.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "", "example.htm"));
    addMenuItem(new menuItem("Item 4", "", "example.htm"));
  }
  subMenu = new jsDOMenu(140);
  with (subMenu) {
    addMenuItem(new menuItem("Item 1", "", "example.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 2", "", "example.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "", "example.htm"));
    addMenuItem(new menuItem("Item 4", "", "example.htm"));
  }
  mainMenu.items.item2.setSubMenu(subMenu);
  setPopUpMenu(mainMenu);
  activatePopUpMenuBy(0, 0);
}