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
 *   84: class tx_orginstaller_pi1_org
 *
 *              SECTION: Main
 *  108:     public function main( )
 *
 *              SECTION: Categories
 *  138:     private function category( )
 *  179:     private function categoryBlue( $uid )
 *  207:     private function categoryBook( $uid )
 *  234:     private function categoryClothes( $uid )
 *  261:     private function categoryCup( $uid )
 *  288:     private function categoryGreen( $uid )
 *  316:     private function categoryRed( $uid )
 *
 *              SECTION: Records
 *  352:     private function recordBasecapBlue( $uid )
 *  400:     private function recordBasecapGreen( $uid )
 *  448:     private function recordBasecapRed( $uid )
 *  496:     private function recordBook( $uid )
 *  546:     private function recordCup( $uid )
 *  596:     private function recordPullover( $uid )
 *  643:     private function records( )
 *
 *              SECTION: Relations
 *  692:     private function relationBasecapBlueBlue( $sorting )
 *  712:     private function relationBasecapBlueClothes( $sorting )
 *  732:     private function relationBasecapGreenClothes( $sorting )
 *  752:     private function relationBasecapGreenGreen( $sorting )
 *  772:     private function relationBasecapRedClothes( $sorting )
 *  792:     private function relationBasecapRedRed( $sorting )
 *  812:     private function relationBook( $sorting )
 *  832:     private function relationCup( $sorting )
 *  852:     private function relationPullover( $sorting )
 *  871:     private function relations( )
 *
 *              SECTION: Sql
 *  927:     private function sqlInsert( $records, $table )
 *
 *              SECTION: ZZ
 *  987:     private function zz_counter( $uid )
 *
 * TOTAL FUNCTIONS: 27
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
class tx_orginstaller_pi1_org
{
  public $prefixId      = 'tx_orginstaller_pi1_org';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_orginstaller_pi1_org.php';  // Path to this script relative to the extension dir.
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
    $this->category( );
    $this->record( );
//    $this->sqlInsert( $records, 'tx_org_cal' );
//
//    $records = $this->relations( );
//    $this->sqlInsert( $records, 'tx_org_cal_category_mm' );
  }



 /***********************************************
  *
  * Categories
  *
  **********************************************/

