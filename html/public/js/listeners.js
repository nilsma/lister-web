$(document).ready(function() {
    /**
     * listeners for menu
     */
    $('#menu_button').click(function() {
	openMenu();
    }),
    $('#close_menu').click(function() {
	closeMenu();
    }),
    $('#lists_button').click(function() {
	openLists();
    }),
    /**
     * listeners for new list section
     */
    //toggle opening and closing the new list section
    $('#newList').click(function() {
	toggleNewListSection();
    }),
    /**
     * listeners for share list/invite member to list section
     */
    $('#inviteMemberEntry').click(function() {
	toggleInviteMemberSection();
    }),
    /**
     * listeners for browse own invitations section
     */
    //toggle open/close invites section
    $('#invitations').click(function() {
	toggleInvitationsSection();
    }),
    /**
     * listeners for logout section
     */
    $('#logout').click(function() {
	logout();
    }),
    $('#delete_button').click(function() {
	deleteList();
    }),
    /**
     * listeners for list
     */
    $('#remove_item').click(function() {
	removeItem();
    });
    //add item to list
/*
    $('#add_item').click(function() {
	addItem();
    }),
*/
});