/**
 * A function to display the menu
 *
 * For some screen dimensions (smaller screens) the menu is initially hidden.
 * This function will open/display the menu and its options
 */
function openMenu() {
    var left_column = document.getElementById('left_column');
    var menu = document.getElementById('menu');
    var inner_container = document.getElementById('inner_container');
    var menu_panel = document.getElementById('menu_panel');
    left_column.style.display='block';
    menu.style.display='block';
    inner_container.style.backgroundColor='rgba(95, 189, 206, 0.7)';
    menu_panel.style.backgroundColor='rgba(95, 189, 206, 0.7)';
}

/**
 * A function to hide the menu
 * 
 * For some screen dimensions (smaller screens) the menu is initially hidden.
 * This function will close/hide the menu and its options
 */
function closeMenu() {
    var left_column = document.getElementById('left_column');
    var menu = document.getElementById('menu');
    var inner_container = document.getElementById('inner_container');
    var menu_panel = document.getElementById('menu_panel');
    left_column.style.display='none';
    menu.style.display='none';
    inner_container.style.backgroundColor='rgba(4, 133, 157, 1)';
    menu_panel.style.backgroundColor='rgba(4, 133, 157, 1)';
}

/**
 * A function to display the list overview
 *
 * For some screen dimensions (smaller screens) the list overview is initially hidden.
 * This function will open/display the list overview and its options
 */
function openLists() {
    var right_column = document.getElementById('right_column');
    var lists = document.getElementById('lists_overview');
    var inner_container = document.getElementById('inner_container');
    var menu_panel = document.getElementById('menu_panel');
    right_column.style.display='block';
    lists_overview.style.display='block';
    inner_container.style.backgroundColor='rgba(95, 189, 206, 0.7)';
    menu_panel.style.backgroundColor='rgba(95, 189, 206, 0.7)';
}

/**
 * A function to hide the list overview
 *
 * For some screen dimensions (smaller screens) the list overview is initially hidden.
 * This function will close/hide the list overview and its options
 */
function closeLists() {
    var right_column = document.getElementById('right_column');
    var lists = document.getElementById('lists_overview');
    var inner_container = document.getElementById('inner_container');
    var menu_panel = document.getElementById('menu_panel');
    right_column.style.display='none';
    lists_overview.style.display='none';
    inner_container.style.backgroundColor='rgba(4, 133, 157, 1)';
    menu_panel.style.backgroundColor='rgba(4, 133, 157, 1)';
}

/**
 * A function to update the lists in the list overview for the given user
 * 
 * @param user_id int - the integer of the given users id
 */
function updateOverviewLists(user_id) {
    var topList = getListOnTop();
    var result = null;
    var element = document.getElementById('right_column');

    if (window.XMLHttpRequest) {
	xmlhttp=new XMLHttpRequest();
    } else {
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	    result = xmlhttp.responseText;
	    element.innerHTML=result;
	    focusList(topList);
	}
    }

    var params = "userid=".concat(user_id);
    xmlhttp.open("POST", "resources/update-overview-lists.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

/**
 * A function to update the invitations for the currently logged in users invites section
 */
function updateInvites() {
    var result = null;
    var xmlhttp = null;
    var element = document.getElementById('invitationsSection');

    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	    result = xmlhttp.responseText;
	    addInvitesResult(result, element);
	}
    }
    
    xmlhttp.open("POST", "resources/update-invites.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(null);
}

/**
 * A function to update the number of invitations in the given users invites section
 *
 * @param user_id int - the integer of the given users id
 */
function updateInvitesNum(user_id) {
    var fetch = new Boolean();
    fetch = false;
    var result = null;
    var xmlhttp = null;
    var element = document.getElementById('invitesNum');
    if (window.XMLHttpRequest) {
	xmlhttp=new XMLHttpRequest();
    } else {
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	    result = xmlhttp.responseText;
	    fetch = true;
	}

	if(fetch) {
	    addInvitesResult(result, element);
	}

    }

    var params = "userid=".concat(user_id);
    xmlhttp.open("POST", "resources/update-invites-num.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

/**
 * A function to add a given string to the inner HTML of a given HTMLElement
 *
 * @param string string - the string to add as the inner HTML of the given HTML element
 * @param element HTMLElement - the HTML element of which to addthe given string
 */
function addInvitesResult(string, element) {
    element.innerHTML=string;
}

/**
 * A function to accept a given invite
 *
 * @param elem HTMLElement - the HTML element which contains the invitations details
 */
function acceptInvite(elem) {
	var listid = elem.parentNode.id.substring(8);
	if(listid) {
	    var result = null;
	    var xmlhttp = null;
	    if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	    } else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    
	    xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		    result = xmlhttp.responseText;
		    removeInvite(elem);
		}
	    }

	    var params = "listid=".concat(listid);
	    xmlhttp.open("POST", "resource/accept-invite.php", true);
	    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    xmlhttp.send(params);
    } 
}

