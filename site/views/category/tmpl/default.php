<?php
/**
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

defined('_JEXEC') or die("Restricted");

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Layout\LayoutHelper;
use \Joomla\CMS\Router\Route;

HTMLHelper::_('formbehavior.chosen', 'select');

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<form action="#" method="post" id="adminForm" name="adminForm">
<div id="j-main-container" class="span10">
	<div class="row-fluid">
		<div class="span10">
			<?php
				echo LayoutHelper::render(
					'joomla.searchtools.default',
					array('view'=>$this, 
						'searchButton' => false)
				);
			?>
		</div>
	</div>
<table class="table table-striped table-hover">
	<thead>
	<tr>
		<th width="5%"><?php echo Text::_('JGLOBAL_NUM');?></th>
		<th width="20%">
			<?php echo HTMLHelper::_('searchtools.sort',
				'COM_DINNING_PHILOSOPHERS_DINNING_PHILOSOPHERS_ALIAS_LABEL',
				'alias', $listDirn, $listOrder);
			?>
		</th>
		<th  width="20%">
			<?php echo Text::_(
				'COM_DINNING_PHILOSOPHERS_DINNING_PHILOSOPHERS_FIELD_URL_LABEL');
			?>
		</th>
		<th width="5%">
			<?php echo HTMLHelper::_('searchtools.sort', 
				'JGLOBAL_FIELD_ID_LABEL',
				'id',
				$listDirn, $listOrder);
			?>
		</th>
	</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="5">
				<?php 
				 echo $this->pagination->getListFooter();
				?>
			</td>
		</tr>
	</tfoot>
	<tbody>
		<?php if(!empty($this->items)):?>
		  <?php foreach($this->items as $i => $row):
			 $url = Route::_(
			  'index.php?option=com_dinning_philosophers&view=dinning_philosophers&id='.
			  $row->id);
			 ?>
			<tr>
				<td align="center"><?php echo 
					$this->pagination->getRowOffset($i);?>
				</td>
				<td align="center"><?php echo
					$row->alias; ?>
				</td>
				<td align="center"><a href="<?php echo $url;
					?>"><?php echo $url;?></a>
				</td>
				<td align="center"><?php echo $row->id;?>
				</td>
			</tr>
		  <?php endforeach;?>
		<?php endif;?>
	</tbody>
</table>
</div>
</form>
