<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013-2014 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
 * ************************************************************* */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   70: class tx_orginstaller_pi1_typoscript
 *
 *              SECTION: Main
 *   94:     public function main( )
 *
 *              SECTION: Records
 *  124:     private function pageOrg( $uid )
 *  154:     private function pageOrg_caseAll( $uid )
 *  416:     private function pageOrg_caseOrgOnly( $uid )
 *  601:     private function pageOrgCalCaddy( $uid )
 *  655:     private function pageOrgDocumentsCaddy( $uid )
 *  707:     private function pageOrgStaticFiles( )
 *  747:     private function pageOrgStaticFilesPowermail1x( )
 *  765:     private function pageOrgStaticFilesPowermail2x( )
 *  783:     private function page( )
 *
 *              SECTION: Sql
 *  820:     private function sqlInsert( $records )
 *
 *              SECTION: ZZ - Helper
 *  872:     private function zzOrgCaddyConfig( )
 *  912:     private function zzOrgCaddyConfigPowermail1x( )
 *  940:     private function zzOrgCaddyConfigPowermail2x( )
 *  969:     private function zzOrgCaddyStaticFiles( )
 * 1009:     private function zzOrgCaddyStaticFilesPowermail1x( )
 * 1027:     private function zzOrgCaddyStaticFilesPowermail2x( )
 *
 * TOTAL FUNCTIONS: 17
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Plugin 'Organiser Installer' for the 'org_installer' extension.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    tx_orginstaller
 * @version 6.0.0
 * @since 3.0.0
 */
class tx_orginstaller_pi1_typoscript
{

  public $prefixId = 'tx_orginstaller_pi1_typoscript';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_orginstaller_pi1_typoscript.php';  // Path to this script relative to the extension dir.
  public $extKey = 'org_installer';                      // The extension key.
  public $pObj = null;

  /*   * *********************************************
   *
   * Main
   *
   * ******************************************** */

  /**
   * main( )
   *
   * @return	void
   * @access public
   * @version 3.0.0
   * @since   3.0.0
   */
  public function main()
  {
    $records = array();

    $this->pObj->arrReport[] = '
      <h2>
       ' . $this->pObj->pi_getLL('ts_create_header') . '
      </h2>';

    $records = $this->page();
    $this->sqlInsert($records);
  }

  /*   * *********************************************
   *
   * Records
   *
   * ******************************************** */

  /**
   * page( )
   *
   * @return	array		$records : the TypoScript records
   * @access private
   * @version 6.0.0
   * @since   3.0.0
   */
  private function page()
  {
    $records = array();
    $uid = $this->pObj->zz_getMaxDbUid('sys_template');

    $uid = $uid + 1;
    $records[$uid] = $this->pageOrg($uid);

    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgCalCaddy($uid);

    // #61838, 140923, dwildt, 2+
    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgCal($uid);

    // #61826, 140923, dwildt, 2+
    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgCalEvents($uid);

    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgCalLocations($uid);

    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgDocuments($uid);

    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgDocumentsCaddy($uid);

    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgHeadquarters($uid);

    // #61779, 140921, dwildt, 2+
    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgJobs($uid);

    // #61779, 140921, dwildt, 2+
    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgJobsJobsApply($uid);

    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgNews($uid);

    // #61779, 140921, dwildt, 2+
    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgService($uid);

    $uid = $uid + 1;
    $records[$uid] = $this->pageOrgStaff($uid);

    return $records;
  }

  /**
   * pageOrg( )
   *
   * @param	[type]		$$uid: ...
   * @return	array
   * @access private
   * @version 3.0.0
   * @since   3.0.0
   */
  private function pageOrg($uid)
  {
    $strUid = sprintf('%03d', $uid);
    $this->pObj->str_tsRoot = 'page_org_' . $strUid;
    $this->pObj->arr_tsUids[$this->pObj->str_tsRoot] = $uid;

    // SWITCH : install case
    switch (true)
    {
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_all' ):
        $record = $this->pageOrg_caseAll($uid);
        break;
      case( $this->pObj->markerArray['###INSTALL_CASE###'] == 'install_org' ):
        $record = $this->pageOrg_caseOrgOnly($uid);
        break;
    }
    // SWITCH : install case

    return $record;
  }

  /**
   * pageOrgCal( )
   *
   * @param	integer		$uid: uid of the new record
   * @return	array		$record : the TypoScript record
   * @access private
   * @internal #61838
   * @version 6.0.0
   * @since   6.0.0
   */
  private function pageOrgCal($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);
    $title = 'pageOrgCal_title';
    $llTitle = strtolower($this->pObj->pi_getLL($title));
    $llTitle = str_replace(' ', null, $llTitle);
    $llTitle = '+page_' . $llTitle . '_' . $strUid;
    $pid = $this->pObj->arr_pageUids[$title];

    $this->pObj->arr_tsUids[$title] = $uid;
    $this->pObj->arr_tsTitles[$uid] = $title;

    $includeStaticFile = 'EXT:org/Configuration/TypoScript/events/61826/';
    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $includeStaticFile = $includeStaticFile
                . ',EXT:org/Configuration/TypoScript/base/typo3/4.6/';
        break;
      default:
        // follow the workflow
        break;
    }

    $record['title'] = $llTitle;
    $record['uid'] = $uid;
    $record['pid'] = $pid;
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = ''
            . 'EXT:org/Configuration/TypoScript/calendar/201/,'
            . 'EXT:org/Configuration/TypoScript/calendar/201/caddy/'
    ;
    $record['constants'] = '

  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.caddy
  // plugin.tx_browser_pi1
  // plugin.tx_seodynamictag



  /////////////////////////////////////////
  //
  // plugin.caddy

plugin.caddy {
  pages {
    caddy       = ' . $this->pObj->arr_pageUids['pageOrgCalCaddy_title'] . '
    caddymini   = ' . $this->pObj->arr_pageUids['pageOrgCalCaddyCaddymini_title'] . '
    revocation  = ' . $this->pObj->arr_pageUids['pageOrgCalRevocation_title'] . '
    shop        = ' . $this->pObj->arr_pageUids['pageOrgCal_title'] . '
    terms       = ' . $this->pObj->arr_pageUids['pageOrgCalTerms_title'] . '
  }
  url {
    showUid = calendarUid
  }
}
  // plugin.caddy



  ////////////////////////////////////////
  //
  // plugin.tx_browser_pi1

plugin.tx_browser_pi1 {
  templates {
    listview {
      url {
        1 {
            // News
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgNews_title'] . '
        }
        2 {
            // Location
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgLocation_title'] . '
        }
        3 {
            // Staff
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgStaff_title'] . '
        }
      }
    }
  }
}
  // plugin.tx_browser_pi1



  ////////////////////////////////////////
  //
  // plugin.tx_seodynamictag

plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|calendarUid > 0] && [globalVar = TSFE:id = ' . $pid . '
    }
  }
}
  // plugin.tx_seodynamictag
';

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrgCalEvents( )
   *
   * @param	integer		$uid: uid of the new record
   * @return	array		$record : the TypoScript record
   * @access private
   * @internal #61826
   * @version 6.0.0
   * @since   6.0.0
   */
  private function pageOrgCalEvents($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);
    $title = 'pageOrgCalEvents_title';
    $llTitle = strtolower($this->pObj->pi_getLL($title));
    $llTitle = str_replace(' ', null, $llTitle);
    $llTitle = '+page_' . $llTitle . '_' . $strUid;
    $pid = $this->pObj->arr_pageUids[$title];

    $this->pObj->arr_tsUids[$title] = $uid;
    $this->pObj->arr_tsTitles[$uid] = $title;

    $includeStaticFile = 'EXT:org/Configuration/TypoScript/events/61826/';
    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $includeStaticFile = $includeStaticFile
                . ',EXT:org/Configuration/TypoScript/base/typo3/4.6/';
        break;
      default:
        // follow the workflow
        break;
    }

    $record['title'] = $llTitle;
    $record['uid'] = $uid;
    $record['pid'] = $pid;
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = $includeStaticFile;
    $record['constants'] = '
  ////////////////////////////////////////
  //
  // INDEX

  // plugin.tx_browser_pi1
  // plugin.tx_seodynamictag



  ////////////////////////////////////////
  //
  // plugin.tx_browser_pi1

plugin.tx_browser_pi1 {
  map {
    aliases {
      showUid {
        marker = eventsUid
      }
    }
  }
  templates {
    listview {
      image {
        0 {
          height  =  90c
          width   = 220c
        }
      }
      url {
        1 {
            // News
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgNews_title'] . '
        }
        2 {
            // Staff
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgStaff_title'] . '
        }
      }
    }
  }
}
  // plugin.tx_browser_pi1



  ////////////////////////////////////////
  //
  // plugin.tx_seodynamictag

  // plugin.tx_seodynamictag
plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|eventsUid > 0] && [globalVar = TSFE:id = ' . $pid . '
    }
  }
}
  // plugin.tx_seodynamictag
';
    $record['config'] = null;

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrgCalLocations( )
   *
   * @param	integer		$uid: uid of the new record
   * @return	array		$record : the TypoScript record
   * @access private
   * @version 3.1.1
   * @since   3.1.1
   */
  private function pageOrgCalLocations($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);
    $title = 'pageOrgCalLocations_title';
    $llTitle = strtolower($this->pObj->pi_getLL($title));
    $llTitle = str_replace(' ', null, $llTitle);
    $llTitle = '+page_' . $llTitle . '_' . $strUid;
    $pid = $this->pObj->arr_pageUids[$title];

    $this->pObj->arr_tsUids[$title] = $uid;
    $this->pObj->arr_tsTitles[$uid] = $title;

    $includeStaticFile = 'EXT:org/Configuration/TypoScript/location/701/';
    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $includeStaticFile = $includeStaticFile
                . ',EXT:org/Configuration/TypoScript/base/typo3/4.6/';
        break;
      default:
        // follow the workflow
        break;
    }

    $record['title'] = $llTitle;
    $record['uid'] = $uid;
    $record['pid'] = $pid;
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = $includeStaticFile;
    $record['constants'] = '
  // plugin.tx_seodynamictag
plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|locationUid > 0] && [globalVar = TSFE:id = ' . $pid . '
    }
  }
}
  // plugin.tx_seodynamictag
';

    $record['config'] = null;

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrgHeadquarters( )
   *
   * @param	integer		$uid: uid of the new record
   * @return	array		$record : the TypoScript record
   * @access private
   * @version 3.1.1
   * @since   3.1.1
   */
  private function pageOrgHeadquarters($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);
    $title = 'pageOrgHeadquarters_title';
    $llTitle = strtolower($this->pObj->pi_getLL($title));
    $llTitle = str_replace(' ', null, $llTitle);
    $llTitle = '+page_' . $llTitle . '_' . $strUid;
    $pid = $this->pObj->arr_pageUids[$title];

    $this->pObj->arr_tsUids[$title] = $uid;
    $this->pObj->arr_tsTitles[$uid] = $title;

    $includeStaticFile = 'EXT:org/Configuration/TypoScript/headquarters/501/';
    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $includeStaticFile = $includeStaticFile
                . ',EXT:org/Configuration/TypoScript/base/typo3/4.6/';
        break;
      default:
        // follow the workflow
        break;
    }

    $record['title'] = $llTitle;
    $record['uid'] = $uid;
    $record['pid'] = $pid;
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = $includeStaticFile;
    $record['constants'] = '
  ////////////////////////////////////////
  //
  // INDEX

  // plugin.tx_browser_pi1
  // plugin.tx_seodynamictag



  ////////////////////////////////////////
  //
  // plugin.tx_browser_pi1

plugin.tx_browser_pi1 {
  templates {
    listview {
      url {
        1 {
            // News
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgNews_title'] . '
        }
        2 {
            // Staff
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgStaff_title'] . '
        }
      }
    }
  }
}
  // plugin.tx_browser_pi1



  ////////////////////////////////////////
  //
  // plugin.tx_seodynamictag

  // plugin.tx_seodynamictag
plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|headquartersUid > 0] && [globalVar = TSFE:id = ' . $pid . '
    }
  }
}
  // plugin.tx_seodynamictag
';
    $record['config'] = null;

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrgJobs( )
   *
   * @param	integer		$uid: uid of the new record
   * @return	array		$record : the TypoScript record
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgJobs($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);
    $title = 'pageOrgJobs_title';
    $llTitle = strtolower($this->pObj->pi_getLL($title));
    $llTitle = str_replace(' ', null, $llTitle);
    $llTitle = '+page_' . $llTitle . '_' . $strUid;
    $pid = $this->pObj->arr_pageUids[$title];

    $this->pObj->arr_tsUids[$title] = $uid;
    $this->pObj->arr_tsTitles[$uid] = $title;

    $includeStaticFile = 'EXT:org/Configuration/TypoScript/job/593611/';
    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $includeStaticFile = $includeStaticFile
                . ',EXT:org/Configuration/TypoScript/base/typo3/4.6/';
        break;
      default:
        // follow the workflow
        break;
    }

    $record['title'] = $llTitle;
    $record['uid'] = $uid;
    $record['pid'] = $pid;
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = $includeStaticFile;
    $record['constants'] = '
  // plugin.tx_browser_pi1
  // plugin.tx_seodynamictag


  // plugin.tx_browser_pi1
