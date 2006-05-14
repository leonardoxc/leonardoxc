/*

  jsDOMenuBar Version 1.2 BETA
  Copyright (C) 2004 - 2005 Toh Zhiqiang
  Released on ??? 2005
  jsDOMenuBar is distributed under the terms of the GNU GPL license
  Refer to license.txt for more informatiom

*/

/*
Get the left position of the menu bar menu.
*/
function getMainMenuBarMenuLeftPos(menuBarObj, menuBarItemObj, menuObj, x) { // Private method
  if (x + menuObj.offsetWidth <= getClientWidth()) {
    return x;
  }
  else {
    var pos = x + menuBarItemObj.offsetWidth - menuObj.offsetWidth + getPropIntVal(menuObj, blw) + getPropIntVal(menuObj, brw);
    return pos < 0 ? 0 : pos;
  }
}

/*
Get the top position of the menu bar menu.
*/
function getMainMenuBarMenuTopPos(menuBarObj, menuBarItemObj, menuObj, y) { // Private method
  if (y + menuObj.offsetHeight <= getClientHeight()) {
    return y;
  }
  else {
    /*
    if ((ie55 || ie6) && menuBarObj.mode == "static" && pageMode == 0) {
      y = menuBarObj.offsetTop + menuBarObj.offsetHeight - getScrollTop();
    }
    */
    var pos = y - menuObj.offsetHeight - menuBarObj.offsetHeight;
    return pos < 0 ? 0 : pos;
    /*
    if ((ie55 || ie6) && menuBarObj.mode == "static" && pageMode == 1) {
      
      return menuBarItemObj.offsetTop 
           - menuObj.offsetHeight 
           - getPropIntVal(menuBarObj, pt) 
           + getPropIntVal(menuBarItemObj, pt) 
           + getPropIntVal(menuBarItemObj, btw) 
           - getScrollTop();
      
      return y - menuObj.offsetHeight - menuBarObj.offsetHeight;
    }
    else {
      return y - menuObj.offsetHeight - menuBarObj.offsetHeight;
    }
    */
  }
}

