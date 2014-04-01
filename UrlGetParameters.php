<?php
/**
 * UrlGetParameters - An extension that allows to use and/or display the "GET" parameters
 * of the URL on a wiki page
 *
 * @link https://www.mediawiki.org/wiki/Extension:UrlGetParameters Documentation
 *
 * @file UrlGetParameters.php
 * @defgroup UrlGetParameters
 * @ingroup Extensions
 * @package MediaWiki
 * @author S.O.E. Ansems
 * @author Ankit Garg
 * @author Yaron Koren
 * @copyright (C) 2008 S.O.E. Ansems
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This file is not a valid entry point.";
    exit( 1 );
}

$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'UrlGetParameters',
	'version'        => '1.4.0',
	'descriptionmsg' => 'urlgetparameters-desc',
	'author'         => 'S.O.E. Ansems',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:UrlGetParameters',
);

$dir = dirname( __FILE__ );
$wgMessagesDirs['UrlGetParameters'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['UrlGetParameters'] = $dir . '/UrlGetParameters.i18n.php';
$wgExtensionMessagesFiles['UrlGetParametersMagic'] = $dir . '/UrlGetParameters.i18n.magic.php';

$wgHooks['ParserFirstCallInit'][] = 'urlGetParameters_Setup';

$wgUrlGetParametersSeparator = ",";

/**
 * @param $parser Parser
 * @return void
 */
function urlGetParameters_Setup( $parser ) {
	$parser->setFunctionHook( 'urlget', 'urlGetParameters_Render' );
	return true;
}

/**
 * @param $parser Parser
 * @return string
 */
function urlGetParameters_Render( $parser ) {
	global $wgUrlGetParametersSeparator;

	// {{#urlget:paramname|defaultvalue}}

	// Get the parameters that were passed to this function
	$params = func_get_args();
	array_shift( $params );

	// Cache needs to be disabled for URL parameters to be retrieved correctly
	$parser->disableCache();

	// Check whether this param is an array, i.e. of the form "a[b]"
	$pos_left_bracket = strpos( $params[0], '[' );
	$pos_right_bracket = strpos( $params[0], ']' );

	if ( !$pos_left_bracket || !$pos_right_bracket ) {

		if ( isset($_GET[$params[0]] ) ) {
			// Allow array
			if ( is_array( $_GET[$params[0]] ) ) {
				$listval = array();
				foreach ($_GET[$params[0]] as $selectedOption) {
				   	array_push( $listval, rawurlencode( $selectedOption ) );
				}
				return implode($wgUrlGetParametersSeparator, $listval);
			} else {
				return rawurlencode( $_GET[$params[0]] );
			}
		}
	} else {
		// It's an array
		$key = substr( $params[0], 0, $pos_left_bracket );
		$value = substr($params[0], $pos_left_bracket + 1, ( $pos_right_bracket - $pos_left_bracket - 1 ) );

		if ( isset( $_GET[$key] ) && isset( $_GET[$key][$value] ) ) {
			return rawurlencode( $_GET[$key][$value] );
		}
	}
	if ( count( $params ) > 1 ) {
		return rawurlencode( $params[1] );
	}

	return '';
}
