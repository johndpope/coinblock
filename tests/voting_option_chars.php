<?php
$host_not_required = true;
include(realpath(dirname(dirname(__FILE__)))."/includes/connect.php");

if (!empty($argv)) {
	$cmd_vars = $app->argv_to_array($argv);
	if (!empty($cmd_vars['key'])) $_REQUEST['key'] = $cmd_vars['key'];
	else if (!empty($cmd_vars[0])) $_REQUEST['key'] = $cmd_vars[0];
}

if (empty($GLOBALS['cron_key_string']) || $_REQUEST['key'] == $GLOBALS['cron_key_string']) {
	$pass_count = 0;
	$fail_count = 0;
	for ($option_index=0; $option_index<1000; $option_index++) {
		$vote_identifier = $app->option_index_to_vote_identifier($option_index);
		$test_addr = "1".$vote_identifier."abctest";
		$addr_vote_identifier = $app->addr_text_to_vote_identifier($test_addr);
		$addr_option_index = $app->vote_identifier_to_option_index($addr_vote_identifier);
		echo "$option_index=$vote_identifier, $addr_option_index=$addr_vote_identifier<br/>\n";
		if ($option_index == $addr_option_index) $pass_count++;
		else $fail_count++;
	}
	echo "Passed ".$pass_count." tests and failed ".$fail_count."<br/>\n";
}
else echo "Please supply the correct key.\n";
?>