/*
Pop up the menu bar menu.
*/
function popUpMenuBarMenu(menuBarObj, menuBarItemObj, menuObj) { // Private method
  var x;
  var y;
  if (menuBarObj.style.position == "fixed") {
    x = menuBarObj.offsetLeft + menuBarItemObj.offsetLeft + getPropIntVal(menuBarObj, blw) - getPropIntVal(menuObj, blw);
    y = menuBarObj.offsetTop + menuBarObj.offsetHeight;
    if (opera || safari) {
      x -= getPropIntVal(menuBarObj, blw);
    }
    menuObj.style.position = "absolute";
    menuObj.style.left = getMainMenuBarMenuLeftPos(menuBarObj, menuBarItemObj, menuObj, x) + px;
    menuObj.style.top = getMainMenuBarMenuTopPos(menuBarObj, menuBarItemObj, menuObj, y) + px;
    menuObj.style.position = "fixed";
  }
  else {
    if (menuBarObj.mode == "static") {
        x = getLeft(menuBarItemObj) - getPropIntVal(menuObj, blw) - getScrollLeft();
        y = getTop(menuBarObj) + menuBarObj.offsetHeight - getScrollTop();
      if (ie55 || ie6) {
        //x = getLeft(menuBarItemObj) + getPropIntVal(menuBarObj, blw) - getPropIntVal(menuObj, blw) - getScrollLeft();  //TODO
        x += getPropIntVal(menuBarObj, blw);
        y = getTop(menuBarItemObj) + menuBarItemObj.offsetHeight + getPropIntVal(menuBarObj, btw) + getPropIntVal(menuBarObj, bbw) - getScrollTop();
      }
      /*
      else {
        x = getLeft(menuBarItemObj) - getPropIntVal(menuObj, blw) - getScrollLeft();
        //x -= getPropIntVal(menuBarObj, blw);
        y = getTop(menuBarObj) + menuBarObj.offsetHeight - getScrollTop();
        //y -= getPropIntVal(menuBarObj, btw) + getPropIntVal(menuBarObj, bbw);
      }
      */
      //alert(y);
      //+ menuBarObj.offsetHeight
      //alert(menuBarItemObj.offsetHeight);
      /*  menuBarItemObj.offsetHeight +    + 
      x = menuBarItemObj.offsetLeft - getPropIntVal(menuObj, blw) - getScrollLeft();
      y = menuBarObj.offsetTop + menuBarObj.offsetHeight - getScrollTop();
      if (ie55 || ie6) {
        x += getPropIntVal(menuBarObj, blw);
        y = menuBarItemObj.offsetTop + menuBarItemObj.offsetHeight 
          + getPropIntVal(menuBarObj, bbw) 
          + getPropIntVal(menuBarObj, pb) 
          - getPropIntVal(menuBarItemObj, bbw) 
          - getScrollTop();
      }
      if (safari) {
        x += 8;
        y += 13;
      }
      */
      menuObj.style.left = (getMainMenuBarMenuLeftPos(menuBarObj, menuBarItemObj, menuObj, x) + getScrollLeft()) + px;
      menuObj.style.top = (getMainMenuBarMenuTopPos(menuBarObj, menuBarItemObj, menuObj, y) + getScrollTop()) + px;
    }
    else {
      x = menuBarObj.offsetLeft + menuBarItemObj.offsetLeft + getPropIntVal(menuBarObj, blw) - getPropIntVal(menuObj, blw) - getScrollLeft();
      y = menuBarObj.offsetTop + menuBarObj.offsetHeight - getScrollTop();
      if (opera || safari) {
        x -= getPropIntVal(menuBarObj, blw);
      }
      menuObj.style.left = (getMainMenuBarMenuLeftPos(menuBarObj, menuBarItemObj, menuObj, x) + getScrollLeft()) + px;
      menuObj.style.top = (getMainMenuBarMenuTopPos(menuBarObj, menuBarItemObj, menuObj, y) + getScrollTop()) + px;
    }
  }
  if (ie && menuObj.mode == "fixed") {
    menuObj.initialLeft = parseInt(menuObj.style.left) - getScrollLeft();
    menuObj.initialTop = parseInt(menuObj.style.top) - getScrollTop();
  }
  //alert(menuObj.style.left + ":" + menuObj.style.top);
  menuObj.style.visibility = "visible";
}

/*
Deactivate the menu bar items.
*/
function deactivateMenuBarItems(menuBarObj) { // Private method
  var i = menuBarObj.childNodes.length - 1;
  if (i > -1) {
    do {
    //for (var i = 0, len = menuBarObj.childNodes.length; i < len; i++) {
      if (menuBarObj.childNodes[i].enabled && menuBarObj.childNodes[i].clicked) {
        menuBarObj.childNodes[i].className = menuBarObj.childNodes[i].itemClassName;
        if (menuBarObj.childNodes[i].iconObj) {
          menuBarObj.childNodes[i].iconObj.className = menuBarObj.childNodes[i].iconClassName;
        }
        menuBarObj.childNodes[i].clicked = false;
        if (menuBarObj.childNodes[i].menu) {
          hideMenus(menuBarObj.childNodes[i].menu.menuObj);
        }
        break;
      }
    } while (i--);
  }
  menuBarObj.activated = false;
}

