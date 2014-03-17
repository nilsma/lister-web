<?php

echo <<<EOF
	  <section id="lists_overview" class="general_panel">
	    <img id="close_lists" onclick="closeLists()" src="{$pics_path}/close_window_w.png"></img>
	    <section class="list_header">
	      <h3 class="list_name">my lists</h3>
	    </section> <!-- end list_header -->
	    <ul id="lists">
EOF;

if(count($user_lists) >= 1) {
  foreach($user_lists as $title => $id) {
    buildList($title);
  }
} else {
echo 'nachos';
}
echo <<<EOF
           </ul> <!-- end lists -->                                                                                                   
          </section> <!-- end lists_overview -->
EOF;
?>
