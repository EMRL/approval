<?php

function HookApprovalResource_emailFooterbottom()
{
	global $ref;
	
	$approval_form_id = sql_value("SELECT ref AS value FROM resource_type_field WHERE name = 'approval_form'", FALSE);
	
	if ( ! $approval_form_id)
		return;
	
	$approval_form = TidyList(get_data_by_field($ref, $approval_form_id));
	
	if ($approval_form !== 'Yes')
		return;
	
	$settings = get_plugin_config('approval');
	
	echo '
		<script type="text/javascript">
			document.getElementById("message").value = "'.htmlspecialchars($settings['email_message']).'";
		</script>
	';
}