/**
 * A function to decline and remove a given invite
 *
 * @param elem HTMLElement - the HTML element which contains the invitations details
 */
function removeInvite(elem) {
    var user_id = getCurrentUserId();
    var listid = elem.parentNode.id.substring(8);
    if(listid) {
	var result = null;
	var xmlhttp = null;
	if (window.XMLHttpRequest) {
	    xmlhttp=new XMLHttpRequest();
	} else {
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		result = xmlhttp.responseText;
		updateInvites();
		updateInvitesNum(user_id);
		updateOverviewLists(user_id);
	    }
	}
	
	var params = "listid=".concat(listid);
	xmlhttp.open("POST", "resources/remove-invite.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
    }
}

/**
 * A function to get the currently logged in users user_id from the application database
 *
 * @return res int - the currently logged in users user_id
 */
function getCurrentUserId() {
    var res;
    $.ajax({
	url: 'resources/member-information.php',
	async: false,
	success: function(data) {
	    res=data.user_id;
	}
    });
    return res;
}

/**
 * A function to get the currently logged in users username from the application database
 *
 * @return res string - the currently logged in users username
 */
function getCurrentUserName() {
    var res;
    $.ajax({
	url: 'resources/member-information.php',
	async: false,
	success: function(data) {
	    res=data.current_user;
	}
    });
    return res;
}

/**
 * A function to check that the user to invite is valid
 *
 * @param current_user int - the user id of the user that initiates the invite
 * @param invite_user int - the user id of the user that is to be invited
 * @param element HTMLElement - the HTML element for the input field of the invite form
 */
function checkUserToInvite(current_user, invite_user, element) {
    if(!isBlank(invite_user)) {
	if(current_user !== invite_user) {
	    if(checkUserExistence(invite_user)) {
		return true;
	    } else {
		setElementBackgroundColor(element, 'red');
		alert('The user you are trying to invite,\ndoes not exist!\nPlease, try again ...');
		return false;
	    }
	} else {
	    setElementBackgroundColor(element, 'red');
	    alert('You cannot invite yourself!\nPlease, try again ...')
	    return false;
	}
    } else {
	setElementBackgroundColor(element, 'red');
    }
}

/**
 * A function to check whether the given username exists in the application database
 *
 * @param username string - the username to check for in the database
 * @return res boolean - returns true if the username exists in the database, false otherwise
 */
function checkUserExistence(username) {
    var res;
    $.ajax({
	url: 'resources/user-existence.php',
	type: 'POST',
	async: false,
	data: { name: username },
	success: function(result) {
	    res=result.existence;
	}
    });
    return res;
}

/**
 * A function to initiate an invite of a user
 * 
 * @param element HTMLElement - the invitation form
 */
function initiateInvite(element) {
    var current_user = getCurrentUserName();
    var invite_user = element.value;
    var e = document.getElementById('dropdown_menu');
    var target_list_id = e.options[e.selectedIndex].id.substring(9);
    if(checkUserToInvite(current_user, invite_user, element)) {
	inviteMember(current_user, invite_user, target_list_id);
    } else {
	//DO SOMETHING
    }
}

/**
 * A function to invite a user to a given list
 *
 * @param current_user int - the user id of the currently logged in user
 * @param invite_user int - the user id of the user to invite
 * @param list_id int - the id of the list to invite the given user to
 */
function inviteMember(current_user, invite_user, list_id) {
    if(confirmInvite(invite_user)) {
	if(list_id) {
	    var result = null;
	    var xmlhttp = null;
	    if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	    } else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    
	    xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		    result = xmlhttp.responseText;
		}
	    }
	    
	    var param1 = "inv=".concat(invite_user);
	    var param2 = "&i=".concat(list_id); 
	    var params = param1.concat(param2);
	    xmlhttp.open("POST", "resources/invite-member.php", true);
	    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    xmlhttp.send(params);
	} else {
	    //TODO 
	    //: if(targetListId) fails
	}
	document.getElementById('inviteMemberTextField').value='';
    } else {
	//DO SOMETHING
	//:if(confirmInvite(inviteUser) fails
    }
}