/*
Event handler that handles onmouseover event of the menu bar item.
*/
function menuBarItemOver(e) { // Private method
  if (intervalId) {
    clearTimeout(intervalId);
  }
  if (this.parent.menuBarObj.activated) {
    if (!this.clicked) {
      var menuBarObj = this.parent.menuBarObj;
      var i = menuBarObj.childNodes.length - 1;
      if (i > -1) {
        do {
        //for (var i = 0, len = menuBarObj.childNodes.length; i < len; i++) {
          if (menuBarObj.childNodes[i].enabled && menuBarObj.childNodes[i].clicked) {
            menuBarObj.childNodes[i].className = menuBarObj.childNodes[i].itemClassName;
            if (menuBarObj.childNodes[i].iconObj) {
              menuBarObj.childNodes[i].iconObj.className = menuBarObj.childNodes[i].iconClassName;
            }
            menuBarObj.childNodes[i].clicked = false;
            if (menuBarObj.childNodes[i].menu) {
              hideMenus(menuBarObj.childNodes[i].menu.menuObj);
            }
            break;
          }
        } while (i--);
      }
      if (this.enabled) {
        if (this.menu) {
          this.onclick(e);
        }
        else {
          if (this.actionOnClick) {
            this.className = this.itemClassNameClick;
            if (this.iconObj && this.iconClassNameClick) {
              this.iconObj.className = this.iconClassNameClick;
            }
            this.clicked = true;
          }
        }
      }
    }
  }
  else {
    var menuBarObj = this.parent.menuBarObj;
    var i = menuBarObj.childNodes.length - 1;
    if (i > -1) {
      do {
      //for (var i = 0, len = menuBarObj.childNodes.length; i < len; i++) {
        if (menuBarObj.childNodes[i].enabled) {
          menuBarObj.childNodes[i].className = menuBarObj.childNodes[i].itemClassName;
          if (menuBarObj.childNodes[i].iconObj) {
            menuBarObj.childNodes[i].iconObj.className = menuBarObj.childNodes[i].iconClassName;
          }
        }
      } while (i--);
    }
    if (this.enabled && (this.menu || this.actionOnClick)) {
      switch (menuBarObj.activateMode) {
        case "click":
          this.className = this.itemClassNameOver;
          break;
        case "over":
          if (this.menu) {
            this.onclick(e);
          }
          else {
            this.className = this.itemClassNameOver;
          }
          break;
      }
      if (this.iconObj && this.iconClassNameOver) {
        this.iconObj.className = this.iconClassNameOver;
      }
    }
  }
}

/*
Event handler that handles onclick event of the menu bar item.
*/
function menuBarItemClick(e) { // Private method
  if (this.enabled) {
    if (this.menu) {
      if (this.clicked) {
        this.className = this.itemClassNameOver;
        if (this.iconObj) {
          this.iconObj.className = this.iconClassNameOver;
        }
        hideMenus(this.menu.menuObj);
        this.clicked = false;
        this.parent.menuBarObj.activated = false;
      }
      else {
        this.className = this.itemClassNameClick;
        if (this.iconObj && this.iconClassNameClick) {
          this.iconObj.className = this.iconClassNameClick;
        }
        popUpMenuBarMenu(this.parent.menuBarObj, this, this.menu.menuObj);
        this.clicked = true;
        this.parent.menuBarObj.activated = true;
      }
    }
    else {
      if (this.actionOnClick) {
        var action = this.actionOnClick;
        if (action.indexOf("link:") == 0) {
          location.href = action.substr(5);
        }
        else {
          if (action.indexOf("code:") == 0) {
            eval(action.substr(5));
          }
          else {
            location.href = action;
          }
        }
        this.className = this.itemClassName;
        if (this.iconObj) {
          this.iconObj.className = this.iconClassName;
        }
        this.clicked = false;
        this.parent.menuBarObj.activated = false;
      }
    }
  }
  if (!e) {
    var e = window.event;
    e.cancelBubble = true;
  }
  if (e.stopPropagation) {
    e.stopPropagation();
  }
}

/*
Event handler that handles onmouseout event of the menu bar item.
*/
function menuBarItemOut() { // Private method
  intervalId = setTimeout("deactivate()", autoHideTimeLimit);
  if (!this.parent.menuBarObj.activated) {
    this.className = this.itemClassName;
    if (this.iconObj) {
      this.iconObj.className = this.iconClassName;
    }
  }
}

