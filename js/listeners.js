$(document).ready(function() {
    //menu
    //open/close
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
    //logout
    $('#logout').click(function() {
	logout();
    });
});