/**
 * A function to reset a given input field by setting the value to an empty string
 *
 * @param field HTMLElement - the HTML element containing the input field to reset
 */
function resetInputField(field) {
    field.value="";
}

/**
 * A function for confirming inviting a given user
 *
 * @param user string - the username of the user to invite
 */
function confirmInvite(user) {
    var string = 'Are you sure you want to invite '.concat(user).concat('?').concat('\n').concat(user).concat(' will be able to add and remove items from your list.');
    return confirm(string);
}
/**
 * A function to remove an item from a list
 *
 * @param list_id int - the list id of the list to remove the item from
 * @param product_name string - the product name of the product to remove from the given list
 */
function removeItem(list_id, product_name) {
    var product = product_name;
    var list = list_id;
    if(product && list) {
	var result = null;
	var xmlhttp = null;

	if (window.XMLHttpRequest) {
	    xmlhttp=new XMLHttpRequest();
	} else {
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		result = xmlhttp.responseText;
		updateTable();
	    }
	}

	var param1 = "product=".concat(product); 
	var param2 = "&list=".concat(list);
	var params = param1.concat(param2);
	xmlhttp.open("POST", "resources/remove-item.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
    }
}

/**
 * A function to add an item to a given list
 *
 * @param product string - the product name of the product to add to the given list
 * @param list_number int - the list id of the list to add the given product to
 */
function addItem(product, list_number) {
    var item = product.value;
    var list_id = document.getElementsByClassName('shopping_list')[0].id.substring(8);
    if(item) {
	var result = null;
	var xmlhttp = null;
	var list = list_id;
	if (window.XMLHttpRequest) {
	    xmlhttp=new XMLHttpRequest();
	} else {
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		result = xmlhttp.responseText;
		resetInputField(product);
		updateTable();
	    }
	}
    
	var param1 = "item=".concat(item);
	var param2 = "&list=".concat(list); 
	var params = param1.concat(param2);
	xmlhttp.open("POST", "resources/add-item.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
    } 
}

/**
 * A function to run the updateTable() function periodically (every 10 seconds)
 */
setInterval(
    function updateTables() {
	updateTable();
    }, 10000
);

/**
 * A function to get the list name of the currently displayed list
 *
 * @return list_name string - the name of the list currently displayed
 */
function getCurrentListName() {
    var element = document.getElementById('current_list');
    var list_name = element.innerText || element.textContent
    return list_name;
}

/**
 * A function to get the list id of the currently displayed list
 *
 * @return list_name int - the id of the list currently displayed
 */
function getCurrentListId() {
    var list_container = document.getElementsByClassName('list_container')[0];
    var element = list_container.children[1];
    var list_id_base = element.id;
    var list_id = list_id_base.substring(8);
    return list_id;
}

/**
 * A function to update the table containing the products in the currently displayed list
 */
function updateTable() {
    var list_name = getCurrentListName();
    var list_id = getCurrentListId();
    var xmlhttp = null;
    var result = null;
    var element = document.getElementsByClassName('shopping_table')[0];
    if (window.XMLHttpRequest) {
	xmlhttp=new XMLHttpRequest();
    } else {
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	    result = xmlhttp.responseText;
	    addResult(element,result);
	}
    }
    
    var params = "listid=".concat(list_id);
    xmlhttp.open("POST", "resources/update.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

/**
 * A function to add a string to a given HTML elements innerHTML
 *
 * @param element HTMLElement - the given HTML element of which to add the string
 * @param string string - the string to add to the given HTML element
 */
function addResult(element,string) {
    var result = string;
    element.innerHTML=result;
}

/**
 * A function to add a new list
 *
 * @param itemarray HTMLFormElement - the HTML form element containing the input field for the new list
 */
function addList(itemarray) {
    var title = itemarray.elements[0].value;
    if(!isBlank(title)) {
	var result = null;
	var xmlhttp = null;

	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		result = xmlhttp.responseText;
		resetInputField(itemarray.elements[0]);
		hideNewListSection();
		location.reload(false);
	    }
	}
    
	var params = "list=".concat(title);
	xmlhttp.open("POST", "resources/add-list.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
    } else {
	setElementBackgroundColor('#newListTextField', 'red');
    }
}

/**
 * A function to get the style of a given property for a given element
 *
 * @param el HTMLElement - the element of which to get the style property
 * @param styleProp string - the style property of which to return
 * @return y string - the value of the given style property
 */
