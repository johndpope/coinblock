<?php
if (!isset($session_key)) {
	$session_key = session_id();
}

if ($session_key == "") {
	session_start();
	$session_key = session_id();
}

$thisuser = FALSE;
$game = FALSE;

if (strlen($session_key) > 0) {
	$q = "SELECT * FROM user_sessions WHERE session_key=".$app->quote_escape($session_key)." AND expire_time > '".time()."' AND logout_time=0;";
	$r = $app->run_query($q);
	
	if ($r->rowCount() == 1) {
		$session = $r->fetch();
		
		$thisuser = new User($app, $session['user_id']);
		
		if ($thisuser->db_user) {
			if (!empty($_REQUEST['game_id'])) {
				$game_id = intval($_REQUEST['game_id']);
				
				$q = "SELECT g.* FROM games g JOIN user_games ug ON g.game_id=ug.game_id WHERE ug.user_id='".$thisuser->db_user['user_id']."' AND g.game_id='".$game_id."';";
				$r = $app->run_query($q);
				
				if ($r->rowCount() > 0) {
					$db_game = $r->fetch();
					
					$blockchain = new Blockchain($app, $db_game['blockchain_id']);
					$game = new Game($blockchain, $db_game['game_id']);
				}
			}
		}
		else $thisuser = false;
	}
	else {
		while ($session = $r->fetch()) {
			$qq = "UPDATE user_sessions SET logout_time='".time()."' WHERE session_id='".$session['session_id']."';";
			$rr = $app->run_query($qq);
		}
		$session = false;
	}
}
?>
