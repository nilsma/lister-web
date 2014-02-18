/**
 * A function to reset the input fields colors and value depending on whether
 * it is marked as 'bad input' according to the checkInputField(element)-function
 * 
 * @param element HTMLInputElement - the input field element to check
 */
function resetInputField(element) {
    if(checkInputField(element)) {
	setFormElementFontColor(element, 'rgb(0, 0, 0)');
	setFormElementBackgroundColor(element, 'rgb(255,255,255)');
	setFormFeedbackVisibility(element, 'hidden');
	clearInputField(element);
    } else {
	//do nothing
    }
}

/**
 * A function to check whether the given input field is marked as 'bad input' by
 * checking if the elements CSS background-color property is rgb(255,0,0), and
 * sets the form elements colors correspondingly and clears the input field
 * 
 * @param element HTMLInputElement - the input field element to check
 * @return boolean - returns true if the input field is marked as 'bad input', false otherwise
 */
function checkInputField(element) {
    var background = window.getComputedStyle(element, null).getPropertyValue("background-color");
    if(background == 'rgb(255, 0, 0)') {
	return true;
    } else {
	return false;
    }
}

/**
 * A function to check whether the given input fields string is a valid username value for the application
 *
 * @param string - the username value to be checked before committing to the database
 */
function checkRegistrationUser(username) {
    if(!isBlank(username)) {
	var element = document.getElementById('username');
	var existence = checkUserExistence(username);
	inputFeedback(element, existence, false);
    } else {
	inputFeedback(element, existence, true);
    }
}

/**
 * A function to check whether the given input fields string is a valid email value for the application
 *
 * @param email string - the email value to be checked before committing to the database
 */
function checkRegistrationEmail(email) {
    if(isBlank(email)) {
	inputFeedback(element, existence, true);
    } else {
	var element = document.getElementById('email');
	var existence = checkMailExistence(email);
	inputFeedback(element, existence, false);
    }
}

/**
 * A function to set the input feedback to the user depending on whether the user input
 * is blank and/or if it already exists in the applications database
 *
 * @param element HTMLInputElment - the input field element of which to give feedback
 * @param existence boolean - should be true if the elements value exists in the database, false otherwise
 * @param blank boolean - should be true if the elements value is blank, false otherwise
 */
function inputFeedback(element, existence, blank) {
    var color;
    var visibility;
    if(!blank) {
	if(existence) {
	    background = 'rgb(255,0,0)';
	    font = 'rgb(255,255,255)';
	    visibility = 'visible';
	    setFormElementColors(element, background, font);
	    setFormFeedbackVisibility(element, visibility);
	} else {
	    background = 'rgb(255,255,255)';
	    font = 'rgb(0,0,0)';
	    visibility = 'hidden';
	    setFormElementColors(element, background, font);
	    setFormFeedbackVisibility(element, visibility);
	}
    } else {
	//do nothing
    }
}

/**
 * A function to check whether the given string is empty or not.
 *
 * @param str string - the string to be checked
 * @return boolean - returns true if the given string is blank, false otherwise
 */
function isBlank(str) {
    return (!str || /^\s*$/.test(str));
}

/**
 * A function to set the given elements background and font colors
 *
 * @param element HTMLInputElement - the element of which to set the colors of
 * @param background string - the rgb value of the color to which the elements background-color should be set to
 * @param font string - the rgb value of the color to which the elements font color should be set to
 */
function setFormElementColors(element, background, font) {
    setFormElementBackgroundColor(element, background);
    setFormElementFontColor(element, font);
}

/**
 * A function to set the given elements font color.
 *
 * @param element HTMLInputElement - the element of which to set the font color
 * @param newColor string - the rgb value of the new font color for the given element
 */
function setFormElementFontColor(element, newColor) {
    element.style.color=newColor;
}

/**
 * A function to the set given elements background color.
 *
 * @param element HTMLInputElement - the element of which to set the background color
 * @param newColor string - the rgb value of the new background color for the given element
 */
function setFormElementBackgroundColor(element, newColor) {
    element.style.backgroundColor=newColor;
}

/**
 * A function to set the elements corresponding class='input_feedback' HTML paragraph visibility based
 * on the elements id value.
 *
 * Both username ane email input fields have corresponding HTML paragraphs that give textual feedback
 * to the users input, both are initially hidden
 *
 * @param element HTMLInputElement - the element of which to change the corresponding HTML paragraph
 * @param value string - the new value of the corresponding HTML paragraph visibility attribute, hidden or visible
 */
function setFormFeedbackVisibility(element, value) {
    if(element.id == "email") {
	document.getElementById('checked-email').style.visibility=value;
    } else {
	document.getElementById('checked-username').style.visibility=value;
    }
}

/**
 * A function to clear the given elements field value, by setting the elements fields value to an empty string.
 * 
 * @param element HTMLInputElement - the element of which to clear the input field value
 */
function clearInputField(element) {
    element.value='';
}

/**
 * A function to check whether the given email exists in the database.
 *
 * @param email string - the email adress to check if exists in the database
 * @return res boolean - returns true if the email exists in the database, false otherwise
 */
function checkMailExistence(email) {
    var res;
    $.ajax({
	url: 'resources/check-mail.php',
	type: 'POST',
	async: false,
	data: { mail: email },
	success: function(result) {
	    res=result.existence;
	}
    });
    return res;
}

/**
 * A function to check whether the given username exists in the database.
 *
 * @param username string - the username to check if exists in the database
 * @return res boolean - returns true if the username exists in the database, false otherwise
 */
function checkUserExistence(username) {
    var res;
    $.ajax({
	url: 'resources/check-user.php',
	type: 'POST',
	async: false,
	data: { name: username },
	success: function(result) {
	    res=result.existence;
	}
    });
    return res;
}

