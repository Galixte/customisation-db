<?php
/**
*
* @package Titania
* @copyright (c) 2014 phpBB Limited
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2
*
*/

/**
* @ignore
*/
if (!defined('IN_TITANIA'))
{
	exit;
}

if (!class_exists('titania_type_base'))
{
	include(TITANIA_ROOT . 'includes/types/base.' . PHP_EXT);
}

define('TITANIA_TYPE_EXTENSION', 8);

class titania_type_extension extends titania_type_base
{
	/**
	 * The type id
	 *
	 * @var int type id (for custom types not specified in titania to start, please start with 10 in case we add any extra later)
	 */
	public $id = 8;

	/**
	 * The type name
	 *
	 * @var string (any lang key that includes the type should match this value)
	 */
	public $name = 'extension';

	/**
	 * For the url slug
	 *
	 * @var string portion to be used in the URL slug
	 */
	public $url = 'extension';

	// Validation messages (for the PM)
	public $validation_subject = 'EXTENSION_VALIDATION';
	public $validation_message_approve = 'EXTENSION_VALIDATION_MESSAGE_APPROVE';
	public $validation_message_deny = 'EXTENSION_VALIDATION_MESSAGE_DENY';
	public $create_public = 'EXTENSION_CREATE_PUBLIC';
	public $reply_public = 'EXTENSION_REPLY_PUBLIC';
	public $update_public = 'EXTENSION_UPDATE_PUBLIC';
	public $upload_agreement = 'EXTENSION_UPLOAD_AGREEMENT';

	public function __construct()
	{
		$this->lang = phpbb::$user->lang['EXTENSION'];
		$this->langs = phpbb::$user->lang['EXTENSIONS'];
		$this->forum_database = titania::$config->forum_extension_database;
		$this->forum_robot = titania::$config->forum_extension_robot;
	}

	/**
	* Check auth level
	*
	* @param string $auth ('view', 'test', 'validate')
	* @return bool
	*/
	public function acl_get($auth)
	{
		switch ($auth)
		{
			// Can submit a mod
			case 'submit' :
				return true;
			break;

			// Can view the mod queue discussion
			case 'queue_discussion' :
				return phpbb::$auth->acl_get('u_titania_mod_extension_queue_discussion');
			break;

			// Can view the extensions queue
			case 'view' :
				return phpbb::$auth->acl_get('u_titania_mod_extension_queue');
			break;

			// Can validate extensions in the queue
			case 'validate' :
				return phpbb::$auth->acl_get('u_titania_mod_extension_validate');
			break;

			// Can moderate extensions
			case 'moderate' :
				return phpbb::$auth->acl_gets(array('u_titania_mod_extension_moderate', 'u_titania_mod_contrib_mod'));
			break;
		}

		return false;
	}
}