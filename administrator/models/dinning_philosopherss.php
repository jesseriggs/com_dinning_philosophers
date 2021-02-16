<?php
/**
 * @package	Joomla.Administrator
 * @subpackage	com_dinning_philosophers
 * 
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

use \Joomla\CMS\Factory;
use \Joomla\CMS\Form\Form;
use \Joomla\CMS\MVC\Model\ListModel;

/**
 * Dinning_philosophersList Model
 */
class Dinning_philosophersModelDinning_philosopherss extends ListModel
{
	/**
	 * Constructor.
	 * @param array $config an optional associative array of configuration settings.
	 * @see	JController
	 */
	public function __construct($config = array())
	{
		if(empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
			    'metadesc',
				'created_by_alias',
				'created',
				'published'
			);
		}

		parent::__construct($config);
	}

	/**
	 * We may need to implement loadFormData..???
	 * Or, preprocessForm???
	 */
	public function preprocessForm(Form $form, $data, $group="content")
	{
		return true;
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string An SQL query
	 */
	protected function getListQuery()
	{
		$db	= Factory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('t.id as id, t.published as published, 
			t.created as created, t.image as imageInfo, 
			t.created_by_alias as author, t.alias as alias')
			->from($db->quoteName('#__dinning_philosophers', 't'));
		$query->select($db->quoteName('c.title', 'category_title'))
			->join('LEFT',
				$db->quoteName('#__categories', 'c').
				' ON c.id = t.catid');
		
		return $query;
	}
}
