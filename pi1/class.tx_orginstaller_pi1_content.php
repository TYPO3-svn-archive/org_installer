<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2013 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   61: class tx_orginstaller_pi1_content
 *
 *              SECTION: Main
 *   85:     public function main( )
 *
 *              SECTION: Records
 *  115:     private function pageOrgCaddy( $uid )
 *  145:     private function pageOrgCaddyDelivery( $uid )
 *  175:     private function pageOrgLibraryFooter( $uid )
 *  206:     private function pageOrgLibraryHeader( $uid )
 *  242:     private function pageOrgLegalinfo( $uid )
 *  272:     private function pageOrgCaddyRevocation( $uid )
 *  302:     private function pageOrgCaddyTerms( $uid )
 *  331:     private function pages( )
 *
 *              SECTION: Sql
 *  389:     private function sqlInsert( $records )
 *
 * TOTAL FUNCTIONS: 10
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Plugin 'Organiser Installer' for the 'org_installer' extension.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    tx_orginstaller
 * @version 3.0.0
 * @since 3.0.0
 */
class tx_orginstaller_pi1_content
{
  public $prefixId      = 'tx_orginstaller_pi1_content';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_orginstaller_pi1_content.php';  // Path to this script relative to the extension dir.
  public $extKey        = 'org_installer';                      // The extension key.

  public $pObj = null;



 /***********************************************
  *
  * Main
  *
  **********************************************/

/**
 * main( )
 *
 * @return	void
 * @access public
 * @version 3.0.0
 * @since   0.0.1
 */
  public function main( )
  {
    $records = array( );

    $this->pObj->arrReport[ ] = '
      <h2>
       ' . $this->pObj->pi_getLL( 'content_create_header' ) . '
      </h2>';

    $records = $this->page( );
    $this->sqlInsert( $records );
  }



 /***********************************************
  *
  * Records
  *
  **********************************************/

/**
 * page( )
 *
 * @return	array		$records : the plugin records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function page( )
  {
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( 'tt_content' );

      // content for page delivery
    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgCaddy( $uid );

      // content for page delivery
    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgCaddyDelivery( $uid );

      // content for page revocation
    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgCaddyRevocation( $uid );

      // content for page terms
    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgCaddyTerms( $uid );

    if( $this->pObj->markerArray['###INSTALL_CASE###'] != 'install_all')
    {
      return $records;
    }

      // content for page legal
    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgLegalinfo( $uid );

      // content for page library header
    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgLibraryHeader( $uid );

      // content for page library footer
    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgLibraryFooter( $uid );

    return $records;
  }

/**
 * pageOrgCaddy( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.4
 * @since   3.0.4
 */
  private function pageOrgCaddy( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_pageOrgCaddy_header' );
    $this->pObj->arr_contentUids['content_pageOrgCaddy_header'] = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgCaddy_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 2;
    $record['CType']        = 'html';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_pageOrgCaddy_bodytext');
    $record['sectionIndex'] = 0;

    return $record;
  }

/**
 * pageOrgCaddyDelivery( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageOrgCaddyDelivery( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_pageOrgCaddyDelivery_header' );
    $this->pObj->arr_contentUids['content_pageOrgCaddyDelivery_header'] = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgCaddyDelivery_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'text';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_pageOrgCaddyDelivery_bodytext');
    $record['sectionIndex'] = 1;

    return $record;
  }

/**
 * pageOrgCaddyRevocation( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageOrgCaddyRevocation( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_pageOrgCaddyRevocation_header' );
    $this->pObj->arr_contentUids['content_pageOrgCaddyRevocation_header']  = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgCaddyRevocation_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'text';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_pageOrgCaddyRevocation_bodytext');
    $record['sectionIndex'] = 1;

    return $record;
  }

/**
 * pageOrgCaddyTerms( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageOrgCaddyTerms( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_pageOrgCaddyTerms_header' );
    $this->pObj->arr_contentUids['content_pageOrgCaddyTerms_header']  = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgCaddyTerms_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'text';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_pageOrgCaddyTerms_bodytext');
    $record['sectionIndex'] = 1;

    return $record;
  }

/**
 * pageOrgLegalinfo( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageOrgLegalinfo( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_pageOrgLegalinfo_header' );
    $this->pObj->arr_contentUids['content_pageOrgLegalinfo_header']  = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgLegalinfo_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']      = 256 * 1;
    $record['CType']        = 'text';
    $record['header']       = $llHeader;
    $record['bodytext']     = $this->pObj->pi_getLL('content_pageOrgLegalinfo_bodytext');
    $record['sectionIndex'] = 1;

    return $record;
  }

/**
 * pageOrgLibraryFooter( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageOrgLibraryFooter( $uid )
  {
    $record = null;

    $llHeader = $this->pObj->pi_getLL( 'content_pageOrgLibraryFooter_header' );
    $this->pObj->arr_contentUids['content_pageOrgLibraryFooter_header']  = $uid;

    $record['uid']            = $uid;
    $record['pid']            = $this->pObj->arr_pageUids[ 'pageOrgLibraryFooter_title' ];
    $record['tstamp']         = time( );
    $record['crdate']         = time( );
    $record['cruser_id']      = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']        = 256 * 1;
    $record['CType']          = 'text';
    $record['header']         = $llHeader;
    $record['header_layout']  = 100; // hidden
    $record['bodytext']       = $this->pObj->pi_getLL('content_pageOrgLibraryFooter_bodytext');
    $record['sectionIndex']   = 1;

    return $record;
  }

/**
 * pageOrgLibraryHeader( )
 *
 * @param	integer		$uid: uid of the current plugin
 * @return	array		$record : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function pageOrgLibraryHeader( $uid )
  {
    $record = null;

      // Content for page header
    $pid      = $GLOBALS['TSFE']->id;
    $bodytext = $this->pObj->pi_getLL('content_pageOrgLibraryHeader_bodytext');
    $bodytext = str_replace('###PID###', $pid, $bodytext);

    $llHeader = $this->pObj->pi_getLL( 'content_pageOrgLibraryHeader_header' );
    $this->pObj->arr_contentUids['content_pageOrgLibraryHeader_header']  = $uid;

    $record['uid']            = $uid;
    $record['pid']            = $this->pObj->arr_pageUids[ 'pageOrgLibraryHeader_title' ];
    $record['tstamp']         = time( );
    $record['crdate']         = time( );
    $record['cruser_id']      = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']        = 256 * 1;
    $record['CType']          = 'text';
    $record['header']         = $llHeader;
    $record['header_layout']  = 100; // hidden
    $record['bodytext']       = $bodytext;
    $record['sectionIndex']   = 1;

    return $record;
  }



 /***********************************************
  *
  * Sql
  *
  **********************************************/

/**
 * sqlInsert( )
 *
 * @param	array		$records : TypoScript records for pages
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function sqlInsert( $records )
  {
    foreach( $records as $record )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery( 'tt_content', $record ) );
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'tt_content', $record );
      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->INSERTquery( 'tt_content', $record );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                  'query: ' . $query . '.<br />' . PHP_EOL .
                  'error: ' . $error . '.<br />' . PHP_EOL .
                  'Sorry for the trouble.<br />' . PHP_EOL .
                  'TYPO3-Organiser Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }

        // prompt
      $pageTitle = $this->pObj->arr_pageTitles[$record['pid']];
      $pageTitle = $this->pObj->pi_getLL( $pageTitle );
      $marker['###HEADER###']     = $record['header'];
      $marker['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $record['pid'] . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'content_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[ ] = $prompt;
        // prompt
    }
  }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_content.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_content.php']);
}