<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_dinning_philosophers
 * 
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use \Joomla\CMS\Factory;
use \Joomla\CMS\Helper\ContentHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\MVC\View\HtmlView;
use \Joomla\CMS\Uri\Uri;

/**
 * Dinning_philosophers View
 */
class Dinning_philosophersViewDinning_philosophers extends HtmlView
{
	protected $form;
	protected $item;
	protected $script;
	protected $canDo;

	/**
	 * Display the Dinning_philosophers view
	 *
	 * @param	string  $tpl  The name of the dinning_philosophers file to parse;
	 * 		automatically searches through the dinning_philosophers paths.
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		// Get the Data
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->script = $this->get('Script');

		// What Access Permissions does this user have? What can 
		// (s)he do?
		$this->canDo = ContentHelper::getActions(
			'com_dinning_philosophers',
			'dinning_philosophers',
			$this->item->id);

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// Set the toolbar
		$this->addToolBar();

		// Display the dinning_philosophers
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolBar()
	{
	    $input = Factory::getApplication()->input;

		// Hide Joomla Administrator Main menu
		$input->set('hidemainmenu', true);

		$isNew = ($this->item->id == 0);

		JToolBarHelper::title(
			$isNew	?
				Text::_('COM_DINNING_PHILOSOPHERS_MANAGER_DINNING_PHILOSOPHERS_NEW')
				:
				Text::_('COM_DINNING_PHILOSOPHERS_MANAGER_DINNING_PHILOSOPHERS_EDIT')
			,'dinning_philosophers');
		// Build the actions for new and existing records.
		if ($isNew)
		{
			// For new records, check the create permission.
			if ($this->canDo->get('core.create')) 
			{
				JToolBarHelper::apply('dinning_philosophers.apply',
					'JTOOLBAR_APPLY');
				JToolBarHelper::save('dinning_philosophers.save',
					'JTOOLBAR_SAVE');
				JToolBarHelper::custom('dinning_philosophers.save2new',
					'save-new.png', 'save-new_f2.png',
					'JTOOLBAR_SAVE_AND_NEW', false);
			}
			JToolBarHelper::cancel('dinning_philosophers.cancel',
				'JTOOLBAR_CANCEL');
		}
		else
		{
			if ($this->canDo->get('core.edit'))
			{
				// We can save the new record
				JToolBarHelper::apply('dinning_philosophers.apply',
					'JTOOLBAR_APPLY');
				JToolBarHelper::save('dinning_philosophers.save',
					'JTOOLBAR_SAVE');
 
				// We can save this record, but check the
				// create permission to see if we can return
				// to make a new one.
				if ($this->canDo->get('core.create')) 
				{
					JToolBarHelper::custom(
						'dinning_philosophers.save2new',
						'save-new.png',
						'save-new_f2.png',
						'JTOOLBAR_SAVE_AND_NEW',
						false);
				}
			}
			if ($this->canDo->get('core.create')) 
			{
				JToolBarHelper::custom('dinning_philosophers.save2copy',
					'save-copy.png', 'save-copy_f2.png',
					'JTOOLBAR_SAVE_AS_COPY', false);
			}
			JToolBarHelper::cancel('dinning_philosophers.cancel',
				'JTOOLBAR_CLOSE');
		}
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$isNew = ($this->item->id == 0);
		$document = Factory::getDocument();
		$document->setTitle($isNew ?
			Text::_('COM_DINNING_PHILOSOPHERS_DINNING_PHILOSOPHERS_CREATING')
		                           :
			Text::_('COM_DINNING_PHILOSOPHERS_DINNING_PHILOSOPHERS_EDITING'));
		$document->addScript(Uri::root() . $this->script);
		$document->addScript(Uri::root() .
			"administrator/components/com_dinning_philosophers" .
			"/models/forms/submitbutton.js");
		Text::script('COM_DINNING_PHILOSOPHERS_DINNING_PHILOSOPHERS_ERROR_UNACCEPTABLE');
	}
}