/*
Event handler that handles onmousedown event of the menu bar.
*/
function menuBarDown(e) { // Private method
  draggingObj = this.parent.menuBarObj;
  var menuBarObj = this.parent.menuBarObj;
  menuBarObj.differenceLeft = getX(e) - menuBarObj.offsetLeft;
  menuBarObj.differenceTop = getY(e) - menuBarObj.offsetTop;
  hideMenuBarMenus();
  document.onmousemove = mouseMoveHandler;
}

/*
Event handler that handles onmouseup event of the menu bar.
*/
function menuBarUp() { // Private method
  draggingObj = null;
  var menuBarObj = this.parent.menuBarObj;
  menuBarObj.differenceLeft = 0;
  menuBarObj.differenceTop = 0;
  menuBarObj.initialLeft = menuBarObj.offsetLeft - getScrollLeft();
  menuBarObj.initialTop = menuBarObj.offsetTop - getScrollTop();
  document.onmousemove = null;
}

/*
Event handler that handles mouse move event.
*/
function mouseMoveHandler(e) { // Private method
  if (draggingObj) {
    draggingObj.style.left = (getX(e) - draggingObj.differenceLeft) + px;
    draggingObj.style.top = (getY(e) - draggingObj.differenceTop) + px;
  }
}

/*
Event handler that handles scroll event.
*/
function menuBarScrollHandler() { // Private method
  var i = menuBarCount;
  do {
  //for (var i = 1; i <= menuBarCount; i++) {
    var menuBarObj = getElmId("DOMenuBar" + i);	
	//	if (menuBarObj.mode == "fixed") {
	//	  menuBarObj.style.left = (menuBarObj.initialLeft + getScrollLeft()) + px;
	//	  menuBarObj.style.top = (menuBarObj.initialTop + getScrollTop()) + px;
	//	} 	
  } while (--i);
}

/*
Remove all menu bars events.
*/
function removeMenuBarEvents(menuBarObj) { // Private method
  var fields = new Array("setMode", 
                         "setActivateMode", 
                         "setDraggable", 
                         "setClassName", 
                         "setDragClassName", 
                         "show", 
                         "hide", 
                         "setX", 
                         "setY", 
                         "moveTo", 
                         "moveBy", 
                         "setBorderWidth");
  var i = fields.length - 1;
  do {
    menuBarObj[fields[i]] = null;
    //_i++; // TODO
  } while (i--);
}

/*
Release the memory to minimize memory leak.
*/
function menuBarReleaseMemory() { // Private method
  var i = menuBarCount;
  var menuBarObj;
  if (i > 0) {
    do {
      menuBarObj = getElmId("DOMenuBar" + i);
      removeMenuBarEvents(menuBarObj.parent);
      removeItemEvents(menuBarObj);
      menuBarObj.parent.dragObj.parent = null;
      menuBarObj.parent = null;
      menuBarObj.onclick = null;
      document.body.removeChild(menuBarObj);
    } while (--i);
  }
  i = staticMenuBarId.length - 1;
  if (i > -1) {
    do {
      menuBarObj = getElmId(staticMenuBarId[i]);
      removeMenuBarEvents(menuBarObj.parent);
      removeItemEvents(menuBarObj);
      menuBarObj.parent.dragObj.parent = null;
      menuBarObj.parent = null;
      menuBarObj.onclick = null;
    } while (i--);
  }
}

/*
Hide all menu bar menus.
*/
function hideMenuBarMenus() { // Public method
  var i = menuBarCount;
  if (i > 0) {
    do {
    //for (var i = 1; i <= menuBarCount; i++) {
      deactivateMenuBarItems(getElmId("DOMenuBar" + i));
    } while (--i);
  }
}

