function createjsDOMenu() {
  
  staticMenu1_1 = new jsDOMenu(130, "absolute");
  with (staticMenu1_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "item3", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
  }
  
  staticMenu1_2 = new jsDOMenu(120, "cursor");
  with (staticMenu1_2) {
    addMenuItem(new menuItem("Item 1", "item1", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "item3", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
  }
    
  staticMenu1_3 = new jsDOMenu(250, "absolute");
  with (staticMenu1_3) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
    addMenuItem(new menuItem("Item 5", "", "blank.htm"));
  }
 

   staticMenu1 = new jsDOMenuBar("static", "staticMenu",false,"jsdomenubardiv",500);
 // staticMenu1 = new jsDOMenuBar("absolute", "", true);
  with (staticMenu1) {
    addMenuBarItem(new menuBarItem("XC League by Country", staticMenu1_1));
    addMenuBarItem(new menuBarItem("Select Country", staticMenu1_2));
    addMenuBarItem(new menuBarItem("Show Pilots", staticMenu1_3));
//    addMenuBarItem(new menuBarItem("Item 4", "", "", true, "blank.htm"));
//    addMenuBarItem(new menuBarItem("Item 5", "", "item5", true, "blank.htm"));
	// show();    
  }
 
  /*staticMenu1.items.item1.setSubMenu(staticMenu1_1);
  staticMenu1.items.item2.setSubMenu(staticMenu1_2);
  staticMenu1_1.items.item3.setSubMenu(staticMenu1_1_1);
  staticMenu1_2.items.item1.setSubMenu(staticMenu1_2_1);
  staticMenu1_2.items.item3.setSubMenu(staticMenu1_2_2);
*/

}