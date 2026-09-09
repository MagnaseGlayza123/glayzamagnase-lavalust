<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
|  Config Files
| -------------------------------------------------------------------
| This file is for setting-up default settings.
|
*/

/*
| -------------------------------------------------------------------
|  Your Own Configs
| -------------------------------------------------------------------
| For easy access on your config, just put them below
| You can simply get configs using config_item() function anywhere
| My Configs:
*/

/*
| -------------------------------------------------------------------
| LavaLust Version
| -------------------------------------------------------------------
*/
$config['version']                 = '4.6.0';

/*
| -------------------------------------------------------------------
| Default Environment
| -------------------------------------------------------------------
| Values: development and production
*/
$config['environment'] = getenv('APP_ENV') ?: 'development';

error_reporting(E_ALL);
ini_set('display_errors', '1');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your LavaLust root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| WARNING: You MUST set this value!
|
*/
$config['base_url'] 				= '';

/*
|--------------------------------------------------------------------------
| Static File Proxies
|--------------------------------------------------------------------------
|
| Enable Static Proxies / Facades
|
*/
$config['proxy_enabled']           = FALSE;

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| If you are using mod_rewrite to remove index.php in the URL set this
| variable to blank.
|
*/
$config['index_page']               = 'index.php';

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| You can enable error logging by setting a threshold over zero.
|
|	0 = Disables logging
|	1 = Exception and Error Messages
|   2 = Debug
|   3 = All
|
*/
$config['log_threshold']            = 0;
$config['log_dir']                  = 'runtime/logs/';

/*
|--------------------------------------------------------------------------
| Composer auto-loading
|--------------------------------------------------------------------------
|
| Enabling this setting will tell LavaLust to look for a Composer
| package auto-loader script in vendor/autoload.php.
|
|	$config['composer_autoload'] = TRUE;
|
| Or if you have your vendor/ directory located somewhere else, you
| can opt to set a specific path as well:
|
|	$config['composer_autoload'] = '/path/to/vendor/autoload.php';
|
| For more information about Composer, please visit http://getcomposer.org/
|
| Note: This will NOT disable or override the LavaLust-specific
|	autoloader (app/config/autoload.php)
*/
$config['composer_autoload']        = FALSE;

/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
|
| This lets you specify which characters are permitted within your URLs.
|
*/
$config['permitted_uri_chars']		= 'a-z 0-9~%.:_\-';

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
*/
$config['charset']					= 'UTF-8';

/*
|--------------------------------------------------------------------------
| Error Views Directory Path
|--------------------------------------------------------------------------
|
*/
$config['error_view_path']         	= '';

/*
|--------------------------------------------------------------------------
| 404 Error Overide
|--------------------------------------------------------------------------
|
*/
$config['404_override']       	    = '';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
*/
$config['language'] 				= 'en-US';

/*
|--------------------------------------------------------------------------
| Sub-class Prefix
|--------------------------------------------------------------------------
|
*/
$config['subclass_prefix']          = 'MY_';

/*
|--------------------------------------------------------------------------
| Session
|--------------------------------------------------------------------------
|
*/
$config['sess_driver']             = 'file';
$config['sess_table']              = 'sessions';
$config['sess_cookie_name']        = 'LLSession';
$config['sess_expiration']         = 7200;
$config['sess_save_path']          = '';
$config['sess_match_ip']           = FALSE;
$config['sess_match_fingerprint']  = FALSE;
$config['sess_time_to_update']     = 300;
$config['sess_regenerate_destroy'] = FALSE;
$config['sess_expire_on_close']    = FALSE;
$config['max_invalid_attempts']    = 5;
$config['invalid_window']          = 600;
$config['lock_duration_invalid']   = 900;
$config['max_session_creations']   = 10;
$config['creation_window']         = 60;
$config['lock_duration_creation']  = 120;
$config['security_file']           = ROOT_DIR . 'runtime/session/session_security.json';
$config['sess_inactivity_timeout'] = 1800;
$config['session_hmac_secret']     = getenv('APP_KEY') ?: '';

/*
|--------------------------------------------------------------------------
| Cookies
|--------------------------------------------------------------------------
|
*/
$config['cookie_prefix']           = '';
$config['cookie_domain']           = '';
$config['cookie_path']             = '/';
$config['cookie_secure']           = FALSE;
$config['cookie_expiration']       = 86400;
$config['cookie_httponly']         = FALSE;
$config['cookie_samesite']         = 'Strict';

/*
|--------------------------------------------------------------------------
| Cache
|--------------------------------------------------------------------------
|
*/
$config['cache_driver']            = 'php';
$config['cache_dir']               = ROOT_DIR . 'runtime/cache/';
$config['cache_default_expires']   = 0;
$config['lock_lock_timeout']       = 5;
$config['lock_lock_sleep']         = 100000;
$config['cache_default_expires']   = 0;

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
*/
$config['encryption_key']           = getenv('APP_KEY') ?: '';

/*
|--------------------------------------------------------------------------
| Soft Delete
|--------------------------------------------------------------------------
|
*/
$config['soft_delete']              = FALSE;
$config['soft_delete_column']       = 'deleted_at';

/*
|--------------------------------------------------------------------------
| Created At and Updated At Column
|--------------------------------------------------------------------------
|
*/
$config['timestamps']               = FALSE;
$config['created_at_column']        = 'created_at';
$config['updated_at_column']        = 'updated_at';

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
|
*/
$config['csrf_protection']         = FALSE;
$config['csrf_exclude_uris']       = array();
$config['csrf_token_name']         = 'csrf_test_name';
$config['csrf_cookie_name']        = 'csrf_cookie_name';
$config['csrf_expire']             = 7200;
$config['csrf_regenerate']         = FALSE;

require_once APP_DIR . 'middlewares/StudentMiddleware.php';
require_once APP_DIR . 'middlewares/AuthMiddleware.php';

$config['middlewares'] = [
    'student' => new StudentMiddleware(),
    'auth' => new AuthMiddleware()
];

?>