/*
Show the icon before the display text.
Arguments:
className          : Required. String that specifies the CSS class selector for the icon.
classNameOver      : Optional. String that specifies the CSS class selector for the icon when 
                     the cursor is over the menu bar item.
classNameClick     : Optional. String that specifies the CSS class selector for the icon when 
                     the cursor is clicked on the menu bar item.
*/
function showMenuBarItemIcon() { // Public method
  var iconElm = createElm("span");
  var textNode = document.createTextNode("");
  iconElm.appendChild(textNode);
  iconElm.id = this.id + "Icon";
  iconElm.className = arguments[0];
  this.insertBefore(iconElm, this.firstChild);
  var height;
  var offsetHeight;
  var menuBarObj = this.parent.menuBarObj;
  var offset = getPropIntVal(menuBarObj, btw) 
             + getPropIntVal(this, pt) 
             - getPropIntVal(menuBarObj, pb) 
             - getPropIntVal(menuBarObj, bbw) 
             - getPropIntVal(this, pb);
  //height = iconElm.offsetHeight;
  //offsetHeight = this.offsetHeight;
  /*
  if (ie55 || ie6) {
    height = getPropIntVal(iconElm, "height");
    offsetHeight = (menuBarObj.mode == "static") ? menuBarObj.offsetHeight + offset : this.offsetHeight + getPropIntVal(this, pt) - getPropIntVal(this, pb);
  }
  else {
    height = iconElm.offsetHeight;
    offsetHeight = this.offsetHeight;
  }
  */
  //iconElm.style.top = Math.floor((offsetHeight - height) / 2) + px;
  iconElm.style.top = Math.floor((this.offsetHeight - iconElm.offsetHeight) / 2) + px;
  if (opera && this.parent.menuBarObj.mode != "static") {
    iconElm.style.display = "none";
  }
  this.iconClassName = iconElm.className;
  var len = arguments.length;
  if (len > 1 && arguments[1].length > 0) {
    this.iconClassNameOver = arguments[1];
  }
  if (len > 2 && arguments[2].length > 0) {
    this.iconClassNameClick = arguments[2];
  }
  this.iconObj = iconElm;
  this.setIconClassName = function(className) { // Public method
    if (opera && this.parent.menuBarObj.mode != "static") {
      return;
    }
    this.iconClassName = className;
    this.iconObj.className = this.iconClassName;
  };
  this.setIconClassNameOver = function(classNameOver) { // Public method
    if (opera && this.parent.menuBarObj.mode != "static") {
      return;
    }
    this.iconClassNameOver = classNameOver;
  };
  this.setIconClassNameClick = function(classNameClick) { // Public method
    if (opera && this.parent.menuBarObj.mode != "static") {
      return;
    }
    this.iconClassNameClick = classNameClick;
  };
  iconElm = null;
}

/*
Add a new menu bar item to the menu bar.
Argument:
menuBarItemObj     : Required. Menu bar item object that is going to be added to the menu bar 
                     object.
*/
function addMenuBarItem(menuBarItemObj) { // Public method
  var itemElm = createElm("span");
  itemElm.id = menuBarItemObj.id;
  itemElm.menu = menuBarItemObj.menu;
  itemElm.enabled = menuBarItemObj.enabled;
  itemElm.clicked = false;
  itemElm.actionOnClick = menuBarItemObj.actionOnClick;
  itemElm.itemClassName = menuBarItemObj.className;
  itemElm.itemClassNameOver = menuBarItemObj.classNameOver;
  itemElm.itemClassNameClick = menuBarItemObj.classNameClick;
  itemElm.className = itemElm.itemClassName;
  if (ie50) {
    itemElm.style.height = "1%";
  }
  if (ie55) {
    itemElm.style.width = "auto";
  }
  var textElm;
  if (typeof(itemElm.innerHTML) != "undefined") {
    textElm = createElm("span");
    textElm.innerHTML = menuBarItemObj.displayText;
  }
  else {
    textElm = document.createTextNode(menubarItemObj.displayText);
  }
  
  //var textNode = document.createTextNode(menuBarItemObj.displayText);
  //itemElm.appendChild(textNode);
  itemElm.appendChild(textElm);
  this.menuBarObj.appendChild(itemElm);
  itemElm.parent = this;
  itemElm.setClassName = function(className) { // Public method
    this.itemClassName = className;
    this.className = this.itemClassName;
  };
  itemElm.setClassNameOver = function(classNameOver) { // Public method
    this.itemClassNameOver = classNameOver;
  };
  itemElm.setClassNameClick = function(classNameClick) { // Public method
    this.itemClassNameClick = classNameClick;
  };
  itemElm.setDisplayText = function(text) { // Public method
    var index = this.childNodes[0].id.indexOf("Icon") > -1 ? 1 : 0;
    var node = this.childNodes[index];
    if (typeof(node.innerHTML != "undefined")) {
      node.innerHTML = text;
    }
    else {
      node.nodeValue = text;
    }
      /*
    if (this.childNodes[0].nodeType == 3) {
      this.childNodes[0].nodeValue = text;
    }
    else {
      this.childNodes[1].nodeValue = text;
    }
    */
  };
  itemElm.setMenu = function(menu) { // Public method
    this.menu = menu;
  };
  itemElm.showIcon = showMenuBarItemIcon;
  itemElm.onmouseover = menuBarItemOver;
  itemElm.onclick = menuBarItemClick;
  itemElm.onmouseout = menuBarItemOut;
  if (menuBarItemObj.itemName.length > 0) {
    this.items[menuBarItemObj.itemName] = itemElm;
  }
  else {
    this.items[this.items.length] = itemElm;
  }
  var len = 0;
  for (var x in this.items) {
    ++len;
  }
  if (len == 1 && opera && pageMode == 0) {
    this.dragObj.style.height = (this.dragObj.offsetTop - itemElm.offsetTop) + px;
  }
  textElm = null;
  itemElm = null;
}

