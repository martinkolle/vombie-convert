<?php

defined('_JEXEC') or die('Restricted access');

?>
<div id="tablecell">
	<div id="fail-message">
		<p><strong>
		You can safely ignore "Failed! - Duplicate Key!" errors. Please verify first that the contents you imported are present in your Joomla site or not.
		</strong></p>
	</div>
    <table class="adminform">
    <tr class="row1">
        <td align="right">
            <?php echo JText::_( 'Import Users' ); ?>
        </td>
        <td>
			<?php echo $this->errors['users']; ?>
        </td>
    </tr>


    </table>

</div>


