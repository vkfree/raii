<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Swagger Definitions
|--------------------------------------------------------------------------
| Example: https://github.com/zircote/swagger-php/tree/master/Examples/petstore.swagger.io/models
*/

// To avoid class naming conflicts when defining Swagger Definitions
namespace MySwaggerDefinitions;

/**
 * @SWG\Definition()
 */
class v1 {

	/**
	 * Unique ID
	 * @var int
	 * @SWG\Property()
	 */
	public $id;

	/**
	 * @var string
	 * @SWG\Property()
	 */
	public $name;
}

/**
 * @SWG\Definition()
 */
class v1SignUp {
	
	/**
	 * @var string
	 * @SWG\Property()
	 */
	public $email;

	/**
	 * @var string
	 * @SWG\Property()
	 */
	public $password;

	/**
	 * @var string
	 * @SWG\Property()
	 */
	public $first_name;

	/**
	 * @var string
	 * @SWG\Property()
	 */
	public $last_name;

	/**
	 * @var int
	 * @SWG\Property()
	 */
	public $mobile;

	/**
	 * @var int
	 * @SWG\Property()
	 */
	public $group;


}


/**
 * @SWG\Definition()
 */
class v1Login {

	/**
	 * @var string
	 * @SWG\Property()
	 */
	public $email;

	/**
	 * @var string
	 * @SWG\Property()
	 */
	public $password;
}

/**
 * @SWG\Definition()
 */
class v1UpdateUserInfo {

	
	/**
	 * @var int
	 * @SWG\Property()
	 */
	public $mobile;
	/**
	 * @var string
	 * @SWG\Property()
	 */
	public $first_name;

	/**
	 * @var string
	 * @SWG\Property()
	 */
	public $last_name;

}

/**
 * @SWG\Definition()
 */
class v1Home {

	
	/**
	 * @var string
	 * @SWG\Property()
	 */
	public $category;

}

/**
 * @SWG\Definition()
 */
class v1Vendor {

	
	/**
	 * @var string
	 * @SWG\Property()
	 */
	public $category;

	/**
	 * @var string
	 * @SWG\Property()
	 */
	public $vendor;

}