plugin.tx_browser_pi1 {
  templates {
    listview {
      url {
        1 {
            // News
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgNews_title'] . '
        }
        2 {
            // Headquarters
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgHeadquarters_title'] . '
        }
      }
    }
  }
}
  // plugin.tx_browser_pi1

  // plugin.tx_seodynamictag
plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|jobUid > 0] && [globalVar = TSFE:id = ' . $pid . '
    }
  }
}
  // plugin.tx_seodynamictag
';
    $record['config'] = null;

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrgJobsJobsApply( )
   *
   * @param	integer		$uid: uid of the new record
   * @return	array		$record : the TypoScript record
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgJobsJobsApply($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);
    $title = 'pageOrgJobsJobsApply_title';
    $llTitle = strtolower($this->pObj->pi_getLL($title));
    $llTitle = str_replace(' ', null, $llTitle);
    $llTitle = '+page_' . $llTitle . '_' . $strUid;
    $pid = $this->pObj->arr_pageUids[$title];

    $this->pObj->arr_tsUids[$title] = $uid;
    $this->pObj->arr_tsTitles[$uid] = $title;

    $includeStaticFile = $this->zzOrgCaddyStaticFiles();

    $record['title'] = $llTitle;
    $record['uid'] = $uid;
    $record['pid'] = $pid;
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = $includeStaticFile;
// Will handled by consolidation
//    $record['constants']            = null;
//    $record['config']               = null;
    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrgNews( )
   *
   * @param	integer		$uid: uid of the new record
   * @return	array		$record : the TypoScript record
   * @access private
   * @version 3.1.1
   * @since   3.1.1
   */
  private function pageOrgNews($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);
    $title = 'pageOrgNews_title';
    $llTitle = strtolower($this->pObj->pi_getLL($title));
    $llTitle = str_replace(' ', null, $llTitle);
    $llTitle = '+page_' . $llTitle . '_' . $strUid;
    $pid = $this->pObj->arr_pageUids[$title];

    $this->pObj->arr_tsUids[$title] = $uid;
    $this->pObj->arr_tsTitles[$uid] = $title;

    $includeStaticFile = 'EXT:org/Configuration/TypoScript/news/401/';
    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $includeStaticFile = $includeStaticFile
                . ',EXT:org/Configuration/TypoScript/base/typo3/4.6/';
        break;
      default:
        // follow the workflow
        break;
    }

    $record['title'] = $llTitle;
    $record['uid'] = $uid;
    $record['pid'] = $pid;
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = $includeStaticFile;
    $record['constants'] = '
  // plugin.tx_browser_pi1
  // plugin.tx_seodynamictag


  // plugin.tx_browser_pi1
plugin.tx_browser_pi1 {
  templates {
    listview {
      url {
        1 {
            // Staff
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgStaff_title'] . '
        }
        2 {
            // Headquarters
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgHeadquarters_title'] . '
        }
      }
    }
  }
}
  // plugin.tx_browser_pi1

  // plugin.tx_seodynamictag
plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|newsUid > 0] && [globalVar = TSFE:id = ' . $pid . '
    }
  }
}
  // plugin.tx_seodynamictag
';
    $record['config'] = null;

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrgStaff( )
   *
   * @param	integer		$uid: uid of the new record
   * @return	array		$record : the TypoScript record
   * @access private
   * @version 3.1.1
   * @since   3.1.1
   */
  private function pageOrgStaff($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);
    $title = 'pageOrgStaff_title';
    $llTitle = strtolower($this->pObj->pi_getLL($title));
    $llTitle = str_replace(' ', null, $llTitle);
    $llTitle = '+page_' . $llTitle . '_' . $strUid;
    $pid = $this->pObj->arr_pageUids[$title];

    $this->pObj->arr_tsUids[$title] = $uid;
    $this->pObj->arr_tsTitles[$uid] = $title;

    $includeStaticFile = 'EXT:org/Configuration/TypoScript/staff/101/';
    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $includeStaticFile = $includeStaticFile
                . ',EXT:org/Configuration/TypoScript/base/typo3/4.6/';
        break;
      default:
        // follow the workflow
        break;
    }

    $record['title'] = $llTitle;
    $record['uid'] = $uid;
    $record['pid'] = $pid;
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = $includeStaticFile;
    $record['constants'] = '
  // plugin.tx_browser_pi1
  // plugin.tx_seodynamictag


  // plugin.tx_browser_pi1
plugin.tx_browser_pi1 {
  templates {
    listview {
      url {
        1 {
            // News
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgNews_title'] . '
        }
        2 {
            // Headquarters
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgHeadquarters_title'] . '
        }
      }
    }
  }
}
  // plugin.tx_browser_pi1

  // plugin.tx_seodynamictag
plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|staffUid > 0] && [globalVar = TSFE:id = ' . $pid . '
    }
  }
}
  // plugin.tx_seodynamictag
';
    $record['config'] = null;

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrgService( )
   *
   * @param	integer		$uid: uid of the new record
   * @return	array		$record : the TypoScript record
   * @access private
   * @internal #61779
   * @version 6.0.0
   * @since 6.0.0
   */
  private function pageOrgService($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);
    $title = 'pageOrgService_title';
    $llTitle = strtolower($this->pObj->pi_getLL($title));
    $llTitle = str_replace(' ', null, $llTitle);
    $llTitle = '+page_' . $llTitle . '_' . $strUid;
    $pid = $this->pObj->arr_pageUids[$title];

    $this->pObj->arr_tsUids[$title] = $uid;
    $this->pObj->arr_tsTitles[$uid] = $title;

    $includeStaticFile = 'EXT:org/Configuration/TypoScript/service/593621/';
    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $includeStaticFile = $includeStaticFile
                . ',EXT:org/Configuration/TypoScript/base/typo3/4.6/';
        break;
      default:
        // follow the workflow
        break;
    }

    $record['title'] = $llTitle;
    $record['uid'] = $uid;
    $record['pid'] = $pid;
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = $includeStaticFile;
    $record['constants'] = '
  // plugin.tx_browser_pi1
  // plugin.tx_seodynamictag


  // plugin.tx_browser_pi1
plugin.tx_browser_pi1 {
  templates {
    listview {
      url {
        1 {
            // News
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgNews_title'] . '
        }
        2 {
            // Headquarters
          singlePid = ' . $this->pObj->arr_pageUids['pageOrgHeadquarters_title'] . '
        }
      }
    }
  }
}
  // plugin.tx_browser_pi1

  // plugin.tx_seodynamictag
plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|serviceUid > 0] && [globalVar = TSFE:id = ' . $pid . '
    }
  }
}
  // plugin.tx_seodynamictag
