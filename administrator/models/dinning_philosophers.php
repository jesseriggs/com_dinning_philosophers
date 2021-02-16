<?php
/**
 * @package		Joomla.Adminstrator
 * @subpackage	com_dinning_philosophers
 * 
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

use \Joomla\CMS\Factory;
use \Joomla\CMS\MVC\Model\AdminModel;
use \Joomla\CMS\Table\Table;
use \Joomla\Registry\Registry;

/**
 * Dinning_philosophers Model
 */
class Dinning_philosophersModelDinning_philosophers extends AdminModel
{
	/**
	 * Method to override getItem to allow us to convert the JSON-encoded
	 * image information in the database to record into an array for
	 * subsequent prefilling of the edit form. 
	 */
	public function getItem($pk = null)
	{
		$item = parent::getItem($pk);
		if($item AND property_exists($item, 'image'))
		{
			$registry = new Registry($item->image);
			$item->imageinfo = $registry->toArray();
		}
		return $item;
	}
	/**
	 * Method to get a table object, load it if necessary.
	 * @param	string $type	table name. Optional
	 * @param	string $prefix	Class prefix. Optional
	 * @param	array  $config	Config array for model. Optional
	 * @return	Table
	 */
	public function getTable($type='Dinning_philosophers', 
				$prefix='Dinning_philosophersTable', 
				$config=array())
	{
	    return Table::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 * @param	array	$data	Data for form.
	 * @param	boolean	$loadData	True if the form is to load its
	 * 					own data, false if not.
	 * @return	mixed	A JForm object on success, false on failure.
	 */
	public function getForm($data=array(), $loadData=true)
	{
		$form = $this->loadForm(
			'com_dinning_philosophers.dinning_philosophers',
			'dinning_philosophers',
			array(
				'control'=>'jform',
				'load_data'=>$loadData
			)
		);
		if(empty($form))
		{
			return false;
		}

		return $form;
	}
	/**
	 * Method to get the script that have to be included on the form
	 */
	public function getScript()
	{
		return
		  'administrator/components/com_dinning_philosophers/models/forms/dinning_philosophers.js';
	}
	/**
	 * Method to get the data that should be injected in the form
	 * @return mixed data for form.
	 */
	protected function loadFormData()
	{
	    $data = Factory::getApplication()->getUserState(
			'com_dinning_philosophers.edit.dinning_philosophers.data',
			array()
		);
		if(empty($data))
		{
			$data=$this->getItem();
		}
		return $data;
	}
	/**
	 * Method to override the JModelAdmin save() function to handle save
	 * as Copy correctly.
	 * @param	the dinning_philosophers record data submitted from the form.
	 * @return	parent::save() return value
	 */
	public function save($data)
	{
	    $input = Factory::getApplication()->input;
		JLoader::register('CategoriesHelper', JPATH_ADMINISTRATOR.
			'/components/com_categories/helpers/categories.php');
		// validate id
		if((int)$data['catid']>0)
		{
			$catid = CategoriesHelper::validateCategoryId
				($data['catid'], 'com_dinning_philosophers');
			// If catid and extension don't match, validate will return 0.
			// Let's create a new category to for this component.
			if($catid===0){
			    $category = array();
			    $category['id'] = $data['catid'];
			    
			    $categoryTable = Table::getInstance('Category');
			    if (!$categoryTable->load($category))
			    {
			        $catid = 0;
			    } else {
			        $properties = $categoryTable->getProperties();
			        unset($properties['id']);
			        unset($properties['alias']);
			        array_values($properties);
			        // categories uses extension as an alias to identify
			        // duplicates. Use unique extension.
			        $properties['extension'] = 'com_dinning_philosophers';
			        $catid = CategoriesHelper::createCategory($properties);
			    }
			}
			$data['catid'] = $catid;
		}
		// Alter the alias for save as copy.
		if($input->get('task') == 'save2copy')
		{
			$origTable = clone $this-getTable();
			$origTable->load($input->getInt('id'));
			if($data['alias']==$origTable->alias)
			{
				$data['alias']='';
			}
			$data['published']=0;
		}
		return parent::save($data);
	}
	/**
	 * Method to check if it's OK to delete.
	 */
	protected function canDelete($record)
	{
		if(!empty($record->id))
		{
		    return Factory::getUser()->authorise(
				"core.delete",
				"com_dinning_philosophers.dinning_philosophers.".$record->id
			);
		}
	}
	/**
	 * Method to prepare table. This will add date to new table.
	 */
	protected function prepareTable($table){
        $date = Factory::getDate();
	    if(empty($table->id)){
	        $table->created = $date->toSql();
	    }
	}
}
