<?php 

/**
 * @author Rakesh Mistry
 * Form Array to produce form HTML.
 */

require '../config/config.php';

require CLASS_PATH."pdo.class.php";

require CLASS_PATH."form.class.php";

require CLASS_PATH."image.class.php";

//Login Form - Sign In 
$login_form = [

	'open'=>[

				'type' => 'open', 

				'id'=>'login'

				],

	'username'=>[

				'type' => 'text',

				'label' => 'USERNAME',

				'required' => true
	],

	'userpassword'=>[

				'type' => 'password',

				'label' => 'PASSWORD',

				'required' => true
	],

	'submit'=>[

				'name' => 'login_button',

				'value' => 'LOGIN'
	]

];


//Login Form - Sign Up (Register User)

$register_form = [

	'open'=>[

				'type' => 'open', 

				'id'=>'register'

				],

	'firstname'=>[

				'type' => 'text',

				'label' => 'First Name*',

				'input_message' => '<span></span>',

				'placeholder'=> 'John',

				'validation_message' => '<span class="fail">Sorry only letters accepted</span>',

				'required' => true
	],

	'lastname'=>[

				'type' => 'text',

				'label' => 'Last Name*',

				'input_message' => '<span></span>',

				'placeholder'=> 'Smith',

				'validation_message' => '<span class="fail">Sorry only letters accepted</span>',

				'required' => true
	],

	'email'=>[

				'type' => 'text',

				'label' => 'Email*',

				'input_message' => '<span></span>',

				'placeholder'=> 'user@sportzweekly.com',

				'validation_message' => '<span class="fail">Sorry invalid email</span>',

				'required' => true
	],

	'username'=>[

				'type' => 'text',

				'label' => 'Username*',

				'input_message' => '<span></span>',

				'placeholder'=> 'cricketmad',

				'validation_message' => '<span class="fail">Invalid username (4-10 characters long, lowercase and no spaces)</span>',

				'required' => true
	],



	'userpassword'=>[

				'type' => 'text',

				'label' => 'Password*',

				'input_message' => '<span></span>',

				'placeholder'=> 'between 4-15 in length, no spaces',

				'validation_message' => '<span class="fail">Invalid password (4-15 characters accepted)</span>',

				'required' => true
	],

	'submit'=>[

				'name' => 'register_button',

				'value' => 'REGISTER'
	]

];

//Search Form
$searchform = [

			'open'=>[

				'type' => 'open', 

				'id'=>'search_bar'

				],

			'search'=>[

				'type' => 'search',

				'required' => true,

				'placeholder' => 'NEWS SEARCH',

				'label' =>'SEARCH'
			],

			'submit'=>[

			'name' => 'search_button',

			'value' => 'SUBMIT'
			]

	];

//Article Comment Form
$comment_form = [

			'open'=>[

				'type' => 'open', 

				'id'=>'comment'

				],

			'comment'=>[

				'type' => 'text_area',

				'comment' => 'Add your comment...',

				'form'=>'comment',

				'col'=>20,

				'rows'=>10
			],

			'submit'=>[

				'name' => 'comment_button',

				'value' => 'POST COMMENT'
			]	

		];


//Update User Form
$update_user_form = [

	'open'=>[

				'type' => 'open', 

				'id'=>'update'

				],

	'firstname'=>[

				'type' => 'text',

				'label' => 'First Name*',

				'input_message' => '<span></span>',

				'placeholder'=> 'John',

				'validation_message' => '<span class="fail">Sorry only letters accepted</span>',

				'required' => true
	],

	'lastname'=>[

				'type' => 'text',

				'label' => 'Last Name*',

				'input_message' => '<span></span>',

				'placeholder'=> 'Smith',

				'validation_message' => '<span class="fail">Sorry only letters accepted</span>',

				'required' => true
	],

	'email'=>[

				'type' => 'text',

				'label' => 'Email*',

				'input_message' => '<span></span>',

				'placeholder'=> 'user@sportzweekly.com',

				'validation_message' => '<span class="fail">Invalid email address</span>',

				'required' => true
	],

	'username'=>[

				'type' => 'text',

				'label' => 'Username*',

				'input_message' => '<span></span>',

				'placeholder'=> 'cricketmad',

				'validation_message' => '<span class="fail">Invalid username (4-10 characters long, lowercase and no spaces)</span>',

				'required' => true
	],

	'submit'=>[

				'name' => 'update_button',

				'value' => 'UPDATE PROFILE'
	]

];


//Update User Photo
$update_user_photo = [

	'enctype_open'=>[

		'id'=>'image_upload',

		'type'=>'openEnctype'

	],

	'file_input'=>[

		'input_message'=>'<span class="col3">Must be a .jpg, .png or .gif file (size < 2MB)</span>',

		'type'=>'file_input',

		'label'=>'UPLOAD FILE BELOW:'

	],

	'submit' =>[

		'name'=>'image_upload',

		'value'=>'UPLOAD IMAGE'

	]
];


//Update Article
$article_info = new mypdocrud();

$cat_list = $article_info->get_category($cat_query);