';
    $record['config'] = null;

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrg_caseAll( )
   *
   * @param	[type]		$$uid: ...
   * @return	array		$record : the TypoScript record
   * @access private
   * @version 6.0.0
   * @since   3.0.0
   */
  private function pageOrg_caseAll($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);

    $title = strtolower($GLOBALS['TSFE']->page['title']);
    $title = str_replace(' ', null, $title);
    $title = 'page_' . $title . '_' . $strUid;
    $pid = $GLOBALS['TSFE']->id;

    $this->pObj->str_tsRoot = $title;
    $this->pObj->arr_tsUids[$this->pObj->str_tsRoot] = $uid;

    $record['title'] = $title;
    $record['uid'] = $uid;
    $record['pid'] = $pid;
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['sitetitle'] = $this->pObj->markerArray['###WEBSITE_TITLE###'];
    $record['root'] = 1;
    $record['clear'] = 3;  // Clear all
    $record['include_static_file'] = 'EXT:css_styled_content/static/,'
            . 'EXT:browser/Configuration/TypoScript/Foundation/Framework/,'
            . 'EXT:baseorg/static/,'
            . 'EXT:radialsearch/static/,'
            . 'EXT:radialsearch/static/properties/de/,'
            . 'EXT:browser/Configuration/TypoScript/,'
            . 'EXT:browser/Configuration/TypoScript/Foundation/Templating/,'
            . 'EXT:caddy/Configuration/TypoScript/Basis/,'
            . 'EXT:caddy/Configuration/TypoScript/Foundation/5x/,'      // #61867, 140925, dwildt, 1+
            . 'EXT:caddy/Configuration/TypoScript/Properties/de/,'
            . 'EXT:caddy/Configuration/TypoScript/Foundation/5x/Css/,'  // #61867, 140925, dwildt, 1+
            //. 'EXT:caddy/Configuration/TypoScript/Css/,'              // #61867, 140925, dwildt, 1-
            . 'EXT:linkhandlerconf/static/,'
            . 'EXT:flipit/static/,'
            . '%flipit46%'
            . '%flipit61%'
            . 'EXT:seo_dynamic_tag/static/,'
            . 'EXT:org/Configuration/TypoScript/base/,'
    ;

    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $include = $record['include_static_file'];
        $include = str_replace('%flipit46%', 'EXT:flipit/static/typo3/4.6/,', $include);
        $include = $include . ',EXT:org/Configuration/TypoScript/base/typo3/4.6/';
        $record['include_static_file'] = $include;
        break;
      default:
        $include = $record['include_static_file'];
        $include = str_replace('%flipit46%', null, $include);
        $record['include_static_file'] = $include;
        break;
    }
    switch (true)
    {
      case( $this->pObj->get_typo3Version() >= 6000000 ):
        $include = $record['include_static_file'];
        $include = str_replace('%flipit61%', 'EXT:flipit/static/woFancybox/,', $include);
        $record['include_static_file'] = $include;
        break;
      default:
        $include = $record['include_static_file'];
        $include = str_replace('%flipit61%', null, $include);
        $record['include_static_file'] = $include;
        break;
    }
    $record['includeStaticAfterBasedOn'] = 1;
    $record['constants'] = '

  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.baseorg
  // plugin.org
  // plugin.tx_browser_pi1
  // plugin.tx_radialsearch_pi1
  // plugin.tx_seodynamictag_pi1


  /////////////////////////////////////////
  //
  // plugin.baseorg
plugin.baseorg {
  client {
    name = TYPO3 Organiser Installer
  }
    // for baseURL
  host = ' . $this->pObj->markerArray['###HOST###'] . '/
  pages {
    root = ' . $this->pObj->arr_pageUids['pageOrg_title'] . '
    root {
      caddymini = ' . $this->pObj->arr_pageUids['pageOrgCalCaddyCaddymini_title'] . '
      libraries {
        footer = ' . $this->pObj->arr_pageUids['pageOrgLibraryFooter_title'] . '
        header {
          logo = ' . $this->pObj->arr_pageUids['pageOrgLibraryHeaderLogo_title'] . '
          slider {
            content = ' . $this->pObj->arr_pageUids['pageOrgLibraryHeaderSlider_title'] . '
          }
        }
        menu {
          topbar = ' . $this->pObj->arr_pageUids['pageOrgLibraryMenu_title'] . '
          bottom = ' . $this->pObj->arr_pageUids['pageOrgLibraryMenubelow_title'] . '
        }
      }
    }
  }
  slider {
    colpos = 1
  }
}
  // plugin.baseorg



  /////////////////////////////////////////
  //
  // plugin.org

plugin.org {
  host = ' . $this->pObj->markerArray['###HOST###'] . '/
  sysfolder {
    calendar    = ' . $this->pObj->arr_pageUids['pageOrgDataCal_title'] . '
    downloads   = ' . $this->pObj->arr_pageUids['pageOrgDataDownloads_title'] . '
    event       = ' . $this->pObj->arr_pageUids['pageOrgDataEvents_title'] . '
    headquarter = ' . $this->pObj->arr_pageUids['pageOrgDataHeadquarters_title'] . '
    job         = ' . $this->pObj->arr_pageUids['pageOrgDataJobs_title'] . '
    location    = ' . $this->pObj->arr_pageUids['pageOrgDataLocations_title'] . '
    news        = ' . $this->pObj->arr_pageUids['pageOrgDataNews_title'] . '
    service     = ' . $this->pObj->arr_pageUids['pageOrgDataService_title'] . '
    staff       = ' . $this->pObj->arr_pageUids['pageOrgDataStaff_title'] . '
  }
  pages {
    calendar                = ' . $this->pObj->arr_pageUids['pageOrgCal_title'] . '
    downloads               = ' . $this->pObj->arr_pageUids['pageOrgDocuments_title'] . '
    downloadsCaddy          = ' . $this->pObj->arr_pageUids['pageOrgDocumentsCaddy_title'] . '
    downloadsCaddyCaddymini = ' . $this->pObj->arr_pageUids['pageOrgDocumentsCaddyCaddymini_title'] . '
    event                   = ' . $this->pObj->arr_pageUids['pageOrgCalEvents_title'] . '
    headquarter             = ' . $this->pObj->arr_pageUids['pageOrgHeadquarters_title'] . '
    job                     = ' . $this->pObj->arr_pageUids['pageOrgJobs_title'] . '
    jobApply                = ' . $this->pObj->arr_pageUids['pageOrgJobsApply_title'] . '
    location                = ' . $this->pObj->arr_pageUids['pageOrgCalLocations_title'] . '
    news                    = ' . $this->pObj->arr_pageUids['pageOrgNews_title'] . '
    service                 = ' . $this->pObj->arr_pageUids['pageOrgService_title'] . '
    shopping_cart           = ' . $this->pObj->arr_pageUids['pageOrgCalCaddy_title'] . '
    shopping_cart_downloads = ' . $this->pObj->arr_pageUids['pageOrgDocumentsCaddy_title'] . '
    staff                   = ' . $this->pObj->arr_pageUids['pageOrgStaff_title'] . '
  }
  url {
    default {
      calendar        = /
      caddy           = ' . $this->pObj->pi_getLL('pageOrgCalCaddy_titleUrl') . '/
      downloadsCaddy  = ' . $this->pObj->pi_getLL('pageOrgDocumentsCaddy_titleUrl') . '/
    }
    de {
      calendar        = /
      caddy           = ' . $this->pObj->pi_getLL('pageOrgCalCaddy_titleUrl') . '/
      downloadsCaddy  = ' . $this->pObj->pi_getLL('pageOrgDocumentsCaddy_titleUrl') . '/
    }
  }
}
  // organiser



  /////////////////////////////////////////
  //
  // plugin.tx_browser_pi1

