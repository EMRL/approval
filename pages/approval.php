<?php

include '../../../include/db.php';
//include '../../../include/authenticate.php'; if ( ! checkperm('u')) exit('Permission denied.');
include '../../../include/general.php';

// Stupid function to provide default values
function val($val, $default = NULL)
{
	return empty($val) ? $default : $val;
}
	
// Get posted values
$referrer  = base64_decode(getvalescaped('referrer', base64_encode('../../../index.php')));
$ref       = (int) getvalescaped('ref', -999);
$time      = time();
$status    = getvalescaped('status', 'approved');
$name      = getvalescaped('name', NULL);
$signature = getvalescaped('signature', NULL);
$comment   = getvalescaped('comment', NULL);

// Validate
$valid = TRUE;

if (empty($name) OR empty($signature) OR ! in_array($status, array('approved', 'minor', 'major')))
{
	$valid = FALSE;
}

// If no $_POST or this resource doesn't exist then redirect back to resource
if (empty($_POST) OR ! $valid OR $ref === -999 OR ((int) sql_value("SELECT COUNT(*) AS value FROM resource WHERE ref = $ref", 0) < 1))
{
	redirect($referrer);
}

// Insert a new history item
sql_query("INSERT INTO approval (ref, posted, comment, name, signature, status) VALUES ($ref, NOW(), '$comment', '$name', '$signature', '$status')");

// Update resource approval field
sql_query("UPDATE resource SET approval_status = '$status' WHERE ref = $ref");

// Get approval plugin settings
$settings = get_plugin_config('approval');

$email_to = val($settings['email_to']);

// If theres no one to email then redirect back to resource
if ($email_to === NULL)
{
	redirect($referrer);
}

// Get the emails in the correct format
$email_to = resolve_userlist_groups($email_to);
$email_to = explode(',', $email_to);
$email_to = array_map('trim', $email_to);
$email_to = array_filter($email_to);

// Replace usernames with their emails
foreach ($email_to as $key => $email)
{
	$user_email = sql_value("SELECT email AS value FROM user WHERE username = '$email'", NULL);
	
	if ($user_email === NULL)
	{
		if (strpos($email, '@') === FALSE)
		{
			unset($email_to[$key]);
			continue;
		}
	}
	else
	{
		$email_to[$key] = $user_email;
	}
}

// Setup email
$email_to = implode(',', $email_to);
$email_subject = val($settings['email_subject'], 'Asset Manager Client Approval Submission');

$resource = get_resource_data($ref);

switch($status)
{
	case 'approved':
		$status = 'Approved';
		break;
	
	case 'minor':
		$status = 'Not Approved - Minor Changes';
		break;
		
	case 'major':
		$status = 'Not Approved - Major Changes';
		break;
}

ob_start();
include '../inc/email.php';
$message = ob_get_clean();

// Send emails
send_mail($email_to, $email_subject, $message);

// Redirect back to resource
redirect($referrer);