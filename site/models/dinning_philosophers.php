<?php
/**
 * @package	    Joomla.Site
 * @subpackage	com_dinning_philosophers
 *
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

defined('_JEXEC') or die('restricted access');

use \Joomla\CMS\MVC\Model\ItemModel;
use \Joomla\CMS\Factory;
use \Joomla\Registry\Registry;
use \Joomla\CMS\Table\Table;


JLoader::register('Dinning_philosophersHelperRout', JPATH_ROOT . '/components/com_dinning_philosophers/helpers/route.php');

/**
 * Dinning_philosophers Model
 */
class Dinning_philosophersModelDinning_philosophers extends ItemModel
{
	/**
	 * Holds a database query full of dinning_philosophers info.
	 * 
	 * @var object item
	 */
	protected $item;
	
	/**
	 * Method to auto-populate the model state.
	 * This method should only be called once per instantiation and is
	 * designed to be called on the first call to the getState() method
	 * unless the model configuratoin flag to ignore the request is set.
	 *
	 * Note: calling getState in this method will result in recursion.
	 *
	 * @return void
	 */
	protected function populateState()
	{
		// get the message id
		$jinput	= Factory::getApplication()->input;
		$id	= $jinput->get('id', 1, 'INT');
		$this->setState('message.id', $id);

		// load parameters.
		$this->setState('params', 
			Factory::getApplication()->getParams());
		parent::populateState();
	}

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param	string	$type	table name, optional
	 * @param	string	$prefix	class prefix, optional
	 * @param	array	$config	Configuration array for model, optional
	 *
	 * @return	Table	Table object
	 */
	public function getTable($type = 'Dinning_philosophers', 
		$prefix = 'Dinning_philosophersTable',
		$config = array())
	{
		return Table::getInstance($type, $prefix, $config);
	}

	/**
	 * Get the message
	 * @return object the message to be displayed
	 */
	public function getItem()
	{
		if(!isset($this->item))
		{
			$id	= $this->getState('message.id');
			$db	= Factory::getDbo();
			$query = $db->getQuery(true);
			$query->select('t.params, t.image, t.title, t.metadesc, ' . 
			    't.created_by_alias, t.language, t.catid, t.alias');
	 		$query->from('#__dinning_philosophers as t');
 			$query->where('t.id='.(int)$id);
			$db->setQuery((string)$query);

			if($this->item = $db->loadObject())
			{
				// Load JSON String
				$params = new Registry;
				$params->loadString($this->item->params, 
					'JSON');
				$this->item->params = $params;

				// Merge global params with item params
				$params = clone $this->getState('params');
				$params->merge($this->item->params);
				$this->item->params = $params;

				// convert the JSON-enc image info into array
				$image = new Registry;
				$image->loadString($this->item->image, 'JSON');
				$this->item->imageDetails = $image;
			}
		}
		return $this->item;
	}

}