plugin.tx_browser_pi1 {
  frameworks {
    foundation {
      templating {
        components {
          navigation {
            topbar {
              name = TYPO3 Organiser
            }
          }
        }
      }
    }
  }
}
  // plugin.tx_browser_pi1


  ////////////////////////////////////////
  //
  // plugin.tx_radialsearch_pi1

plugin.tx_radialsearch_pi1 {
  radiusbox {
    options = 50, 100, 500,1000,8000
  }
}
  // plugin.tx_radialsearch_pi1



  ////////////////////////////////////////
  //
  // plugin.tx_seodynamictag

plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|calendarUid > 0] && [globalVar = TSFE:id = ' . $pid . '
    }
  }
}
  // plugin.tx_seodynamictag
';

    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $html5conf = 'doctype                                 = xhtml_strict';
        break;
      default:
        $html5conf = 'doctype                                 = html5
xmlprologue                             = none';
        break;
    }

    switch ($GLOBALS['TSFE']->lang)
    {
      case('de'):
        $localeAll = 'de_DE';
        break;
      default:
        $localeAll = 'en_GB';
        break;
    }

    $record['config'] = '' .
            '
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // config
  // plugin.tx_caddy_pi3
  // page
  // TYPO3-Browser: ajax page object I
  // TYPO3-Browser: ajax page object II
  // jQuery


  // config
config {
  baseURL                                 = ' . t3lib_div::getIndpEnv('TYPO3_REQUEST_HOST') . '/
  tx_realurl_enable                       = 0
  //no_cache                                = 1
  language                                = ' . $GLOBALS['TSFE']->lang . '
  locale_all                              = ' . $localeAll . '
  htmlTag_langKey                         = ' . $GLOBALS['TSFE']->lang . '
  metaCharset                             = UTF-8
  ' . $html5conf . '
  xhtml_cleaning                          = all
  admPanel                                = 1
  disablePrefixComment                    = 1
  spamProtectEmailAddresses               = 5
  spamProtectEmailAddresses_atSubst       = <span style="display:none;">spamfilter</span><span class="dummy">@</span>
  spamProtectEmailAddresses_lastDotSubst  = <span style="display:none;">spamfilter</span><span class="dummy">.</span>
}
  // config



  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // plugin.tx_caddy_pi3

plugin.tx_caddy_pi3 {
  content {
    sum {
      20 {
        10 {
          data >
          value = ticket
          lang {
            de = Ticket
            en = ticket
          }
        }
        20 {
          data >
          value = tickets
          lang {
            de = Tickets
            en = tickets
          }
        }
      }
    }
  }
  _HTMLMARKER {
    linktoshop {
      10 {
        data >
        value = Tickets
        typolink {
          title {
            data >
            value = Order a ticket!
            lang {
              de = Bestell ein Ticket!
              en = Order a ticket!
            }
          }
        }
      }
    }
  }
  _LOCAL_LANG {
    default {
      caddyminiempty = Order a ticket!
    }
    de {
      caddyminiempty = Bestell ein Ticket!
    }
  }
}
  // plugin.tx_caddy_pi3



  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // page

page {
  config {
    headerComment (
        TYPO3 Organiser is brought to you by die-netzmacher.de
    )
  }
}
  // page



  ////////////////////////////////////////////////////////
  //
  // TYPO3-Browser: ajax page object I

  // Add this snippet into the setup of the TypoScript
  // template of your page.
  // Use \'page\', if the name of your page object is \'page\'
  // (this is a default but there isn\'t any rule)

[globalString = GP:tx_browser_pi1|segment=single] || [globalString = GP:tx_browser_pi1|segment=list] || [globalString = GP:tx_browser_pi1|segment=searchform]
  page >
  page < plugin.tx_browser_pi1.javascript.ajax.page
[global]
  // TYPO3-Browser: ajax page object I



  ////////////////////////////////////////////////////////
  //
  // ajax page object II

browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.default
  // Localised will be (example for German)
//browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.de

  // Example in case of localisation. Here: German has the language uid 1
//[globalVar = GP:L = 1]
//  browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.de
//  browser_ajax {
//      // Language: Configure it with the Constant Editor.
//      //   See: plugin.tx_browser_pi1.typeNum.sys_language_de
//      // Or configure here
//      //   config.sys_language_uid = YOUR_LANGUAGE_ID
//  }
//[global]
  // ajax page object II



  ////////////////////////////////////////////////////////
  //
  // jQuery

  // Please use t3jquery!
page {
  includeJSFooterlibs {
    baseorgJquery >
    browserJquery >
  }
}
  // jQuery

