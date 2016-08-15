ALTER TABLE `games` ADD `game_series_index` INT NULL DEFAULT NULL AFTER `creator_game_index`;
UPDATE game_types SET event_type_name='election', url_identifier='mock-election-2016-day-', name='Mock Election 2016, Day ', round_length='30', seconds_per_block='30', payout_weight='coin_block', start_condition_players='12', buyin_policy='per_user_cap' WHERE game_type_id=1;