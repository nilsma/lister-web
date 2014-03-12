$(document).ready(function() {
    //menu
    //open/close
    $('#menu_button').click(function() {
	openMenu();
    }),
    $('#lists_button').click(function() {
	openLists();
    }),
    $('#close_menu').click(function() {
	closeMenu();
    }),
    //new list section
    $('#newList').click(function() {
	toggleNewListSection();
    }),
    //share list/invite member to list section
    $('#inviteMemberEntry').click(function() {
	toggleInviteMemberSection();
    }),
    //browse own invitations section
    $('#invitations').click(function() {
	toggleInvitationsSection();
    }),
    $('#accept_button').click(function() {
	acceptInvite(this);
    }),
    $('#decline_button').click(function() {
	removeInvite(this);
    }),
    //logout
    $('#logout').click(function() {
	logout();
    }),
    //lists
    //delete list
    $('#remove_list').click(function() {
	deleteList();
    });
});