/**
 * category( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function category( )
  {
    $this->categoryCal( );
    $this->categoryDepartment( );
    $this->categoryDownloads( );
    $this->categoryNews( );
  }


/**
 * categoryCal( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCal( )
  {
    $this->categoryCalEntrance( );
    $this->categoryCalTax( );
    $this->categoryCalType( );
  }

/**
 * categoryCalEntrance( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCalEntrance( )
  {
    $table    = 'tx_org_calentrance';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

      // category policy
    $uid = $uid + 1;
    $records[$uid] = $this->categoryCalEntranceFree( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryCalEntranceMortals( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryCalEntranceSponsors( $uid );


    $this->sqlInsert( $records, $table );
  }
  
/**
 * categoryCalEntranceFree( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCalEntranceFree( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_calentrance_title_entranceFree';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel = 'record_tx_org_calentrance_value_entranceFree';
    $llValue = $this->pObj->pi_getLL( $llLabel );

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['value']      = $llValue;

    return $record;
  }
  
/**
 * categoryCalEntranceMortals( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCalEntranceMortals( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_calentrance_title_mereMortals';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel = 'record_tx_org_calentrance_value_mereMortals';
    $llValue = $this->pObj->pi_getLL( $llLabel );

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['value']      = $llValue;

    return $record;
  }
  
/**
 * categoryCalEntranceSponsors( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCalEntranceSponsors( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_calentrance_title_sponsor';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel = 'record_tx_org_calentrance_value_sponsor';
    $llValue = $this->pObj->pi_getLL( $llLabel );

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['value']      = $llValue;

    return $record;
  }
  

/**
 * categoryCalTax( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCalTax( )
  {
    $table    = 'tx_org_tax';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

      // category policy
    $uid = $uid + 1;
    $records[$uid] = $this->categoryCalTax000( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryCalTax007( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryCalTax019( $uid );


    $this->sqlInsert( $records, $table );
  }
   
/**
 * categoryCalTax000( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCalTax000( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_tax_title_000';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel = 'record_tx_org_tax_value_000';
    $llValue = $this->pObj->pi_getLL( $llLabel );

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['value']      = $llValue;

    return $record;
  }
   
/**
 * categoryCalTax007( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCalTax007( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_tax_title_007';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel = 'record_tx_org_tax_value_007';
    $llValue = $this->pObj->pi_getLL( $llLabel );

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['value']      = $llValue;

    return $record;
  }
   
/**
 * categoryCalTax019( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCalTax019( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_tax_title_019';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel = 'record_tx_org_tax_value_019';
    $llValue = $this->pObj->pi_getLL( $llLabel );

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['value']      = $llValue;

    return $record;
  } 

/**
 * categoryCalType( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCalType( )
  {
    $table    = 'tx_org_caltype';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

      // category policy
    $uid = $uid + 1;
    $records[$uid] = $this->categoryCalTypePolicy( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryCalTypeSociety( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryCalTypeTYPO3( $uid );


    $this->sqlInsert( $records, $table );
  }
  
/**
 * categoryCalTypePolicy( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCalTypePolicy( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_caltype_title_policy';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }
  
/**
 * categoryCalTypeSociety( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCalTypeSociety( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_caltype_title_society';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }
  
/**
 * categoryCalTypeTYPO3( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryCalTypeTYPO3( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_caltype_title_typo3';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }

/**
 * categoryDepartment( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDepartment( )
  {
    $table    = 'tx_org_departmentcat';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

      // category policy
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDepartmentPolicy( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDepartmentSociety( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDepartmentTYPO3( $uid );


    $this->sqlInsert( $records, $table );
  }
  
/**
 * categoryDepartmentPolicy( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDepartmentPolicy( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_departmentcat_title_policy';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataHeadquarters_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }
  
/**
 * categoryDepartmentSociety( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDepartmentSociety( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_departmentcat_title_society';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataHeadquarters_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }
  
/**
 * categoryDepartmentTYPO3( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDepartmentTYPO3( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_departmentcat_title_typo3';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataHeadquarters_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }

/**
 * categoryDownloads( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDownloads( )
  {
    $table    = 'tx_org_downloadscat';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

      // category policy
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDownloadsDevelopment( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDownloadsFlyer( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDownloadsMusic( $uid );


    $this->sqlInsert( $records, $table );
  }
  
/**
 * categoryDownloadsDevelopment( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDownloadsDevelopment( $uid )
  {
    $record = null;

    $llLabel  = 'record_tx_org_downloadscat_title_development';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloadscat_type_development';
    $llType   = $this->pObj->pi_getLL( $llLabel );

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['type']       = $llType;

    return $record;
  }
  
/**
 * categoryDownloadsFlyer( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDownloadsFlyer( $uid )
  {
    $record = null;

    $llLabel  = 'record_tx_org_downloadscat_title_flyer';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloadscat_type_flyer';
    $llType   = $this->pObj->pi_getLL( $llLabel );

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['type']       = $llType;

    return $record;
  }
  
/**
 * categoryDownloadsMusic( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDownloadsMusic( $uid )
  {
    $record = null;

    $llLabel  = 'record_tx_org_downloadscat_title_music';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloadscat_type_music';
    $llType   = $this->pObj->pi_getLL( $llLabel );

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;
    $record['type']       = $llType;

    return $record;
  }

/**
 * categoryNews( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryNews( )
  {
    $table    = 'tx_org_newscat';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

      // category policy
    $uid = $uid + 1;
    $records[$uid] = $this->categoryNewsPolicy( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryNewsSociety( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryNewsTYPO3( $uid );


    $this->sqlInsert( $records, $table );
  }
  
/**
 * categoryNewsPolicy( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryNewsPolicy( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_newscat_title_policy';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataNews_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }
  
/**
 * categoryNewsSociety( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryNewsSociety( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_newscat_title_society';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataNews_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }
  
/**
 * categoryNewsTYPO3( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryNewsTYPO3( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_newscat_title_typo3';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataNews_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }



 /***********************************************
  *
  * Records
  *
  **********************************************/

