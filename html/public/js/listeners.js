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
    //accept button on invite
    $('#accept_btn').click(function() {
	acceptInvite(this);
    }),
    //decline button on invite
    $('#decline_btn').click(function() {
	removeInvite(this);
    }),
    /**
     * listeners for logout section
     */
    $('#logout').click(function() {
	logout();
    });
});