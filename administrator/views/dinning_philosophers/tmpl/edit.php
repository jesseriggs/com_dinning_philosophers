<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_dinning_philosophers
 * 
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use \Joomla\CMS\Factory;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.formvalidator');

// The following is to enable setting the permission's Calculated Setting 
// when you change the permission's Setting. The core javascript code for
// initiating the Ajax request looks for a field with id="jform_title" and
// sets its value as the 'title' parameter to send in the Ajax request
Factory::getDocument()->addScriptDeclaration('
	jQuery(document).ready(function() {
        greeting = jQuery("#jform_greeting").val();
		jQuery("#jform_title").val(greeting);
	});
');

?>
<form action="<?php echo Route::_(
	'index.php?option=com_dinning_philosophers&layout=edit&id=' .
	(int) $this->item->id); ?>"
	method="post" name="adminForm" id="adminForm" class="form-validate">
    
    <input id="jform_title" type="hidden" name="dinning_philosophers-message-title"/>
    
    <div class="form-horizontal">

    <?php echo HTMLHelper::_('bootstrap.startTabSet', 'myTab',
	array('active' => 'details')); ?>
    <?php echo HTMLHelper::_('bootstrap.addTab', 'myTab', 'details', 
        empty($this->item->id) ? 
			Text::_('COM_DINNING_PHILOSOPHERS_TAB_NEW_MESSAGE')
			:
			Text::_('COM_DINNING_PHILOSOPHERS_TAB_EDIT_MESSAGE')); ?>
        <fieldset class="adminform">
            <legend><?php 
		echo Text::_('COM_DINNING_PHILOSOPHERS_LEGEND_DETAILS') ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php echo $this->form->renderFieldset('details');  ?>
                </div>
            </div>
        </fieldset>
    <?php echo HTMLHelper::_('bootstrap.endTab'); ?>

    <?php echo HTMLHelper::_('bootstrap.addTab', 'myTab', 'image',
		Text::_('COM_DINNING_PHILOSOPHERS_TAB_IMAGE')); ?>
        <fieldset class="adminform">
            <legend><?php
		echo Text::_('COM_DINNING_PHILOSOPHERS_LEGEND_IMAGE') ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php echo $this->form->renderFieldset('image-info');  ?>
                </div>
            </div>
        </fieldset>
    <?php echo HTMLHelper::_('bootstrap.endTab'); ?>

    <?php echo HTMLHelper::_('bootstrap.addTab', 'myTab', 'params',
		Text::_('COM_DINNING_PHILOSOPHERS_TAB_PARAMS')); ?>
        <fieldset class="adminform">
            <legend><?php
		echo Text::_('COM_DINNING_PHILOSOPHERS_LEGEND_PARAMS') ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php echo $this->form->renderFieldset('params');  ?>
                </div>
            </div>
        </fieldset>
    <?php echo HTMLHelper::_('bootstrap.endTab'); ?>

    <?php echo HTMLHelper::_('bootstrap.endTabSet'); ?>

    </div>
    <input type="hidden" name="task" value="dinning_philosophers.edit" />
    <?php echo HTMLHelper::_('form.token'); ?>
</form>