/**
 * record( )
 *
 * @return	array		$records : the records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function record( )
  {
      // staff must be first, because ids are needed by cal
    $this->recordStaff( );
    $this->recordCal( );
//    $this->recordDownloads( );
//    $this->recordHeadquarters( );
//    $this->recordLocations( );
//    $this->recordNews( );
  }

/**
 * recordCal( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordCal( )
  {
    $table    = 'tx_org_cal';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

    $uid = $uid + 1;
    $records[$uid] = $this->recordCalEggroll( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordCalT3Devdays( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordCalT3Organiser( $uid );

    $this->sqlInsert( $records, $table );
  }
  
/**
 * recordCalEggroll( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordCalEggroll( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_cal_eggroll_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_cal_eggroll_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( '###TIMESTAMP###', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;
    
    $bodytext = $this->pObj->pi_getLL( 'record_tx_org_cal_eggroll_bodytext');

    $datetime = strtotime( '1 April next year' );

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['type']         = $this->pObj->pi_getLL('record_tx_org_cal_eggroll_type');
    $record['title']        = $llTitle;
    $record['datetime']     = $datetime;
    $record['bodytext']     = $bodytext;
    $record['image']        = $llImageWiTimestamp;
    //$record['imagewidth']   = $this->pObj->pi_getLL('record_tx_org_cal_eggroll_imagewidth');
    $record['image_link']   = $this->pObj->pi_getLL('record_tx_org_cal_eggroll_image_link');
    $record['imageorient']  = $this->pObj->pi_getLL('record_tx_org_cal_eggroll_imageorient');
    $record['imagecols']    = '1';
    $record['image_zoom']   = '1';
    $record['image_noRows'] = '1';

    return $record;
  }

/**
 * recordCalT3Devdays( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordCalT3Devdays( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_cal_t3devdays_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_cal_t3devdays_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( '###TIMESTAMP###', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;
    
    $bodytext = $this->pObj->pi_getLL( 'record_tx_org_cal_t3devdays_bodytext');

    $datetime = strtotime( '+3 months' );

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['type']         = $this->pObj->pi_getLL('record_tx_org_cal_t3devdays_type');
    $record['title']        = $llTitle;
    $record['datetime']     = $datetime;
    $record['calurl']       = $this->pObj->pi_getLL('record_tx_org_cal_t3devdays_calurl');
    $record['teaser_short'] = $this->pObj->pi_getLL('record_tx_org_cal_t3devdays_teaser_short');

    return $record;
  }
  
/**
 * recordCalT3Organiser( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordCalT3Organiser( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_cal_t3organiser_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_cal_t3organiser_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( '###TIMESTAMP###', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;
    
    $bodytext = $this->pObj->pi_getLL( 'record_tx_org_cal_t3organiser_bodytext');
    $strUser  = '###fe_users.uid.dwildt###';
    $uidUser  = $this->arr_recordUids[ $strUser ];
    $bodytext = str_replace( $strUser, $uidUser, $bodytext );
    $strUser  = '###fe_users.uid.obama###';
    $uidUser  = $this->arr_recordUids[ $strUser ];
    $bodytext = str_replace( $strUser, $uidUser, $bodytext );

    $datetime = strtotime( '+1 week' );

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['type']         = $this->pObj->pi_getLL('record_tx_org_cal_t3organiser_type');
    $record['title']        = $llTitle;
    $record['datetime']     = $datetime;
    $record['bodytext']     = $bodytext;
    $record['image']        = $llImageWiTimestamp;
    $record['imagewidth']   = $this->pObj->pi_getLL('record_tx_org_cal_t3organiser_imagewidth');
    //$record['image_link']   = $this->pObj->pi_getLL('record_tx_org_cal_t3organiser_image_link');
    $record['imageorient']  = $this->pObj->pi_getLL('record_tx_org_cal_t3organiser_imageorient');;
    $record['imagecols']    = '1';
    $record['image_zoom']   = '1';
    $record['image_noRows'] = '1';

    return $record;
  }

/**
 * recordStaff( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordStaff( )
  {
      // group must be first, because ids are needed by user
    $this->recordStaffGroup( );
    $this->recordStaffUser( );
  }

/**
 * recordStaffGroup( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordStaffGroup( )
  {
    $table    = 'fe_groups';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

      // category policy
    $uid = $uid + 1;
    $records[$uid] = $this->recordStaffGroupPolicy( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->recordStaffGroupSociety( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->recordStaffGroupTYPO3( $uid );


    $this->sqlInsert( $records, $table );
  }
  
/**
 * recordStaffGroupPolicy( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordStaffGroupPolicy( $uid )
  {
    $record = null;
    
    $this->arr_recordUids['###fe_groups.uid.policy###'] = $uid;

    $llLabel = 'record_fe_groups_title_policy';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataStaff_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }
  
/**
 * recordStaffGroupSociety( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordStaffGroupSociety( $uid )
  {
    $record = null;
    
    $this->arr_recordUids['###fe_groups.uid.society###'] = $uid;

    $llLabel = 'record_fe_groups_title_society';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataStaff_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }
  
/**
 * recordStaffGroupTYPO3( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordStaffGroupTYPO3( $uid )
  {
    $record = null;
    
    $this->arr_recordUids['###fe_groups.uid.typo3###'] = $uid;

    $llLabel = 'record_fe_groups_title_typo3';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']        = $uid;
    $record['pid']        = $this->pObj->arr_pageUids[ 'pageOrgDataStaff_title' ];
    $record['tstamp']     = time( );
    $record['crdate']     = time( );
    $record['cruser_id']  = $this->pObj->markerArray['###BE_USER###'];
    $record['title']      = $llTitle;

    return $record;
  }

/**
 * recordStaffUser( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordStaffUser( )
  {
    $table    = 'fe_users';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

    $uid = $uid + 1;
    $records[$uid] = $this->recordStaffUserObama( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordStaffUserSchaffstein( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordStaffUserWildt( $uid );

    $this->sqlInsert( $records, $table );
  }
  
/**
 * recordStaffUserObama( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordStaffUserObama( $uid )
  {
    $record = array( );

    $this->arr_recordUids['###fe_users.uid.bobama###'] = $uid;

    $llLabel  = 'record_fe_users_bobama_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( '###TIMESTAMP###', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;
    
    $usergroup  = $this->arr_recordUids['###fe_groups.uid.policy###'] . ', ' 
                . $this->arr_recordUids['###fe_groups.uid.society###'];

    $record['uid']                  = $uid;
    $record['pid']                  = $this->pObj->arr_pageUids[ 'pageOrgDataStaff_title' ];
    $record['tstamp']               = time( );
    $record['crdate']               = time( );
    $record['cruser_id']            = $this->pObj->markerArray['###BE_USER###'];
    $record['usergroup']            = $usergroup;
    $record['username']             = $this->pObj->pi_getLL('record_fe_users_bobama_username');
    $record['name']                 = $this->pObj->pi_getLL('record_fe_users_bobama_name');
    $record['first_name']           = $this->pObj->pi_getLL('record_fe_users_bobama_first_name');
    $record['last_name']            = $this->pObj->pi_getLL('record_fe_users_bobama_last_name');
    $record['password']             = $this->zz_getPassword();
    $record['telephone']            = $this->pObj->pi_getLL('record_fe_users_bobama_telephone');
    $record['email']                = $this->pObj->pi_getLL('record_fe_users_bobama_email');
    $record['www']                  = $this->pObj->pi_getLL('record_fe_users_bobama_www');
    $record['image']                = $llImageWiTimestamp;
    $record['tx_org_imagecaption']  = $this->pObj->pi_getLL('record_fe_users_bobama_tx_org_imagecaption');
    $record['tx_org_imageseo']      = $this->pObj->pi_getLL('record_fe_users_bobama_tx_org_imageseo');
    $record['tx_org_vita']          = $this->pObj->pi_getLL('record_fe_users_bobama_tx_org_vita');

    return $record;
  }

/**
 * recordStaffUserSchaffstein( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordStaffUserSchaffstein( $uid )
  {
    $record = array( );

    $this->arr_recordUids['###fe_users.uid.sschaffstein###'] = $uid;

    $llLabel  = 'record_fe_users_sschaffstein_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( '###TIMESTAMP###', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;
    
    $usergroup  = $this->arr_recordUids['###fe_groups.uid.policy###'] . ', ' 
                . $this->arr_recordUids['###fe_groups.uid.society###'];

    $record['uid']                  = $uid;
    $record['pid']                  = $this->pObj->arr_pageUids[ 'pageOrgDataStaff_title' ];
    $record['tstamp']               = time( );
    $record['crdate']               = time( );
    $record['cruser_id']            = $this->pObj->markerArray['###BE_USER###'];
    $record['usergroup']            = $usergroup;
    $record['username']             = $this->pObj->pi_getLL('record_fe_users_sschaffstein_username');
    $record['name']                 = $this->pObj->pi_getLL('record_fe_users_sschaffstein_name');
    $record['first_name']           = $this->pObj->pi_getLL('record_fe_users_sschaffstein_first_name');
    $record['last_name']            = $this->pObj->pi_getLL('record_fe_users_sschaffstein_last_name');
    $record['password']             = $this->zz_getPassword();
    $record['telephone']            = $this->pObj->pi_getLL('record_fe_users_sschaffstein_telephone');
    $record['email']                = $this->pObj->pi_getLL('record_fe_users_sschaffstein_email');
    $record['www']                  = $this->pObj->pi_getLL('record_fe_users_sschaffstein_www');
    $record['image']                = $llImageWiTimestamp;
    $record['tx_org_imagecaption']  = $this->pObj->pi_getLL('record_fe_users_sschaffstein_tx_org_imagecaption');
    $record['tx_org_imageseo']      = $this->pObj->pi_getLL('record_fe_users_sschaffstein_tx_org_imageseo');
    $record['tx_org_vita']          = $this->pObj->pi_getLL('record_fe_users_sschaffstein_tx_org_vita');

    return $record;
  }
  
/**
 * recordStaffUserWildt( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordStaffUserWildt( $uid )
  {
    $record = array( );

    $this->arr_recordUids['###fe_users.uid.dwildt###'] = $uid;

    $llLabel  = 'record_fe_users_dwildt_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( '###TIMESTAMP###', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;
    
    $usergroup  = $this->arr_recordUids['###fe_groups.uid.policy###'] . ', ' 
                . $this->arr_recordUids['###fe_groups.uid.society###'];

    $record['uid']                  = $uid;
    $record['pid']                  = $this->pObj->arr_pageUids[ 'pageOrgDataStaff_title' ];
    $record['tstamp']               = time( );
    $record['crdate']               = time( );
    $record['cruser_id']            = $this->pObj->markerArray['###BE_USER###'];
    $record['usergroup']            = $usergroup;
    $record['username']             = $this->pObj->pi_getLL('record_fe_users_dwildt_username');
    $record['name']                 = $this->pObj->pi_getLL('record_fe_users_dwildt_name');
    $record['first_name']           = $this->pObj->pi_getLL('record_fe_users_dwildt_first_name');
    $record['last_name']            = $this->pObj->pi_getLL('record_fe_users_dwildt_last_name');
    $record['password']             = $this->zz_getPassword();
    $record['telephone']            = $this->pObj->pi_getLL('record_fe_users_dwildt_telephone');
    $record['email']                = $this->pObj->pi_getLL('record_fe_users_dwildt_email');
    $record['www']                  = $this->pObj->pi_getLL('record_fe_users_dwildt_www');
    $record['image']                = $llImageWiTimestamp;
    $record['tx_org_imagecaption']  = $this->pObj->pi_getLL('record_fe_users_dwildt_tx_org_imagecaption');
    $record['tx_org_imageseo']      = $this->pObj->pi_getLL('record_fe_users_dwildt_tx_org_imageseo');
    $record['tx_org_vita']          = $this->pObj->pi_getLL('record_fe_users_dwildt_tx_org_vita');

    return $record;
  }



 /***********************************************
  *
  * Relations
  *
  **********************************************/

