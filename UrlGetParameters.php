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
 * @license GPL-2.0-or-later
 */

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'UrlGetParameters' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['UrlGetParameters'] = __DIR__ . '/i18n';
	$wgExtensionMessagesFiles['UrlGetParameters'] = __DIR__ . '/UrlGetParameters.i18n.magic.php';
	wfWarn(
		'Deprecated PHP entry point used for the UrlGetParametersMagic extension. ' .
		'Please use wfLoadExtension() instead, ' .
		'see https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the UrlGetParameters extension requires MediaWiki 1.35+' );
}
