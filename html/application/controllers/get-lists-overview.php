<?php

echo <<<EOF
	  <section id="lists_owner_overview" class="general_panel">
	    <img id="close_lists" onclick="closeLists()" src="{$pics_path}/close_window_w.png"></img>
	    <section class="list_header">
	      <h3 class="list_name">my lists</h3>
	    </section> <!-- end list_header -->
	    <ul id="owner_lists">
EOF;

if(count($owner_lists) >= 1) {
  foreach($owner_lists as $title => $id) {
    buildOwnerList($title);
  }
} else {
  echo '<p class="user_lists_overview">You havent made any lists yet</p>';
}
echo <<<EOF
           </ul> <!-- end lists -->                                                                                                   
          </section> <!-- end lists_overview -->
EOF;

echo <<<EOF
	  <section id="lists_member_overview" class="general_panel">
	    <img id="close_lists" onclick="closeLists()" src="{$pics_path}/close_window_w.png"></img>
	    <section class="list_header">
	      <h3 class="list_name">other lists</h3>
	    </section> <!-- end list_header -->
	    <ul id="member_lists">
EOF;

if(count($member_lists) >= 1) {
  foreach($member_lists as $title => $id) {
    buildMemberList($title);
  }
} else {
  echo '<p class="user_lists_overview">You do not subscribe to any lists yet</p>';
}
echo <<<EOF
           </ul> <!-- end lists -->                                                                                                   
          </section> <!-- end lists_overview -->
EOF;
?>
