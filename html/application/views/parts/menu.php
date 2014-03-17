<?php


echo <<<EOF
   <!-- menu.php -->
       <section id="menu" class="general_panel">
         <img id="close_menu" src="{$pics_path}close_window_w.png"/>
         <section class="list_header">
           <h3 class="list_name">Menu</h3>
	 </section> <!-- end list_header -->

       <h3 class="menu_entry" id="newList">New List</h3>
       <section id="newListSection">
         <h4>List name:</h4>
	 <form name="addNewList" method="post" action="{$mods_path}add-new-list.php">
           <input class="menu_input itemtoadd" type="text" name="title">
           <input id="addNewList" type="submit" class="add_button" value="Create">
         </form>
       </section> <!-- end newListSection -->

       <h3 class="menu_entry" id="inviteMemberEntry">Share List</h3>
       <section id="inviteMemberSection">
	<h4>Username:</h4>
         <form name="inviteMember" method="post" onsubmit="return confirm('Confirm invite')" action="{$mods_path}add-invite.php">
	   <input class="cleanInput menu_input itemtoadd" type="text" name="receiver">
           <select name="title" class="itemtoadd" id="dropdown_menu">

EOF;

invOptions($user_lists);

echo <<<EOF
           </select>
           <input type="submit" class="add_button" value="Invite">
         </form>
       </section> <!-- end end inviteMemberSection -->

       <h3 class="menu_entry" id="invitations">Invitations [<span id="invitesNum">$num_inv</span>]</h3>
       <section id="invitationsSection">

EOF;

invDisplay($myInvites, $mods_path);

echo <<<EOF
       </section> <!-- end invitationsSection -->

       <h3 id="logout" class="menu_entry">Logout</h3>
     </section> <!-- end menu -->

EOF;

?>
