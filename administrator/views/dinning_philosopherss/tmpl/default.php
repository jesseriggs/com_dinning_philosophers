<?php
/**
 * @package     Joomla.Administrator
 * @subpackage	com_dinning_philosophers
 * 
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted Access');

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Uri\Uri;
use \Joomla\Registry\Registry;

HTMLHelper::_('formbehavior.chosen', 'select');

?>
<form action="index.php?option=com_dinning_philosophers&view=dinning_philosopherss" method="post" id="adminForm" name="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?php echo JHtmlSidebar::render();?>
	</div>
	<div id="j-main-container" class="span10">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th width="1%">num</th>
					<th width="2%">chekcall</th>
					<th width="15%">name</th>
					<th width="30%">image</th>
					<th width="15%">author</th>
					<th width="15%">created</th>
					<th width="5%">published</th>
					<th width="2%">id</th>
				</tr>
			</thead>
		<tbody>
				<?php if(!empty($this->items)) : ?>
				<?php foreach($this->items as $i => $row):
				$link = Route::_('index.php?option=com_dinning_philosophers&task=dinning_philosophers.edit&id=' . $row->id);
				$row->image = new Registry;
				$row->image->loadString($row->imageInfo);
				?>
				<tr>
					<td id="pagination"><?php echo $this->pagination->getRowOffset($i); ?></td>
					<td id="checkall"><?php echo HTMLHelper::_('grid.id', $i, $row->id);?></td>
					<td id="name">
						<a href="<?php echo $link;?>"
							title="<?php echo Text::_('COM_DINNING_PHILOSOPHERS_EDIT_DINNING_PHILOSOPHERS');?>">
						</a>
						<span class="small break-word">
							<?php echo Text::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($row->alias));?>
						</span>
						<div class="small">
							<?php echo Text::_('JCATEGORY').': '.$this->escape($row->category_title);?>
						</div>
					</td>
					<td id="image" align="center">
						<?php
						$caption = $row->image->get('caption') ? : '';
						$src = Uri::root().($row->image->get('image')?:'');
						$html='<p class="hasTooltip" style="display: inline-block" data-html="true" data-toggle="tooltip" data-placement="right" title="<img src=\'%s\'>">%s</p>';
						echo sprintf($html, $src, $caption); ?>
					</td>
					<td id="author" align="center">
						<?php echo $row->author;?>
					</td>
					<td id="created" align="center">
						<?php echo substr($row->created, 0, 10);?>
					</td>
					<td id="published" align="center">
						<?php echo HTMLHelper::_('jgrid.published', $row->published, $i, 'dinning_philosophers.', true, 'cb');?>
					</td>
					<td id="id" align="center">
						<?php echo $row->id;?>
					</td>
				</tr>
				<?php endforeach;?>
				<?php endif;?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5">
						<?php echo $this->pagination->getListFooter();?>
					</td>
				</tr>
			</tfoot>
		</table>
		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="boxchecked" value="0"/>
		<?php echo HTMLHelper::_('form.token');?>
	</div>
</form>
