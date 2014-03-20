$(document).ready(function() {
    $('#menu_button').click(function() {
	openMenu();
    }),
    $('#close_menu').click(function() {
	closeMenu();
    }),
    $('#lists_button').click(function() {
	openLists();
    }),
    $('#newList').click(function() {
	toggleNewListSection();
    }),
    $('#inviteMemberEntry').click(function() {
	toggleInviteMemberSection();
    }),
    $('#invitations').click(function() {
	toggleInvitationsSection();
    }),
    $('#logout').click(function() {
	logout();
    });
});