/*
Create a new menu bar item object.
Arguments:
displayText        : Required. String that specifies the text to be displayed on the menu bar item.
menuObj            : Optional. Menu object that is going to be the main menu for the menu bar item. 
                     Defaults to null (no menu).
itemName           : Optional. String that specifies the name of the menu bar item. Defaults to "" 
                     (no name).
enabled            : Optional. Boolean that specifies whether the menu bar item is enabled/disabled. 
                     Defaults to true.
actionOnClick      : Optional. String that specifies the action to be done when the menu item is 
                     being clicked if no main menu has been set for the menu bar item. Defaults to 
                     "" (no action).
className          : Optional. String that specifies the CSS class selector for the menu bar item. 
                     Defaults to "jsdomenubaritem".
classNameOver      : Optional. String that specifies the CSS class selector for the menu item when 
                     the cursor is over it. Defaults to "jsdomenubaritemover".
classNameClick     : Optional. String that specifies the CSS class selector for the menu item when 
                     the cursor is clicked on it. Defaults to "jsdomenubaritemclick".
*/
function menuBarItem() { // Public method
  this.displayText = arguments[0];
  this.id = "menuBarItem" + (++menuBarItemCount);
  this.itemName = "";
  this.menu = null;
  this.enabled = true;
  this.actionOnClick = "";
  this.className = menuBarItemClassName;
  this.classNameOver = menuBarItemClassNameOver;
  this.classNameClick = menuBarItemClassNameClick;
  var len = arguments.length;
  if (len > 1 && typeof(arguments[1]) == "object") {
    this.menu = arguments[1];
  }
  if (len > 2 && arguments[2].length > 0) {
    this.itemName = arguments[2];
  }
  if (len > 3 && typeof(arguments[3]) == "boolean") {
    this.enabled = arguments[3];
  }
  if (len > 4 && arguments[4].length > 0) {
    this.actionOnClick = arguments[4];
  }
  if (len > 5 && arguments[5].length > 0) {
    this.className = arguments[5];
  }
  if (len > 6 && arguments[6].length > 0) {
    this.classNameOver = arguments[6];
  }
  if (len > 7 && arguments[7].length > 0) {
    this.classNameClick = arguments[7];
  }
}

