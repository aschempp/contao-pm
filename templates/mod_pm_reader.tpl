
<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
<?php if ($this->headline): ?>

<<?php echo $this->hl; ?>><?php echo $this->headline; ?></<?php echo $this->hl; ?>>
<?php endif; ?>

<div class="private-message-reader">
	<div class="sender">
		<span class="label"><?php echo $this->label_sender; ?></span>
		<span class="value"><?php echo $this->sender; ?></span>
	</div>
	<div class="recipient">
		<span class="label"><?php echo $this->label_recipient; ?></span>
		<span class="value"><?php echo $this->recipient; ?></span>
	</div>
	<div class="subject">
		<span class="label"><?php echo $this->label_subject; ?></span>
		<span class="value"><?php echo $this->subject; ?></span>
	</div>
	<div class="message">
		<span class="label"><?php echo $this->label_message; ?></span>
		<span class="value"><?php echo $this->message; ?></span>
	</div>
	
	<form action="<?php echo $this->actionReply; ?>" method="get">
	<div class="formbody">
		<input class="submit reply" type="submit" value="<?php echo $this->label_reply; ?>" />
	</div>
	</form>
	<form action="<?php echo $this->actionDelete; ?>" method="post">
	<div class="formbody">
		<input type="hidden" name="FORM_SUBMIT" value="tl_pm_delete" />
		<input type="hidden" name="pm_id" value="<?php echo $this->pm_id; ?>" />
		<input class="submit delete" type="submit" name="submit" value="<?php echo $this->label_delete; ?>" />
	</div>
	</form>
</div>

</div>