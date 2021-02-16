<?php 
/**
 * @package    Joomla.Administrator
 * @subpackage com_dinning_philosophers
 * 
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */
defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\MVC\Controller\BaseController;

// set some globals
$document = Factory::getDocument();
// $document->addStyleDeclaration('css stuff goes here');

// access check
if(!Factory::getUser()->authorise('core.manage', 'com_dinning_philosophers'))
{
	throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'));
}

// require helper
JLoader::register('Dinning_philosophersHelper',
    JPATH_COMPONENT.'/helpers/dinning_philosophers.php');
// require view
JLoader::register('dinning_philosophersViewdinning_philosophers',
    JPATH_COMPONENT.'/views/dinning_philosophers/view.html.php');

// get instance of controller
$controller = BaseController::getInstance('Dinning_philosophers');

// request task
$controller->execute(Factory::getApplication()->input->get('task'));

// retirect if set by controller
$controller->redirect();
