<?php
/**
 * GetSimple API Handler
 *
 * @package GetSimple
 * @subpackage API
 */
	include('inc/common.php');
	include('inc/api.class.php');

	#step 1 - check for post
	if (empty($_POST)) exit;
	if (!getDef('GSEXTAPI',true)) exit;

	// disable libxml error output
	libxml_use_internal_errors(true);

	// disable entity loading to avoid xxe
	if (PHP_VERSION_ID < 80000) libxml_disable_entity_loader(true);

	#step 1 - check post for data
	if (!isset($_POST['data']) || !is_string($_POST['data'])) {
		$message = ['status' => 'error', 'message' => i18n_r('API_ERR_MISSINGPARAM')];
		echo json_encode($message);
		exit;
	};

	#step 2 - setup request
	$in = simplexml_load_string($_POST['data'], 'SimpleXMLExtended', LIBXML_NOCDATA);

	if ($in === false || !isset($in->method)) {
		$message = ['status' => 'error', 'message' => i18n_r('API_ERR_MISSINGPARAM')];
		echo json_encode($message);
		exit;
	}

	$request = new API_Request();
	$request->add_data($in);

	#step 3 - verify a compatible method was provided
	$method = (string)$in->method;
	$methods = ['page_read', 'page_save', 'all_pages_read', 'all_files_read', 'file_upload', 'settings_read'];
	if (!in_array($method, $methods, true)) {
		$message = ['status' => 'error', 'message' => sprintf(i18n_r('API_ERR_BADMETHOD'), $method)];
		echo json_encode($message);
		exit;
	}

	#step 4 - process request
	echo call_user_func([$request, $method], '');

exit;

/*
----------------------------
EXAMPLE XML FILE COMING IN
----------------------------

<request>
	<key>ABCDE12345</key>
	<method>page_read</method>
	<data>
		<field1></field1>
		<field2></field2>
		<field3></field3>
	</data>
</request>

*/
