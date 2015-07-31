<?php /*
		</div>
	</div>
</div>

<div class="RecordBox">
	<div class="RecordPanel">
	*/ ?>

		<div id="approval-container">
			<div id="approval-form">
				<div class="Title">Client Approval</div>
				
				<?php if ($resource['approval_status'] === 'approved'): ?>
					<div id="approved">
						<h3><span>Approved</span></h3>
						<p>Approved by <?php echo $history[0]['name'] ?> on <?php echo date('M j, Y', strtotime($history[0]['posted'])) ?></p>
						<p><a id="approval-form-toggle" href="#"><span class="minor">Revert to Not Approved</span></a></p>
					</div>
				<?php elseif ($resource['approval_status'] === 'minor'): ?>
					<div id="minor-edits">
						<h3><span>Not Approved</span></h3>
					</div>
				<?php elseif ($resource['approval_status'] === 'major'): ?>
					<div id="major-edits">
						<h3><span>Not Approved</span></h3>
					</div>
				<?php endif ?>
				
				<form id="form-approval" method="post" action="/plugins/approval/pages/approval.php"<?php if ($resource['approval_status'] === 'approved') echo ' class="hidden"' ?>>
					<input type="hidden" name="referrer" value="<?php echo base64_encode($_SERVER['REQUEST_URI']) ?>" />
					<input type="hidden" name="ref" value="<?php echo $ref ?>" />
					
					<p>Please carefully check your proof for spelling, puncuation, grammar, names, dates, phone numbers, &amp; email/website addresses.</p>
					
					<div>
						<table id="status-options">
							<tr>
								<td class="radio">
									<input type="radio" name="status" id="status-approved" required value="approved"<?php //if ($resource['approval_status'] === 'approved') echo ' checked="checked"' ?> />
								</td>
								<td class="label">
									<label for="status-approved">
										<span class="approved">Approved</span>
										<span class="desc">No Changes</span>
										<span class="desc-two">Proceed with job completion.</span>
									</label>
								</td>
								
								<td class="radio">
									<input type="radio" name="status" id="status-minor" value="minor"<?php //if ($resource['approval_status'] === 'minor') echo ' checked="checked"' ?> />
								</td>
								<td class="label">
									<label for="status-minor">
										<span class="minor">Not Approved</span>
										<span class="desc">Minor Changes</span>
										<span class="desc-two">List your changes below; you will be contacted when your updated proof is ready.</span>
									</label>
								</td>
								
								<td class="radio">
									<input type="radio" name="status" id="status-major" value="major"<?php //if ($resource['approval_status'] === 'major') echo ' checked="checked"' ?> />
								</td>
								<td class="label">
									<label for="status-major">
										<span class="major">Not Approved</span>
										<span class="desc">Major Changes</span>
										<span class="desc-two">We will call for further discussion.</span>
									</label>
								</td>
							</tr>
						</table>
						<input type="radio" style="visibility:hidden" id="validate-tricker" class="validate-one-required" />
					</div>
					
					<p>
						<label for="name">Reviewed by:</label>
						<input type="text" name="name" id="name" placeholder="Your Name" class="required" required />
					</p>
					
					<p id="approval-comments">
						<label for="comment">Comments &amp; Corrections (if applicable):</label>
						<textarea name="comment" id="comment" cols="80" rows="7"></textarea>
					</p>
					
					<p>
						<label for="signature">
							Please enter your initials below and click the Submit button.<br />
							<small><i>By initialing this form you are acknowledging receipt of this document, and verifying that<br /> you have carefully reviewed the artwork contained herein.</i></small>
						</label> 
					</p>

					<p>
						<input type="text" maxlength="3" name="signature" id="signature" size="2" class="required" required /> &nbsp; <span class="review-date">Reviewed on <?php echo date('F jS, Y \a\t g:i A') ?></span>
					</p>
					
					<br />
						<input class="approval-button" type="submit" value="Submit" />


				</form>
			</div>

			<div id="approval-history">
				<div class="Title">Approval History</div>

				<?php if (empty($history)): ?>
					No history yet.
				<?php else: ?>
					
					<table class="history">
						<?php foreach ($history as $row): ?>
							<tr>
								<th><?php echo date('M j, Y', strtotime($row['posted'])) ?></th>
								<td>
									<strong>Status:</strong> <?php echo approval_status($row['status']) ?><br />
									<strong>Name:</strong> <?php echo $row['name'] ?><br />
									<strong>Initials:</strong> <?php echo $row['signature'] ?><br />
									<?php if ( ! empty($row['comment'])): ?>
										<br />
										<?php echo nl2br($row['comment']) ?>
									<?php endif ?>
								</td>
							</tr>
						<?php endforeach ?>
					</table>
					
					<?php if (count($history) > 3): ?>
						<a href="#" id="approval-toggle-history">Show All History</a>
					<?php endif ?>
					
				<?php endif ?>
			</div>
		</div>
		
		<script type="text/javascript">
			// Hide extra history rows on page load
			var historyRows = jQuery('#approval-history tr');
			
			historyRows.each(function(index, row) {
				row = jQuery(row);
				if (index > 2) {
					row.css({display : 'none'});
				}
			});
			
			// Show extra history rows when asked
			var historyToggle = jQuery('#approval-toggle-history');
			
			if (historyToggle) {
				historyToggle.click(function(e) {
					historyRows.each(function(index, row) {
						row = jQuery(row);
						if (index > 2) {
							row.css({display : ((row.css('display') == 'table-row') ? 'none' : 'table-row')});
						}
					});
					this.blur();
					e.preventDefault();
				});
			}
			
			// Don't want it approved anymore? :(
			var formToggle = jQuery('#approval-form-toggle'),
			    form = jQuery('#form-approval');
			
			if (formToggle) {
				formToggle.click(function(e) {
					if (form.hasClass('hidden'))
						form.removeClass('hidden');
					else
						form.addClass('hidden');
					e.preventDefault();
				});
			}
			
			// Validate this son'bitch
			//var valid = new Validation('form-approval');
		</script>
<?php /*
	</div>
</div>

<div class="RecordBox">
	<div class="RecordPanel">
		<div class="RecordResource">
		*/ ?>