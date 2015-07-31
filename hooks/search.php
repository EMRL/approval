<?php

function HookApprovalSearchResourcethumbtop()
{
	global $result, $n;

	showApproval($result[$n]);
}

function HookApprovalSearchRenderimagesmallthumb()
{
	global $result, $n;

	showApproval($result[$n]);
}

function HookApprovalSearchRenderimagelargethumb()
{
	global $result, $n;

	showApproval($result[$n]);
}

function showApproval($result)
{
	$approval         = sql_value("SELECT approval_status AS value FROM resource WHERE ref = {$result['ref']}", FALSE);
	$approval_form_id = sql_value("SELECT ref AS value FROM resource_type_field WHERE name = 'approval_form'", FALSE);
	
	if ( ! $approval_form_id)
		return;
	
	$approval_form = TidyList(get_data_by_field($result['ref'], $approval_form_id));

	if (empty($approval) AND strpos($approval_form, 'Yes') !== FALSE)
	{
		$approval = 'waiting';
	}

	if ($approval)
	{
		switch ($approval)
		{
			case 'waiting':
				$title = 'Awaiting Approval';
				break;

			case 'minor':
				$title = 'Minor Changes Needed';
				break;

			case 'major':
				$title = 'Major Changes Needed';
				break;

			case 'approved':
				$title = 'Approved';
				break;
		}

		echo '<span class="rps-approval rps-approval-'.$approval.'" title="'.$title.'"></span>';
	}
}