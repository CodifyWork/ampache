<?php
/*

 Copyright (c) 2001 - 2007 Ampache.org
 All rights reserved.

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License v2
 as published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

*/

/**
 * Sub-Ajax page, requires AJAX_INCLUDE as one
 */
if (AJAX_INCLUDE != '1') { exit; } 

switch ($_REQUEST['action']) { 
	case 'delete_track': 
		// Create the object and remove the track
		$playlist = new Playlist($_REQUEST['playlist_id']); 
		$playlist->format(); 
		if ($playlist->has_access()) {
			$playlist->delete_track($_REQUEST['track']); 
		} 

		$object_ids = $playlist->get_items(); 
		ob_start(); 
		require_once Config::get('prefix') . '/templates/show_playlist_songs.inc.php'; 	
		$results['browse_content'] = ob_get_contents(); 
		ob_end_clean(); 
	break;
	default: 
		$results['rfc3514'] = '0x1'; 
	break;
} // switch on action; 

// We always do this
echo xml_from_array($results); 
?>