function getStyle(el,styleProp) {
    var x = document.getElementById(el);
    if (x.currentStyle)
	var y = x.currentStyle[styleProp];
    else if (window.getComputedStyle)
	var y = document.defaultView.getComputedStyle(x,null).getPropertyValue(styleProp);
    return y;
}

/**
 * A function to toggle the display of the section for inviting a member
 */
function toggleInviteMemberSection() {
    var string = 'inviteMemberSection';
    var value = getStyle(string, 'display');
    hideNewListSection();
    hideInvitationsSection();
    if(value == 'none') {
	showInviteMemberSection();
    } else {
	hideInviteMemberSection();
	resetInputField(document.getElementById('inviteMemberTextField'));
    }
}

/**
 * A function to toggle the display of the section for the invitations of the currently
 * logged in user
 */
function toggleInvitationsSection() {
    var string = 'invitationsSection';
    var value = getStyle(string, 'display');
    hideNewListSection();
    hideInviteMemberSection();
    if(value == 'none') {
	showInvitationsSection();
    } else {
	hideInvitationsSection();
    }
}

/**
 * A function to toggle the display of the section for adding new list to the application
 */
function toggleNewListSection() {
    var string = 'newListSection';
    var value = getStyle(string, 'display');
    hideInviteMemberSection();
    hideInvitationsSection();
    if(value == 'none') {
	showNewListSection();
    } else {
	hideNewListSection();
    }
}

/**
 * A function to set an elements background color
 *
 * @param element HTMLElement - the HTML element of which to change the background color
 * @param color string - the new background color for the HTML element
 */
function setElementBackgroundColor(element, color) {
    jQuery(document).ready(function() {
	jQuery(element).css('background-color', color);
    });
}

/**
 * A function to hide the new list section
 */ 
function hideNewListSection() {
    var element = document.getElementById('newListSection');
    jQuery(document).ready(function() {
	jQuery(element).hide(300);
    });
    setElementBackgroundColor('#newListTextField', '#ffffff');
}

/**
 * A function to display the new list section
 */ 
function showNewListSection() {
    var element = document.getElementById("newListSection");
    jQuery(document).ready(function() {
	jQuery(element).show(300);
    });    
}

/**
 * A function to hide the invite member section
 */ 
function hideInviteMemberSection() {
    var element = document.getElementById('inviteMemberSection');
    jQuery(document).ready(function() {
	jQuery(element).hide(300);
    });
    setElementBackgroundColor('#inviteMemberTextField', '#ffffff');
}

/**
 * A function to display the invite member section
 */ 
function showInviteMemberSection() {
    var element = document.getElementById('inviteMemberSection');
    jQuery(document).ready(function() {
	jQuery(element).show(300);
    });
}

/**
 * A function to hide the invitations section
 */
function hideInvitationsSection() {
    var element = document.getElementById('invitationsSection');
    jQuery(document).ready(function() {
	jQuery(element).hide(300);
    });
}

/**
 * A function to display the invitations section
 */
function showInvitationsSection() {
    var element = document.getElementById('invitationsSection');
    jQuery(document).ready(function() {
	jQuery(element).show(300);
    });    
}

/**
 * A function to check whether a given string is blank or not
 *
 * @param str string - the string to check
 * @return boolean - returns true if the string is empty, false otherwise
 */
function isBlank(str) {
    return (!str || /^\s*$/.test(str));
}

/**
 * A function to get the list name of the given HTML element
 * 
 * @param element HTMLElement - the HTML element which contains the list
 * @return string string - the name of the list
 */
function getListName(elem) {
    var string;
    var element = elem;
    jQuery(document).ready(function() {
	string = jQuery(element).parent().siblings('.list_name').text();
    });
    return string;
}

/**
 * A function to get the application database id for the list from the HTML element
 *
 * @return string string - the id of the list
 */
function getListId() {
    var string;
    string = document.getElementsByClassName('shopping_list')[0].id.substring(8);
    return string;
}

/**
 * A function to get the user verification of whether to delete a given list or not
 *
 * @return boolean - returns true if the user verifies deletion, false otherwise
 */
function verifyDeleteList() {
    var string = 'This will delete the list and its entire contents. \n Are you sure you want to delete this list?';
    var value;
    return confirm(string);
}

/**
 * A function to delete a list from the application database
 *
 * @param element HTMLElement - the element which contains the list to delete
 */