';

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrg_caseOrgOnly( )
   *
   * @param	[type]		$$uid: ...
   * @return	array		$record : the TypoScript record
   * @access private
   * @version 3.0.0
   * @since   3.0.0
   */
  private function pageOrg_caseOrgOnly($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);

    $title = strtolower($GLOBALS['TSFE']->page['title']);
    $title = str_replace(' ', null, $title);
    $title = 'page_' . $title . '_' . $strUid;
    $pid = $GLOBALS['TSFE']->id;

    $this->pObj->str_tsRoot = $title;
    $this->pObj->arr_tsUids[$this->pObj->str_tsRoot] = $uid;

    $record['title'] = $title;
    $record['uid'] = $uid;
    $record['pid'] = $pid;
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['sitetitle'] = $this->pObj->markerArray['###WEBSITE_TITLE###'];
    $record['root'] = 0;
    $record['clear'] = 0;  // Clear nothing
    $record['include_static_file'] = ''
            . 'EXT:radialsearch/static/,'
            . 'EXT:radialsearch/static/properties/de/,'
            . 'EXT:browser/Configuration/TypoScript/,'
            . 'EXT:caddy/Configuration/TypoScript/Basis/,'
            . 'EXT:caddy/Configuration/TypoScript/Foundation/5x/,'      // #61867, 140925, dwildt, 1+
            . 'EXT:caddy/Configuration/TypoScript/Properties/de/,'
            . 'EXT:caddy/Configuration/TypoScript/Foundation/5x/Css,'  // #61867, 140925, dwildt, 1+
            //. 'EXT:caddy/Configuration/TypoScript/Css/,'              // #61867, 140925, dwildt, 1-
            . 'EXT:linkhandler/static/link_handler/,'
            . 'EXT:flipit/static/,'
            . '%flipit46%'
            . '%flipit61%'
            . 'EXT:seo_dynamic_tag/static/,'
            . 'EXT:org/Configuration/TypoScript/base/,'
    ;
    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $include = $record['include_static_file'];
        $include = str_replace('%flipit46%', 'EXT:flipit/static/typo3/4.6/,', $include);
        $include = $include . ',EXT:org/Configuration/TypoScript/base/typo3/4.6/';
        $record['include_static_file'] = $include;
        break;
      default:
        $include = $record['include_static_file'];
        $include = str_replace('%flipit46%', null, $include);
        $record['include_static_file'] = $include;
        break;
    }
    switch (true)
    {
      case( $this->pObj->get_typo3Version() >= 6000000 ):
        $include = $record['include_static_file'];
        $include = str_replace('%flipit61%', 'EXT:flipit/static/woFancybox/,', $include);
        $record['include_static_file'] = $include;
        break;
      default:
        $include = $record['include_static_file'];
        $include = str_replace('%flipit61%', null, $include);
        $record['include_static_file'] = $include;
        break;
    }
    $record['includeStaticAfterBasedOn'] = 1;
    $record['constants'] = '

  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.org
  // plugin.tx_radialsearch_pi1
  // plugin.tx_seodynamictag_pi1



  /////////////////////////////////////////
  //
  // plugin.org

plugin.org {
  host = ' . $this->pObj->markerArray['###HOST###'] . '/
  sysfolder {
    calendar    = ' . $this->pObj->arr_pageUids['pageOrgDataCal_title'] . '
    downloads   = ' . $this->pObj->arr_pageUids['pageOrgDataDownloads_title'] . '
    event       = ' . $this->pObj->arr_pageUids['pageOrgDataEvents_title'] . '
    headquarter = ' . $this->pObj->arr_pageUids['pageOrgDataHeadquarters_title'] . '
    job         = ' . $this->pObj->arr_pageUids['pageOrgDataJobs_title'] . '
    location    = ' . $this->pObj->arr_pageUids['pageOrgDataLocations_title'] . '
    news        = ' . $this->pObj->arr_pageUids['pageOrgDataNews_title'] . '
    service     = ' . $this->pObj->arr_pageUids['pageOrgDataService_title'] . '
    staff       = ' . $this->pObj->arr_pageUids['pageOrgDataStaff_title'] . '
  }
  pages {
    calendar                = ' . $this->pObj->arr_pageUids['pageOrgCal_title'] . '
    downloads               = ' . $this->pObj->arr_pageUids['pageOrgDocuments_title'] . '
    downloadsCaddy          = ' . $this->pObj->arr_pageUids['pageOrgDocumentsCaddy_title'] . '
    downloadsCaddyCaddymini = ' . $this->pObj->arr_pageUids['pageOrgDocumentsCaddyCaddymini_title'] . '
    event                   = ' . $this->pObj->arr_pageUids['pageOrgCalEvents_title'] . '
    headquarter             = ' . $this->pObj->arr_pageUids['pageOrgHeadquarters_title'] . '
    job                     = ' . $this->pObj->arr_pageUids['pageOrgJobs_title'] . '
    jobApply                = ' . $this->pObj->arr_pageUids['pageOrgJobsApply_title'] . '
    location                = ' . $this->pObj->arr_pageUids['pageOrgCalLocations_title'] . '
    news                    = ' . $this->pObj->arr_pageUids['pageOrgNews_title'] . '
    service                 = ' . $this->pObj->arr_pageUids['pageOrgService_title'] . '
    shopping_cart           = ' . $this->pObj->arr_pageUids['pageOrgCalCaddy_title'] . '
    shopping_cart_downloads = ' . $this->pObj->arr_pageUids['pageOrgDocumentsCaddy_title'] . '
    staff                   = ' . $this->pObj->arr_pageUids['pageOrgStaff_title'] . '
  }
  url {
    default {
      calendar        = /
      caddy           = ' . $this->pObj->pi_getLL('pageOrgCalCaddy_titleUrl') . '/
      downloadsCaddy  = ' . $this->pObj->pi_getLL('pageOrgDocumentsCaddy_titleUrl') . '/
    }
    de {
      calendar        = /
      caddy           = ' . $this->pObj->pi_getLL('pageOrgCalCaddy_titleUrl') . '/
      downloadsCaddy  = ' . $this->pObj->pi_getLL('pageOrgDocumentsCaddy_titleUrl') . '/
    }
  }
}
  // organiser



  ////////////////////////////////////////
  //
  // plugin.tx_radialsearch_pi1

plugin.tx_radialsearch_pi1 {
  radiusbox {
    options = 50, 100, 500,1000,8000
  }
}
  // plugin.tx_radialsearch_pi1



  ////////////////////////////////////////
  //
  // plugin.tx_seodynamictag

plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|calendarUid > 0] && [globalVar = TSFE:id = ' . $pid . '
    }
  }
}
  // plugin.tx_seodynamictag
';

    $record['config'] = '' .
            '
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // page
  // TYPO3-Browser: ajax page object I
  // TYPO3-Browser: ajax page object II



  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // page (default)

page {
  config {
    headerComment (
        TYPO3 Organiser is brought to you by die-netzmacher.de
    )
  }
}
  // page (default)



  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // page (AJAX)

[globalString = GP:tx_browser_pi1|segment=single] || [globalString = GP:tx_browser_pi1|segment=list] || [globalString = GP:tx_browser_pi1|segment=searchform]
  page >
  page < plugin.tx_browser_pi1.javascript.ajax.page
[global]
  // page (AJAX)



  ////////////////////////////////////////////////////////
  //
  // ajax page object II

browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.default
  // Localised will be (example for German)
//browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.de

  // Example in case of localisation. Here: German has the language uid 1
//[globalVar = GP:L = 1]
//  browser_ajax < plugin.tx_browser_pi1.javascript.ajax.jQuery.de
//  browser_ajax {
//      // Language: Configure it with the Constant Editor.
//      //   See: plugin.tx_browser_pi1.typeNum.sys_language_de
//      // Or configure here
//      //   config.sys_language_uid = YOUR_LANGUAGE_ID
//  }
//[global]
  // ajax page object II
