<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
<?php if ($this->headline): ?>

<<?php echo $this->hl; ?>><?php echo $this->headline; ?></<?php echo $this->hl; ?>>
<?php endif; ?>

<form action="<?php echo $this->action; ?>" method="post">
<div class="formbody">
<input type="hidden" name="FORM_SUBMIT" value="tl_pm_delete_all" />
<table cellpadding="0" cellspacing="0" class="sortable" id="table_<?php echo $this->id; ?>" summary="Table holds messages">
	<thead>
		<tr>
			<th class="head_0 col_first unsortable"><input id="ctrl_checkall_<?php echo $this->id; ?>" type="checkbox" onclick="$$('.pm_delete_<?php echo $this->id; ?>').each( function(el) { el.checked=$('ctrl_checkall_<?php echo $this->id; ?>').checked; } )" /></th>
			<th class="head_1"><?php echo $this->label_date; ?></th>
			<th class="head_2"><?php echo $this->label_sender; ?></th>
			<th class="head_3"><?php echo $this->label_recipient; ?></th>
			<th class="head_4"><?php echo $this->label_subject; ?></th>
			<th class="head_5 col_last"><?php echo $this->label_status; ?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($this->messages as $arrMessage): ?>
		<tr class="<?php echo $arrMessage['class']; ?>">
			<td class="col_0 col_first"><input class="pm_delete pm_delete_<?php echo $this->id; ?>" type="checkbox" name="delete[]" value="<?php echo $arrMessage['id']; ?>" /></td>
			<td class="col_1"><?php echo $arrMessage['date']; ?></td>
			<td class="col_2"><?php echo $arrMessage['sender']; ?></td>
			<td class="col_3"><?php echo $arrMessage['recipient']; ?></td>
			<td class="col_4"><a href="<?php echo $arrMessage['href']; ?>"><?php echo $arrMessage['subject']; ?></a></td>
			<td class="col_5 col_last"><?php echo $arrMessage['status']; ?></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

<div class="submit_container"><input type="submit" class="submit" value="Markierte löschen" /></div>

</div>
</form>

<!-- indexer::stop -->
<script type="text/javascript">
<!--//--><![CDATA[//><!--
window.addEvent('domready', function() { new TableSort('table_<?php echo $this->id; ?>'); });
//--><!]]>
</script>
<!-- indexer::continue -->

</div>