function deleteList() {
    if(verifyDeleteList()) {
	var result = null;
	var xmlhttp = null;
	
	if (window.XMLHttpRequest) {
	    xmlhttp=new XMLHttpRequest();
	} else {
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
//		result = xmlhttp.responseText;
		location.reload(false);
	    }
	}
	
	xmlhttp.open("POST", "resources/remove-list.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();
    }
}

/**
 * A function to get the users feedback on whether or not to logout from the application
 *
 * @return boolean - returns true if the user confirms logout, false otherwise
 */
function confirmLogout() {
    var string = 'Are you sure you want to logout?';
    return confirm(string);
}

/**
 * A function to logout the user from the application database
 */
function logout() {
    if(confirmLogout()) {
	var xmlhttp = null;
	if (window.XMLHttpRequest) {
	    xmlhttp=new XMLHttpRequest();
	} else {
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.open("GET", "lib/logout.php", false );
	xmlhttp.send(null);
	return xmlhttp.responseText;
    }
}

/**
 * A function to update the contents of the displayed list when changing from one list to another
 *
 * @param id int - the database id of the new list of which to get the contents
 */
function getNewList(id) {
    var list_id = id;
    var xmlhttp = null;
    var result = null;
    var element = document.getElementsByClassName('shopping_table')[0];
    if (window.XMLHttpRequest) {
	xmlhttp=new XMLHttpRequest();
    } else {
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	    result = xmlhttp.responseText;
	    addResult(element,result);
	}
    }
    
    var params = "listid=".concat(list_id);
    xmlhttp.open("POST", "resources/update.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

/**
 * A function to the the title of the currently displayed list
 *
 * @param string string - the string to set the new title to
 */
function setTitle(string) {
    var element = document.getElementById('current_list');
    element.innerHTML=string;
}

/**
 * A function to update the HTML id of the list that is currently being displayed
 *
 * @param string string - the string representation of the database id of the list
 */
function setListId(string) {
    var new_id_prefix = 'list_id_';
    var new_id = new_id_prefix.concat(string);
    var element = document.getElementsByClassName('shopping_list')[0];
    element.id=new_id;
}

/**
 * A function to get the currently displayed list's corresponding list element in the overview lists
 *
 * @return object - the corresponding list element for the overview lists section
 */
function getCurrentListElement() {
    var main_list_id = document.getElementsByClassName('shopping_list')[0].id.substring(8);
    var overview_lists = document.getElementsByClassName('user_list_overview');
    var overview_lists_id;
    for(var i = 0; i < overview_lists.length; i++) {
	overview_lists_id = overview_lists[i].id.substring(8);
	if(overview_lists_id === main_list_id) {
	    return overview_lists[i];
	}
    }
}

/**
 * A function to set the chosen list as the displayed list
 *
 * @param element object - the li element from the overview lists section for the chosen list to focus
 */
function focusList(element) {
    setListOverviewStyle(getCurrentListElement());
    setListOverviewStyle(element);
    var list_id = element.id.substring(8);
    var list_name = element.innerText || element.textContent;
    setTitle(list_name);
    setListId(list_id);
    getNewList(list_id);
}

/**
 * A function to get the list that is sorted as the top-most list in the overview lists section
 *
 * @return element object - the element for the list that is sorted on the top of the overview lists section
 */
function getListOnTop() {
    var element;
    jQuery(document).ready(function() {
	element = jQuery('#lists li').first();
    });
    return element;
}

/**
 * A function to check whether the given element is of a certain HTML class
 *
 * @param element object - the element to check for the given class
 * @param cls string - the name of the class to check for
 * @return value boolean - returns true if the element contains the class, false otherwise
 */
function checkForClass(element, cls) {
    var value;
    jQuery(document).ready(function() {
	if(jQuery(element).hasClass(cls)) {
	    value = true;
	} else {
	    value = false;
	}
    });
    return value;
}

/**
 * A function to toggle the overview_open class within the given element
 *
 * @param element HTMLElement - the element to toggle
 */
function setListOverviewStyle(element) {
    var cls = 'overview_open';
    if(checkForClass(element, cls)) {
	jQuery(document).ready(function() {
	    jQuery(element).removeClass(cls);
	});
    } else {
	jQuery(document).ready(function() {
	    jQuery(element).addClass(cls);
	});
    }
}

/**
 * A function to run on window load, which sets the highlight of some particular
 * elements of the page
 */
window.onload = function initiate() {
    var nodelist = document.getElementsByClassName("list_container");
    var node = nodelist[0]; 
    var topList = getListOnTop();
    setListOverviewStyle(topList);
    updateTables();
}