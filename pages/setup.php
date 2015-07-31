<?php
ini_set('display_errors', 1);
include '../../../include/db.php';
include '../../../include/authenticate.php'; if ( ! checkperm('u')) exit('Permission denied.');
include '../../../include/general.php';

if ($_POST)
{
	$email_to = getvalescaped('users', NULL);
	$email_to = str_replace(array('\n', '\r', '\t'), ',', $email_to);
	$email_to = explode(',', $email_to);
	$email_to = array_map('trim', $email_to);
	$email_to = array_filter($email_to);
	$email_to = implode(', ', $email_to);
	
	$email_subject = getvalescaped('email_subject', 'Asset Manager Client Approval Submission');
	
	$email_message = getvalescaped('email_message', '');
	
	$settings = array(
		'email_to'      => $email_to,
		'email_subject' => $email_subject,
		'email_message' => $email_message,
	);
	
	set_plugin_config('approval', $settings);
}

$settings = get_plugin_config('approval');

if (empty($settings))
{
	$settings = array();
}

$settings = $settings + array(
	'email_to'      => NULL,
	'email_subject' => 'Asset Manager Client Approval Submission',
	'email_message' => '',
);

?>

<?php include '../../../include/header.php' ?>

<div class="BasicsBox"> 
	<h2>&nbsp;</h2>
	<h1>Client Approval Settings</h1>
	
	<div class="VerticalNav">
		<form method="post" action="">
			<div class="Question">
				<label for="autocomplete"><?php echo $lang['emailtousers']?></label>
				<?php $userstring = $settings['email_to']; include '../../../include/user_select.php' ?>
				<div class="clearerleft"></div>
			</div>
			
			<div class="Question">
				<label for="email_subject">Email Subject:</label> 
				<input type="text" name="email_subject" id="email_subject" size="60" class="stdwidth" value="<?php echo htmlspecialchars($settings['email_subject']) ?>" />
				<div class="clearerleft"></div>
			</div>
			
			<div class="Question">
				<label for="email_message">
					Default Email Message:<br />
					Used as the default email message when sending an asset to clients.
				</label>
				<textarea name="email_message" id="email_message" cols="56" rows="4" class="stdwidth"><?php echo htmlspecialchars($settings['email_message']) ?></textarea>
				<div class="clearerleft"></div>
			</div>
			
			<div class="QuestionSubmit">
				<label for="buttons"></label>			
				<input type="submit" value="Save" />
			</div>
		</form>
	</div>
</div>

<?php include '../../../include/footer.php' ?>
