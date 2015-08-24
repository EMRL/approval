<?php

function HookApprovalViewHeadblock()
{
	global $lang, $css_reload_key;
	//echo '<link type="text/css" rel="stylesheet" media="all" href="/plugins/approval/style.css?css_reload_key='.$css_reload_key.'" />';
	//echo '<script type="text/javascript" src="/plugins/approval/validation.js?css_reload_key='.$css_reload_key.'"></script>';
}

function HookApprovalViewRenderbeforeresourcedetails()
{
	global $lang, $ref, $resource, $fields;
	
	$approval_form_id = sql_value("SELECT ref AS value FROM resource_type_field WHERE name = 'approval_form'", FALSE);
	
	if ( ! $approval_form_id)
		return;
	
	$approval_form = TidyList(get_data_by_field($ref, $approval_form_id));
	
	if ($approval_form !== 'Yes')
		return;
		
	$history = sql_query('SELECT id, ref, posted, comment, name, signature, status FROM approval WHERE ref = '.((int) $ref).' ORDER BY posted DESC');
	
	ob_start();
	
	$path = dirname(dirname(__FILE__));
	
	include $path.'/inc/approval.php';
	
	echo ob_get_clean();
}

function approval_status($status)
{
	global $lang;
	
	switch($status)
	{
		case 'approved':
			$status = '<span class="approved">Approved</span>';
			break;
			
		case 'minor':
			$status = '<span class="minor">Not Approved - Minor Changes</span>';
			break;
			
		case 'major':
			$status = '<span class="major">Not Approved - Major Changes</span>';
			break;
	}
	
	return $status;
}