';

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrgCalCaddy( )
   *
   * @param	[type]		$$uid: ...
   * @return	array		$record : the TypoScript record
   * @access private
   * @version 3.0.0
   * @since   3.0.0
   */
  private function pageOrgCalCaddy($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);

    $title = 'pageOrgCalCaddy_title';
    $llTitle = strtolower($this->pObj->pi_getLL($title));
    $llTitle = str_replace(' ', null, $llTitle);
    $llTitle = '+page_' . $llTitle . '_' . $strUid;

    $this->pObj->arr_tsUids[$title] = $uid;
    $this->pObj->arr_tsTitles[$uid] = $title;

    $includeStaticFile = $this->zzOrgCaddyStaticFiles();

    $record['title'] = $llTitle;
    $record['uid'] = $uid;
    $record['pid'] = $this->pObj->arr_pageUids['pageOrgCalCaddy_title'];
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = $includeStaticFile;
// Will handled by consolidation
//    $record['constants']            = null;
//    $record['config']               = null;
    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrgDocumentsCaddy( )
   *
   * @param	[type]		$$uid: ...
   * @return	array		$record : the TypoScript record
   * @access private
   * @version 3.0.0
   * @since   3.0.0
   */
  private function pageOrgDocumentsCaddy($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);
    $title = 'pageOrgDocumentsCaddy_title';
    $llTitle = strtolower($this->pObj->pi_getLL($title));
    $llTitle = str_replace(' ', null, $llTitle);
    $llTitle = '+page_' . $llTitle . '_' . $strUid;

    $this->pObj->arr_tsUids[$title] = $uid;
    $this->pObj->arr_tsTitles[$uid] = $title;

    $includeStaticFile = $this->zzOrgCaddyStaticFiles();