/**
 * relationBasecapBlueBlue( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationBasecapBlueBlue( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capBlue' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_blue' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationBasecapBlueClothes( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationBasecapBlueClothes( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capBlue' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationBasecapGreenClothes( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationBasecapGreenClothes( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capGreen' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationBasecapGreenGreen( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationBasecapGreenGreen( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capGreen' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_green' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationBasecapRedClothes( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationBasecapRedClothes( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capRed' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationBasecapRedRed( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationBasecapRedRed( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_capRed' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_red' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationBook( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationBook( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_book' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_books' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationCup( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCup( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_cup' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_cups' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relationPullover( )
 *
 * @param	integer		$sorting  : sorting value
 * @return	array		$record   : the field record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationPullover( $sorting )
  {
    $record = null;

    $record['uid_local']   = $this->pObj->arr_recordUids[ 'record_qs_prod_title_pullover' ];
    $record['uid_foreign'] = $this->pObj->arr_recordUids[ 'record_qs_cat_title_clothes' ];
    $record['sorting']     = $sorting;

    return $record;
  }

/**
 * relations( )
 *
 * @return	array		$records : the relation records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relations( )
  {
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( 'tx_powermail_fields' );

      // record book
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationBook( $sorting );

      // record basecap blue
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationBasecapBlueClothes( $sorting );
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationBasecapBlueBlue( $sorting );

      // record basecap green
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationBasecapGreenClothes( $sorting );
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationBasecapGreenGreen( $sorting );

      // record basecap red
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationBasecapRedClothes( $sorting );
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationBasecapRedRed( $sorting );

      // record cup
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationCup( $sorting );

      // record pullover
    list( $uid, $sorting) = explode( ',', $this->zz_counter( $uid ) );
    $records[$uid] = $this->relationPullover( $sorting );

    return $records;
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
 * @param	[type]		$table: ...
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function sqlInsert( $records, $table )
  {
    foreach( $records as $record )
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery( $table, $record ) );
      $GLOBALS['TYPO3_DB']->exec_INSERTquery( $table, $record );
      $error = $GLOBALS['TYPO3_DB']->sql_error( );

      if( $error )
      {
        $query  = $GLOBALS['TYPO3_DB']->INSERTquery( $table, $record );
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                  'query: ' . $query . '.<br />' . PHP_EOL .
                  'error: ' . $error . '.<br />' . PHP_EOL .
                  'Sorry for the trouble.<br />' . PHP_EOL .
                  'TYPO3-Quick-Shop Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die( $prompt );
      }

        // CONTINUE : pid is empty, no prompt
      if( empty( $record['pid'] ) )
      {
        continue;
      }
        // CONTINUE : pid is empty, no prompt

        // prompt
      $pageTitle = $this->pObj->arr_pageTitles[$record['pid']];
      $pageTitle = $this->pObj->pi_getLL( $pageTitle );
      $marker['###TITLE###']      = $record['title'];
      $marker['###TABLE###']      = $this->pObj->pi_getLL( $table );
      $marker['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $record['pid'] . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL( 'record_create_prompt' ) . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray( $prompt, $marker );
      $this->pObj->arrReport[ ] = $prompt;
        // prompt
    }
  }



 /***********************************************
  *
  * ZZ
  *
  **********************************************/

/**
 * zz_counter( ) :
 *
 * @param	integer		$uid        : current record uid
 * @return	string		$csvResult  : uid, sorting
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function zz_counter( $uid )
  {
    static $counter = 0;

    $counter  = $counter + 1 ;
    $uid      = $uid + 1 ;
    $sorting  = 256 * $counter;

    $csvResult = $uid . ',' . $sorting;

    return $csvResult;
  }
  
/**
 * zz_getPassword: Get a random value
 *
 * @return    string  random value
 * @access private
 * @version 3.0.0
 * @since 1.0.0
 */
  private function zz_getPassword( )
  {
    mt_srand( ( double ) microtime( ) * 1000000 );
    $randval = mt_rand( );
    $randval = md5( $randval );
    
    return $randval;
  }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_org.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_org.php']);
}