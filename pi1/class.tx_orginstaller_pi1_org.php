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
 *  135: class tx_orginstaller_pi1_org
 *
 *              SECTION: Main
 *  159:     public function main( )
 *
 *              SECTION: Categories
 *  182:     private function category( )
 *  199:     private function categoryCal( )
 *  214:     private function categoryCalEntrance( )
 *  245:     private function categoryCalEntranceFree( $uid )
 *  276:     private function categoryCalEntranceMortals( $uid )
 *  307:     private function categoryCalEntranceSponsors( $uid )
 *  338:     private function categoryCalTax( )
 *  369:     private function categoryCalTax000( $uid )
 *  400:     private function categoryCalTax007( $uid )
 *  431:     private function categoryCalTax019( $uid )
 *  461:     private function categoryCalType( )
 *  492:     private function categoryCalTypePolicy( $uid )
 *  519:     private function categoryCalTypeSociety( $uid )
 *  546:     private function categoryCalTypeTYPO3( $uid )
 *  572:     private function categoryDepartments( )
 *  603:     private function categoryDepartmentsPolicy( $uid )
 *  630:     private function categoryDepartmentsSociety( $uid )
 *  657:     private function categoryDepartmentsTYPO3( $uid )
 *  683:     private function categoryDownloadscat( )
 *  714:     private function categoryDownloadscatDevelopment( $uid )
 *  745:     private function categoryDownloadscatFlyer( $uid )
 *  776:     private function categoryDownloadscatMusic( $uid )
 *  806:     private function categoryNews( )
 *  837:     private function categoryNewsPolicy( $uid )
 *  864:     private function categoryNewsSociety( $uid )
 *  891:     private function categoryNewsTYPO3( $uid )
 *
 *              SECTION: Records
 *  925:     private function record( )
 *  945:     private function recordCal( )
 *  972:     private function recordCalEggroll( $uid )
 * 1018:     private function recordCalT3Devdays( $uid )
 * 1058:     private function recordCalT3Organiser( $uid )
 * 1109:     private function recordDepartments( )
 * 1136:     private function recordDepartmentsNetzmacher( $uid )
 * 1168:     private function recordDepartmentsPresident( $uid )
 * 1200:     private function recordDepartmentsT3Press( $uid )
 * 1231:     private function recordDownloads( )
 * 1273:     private function recordDownloadsCD1( $uid )
 * 1316:     private function recordDownloadsCD2( $uid )
 * 1359:     private function recordDownloadsCD3( $uid )
 * 1402:     private function recordDownloadsFlyer1( $uid )
 * 1445:     private function recordDownloadsFlyer2( $uid )
 * 1488:     private function recordDownloadsManual1( $uid )
 * 1531:     private function recordDownloadsManual2( $uid )
 * 1574:     private function recordDownloadsManual3( $uid )
 * 1616:     private function recordHeadquarters( )
 * 1643:     private function recordHeadquartersNetzmacher( $uid )
 * 1690:     private function recordHeadquartersPresident( $uid )
 * 1737:     private function recordHeadquartersTYPO3( $uid )
 * 1783:     private function recordLocations( )
 * 1807:     private function recordLocationsNetzmacher( $uid )
 * 1856:     private function recordLocationsT3Devdays( $uid )
 * 1913:     private function recordNews( )
 * 1940:     private function recordNewsFlow( $uid )
 * 1988:     private function recordNewsOrganiser( $uid )
 * 2036:     private function recordNewsPresident( $uid )
 * 2069:     private function recordStaff( )
 * 2084:     private function recordStaffGroup( )
 * 2115:     private function recordStaffGroupPolicy( $uid )
 * 2142:     private function recordStaffGroupSociety( $uid )
 * 2169:     private function recordStaffGroupTYPO3( $uid )
 * 2195:     private function recordStaffUser( )
 * 2222:     private function recordStaffUserBobama( $uid )
 * 2270:     private function recordStaffUserSschaffstein( $uid )
 * 2318:     private function recordStaffUserDwildt( $uid )
 *
 *              SECTION: Relations
 * 2374:     private function relationBasecapBlueBlue( $sorting )
 * 2394:     private function relationBasecapBlueClothes( $sorting )
 * 2414:     private function relationBasecapGreenClothes( $sorting )
 * 2434:     private function relationBasecapGreenGreen( $sorting )
 * 2454:     private function relationBasecapRedClothes( $sorting )
 * 2474:     private function relationBasecapRedRed( $sorting )
 * 2494:     private function relationBook( $sorting )
 * 2514:     private function relationCup( $sorting )
 * 2534:     private function relationPullover( $sorting )
 * 2553:     private function relation( )
 *
 *              SECTION: Sql
 * 2609:     private function sqlInsert( $records, $table )
 *
 *              SECTION: ZZ
 * 2669:     private function zz_counter( $uid )
 * 2690:     private function zz_getPassword( )
 *
 * TOTAL FUNCTIONS: 78
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
    $this->relation( );
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
    $this->categoryDepartments( );
    $this->categoryDownloadscat( );
    $this->categoryDownloadsmedia( );
    $this->categoryHeadquarters( );
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
 * categoryDepartments( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDepartments( )
  {
    $table    = 'tx_org_departmentcat';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

      // category policy
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDepartmentsPolicy( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDepartmentsSociety( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDepartmentsTYPO3( $uid );


    $this->sqlInsert( $records, $table );
  }

/**
 * categoryDepartmentsPolicy( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDepartmentsPolicy( $uid )
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
 * categoryDepartmentsSociety( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDepartmentsSociety( $uid )
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
 * categoryDepartmentsTYPO3( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDepartmentsTYPO3( $uid )
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
 * categoryDownloadscat( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDownloadscat( )
  {
    $table    = 'tx_org_downloadscat';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

      // category policy
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDownloadscatDevelopment( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDownloadscatFlyer( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDownloadscatMusic( $uid );


    $this->sqlInsert( $records, $table );
  }

/**
 * categoryDownloadscatDevelopment( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDownloadscatDevelopment( $uid )
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
 * categoryDownloadscatFlyer( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDownloadscatFlyer( $uid )
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
 * categoryDownloadscatMusic( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDownloadscatMusic( $uid )
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
 * categoryDownloadsmedia( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDownloadsmedia( )
  {
    $table    = 'tx_org_downloadsmedia';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

      // category policy
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDownloadsmediaCD( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDownloadsmediaFlyer( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryDownloadsmediaManuals( $uid );


    $this->sqlInsert( $records, $table );
  }

/**
 * categoryDownloadsmediaCD( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDownloadsmediaCD( $uid )
  {
    $record = null;

    $llLabel  = 'record_tx_org_downloadsmedia_title_cd';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloadsmedia_type_cd';
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
 * categoryDownloadsmediaFlyer( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDownloadsmediaFlyer( $uid )
  {
    $record = null;

    $llLabel  = 'record_tx_org_downloadsmedia_title_flyer';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloadsmedia_type_flyer';
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
 * categoryDownloadsmediaManuals( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryDownloadsmediaManuals( $uid )
  {
    $record = null;

    $llLabel  = 'record_tx_org_downloadsmedia_title_manuals';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloadsmedia_type_manuals';
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
 * categoryHeadquarters( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryHeadquarters( )
  {
    $table    = 'tx_org_headquarterscat';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

      // category policy
    $uid = $uid + 1;
    $records[$uid] = $this->categoryHeadquartersPolicy( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryHeadquartersSociety( $uid );

      // category society
    $uid = $uid + 1;
    $records[$uid] = $this->categoryHeadquartersTYPO3( $uid );


    $this->sqlInsert( $records, $table );
  }

/**
 * categoryHeadquartersPolicy( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryHeadquartersPolicy( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_headquarterscat_title_policy';
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
 * categoryHeadquartersSociety( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryHeadquartersSociety( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_headquarterscat_title_society';
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
 * categoryHeadquartersTYPO3( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function categoryHeadquartersTYPO3( $uid )
  {
    $record = null;

    $llLabel = 'record_tx_org_headquarterscat_title_typo3';
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
    $this->recordDepartments( );
    $this->recordDownloads( );
    $this->recordHeadquarters( );
    $this->recordLocations( );
    $this->recordNews( );
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

    $datetime = strtotime( '1 April last year' );

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgDataCal_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['type']         = $this->pObj->pi_getLL('record_tx_org_cal_eggroll_type');
    $record['title']        = $llTitle;
    $record['datetime']     = $datetime;
    $record['calurl']       = $this->pObj->pi_getLL('record_tx_org_cal_eggroll_calurl');
    $record['teaser_short'] = $this->pObj->pi_getLL('record_tx_org_cal_eggroll_teaser_short');

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
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
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
    $record['bodytext']     = $bodytext;
    $record['image']        = $llImageWiTimestamp;
    //$record['imagewidth']   = $this->pObj->pi_getLL('record_tx_org_cal_t3devdays_imagewidth');
    $record['image_link']   = $this->pObj->pi_getLL('record_tx_org_cal_t3devdays_image_link');
    $record['imageorient']  = $this->pObj->pi_getLL('record_tx_org_cal_t3devdays_imageorient');;
    $record['imagecols']    = '1';
    $record['image_zoom']   = '1';
    $record['image_noRows'] = '1';

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
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $bodytext = $this->pObj->pi_getLL( 'record_tx_org_cal_t3organiser_bodytext');
    $strUser  = '%dwildt%';
    $uidUser  = $this->pObj->arr_recordUids[ 'record_fe_users_dwildt_name' ];
    $bodytext = str_replace( $strUser, $uidUser, $bodytext );
    $strUser  = '%bobama%';
    $uidUser  = $this->pObj->arr_recordUids[ 'record_fe_users_bobama_name' ];
    $bodytext = str_replace( $strUser, $uidUser, $bodytext );

    $datetime = strtotime( '+3 months' );

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
 * recordDepartments( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDepartments( )
  {
    $table    = 'tx_org_department';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

    $uid = $uid + 1;
    $records[$uid] = $this->recordDepartmentsNetzmacher( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordDepartmentsPresident( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordDepartmentsT3Press( $uid );

    $this->sqlInsert( $records, $table );
  }

/**
 * recordDepartmentsNetzmacher( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDepartmentsNetzmacher( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_department_netzmacher_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgDataHeadquarters_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']       = 256 * 1;
    $record['title']        = $llTitle;
    $record['telephone']     = $this->pObj->pi_getLL('record_tx_org_department_netzmacher_telephone');
    $record['email']         = $this->pObj->pi_getLL('record_tx_org_department_netzmacher_email');
    $record['url']           = $this->pObj->pi_getLL('record_tx_org_department_netzmacher_url');

    return $record;

  }

/**
 * recordDepartmentsPresident( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDepartmentsPresident( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_department_president_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgDataHeadquarters_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']       = 256 * 2;
    $record['title']        = $llTitle;
    $record['telephone']     = $this->pObj->pi_getLL('record_tx_org_department_president_telephone');
    $record['email']         = $this->pObj->pi_getLL('record_tx_org_department_president_email');
    $record['url']           = $this->pObj->pi_getLL('record_tx_org_department_president_url');

    return $record;

  }

/**
 * recordDepartmentsT3Press( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDepartmentsT3Press( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_department_t3press_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgDataHeadquarters_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']       = 256 * 3;
    $record['title']        = $llTitle;
    $record['telephone']     = $this->pObj->pi_getLL('record_tx_org_department_t3press_telephone');
    $record['email']         = $this->pObj->pi_getLL('record_tx_org_department_t3press_email');
    $record['url']           = $this->pObj->pi_getLL('record_tx_org_department_t3press_url');

    return $record;

  }

/**
 * recordDownloads( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDownloads( )
  {
    $table    = 'tx_org_downloads';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

    $uid = $uid + 1;
    $records[$uid] = $this->recordDownloadsCD1( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordDownloadsCD2( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordDownloadsCD3( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordDownloadsFlyer1( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordDownloadsFlyer2( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordDownloadsManual1( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordDownloadsManual2( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordDownloadsManual3( $uid );

    $this->sqlInsert( $records, $table );
  }

/**
 * recordDownloadsCD1( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDownloadsCD1( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_downloads_cd1_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloads_cd1_thumbnail';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']                    = $uid;
    $record['pid']                    = $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ];
    $record['tstamp']                 = time( );
    $record['crdate']                 = time( );
    $record['cruser_id']              = $this->pObj->markerArray['###BE_USER###'];
    $record['type']                   = $this->pObj->pi_getLL('record_tx_org_downloads_cd1_type');
    $record['title']                  = $llTitle;
    $record['datetime']               = $this->pObj->pi_getLL('record_tx_org_downloads_cd1_datetime');
    $record['bodytext']               = $this->pObj->pi_getLL('record_tx_org_downloads_cd1_bodytext');
    $record['teaser_short']           = $this->pObj->pi_getLL('record_tx_org_downloads_cd1_teasershort');
    $record['tx_org_downloadscat']    = $this->pObj->pi_getLL('record_tx_org_downloads_cd1_tx_org_downloadscat');
    $record['tx_org_downloadsmedia']  = $this->pObj->pi_getLL('record_tx_org_downloads_cd1_tx_org_downloadsmedia');
    $record['linkicon_width']         = $this->pObj->pi_getLL('record_tx_org_downloads_cd1_linkicon_width');
    $record['thumbnail']              = $llImageWiTimestamp;
    $record['thumbnail_height']       = $this->pObj->pi_getLL('record_tx_org_downloads_cd1_thumbnail_height');
    $record['thumbnail_width']        = $this->pObj->pi_getLL('record_tx_org_downloads_cd1_thumbnail_width');

    return $record;

  }

/**
 * recordDownloadsCD2( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDownloadsCD2( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_downloads_cd2_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloads_cd2_thumbnail';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']                    = $uid;
    $record['pid']                    = $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ];
    $record['tstamp']                 = time( );
    $record['crdate']                 = time( );
    $record['cruser_id']              = $this->pObj->markerArray['###BE_USER###'];
    $record['type']                   = $this->pObj->pi_getLL('record_tx_org_downloads_cd2_type');
    $record['title']                  = $llTitle;
    $record['datetime']               = $this->pObj->pi_getLL('record_tx_org_downloads_cd2_datetime');
    $record['bodytext']               = $this->pObj->pi_getLL('record_tx_org_downloads_cd2_bodytext');
    $record['teaser_short']           = $this->pObj->pi_getLL('record_tx_org_downloads_cd2_teasershort');
    $record['tx_org_downloadscat']    = $this->pObj->pi_getLL('record_tx_org_downloads_cd2_tx_org_downloadscat');
    $record['tx_org_downloadsmedia']  = $this->pObj->pi_getLL('record_tx_org_downloads_cd2_tx_org_downloadsmedia');
    $record['linkicon_width']         = $this->pObj->pi_getLL('record_tx_org_downloads_cd2_linkicon_width');
    $record['thumbnail']              = $llImageWiTimestamp;
    $record['thumbnail_height']       = $this->pObj->pi_getLL('record_tx_org_downloads_cd2_thumbnail_height');
    $record['thumbnail_width']        = $this->pObj->pi_getLL('record_tx_org_downloads_cd2_thumbnail_width');

    return $record;

  }

/**
 * recordDownloadsCD3( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDownloadsCD3( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_downloads_cd3_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloads_cd3_thumbnail';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']                    = $uid;
    $record['pid']                    = $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ];
    $record['tstamp']                 = time( );
    $record['crdate']                 = time( );
    $record['cruser_id']              = $this->pObj->markerArray['###BE_USER###'];
    $record['type']                   = $this->pObj->pi_getLL('record_tx_org_downloads_cd3_type');
    $record['title']                  = $llTitle;
    $record['datetime']               = $this->pObj->pi_getLL('record_tx_org_downloads_cd3_datetime');
    $record['bodytext']               = $this->pObj->pi_getLL('record_tx_org_downloads_cd3_bodytext');
    $record['teaser_short']           = $this->pObj->pi_getLL('record_tx_org_downloads_cd3_teasershort');
    $record['tx_org_downloadscat']    = $this->pObj->pi_getLL('record_tx_org_downloads_cd3_tx_org_downloadscat');
    $record['tx_org_downloadsmedia']  = $this->pObj->pi_getLL('record_tx_org_downloads_cd3_tx_org_downloadsmedia');
    $record['linkicon_width']         = $this->pObj->pi_getLL('record_tx_org_downloads_cd3_linkicon_width');
    $record['thumbnail']              = $llImageWiTimestamp;
    $record['thumbnail_height']       = $this->pObj->pi_getLL('record_tx_org_downloads_cd3_thumbnail_height');
    $record['thumbnail_width']        = $this->pObj->pi_getLL('record_tx_org_downloads_cd3_thumbnail_width');

    return $record;

  }

/**
 * recordDownloadsFlyer1( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDownloadsFlyer1( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_downloads_flyer1_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloads_flyer1_thumbnail';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']                    = $uid;
    $record['pid']                    = $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ];
    $record['tstamp']                 = time( );
    $record['crdate']                 = time( );
    $record['cruser_id']              = $this->pObj->markerArray['###BE_USER###'];
    $record['type']                   = $this->pObj->pi_getLL('record_tx_org_downloads_flyer1_type');
    $record['title']                  = $llTitle;
    $record['datetime']               = $this->pObj->pi_getLL('record_tx_org_downloads_flyer1_datetime');
    $record['bodytext']               = $this->pObj->pi_getLL('record_tx_org_downloads_flyer1_bodytext');
    $record['teaser_short']           = $this->pObj->pi_getLL('record_tx_org_downloads_flyer1_teasershort');
    $record['tx_org_downloadscat']    = $this->pObj->pi_getLL('record_tx_org_downloads_flyer1_tx_org_downloadscat');
    $record['tx_org_downloadsmedia']  = $this->pObj->pi_getLL('record_tx_org_downloads_flyer1_tx_org_downloadsmedia');
    $record['linkicon_width']         = $this->pObj->pi_getLL('record_tx_org_downloads_flyer1_linkicon_width');
    $record['thumbnail']              = $llImageWiTimestamp;
    $record['thumbnail_height']       = $this->pObj->pi_getLL('record_tx_org_downloads_flyer1_thumbnail_height');
    $record['thumbnail_width']        = $this->pObj->pi_getLL('record_tx_org_downloads_flyer1_thumbnail_width');

    return $record;

  }

/**
 * recordDownloadsFlyer2( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDownloadsFlyer2( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_downloads_flyer2_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloads_flyer2_thumbnail';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']                    = $uid;
    $record['pid']                    = $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ];
    $record['tstamp']                 = time( );
    $record['crdate']                 = time( );
    $record['cruser_id']              = $this->pObj->markerArray['###BE_USER###'];
    $record['type']                   = $this->pObj->pi_getLL('record_tx_org_downloads_flyer2_type');
    $record['title']                  = $llTitle;
    $record['datetime']               = $this->pObj->pi_getLL('record_tx_org_downloads_flyer2_datetime');
    $record['bodytext']               = $this->pObj->pi_getLL('record_tx_org_downloads_flyer2_bodytext');
    $record['teaser_short']           = $this->pObj->pi_getLL('record_tx_org_downloads_flyer2_teasershort');
    $record['tx_org_downloadscat']    = $this->pObj->pi_getLL('record_tx_org_downloads_flyer2_tx_org_downloadscat');
    $record['tx_org_downloadsmedia']  = $this->pObj->pi_getLL('record_tx_org_downloads_flyer2_tx_org_downloadsmedia');
    $record['linkicon_width']         = $this->pObj->pi_getLL('record_tx_org_downloads_flyer2_linkicon_width');
    $record['thumbnail']              = $llImageWiTimestamp;
    $record['thumbnail_height']       = $this->pObj->pi_getLL('record_tx_org_downloads_flyer2_thumbnail_height');
    $record['thumbnail_width']        = $this->pObj->pi_getLL('record_tx_org_downloads_flyer2_thumbnail_width');

    return $record;

  }

/**
 * recordDownloadsManual1( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDownloadsManual1( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_downloads_manual1_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloads_manual1_thumbnail';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']                    = $uid;
    $record['pid']                    = $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ];
    $record['tstamp']                 = time( );
    $record['crdate']                 = time( );
    $record['cruser_id']              = $this->pObj->markerArray['###BE_USER###'];
    $record['type']                   = $this->pObj->pi_getLL('record_tx_org_downloads_manual1_type');
    $record['title']                  = $llTitle;
    $record['datetime']               = $this->pObj->pi_getLL('record_tx_org_downloads_manual1_datetime');
    $record['bodytext']               = $this->pObj->pi_getLL('record_tx_org_downloads_manual1_bodytext');
    $record['teaser_short']           = $this->pObj->pi_getLL('record_tx_org_downloads_manual1_teasershort');
    $record['tx_org_downloadscat']    = $this->pObj->pi_getLL('record_tx_org_downloads_manual1_tx_org_downloadscat');
    $record['tx_org_downloadsmedia']  = $this->pObj->pi_getLL('record_tx_org_downloads_manual1_tx_org_downloadsmedia');
    $record['linkicon_width']         = $this->pObj->pi_getLL('record_tx_org_downloads_manual1_linkicon_width');
    $record['thumbnail']              = $llImageWiTimestamp;
    $record['thumbnail_height']       = $this->pObj->pi_getLL('record_tx_org_downloads_manual1_thumbnail_height');
    $record['thumbnail_width']        = $this->pObj->pi_getLL('record_tx_org_downloads_manual1_thumbnail_width');

    return $record;

  }

/**
 * recordDownloadsManual2( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDownloadsManual2( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_downloads_manual2_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloads_manual2_thumbnail';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']                    = $uid;
    $record['pid']                    = $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ];
    $record['tstamp']                 = time( );
    $record['crdate']                 = time( );
    $record['cruser_id']              = $this->pObj->markerArray['###BE_USER###'];
    $record['type']                   = $this->pObj->pi_getLL('record_tx_org_downloads_manual2_type');
    $record['title']                  = $llTitle;
    $record['datetime']               = $this->pObj->pi_getLL('record_tx_org_downloads_manual2_datetime');
    $record['bodytext']               = $this->pObj->pi_getLL('record_tx_org_downloads_manual2_bodytext');
    $record['teaser_short']           = $this->pObj->pi_getLL('record_tx_org_downloads_manual2_teasershort');
    $record['tx_org_downloadscat']    = $this->pObj->pi_getLL('record_tx_org_downloads_manual2_tx_org_downloadscat');
    $record['tx_org_downloadsmedia']  = $this->pObj->pi_getLL('record_tx_org_downloads_manual2_tx_org_downloadsmedia');
    $record['linkicon_width']         = $this->pObj->pi_getLL('record_tx_org_downloads_manual2_linkicon_width');
    $record['thumbnail']              = $llImageWiTimestamp;
    $record['thumbnail_height']       = $this->pObj->pi_getLL('record_tx_org_downloads_manual2_thumbnail_height');
    $record['thumbnail_width']        = $this->pObj->pi_getLL('record_tx_org_downloads_manual2_thumbnail_width');

    return $record;

  }

/**
 * recordDownloadsManual3( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordDownloadsManual3( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_downloads_manual3_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_downloads_manual3_thumbnail';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']                    = $uid;
    $record['pid']                    = $this->pObj->arr_pageUids[ 'pageOrgDataDownloads_title' ];
    $record['tstamp']                 = time( );
    $record['crdate']                 = time( );
    $record['cruser_id']              = $this->pObj->markerArray['###BE_USER###'];
    $record['type']                   = $this->pObj->pi_getLL('record_tx_org_downloads_manual3_type');
    $record['title']                  = $llTitle;
    $record['datetime']               = $this->pObj->pi_getLL('record_tx_org_downloads_manual3_datetime');
    $record['bodytext']               = $this->pObj->pi_getLL('record_tx_org_downloads_manual3_bodytext');
    $record['teaser_short']           = $this->pObj->pi_getLL('record_tx_org_downloads_manual3_teasershort');
    $record['tx_org_downloadscat']    = $this->pObj->pi_getLL('record_tx_org_downloads_manual3_tx_org_downloadscat');
    $record['tx_org_downloadsmedia']  = $this->pObj->pi_getLL('record_tx_org_downloads_manual3_tx_org_downloadsmedia');
    $record['linkicon_width']         = $this->pObj->pi_getLL('record_tx_org_downloads_manual3_linkicon_width');
    $record['thumbnail']              = $llImageWiTimestamp;
    $record['thumbnail_height']       = $this->pObj->pi_getLL('record_tx_org_downloads_manual3_thumbnail_height');
    $record['thumbnail_width']        = $this->pObj->pi_getLL('record_tx_org_downloads_manual3_thumbnail_width');

    return $record;

  }

/**
 * recordHeadquarters( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordHeadquarters( )
  {
    $table    = 'tx_org_headquarters';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

    $uid = $uid + 1;
    $records[$uid] = $this->recordHeadquartersNetzmacher( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordHeadquartersPresident( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordHeadquartersTYPO3( $uid );

    $this->sqlInsert( $records, $table );
  }

/**
 * recordHeadquartersNetzmacher( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordHeadquartersNetzmacher( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_headquarters_netzmacher_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_headquarters_netzmacher_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']                = $uid;
    $record['pid']                = $this->pObj->arr_pageUids[ 'pageOrgDataHeadquarters_title' ];
    $record['tstamp']             = time( );
    $record['crdate']             = time( );
    $record['cruser_id']          = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']            = 256 * 1;
    $record['title']              = $llTitle;
    $record['telephone']          = $this->pObj->pi_getLL('record_tx_org_headquarters_netzmacher_telephone');
    $record['email']              = $this->pObj->pi_getLL('record_tx_org_headquarters_netzmacher_email');
    $record['mail_address']       = $this->pObj->pi_getLL('record_tx_org_headquarters_netzmacher_mail_address');
    $record['mail_postcode']      = $this->pObj->pi_getLL('record_tx_org_headquarters_netzmacher_mail_postcode');
    $record['mail_city']          = $this->pObj->pi_getLL('record_tx_org_headquarters_netzmacher_mail_city');
    $record['mail_url']           = $this->pObj->pi_getLL('record_tx_org_headquarters_netzmacher_mail_url');
    $record['mail_embeddedcode']  = $this->pObj->pi_getLL('record_tx_org_headquarters_netzmacher_mail_embeddedcode');
    $record['image']              = $llImageWiTimestamp;
    $record['imageorient']        = $this->pObj->pi_getLL('record_tx_org_headquarters_netzmacher_imageorient');
    $record['imageseo']           = $this->pObj->pi_getLL('record_tx_org_headquarters_netzmacher_imageseo');
    $record['imagecols']          = '1';
    $record['image_zoom']         = '1';
    $record['image_noRows']       = '1';

    return $record;

  }

/**
 * recordHeadquartersPresident( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordHeadquartersPresident( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_headquarters_president_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_headquarters_president_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']                = $uid;
    $record['pid']                = $this->pObj->arr_pageUids[ 'pageOrgDataHeadquarters_title' ];
    $record['tstamp']             = time( );
    $record['crdate']             = time( );
    $record['cruser_id']          = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']            = 256 * 1;
    $record['title']              = $llTitle;
    $record['telephone']          = $this->pObj->pi_getLL('record_tx_org_headquarters_president_telephone');
    $record['email']              = $this->pObj->pi_getLL('record_tx_org_headquarters_president_email');
    $record['mail_address']       = $this->pObj->pi_getLL('record_tx_org_headquarters_president_mail_address');
    $record['mail_postcode']      = $this->pObj->pi_getLL('record_tx_org_headquarters_president_mail_postcode');
    $record['mail_city']          = $this->pObj->pi_getLL('record_tx_org_headquarters_president_mail_city');
    $record['mail_url']           = $this->pObj->pi_getLL('record_tx_org_headquarters_president_mail_url');
    $record['mail_embeddedcode']  = $this->pObj->pi_getLL('record_tx_org_headquarters_president_mail_embeddedcode');
    $record['image']              = $llImageWiTimestamp;
    $record['imageorient']        = $this->pObj->pi_getLL('record_tx_org_headquarters_president_imageorient');
    $record['imageseo']           = $this->pObj->pi_getLL('record_tx_org_headquarters_president_imageseo');
    $record['imagecols']          = '1';
    $record['image_zoom']         = '1';
    $record['image_noRows']       = '1';

    return $record;

  }

/**
 * recordHeadquartersTYPO3( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordHeadquartersTYPO3( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_headquarters_typo3_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_headquarters_typo3_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']                = $uid;
    $record['pid']                = $this->pObj->arr_pageUids[ 'pageOrgDataHeadquarters_title' ];
    $record['tstamp']             = time( );
    $record['crdate']             = time( );
    $record['cruser_id']          = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']            = 256 * 1;
    $record['title']              = $llTitle;
    $record['telephone']          = $this->pObj->pi_getLL('record_tx_org_headquarters_typo3_telephone');
    $record['email']              = $this->pObj->pi_getLL('record_tx_org_headquarters_typo3_email');
    $record['mail_address']       = $this->pObj->pi_getLL('record_tx_org_headquarters_typo3_mail_address');
    $record['mail_postcode']      = $this->pObj->pi_getLL('record_tx_org_headquarters_typo3_mail_postcode');
    $record['mail_city']          = $this->pObj->pi_getLL('record_tx_org_headquarters_typo3_mail_city');
    $record['mail_url']           = $this->pObj->pi_getLL('record_tx_org_headquarters_typo3_mail_url');
    $record['mail_embeddedcode']  = $this->pObj->pi_getLL('record_tx_org_headquarters_typo3_mail_embeddedcode');
    $record['image']              = $llImageWiTimestamp;
    $record['imageorient']        = $this->pObj->pi_getLL('record_tx_org_headquarters_typo3_imageorient');
    $record['imageseo']           = $this->pObj->pi_getLL('record_tx_org_headquarters_typo3_imageseo');
    $record['imagecols']          = '1';
    $record['image_zoom']         = '1';
    $record['image_noRows']       = '1';

    return $record;

  }

/**
 * recordLocations( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordLocations( )
  {
    $table    = 'tx_org_location';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

    $uid = $uid + 1;
    $records[$uid] = $this->recordLocationsNetzmacher( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordLocationsT3Devdays( $uid );

    $this->sqlInsert( $records, $table );
  }

/**
 * recordLocationsNetzmacher( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordLocationsNetzmacher( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_location_netzmacher_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_location_netzmacher_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $record['uid']                = $uid;
    $record['pid']                = $this->pObj->arr_pageUids[ 'pageOrgDataLocations_title' ];
    $record['tstamp']             = time( );
    $record['crdate']             = time( );
    $record['cruser_id']          = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']            = 256 * 1;
    $record['title']              = $llTitle;
    $record['url']                = $this->pObj->pi_getLL('record_tx_org_location_netzmacher_url');
    $record['telephone']          = $this->pObj->pi_getLL('record_tx_org_location_netzmacher_telephone');
    $record['email']              = $this->pObj->pi_getLL('record_tx_org_location_netzmacher_email');
    $record['mail_address']       = $this->pObj->pi_getLL('record_tx_org_location_netzmacher_mail_address');
    $record['mail_postcode']      = $this->pObj->pi_getLL('record_tx_org_location_netzmacher_mail_postcode');
    $record['mail_city']          = $this->pObj->pi_getLL('record_tx_org_location_netzmacher_mail_city');
    $record['mail_url']           = $this->pObj->pi_getLL('record_tx_org_location_netzmacher_mail_url');
    $record['mail_embeddedcode']  = $this->pObj->pi_getLL('record_tx_org_location_netzmacher_mail_embeddedcode');
    $record['image']              = $llImageWiTimestamp;
    $record['imageorient']        = $this->pObj->pi_getLL('record_tx_org_location_netzmacher_imageorient');
    $record['imageseo']           = $this->pObj->pi_getLL('record_tx_org_location_netzmacher_imageseo');
    $record['imagewidth']         = $this->pObj->pi_getLL('record_tx_org_location_netzmacher_imagewidth');
    $record['image_link']         = $this->pObj->pi_getLL('record_tx_org_location_netzmacher_image_link');
    $record['imagecols']          = '1';
    $record['image_zoom']         = '1';
    $record['image_noRows']       = '1';

    return $record;
  }

/**
 * recordLocationsT3Devdays( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordLocationsT3Devdays( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_location_t3devdays_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_location_t3devdays_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    
    $arrLlImage             = explode( ',', $llImage );
    $arrLlImageWiTimestamp  = explode( ',', $llImageWiTimestamp );
    foreach( array_keys( $arrLlImageWiTimestamp ) as $pos )
    {
      $this->pObj->arr_fileUids[ $arrLlImage[ $pos ] ] = $arrLlImageWiTimestamp[ $pos ];
    }

    $llLabel  = 'record_tx_org_location_t3devdays_documents';
    $llFile  = $this->pObj->pi_getLL( $llLabel );
    $llFileWiTimestamp = str_replace( 'timestamp', time( ), $llFile );
    $this->pObj->arr_fileUids[ $llFile ] = $llFileWiTimestamp;

    $record['uid']                = $uid;
    $record['pid']                = $this->pObj->arr_pageUids[ 'pageOrgDataLocations_title' ];
    $record['tstamp']             = time( );
    $record['crdate']             = time( );
    $record['cruser_id']          = $this->pObj->markerArray['###BE_USER###'];
    $record['sorting']            = 256 * 2;
    $record['title']              = $llTitle;
    $record['url']                = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_url');
    $record['telephone']          = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_telephone');
    $record['email']              = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_email');
    $record['mail_address']       = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_mail_address');
    $record['mail_postcode']      = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_mail_postcode');
    $record['mail_city']          = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_mail_city');
    $record['mail_url']           = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_mail_url');
    $record['mail_embeddedcode']  = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_mail_embeddedcode');
    $record['image']              = $llImageWiTimestamp;
    $record['imageorient']        = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_imageorient');
    $record['imageseo']           = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_imageseo');
    $record['imagewidth']         = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_imagewidth');
    $record['image_link']         = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_image_link');
    $record['imagecols']          = '1';
    $record['image_zoom']         = '1';
    $record['image_noRows']       = '1';
    $record['documents']          = $llFileWiTimestamp;
    $record['documentscaption']   = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_documentscaption');
    $record['documentslayout']    = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_documentslayout');
    $record['documentssize']      = $this->pObj->pi_getLL('record_tx_org_location_t3devdays_documentssize');

    return $record;
  }

/**
 * recordNews( )
 *
 * @return	array		$records : the fieldset records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordNews( )
  {
    $table    = 'tx_org_news';
    $records  = array( );
    $uid      = $this->pObj->zz_getMaxDbUid( $table );

    $uid = $uid + 1;
    $records[$uid] = $this->recordNewsFlow( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordNewsOrganiser( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordNewsPresident( $uid );

    $this->sqlInsert( $records, $table );
  }

/**
 * recordNewsFlow( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordNewsFlow( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_news_flow_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_news_flow_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $bodytext = $this->pObj->pi_getLL( 'record_tx_org_news_flow_bodytext');

    $datetime = strtotime( 'now' );

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgDataNews_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['type']         = $this->pObj->pi_getLL('record_tx_org_news_flow_type');
    $record['title']        = $llTitle;
    $record['datetime']     = $datetime;
    $record['bodytext']     = $bodytext;
    $record['image']        = $llImageWiTimestamp;
    $record['imagewidth']   = $this->pObj->pi_getLL('record_tx_org_news_flow_imagewidth');
    $record['image_link']   = $this->pObj->pi_getLL('record_tx_org_news_flow_image_link');
    $record['imageorient']  = $this->pObj->pi_getLL('record_tx_org_news_flow_imageorient');
    $record['imagecaption'] = $this->pObj->pi_getLL('record_tx_org_news_flow_imagecaption');
    $record['imageseo']     = $this->pObj->pi_getLL('record_tx_org_news_flow_imageseo');
    $record['imagecols']    = '1';
    $record['image_zoom']   = '1';
    $record['image_noRows'] = '1';

    return $record;
  }

/**
 * recordNewsOrganiser( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordNewsOrganiser( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_news_organiser_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_tx_org_news_organiser_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $datetime = strtotime( '1. April 2011' );

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgDataNews_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['type']         = $this->pObj->pi_getLL('record_tx_org_news_organiser_type');
    $record['newsurl']      = $this->pObj->pi_getLL('record_tx_org_news_organiser_newsurl');
    $record['title']        = $llTitle;
    $record['subtitle']     = $this->pObj->pi_getLL('record_tx_org_news_organiser_subtitle');
    $record['datetime']     = $datetime;
    $record['teaser_short'] = $this->pObj->pi_getLL('record_tx_org_news_organiser_teaser_short');
    $record['image']        = $llImageWiTimestamp;
    $record['imagewidth']   = $this->pObj->pi_getLL('record_tx_org_news_organiser_imagewidth');
    $record['image_link']   = $this->pObj->pi_getLL('record_tx_org_news_organiser_image_link');
    $record['imageorient']  = $this->pObj->pi_getLL('record_tx_org_news_organiser_imageorient');
    $record['imagecaption'] = $this->pObj->pi_getLL('record_tx_org_news_organiser_imagecaption');
    $record['imageseo']     = $this->pObj->pi_getLL('record_tx_org_news_organiser_imageseo');
    $record['imagecols']    = '1';
    $record['image_zoom']   = '1';
    $record['image_noRows'] = '1';

    return $record;
  }

/**
 * recordNewsPresident( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordNewsPresident( $uid )
  {
    $record = array( );

    $llLabel  = 'record_tx_org_news_president_title';
    $llTitle  = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $bodytext = $this->pObj->pi_getLL( 'record_tx_org_news_president_bodytext');

    $datetime = strtotime( '22. March last year' );

    $record['uid']          = $uid;
    $record['pid']          = $this->pObj->arr_pageUids[ 'pageOrgDataNews_title' ];
    $record['tstamp']       = time( );
    $record['crdate']       = time( );
    $record['cruser_id']    = $this->pObj->markerArray['###BE_USER###'];
    $record['type']         = $this->pObj->pi_getLL('record_tx_org_news_president_type');
    $record['title']        = $llTitle;
    $record['datetime']     = $datetime;
    $record['bodytext']     = $bodytext;

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
    $records[$uid] = $this->recordStaffUserBobama( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordStaffUserSschaffstein( $uid );

    $uid = $uid + 1;
    $records[$uid] = $this->recordStaffUserDwildt( $uid );

    $this->sqlInsert( $records, $table );
  }

/**
 * recordStaffUserBobama( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordStaffUserBobama( $uid )
  {
    $record = array( );

    $llLabel = 'record_fe_users_bobama_name';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_fe_users_bobama_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $policy     = $this->pObj->arr_recordUids[ 'record_fe_groups_title_policy' ];
    $society    = $this->pObj->arr_recordUids[ 'record_fe_groups_title_society' ];
    $usergroup  = $policy . ', ' . $society;

    $record['uid']                  = $uid;
    $record['pid']                  = $this->pObj->arr_pageUids[ 'pageOrgDataStaff_title' ];
    $record['tstamp']               = time( );
    $record['crdate']               = time( );
    $record['cruser_id']            = $this->pObj->markerArray['###BE_USER###'];
    $record['usergroup']            = $usergroup;
    $record['username']             = $this->pObj->pi_getLL('record_fe_users_bobama_username');
    $record['name']                 = $llTitle;
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
 * recordStaffUserDwildt( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordStaffUserDwildt( $uid )
  {
    $record = array( );

    $llLabel = 'record_fe_users_dwildt_name';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_fe_users_dwildt_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $society    = $this->pObj->arr_recordUids[ 'record_fe_groups_title_society' ];
    $typo3      = $this->pObj->arr_recordUids[ 'record_fe_groups_title_typo3' ];
    $usergroup  = $society . ', ' . $typo3;

    $record['uid']                  = $uid;
    $record['pid']                  = $this->pObj->arr_pageUids[ 'pageOrgDataStaff_title' ];
    $record['tstamp']               = time( );
    $record['crdate']               = time( );
    $record['cruser_id']            = $this->pObj->markerArray['###BE_USER###'];
    $record['usergroup']            = $usergroup;
    $record['username']             = $this->pObj->pi_getLL('record_fe_users_dwildt_username');
    $record['name']                 = $llTitle;
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

/**
 * recordStaffUserSschaffstein( )
 *
 * @param	integer		$uid      : uid of the current fieldset
 * @return	array		$record   : the plugin record
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function recordStaffUserSschaffstein( $uid )
  {
    $record = array( );

    $llLabel = 'record_fe_users_sschaffstein_name';
    $llTitle = $this->pObj->pi_getLL( $llLabel );
    $this->pObj->arr_recordUids[ $llLabel ] = $uid;

    $llLabel  = 'record_fe_users_sschaffstein_image';
    $llImage  = $this->pObj->pi_getLL( $llLabel );
    $llImageWiTimestamp = str_replace( 'timestamp', time( ), $llImage );
    $this->pObj->arr_fileUids[ $llImage ] = $llImageWiTimestamp;

    $society    = $this->pObj->arr_recordUids[ 'record_fe_groups_title_society' ];
    $typo3      = $this->pObj->arr_recordUids[ 'record_fe_groups_title_typo3' ];
    $usergroup  = $society . ', ' . $typo3;

    $record['uid']                  = $uid;
    $record['pid']                  = $this->pObj->arr_pageUids[ 'pageOrgDataStaff_title' ];
    $record['tstamp']               = time( );
    $record['crdate']               = time( );
    $record['cruser_id']            = $this->pObj->markerArray['###BE_USER###'];
    $record['usergroup']            = $usergroup;
    $record['username']             = $this->pObj->pi_getLL('record_fe_users_sschaffstein_username');
    $record['name']                 = $llTitle;
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



 /***********************************************
  *
  * Relations
  *
  **********************************************/

/**
 * relation( )
 *
 * @return	array		$records : the relation records
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relation( )
  {
    $this->relationCal2Calentrance( );
    $this->relationCal2Caltype( );
    $this->relationCal2Location( );
    $this->relationDepartment2Cal( );
    $this->relationDepartment2Departmentcat( );
    $this->relationDepartment2News( );
    $this->relationDepartment2Staff( );
    $this->relationDownloads2Downloadscat( );
    $this->relationDownloads2Downloadsmedia( );
    $this->relationHeadquarters2Departments( );
    $this->relationHeadquarters2Headquarterscat( );
    $this->relationHeadquarters2Staff( );
    $this->relationNews2Newscat( );
    $this->relationStaff2News( );
  }

/**
 * relationCal2Calentrance( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2Calentrance( )
  {
    $table = 'tx_org_cal_mm_tx_org_calentrance';

    $records = array
              (
                $this->relationCal2CalentranceT3DevdaysFree( ),
                $this->relationCal2CalentranceT3DevdaysMortal( ),
                $this->relationCal2CalentranceT3DevdaysSponsor( ),
                $this->relationCal2CalentranceT3OrganiserFree( ),
                $this->relationCal2CalentranceT3OrganiserMortal( ),
                $this->relationCal2CalentranceT3OrganiserSponsor( )
              );

    $this->sqlInsert( $records, $table );

  }

/**
 * relationCal2CalentranceT3DevdaysFree( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2CalentranceT3DevdaysFree( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_cal_t3devdays_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_calentrance_title_entranceFree' ],
              );

    return $record;
  }

/**
 * relationCal2CalentranceT3DevdaysMortals( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2CalentranceT3DevdaysMortal( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_cal_t3devdays_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_calentrance_title_mereMortals' ],
              );

    return $record;
  }

/**
 * relationCal2CalentranceT3DevdaysSponsors( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2CalentranceT3DevdaysSponsor( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_cal_t3devdays_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_calentrance_title_sponsor' ],
              );

    return $record;
  }

/**
 * relationCal2CalentranceT3OrganiserFree( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2CalentranceT3OrganiserFree( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_cal_t3organiser_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_calentrance_title_entranceFree' ],
              );

    return $record;
  }

/**
 * relationCal2CalentranceT3OrganiserMortals( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2CalentranceT3OrganiserMortal( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_cal_t3organiser_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_calentrance_title_mereMortals' ],
              );

    return $record;
  }

/**
 * relationCal2CalentranceT3OrganiserSponsors( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2CalentranceT3OrganiserSponsor( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_cal_t3organiser_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_calentrance_title_sponsor' ],
              );

    return $record;
  }

/**
 * relationCal2Caltype( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2Caltype( )
  {
    $table = 'tx_org_cal_mm_tx_org_caltype';

    $records = array
              (
                $this->relationCal2CaltypeEggrollSociety( ),
                $this->relationCal2CaltypeT3DevdaysTYPO3( ),
                $this->relationCal2CaltypeT3OrgansierTYPO3( )
              );

    $this->sqlInsert( $records, $table );

  }

/**
 * relationCal2CaltypeEggrollSociety( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2CaltypeEggrollSociety( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_cal_eggroll_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_caltype_title_society' ],
              );

    return $record;
  }

/**
 * relationCal2CaltypeT3DevdaysTYPO3( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2CaltypeT3DevdaysTYPO3( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_cal_t3devdays_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_caltype_title_typo3' ],
              );

    return $record;
  }

/**
 * relationCal2CaltypeT3OrgansierTYPO3( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2CaltypeT3OrgansierTYPO3( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_cal_t3organiser_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_caltype_title_typo3' ],
              );

    return $record;
  }

/**
 * relationCal2Location( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2Location( )
  {
    $table = 'tx_org_cal_mm_tx_org_location';

    $records = array
              (
                $this->relationCal2LocationT3DevdaysT3Devdays( ),
                $this->relationCal2LocationT3OrganiserNetzmacher( )
              );

    $this->sqlInsert( $records, $table );

  }

/**
 * relationCal2LocationT3OrganiserNetzmacher( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2LocationT3OrganiserNetzmacher( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_cal_t3organiser_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_location_netzmacher_title' ],
              );

    return $record;
  }

/**
 * relationCal2LocationT3DevdaysT3Devdays( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationCal2LocationT3DevdaysT3Devdays( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_cal_t3devdays_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_location_t3devdays_title' ],
              );

    return $record;
  }

/**
 * relationDepartment2Cal( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2Cal( )
  {
    $table = 'tx_org_department_mm_tx_org_cal';

    $records = array
              (
                $this->relationDepartment2CalNetzmacherT3Organiser( ),
                $this->relationDepartment2CalPresidentEggroll( ),
                $this->relationDepartment2CalT3PressT3Devdays( )
              );

    $this->sqlInsert( $records, $table );

  }

/**
 * relationDepartment2CalNetzmacherT3Organiser( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2CalNetzmacherT3Organiser( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_netzmacher_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_cal_t3organiser_title' ],
              );

    return $record;
  }

/**
 * relationDepartment2CalPresidentEggroll( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2CalPresidentEggroll( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_president_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_cal_eggroll_title' ],
              );

    return $record;
  }

/**
 * relationDepartment2CalT3PressT3Devdays( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2CalT3PressT3Devdays( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_t3press_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_cal_t3devdays_title' ],
              );

    return $record;
  }

/**
 * relationDepartment2Departmentcat( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2Departmentcat( )
  {
    $table = 'tx_org_department_mm_tx_org_departmentcat';

    $records = array
              (
                $this->relationDepartment2DepartmentcatNetzmacherTYPO3( ),
                $this->relationDepartment2DepartmentcatPresidentPolicy( ),
                //$this->relationDepartment2DepartmentcatPresidentSociety( ),
                //$this->relationDepartment2DepartmentcatT3PressSociety( ),
                $this->relationDepartment2DepartmentcatT3PressTYPO3( )
              );

    $this->sqlInsert( $records, $table );

  }

/**
 * relationDepartment2DepartmentcatNetzmacherTYPO3( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2DepartmentcatNetzmacherTYPO3( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_netzmacher_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_departmentcat_title_typo3' ],
              );

    return $record;
  }

/**
 * relationDepartment2DepartmentcatPresidentPolicy( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2DepartmentcatPresidentPolicy( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_president_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_departmentcat_title_policy' ],
              );

    return $record;
  }

/**
 * relationDepartment2DepartmentcatPresidentSociety( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2DepartmentcatPresidentSociety( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_president_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_departmentcat_title_society' ],
              );

    return $record;
  }

/**
 * relationDepartment2DepartmentcatT3PressSociety( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2DepartmentcatT3PressSociety( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_t3press_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_departmentcat_title_society' ],
              );

    return $record;
  }

/**
 * relationDepartment2DepartmentcatT3PressTYPO3( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2DepartmentcatT3PressTYPO3( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_t3press_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_departmentcat_title_typo3' ],
              );

    return $record;
  }

/**
 * relationDepartment2News( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2News( )
  {
    $table = 'tx_org_department_mm_tx_org_news';

    $records = array
              (
                $this->relationDepartment2NewsPresidentPresident( ),
                $this->relationDepartment2NewsT3PressFlow( )
              );

    $this->sqlInsert( $records, $table );

  }

/**
 * relationDepartment2NewsPresidentPresident( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2NewsPresidentPresident( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_president_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_news_president_title' ],
              );

    return $record;
  }

/**
 * relationDepartment2NewsT3PressFlow( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2NewsT3PressFlow( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_t3press_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_news_flow_title' ],
              );

    return $record;
  }

/**
 * relationDepartment2Staff( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2Staff( )
  {
    $table = 'tx_org_department_mm_fe_users';

    $records = array
              (
                $this->relationDepartment2StaffNetzmacherDwildt( ),
                $this->relationDepartment2StaffPresidentBobama( ),
                $this->relationDepartment2StaffT3PressSschaffstein( )
              );

    $this->sqlInsert( $records, $table );

  }

/**
 * relationDepartment2StaffNetzmacherDwildt( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2StaffNetzmacherDwildt( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_netzmacher_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_fe_users_dwildt_name' ],
              );

    return $record;
  }

/**
 * relationDepartment2StaffPresidentBobama( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2StaffPresidentBobama( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_president_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_fe_users_bobama_name' ],
              );

    return $record;
  }

/**
 * relationDepartment2StaffT3PressSschaffstein( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDepartment2StaffT3PressSschaffstein( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_department_t3press_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_fe_users_sschaffstein_name' ],
              );

    return $record;
  }

/**
 * relationDownloads2Downloadscat( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2Downloadscat( )
  {
    $table = 'tx_org_downloads_mm_tx_org_downloadscat';

    $records = array
              (
                $this->relationDownloads2DownloadscatCD1Music( ),
                $this->relationDownloads2DownloadscatCD2Music( ),
                $this->relationDownloads2DownloadscatCD3Music( ),
                $this->relationDownloads2DownloadscatFlyer1Flyer( ),
                $this->relationDownloads2DownloadscatFlyer2Flyer( ),
                $this->relationDownloads2DownloadscatManual1Development( ),
                $this->relationDownloads2DownloadscatManual2Development( ),
                $this->relationDownloads2DownloadscatManual3Development( )
              );

    $this->sqlInsert( $records, $table );
  }

/**
 * relationDownloads2DownloadscatCD1Music( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadscatCD1Music( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_cd1_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadscat_title_music' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadscatCD2Music( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadscatCD2Music( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_cd2_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadscat_title_music' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadscatCD3Music( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadscatCD3Music( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_cd3_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadscat_title_music' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadscatFlyer1Flyer( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadscatFlyer1Flyer( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_flyer1_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadscat_title_flyer' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadscatFlyer2Flyer( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadscatFlyer2Flyer( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_flyer2_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadscat_title_flyer' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadscatManual1Development( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadscatManual1Development( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_manual1_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadscat_title_development' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadscatManual2Development( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadscatManual2Development( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_manual2_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadscat_title_development' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadscatManual3Development( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadscatManual3Development( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_manual3_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadscat_title_development' ],
              );

    return $record;
  }


/**
 * relationDownloads2Downloadsmedia( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2Downloadsmedia( )
  {
    $table = 'tx_org_downloads_mm_tx_org_downloadsmedia';

    $records = array
              (
                $this->relationDownloads2DownloadsmediaCD1CD( ),
                $this->relationDownloads2DownloadsmediaCD2CD( ),
                $this->relationDownloads2DownloadsmediaCD3CD( ),
                $this->relationDownloads2DownloadsmediaFlyer1Flyer( ),
                $this->relationDownloads2DownloadsmediaFlyer2Flyer( ),
                $this->relationDownloads2DownloadsmediaManual1Manuals( ),
                $this->relationDownloads2DownloadsmediaManual2Manuals( ),
                $this->relationDownloads2DownloadsmediaManual3Manuals( )
              );

    $this->sqlInsert( $records, $table );
  }

/**
 * relationDownloads2DownloadsmediaCD1CD( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadsmediaCD1CD( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_cd1_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadsmedia_title_cd' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadsmediaCD2CD( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadsmediaCD2CD( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_cd2_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadsmedia_title_cd' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadsmediaCD3CD( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadsmediaCD3CD( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_cd3_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadsmedia_title_cd' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadsmediaFlyer1Flyer( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadsmediaFlyer1Flyer( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_flyer1_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadsmedia_title_flyer' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadsmediaFlyer2Flyer( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadsmediaFlyer2Flyer( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_flyer2_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadsmedia_title_flyer' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadsmediaManual1Manuals( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadsmediaManual1Manuals( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_manual1_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadsmedia_title_manuals' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadsmediaManual2Manuals( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadsmediaManual2Manuals( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_manual2_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadsmedia_title_manuals' ],
              );

    return $record;
  }

/**
 * relationDownloads2DownloadsmediaManual3Manuals( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationDownloads2DownloadsmediaManual3Manuals( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_downloads_manual3_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_downloadsmedia_title_manuals' ],
              );

    return $record;
  }

/**
 * relationHeadquarters2Departments( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationHeadquarters2Departments( )
  {
    $table = 'tx_org_headquarters_mm_tx_org_department';

    $records = array
              (
                $this->relationHeadquarters2DepartmentsNetzmacherNetzmacher( ),
                $this->relationHeadquarters2DepartmentsPresidentPresident( ),
                $this->relationHeadquarters2DepartmentsTYPO3T3press( )
              );

    $this->sqlInsert( $records, $table );

  }

/**
 * relationHeadquarters2DepartmentsNetzmacherNetzmacher( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationHeadquarters2DepartmentsNetzmacherNetzmacher( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_headquarters_netzmacher_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_department_netzmacher_title' ]
              );

    return $record;
  }

/**
 * relationHeadquarters2DepartmentsPresidentPresident( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationHeadquarters2DepartmentsPresidentPresident( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_headquarters_president_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_department_president_title' ],
              );

    return $record;
  }

/**
 * relationHeadquarters2DepartmentsTYPO3T3press( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationHeadquarters2DepartmentsTYPO3T3press( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_headquarters_typo3_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_department_t3press_title' ],
              );

    return $record;
  }

/**
 * relationHeadquarters2Headquarterscat( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationHeadquarters2Headquarterscat( )
  {
    $table = 'tx_org_headquarters_mm_tx_org_headquarterscat';

    $records = array
              (
                $this->relationHeadquarters2HeadquarterscatNetzmacherTYPO3( ),
                $this->relationHeadquarters2HeadquarterscatPresidentPolicy( ),
                $this->relationHeadquarters2HeadquarterscatTYPO3TYPO3( )
              );

    $this->sqlInsert( $records, $table );

  }

/**
 * relationHeadquarters2HeadquarterscatNetzmacherTYPO3( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationHeadquarters2HeadquarterscatNetzmacherTYPO3( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_headquarters_netzmacher_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_headquarterscat_title_typo3' ]
              );

    return $record;
  }

/**
 * relationHeadquarters2HeadquarterscatPresidentPolicy( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationHeadquarters2HeadquarterscatPresidentPolicy( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_headquarters_president_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_headquarterscat_title_policy' ],
              );

    return $record;
  }

/**
 * relationHeadquarters2HeadquarterscatTYPO3TYPO3( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationHeadquarters2HeadquarterscatTYPO3TYPO3( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_headquarters_typo3_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_headquarterscat_title_typo3' ],
              );

    return $record;
  }

/**
 * relationHeadquarters2Staff( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationHeadquarters2Staff( )
  {
    $table = 'tx_org_headquarters_mm_fe_users';

    $records = array
              (
                $this->relationHeadquarters2StaffNetzmacherDwildt( ),
                $this->relationHeadquarters2StaffPresidentBobama( ),
                $this->relationHeadquarters2StaffTYPO3Sschaffstein( )
              );

    $this->sqlInsert( $records, $table );

  }

/**
 * relationHeadquarters2StaffNetzmacherDwildt( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationHeadquarters2StaffNetzmacherDwildt( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_headquarters_netzmacher_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_fe_users_dwildt_name' ]
              );

    return $record;
  }

/**
 * relationHeadquarters2StaffPresidentBobama( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationHeadquarters2StaffPresidentBobama( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_headquarters_president_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_fe_users_bobama_name' ],
              );

    return $record;
  }

/**
 * relationHeadquarters2StaffTYPO3Sschaffstein( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationHeadquarters2StaffTYPO3Sschaffstein( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_headquarters_typo3_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_fe_users_sschaffstein_name' ],
              );

    return $record;
  }

/**
 * relationNews2Newscat( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationNews2Newscat( )
  {
    $table = 'tx_org_news_mm_tx_org_newscat';

    $records = array
              (
                $this->relationNews2NewscatFlowTYPO3( ),
                $this->relationNews2NewscatPresidentPolicy( ),
                $this->relationNews2NewscatT3OrganiserTYPO3( )
              );

    $this->sqlInsert( $records, $table );

  }

/**
 * relationNews2NewscatFlowTYPO3( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationNews2NewscatFlowTYPO3( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_news_flow_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_newscat_title_typo3' ],
              );

    return $record;
  }

/**
 * relationNews2NewscatPresidentPolicy( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationNews2NewscatPresidentPolicy( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_news_president_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_newscat_title_policy' ],
              );

    return $record;
  }

/**
 * relationNews2NewscatT3OrganiserTYPO3( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationNews2NewscatT3OrganiserTYPO3( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_tx_org_news_t3organiser_title' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_newscat_title_typo3' ],
              );

    return $record;
  }

/**
 * relationStaff2News( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationStaff2News( )
  {
    $table = 'fe_users_mm_tx_org_news';

    $records = array
              (
                $this->relationStaff2NewsPresidentPresident( ),
                $this->relationStaff2NewsSschaffsteinFlow( )
              );

    $this->sqlInsert( $records, $table );

  }

/**
 * relationStaff2NewsPresidentPresident( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationStaff2NewsPresidentPresident( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_fe_users_bobama_name' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_news_president_title' ],
              );

    return $record;
  }

/**
 * relationStaff2NewsSschaffsteinFlow( )
 *
 * @return	void
 * @access private
 * @version 3.0.0
 * @since   0.0.1
 */
  private function relationStaff2NewsSschaffsteinFlow( )
  {
    $record = array
              ( 
                'uid_local'   => $this->pObj->arr_recordUids[ 'record_fe_users_sschaffstein_name' ],
                'uid_foreign' => $this->pObj->arr_recordUids[ 'record_tx_org_news_flow_title' ],
              );

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
                  'TYPO3-Organiser Installer<br />' . PHP_EOL .
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
      
      $title = $record['title'];
      if( empty( $title ) )
      {
        $title = $record['header'];      
      }
      if( empty( $title ) )
      {
        $title = $record['name'];      
      }
      $marker['###TITLE###']      = $title;
      $marker['###TABLE###']      = $this->pObj->pi_getLL( $table, '<i>' . $table . '</i>' );
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
 * zz_getPassword: Get a random value
 *
 * @return	string		random value
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