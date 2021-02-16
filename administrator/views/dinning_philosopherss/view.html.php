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

/**
 * Dinning_philosopherss View
 */
class Dinning_philosophersViewDinning_philosopherss extends HtmlView
{
	/**
	 * Display the Cat World view
	 *
	 * @param	string  $tpl  The name of the dinning_philosophers file to parse;
	 * 		automatically searches through the dinning_philosophers paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		
		// Get application
	    $app = Factory::getApplication();
		$context = "dinning_philosophers.list.admin.dinning_philosophers";
		// Get data from the model
		$this->items			= $this->get('Items');
		$this->pagination		= $this->get('Pagination');		
		$this->state			= $this->get('State');
		// Remove the old ordering mechanism
        $this->filter_order 	= $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'greeting', 'cmd');
        $this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
        
        // JForm::getInstance could not load file???
        $this->filterForm    	= $this->get('FilterForm');
        $this->activeFilters 	= $this->get('ActiveFilters');
        
		// What Access Permissions does this user have? What can (s)he do?
        $this->canDo = ContentHelper::getActions('com_dinning_philosophers');
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			//JError::raiseError(500, implode('<br />', $errors));

			return false;
		}
        
		// Set the submenu
		Dinning_philosophersHelper::addSubmenu('dinning_philosopherss');

		// Set the toolbar and number of found items
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
	 */
	protected function addToolBar()
	{
		$title = Text::_('COM_DINNING_PHILOSOPHERS_MANAGER_DINNING_PHILOSOPHERSS');

		if ($this->pagination->total)
		{
			$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		}

		JToolBarHelper::title($title, 'dinning_philosophers');
		if ($this->canDo->get('core.create')) 
		{
			JToolBarHelper::addNew('dinning_philosophers.add', 'JTOOLBAR_NEW');
		}
		if ($this->canDo->get('core.edit')) 
		{
			JToolBarHelper::editList('dinning_philosophers.edit', 'JTOOLBAR_EDIT');
		}
		if ($this->canDo->get('core.delete')) 
		{
			JToolBarHelper::deleteList('', 'dinning_philosopherss.delete', 'JTOOLBAR_DELETE');
		}
		if ($this->canDo->get('core.admin')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_dinning_philosophers');
		}
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
	    $document = Factory::getDocument();
		$document->setTitle(Text::_('COM_DINNING_PHILOSOPHERS_ADMINISTRATION'));
	}
}