//    $includeStaticFile = $includeStaticFile
//            . ',EXT:powermail/Configuration/TypoScript/Main'
//            . ',EXT:caddy/Configuration/TypoScript/Powermail/2x/'
//            . ',EXT:caddy/Configuration/TypoScript/Powermail/2x/Foundation_5x/'
//    ;

    $record['title'] = $llTitle;
    $record['uid'] = $uid;
    $record['pid'] = $this->pObj->arr_pageUids['pageOrgDocumentsCaddy_title'];
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = $includeStaticFile;
// Will handled by consolidation
//    $record['constants']            = null;
//    $record['config']               = null;
    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /**
   * pageOrgDocuments( )
   *
   * @param	[type]		$$uid: ...
   * @return	array		$record : the TypoScript record
   * @access private
   * @version 3.0.0
   * @since   3.0.0
   */
  private function pageOrgDocuments($uid)
  {
    $record = null;

    $strUid = sprintf('%03d', $uid);
    $title = 'pageOrgDocuments_title';
    $llTitle = strtolower($this->pObj->pi_getLL($title));
    $llTitle = str_replace(' ', null, $llTitle);
    $llTitle = '+page_' . $llTitle . '_' . $strUid;
    $pid = $this->pObj->arr_pageUids[$title];

    $this->pObj->arr_tsUids[$title] = $uid;
    $this->pObj->arr_tsTitles[$uid] = $title;

    $includeStaticFile = 'EXT:caddy/Configuration/TypoScript/Css/red/,'
            . 'EXT:org/Configuration/TypoScript/downloads/301/,'
            . 'EXT:org/Configuration/TypoScript/downloads/301/tx_caddy/,'
            . 'EXT:org/Configuration/TypoScript/downloads/301/tx_flipit/'
    ;
    switch (true)
    {
      case( $this->pObj->get_typo3Version() >= 6000000 ):
        $includeStaticFile = $includeStaticFile
                . ',EXT:org/Configuration/TypoScript/downloads/301/tx_flipit/typo3/6.x';
        break;
      default:
        // follow the workflow
        break;
    }

    switch (true)
    {
      case( $this->pObj->get_typo3Version() < 4007000 ):
        $includeStaticFile = $includeStaticFile
                . ',EXT:org/Configuration/TypoScript/base/typo3/4.6/';
        break;
      default:
        // follow the workflow
        break;
    }

    $record['title'] = $llTitle;
    $record['uid'] = $uid;
    $record['pid'] = $pid;
    $record['tstamp'] = time();
    $record['sorting'] = 256;
    $record['crdate'] = time();
    $record['cruser_id'] = $this->pObj->markerArray['###BE_USER###'];
    $record['include_static_file'] = $includeStaticFile;
    $record['constants'] = '
  /////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.baseorg
  // plugin.caddy
  // plugin.tx_flipit
  // plugin.tx_seodynamictag



  /////////////////////////////////////////
  //
  // plugin.baseorg

plugin.baseorg {
  pages {
    root {
      caddymini = ' . $this->pObj->arr_pageUids['pageOrgDocumentsCaddyCaddymini_title'] . '
    }
  }
}
  // plugin.baseorg



  /////////////////////////////////////////
  //
  // plugin.caddy

plugin.caddy {
  pages {
    caddy       = ' . $this->pObj->arr_pageUids['pageOrgDocumentsCaddy_title'] . '
    caddymini   = ' . $this->pObj->arr_pageUids['pageOrgDocumentsCaddyCaddymini_title'] . '
    revocation  = ' . $this->pObj->arr_pageUids['pageOrgDocumentsRevocation_title'] . '
    shop        = ' . $this->pObj->arr_pageUids['pageOrgDocuments_title'] . '
    terms       = ' . $this->pObj->arr_pageUids['pageOrgDocumentsTerms_title'] . '
  }
  url {
    showUid = downloadsUid
  }
}
  // plugin.caddy



  /////////////////////////////////////////
  //
  // plugin.tx_flipit

plugin.tx_flipit {
  configuration {
    layout = layout_01
  }
  jquery {
      // jQuery is delivered by tx_browser_pi1 or t3jQuery
    source            = disabled
    fancyboxPosition  = bottom
  }
}
  // plugin.tx_flipit



  /////////////////////////////////////////
  //
  // plugin.tx_seodynamictag

plugin.tx_seodynamictag {
  condition {
    single {
      begin = globalVar = GP:tx_browser_pi1|downloadsUid > 0] && [globalVar = TSFE:id = ' . $pid . '
    }
  }
}
  // plugin.tx_seodynamictag
';
    $record['config'] = '
  ////////////////////////////////////////////////////////
  //
  // INDEX
  //
  // plugin.tx_caddy_pi3



  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // plugin.tx_caddy_pi3

plugin.tx_caddy_pi3 {
  content {
    sum {
      20 {
        10 {
          data >
          value = Item
          lang {
            de = Artikel
            en = Item
          }
        }
        20 {
          data >
          value = Items
          lang {
            de = Artikel
            en = Items
          }
        }
      }
    }
  }
  _HTMLMARKER {
    linktoshop {
      10 {
        data >
        value = Order an item
        lang {
          de = Artikel bestellen
          en = Order an item
        }
        typolink {
          title {
            data >
            value = Order an item!
            lang {
              de = Bestell einen Artikel!
              en = Order an item!
            }
          }
        }
      }
    }
  }
  _LOCAL_LANG {
    default {
      caddyminiempty = Order an item!
    }
    de {
      caddyminiempty = Bestell einen Artikel!
    }
  }
}
  // plugin.tx_caddy_pi3
';

    $record['description'] = '// Created by ORGANISER INSTALLER at ' . date('Y-m-d G:i:s');

    return $record;
  }

  /*   * *********************************************
   *
   * Sql
   *
   * ******************************************** */

  /**
   * sqlInsert( )
   *
   * @param	array		$records : TypoScript records for pages
   * @return	void
   * @access private
   * @version 3.0.0
   * @since   3.0.0
   */
  private function sqlInsert($records)
  {
    foreach ($records as $record)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $record, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery('sys_template', $record);
      $error = $GLOBALS['TYPO3_DB']->sql_error();

      if ($error)
      {
        $query = $GLOBALS['TYPO3_DB']->INSERTquery('sys_template', $record);
        $prompt = 'SQL-ERROR<br />' . PHP_EOL .
                'query: ' . $query . '.<br />' . PHP_EOL .
                'error: ' . $error . '.<br />' . PHP_EOL .
                'Sorry for the trouble.<br />' . PHP_EOL .
                'TYPO3-Organiser Installer<br />' . PHP_EOL .
                __METHOD__ . ' (' . __LINE__ . ')';
        die($prompt);
      }

      // prompt
      $pageTitle = $this->pObj->arr_pageTitles[$record['pid']];
      $pageTitle = $this->pObj->pi_getLL($pageTitle);
      $marker['###TITLE###'] = $record['title'];
      $marker['###UID###'] = $record['uid'];
      $marker['###TITLE_PID###'] = '"' . $pageTitle . '" (uid ' . $record['pid'] . ')';
      $prompt = '
        <p>
          ' . $this->pObj->arr_icons['ok'] . ' ' . $this->pObj->pi_getLL('ts_create_prompt') . '
        </p>';
      $prompt = $this->pObj->cObj->substituteMarkerArray($prompt, $marker);
      $this->pObj->arrReport[] = $prompt;
      // prompt
    }
  }

  /*   * *********************************************
   *
   * ZZ - Helper
   *
   * ******************************************** */

  /**
   * zzOrgCaddyConfig( )
   *
   * @return	string		$staticFiles  : the list of static files
   * @access private
   * @version 3.0.0
   * @since   3.0.0
   */
  private function zzOrgCaddyConfig()
  {
    $config = null;

    switch (true)
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die($prompt);
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $config = $this->zzOrgCaddyConfigPowermail1x();
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $config = $this->zzOrgCaddyConfigPowermail2x();
        break;
      case( $this->pObj->powermailVersionInt >= 3000000 ):
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is 3.x: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die($prompt);
        break;
    }

    return $config;
  }

  /**
   * zzOrgCaddyConfigPowermail1x( )
   *
   * @return	string		$config  : the list of static files
   * @access private
   * @version 3.0.0
   * @since   3.0.0
   */
  private function zzOrgCaddyConfigPowermail1x()
  {
    $config = '
  ////////////////////////////////////////
  //
  // plugin.tx_powermail_pi1

plugin.tx_powermail_pi1 {
  _LOCAL_LANG {
    de {
      locallangmarker_confirmation_submit = Anmelden
    }
  }
}
  // plugin.tx_powermail_pi1
';

    return $config;
  }

  /**
   * zzOrgCaddyConfigPowermail2x( )
   *
   * @return	string		$config  : the list of static files
   * @access private
   * @version 3.0.0
   * @since   3.0.0
   */
  private function zzOrgCaddyConfigPowermail2x()
  {
    // 130721, dwildt: powermail 2.x without an ending slash!
    $config = '
plugin.tx_powermail {
  _LOCAL_LANG {
    default {
      confirmation_next = Order without commitment
    }
    de {
      confirmation_next = Unverbindlich testen
    }
  }
}
';

    return $config;
  }

  /**
   * zzOrgCaddyStaticFiles( )
   *
   * @return	string		$staticFiles  : the list of static files
   * @access private
   * @version 3.0.0
   * @since   3.0.0
   */
  private function zzOrgCaddyStaticFiles()
  {
    $staticFiles = null;

    switch (true)
    {
      case( $this->pObj->powermailVersionInt < 1000000 ):
        $prompt = 'ERROR: unexpected result<br />
          powermail version is below 1.0.0: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die($prompt);
        break;
      case( $this->pObj->powermailVersionInt < 2000000 ):
        $staticFiles = $this->zzOrgCaddyStaticFilesPowermail1x();
        break;
      case( $this->pObj->powermailVersionInt < 3000000 ):
        $staticFiles = $this->zzOrgCaddyStaticFilesPowermail2x();
        break;
      case( $this->pObj->powermailVersionInt >= 3000000 ):
      default:
        $prompt = 'ERROR: unexpected result<br />
          powermail version is 3.x: ' . $this->pObj->powermailVersionInt . '<br />
          Method: ' . __METHOD__ . ' (line ' . __LINE__ . ')<br />
          TYPO3 extension: ' . $this->extKey;
        die($prompt);
        break;
    }

    return $staticFiles;
  }

  /**
   * zzOrgCaddyStaticFilesPowermail1x( )
   *
   * @return	string		$staticFiles  : the list of static files
   * @access private
   * @version 6.0.0
   * @since   3.0.0
   */
  private function zzOrgCaddyStaticFilesPowermail1x()
  {
    $staticFiles = 'EXT:powermail/static/pi1/'
            . ',EXT:caddy/Configuration/TypoScript/Powermail/1x/'
    ;

    return $staticFiles;
  }

  /**
   * zzOrgCaddyStaticFilesPowermail2x( )
   *
   * @return	string		$staticFiles  : the list of static files
   * @access private
   * @version 6.0.0
   * @since   3.0.0
   */
  private function zzOrgCaddyStaticFilesPowermail2x()
  {
    // 130721, dwildt: powermail 2.x without an ending slash!
    $staticFiles = ''
            . 'EXT:powermail/Configuration/TypoScript/Main'
            . ',EXT:caddy/Configuration/TypoScript/Powermail/2x/'
            . ',EXT:caddy/Configuration/TypoScript/Powermail/2x/Foundation_5x/'
    ;

    return $staticFiles;
  }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_typoscript.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1_typoscript.php']);
}