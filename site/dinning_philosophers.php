<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_dinning_philosophers
 *
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted Access');

use \Joomla\CMS\Factory;
use \Joomla\CMS\MVC\Controller\BaseController;

$controller = BaseController::getInstance('Dinning_philosophers');

$input = Factory::getApplication()->input;
$controller->execute($input->getCmd('task'));

$controller->redirect();
