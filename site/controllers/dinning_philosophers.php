<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Helper\MediaHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Log\Log;
use \Joomla\CMS\MVC\Controller\FormController;
use \Joomla\CMS\Session\Session;
use \Joomla\CMS\Uri\Uri;
use \Joomla\CMS\User\User;

/**
 * Dinning_philosophers Controller
 *
 * @package     Joomla.Site
 * @subpackage  com_dinning_philosophers
 * 
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 *
 * Used to handle the http POST from the front-end form which allows 
 * users to enter a new dinning_philosophers message
 *
 */
class Dinning_philosophersControllerDinning_philosophers extends FormController
{   
    public function cancel($key = null)
    {
        parent::cancel($key);
        
        // set up the redirect back to the same form
        $this->setRedirect(
            (string)Uri::getInstance(), 
            Text::_(COM_DINNING_PHILOSOPHERS_ADD_CANCELLED)
		);
    }
    
    /*
     * Function handing the save for adding a new dinning_philosophers record
     * Based on the save() function in the JControllerForm class
     */
    public function save($key = null, $urlVar = null)
    {
		// Check for request forgeries.
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
        
		$app = Factory::getApplication(); 
		$input = $app->input; 
		$model = $this->getModel('form');
        
		// Get the current URI to set in redirects. As we're handling a POST, 
		// this URI comes from the <form action="..."> attribute in the layout file above
		$currentUri = (string)Uri::getInstance();

		// Check that this user is allowed to add a new record
		if (!Factory::getUser()->authorise( "core.create", "com_dinning_philosophers"))
		{
			$app->enqueueMessage(Text::_('JERROR_ALERTNOAUTHOR'), 'error');
			$app->setHeader('status', 403, true);

			return;
		}
        
		// get the data from the HTTP POST request
		$data  = $input->get('jform', array(), 'array');
        
		// set up context for saving form data
		$context = "$this->option.edit.$this->context";
        
		// save the form data and set up the redirect back to the same form, 
		// to avoid repeating them under every error condition
		$app->setUserState($context . '.data', $data);
		$this->setRedirect($currentUri);

		// Validate the posted data.
		// First we need to set up an instance of the form ...
		$form = $model->getForm($data, false);

		if (!$form)
		{
			$app->enqueueMessage($model->getError(), 'error');
			return false;
		}

		// ... and then we validate the data against it
		// The validate function called below results in the running of the validate="..." routines
		// specified against the fields in the form xml file, and also filters the data 
		// according to the filter="..." specified in the same place (removing html tags by default in strings)
		$validData = $model->validate($form, $data);

		// Handle the case where there are validation errors
		if ($validData === false)
		{
			// Get the validation messages.
			$errors = $model->getErrors();

			// Display up to three validation messages to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			return false;
		}

		// Handle the uploaded file - get it from the PHP $_FILES structure
		$fileinfo = $this->input->files->get('jform', array(), 'array');
		$file = $fileinfo['imageinfo']['image'];
		/* The $file variable above should contain an array of 5 elements as follows:
		 *   name: the name of the file (on the system from which it was uploaded), without directory info
		 *   type: should be something like image/jpeg
		 *   tmp_name: pathname of the file where PHP has stored the uploaded data 
		 *   error: 0 if no error
		 *   size: size of the file in bytes
		 */
        
		// Check if any files have been uploaded
		if ($file['error'] == 4)   // no file uploaded (see PHP file upload error conditions)
		{
			$validData['imageinfo'] = null;
		} 
		else 
		{
			if ($file['error'] > 0)
			{
				$app->enqueueMessage(Text::sprintf('COM_DINNING_PHILOSOPHERS_ERROR_FILEUPLOAD', $file['error']), 'warning');
				return false;
			}
            
			// make sure filename is clean
			jimport('joomla.filesystem.file');
			$file['name'] = JFile::makeSafe($file['name']);
			if (!isset($file['name']))
			{
				// No filename (after the name was cleaned by JFile::makeSafe)
				$app->enqueueMessage(Text::_('COM_DINNING_PHILOSOPHERS_ERROR_BADFILENAME'), 'warning');
				return false;
			}

			// files from Microsoft Windows can have spaces in the filenames
			$file['name'] = str_replace(' ', '-', $file['name']);

			// do checks against Media configuration parameters
			$mediaHelper = new MediaHelper;
			if (!$mediaHelper->canUpload($file))
			{
				// The file can't be uploaded - the helper class will have enqueued the error message
				return false;
			}
            
			// prepare the uploaded file's destination pathnames
			$mediaparams = ComponentHelper::getParams('com_media');
			$relativePathname = JPath::clean($mediaparams->get($path, 'images') . '/' . $file['name']);
			$absolutePathname = JPATH_ROOT . '/' . $relativePathname;
			if (JFile::exists($absolutePathname))
			{
				// A file with this name already exists
				$app->enqueueMessage(Text::_('COM_DINNING_PHILOSOPHERS_ERROR_FILE_EXISTS'), 'warning');
				return false;
			}
            
			// check file contents are clean, and copy it to destination pathname
			if (!JFile::upload($file['tmp_name'], $absolutePathname))
			{
				// Error in upload
				$app->enqueueMessage(Text::_('COM_DINNING_PHILOSOPHERS_ERROR_UNABLE_TO_UPLOAD_FILE'));
				return false;
			}
            
			// Upload succeeded, so update the relative filename for storing in database
			$validData['imageinfo']['image'] = $relativePathname;
		}
        
		// add the 'created by' and 'created' date fields
		$validData['created_by'] = Factory::getUser()->get('id', 0);
		$validData['created'] = date('Y-m-d h:i:s');
        
		// Attempt to save the data.
		if (!$model->save($validData))
		{
			// Handle the case where the save failed
			$this->setError(Text::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');

			return false;
		}
        
		// clear the data in the form
		$app->setUserState($context . '.data', null);
        
		// notify the administrator that a new dinning_philosophers message has been added on the front end
        
		// get the id of the person to notify from global config
		$params   = $app->getParams();
		$userid_to_email = (int) $params->get('user_to_email');
		$user_to_email = User::getInstance($userid_to_email);
		$to_address = $user_to_email->get("email");
        
		// get the current user (if any)
		$current_user = Factory::getUser();
		if ($current_user->get("id") > 0) 
		{
			$current_username = $current_user->get("username");
		}
		else 
		{
			$current_username = "a visitor to the site";
		}
        
		// get the Mailer object, set up the email to be sent, and send it
		$mailer = Factory::getMailer();
		$mailer->addRecipient($to_address);
		$mailer->setSubject("New dinning_philosophers message added by " . $current_username);
		$mailer->setBody("New greeting is " . $validData['greeting']);
		try 
		{
			$mailer->send(); 
		}
		catch (Exception $e)
		{
			Log::add('Caught exception: ' . $e->getMessage(), Log::Error, 'jerror');
		}
        
		$this->setRedirect(
				$currentUri,
				Text::_('COM_DINNING_PHILOSOPHERS_ADD_SUCCESSFUL')
				);
            
		return true;
        
    }

}