/*
Create a new menu bar object.
Arguments:
mode               : Optional. String that specifies the mode of the menu bar. Defaults to "absolute".
id                 : Optional, except when mode = "static". String that specifies the id of 
                     the element that will contain the menu bar. This argument is required when 
                     mode = "static".
draggable          : Optional. Boolean that specifies whether the menu bar is draggable. Defaults to 
                     false.
className          : Optional. String that specifies the CSS class selector for the menu bar. Defaults 
                     to "jsdomenubardiv".
width              : Optional. Integer that specifies the width of the menu bar. Defaults to "auto".
height             : Optional. Integer that specifies the height of the menu bar. Defaults to "auto".
*/
function jsDOMenuBar() { // Public method
  this.items = new Array();
  var dragElm = createElm("span");
  dragElm.className = menuBarDragClassName;
  var textNode = document.createTextNode("");
  dragElm.appendChild(textNode);
  var menuBarElm;
  var len = arguments.length;
  if (len > 1 && arguments[1].length > 0 && arguments[0] == "static") {
    menuBarElm = getElmId(arguments[1]);
    if (!menuBarElm) {
      return;
    }
    staticMenuBarId[staticMenuBarId.length] = arguments[1];
    menuBarElm.appendChild(dragElm);
  }
  else {
    menuBarElm = createElm("div");
    menuBarElm.appendChild(dragElm);
    menuBarElm.id = "DOMenuBar" + (++menuBarCount);
  }
  menuBarElm.mode = menuBarMode;
  menuBarElm.activateMode = menuBarActivateMode;
  menuBarElm.draggable = false;
  menuBarElm.className = menuBarClassName;
  menuBarElm.activated = false;
  menuBarElm.initialLeft = 0;
  menuBarElm.initialTop = 0;
  menuBarElm.differenceLeft = 0;
  menuBarElm.differenceTop = 0;
  if (len > 0 && arguments[0].length > 0) {
    switch (arguments[0]) {
      case "absolute":
        menuBarElm.style.position = "absolute";
        menuBarElm.mode = "absolute";
        break;
      case "fixed":
        if (ie) {
          menuBarElm.style.position = "absolute";
        }
        else {
          menuBarElm.style.position = "fixed";
        }
        menuBarElm.mode = "fixed";
        break;
      case "static":
        menuBarElm.style.position = "static";
        menuBarElm.mode = "static";
        break;
    }
  }
  if (len > 2 && typeof(arguments[2]) == "boolean") {
    menuBarElm.draggable = arguments[2];
    if (menuBarElm.draggable) {
      dragElm.style.visibility = "visible";
    }
    else {
      dragElm.style.visibility = "hidden";
    }
  }
  if (len > 3 && arguments[3].length > 0) {
    menuBarElm.className = arguments[3];
  }
  if (len > 4 && typeof(arguments[4]) == "number" && arguments[4] > 0) {
    menuBarElm.style.width = arguments[4] + px;
  }
  if (len > 5 && typeof(arguments[5]) == "number" && arguments[5] > 0) {
    menuBarElm.style.height = arguments[5] + px;
  }
  menuBarElm.style.left = "0px";
  menuBarElm.style.top = "0px";
  if (ie50) {
    menuBarElm.style.height = "1%";
  }
  if (menuBarElm.mode != "static") {
    document.body.appendChild(menuBarElm);
  }
  else {
    if (ie) {
      menuBarElm.style.height = "1%";
    }
  }
  if (!getPropVal(menuBarElm, blw)) {
    menuBarElm.style.borderWidth = menuBarBorderWidth + px;
  }
  this.menuBarObj = menuBarElm;
  this.menuBarObj.parent = this;
  this.dragObj = dragElm;
  this.dragObj.parent = this;
  this.addMenuBarItem = addMenuBarItem;
  this.menuBarObj.onclick = function(e) { // Private method
    if (!e) {
      var e = window.event;
      e.cancelBubble = true;
    }
    if (e.stopPropagation) {
      e.stopPropagation();
    }
  };
  dragElm.onmousedown = menuBarDown;
  dragElm.onmouseup = menuBarUp;
  this.setMode = function(mode) { // Public method
    switch (mode) {
      case "absolute":
        this.menuBarObj.style.position = "absolute";
        this.menuBarObj.mode = "absolute";
        this.menuBarObj.initialLeft = parseInt(this.menuBarObj.style.left);
        this.menuBarObj.initialTop = parseInt(this.menuBarObj.style.top);
        break;
      case "fixed":
        if (ie) {
          this.menuBarObj.style.position = "absolute";
          this.menuBarObj.initialLeft = parseInt(this.menuBarObj.style.left);
          this.menuBarObj.initialTop = parseInt(this.menuBarObj.style.top);
        }
        else {
          this.menuBarObj.style.position = "fixed";
        }
        this.menuBarObj.mode = "fixed";
        break;
    }
  };
  this.setActivateMode = function(activateMode) { // Public method
    this.menuBarObj.activateMode = activateMode;
  };
  this.setDraggable = function(draggable) { // Public method
    if (typeof(draggable) == "boolean" && this.menuBarObj.mode != "static") {
      this.menuBarObj.draggable = draggable;
      if (this.menuBarObj.draggable) {
        this.dragObj.style.visibility = "visible";
      }
      else {
        this.dragObj.style.visibility = "hidden";
      }
    }
  };
  this.setClassName = function(className) { // Public method
    this.menuBarObj.className = className;
  };
  this.setDragClassName = function(className) { // Public method
    this.dragObj.className = className;
  };
  this.show = function() { // Public method
    this.menuBarObj.style.visibility = "visible";
  };
  this.hide = function() { // Public method
    this.menuBarObj.style.visibility = "hidden";
  };
  this.setX = function(x) { // Public method
    this.menuBarObj.initialLeft = x;
    this.menuBarObj.style.left = x + px;
  };
  this.setY = function(y) { // Public method
    this.menuBarObj.initialTop = y;
    this.menuBarObj.style.top = y + px;
  };
  this.moveTo = function(x, y) { // Public method
    this.menuBarObj.initialLeft = x;
    this.menuBarObj.initialTop = y;
    this.menuBarObj.style.left = x + px;
    this.menuBarObj.style.top = y + px;
  };
  this.moveBy = function(x, y) { // Public method
    var left = parseInt(this.menuBarObj.style.left);
    var top = parseInt(this.menuBarObj.style.top);
    this.menuBarObj.initialLeft = left + x;
    this.menuBarObj.initialTop = top + y;
    this.menuBarObj.style.left = (left + x) + px;
    this.menuBarObj.style.top = (top + y) + px;
  };
  this.setBorderWidth = function(width) { // Public method
    this.menuBarObj.style.borderWidth = width + px;
  };
  menuBarElm = null;
  dragElm = null;
}

