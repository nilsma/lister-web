<?php
require_once $SERVER['DOCUMENT_ROOT'] . 'lib/tools.php';
$user_id = $_SESSION['user_id'];
$num_inv = getInvQty($user_id, $mysqli);

echo <<<EOF

     <section id="menu" class="general_panel">
       <img id="close_menu" onclick="closeMenu()" src="media/close_window_w.png"></img>
       <section class="list_header">
	 <h3 class="list_name">Menu</h3>
       </section> <!-- end list_header -->

       <h3 class="menu_entry" id="newList"><a onclick="toggleNewListSection()">New List</a></h3>
       <section id="newListSection">
	 <h4>List name:</h4>
	 <form name="addNewList" id="listtocreate" method="post" action="javascript:addList(this.addNewList)">
	   <input id="newListTextField" class="cleanInput menu_input itemtoadd" type="text" name="listTitle">
	   <input type="submit" class="add_button" value="Create">
	 </form>
       </section> <!-- end newListSection -->

       <h3 class="menu_entry" id="inviteMemberEntry"><a onclick="toggleInviteMemberSection()">Share List</a></h3>
       <section id="inviteMemberSection">
	 <h4>Username:</h4>
	 <form name="inviteMember" id="listtoinvite" method="post" action="javascript:initiateInvite(inviteMemberTextField)">
	   <input id="inviteMemberTextField" class="cleanInput menu_input itemtoadd" type="text" name="memberToInvite" onclick="javascript:checkTextField(this)">
	   <select name="listChooser" class="itemtoadd" id="dropdown_menu">

EOF;
getListSummary($user_id, $mysqli);
echo <<<EOF
	   </select>
	   <input type="submit" class="add_button" value="Invite">
	 </form>
       </section> <!-- end end inviteMemberSection -->

       <h3 class="menu_entry" id="invitations"><a onclick="toggleInvitationsSection()" id="invitesNum">$num_inv</a></h3>
       <section id="invitationsSection">
EOF;
getInvitationLists($user_id);
echo <<<EOF

       </section> <!-- end invitationsSection -->
       
       <h3 class="menu_entry" id="logout"><a href="javascript:logout()">Logout</a></h3>
     </section> <!-- end menu -->
<!--     </div> -->	<!-- end left_column -->
EOF;

?>