$options_list = $article_info->make_options_list($cat_list);

$update_article_form = [

	'enctype_open'=>[

		'id'=>'update_article',

		'type'=>'openEnctype'

	],

	'file_input'=>[

		'input_message'=>'<span class="col3">Must be a .jpg, .png or .gif file (size < 2MB)</span>',

		'type'=>'file_input',

		'label'=>'Update Article Photo'

	],

	'news_category_id'=>[

				'type' => 'select',

				'label' => 'Sports Category',

				'input_message' => '<span></span>',

				'list_values'=> $options_list,

				'required' => true
	],

	'headline'=>[

				'type' => 'text',

				'label' => 'Headline',

				'input_message' => '<span></span>',

				'placeholder'=> 'Article Headline',

				'validation_message' => '<span class="fail">Sorry only letters accepted</span>',

				'required' => true
	],

	'article_text'=>[

				'type' => 'text_area',

				'form' => 'update_article',

				'label' => 'Article Text',

				'input_message' => '<span></span>',

				'col' => '10',

				'rows' => '10',

				'placeholder'=> ' ',

				'validation_message' => '<span class="fail">Sorry non-acceptable characters in text</span>',

				'required' => true
	],

	'approval_id'=>[

				'type' => 'select',

				'label' => 'Main Article?',

				'input_message' => '<span><span>',

				'list_values'=> [

				'4' => 'YES',

				'3' => 'NO'

				],

				'required' => true
	],

	'submit'=>[

				'name' => 'update_article',

				'value' => 'UPDATE ARTICLE'
	]

];


$submit_article_form = [

	'enctype_open'=>[

		'id'=>'submit_article',

		'type'=>'openEnctype'

	],

	'file_input'=>[

		'input_message'=>'<span class="col3">Must be a .jpg, .png or .gif file (size < 2MB)</span>',

		'type'=>'file_input',

		'label'=>'UPLOAD ARTICLE PHOTO BELOW'

	],

	'news_category_id'=>[

				'type' => 'select',

				'label' => 'Sports Category',

				'input_message' => '<span></span>',

				'list_values'=> $options_list,

				'required' => true
	],

	'headline'=>[

				'type' => 'text',

				'label' => 'Headline',

				'input_message' => '<span></span>',

				'placeholder'=> 'Article Headline',

				'validation_message' => '<span class="fail">Sorry only letters accepted</span>',

				'required' => true
	],

	'article_text'=>[

				'type' => 'text_area',

				'form' => 'submit_article',

				'label' => 'Article Text',

				'input_message' => '<span></span>',

				'col' => '10',

				'rows' => '10',

				'placeholder'=> ' ',

				'validation_message' => '<span class="fail">Sorry non-acceptable characters in text</span>',

				'required' => true
	],

	'approval_id'=>[

				'type' => 'select',

				'label' => 'Main Article?',

				'input_message' => '<span></span>',

				'list_values'=> [

				'4' => 'YES',

				'3' => 'NO'

				],

				'required' => true
	],

	'submit'=>[

				'name' => 'submit_article',

				'value' => 'SUBMIT ARTICLE'
	]

];

//**********************************************************//
	//Security Class Config - Validation tests
		//note: validation and fieldnames need to match (name & field rows)
//**********************************************************//

//Loginform.php Registration Form - Registration Validation Regexp

$registerValidation = array(

	'firstname' => array(

    				'filter' => FILTER_VALIDATE_REGEXP,

    				'options' => array(

    					"regexp" => "/^([A-Za-z ]+$)/"

    					)
    				),

	'lastname' => array(

    				'filter' => FILTER_VALIDATE_REGEXP,

    				'options' => array(

    					"regexp" => "/^([A-Za-z ]+$)/"

    					)
    				),

	'email' => FILTER_VALIDATE_EMAIL,


	'username' => array(

    				'filter' => FILTER_VALIDATE_REGEXP,

    				'options' => array(

    					"regexp" => "/^([a-z0-9_-]{4,15})/"

    					)
    				),

	'userpassword' => array(

    				'filter' => FILTER_VALIDATE_REGEXP,

    				'options' => array(

    					"regexp" => "/^([a-zA-Z0-9@*#]{4,15})/"

    					)
    				),

		);

//End of Login Form - Registration Validation Regexp

/**********************************************************/

//editprofile.php Update userinfo Form - Validation Regexp

$updateValidation = array(

	'firstname' => array(

    				'filter' => FILTER_VALIDATE_REGEXP,

    				'options' => array(

    					"regexp" => "/^([A-Za-z ]+$)/"

    					)
    				),

	'lastname' => array(

    				'filter' => FILTER_VALIDATE_REGEXP,

    				'options' => array(

    					"regexp" => "/^([A-Za-z ]+$)/"

    					)
    				),

	'email' => FILTER_VALIDATE_EMAIL,


	'username' => array(

    				'filter' => FILTER_VALIDATE_REGEXP,

    				'options' => array(

    					"regexp" => "/^([a-z0-9_-]{4,15})/"

    					)
    				),

	);
//End of Update userinfo Form - Validation Regexp






 ?>