if (typeof(menuBarClassName) == "undefined") {
  var menuBarClassName = "jsdomenubardiv"; // Public field
}

if (typeof(menuBarItemClassName) == "undefined") {
  var menuBarItemClassName = "jsdomenubaritem"; // Public field
}

if (typeof(menuBarItemClassNameOver) == "undefined") {
  var menuBarItemClassNameOver = "jsdomenubaritemover"; // Public field
}

if (typeof(menuBarItemClassNameClick) == "undefined") {
  var menuBarItemClassNameClick = "jsdomenubaritemclick"; // Public field
}

if (typeof(menuBarDragClassName) == "undefined") {
  var menuBarDragClassName = "jsdomenubardragdiv"; // Public field
}

if (typeof(menuBarMode) == "undefined") {
  var menuBarMode = "absolute"; // Public field
}

if (typeof(menuBarActivateMode) == "undefined") {
  var menuBarActivateMode = "click"; // Public field
}

if (typeof(menuBarBorderWidth) == "undefined") {
  var menuBarBorderWidth = 2; // Public field
}

var pt = "padding-top"; // Private field
var pb = "padding-bottom"; // Private field
var menuBarCount = 0; // Private field
var menuBarItemCount = 0; // Private field
var draggingObj = null; // Private field
var staticMenuBarId = new Array(); // Private field
