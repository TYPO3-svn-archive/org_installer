<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
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
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Organiser Installer' for the 'org_installer' extension.
 *
 * @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
 * @package    TYPO3
 * @subpackage    tx_orginstaller
 * @version 1.0.0
 */
class tx_orginstaller_pi1 extends tslib_pibase 
{
  public $prefixId      = 'tx_orginstaller_pi1';                // Same as class name
  public $scriptRelPath = 'pi1/class.tx_orginstaller_pi1.php';  // Path to this script relative to the extension dir.
  public $extKey        = 'org_installer';                      // The extension key.
  public $pi_checkCHash = true;

  
  public $conf           = false;
  // [array] The TypoScript configuration array

  private $bool_error      = false;
  // [boolean] true, if ther is any installation error.
  private $arr_piFlexform  = false;
  // [array] The flexform array
  private $arrReport       = false;
  // [array] Array with the report items
  private $arr_icons       = false;
  // [array] Array with images, wrapped as HTML <img ...>
  
  private $markerArray       = false;

  // [boolean] Is the installer page on the top level
  private $bool_topLevel     = false;

  // [array] Array with information about the used pages. Uid is the key, title is the value.
  private $arr_pageUids      = false;
  // [array] Array with information about the used pages. Title is the key, uid is the value.
  private $arr_pageTitles    = false;
  // [array] Array with information about the used sysfolders. Uid is the key, title is the value.
  private $arr_sysfUids      = false;
  // [array] Array with information about the used sysfolders. Title is the key, uid is the value.
  private $arr_sysfTitles    = false;

  // [array] Titles of the current and the generated pages records. Uids are the keys.
  private $arr_tsUids         = false;
  // [array] Uids of the generated sys_templates records
  private $str_tsRoot         = false;
  // [string] Title of the root TypoScript
  private $arr_pluginUids     = false;
  // [array] Uids of the generated tt_content records - here: plugins only
  private $arr_recordUids     = false;
  // [array] Uids of the generated records for different tables.
  private $arr_contentUids    = false;
  // [array] Uids of the generated tt_content records

    // [int] current timestamp
  private $timestamp          = null;









  /**
   * The main method of the PlugIn
   *
   * @param    string       $content: The PlugIn content
   * @param    array        $conf: The TypoScript configuration array
   * @return    The content that is displayed on the website
   */
  public function main($content, $conf)
  {

    $this->conf = $conf;


    $this->pi_loadLL();
      // Get values from the flexform
    $this->zz_getFlexValues();
      // Set the path to icons
    $this->zz_getPathToIcons();
      // Set current time
    $this->timestamp = time();
    



      //////////////////////////////////////////////////////////////////////
      //
      // Install the Organiser

    switch($this->arr_piFlexform['data']['sDEF']['lDEF']['install_case']['vDEF'])
    {
      case(null):
      case('disabled'):
        $this->install_nothing();
        break;
      case('enabled'):
        $this->install();
        break;
      default:
        $this->arrReport[] = '
          <p>
            switch in ' . __METHOD__ . ' has an undefined value: ' . 
            $this->arr_piFlexform['data']['sDEF']['lDEF']['install_case']['vDEF'] . '
          </p>';
    }
      // Install the Organiser



      //////////////////////////////////////////////////////////////////////
      //
      // Error
      
    if($this->bool_error)
    {
      $str_result = '
        <div style="border:4px solid red;padding:2em;">
          <h1>
           '.$this->pi_getLL('error_all_h1').'
          </h1>
          '.$this->htmlReport().'
        </div>';
    }
      // Error



      //////////////////////////////////////////////////////////////////////
      //
      // RETURN the result
      
    $str_result = $this->htmlReport();
    return $this->pi_wrapInBaseClass($str_result);
      // RETURN the result
  }














  /**
   * Shop will be installed without template
   *
   * @return    The content that is displayed on the website
   */
  private function install_nothing()
  {
     $this->arrReport[] = '
       <p>
         '.$this->arr_icons['warn'].$this->pi_getLL('plugin_warn').'<br />
         '.$this->arr_icons['info'].$this->pi_getLL('plugin_help').'
       </p>';
    $this->bool_error = true;
  }














  /**
   * Shop will be installed without template
   *
   * @return    The content that is displayed on the website
   */
  private function htmlReport()
  {
    if(!is_array($this->arrReport))
    {
      $str_errorPrompt = '
        <h1>
          No Report
        </h1>
        <p>
          This is a mistake!
        </p>';
      return $str_errorPrompt;
    }

    $arrReport = array();
    if(!$this->bool_error)
    {
      if(!$this->piVars['confirm'])
      {
        $arrReport[] = '
          <h1>
            '.$this->pi_getLL('begin_h1').'
          </h1>';
      }
      if($this->piVars['confirm'])
      {
        $arrReport[] = '
          <h1>
            '.$this->pi_getLL('end_h1').'
          </h1>';
      }
    }
    $arrReport = array_merge($arrReport, $this->arrReport);
    $str_result = implode('', $arrReport);

    return $str_result;
  }














  /**
   * Shop will be installed - with or without template
   *
   * @param    string       $str_installCase: install_all or install_shop
   * @return    The content that is displayed on the website
   */
   
  //http://forge.typo3.org/issues/9632
  //private function install($str_installCase)
  private function install()
  {
    
      ////////////////////////////////////////////////
      //
      // RETURN one extension is missing

    $this->checkExtensions();
    if($this->bool_error)
    {
      return;
    }
      // RETURN one extension is missing



      ////////////////////////////////////////////////
      //
      // RETURN a condition failes

    $this->checkConditions();
    if($this->bool_error)
    {
      return;
    }
      // RETURN a condition failes



      ////////////////////////////////////////////////
      //
      // RETURN form isn't confirmed

    $bool_confirm = $this->confirmation();
    if(!$bool_confirm)
    {
      return;
    }
      // RETURN form isn't confirmed



    $this->init_boolTopLevel();
    $this->createBeGroup();
    $this->createPages();
    $this->createTyposcript();
    $this->createPlugins();
    $this->createRecordsPowermail();
    $this->createContent();
    $this->createRecordsOrganiser();
    $this->createFilesFeUser();
    $this->createFilesOrganiser();
    $this->consolidatePageCurrent();
    $this->consolidatePluginPowermail();
    $this->consolidateTsWtCart();
    
    $this->promptCleanUp();

    return false;
  }














  /**
   * confirmation(): Get the initial confirmation form
   *
   * @return    boolean   true: form is confirmed, false: form has to be confirmed
   */
  private function confirmation()
  {
      // RETURN form is confirmed
    if($this->piVars['confirm'])
    {
      return true;
    }
      // RETURN form is confirmed



      // Get the cHash. Important in case of realUrl and no_cache=0
    $cHash_calc = $this->get_cHash('&tx_orginstaller_pi1[confirm]=1');

      // Confirmation form
    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('confirm_header').'
      </h2>
      <p>
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createBeGroup').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createPages').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createPlugins').'<br />
      ';
      $this->arrReport[] = '
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createTs').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createPowermail').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createOrganiser').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createFiles').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_createContent').'<br />
        '.$this->arr_icons['info'].$this->pi_getLL('confirm_prompt_consolidate').'<br />
      </p>
      <div style="text-align:right">
        <form name="form_confirm" method="POST">
          <fieldset id="fieldset_confirm" style="border:1px solid #F66800;padding:1em;">
            <legend style="color:#F66800;font-weight:bold;padding:0 1em;">
              '.$this->pi_getLL('confirm_header').'
            </legend>
            <input type="hidden" name="tx_orginstaller_pi1[confirm]" value="1" />
            <input type="hidden" name="cHash"                              value="'.$cHash_calc.'" />
            <input type="submit" name="submit" value=" '.$this->pi_getLL('confirm_button').' " />
          </fieldset>
        </form>
      </div>
    ';
      // Confirmation form

    return false;
  }










  /**
   * checkExtensions(): Check for needed extensions
   *
   * @param    string       $str_installCase: install_all or install_shop
   * @return    The content that is displayed on the website
   */
  private function checkExtensions()
  {
      ///////////////////////////////////////////////
      //
      // RETURN  form is confirmed

    if($this->piVars['confirm'])
    {
      return false;
    }
      // RETURN  form is confirmed



      ///////////////////////////////////////////////
      //
      // prompt header

    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('ext_header').'
      </h2>
      ';
      // prompt header



      ///////////////////////////////////////////////
      //
      // needed extensions

    $i = 0;
    $arr_extensions[$i]['extKey']   = 'browser';
    $arr_extensions[$i]['extTitle'] = 'Browser - the TYPO3-Frontend-Engine (browser)';
    $i++;
    $arr_extensions[$i]['extKey']   = 'linkhandler';
    $arr_extensions[$i]['extTitle'] = 'AOE link handler (linkhandler)';
    $i++;
    $arr_extensions[$i]['extKey']   = 'org';
    $arr_extensions[$i]['extTitle'] = 'Organiser (org)';
    $i++;
    $arr_extensions[$i]['extKey']   = 'powermail';
    $arr_extensions[$i]['extTitle'] = 'Powermail (powermail)';
    $i++;
    $arr_extensions[$i]['extKey']   = 'wt_cart';
    $arr_extensions[$i]['extTitle'] = 'Shopping Cart for TYPO3 (wt_cart)';
      // needed extensions
    
    
    
      ///////////////////////////////////////////////
      //
      // LOOP extensions

    foreach($arr_extensions as $key => $arr_extension)
    {
        // extension is missing
      if(!t3lib_extMgm::isLoaded($arr_extension['extKey']))
      {
        $this->arrReport[] = '
          <p>
            ' . $this->arr_icons['error'] . $this->pi_getLL('ext_error') . '<br />
            ' . $this->arr_icons['info']  . $this->pi_getLL('ext_help')  . ' ' . $arr_extension['extTitle'] . '
          </p>';
        $this->bool_error = true;
      }

        // extension is ok
      if(t3lib_extMgm::isLoaded($arr_extension['extKey']))
      {
        $this->arrReport[] = '
          <p>
            ' . $this->arr_icons['ok'] . ' ' . $arr_extension['extTitle'] . ' ' . $this->pi_getLL('ext_ok') . '
          </p>';
      }
    }
      // LOOP extensions

  }










  /**
   * checkConditions(): Check 
   *
   * @return    boolean    true: error, false: ok 
   */
  private function checkConditions()
  {



      ///////////////////////////////////////////////
      //
      // prompt header

    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('condition_header').'
      </h2>
      ';
      // prompt header



      ///////////////////////////////////////////////
      //
      // condition "Store record configuration" 

    $confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['org']);
    switch($confArr['store_records']) 
    {
        // IN CASE OF CHANGINGS: BE AWARE OF THE ORGANISER INSTALLER!
      case('Multi grouped: record groups in different directories'):
      case('Easy 2: same as easy 1 but with storage pid'):
      case('Easy 1: all in the same directory'):
      default:
        $this->arrReport[] = '
          <p>
            ' . $this->arr_icons['warn'] . ' ' . $this->pi_getLL('condition_error') . '<br />
            ' . $this->arr_icons['info'] . ' ' . $this->pi_getLL('condition_help')  . ' ' . $this->pi_getLL('condition_help_org_clearpresented') . '
          </p>';
        $this->bool_error = false;
        break;
      case('Clear presented: each record group in one directory at most'):
        $this->arrReport[] = '
          <p>
            ' . $this->arr_icons['ok'] . ' ' . $this->pi_getLL('condition_ok_org_clearpresented') . '
          </p>';
        break;
    }
      // condition "Store record configuration" 

    $int_memory_limit = substr (ini_get('memory_limit'), 1);
    switch ($int_memory_limit)
    {
        case 'M': 
        case 'm':
          $int_memory_limit = $int_memory_limit * 1048576;
        case 'K':
        case 'k': 
          $int_memory_limit = $int_memory_limit * 1024;
        case 'G':
        case 'g':
          $int_memory_limit = $int_memory_limit * 1073741824;
        default:
          // do nothing;
    }
echo $int_memory_limit;

  }














  /**
   * createBeGroup(): Create the backend-group organiser, if it is new
   *
   * @return  void
   */
  private function createBeGroup()
  {
    $this->markerArray['###GROUP_TITLE###'] = 'organiser';



      //////////////////////////////////////////////////////////////////////
      //
      // There is a group available
  
    $select_fields = '`uid`, `title`';
    $from_table    = '`be_groups`';
    $where_clause  = '`hidden` = 0 AND `deleted` = 0 AND `title` = "organiser"';
    $groupBy       = '';
    $orderBy       = '';
    $limit         = '0,1';
    $uidIndexField = '';
    
    $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit, $uidIndexField);
    if(is_array($rows) && count($rows) > 0)
    {
      $group_uid   = $rows[0]['uid'];
      $group_title = $rows[0]['title'];
    }
    
    if($group_uid)
    {
      $this->markerArray['###GROUP_TITLE###'] = $group_title;
      $this->markerArray['###GROUP_UID###']   = $group_uid;
      
      $str_grp_prompt = '
        <h2>
         '.$this->pi_getLL('grp_ok_header').'
        </h2>
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('grp_ok_prompt').'
        </p>';
      $str_grp_prompt = $this->cObj->substituteMarkerArray($str_grp_prompt, $this->markerArray);
      $this->arrReport[] = $str_grp_prompt;
      return;
    }
      // There is a group available



      //////////////////////////////////////////////////////////////////////
      //
      // There isn't any group available
  
    $table                   = '`be_groups`';
    $fields_values['uid']    = null;
    $fields_values['pid']    = 0;
    $fields_values['tstamp'] = $this->timestamp;
    $fields_values['title']  = 'organiser';
    $fields_values['crdate'] = $this->timestamp;
    $no_quote_fields         = false;
    $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      // There isn't any group available

    $where_clause  = '`hidden` = 0 AND `deleted` = 0 AND `title` = "organiser" AND `crdate` = '.$this->timestamp.' AND `tstamp` = '.$this->timestamp;
    
    $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit, $uidIndexField);
    if(is_array($rows) && count($rows) > 0)
    {
      $group_title = $rows[0]['title'];
      $group_uid   = $rows[0]['uid'];
    }
    
    if($group_uid)
    {
      $this->markerArray['###GROUP_TITLE###'] = $group_title;
      $this->markerArray['###GROUP_UID###']   = $group_uid;
      
      $str_grp_prompt = '
        <h2>
         '.$this->pi_getLL('grp_create_header').'
        </h2>
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('grp_create_prompt').'
        </p>';
      $str_grp_prompt = $this->cObj->substituteMarkerArray($str_grp_prompt, $this->markerArray);
      $this->arrReport[] = $str_grp_prompt;
      return;
    }

    $this->markerArray['###GROUP_UID###'] = false;
      
    $str_grp_prompt = '
      <h2>
       '.$this->pi_getLL('grp_warn_header').'
      </h2>
      <p>
        '.$this->arr_icons['warn'].' '.$this->pi_getLL('grp_warn_prompt').'
      </p>';
    $str_grp_prompt = $this->cObj->substituteMarkerArray($str_grp_prompt, $this->markerArray);
    $this->arrReport[] = $str_grp_prompt;
  }














  /**
   * Shop will be installed - with or without template
   *
   * @param    string       $str_installCase: install_all or install_shop
   * @return    The content that is displayed on the website
   */
  private function createPages()
  {
    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('page_create_header').'
      </h2>';



      //////////////////////////////////////////////////////////////////////
      //
      // General Values
  
    $str_date        = date('Y-m-d G:i:s');
    $table           = 'pages';
    $no_quote_fields = false;
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General Values



      //////////////////////////////////////////////////////////////////////
      //
      // Pages top level

    $this->arr_pageUids[$this->pi_getLL('page_title_calendar')] = $GLOBALS['TSFE']->id;
    $this->arr_pageTitles[$GLOBALS['TSFE']->id] = $this->pi_getLL('page_title_calendar');
      // Pages top level



      //////////////////////////////////////////////////////////////////////
      //
      // Pages first level
  
      // News
    $int_uid = $int_uid + 1;
    $arr_pages[$int_uid]['uid']           = $int_uid;
    $arr_pages[$int_uid]['pid']           = $GLOBALS['TSFE']->id;
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('page_title_news');
    $arr_pages[$int_uid]['dokType']       = 1;  // 1: page
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 1;
    $this->arr_pageUids[$this->pi_getLL('page_title_news')] = $int_uid;
    $this->arr_pageTitles[$int_uid] = $this->pi_getLL('page_title_news');
      // News

      // Staff
    $int_uid = $int_uid + 1;
    $arr_pages[$int_uid]['uid']           = $int_uid;
    $arr_pages[$int_uid]['pid']           = $GLOBALS['TSFE']->id;
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('page_title_staff');
    $arr_pages[$int_uid]['dokType']       = 1;  // 1: page
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 2;
    $this->arr_pageUids[$this->pi_getLL('page_title_staff')] = $int_uid;
    $this->arr_pageTitles[$int_uid] = $this->pi_getLL('page_title_staff');
      // Staff

      // Headquarters
    $int_uid = $int_uid + 1;
    $arr_pages[$int_uid]['uid']           = $int_uid;
    $arr_pages[$int_uid]['pid']           = $GLOBALS['TSFE']->id;
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('page_title_headquarters');
    $arr_pages[$int_uid]['dokType']       = 1;  // 1: page
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 3;
    $this->arr_pageUids[$this->pi_getLL('page_title_headquarters')] = $int_uid;
    $this->arr_pageTitles[$int_uid] = $this->pi_getLL('page_title_headquarters');
      // Headquarters

      // Locations
    $int_uid = $int_uid + 1;
    $arr_pages[$int_uid]['uid']           = $int_uid;
    $arr_pages[$int_uid]['pid']           = $GLOBALS['TSFE']->id;
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('page_title_locations');
    $arr_pages[$int_uid]['dokType']       = 1;  // 1: page
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 4;
    $this->arr_pageUids[$this->pi_getLL('page_title_locations')] = $int_uid;
    $this->arr_pageTitles[$int_uid] = $this->pi_getLL('page_title_locations');
      // Locations

      // Tickets
    $int_uid = $int_uid + 1;
    $arr_pages[$int_uid]['uid']           = $int_uid;
    $arr_pages[$int_uid]['pid']           = $GLOBALS['TSFE']->id; 
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('page_title_tickets');
    $arr_pages[$int_uid]['dokType']       = 1;  // 1: page
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 5;
    $this->arr_pageUids[$this->pi_getLL('page_title_tickets')] = $int_uid;
    $this->arr_pageTitles[$int_uid] = $this->pi_getLL('page_title_tickets');
      // Tickets

      // Terms and Conditions
    $int_uid = $int_uid + 1;
    $arr_pages[$int_uid]['uid']           = $int_uid;
    $arr_pages[$int_uid]['pid']           = $GLOBALS['TSFE']->id;
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('page_title_terms');
    $arr_pages[$int_uid]['dokType']       = 1;  // 1: page
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 6;
    $this->arr_pageUids[$this->pi_getLL('page_title_terms')] = $int_uid;
    $this->arr_pageTitles[$int_uid] = $this->pi_getLL('page_title_terms');
      // Terms and Conditions

### SYSFOLDER

    $int_uid_organiser    = $int_uid              + 1;
    $int_uid_calendar     = $int_uid_organiser    + 1;
    $int_uid_events       = $int_uid_calendar     + 1;
    $int_uid_headquarters = $int_uid_events       + 1;
    $int_uid_locations    = $int_uid_headquarters + 1;
    $int_uid_news         = $int_uid_locations    + 1;
    $int_uid_staff        = $int_uid_news         + 1;



      // sysfolder organiser
    $int_uid = $int_uid_organiser;
    $arr_pages[$int_uid]['uid']           = $int_uid_organiser;
    $arr_pages[$int_uid]['pid']           = $GLOBALS['TSFE']->id;
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('sysfolder_title_organiser');
    $arr_pages[$int_uid]['dokType']       = 254;  // 254: sysfolder
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['module']        = 'org';
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 7;
    $arr_pages[$int_uid]['TSconfig']      = '

// Created by ORGANISER INSTALLER at '.$str_date.' -- BEGIN



  ///////////////////////////
  //
  // INDEX

  // TCEFORM
  //    organiser tables
  // LINKHANDLER
  //    mod.tx_linkhandler
  //    RTE.default.tx_linkhandler
  // TCEMAIN
  //    clearCacheCmd
  //    permissions
  // MOD
  //    web_layout



  // PID
  // [' . $int_uid_organiser . '] organiser
  //    [' . $int_uid_calendar . '] calendar
  //    [' . $int_uid_news . '] news
  //    [' . $int_uid_staff . '] staff
  //    [' . $int_uid_headquarters . '] headquarters and departments
  //    [' . $int_uid_events . '] events
  //    [' . $int_uid_locations . '] locations

  // organiser tables
TCEFORM {
  fe_users {
    tx_org_news {
      PAGE_TSCONFIG_IDLIST  = ' . $int_uid_organiser . ',' . $int_uid_news . '
      PAGE_TSCONFIG_ID      = ' . $int_uid_news . '
    }
    tx_org_department {
      PAGE_TSCONFIG_IDLIST  = ' . $int_uid_organiser . ',' . $int_uid_headquarters . '
      PAGE_TSCONFIG_ID      = ' . $int_uid_headquarters . '
    }
  }
  tx_org_cal_all_tables {
    fe_user {
      PAGE_TSCONFIG_IDLIST  = ' . $int_uid_organiser . ',' . $int_uid_staff . '
      PAGE_TSCONFIG_ID      = ' . $int_uid_staff . '
    }
    tx_org_cal {
      PAGE_TSCONFIG_IDLIST  = ' . $int_uid_organiser . ',' . $int_uid_calendar . '
      PAGE_TSCONFIG_ID      = ' . $int_uid_calendar . '
    }
    tx_org_calentrance < .tx_org_cal
    tx_org_calspecial  < .tx_org_cal
    tx_org_caltype     < .tx_org_cal
    tx_org_department {
      PAGE_TSCONFIG_IDLIST  = ' . $int_uid_organiser . ',' . $int_uid_headquarters . '
      PAGE_TSCONFIG_ID      = ' . $int_uid_headquarters . '
    }
    tx_org_departmentcat < .tx_org_department
    tx_org_event {
      PAGE_TSCONFIG_IDLIST  = ' . $int_uid_organiser . ',' . $int_uid_events . '
      PAGE_TSCONFIG_ID      = ' . $int_uid_events . '
    }
    tx_org_headquarters {
      PAGE_TSCONFIG_IDLIST  = ' . $int_uid_organiser . ',' . $int_uid_headquarters . '
      PAGE_TSCONFIG_ID      = ' . $int_uid_headquarters . '
    }
    tx_org_news {
      PAGE_TSCONFIG_IDLIST  = ' . $int_uid_organiser . ',' . $int_uid_news . '
      PAGE_TSCONFIG_ID      = ' . $int_uid_news . '
    }
    tx_org_newscat < .tx_org_news
    tx_org_location {
      PAGE_TSCONFIG_IDLIST  = ' . $int_uid_organiser . ',' . $int_uid_locations . '
      PAGE_TSCONFIG_ID      = ' . $int_uid_locations . '
    }
  }
  tx_org_cal          < .tx_org_cal_all_tables
  tx_org_calentrance  < .tx_org_cal_all_tables
  tx_org_calspecial   < .tx_org_cal_all_tables
  tx_org_caltype      < .tx_org_cal_all_tables
  tx_org_department   < .tx_org_cal_all_tables
  tx_org_department {
    manager {
      PAGE_TSCONFIG_IDLIST  = ' . $int_uid_organiser . ',' . $int_uid_staff . '
      PAGE_TSCONFIG_ID      = ' . $int_uid_staff . '
    }
    fe_users < .manager
  }
  tx_org_event        < .tx_org_cal_all_tables
  tx_org_headquarters < .tx_org_cal_all_tables
  tx_org_location     < .tx_org_cal_all_tables
  tx_org_news         < .tx_org_cal_all_tables
  tx_org_newscat      < .tx_org_cal_all_tables
}
  // organiser tables
  // TCEFORM




  /////////////////////////////////////
  //
  // LINKHANDLER

  // mod.tx_linkhandler
mod.tx_linkhandler {
  fe_users.onlyPids             = ' . $int_uid_staff . '
  tx_org_cal.onlyPids           = ' . $int_uid_calendar . '
  tx_org_department.onlyPids    = ' . $int_uid_headquarters . '
  tx_org_event.onlyPids         = ' . $int_uid_events . '
  tx_org_headquarters.onlyPids  = ' . $int_uid_headquarters . '
  tx_org_location.onlyPids      = ' . $int_uid_locations . '
  tx_org_news.onlyPids          = ' . $int_uid_news . '
}

  // Remove RTE default configuration
RTE.default.tx_linkhandler >
  // Copy configuration from mod to RTE
RTE.default.tx_linkhandler < mod.tx_linkhandler

  // LINKHANDLER



  ////////////////////////////////////////////////////////////////////////
  //
  // TCEMAIN

TCEMAIN {
  clearCacheCmd = pages
  permissions {
    // ' . $this->markerArray['###GROUP_UID###'] . ': ' . $this->markerArray['###GROUP_TITLE###'] . '
    groupid = ' . $this->markerArray['###GROUP_UID###'] . '
    group   = show,edit,delete,new,editcontent
  }
}
  // TCEMAIN
  
  
  
  ///////////////////////////
  //
  // MOD
  
mod {
  web_list {
      // Deny all tables!
    allowedNewTables = xxx
  }
}
  // MOD


// Created by ORGANISER INSTALLER at '.$str_date.' -- END

';
    $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_organiser')] = $int_uid;
    $this->arr_sysfTitles[$int_uid] = $this->pi_getLL('sysfolder_title_organiser');
      // sysfolder organiser



      // sysfolder calendar
    $int_uid = $int_uid_calendar;
    $arr_pages[$int_uid]['uid']           = $int_uid_calendar;
    $arr_pages[$int_uid]['pid']           = $int_uid_organiser;
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('sysfolder_title_calendar');
    $arr_pages[$int_uid]['dokType']       = 254;  // 254: sysfolder
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['module']        = 'org_cal';
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 1;
    $arr_pages[$int_uid]['TSconfig']      = '

// Created by ORGANISER INSTALLER at '.$str_date.' -- BEGIN



mod {
  web_list {
    allowedNewTables (
      tx_org_cal, 
      tx_org_calentrance, 
      tx_org_calspecial, 
      tx_org_caltype, 
      tx_org_tax
    )
  }
}


// Created by ORGANISER INSTALLER at '.$str_date.' -- END

';
    $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_calendar')] = $int_uid;
    $this->arr_sysfTitles[$int_uid] = $this->pi_getLL('sysfolder_title_calendar');
      // sysfolder calendar



      // sysfolder events
    $int_uid = $int_uid_events;
    $arr_pages[$int_uid]['uid']           = $int_uid_events;
    $arr_pages[$int_uid]['pid']           = $int_uid_organiser;
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('sysfolder_title_events');
    $arr_pages[$int_uid]['dokType']       = 254;  // 254: sysfolder
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['module']        = 'org_event';
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 2;
    $arr_pages[$int_uid]['TSconfig']      = '

// Created by ORGANISER INSTALLER at '.$str_date.' -- BEGIN



mod {
  web_list {
    allowedNewTables (
      tx_org_event
    )
  }
}



// Created by ORGANISER INSTALLER at '.$str_date.' -- END

';
    $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_events')] = $int_uid;
    $this->arr_sysfTitles[$int_uid] = $this->pi_getLL('sysfolder_title_events');
      // sysfolder events



      // sysfolder headquarters
    $int_uid = $int_uid_headquarters;
    $arr_pages[$int_uid]['uid']           = $int_uid_headquarters;
    $arr_pages[$int_uid]['pid']           = $int_uid_organiser;
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('sysfolder_title_headquarters');
    $arr_pages[$int_uid]['dokType']       = 254;  // 254: sysfolder
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['module']        = 'org_headq';
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 3;
    $arr_pages[$int_uid]['TSconfig']      = '

// Created by ORGANISER INSTALLER at '.$str_date.' -- BEGIN



mod {
  web_list {
    allowedNewTables (
      tx_org_headquarters,
      tx_org_department,
      tx_org_departmentcat
    )
  }
}



// Created by ORGANISER INSTALLER at '.$str_date.' -- END

';
    $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_headquarters')] = $int_uid;
    $this->arr_sysfTitles[$int_uid] = $this->pi_getLL('sysfolder_title_headquarters');
      // sysfolder headquarters



      // sysfolder locations
    $int_uid = $int_uid_locations;
    $arr_pages[$int_uid]['uid']           = $int_uid_locations;
    $arr_pages[$int_uid]['pid']           = $int_uid_organiser;
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('sysfolder_title_locations');
    $arr_pages[$int_uid]['dokType']       = 254;  // 254: sysfolder
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['module']        = 'org_locat';
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 4;
    $arr_pages[$int_uid]['TSconfig']      = '

// Created by ORGANISER INSTALLER at '.$str_date.' -- BEGIN



mod {
  web_list {
    allowedNewTables (
      tx_org_location
    )
  }
}



// Created by ORGANISER INSTALLER at '.$str_date.' -- END

';
    $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_locations')] = $int_uid;
    $this->arr_sysfTitles[$int_uid] = $this->pi_getLL('sysfolder_title_locations');
      // sysfolder locations



      // sysfolder news
    $int_uid = $int_uid_news;
    $arr_pages[$int_uid]['uid']           = $int_uid_news;
    $arr_pages[$int_uid]['pid']           = $int_uid_organiser;
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('sysfolder_title_news');
    $arr_pages[$int_uid]['dokType']       = 254;  // 254: sysfolder
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['module']        = 'org_news';
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 5;
    $arr_pages[$int_uid]['TSconfig']      = '

// Created by ORGANISER INSTALLER at '.$str_date.' -- BEGIN



mod {
  web_list {
    allowedNewTables (
      tx_org_news,
      tx_org_newscat
    )
  }
}



// Created by ORGANISER INSTALLER at '.$str_date.' -- END

';
    $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_news')] = $int_uid;
    $this->arr_sysfTitles[$int_uid] = $this->pi_getLL('sysfolder_title_news');
      // sysfolder news



      // sysfolder staff
    $int_uid = $int_uid_staff;
    $arr_pages[$int_uid]['uid']           = $int_uid_staff;
    $arr_pages[$int_uid]['pid']           = $int_uid_organiser;
    $arr_pages[$int_uid]['title']         = $this->pi_getLL('sysfolder_title_staff');
    $arr_pages[$int_uid]['dokType']       = 254;  // 254: sysfolder
    $arr_pages[$int_uid]['crdate']        = $this->timestamp;
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['perms_userid']  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_pages[$int_uid]['perms_groupid'] = $this->markerArray['###GROUP_UID###'];
    $arr_pages[$int_uid]['perms_user']    = 31; // 31: Full access
    $arr_pages[$int_uid]['perms_group']   = 31; // 31: Full access
    $arr_pages[$int_uid]['module']        = 'org_staff';
    $arr_pages[$int_uid]['urlType']       = 1;
    $arr_pages[$int_uid]['sorting']       = 256 * 6;
    $arr_pages[$int_uid]['TSconfig']      = '

// Created by ORGANISER INSTALLER at '.$str_date.' -- BEGIN



mod {
  web_list {
    allowedNewTables (
      fe_users,
      fe_groups
    )
  }
}



// Created by ORGANISER INSTALLER at '.$str_date.' -- END

';
    $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_staff')] = $int_uid;
    $this->arr_sysfTitles[$int_uid] = $this->pi_getLL('sysfolder_title_staff');
      // sysfolder staff


    foreach($arr_pages as $fields_values)
    {
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###'] = $fields_values['title'];
      $this->markerArray['###UID###']   = $fields_values['uid'];
      if($fields_values['dokType'] == 254)
      {
        $str_page_prompt = '
          <p>
            '.$this->arr_icons['ok'].' '.$this->pi_getLL('sysf_create_prompt').'
          </p>';
      }
      if($fields_values['dokType'] != 254)
      {
        $str_page_prompt = '
          <p>
            '.$this->arr_icons['ok'].' '.$this->pi_getLL('page_create_prompt').'
          </p>';
      }
      $str_page_prompt = $this->cObj->substituteMarkerArray($str_page_prompt, $this->markerArray);
      $this->arrReport[] = $str_page_prompt;
    }
    unset($arr_pages);
    // Pages first level



    return false;
  }














   /**
   * createTyposcript()
   *
   * @return    void
   * @version 1.0.0
   */
  private function createTyposcript()
  {
    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('ts_create_header').'
      </h2>';
    
    switch($GLOBALS['TSFE']->lang) 
    {
      case('de'):
        $str_locale_all = 'de_DE';
        break;
      default:
        $str_locale_all = 'en_GB';
        break;
    }
    
    
    $table           = 'sys_template';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');

    $int_uid = $this->zz_getMaxDbUid($table);

      // Root page
    $int_uid                              = $int_uid +1;
    $str_uid                              = sprintf ('%03d', $int_uid);
    $str_pageTitle                        = strtolower($GLOBALS['TSFE']->page['title']);
    $str_pageTitle                        = str_replace(' ', '', $str_pageTitle);
    $this->str_tsRoot                     = 'page_'.$str_pageTitle.'_'.$str_uid;
    $this->arr_tsUids[$this->str_tsRoot]  = $int_uid;
    
    $arr_ts[$int_uid]['uid']              = $int_uid;
    $arr_ts[$int_uid]['pid']              = $GLOBALS['TSFE']->id;
    $arr_ts[$int_uid]['tstamp']           = $this->timestamp;
    $arr_ts[$int_uid]['sorting']          = 256;
    $arr_ts[$int_uid]['crdate']           = $this->timestamp;
    $arr_ts[$int_uid]['cruser_id']        = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_ts[$int_uid]['title']            = 'page_'.$str_pageTitle.'_'.$str_uid;
    if($this->bool_topLevel)
    {
      $arr_ts[$int_uid]['sitetitle']      = 'TYPO3 Organiser';
      $arr_ts[$int_uid]['root']           = 1;
      $arr_ts[$int_uid]['clear']          = 3;  // Clear all
    }
    if(!$this->bool_topLevel)
    {
      $arr_ts[$int_uid]['root']           = 0;
      $arr_ts[$int_uid]['clear']          = 0;
    }
    $arr_ts[$int_uid]['description']          = ''.
      '// Created by ORGANISER INSTALLER at '.$str_date;
    $arr_ts[$int_uid]['include_static_file']  = ''.
      'EXT:css_styled_content/static/,'.
      'EXT:wt_cart/files/static/,'.
      'EXT:linkhandler/static/link_handler/,'.
      'EXT:browser/static/,'.
      'EXT:org/static/base/,'.
      'EXT:org/static/calendar/201/,'.
      'EXT:org/static/calendar/211/,'.
      'EXT:org/static/department/601/,'.
      'EXT:org/static/headquarters/501,'.
      'EXT:org/static/location/701,'.
      'EXT:org/static/news/401,'.
      'EXT:org/static/news/411,'.
      'EXT:org/static/shopping_cart/811/,'.
      'EXT:org/static/staff/101/,'.
      'EXT:org/static/staff/111/,'.
      'EXT:browser/pi4/static/';
    if($this->bool_topLevel)
    {
      $arr_ts[$int_uid]['config']                    = '
  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // INDEX
  // 
  // config
  // page (default)
  // page (AJAX)



  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // config

config {
  baseURL                   = ' . t3lib_div::getIndpEnv('TYPO3_REQUEST_HOST') . '/
  extTarget                 = _blank
  language                  = ' . $GLOBALS['TSFE']->lang . '
  locale_all                = ' . $str_locale_all . '
  metaCharset               = UTF-8
  doctype                   = xhtml_strict
  xhtml_cleaning            = all
  htmlTag_langKey           = '.$GLOBALS['TSFE']->lang.'

  admPanel                  = 1
  disablePrefixComment      = 1
  spamProtectEmailAddresses = 5
  spamProtectEmailAddresses_atSubst       = <span style="display:none;">spamfilter</span><span class="dummy">@</span>
  spamProtectEmailAddresses_lastDotSubst  = <span style="display:none;">spamfilter</span><span class="dummy">.</span>
}
  // config



  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // page (default)

page >
page = PAGE
page {
  config {
    headerComment (
        TYPO3 Organiser is brought to you by die-netzmacher.de
    )
  }
  typeNum = 0
  includeCSS {
    organiser = EXT:org/res/html/org.css
  }
    // menue
  10 = COA
  10 {
    wrap = <div style="text-align:center;">|</div>
    10 = TEXT
    10 {
      typolink {
        parameter = {$plugin.org.pages.calendar}
      }
    }
    11 = TEXT
    11 {
      value = |
      noTrimWrap = | | |
    }
    20 = TEXT
    20 {
      typolink {
        parameter = {$plugin.org.pages.news}
      }
    }
    21 = TEXT
    21 {
      value = |
      noTrimWrap = | | |
    }
    30 = TEXT
    30 {
      typolink {
        parameter = {$plugin.org.pages.staff}
      }
    }
    31 = TEXT
    31 {
      value = |
      noTrimWrap = | | |
    }
    40 = TEXT
    40 {
      typolink {
        parameter = {$plugin.org.pages.headquarter}
      }
    }
    41 = TEXT
    41 {
      value = |
      noTrimWrap = | | |
    }
    50 = TEXT
    50 {
      typolink {
        parameter = {$plugin.org.pages.location}
      }
    }
    51 = TEXT
    51 {
      value = |
      noTrimWrap = | | |
    }
    60 = TEXT
    60 {
      typolink {
        parameter = {$plugin.org.pages.shopping_cart}
      }
    }
    61 = TEXT
    61 {
      value = |
      noTrimWrap = | | |
    }
    70 = TEXT
    70 {
      typolink {
        parameter = {$plugin.org.pages.terms}
      }
    }
  }
    // content
  20 < styles.content.get
    // menue
  30 < .10
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
';
    }
    if(!$this->bool_topLevel)
    {
      $arr_ts[$int_uid]['config']                    = '
  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // INDEX
  // 
  // config
  // page (default)
  // page (AJAX)



  ////////////////////////////////////////////////////////////////////////////////////////////
  //
  // config

config {
  extTarget                 = _blank
  language                  = '.$GLOBALS['TSFE']->lang.'
  locale_all                = ' . $str_locale_all . '
  metaCharset               = UTF-8
  doctype                   = xhtml_strict
  xhtml_cleaning            = all
  htmlTag_langKey           = '.$GLOBALS['TSFE']->lang.'

  admPanel                  = 1
  disablePrefixComment      = 1
  spamProtectEmailAddresses = 5
  spamProtectEmailAddresses_atSubst       = <span style="display:none;">spamfilter</span><span class="dummy">@</span>
  spamProtectEmailAddresses_lastDotSubst  = <span style="display:none;">spamfilter</span><span class="dummy">.</span>
}
  // config



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
';
    }

    $arr_ts[$int_uid]['constants']           = '
plugin.org {
  sysfolder {
    calendar    = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_calendar')] . '
    department  = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_headquarters')] . '
    event       = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_events')] . '
    headquarter = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_headquarters')] . '
    location    = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_locations')] . '
    news        = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_news')] . '
    staff       = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_staff')] . '
  }
  pages {
    calendar          = ' . $this->arr_pageUids[$this->pi_getLL('page_title_calendar')] . '
    calendar_expired  = ' . $this->arr_pageUids[$this->pi_getLL('page_title_calendar')] . '
    headquarter       = ' . $this->arr_pageUids[$this->pi_getLL('page_title_headquarters')] . '
    staff             = ' . $this->arr_pageUids[$this->pi_getLL('page_title_staff')] . '
    location          = ' . $this->arr_pageUids[$this->pi_getLL('page_title_locations')] . '
    news              = ' . $this->arr_pageUids[$this->pi_getLL('page_title_news')] . '
    shopping_cart     = ' . $this->arr_pageUids[$this->pi_getLL('page_title_tickets')] . '
    terms             = ' . $this->arr_pageUids[$this->pi_getLL('page_title_terms')] . '
  }
  url {
    default {
      calendar      = /
      shopping_cart = ' . $this->pi_getLL('page_title_tickets') . '/
      terms         = ' . $this->pi_getLL('page_title_terms') . '/
    }
    de {
      calendar      = /
      shopping_cart = ' . $this->pi_getLL('page_title_tickets') . '/
      terms         = ' . $this->pi_getLL('page_title_terms') . '/
    }
  }
}
';
      // Root page



      // Cart page
    $int_uid = $int_uid +1;
    $str_uid = sprintf ('%03d', $int_uid);

    $str_pageTitle      = strtolower($this->pi_getLL('page_title_tickets'));
    $str_pageTitle      = str_replace(' ', '', $str_pageTitle);
    $this->str_tsWtCart = '+page_'.$str_pageTitle.'_'.$str_uid;
    
    $this->arr_tsUids[$this->str_tsWtCart]    = $int_uid;
    $arr_ts[$int_uid]['title']                = '+page_'.$str_pageTitle.'_'.$str_uid;
    $arr_ts[$int_uid]['uid']                  = $int_uid;
    $arr_ts[$int_uid]['pid']                  = $this->arr_pageUids[$this->pi_getLL('page_title_tickets')];
    $arr_ts[$int_uid]['tstamp']               = $this->timestamp;
    $arr_ts[$int_uid]['sorting']              = 256;
    $arr_ts[$int_uid]['crdate']               = $this->timestamp;
    $arr_ts[$int_uid]['cruser_id']            = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_ts[$int_uid]['include_static_file']  = ''.
      'EXT:org/static/shopping_cart/801/,'.
      'EXT:powermail/static/pi1/,'.
      'EXT:powermail/static/css_basic/';
    $arr_ts[$int_uid]['constants']            = '
  ////////////////////////////////////////
  //
  // Will be override by $this->consolidateTsWtCart()

';

    $arr_ts[$int_uid]['config']               = '
  ////////////////////////////////////////
  //
  // Index
  //
  // plugin.tx_wtcart_pi1
  // plugin.tx_powermail_pi1


  ////////////////////////////////////////
  //
  // plugin.tx_wtcart_pi1

plugin.tx_wtcart_pi1 {
  
  _LOCAL_LANG {
    de {
      wtcart_ll_title = Anmeldung
      wtcart_ll_price = Preis
      wtcart_ll_empty (
          Wenn Du Dich anmelden m&ouml;chtest, w&auml;hle das n&auml;chste Treffen
          <ul>
            <li>
              <a title="Anmelden!" href="{$plugin.org.url.de.calendar}">
                im Kalender &raquo;</a>
            </li>
          </ul>
          aus. Dort kannst Du Dich online anmelden.<br />
          <br />
          Es gibt keine allgemeinen Geschäftsbedingungen. Wenn Du dazu mehr wissen möchtest, klicke auf
          <ul>
            <li>
              <a title="Allgemeinen Geschäftsbedingungen" href="{$plugin.org.url.de.terms}">
                AGB &raquo;</a>.
            </li>
          </ul>
)
    }
  }
}
  // plugin.tx_wtcart_pi1
  
  

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
      // Cart page

      // LOOP insert the typoscript records
    foreach($arr_ts as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###UID###']       = $fields_values['uid'];
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_pageTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_ts_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('ts_create_prompt').'
        </p>';
      $str_ts_prompt = $this->cObj->substituteMarkerArray($str_ts_prompt, $this->markerArray);
      $this->arrReport[] = $str_ts_prompt;
    }
    unset($arr_ts);
      // LOOP insert the typoscript records
    
  }














   /**
   * createPlugins(): Add the needed plugins to tt_content
   *
   * @return    void
   * @version 1.0.0
   */
  private function createPlugins()
  {
    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('plugin_create_header').'
      </h2>';
    
    
    
      //////////////////////////////////////////////////////////////////////
      //
      // General values

    $table            = 'tt_content';
    $no_quote_fields  = false;
    $str_date         = date('Y-m-d G:i:s');
    $int_uid          = $this->zz_getMaxDbUid($table);
      // General values



      //////////////////////////////////////////////////////////////////////
      //
      // Plugin browser on current page

    $int_uid                                                          = $int_uid + 1;
    $this->arr_pluginUids[$this->pi_getLL('plugin_organiser_header')] = $int_uid;
    
    $arr_plugin[$int_uid]['uid']           = $int_uid;
    $arr_plugin[$int_uid]['pid']           = $GLOBALS['TSFE']->id;
    $arr_plugin[$int_uid]['tstamp']        = $this->timestamp;
    $arr_plugin[$int_uid]['crdate']        = $this->timestamp;
    $arr_plugin[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_plugin[$int_uid]['sorting']       = 128;
    $arr_plugin[$int_uid]['CType']         = 'list';
    $arr_plugin[$int_uid]['header']        = $this->pi_getLL('plugin_organiser_header');
    $arr_plugin[$int_uid]['pages']         = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_organiser')];
    $arr_plugin[$int_uid]['recursive']     = 250;
    $arr_plugin[$int_uid]['header_layout'] = 100;  // hidden
    $arr_plugin[$int_uid]['list_type']     = 'browser_pi1';
    $arr_plugin[$int_uid]['sectionIndex']  = 1;
    $arr_plugin[$int_uid]['pi_flexform']   = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="views">
                    <value index="vDEF">selected</value>
                </field>
                <field index="viewsHandleFromTemplateOnly">
                    <value index="vDEF">1</value>
                </field>
                <field index="viewsList">
                    <value index="vDEF">201</value>
                </field>
            </language>
        </sheet>
        <sheet index="viewList">
            <language index="lDEF">
                <field index="title">
                    <value index="vDEF">' . $this->pi_getLL('plugin_organiser_label') . '</value>
                </field>
                <field index="titleWrap">
                    <value index="vDEF">&lt;h1 class=&quot;csc-firstHeader&quot;&gt;|&lt;/h1&gt;</value>
                </field>
            </language>
        </sheet>
        <sheet index="templating">
            <language index="lDEF">
                <field index="template">
                    <value index="vDEF">EXT:org/res/html/calendar/201/default.tmpl</value>
                </field>
            </language>
        </sheet>
        <sheet index="javascript">
            <language index="lDEF">
                <field index="mode">
                    <value index="vDEF">list_and_single</value>
                </field>
                <field index="list_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="single_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="list_on_single">
                    <value index="vDEF">single</value>
                </field>
            </language>
        </sheet>
        <sheet index="socialmedia">
            <language index="lDEF">
                <field index="enabled">
                    <value index="vDEF">enabled_wi_individual_template</value>
                </field>
                <field index="tablefieldTitle_list">
                    <value index="vDEF">tx_org_cal.title</value>
                </field>
                <field index="bookmarks_list">
                    <value index="vDEF">hype</value>
                </field>
                <field index="tablefieldTitle_single">
                    <value index="vDEF">tx_org_cal.title</value>
                </field>
                <field index="bookmarks_single">
                    <value index="vDEF">hype</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';
      // Plugin browser on root page



      //////////////////////////////////////////////////////////////////////
      //
      // Plugin browser on news page

    $int_uid                                                      = $int_uid + 1;
    $this->arr_pluginUids[$this->pi_getLL('plugin_news_header')]  = $int_uid;

    $arr_plugin[$int_uid]                = $arr_plugin[$int_uid -1];
    $arr_plugin[$int_uid]['uid']         = $int_uid;
    $arr_plugin[$int_uid]['pid']         = $this->arr_pageUids[$this->pi_getLL('page_title_news')];
    $arr_plugin[$int_uid]['header']      = $this->pi_getLL('plugin_news_header');
    $arr_plugin[$int_uid]['pi_flexform'] = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="views">
                    <value index="vDEF">selected</value>
                </field>
                <field index="viewsHandleFromTemplateOnly">
                    <value index="vDEF">1</value>
                </field>
                <field index="viewsList">
                    <value index="vDEF">401</value>
                </field>
            </language>
        </sheet>
        <sheet index="viewList">
            <language index="lDEF">
                <field index="title">
                    <value index="vDEF">' . $this->pi_getLL('plugin_news_label') . '</value>
                </field>
                <field index="titleWrap">
                    <value index="vDEF">&lt;h1 class=&quot;csc-firstHeader&quot;&gt;|&lt;/h1&gt;</value>
                </field>
            </language>
        </sheet>
        <sheet index="templating">
            <language index="lDEF">
                <field index="template">
                    <value index="vDEF">EXT:org/res/html/news/401/default.tmpl</value>
                </field>
            </language>
        </sheet>
        <sheet index="javascript">
            <language index="lDEF">
                <field index="mode">
                    <value index="vDEF">list_and_single</value>
                </field>
                <field index="list_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="single_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="list_on_single">
                    <value index="vDEF">single</value>
                </field>
            </language>
        </sheet>
        <sheet index="socialmedia">
            <language index="lDEF">
                <field index="enabled">
                    <value index="vDEF">enabled_wi_individual_template</value>
                </field>
                <field index="tablefieldTitle_list">
                    <value index="vDEF">tx_org_news.title</value>
                </field>
                <field index="bookmarks_list">
                    <value index="vDEF">hype</value>
                </field>
                <field index="tablefieldTitle_single">
                    <value index="vDEF">tx_org_news.title</value>
                </field>
                <field index="bookmarks_single">
                    <value index="vDEF">hype</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';
      // Plugin browser on news page



      //////////////////////////////////////////////////////////////////////
      //
      // Plugin browser on staff page

    $int_uid                                                      = $int_uid + 1;
    $this->arr_pluginUids[$this->pi_getLL('plugin_staff_header')]  = $int_uid;

    $arr_plugin[$int_uid]                = $arr_plugin[$int_uid -1];
    $arr_plugin[$int_uid]['uid']         = $int_uid;
    $arr_plugin[$int_uid]['pid']         = $this->arr_pageUids[$this->pi_getLL('page_title_staff')];
    $arr_plugin[$int_uid]['header']      = $this->pi_getLL('plugin_staff_header');
    $arr_plugin[$int_uid]['pi_flexform'] = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="views">
                    <value index="vDEF">selected</value>
                </field>
                <field index="viewsHandleFromTemplateOnly">
                    <value index="vDEF">1</value>
                </field>
                <field index="viewsList">
                    <value index="vDEF">101</value>
                </field>
            </language>
        </sheet>
        <sheet index="viewList">
            <language index="lDEF">
                <field index="title">
                    <value index="vDEF">' . $this->pi_getLL('plugin_staff_label') . '</value>
                </field>
                <field index="titleWrap">
                    <value index="vDEF">&lt;h1 class=&quot;csc-firstHeader&quot;&gt;|&lt;/h1&gt;</value>
                </field>
            </language>
        </sheet>
        <sheet index="templating">
            <language index="lDEF">
                <field index="template">
                    <value index="vDEF">EXT:org/res/html/staff/101/default.tmpl</value>
                </field>
            </language>
        </sheet>
        <sheet index="javascript">
            <language index="lDEF">
                <field index="mode">
                    <value index="vDEF">list_and_single</value>
                </field>
                <field index="list_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="single_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="list_on_single">
                    <value index="vDEF">single</value>
                </field>
            </language>
        </sheet>
        <sheet index="socialmedia">
            <language index="lDEF">
                <field index="enabled">
                    <value index="vDEF">enabled_wi_individual_template</value>
                </field>
                <field index="tablefieldTitle_list">
                    <value index="vDEF">fe_users.name</value>
                </field>
                <field index="bookmarks_list">
                    <value index="vDEF">hype</value>
                </field>
                <field index="tablefieldTitle_single">
                    <value index="vDEF">fe_users.name</value>
                </field>
                <field index="bookmarks_single">
                    <value index="vDEF">hype</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';
      // Plugin browser on staff page



      //////////////////////////////////////////////////////////////////////
      //
      // Plugin browser on headquarters page

    $int_uid                                                      = $int_uid + 1;
    $this->arr_pluginUids[$this->pi_getLL('plugin_headquarters_header')]  = $int_uid;

    $arr_plugin[$int_uid]                = $arr_plugin[$int_uid -1];
    $arr_plugin[$int_uid]['uid']         = $int_uid;
    $arr_plugin[$int_uid]['pid']         = $this->arr_pageUids[$this->pi_getLL('page_title_headquarters')];
    $arr_plugin[$int_uid]['header']      = $this->pi_getLL('plugin_headquarters_header');
    $arr_plugin[$int_uid]['pi_flexform'] = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="views">
                    <value index="vDEF">selected</value>
                </field>
                <field index="viewsHandleFromTemplateOnly">
                    <value index="vDEF">1</value>
                </field>
                <field index="viewsList">
                    <value index="vDEF">501</value>
                </field>
            </language>
        </sheet>
        <sheet index="viewList">
            <language index="lDEF">
                <field index="title">
                    <value index="vDEF">' . $this->pi_getLL('plugin_headquarters_label') . '</value>
                </field>
                <field index="titleWrap">
                    <value index="vDEF">&lt;h1 class=&quot;csc-firstHeader&quot;&gt;|&lt;/h1&gt;</value>
                </field>
            </language>
        </sheet>
        <sheet index="templating">
            <language index="lDEF">
                <field index="template">
                    <value index="vDEF">EXT:org/res/html/headquarters/501/default.tmpl</value>
                </field>
            </language>
        </sheet>
        <sheet index="javascript">
            <language index="lDEF">
                <field index="mode">
                    <value index="vDEF">list_and_single</value>
                </field>
                <field index="list_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="single_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="list_on_single">
                    <value index="vDEF">single</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';
      // Plugin browser on headquarters page



      //////////////////////////////////////////////////////////////////////
      //
      // Plugin browser on locations page

    $int_uid                                                      = $int_uid + 1;
    $this->arr_pluginUids[$this->pi_getLL('plugin_locations_header')]  = $int_uid;

    $arr_plugin[$int_uid]                = $arr_plugin[$int_uid -1];
    $arr_plugin[$int_uid]['uid']         = $int_uid;
    $arr_plugin[$int_uid]['pid']         = $this->arr_pageUids[$this->pi_getLL('page_title_locations')];
    $arr_plugin[$int_uid]['header']      = $this->pi_getLL('plugin_locations_header');
    $arr_plugin[$int_uid]['pi_flexform'] = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="views">
                    <value index="vDEF">selected</value>
                </field>
                <field index="viewsHandleFromTemplateOnly">
                    <value index="vDEF">1</value>
                </field>
                <field index="viewsList">
                    <value index="vDEF">701</value>
                </field>
            </language>
        </sheet>
        <sheet index="viewList">
            <language index="lDEF">
                <field index="title">
                    <value index="vDEF">' . $this->pi_getLL('plugin_locations_label') . '</value>
                </field>
                <field index="titleWrap">
                    <value index="vDEF">&lt;h1 class=&quot;csc-firstHeader&quot;&gt;|&lt;/h1&gt;</value>
                </field>
            </language>
        </sheet>
        <sheet index="templating">
            <language index="lDEF">
                <field index="template">
                    <value index="vDEF">EXT:org/res/html/location/701/default.tmpl</value>
                </field>
            </language>
        </sheet>
        <sheet index="javascript">
            <language index="lDEF">
                <field index="mode">
                    <value index="vDEF">list_and_single</value>
                </field>
                <field index="list_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="single_transition">
                    <value index="vDEF">collapse</value>
                </field>
                <field index="list_on_single">
                    <value index="vDEF">single</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';
      // Plugin browser on locations page



      //////////////////////////////////////////////////////////////////////
      //
      // Plugin wtcart on cart page

    $int_uid                                                        = $int_uid + 1;
    $this->arr_pluginUids[$this->pi_getLL('plugin_tickets_header')] = $int_uid;
    
    $arr_plugin[$int_uid]['uid']           = $int_uid;
    $arr_plugin[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_tickets')];
    $arr_plugin[$int_uid]['tstamp']        = $this->timestamp;
    $arr_plugin[$int_uid]['crdate']        = $this->timestamp;
    $arr_plugin[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_plugin[$int_uid]['sorting']       = 256 * 1;
    $arr_plugin[$int_uid]['CType']         = 'list';
    $arr_plugin[$int_uid]['header']        = $this->pi_getLL('plugin_tickets_header');
    $arr_plugin[$int_uid]['list_type']     = 'wt_cart_pi1';
    $arr_plugin[$int_uid]['sectionIndex']  = 1;
      // Plugin wtcart on cart page



      //////////////////////////////////////////////////////////////////////
      //
      // Plugin powermail on cart page

    $int_uid                                                          = $int_uid +1;
    $this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')] = $int_uid;

    $arr_plugin[$int_uid]['uid']                        = $int_uid;
    $arr_plugin[$int_uid]['pid']                        = $this->arr_pageUids[$this->pi_getLL('page_title_tickets')];
    $arr_plugin[$int_uid]['tstamp']                     = $this->timestamp;
    $arr_plugin[$int_uid]['crdate']                     = $this->timestamp;
    $arr_plugin[$int_uid]['cruser_id']                  = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_plugin[$int_uid]['sorting']                    = 256 * 2;
    $arr_plugin[$int_uid]['CType']                      = 'powermail_pi1';
    $arr_plugin[$int_uid]['header']                     = $this->pi_getLL('plugin_powermail_header');
    $arr_plugin[$int_uid]['header_layout']              = 100;  // hidden
    $arr_plugin[$int_uid]['list_type']                  = '';
    $arr_plugin[$int_uid]['sectionIndex']               = 1;
    $arr_plugin[$int_uid]['tx_powermail_title']         = 'order';

    $arr_plugin[$int_uid]['tx_powermail_recipient']     = 
      $this->arr_piFlexform['data']['sDEF']['lDEF']['mail_default_sender']['vDEF'] . '
      TYPO3 Organiser';
    $arr_plugin[$int_uid]['tx_powermail_subject_r']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['mail_subject']['vDEF'];
    $arr_plugin[$int_uid]['tx_powermail_subject_s']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['mail_subject']['vDEF'];
// Will updated by $this->consolidatePluginPowermail()
//    $arr_plugin[$int_uid]['tx_powermail_sender']        = $str_sender;
//    $arr_plugin[$int_uid]['tx_powermail_sendername']    = $str_sendername;
    $arr_plugin[$int_uid]['tx_powermail_confirm']       = 1;
    $arr_plugin[$int_uid]['tx_powermail_pages']         = false;
    $arr_plugin[$int_uid]['tx_powermail_multiple']      = 0;
    $arr_plugin[$int_uid]['tx_powermail_recip_table']   = 0;
    $arr_plugin[$int_uid]['tx_powermail_recip_id']      = false;
    $arr_plugin[$int_uid]['tx_powermail_recip_field']   = false;
    $arr_plugin[$int_uid]['tx_powermail_thanks']        = $this->pi_getLL('plugin_powermail_thanks');
    $arr_plugin[$int_uid]['tx_powermail_mailsender']    = '###POWERMAIL_TYPOSCRIPT_CART###'."\n".'###POWERMAIL_ALL###';
    $arr_plugin[$int_uid]['tx_powermail_mailreceiver']  = '###POWERMAIL_TYPOSCRIPT_CART###'."\n".'###POWERMAIL_ALL###';
    $arr_plugin[$int_uid]['tx_powermail_redirect']      = false;
    $arr_plugin[$int_uid]['tx_powermail_fieldsets']     = 2;
    $arr_plugin[$int_uid]['tx_powermail_users']         = 0;
    $arr_plugin[$int_uid]['tx_powermail_preview']       = 0;
      // Plugin powermail on cart page



      //////////////////////////////////////////////////////////////////////
      //
      // LOOP insert all plugins

    foreach($arr_plugin as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###HEADER###']    = $fields_values['header'];
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_pageTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_plugin_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('plugin_create_prompt').'
        </p>';
      $str_plugin_prompt = $this->cObj->substituteMarkerArray($str_plugin_prompt, $this->markerArray);
      $this->arrReport[] = $str_plugin_prompt;
    }
    unset($arr_plugin);
      // LOOP insert all plugins



  }














   /**
   * createRecordsPowermail(): Create the records for powermail.
   *                           Records are
   *                           * fieldsets
   *                           * fields
   *
   * @return    void
   * @version 1.0.0
   */
  private function createRecordsPowermail()
  {
    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('record_create_header').'
      </h2>';
    
    
    
      //////////////////////////////////////////////////////////////////////
      //
      // General values for fieldsets
  
    $table           = 'tx_powermail_fieldsets';
    $no_quote_fields = false;
    $int_uid         = $this->zz_getMaxDbUid($table);
    $max_uid         = $int_uid;
      // General values for fieldsets



      //////////////////////////////////////////////////////////////////////
      //
      // Powermail fieldsets records in page cart
  
      // Contact Data
    $int_uid                                                                    = $int_uid + 1;
    $this->arr_recordUids['###tx_powermail_fieldsets.uid.contactData###'] = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_tickets')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_fSets_title_contactData');
    $arr_records[$int_uid]['sorting']       = 256 * 1;
    $arr_records[$int_uid]['tt_content']    = $this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')];
    $arr_records[$int_uid]['felder']        = '5';
      // Contact Data

      // Order
    $int_uid                                                              = $int_uid + 1;
    $this->arr_recordUids['###tx_powermail_fieldsets.uid.order###'] = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_tickets')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_fSets_title_order');
    $arr_records[$int_uid]['sorting']       = 256 * 2;
    $arr_records[$int_uid]['tt_content']    = $this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')];
    $arr_records[$int_uid]['felder']        = '5';
      // Order
      // Powermail fieldsets records in page cart
    
    
    
      //////////////////////////////////////////////////////////////////////
      //
      // INSERT fieldset records
  
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_pageTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // INSERT fieldset records



      //////////////////////////////////////////////////////////////////////
      //
      // General values for fields

    $table           = 'tx_powermail_fields';
    $no_quote_fields = false;
    $int_uid         = $this->zz_getMaxDbUid($table);
    $max_uid         = $int_uid;
      // General values for fields



      //////////////////////////////////////////////////////////////////////
      //
      // Powermail fields

      // first name
    $int_uid                                                                          = $int_uid + 1;
    $this->arr_recordUids['###tx_powermail_fields.uid.firstname###']  = $int_uid;

    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_tickets')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_firstname');
    $arr_records[$int_uid]['sorting']       = 256 * 1;
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids['###tx_powermail_fieldsets.uid.contactData###'];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="mandatory">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>

';
      // first name

      // Surname
    $int_uid                                                                = $int_uid + 1;
    $this->arr_recordUids['###tx_powermail_fields.uid.surname###'] = $int_uid;

    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_tickets')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_surname');
    $arr_records[$int_uid]['sorting']       = 256 * 2;
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids['###tx_powermail_fieldsets.uid.contactData###'];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="mandatory">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';
      // Surname

      // E-mail
    $int_uid                                                              = $int_uid + 1;
    $this->arr_recordUids['###tx_powermail_fields.uid.email###'] = $int_uid;

    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_tickets')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_email');
    $arr_records[$int_uid]['sorting']       = 256 * 3;
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids['###tx_powermail_fieldsets.uid.contactData###'];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="mandatory">
                    <value index="vDEF">1</value>
                </field>
                <field index="validate">
                    <value index="vDEF">validate-email</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';
      // E-mail

      // Phone
    $int_uid                                                                = $int_uid + 1;
    $this->arr_recordUids['###tx_powermail_fields.uid.phone###']   = $int_uid;

    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_tickets')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_phone');
    $arr_records[$int_uid]['sorting']       = 256 * 4;
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids['###tx_powermail_fieldsets.uid.contactData###'];
    $arr_records[$int_uid]['formtype']      = 'text';
    $arr_records[$int_uid]['flexform']      = false;
      // Phone

      // Note
    $int_uid                                                              = $int_uid + 1;
    $this->arr_recordUids['###tx_powermail_fields.uid.note###']  = $int_uid;
    
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_tickets')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_note');
    $arr_records[$int_uid]['sorting']       = 256 * 5;
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids['###tx_powermail_fieldsets.uid.contactData###'];
    $arr_records[$int_uid]['formtype']      = 'textarea';
    $arr_records[$int_uid]['flexform']      = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="cols">
                    <value index="vDEF">50</value>
                </field>
                <field index="rows">
                    <value index="vDEF">5</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>

';
      // Note

      // Terms and Conditions
    $int_terms = $this->arr_pageUids[$this->pi_getLL('page_title_terms')];
    $str_terms = htmlspecialchars($this->pi_getLL('phrases_powermail_termsAccepted'));
    $str_terms = str_replace('###PID###', $int_terms, $str_terms);

    $int_uid                                                              = $int_uid + 1;
    $this->arr_recordUids['###tx_powermail_fields.uid.terms###'] = $int_uid;

    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_tickets')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_terms');
    $arr_records[$int_uid]['sorting']       = 256 * 6;
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids['###tx_powermail_fieldsets.uid.order###'];
    $arr_records[$int_uid]['formtype']      = 'check';
    $arr_records[$int_uid]['flexform']      = ''.
'<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
                <field index="options">
                    <value index="vDEF">'.$str_terms.'</value>
                </field>
                <field index="mandatory">
                    <value index="vDEF">1</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>
';
      // Terms and Conditions

      // Submit
    $int_uid                                                                = $int_uid + 1;
    $this->arr_recordUids['###tx_powermail_fields.uid.submit###']  = $int_uid;

    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_pageUids[$this->pi_getLL('page_title_tickets')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_pm_field_title_submit');
    $arr_records[$int_uid]['sorting']       = 256 * 7;
    $arr_records[$int_uid]['fieldset']      = $this->arr_recordUids['###tx_powermail_fieldsets.uid.order###'];
    $arr_records[$int_uid]['formtype']      = 'submit';
    $arr_records[$int_uid]['flexform']      = '';
      // Submit
      // Powermail fields records in page cart - for fieldset order



      //////////////////////////////////////////////////////////////////////
      //
      // INSERT field records
  
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_pageTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // INSERT field records

  }









   /**
   * createRecordsOrganiser(): Insert records into tx_org_xx tables
   *
   * @return    void
   * @version 1.0.0
   */
  private function createRecordsOrganiser()
  {
    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('record_create_header').'
      </h2>';
    
    
    
      // order of methods is important:
      // categories have be handled before records!
    $this->createRecords_categories_sysfolder_calendar();
    $this->createRecords_categories_sysfolder_headquarters();
    $this->createRecords_categories_sysfolder_news();
    $this->createRecords_categories_sysfolder_staff();

      // order of methods is important!
    $this->createRecords_records_sysfolder_staff();
    $this->createRecords_records_sysfolder_calendar();
    $this->createRecords_records_sysfolder_headquarters();
    $this->createRecords_records_sysfolder_locations();
    $this->createRecords_records_sysfolder_news();

    $this->createRecords_records_mm();
  }










   /**
   * createRecords_categories_sysfolder_calendar(): 
   *                      Adds category records with pid of the sysfolder calendar
   *                      Tables are
   *                      * tx_org_calentrance
   *                      * tx_org_caltype
   *                      * tx_org_tax
   *
   * @return    void
   * @version 1.0.0
   */
  private function createRecords_categories_sysfolder_calendar()
  {
      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_calentrance

      // General values
    $table           = 'tx_org_calentrance';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values

      // entranceFree
    $int_uid                            = $int_uid + 1;
    $this->arr_recordUids['###tx_org_calentrance.uid.entranceFree###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['pid']       = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_calendar')];
    $arr_records[$int_uid]['tstamp']    = $this->timestamp;
    $arr_records[$int_uid]['crdate']    = $this->timestamp;
    $arr_records[$int_uid]['cruser_id'] = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_calentrance_title_entranceFree');
    $arr_records[$int_uid]['value']     = $this->pi_getLL('record_tx_org_calentrance_value_entranceFree');
      // entranceFree

      // mereMortals
    $int_uid                            = $int_uid + 1;
    $arr_records[$int_uid]              = $arr_records[$int_uid - 1];
    $this->arr_recordUids['###tx_org_calentrance.uid.mereMortals###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_calentrance_title_mereMortals');
    $arr_records[$int_uid]['value']     = $this->pi_getLL('record_tx_org_calentrance_value_mereMortals');
      // mereMortals

      // sponsor
    $int_uid                            = $int_uid + 1;
    $arr_records[$int_uid]              = $arr_records[$int_uid - 1];
    $this->arr_recordUids['###tx_org_calentrance.uid.sponsor###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_calentrance_title_sponsor');
    $arr_records[$int_uid]['value']     = $this->pi_getLL('record_tx_org_calentrance_value_sponsor');
      // sponsor

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_sysfTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // Add records to database
      // tx_org_calentrance



      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_caltype

      // General values
    $table           = 'tx_org_caltype';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values

      // policy
    $int_uid                            = $int_uid + 1;
    $this->arr_recordUids['###tx_org_caltype.uid.policy###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['pid']       = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_calendar')];
    $arr_records[$int_uid]['tstamp']    = $this->timestamp;
    $arr_records[$int_uid]['crdate']    = $this->timestamp;
    $arr_records[$int_uid]['cruser_id'] = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_caltype_title_policy');
      // policy

      // society
    $int_uid                            = $int_uid + 1;
    $arr_records[$int_uid]              = $arr_records[$int_uid - 1];
    $this->arr_recordUids['###tx_org_caltype.uid.society###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_caltype_title_society');
      // society

      // TYPO3
    $int_uid                            = $int_uid + 1;
    $arr_records[$int_uid]              = $arr_records[$int_uid - 1];
    $this->arr_recordUids['###tx_org_caltype.uid.typo3###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_caltype_title_typo3');
      // TYPO3

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_sysfTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // Add records to database
      // tx_org_caltype



      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_tax

      // General values
    $table           = 'tx_org_tax';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values

      // 000
    $int_uid                            = $int_uid + 1;
    $this->arr_recordUids['###tx_org_tax.uid.000###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['pid']       = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_calendar')];
    $arr_records[$int_uid]['tstamp']    = $this->timestamp;
    $arr_records[$int_uid]['crdate']    = $this->timestamp;
    $arr_records[$int_uid]['cruser_id'] = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_tax_title_000');
    $arr_records[$int_uid]['value']     = $this->pi_getLL('record_tx_org_tax_title_000');
      // 000

      // 007
    $int_uid                            = $int_uid + 1;
    $arr_records[$int_uid]              = $arr_records[$int_uid - 1];
    $this->arr_recordUids['###tx_org_tax.uid.007###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_tax_title_007');
    $arr_records[$int_uid]['value']     = $this->pi_getLL('record_tx_org_tax_title_007');
      // 007

      // 019
    $int_uid                            = $int_uid + 1;
    $arr_records[$int_uid]              = $arr_records[$int_uid - 1];
    $this->arr_recordUids['###tx_org_tax.uid.019###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_tax_title_019');
    $arr_records[$int_uid]['value']     = $this->pi_getLL('record_tx_org_tax_title_019');
      // 019

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_sysfTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // Add records to database
      // tx_org_tax
    
  }










   /**
   * createRecords_categories_sysfolder_headquarters(): 
   *                      Adds category records with pid of the sysfolder news
   *                      Tables are
   *                      * tx_org_departmentcat
   *
   * @return    void
   * @version 1.0.0
   */
  private function createRecords_categories_sysfolder_headquarters()
  {
      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_departmentcat

      // General values
    $table           = 'tx_org_departmentcat';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values

      // policy
    $int_uid                            = $int_uid + 1;
    $this->arr_recordUids['###tx_org_departmentcat.uid.policy###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['pid']       = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_headquarters')];
    $arr_records[$int_uid]['tstamp']    = $this->timestamp;
    $arr_records[$int_uid]['crdate']    = $this->timestamp;
    $arr_records[$int_uid]['cruser_id'] = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_departmentcat_title_policy');
      // policy

      // society
    $int_uid                            = $int_uid + 1;
    $arr_records[$int_uid]              = $arr_records[$int_uid - 1];
    $this->arr_recordUids['###tx_org_departmentcat.uid.society###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_departmentcat_title_society');
      // society

      // TYPO3
    $int_uid                            = $int_uid + 1;
    $arr_records[$int_uid]              = $arr_records[$int_uid - 1];
    $this->arr_recordUids['###tx_org_departmentcat.uid.typo3###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_departmentcat_title_typo3');
      // TYPO3

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_sysfTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // Add records to database
      // tx_org_departmentcat
  }










   /**
   * createRecords_categories_sysfolder_news(): 
   *                      Adds category records with pid of the sysfolder news
   *                      Tables are
   *                      * tx_org_newscat
   *
   * @return    void
   * @version 1.0.0
   */
  private function createRecords_categories_sysfolder_news()
  {
      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_newscat

      // General values
    $table           = 'tx_org_newscat';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values

      // policy
    $int_uid                            = $int_uid + 1;
    $this->arr_recordUids['###tx_org_newscat.uid.policy###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['pid']       = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_news')];
    $arr_records[$int_uid]['tstamp']    = $this->timestamp;
    $arr_records[$int_uid]['crdate']    = $this->timestamp;
    $arr_records[$int_uid]['cruser_id'] = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_newscat_title_policy');
      // policy

      // society
    $int_uid                            = $int_uid + 1;
    $arr_records[$int_uid]              = $arr_records[$int_uid - 1];
    $this->arr_recordUids['###tx_org_newscat.uid.society###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_newscat_title_society');
      // society

      // TYPO3
    $int_uid                            = $int_uid + 1;
    $arr_records[$int_uid]              = $arr_records[$int_uid - 1];
    $this->arr_recordUids['###tx_org_newscat.uid.typo3###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_tx_org_newscat_title_typo3');
      // TYPO3

      // Add records to database

    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_sysfTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // Add records to database
      // tx_org_newscat
  }










   /**
   * createRecords_categories_sysfolder_staff(): 
   *                      Adds category records with pid of the sysfolder staff
   *                      Tables are
   *                      * fe_groups
   *
   * @return    void
   * @version 1.0.0
   */
  private function createRecords_categories_sysfolder_staff()
  {
      //////////////////////////////////////////////////////////////////////
      //
      // fe_groups

      // General values
    $table           = 'fe_groups';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values

      // policy
    $int_uid                            = $int_uid + 1;
    $this->arr_recordUids['###fe_groups.uid.policy###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['pid']       = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_staff')];
    $arr_records[$int_uid]['tstamp']    = $this->timestamp;
    $arr_records[$int_uid]['crdate']    = $this->timestamp;
    $arr_records[$int_uid]['cruser_id'] = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_fe_groups_title_policy');
      // policy

      // society
    $int_uid                            = $int_uid + 1;
    $arr_records[$int_uid]              = $arr_records[$int_uid - 1];
    $this->arr_recordUids['###fe_groups.uid.society###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_fe_groups_title_society');
      // society

      // TYPO3
    $int_uid                            = $int_uid + 1;
    $arr_records[$int_uid]              = $arr_records[$int_uid - 1];
    $this->arr_recordUids['###fe_groups.uid.typo3###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']       = $int_uid;
    $arr_records[$int_uid]['title']     = $this->pi_getLL('record_fe_groups_title_typo3');
      // TYPO3

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_sysfTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // Add records to database
      // fe_groups
  }









   /**
   * createRecords_records_sysfolder_calendar(): 
   *                      Add records into the sysfolder calendar
   *                      Effected tables:
   *                      * tx_org_cal
   *
   * @return    void
   * @version 1.0.0
   */
  private function createRecords_records_sysfolder_calendar()
  {

      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_cal

      // General values
    $table           = 'tx_org_cal';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values

      // t3devdays
    $str_image = $this->pi_getLL('record_tx_org_cal_t3devdays_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_cal.uid.t3devdays###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_calendar')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['type']          = $this->pi_getLL('record_tx_org_cal_t3devdays_type');
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_cal_t3devdays_title');
    $arr_records[$int_uid]['datetime']      = $this->pi_getLL('record_tx_org_cal_t3devdays_datetime');
    $arr_records[$int_uid]['bodytext']      = $this->pi_getLL('record_tx_org_cal_t3devdays_bodytext');
    $arr_records[$int_uid]['image']         = $str_image;
    $arr_records[$int_uid]['image_link']    = $this->pi_getLL('record_tx_org_cal_t3devdays_image_link');
    $arr_records[$int_uid]['imageorient']   = $this->pi_getLL('record_tx_org_cal_t3devdays_imageorient');
    $arr_records[$int_uid]['imagecols']     = '1';
    $arr_records[$int_uid]['image_zoom']    = '1';
    $arr_records[$int_uid]['image_noRows']  = '1';
      // t3devdays

      // t3organiser
    $str_image = $this->pi_getLL('record_tx_org_cal_t3organiser_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_cal.uid.t3organiser###']
                                            = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_calendar')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['type']          = $this->pi_getLL('record_tx_org_cal_t3organiser_type');
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_cal_t3organiser_title');
    $arr_records[$int_uid]['datetime']      = $this->pi_getLL('record_tx_org_cal_t3organiser_datetime');
    $arr_records[$int_uid]['bodytext']      = $this->pi_getLL('record_tx_org_cal_t3organiser_bodytext');
    $arr_records[$int_uid]['image']         = $str_image;
    $arr_records[$int_uid]['imagewidth']    = $this->pi_getLL('record_tx_org_cal_t3organiser_imagewidth');
    $arr_records[$int_uid]['imageorient']   = $this->pi_getLL('record_tx_org_cal_t3organiser_imageorient');
    $arr_records[$int_uid]['imagecols']     = '1';
    $arr_records[$int_uid]['image_zoom']    = '1';
    $arr_records[$int_uid]['image_noRows']  = '1';

    $arr_records[$int_uid]['bodytext'] = str_replace(
      '###fe_users.uid.dwildt###', 
      $this->arr_recordUids['###fe_users.uid.dwildt###'],
      $arr_records[$int_uid]['bodytext']
    );
    $arr_records[$int_uid]['bodytext'] = str_replace(
      '###fe_users.uid.obama###', 
      $this->arr_recordUids['###fe_users.uid.obama###'],
      $arr_records[$int_uid]['bodytext']
    );
      // t3organiser


      // eggroll
    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_cal.uid.eggroll###']
                                            = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_calendar')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['type']          = $this->pi_getLL('record_tx_org_cal_eggroll_type');
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_cal_eggroll_title');
    $arr_records[$int_uid]['datetime']      = $this->pi_getLL('record_tx_org_cal_eggroll_datetime');
    $arr_records[$int_uid]['calurl']        = $this->pi_getLL('record_tx_org_cal_eggroll_calurl');
    $arr_records[$int_uid]['teaser_short']  = $this->pi_getLL('record_tx_org_cal_eggroll_teaser_short');
      // eggroll

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump(__METHOD__ . ' ('. __LINE__ . ')', $GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_sysfTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // Add records to database
      // tx_org_cal
  }









   /**
   * createRecords_records_sysfolder_headquarters(): 
   *                      Add records into the sysfolder calendar
   *                      Effected tables:
   *                      * tx_org_department
   *                      * tx_org_headquarters
   *
   * @return    void
   * @version 1.0.0
   */
  private function createRecords_records_sysfolder_headquarters()
  {

      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_department

      // General values
    $table           = 'tx_org_department';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values

      // netzmacher
    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_department.uid.netzmacher###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_headquarters')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['sorting']       = 256 * 1;
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_department_netzmacher_title');
    $arr_records[$int_uid]['telephone']     = $this->pi_getLL('record_tx_org_department_netzmacher_telephone');
    $arr_records[$int_uid]['email']         = $this->pi_getLL('record_tx_org_department_netzmacher_email');
    $arr_records[$int_uid]['url']           = $this->pi_getLL('record_tx_org_department_netzmacher_url');
      // netzmacher

      // president
    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_department.uid.president###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_headquarters')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['sorting']       = 256 * 2;
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_department_president_title');
    $arr_records[$int_uid]['telephone']     = $this->pi_getLL('record_tx_org_department_president_telephone');
    $arr_records[$int_uid]['email']         = $this->pi_getLL('record_tx_org_department_president_email');
    $arr_records[$int_uid]['url']           = $this->pi_getLL('record_tx_org_department_president_url');
      // president

      // t3press
    $str_image = $this->pi_getLL('record_tx_org_department_t3press_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_department.uid.t3press###']
                                        = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_headquarters')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['sorting']       = 256 * 3;
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_department_t3press_title');
    $arr_records[$int_uid]['telephone']     = $this->pi_getLL('record_tx_org_department_t3press_telephone');
    $arr_records[$int_uid]['email']         = $this->pi_getLL('record_tx_org_department_t3press_email');
    $arr_records[$int_uid]['url']           = $this->pi_getLL('record_tx_org_department_t3press_url');
      // t3press

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_sysfTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // Add records to database
      // tx_org_department



      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_headquarters

      // General values
    $table           = 'tx_org_headquarters';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values

      // netzmacher
    $str_image = $this->pi_getLL('record_tx_org_headquarters_netzmacher_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_headquarters.uid.netzmacher###']
                                            = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_headquarters')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['sorting']       = 256 * 1;
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_headquarters_netzmacher_title');
    $arr_records[$int_uid]['telephone']     = $this->pi_getLL('record_tx_org_headquarters_netzmacher_telephone');
    $arr_records[$int_uid]['email']         = $this->pi_getLL('record_tx_org_headquarters_netzmacher_email');
    $arr_records[$int_uid]['mail_address']  = $this->pi_getLL('record_tx_org_headquarters_netzmacher_mail_address');
    $arr_records[$int_uid]['mail_postcode'] = $this->pi_getLL('record_tx_org_headquarters_netzmacher_mail_postcode');
    $arr_records[$int_uid]['mail_city']     = $this->pi_getLL('record_tx_org_headquarters_netzmacher_mail_city');
    $arr_records[$int_uid]['mail_url']      = $this->pi_getLL('record_tx_org_headquarters_netzmacher_mail_url');
    $arr_records[$int_uid]['mail_embeddedcode'] = $this->pi_getLL('record_tx_org_headquarters_netzmacher_mail_embeddedcode');
    $arr_records[$int_uid]['image']         = $str_image;
    $arr_records[$int_uid]['imageorient']   = $this->pi_getLL('record_tx_org_headquarters_netzmacher_imageorient');
    $arr_records[$int_uid]['imageseo']      = $this->pi_getLL('record_tx_org_headquarters_netzmacher_imageseo');
    $arr_records[$int_uid]['imagecols']     = '1';
    $arr_records[$int_uid]['image_zoom']    = '1';
    $arr_records[$int_uid]['image_noRows']  = '1';
      // netzmacher

      // president
    $str_image = $this->pi_getLL('record_tx_org_headquarters_president_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_headquarters.uid.president###']
                                            = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_headquarters')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['sorting']       = 256 * 2;
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_headquarters_president_title');
    $arr_records[$int_uid]['telephone']     = $this->pi_getLL('record_tx_org_headquarters_president_telephone');
    $arr_records[$int_uid]['email']         = $this->pi_getLL('record_tx_org_headquarters_president_email');
    $arr_records[$int_uid]['mail_address']  = $this->pi_getLL('record_tx_org_headquarters_president_mail_address');
    $arr_records[$int_uid]['mail_postcode'] = $this->pi_getLL('record_tx_org_headquarters_president_mail_postcode');
    $arr_records[$int_uid]['mail_city']     = $this->pi_getLL('record_tx_org_headquarters_president_mail_city');
    $arr_records[$int_uid]['mail_url']      = $this->pi_getLL('record_tx_org_headquarters_president_mail_url');
    $arr_records[$int_uid]['mail_embeddedcode'] = $this->pi_getLL('record_tx_org_headquarters_president_mail_embeddedcode');
    $arr_records[$int_uid]['image']         = $str_image;
    $arr_records[$int_uid]['imageorient']   = $this->pi_getLL('record_tx_org_headquarters_president_imageorient');
    $arr_records[$int_uid]['imageseo']      = $this->pi_getLL('record_tx_org_headquarters_president_imageseo');
    $arr_records[$int_uid]['imagewidth']    = $this->pi_getLL('record_tx_org_headquarters_president_imageseo');
    $arr_records[$int_uid]['imagecols']     = '1';
    $arr_records[$int_uid]['image_zoom']    = '1';
    $arr_records[$int_uid]['image_noRows']  = '1';
      // president

      // typo3
    $str_image = $this->pi_getLL('record_tx_org_headquarters_typo3_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_headquarters.uid.typo3###']
                                            = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_headquarters')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['sorting']       = 256 * 2;
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_headquarters_typo3_title');
    $arr_records[$int_uid]['fax']           = $this->pi_getLL('record_tx_org_headquarters_typo3_fax');
    $arr_records[$int_uid]['email']         = $this->pi_getLL('record_tx_org_headquarters_typo3_email');
    $arr_records[$int_uid]['mail_address']  = $this->pi_getLL('record_tx_org_headquarters_typo3_mail_address');
    $arr_records[$int_uid]['mail_postcode'] = $this->pi_getLL('record_tx_org_headquarters_typo3_mail_postcode');
    $arr_records[$int_uid]['mail_city']     = $this->pi_getLL('record_tx_org_headquarters_typo3_mail_city');
    $arr_records[$int_uid]['mail_url']      = $this->pi_getLL('record_tx_org_headquarters_typo3_mail_url');
    $arr_records[$int_uid]['mail_embeddedcode'] = $this->pi_getLL('record_tx_org_headquarters_typo3_mail_embeddedcode');
    $arr_records[$int_uid]['image']         = $str_image;
    $arr_records[$int_uid]['imageorient']   = $this->pi_getLL('record_tx_org_headquarters_typo3_imageorient');
    $arr_records[$int_uid]['imageseo']      = $this->pi_getLL('record_tx_org_headquarters_typo3_imageseo');
    $arr_records[$int_uid]['imagewidth']    = $this->pi_getLL('record_tx_org_headquarters_typo3_imageseo');
    $arr_records[$int_uid]['imagecols']     = '1';
    $arr_records[$int_uid]['image_zoom']    = '1';
    $arr_records[$int_uid]['image_noRows']  = '1';
      // typo3

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_sysfTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // Add records to database
      // tx_org_headquarters
  }









   /**
   * createRecords_records_sysfolder_locations(): 
   *                      Add records into the sysfolder calendar
   *                      Effected tables:
   *                      * tx_org_location
   *
   * @return    void
   * @version 1.0.0
   */
  private function createRecords_records_sysfolder_locations()
  {

      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_location

      // General values
    $table           = 'tx_org_location';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values

      // netzmacher
    $str_image = $this->pi_getLL('record_tx_org_location_netzmacher_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_location.uid.netzmacher###']
                                            = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_locations')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['sorting']       = 256 * 1;
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_location_netzmacher_title');
    $arr_records[$int_uid]['url']           = $this->pi_getLL('record_tx_org_location_netzmacher_url');
    $arr_records[$int_uid]['telephone']     = $this->pi_getLL('record_tx_org_location_netzmacher_telephone');
    $arr_records[$int_uid]['email']         = $this->pi_getLL('record_tx_org_location_netzmacher_email');
    $arr_records[$int_uid]['mail_address']  = $this->pi_getLL('record_tx_org_location_netzmacher_mail_address');
    $arr_records[$int_uid]['mail_postcode'] = $this->pi_getLL('record_tx_org_location_netzmacher_mail_postcode');
    $arr_records[$int_uid]['mail_city']     = $this->pi_getLL('record_tx_org_location_netzmacher_mail_city');
    $arr_records[$int_uid]['mail_url']      = $this->pi_getLL('record_tx_org_location_netzmacher_mail_url');
    $arr_records[$int_uid]['mail_embeddedcode'] = $this->pi_getLL('record_tx_org_location_netzmacher_mail_embeddedcode');
    $arr_records[$int_uid]['image']         = $str_image;
    $arr_records[$int_uid]['imageorient']   = $this->pi_getLL('record_tx_org_location_netzmacher_imageorient');
    $arr_records[$int_uid]['imageseo']      = $this->pi_getLL('record_tx_org_location_netzmacher_imageseo');
    $arr_records[$int_uid]['imagewidth']    = $this->pi_getLL('record_tx_org_location_netzmacher_imagewidth');
    $arr_records[$int_uid]['image_link']    = $this->pi_getLL('record_tx_org_location_netzmacher_image_link');
    $arr_records[$int_uid]['imagecols']     = '1';
    $arr_records[$int_uid]['image_zoom']    = '1';
    $arr_records[$int_uid]['image_noRows']  = '1';
      // netzmacher

      // t3devdays
    $str_image = $this->pi_getLL('record_tx_org_location_t3devdays_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_location.uid.t3devdays###']
                                            = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_locations')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['sorting']       = 256 * 1;
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_location_t3devdays_title');
    $arr_records[$int_uid]['url']           = $this->pi_getLL('record_tx_org_location_t3devdays_url');
    $arr_records[$int_uid]['telephone']     = $this->pi_getLL('record_tx_org_location_t3devdays_telephone');
    $arr_records[$int_uid]['email']         = $this->pi_getLL('record_tx_org_location_t3devdays_email');
    $arr_records[$int_uid]['mail_address']  = $this->pi_getLL('record_tx_org_location_t3devdays_mail_address');
    $arr_records[$int_uid]['mail_postcode'] = $this->pi_getLL('record_tx_org_location_t3devdays_mail_postcode');
    $arr_records[$int_uid]['mail_city']     = $this->pi_getLL('record_tx_org_location_t3devdays_mail_city');
    $arr_records[$int_uid]['mail_url']      = $this->pi_getLL('record_tx_org_location_t3devdays_mail_url');
    $arr_records[$int_uid]['mail_embeddedcode'] = $this->pi_getLL('record_tx_org_location_t3devdays_mail_embeddedcode');
    $arr_records[$int_uid]['image']         = $str_image;
    $arr_records[$int_uid]['imageorient']   = $this->pi_getLL('record_tx_org_location_t3devdays_imageorient');
    $arr_records[$int_uid]['imageseo']      = $this->pi_getLL('record_tx_org_location_t3devdays_imageseo');
    $arr_records[$int_uid]['imagewidth']    = $this->pi_getLL('record_tx_org_location_t3devdays_imagewidth');
    $arr_records[$int_uid]['image_link']    = $this->pi_getLL('record_tx_org_location_t3devdays_image_link');
    $arr_records[$int_uid]['imagecols']     = '1';
    $arr_records[$int_uid]['image_zoom']    = '1';
    $arr_records[$int_uid]['image_noRows']  = '1';
//:TODO: document importieren
    $arr_records[$int_uid]['documents']         = $this->pi_getLL('record_tx_org_location_t3devdays_documents');
    $arr_records[$int_uid]['documentscaption']  = $this->pi_getLL('record_tx_org_location_t3devdays_documentscaption');
    $arr_records[$int_uid]['documentslayout']   = $this->pi_getLL('record_tx_org_location_t3devdays_documentslayout');
    $arr_records[$int_uid]['documentssize']     = $this->pi_getLL('record_tx_org_location_t3devdays_documentssize');
      // t3devdays

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_sysfTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // Add records to database
      // tx_org_location
  }









   /**
   * createRecords_records_sysfolder_news(): 
   *                      Add records into the sysfolder calendar
   *                      Effected tables:
   *                      * tx_org_news
   *
   * @return    void
   * @version 1.0.0
   */
  private function createRecords_records_sysfolder_news()
  {

      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_news

      // General values
    $table           = 'tx_org_news';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values

      // flow
    $str_image = $this->pi_getLL('record_tx_org_news_flow_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_news.uid.flow###']
                                            = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_news')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['type']          = $this->pi_getLL('record_tx_org_news_flow_type');
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_news_flow_title');
    $arr_records[$int_uid]['datetime']      = $this->pi_getLL('record_tx_org_news_flow_datetime');
    $arr_records[$int_uid]['bodytext']      = $this->pi_getLL('record_tx_org_news_flow_bodytext');
    $arr_records[$int_uid]['image']         = $str_image;
    $arr_records[$int_uid]['imageorient']   = $this->pi_getLL('record_tx_org_news_flow_imageorient');
    $arr_records[$int_uid]['imagecaption']  = $this->pi_getLL('record_tx_org_news_flow_imagecaption');
    $arr_records[$int_uid]['imageseo']      = $this->pi_getLL('record_tx_org_news_flow_imageseo');
    $arr_records[$int_uid]['imagewidth']    = $this->pi_getLL('record_tx_org_news_flow_imagewidth');
    $arr_records[$int_uid]['image_link']    = $this->pi_getLL('record_tx_org_news_flow_image_link');
    $arr_records[$int_uid]['imagecols']     = '1';
    $arr_records[$int_uid]['image_zoom']    = '1';
    $arr_records[$int_uid]['image_noRows']  = '1';
      // flow

      // organiser
    $str_image = $this->pi_getLL('record_tx_org_news_organiser_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_news.uid.organiser###']
                                            = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_news')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['type']          = $this->pi_getLL('record_tx_org_news_organiser_type');
    $arr_records[$int_uid]['newsurl']       = $this->pi_getLL('record_tx_org_news_organiser_newsurl');
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_news_organiser_title');
    $arr_records[$int_uid]['subtitle']      = $this->pi_getLL('record_tx_org_news_organiser_subtitle');
    $arr_records[$int_uid]['datetime']      = $this->pi_getLL('record_tx_org_news_organiser_datetime');
    $arr_records[$int_uid]['teaser_short']  = $this->pi_getLL('record_tx_org_news_organiser_teaser_short');
    $arr_records[$int_uid]['image']         = $str_image;
    $arr_records[$int_uid]['imageorient']   = $this->pi_getLL('record_tx_org_news_organiser_imageorient');
    $arr_records[$int_uid]['imagecaption']  = $this->pi_getLL('record_tx_org_news_organiser_imagecaption');
    $arr_records[$int_uid]['imageseo']      = $this->pi_getLL('record_tx_org_news_organiser_imageseo');
    $arr_records[$int_uid]['imagewidth']    = $this->pi_getLL('record_tx_org_news_organiser_imagewidth');
    $arr_records[$int_uid]['image_link']    = $this->pi_getLL('record_tx_org_news_organiser_image_link');
    $arr_records[$int_uid]['imagecols']     = '1';
    $arr_records[$int_uid]['image_zoom']    = '1';
    $arr_records[$int_uid]['image_noRows']  = '1';
      // organiser

      // president
    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###tx_org_news.uid.president###']
                                            = $int_uid;
    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_news')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['type']          = $this->pi_getLL('record_tx_org_news_president_type');
    $arr_records[$int_uid]['title']         = $this->pi_getLL('record_tx_org_news_president_title');
    $arr_records[$int_uid]['datetime']      = $this->pi_getLL('record_tx_org_news_president_datetime');
    $arr_records[$int_uid]['bodytext']      = $this->pi_getLL('record_tx_org_news_president_bodytext');
      // president

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['title'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_sysfTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // Add records to database
      // tx_org_news
  }









   /**
   * createRecords_records_sysfolder_staff(): 
   *                      Add records into the sysfolder staff
   *                      Effected tables:
   *                      * fe_users_mm_tx_org_news
   *
   * @return    void
   * @version 1.0.0
   */
  private function createRecords_records_sysfolder_staff()
  {

      //////////////////////////////////////////////////////////////////////
      //
      // fe_users

      // General values
    $table           = 'fe_users';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values

      // bobama
    $str_image = $this->pi_getLL('record_fe_users_bobama_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###fe_users.uid.bobama###']
                                            = $int_uid;

    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_staff')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['usergroup']     = 
      $this->arr_recordUids['###fe_groups.uid.policy###'] . ', ' .
      $this->arr_recordUids['###fe_groups.uid.society###'];
    $arr_records[$int_uid]['username']      = $this->pi_getLL('record_fe_users_bobama_username');
    $arr_records[$int_uid]['name']          = $this->pi_getLL('record_fe_users_bobama_name');
    $arr_records[$int_uid]['first_name']    = $this->pi_getLL('record_fe_users_bobama_first_name');
    $arr_records[$int_uid]['last_name']     = $this->pi_getLL('record_fe_users_bobama_last_name');
    $arr_records[$int_uid]['password']      = $this->zz_getPassword();
    $arr_records[$int_uid]['telephone']     = $this->pi_getLL('record_fe_users_bobama_telephone');
    $arr_records[$int_uid]['email']         = $this->pi_getLL('record_fe_users_bobama_email');
    $arr_records[$int_uid]['www']           = $this->pi_getLL('record_fe_users_bobama_www');
    $arr_records[$int_uid]['image']         = $str_image;
    $arr_records[$int_uid]['tx_org_imagecaption'] = $this->pi_getLL('record_fe_users_bobama_tx_org_imagecaption');
    $arr_records[$int_uid]['tx_org_imageseo']     = $this->pi_getLL('record_fe_users_bobama_tx_org_imageseo');
    $arr_records[$int_uid]['tx_org_vita']   = $this->pi_getLL('record_fe_users_bobama_tx_org_vita');
      // bobama

      // dwildt
    $str_image = $this->pi_getLL('record_fe_users_dwildt_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###fe_users.uid.dwildt###']
                                            = $int_uid;

    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_staff')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['username']      = $this->pi_getLL('record_fe_users_dwildt_username');
    $arr_records[$int_uid]['usergroup']     = 
      $this->arr_recordUids['###fe_groups.uid.typo3###'] . ', ' .
      $this->arr_recordUids['###fe_groups.uid.society###'];
    $arr_records[$int_uid]['name']          = $this->pi_getLL('record_fe_users_dwildt_name');
    $arr_records[$int_uid]['first_name']    = $this->pi_getLL('record_fe_users_dwildt_first_name');
    $arr_records[$int_uid]['last_name']     = $this->pi_getLL('record_fe_users_dwildt_last_name');
    $arr_records[$int_uid]['password']      = $this->zz_getPassword();
    $arr_records[$int_uid]['telephone']     = $this->pi_getLL('record_fe_users_dwildt_telephone');
    $arr_records[$int_uid]['email']         = $this->pi_getLL('record_fe_users_dwildt_email');
    $arr_records[$int_uid]['www']           = $this->pi_getLL('record_fe_users_dwildt_www');
    $arr_records[$int_uid]['image']         = $str_image;
    $arr_records[$int_uid]['tx_org_imagecaption'] = $this->pi_getLL('record_fe_users_dwildt_tx_org_imagecaption');
    $arr_records[$int_uid]['tx_org_imageseo']     = $this->pi_getLL('record_fe_users_dwildt_tx_org_imageseo');
      // dwildt

      // sschaffstein
    $str_image = $this->pi_getLL('record_fe_users_sschaffstein_image');
    $str_image = str_replace('timestamp', $this->timestamp, $str_image);

    $int_uid                                = $int_uid + 1;
    $this->arr_recordUids['###fe_users.uid.sschaffstein###']
                                            = $int_uid;

    $arr_records[$int_uid]['uid']           = $int_uid;
    $arr_records[$int_uid]['pid']           = $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_staff')];
    $arr_records[$int_uid]['tstamp']        = $this->timestamp;
    $arr_records[$int_uid]['crdate']        = $this->timestamp;
    $arr_records[$int_uid]['cruser_id']     = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_records[$int_uid]['username']      = $this->pi_getLL('record_fe_users_sschaffstein_username');
    $arr_records[$int_uid]['usergroup']     = 
      $this->arr_recordUids['###fe_groups.uid.typo3###'] . ', ' .
      $this->arr_recordUids['###fe_groups.uid.society###'];
    $arr_records[$int_uid]['name']          = $this->pi_getLL('record_fe_users_sschaffstein_name');
    $arr_records[$int_uid]['first_name']    = $this->pi_getLL('record_fe_users_sschaffstein_first_name');
    $arr_records[$int_uid]['last_name']     = $this->pi_getLL('record_fe_users_sschaffstein_last_name');
    $arr_records[$int_uid]['password']      = $this->zz_getPassword();
    $arr_records[$int_uid]['telephone']     = $this->pi_getLL('record_fe_users_sschaffstein_telephone');
    $arr_records[$int_uid]['email']         = $this->pi_getLL('record_fe_users_sschaffstein_email');
    $arr_records[$int_uid]['www']           = $this->pi_getLL('record_fe_users_sschaffstein_www');
    $arr_records[$int_uid]['image']         = $str_image;
    $arr_records[$int_uid]['tx_org_imagecaption'] = $this->pi_getLL('record_fe_users_sschaffstein_tx_org_imagecaption');
    $arr_records[$int_uid]['tx_org_imageseo']     = $this->pi_getLL('record_fe_users_sschaffstein_tx_org_imageseo');
      // sschaffstein

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###TITLE###']     = $fields_values['name'];
      $this->markerArray['###TABLE###']     = $table;
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_sysfTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_record_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_prompt').'
        </p>';
      $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
      $this->arrReport[] = $str_record_prompt;
    }
    unset($arr_records);
      // Add records to database
      // fe_users
  }









   /**
   * createRecords_records_mm(): 
   *                      Add records into the mm tables
   *                      Effected tables:
   *                      * fe_users_mm_tx_org_news
   *                      * tx_org_cal_mm_tx_org_calentrance
   *                      * tx_org_cal_mm_tx_org_caltype
   *                      * tx_org_cal_mm_tx_org_location
   *                      * tx_org_department_mm_fe_users
   *                      * tx_org_department_mm_tx_org_cal
   *                      * tx_org_department_mm_tx_org_departmentcat
   *                      * tx_org_department_mm_tx_org_news
   *                      * tx_org_news_mm_tx_org_newscat
   *
   * @return    void
   * @version 1.0.0
   */
  private function createRecords_records_mm()
  {

      //////////////////////////////////////////////////////////////////////
      //
      // fe_users_mm_tx_org_news

      // General values
    $int_uid = 0; // Counter only
    $table   = 'fe_users_mm_tx_org_news';

      // Schaffstein -> Flow
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###fe_users.uid.sschaffstein###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_news.uid.flow###'];

      // Obama -> President
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###fe_users.uid.bobama###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_news.uid.president###'];

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, false);
    }
      // Add records to database
      // Prompt
    unset($arr_records);
    $this->markerArray['###COUNT###']     = $int_uid;
    $this->markerArray['###TABLE###']     = $table;
    $str_record_prompt = '
      <p>
        '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_mm_prompt').'
      </p>';
    $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
    $this->arrReport[] = $str_record_prompt;
      // Prompt
      // fe_users_mm_tx_org_news



      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_cal_mm_tx_org_calentrance

      // General values
    $int_uid = 0; // Counter only
    $table   = 'tx_org_cal_mm_tx_org_calentrance';

      // t3 dev days -> free, sponsor, mere mortal
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_cal.uid.t3devdays###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_calentrance.uid.entranceFree###'];
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_cal.uid.t3devdays###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_calentrance.uid.sponsor###'];
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_cal.uid.t3devdays###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_calentrance.uid.mereMortals###'];

      // TYPO3 organiser -> free
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_cal.uid.t3organiser###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_calentrance.uid.entranceFree###'];

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, false);
    }
      // Add records to database
      // Prompt
    unset($arr_records);
    $this->markerArray['###COUNT###']     = $int_uid;
    $this->markerArray['###TABLE###']     = $table;
    $str_record_prompt = '
      <p>
        '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_mm_prompt').'
      </p>';
    $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
    $this->arrReport[] = $str_record_prompt;
      // Prompt
      // tx_org_cal_mm_tx_org_calentrance



      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_cal_mm_tx_org_caltype

      // General values
    $int_uid = 0; // Counter only
    $table   = 'tx_org_cal_mm_tx_org_caltype';

      // egg roll -> policy, society
//    $int_uid                              = $int_uid +1;
//    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_cal.uid.eggroll###'];
//    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_caltype.uid.policy###'];
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_cal.uid.eggroll###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_caltype.uid.society###'];

      // t3 dev days -> society, TYPO3
//    $int_uid                              = $int_uid +1;
//    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_cal.uid.t3devdays###'];
//    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_caltype.uid.society###'];
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_cal.uid.t3devdays###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_caltype.uid.typo3###'];

      // TYPO3 organiser -> society, TYPO3
//    $int_uid                              = $int_uid +1;
//    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_cal.uid.t3organiser###'];
//    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_caltype.uid.society###'];
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_cal.uid.t3organiser###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_caltype.uid.typo3###'];

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, false);
    }
      // Add records to database
      // Prompt
    unset($arr_records);
    $this->markerArray['###COUNT###']     = $int_uid;
    $this->markerArray['###TABLE###']     = $table;
    $str_record_prompt = '
      <p>
        '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_mm_prompt').'
      </p>';
    $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
    $this->arrReport[] = $str_record_prompt;
      // Prompt
      // tx_org_cal_mm_tx_org_caltype



      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_cal_mm_tx_org_location

      // General values
    $int_uid = 0; // Counter only
    $table   = 'tx_org_cal_mm_tx_org_location';

      // t3 dev days -> campus sursee
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_cal.uid.t3devdays###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_location.uid.t3devdays###'];

      // TYPO3 organiser -> netzmachwer
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_cal.uid.t3organiser###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_location.uid.netzmacher###'];

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, false);
    }
      // Add records to database
      // Prompt
    unset($arr_records);
    $this->markerArray['###COUNT###']     = $int_uid;
    $this->markerArray['###TABLE###']     = $table;
    $str_record_prompt = '
      <p>
        '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_mm_prompt').'
      </p>';
    $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
    $this->arrReport[] = $str_record_prompt;
      // Prompt
      // tx_org_cal_mm_tx_org_location



      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_department_mm_fe_users

      // General values
    $int_uid = 0; // Counter only
    $table   = 'tx_org_department_mm_fe_users';
    
      // TYPO3 press -> schaffstein
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.t3press###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###fe_users.uid.sschaffstein###'];

      // netzmachwer -> wildt
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.netzmacher###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###fe_users.uid.dwildt###'];

      // white house -> obama
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.president###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###fe_users.uid.bobama###'];

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, false);
    }
      // Add records to database
      // Prompt
    unset($arr_records);
    $this->markerArray['###COUNT###']     = $int_uid;
    $this->markerArray['###TABLE###']     = $table;
    $str_record_prompt = '
      <p>
        '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_mm_prompt').'
      </p>';
    $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
    $this->arrReport[] = $str_record_prompt;
      // Prompt
      // tx_org_department_mm_fe_users



      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_department_mm_tx_org_cal

      // General values
    $int_uid = 0; // Counter only
    $table   = 'tx_org_department_mm_tx_org_cal';
    
      // TYPO3 press -> t3devdays
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.t3press###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_cal.uid.t3devdays###'];

      // netzmachwer -> t3organiser
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.netzmacher###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_cal.uid.t3organiser###'];

      // white house -> eggroll
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.president###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_cal.uid.eggroll###'];

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, false);
    }
      // Add records to database
      // Prompt
    unset($arr_records);
    $this->markerArray['###COUNT###']     = $int_uid;
    $this->markerArray['###TABLE###']     = $table;
    $str_record_prompt = '
      <p>
        '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_mm_prompt').'
      </p>';
    $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
    $this->arrReport[] = $str_record_prompt;
      // Prompt
      // tx_org_department_mm_tx_org_cal



      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_department_mm_tx_org_departmentcat

      // General values
    $int_uid = 0; // Counter only
    $table   = 'tx_org_department_mm_tx_org_departmentcat';
    
      // TYPO3 press -> society, TYPO3
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.t3press###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_departmentcat.uid.society###'];
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.t3press###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_departmentcat.uid.typo3###'];

      // netzmachwer -> TYPO3
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.netzmacher###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_departmentcat.uid.typo3###'];

      // white house -> policy, society
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.president###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_departmentcat.uid.policy###'];
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.president###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_departmentcat.uid.society###'];

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, false);
    }
      // Add records to database
      // Prompt
    unset($arr_records);
    $this->markerArray['###COUNT###']     = $int_uid;
    $this->markerArray['###TABLE###']     = $table;
    $str_record_prompt = '
      <p>
        '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_mm_prompt').'
      </p>';
    $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
    $this->arrReport[] = $str_record_prompt;
      // Prompt
      // tx_org_department_mm_tx_org_departmentcat



      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_department_mm_tx_org_news

      // General values
    $int_uid = 0; // Counter only
    $table   = 'tx_org_department_mm_tx_org_news';
    
      // TYPO3 press -> flow
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.t3press###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_news.uid.flow###'];

      // white house -> healthreform
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_department.uid.president###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_news.uid.president###'];

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, false);
    }
      // Add records to database
      // Prompt
    unset($arr_records);
    $this->markerArray['###COUNT###']     = $int_uid;
    $this->markerArray['###TABLE###']     = $table;
    $str_record_prompt = '
      <p>
        '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_mm_prompt').'
      </p>';
    $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
    $this->arrReport[] = $str_record_prompt;
      // Prompt
      // tx_org_department_mm_tx_org_news



      //////////////////////////////////////////////////////////////////////
      //
      // tx_org_news_mm_tx_org_newscat

      // General values
    $int_uid = 0; // Counter only
    $table   = 'tx_org_news_mm_tx_org_newscat';
    
      // flow -> typo3
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_news.uid.flow###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_newscat.uid.typo3###'];

      // organiser -> typo3
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_news.uid.organiser###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_newscat.uid.typo3###'];

      // healthreform -> policy
    $int_uid                              = $int_uid +1;
    $arr_records[$int_uid]['uid_local']   = $this->arr_recordUids['###tx_org_news.uid.president###'];
    $arr_records[$int_uid]['uid_foreign'] = $this->arr_recordUids['###tx_org_newscat.uid.policy###'];

      // Add records to database
    foreach($arr_records as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, false);
    }
      // Add records to database
      // Prompt
    unset($arr_records);
    $this->markerArray['###COUNT###']     = $int_uid;
    $this->markerArray['###TABLE###']     = $table;
    $str_record_prompt = '
      <p>
        '.$this->arr_icons['ok'].' '.$this->pi_getLL('record_create_mm_prompt').'
      </p>';
    $str_record_prompt = $this->cObj->substituteMarkerArray($str_record_prompt, $this->markerArray);
    $this->arrReport[] = $str_record_prompt;
      // Prompt
      // tx_org_news_mm_tx_org_newscat

  }









   /**
   * createFilesOrganiser(): 
   *
   * @return    void
   * @version 1.0.0
   */
  private function createFilesFeUser()
  {
    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('files_create_header').'
      </h2>';
    
    
    
      //////////////////////////////////////////////////////////////////////
      //
      // Copy files from res to upload folder
  
      // General values
    $str_t3docRoot  = t3lib_div::getIndpEnv('TYPO3_DOCUMENT_ROOT') . '/';
    $str_pathSrce   = $str_t3docRoot . t3lib_extMgm::siteRelPath($this->extKey).'res/files/fe_users/';
    $str_pathDest   = $str_t3docRoot . 'uploads/pics/';
      // General values

      // LOOP res directory
    $obj_dir = dir($str_pathSrce);
    while (false !== ($str_entry = $obj_dir->read())) 
    {
        // SWITCH entry
      switch($str_entry)
      {
        case('.'):
        case('.svn'):
        case('..'):
          // file false
          // do nothing
          break;
        default:
          // file true
          $str_fileSrce = $str_pathSrce . $str_entry;
          $str_fileDest = $str_pathDest . $str_entry;
          $str_fileDest = str_replace('timestamp', $this->timestamp, $str_fileDest);
          $bool_success = copy($str_fileSrce, $str_fileDest);
          if ($bool_success)
          {
            $this->markerArray['###DEST###'] = $str_fileDest;
            $this->markerArray['###PATH###'] = $str_pathDest;
            $str_file_prompt = '
              <p>
                '.$this->arr_icons['ok'].' '.$this->pi_getLL('files_create_prompt').'
              </p>';
            $str_file_prompt = $this->cObj->substituteMarkerArray($str_file_prompt, $this->markerArray);
            $this->arrReport[] = $str_file_prompt;
          }
          if (!$bool_success)
          {
            $this->markerArray['###SRCE###'] = $str_pathSrce.$str_fileSrce;
            $this->markerArray['###DEST###'] = $str_pathDest.$str_fileDest;
            $str_file_prompt = '
              <p>
                '.$this->arr_icons['warn'].' '.$this->pi_getLL('files_create_prompt_error').'
              </p>';
            $str_file_prompt = $this->cObj->substituteMarkerArray($str_file_prompt, $this->markerArray);
            $this->arrReport[] = $str_file_prompt;
          }
          // file true
      }
        // SWITCH entry
    }
      // LOOP res directory
    $obj_dir->close();
      // Copy files from res to upload folder
  }









   /**
   * createFilesOrganiser(): 
   *
   * @return    void
   * @version 1.0.0
   */
  private function createFilesOrganiser()
  {
    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('files_create_header').'
      </h2>';
    
    
    
      //////////////////////////////////////////////////////////////////////
      //
      // Copy files from res to upload folder
  
      // General values
    $str_t3docRoot  = t3lib_div::getIndpEnv('TYPO3_DOCUMENT_ROOT') . '/';
    $str_pathSrce   = $str_t3docRoot . t3lib_extMgm::siteRelPath($this->extKey).'res/files/tx_org/';
    $str_pathDest   = $str_t3docRoot . 'uploads/tx_org/';
      // General values

      // LOOP res directory
    $obj_dir = dir($str_pathSrce);
    while (false !== ($str_entry = $obj_dir->read())) 
    {
        // SWITCH entry
      switch($str_entry)
      {
        case('.'):
        case('.svn'):
        case('..'):
          // file false
          // do nothing
          break;
        default:
          // file true
          $str_fileSrce = $str_pathSrce . $str_entry;
          $str_fileDest = $str_pathDest . $str_entry;
          $str_fileDest = str_replace('timestamp', $this->timestamp, $str_fileDest);
          $bool_success = copy($str_fileSrce, $str_fileDest);
          if ($bool_success)
          {
            $this->markerArray['###DEST###'] = $str_entry;
            $this->markerArray['###PATH###'] = $str_pathDest;
            $str_file_prompt = '
              <p>
                '.$this->arr_icons['ok'].' '.$this->pi_getLL('files_create_prompt').'
              </p>';
            $str_file_prompt = $this->cObj->substituteMarkerArray($str_file_prompt, $this->markerArray);
            $this->arrReport[] = $str_file_prompt;
          }
          if (!$bool_success)
          {
            $this->markerArray['###SRCE###'] = $str_pathSrce.$str_fileSrce;
            $this->markerArray['###DEST###'] = $str_pathDest.$str_fileDest;
            $str_file_prompt = '
              <p>
                '.$this->arr_icons['warn'].' '.$this->pi_getLL('files_create_prompt_error').'
              </p>';
            $str_file_prompt = $this->cObj->substituteMarkerArray($str_file_prompt, $this->markerArray);
            $this->arrReport[] = $str_file_prompt;
          }
          // file true
      }
        // SWITCH entry
    }
      // LOOP res directory
    $obj_dir->close();
      // Copy files from res to upload folder
  }














   /**
   * createContent(): Create tt_content records
   *
   * @return    void
   * @version 1.0.0
   */
  private function createContent()
  {
    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('content_create_header').'
      </h2>';
    
    
    
      //////////////////////////////////////////////////////////////////////
      //
      // General values

    $table           = 'tt_content';
    $no_quote_fields = false;
    $str_date        = date('Y-m-d G:i:s');
    $int_uid         = $this->zz_getMaxDbUid($table);
      // General values



      //////////////////////////////////////////////////////////////////////
      //
      // Content for page terms

    $int_uid                                                        = $int_uid + 1;
    $this->arr_contentUids[$this->pi_getLL('content_terms_header')] = $int_uid;
    
    $arr_content[$int_uid]['uid']          = $int_uid;
    $arr_content[$int_uid]['pid']          = $this->arr_pageUids[$this->pi_getLL('page_title_terms')];
    $arr_content[$int_uid]['tstamp']       = $this->timestamp;
    $arr_content[$int_uid]['crdate']       = $this->timestamp;
    $arr_content[$int_uid]['cruser_id']    = $this->arr_piFlexform['data']['sDEF']['lDEF']['backend_user']['vDEF'];
    $arr_content[$int_uid]['sorting']      = 256 * 1;
    $arr_content[$int_uid]['CType']        = 'text';
    $arr_content[$int_uid]['header']       = $this->pi_getLL('content_terms_header');
    $arr_content[$int_uid]['bodytext']     = $this->pi_getLL('content_terms_bodytext');
    $arr_content[$int_uid]['sectionIndex'] = 1;   
      // Content for page terms



      //////////////////////////////////////////////////////////////////////
      //
      // INSERT content records

    foreach($arr_content as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->INSERTquery($table, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $fields_values, $no_quote_fields);
      $this->markerArray['###HEADER###']    = $fields_values['header'];
      $this->markerArray['###TITLE_PID###'] = '"'.$this->arr_pageTitles[$fields_values['pid']].'" (uid '.$fields_values['pid'].')';
      $str_content_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('content_create_prompt').'
        </p>';
      $str_content_prompt = $this->cObj->substituteMarkerArray($str_content_prompt, $this->markerArray);
      $this->arrReport[] = $str_content_prompt;
    }
    unset($arr_content);
      // INSERT content records

  }












   /**
   * consolidatePageCurrent(): Consolidate the current page
   *
   * @return    void
   * @version 1.0.0
   */
  private function consolidatePageCurrent()
  {
    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('consolidate_header').'
      </h2>';



      //////////////////////////////////////////////////////////////////////
      //
      // General Values
  
    $str_date        = date('Y-m-d G:i:s');
    $table           = 'pages';
    $where           = 'uid = '.$GLOBALS['TSFE']->id;
    $no_quote_fields = false;
      // General Values



      //////////////////////////////////////////////////////////////////////
      //
      // UPDATE TSconfig and media

    $int_uid = $GLOBALS['TSFE']->id;

    $arr_pages[$int_uid]['title']         = $this->pi_getLL('page_title_calendar');
    $arr_pages[$int_uid]['tstamp']        = $this->timestamp;
    $arr_pages[$int_uid]['module']        = null;
    $arr_pages[$int_uid]['nav_hide']      = 1;
    if($this->bool_topLevel)
    {
      $arr_pages[$int_uid]['is_siteroot'] = 1;
    }
    if(!$this->bool_topLevel)
    {
      $arr_pages[$int_uid]['is_siteroot'] = 0;
    }
    $arr_pages[$int_uid]['TSconfig']      = '

// ORGANISER INSTALLER at '.$str_date.' -- BEGIN



  ///////////////////////////
  //
  // INDEX

  // LINKHANDLER
  //    mod.tx_linkhandler
  //    RTE.default.tx_linkhandler
  // TCEMAIN
  //    permissions



  /////////////////////////////////////
  //
  // LINKHANDLER

  // mod.tx_linkhandler
mod.tx_linkhandler {
  fe_users.onlyPids             = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_staff')] . '
  tx_org_cal.onlyPids           = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_calendar')] . '
  tx_org_department.onlyPids    = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_headquarters')] . '
  tx_org_event.onlyPids         = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_events')] . '
  tx_org_headquarters.onlyPids  = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_headquarters')] . '
  tx_org_location.onlyPids      = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_locations')] . '
  tx_org_news.onlyPids          = ' . $this->arr_sysfUids[$this->pi_getLL('sysfolder_title_news')] . '
}

  // Remove RTE default configuration
RTE.default.tx_linkhandler >
  // Copy configuration from mod to RTE
RTE.default.tx_linkhandler < mod.tx_linkhandler

  // LINKHANDLER


  /////////////////////////////////////
  //
  // TCEMAIN

TCEMAIN {
  permissions {
    // '.$this->markerArray['###GROUP_UID###'].': '.$this->markerArray['###GROUP_TITLE###'].'
    groupid = '.$this->markerArray['###GROUP_UID###'].'
    group   = show,edit,delete,new,editcontent
  }
}
  // TCEMAIN



// ORGANISER INSTALLER at '.$str_date.' -- END

';

      // UPDATE
    foreach($arr_pages as $fields_values)
    {
        //var_dump($GLOBALS['TYPO3_DB']->UPDATEquery($table, $where, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields);
        // Message
      $this->markerArray['###FIELD###']     = 'title, media, TSconfig';
      $this->markerArray['###TITLE_PID###'] = '"'.$GLOBALS['TSFE']->page['title'].'" (uid '.$GLOBALS['TSFE']->id.')';
      $str_consolidate_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('consolidate_prompt_page').'
        </p>';
      $str_consolidate_prompt = $this->cObj->substituteMarkerArray($str_consolidate_prompt, $this->markerArray);
      $this->arrReport[] = $str_consolidate_prompt;
        // Message
    }
    unset($arr_pages);
      // UPDATE



      //////////////////////////////////////////////////////////////////////
      //
      // Hide and delete the installer plugin

      // General Values
    $table           = 'tt_content';
    $int_uid         = $this->cObj->data['uid'];
    $where           = 'uid = '.$int_uid;
    $no_quote_fields = false;
      // General Values

    $arr_content[$int_uid]['tstamp']  = $this->timestamp;
    $arr_content[$int_uid]['hidden']  = 1;
    $arr_content[$int_uid]['deleted'] = 1;

    foreach($arr_content as $fields_values)
    {
        //var_dump($GLOBALS['TYPO3_DB']->UPDATEquery($table, $where, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields);
        // Message
      $this->markerArray['###FIELD###']     = '"deleted"';
      $this->markerArray['###TITLE###']     = '"'.$this->pi_getLL('plugin_powermail_header').'"';
      $this->markerArray['###TITLE_PID###'] = '"'.$GLOBALS['TSFE']->page['title'].'" (uid '.$GLOBALS['TSFE']->id.')';
      $str_consolidate_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('consolidate_prompt_content_rm').'
        </p>';
      $str_consolidate_prompt = $this->cObj->substituteMarkerArray($str_consolidate_prompt, $this->markerArray);
      $this->arrReport[] = $str_consolidate_prompt;
        // Message
    }
    unset($arr_content);
      // Hide the installer plugin



      //////////////////////////////////////////////////////////////////////
      //
      // Hide other TypoScript templates

      // General Values
    unset($arr_content);
    $table           = 'sys_template';
    $int_uid         = $this->arr_tsUids[$this->str_tsRoot];
    $pid             = $GLOBALS['TSFE']->id;
    $where           = 'pid = '.$pid.' AND uid NOT LIKE '.$int_uid;
    $no_quote_fields = false;
      // General Values
  
    $arr_content[$int_uid]['tstamp']  = $this->timestamp;
    $arr_content[$int_uid]['hidden']  = 1;
    $arr_content[$int_uid]['deleted'] = 1;
    
    foreach($arr_content as $fields_values)
    {
        //var_dump($GLOBALS['TYPO3_DB']->UPDATEquery($table, $where, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields);
        // Message
      $this->markerArray['###TITLE_PID###'] = '"'.$GLOBALS['TSFE']->page['title'].'" (uid '.$GLOBALS['TSFE']->id.')';
      $str_consolidate_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('consolidate_prompt_template').'
        </p>';
      $str_consolidate_prompt = $this->cObj->substituteMarkerArray($str_consolidate_prompt, $this->markerArray);
      $this->arrReport[] = $str_consolidate_prompt;
        // Message
    }
    unset($arr_content);
      // Hide other TypoScript templates

  }












   /**
   * consolidatePluginPowermail(): Consolidate the powermail plugin
   *
   * @return    void
   * @version 1.0.0
   */
  private function consolidatePluginPowermail()
  {



      //////////////////////////////////////////////////////////////////////
      //
      // General Values

    $str_date        = date('Y-m-d G:i:s');
    $table           = 'tt_content';
    $int_uid         = $this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')];
    $where           = 'uid = '.$int_uid;
    $no_quote_fields = false;
      // General Values


      //////////////////////////////////////////////////////////////////////
      //
      // UPDATE sender and sendername

    $str_sender     = ''.
      'uid'.$this->arr_recordUids['###tx_powermail_fields.uid.email###'];
    $str_sendername = ''.
      'uid'.$this->arr_recordUids['###tx_powermail_fields.uid.firstname###'].
      ','.
      'uid'.$this->arr_recordUids['###tx_powermail_fields.uid.surname###'];

    $arr_plugin[$int_uid]['tstamp']                  = $this->timestamp;
    $arr_plugin[$int_uid]['tx_powermail_sender']     = $str_sender;
    $arr_plugin[$int_uid]['tx_powermail_sendername'] = $str_sendername;

    foreach($arr_plugin as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->UPDATEquery($table, $where, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields);
        // Message
      $this->markerArray['###FIELD###']     = '"tx_powermail_sender, tx_powermail_sendername"';
      $this->markerArray['###TITLE###']     = '"'.$this->pi_getLL('plugin_powermail_header').'"';
      $this->markerArray['###TITLE_PID###'] = '"'.$this->pi_getLL('page_title_tickets').'" (uid '.$this->arr_pageUids[$this->pi_getLL('page_title_tickets')].')';
      $str_consolidate_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('consolidate_prompt_content').'
        </p>';
      $str_consolidate_prompt = $this->cObj->substituteMarkerArray($str_consolidate_prompt, $this->markerArray);
      $this->arrReport[] = $str_consolidate_prompt;
        // Message
    }
    unset($arr_plugin);
      // UPDATE sender and sendername

  }












   /**
   * consolidateTsWtCart(): Consolidate the TypoScript of wt_cart
   *
   * @return    void
   * @version 1.0.0
   */
  private function consolidateTsWtCart()
  {



      //////////////////////////////////////////////////////////////////////
      //
      // General Values

    $str_date        = date('Y-m-d G:i:s');
    $table           = 'sys_template';
    $int_uid         = $this->arr_tsUids[$this->str_tsWtCart];
    $where           = 'uid = '.$int_uid;
    $no_quote_fields = false;

    list($str_emailName) = explode('@', $this->arr_piFlexform['data']['sDEF']['lDEF']['mail_default_sender']['vDEF']);
    $str_emailName       = $str_emailName.'@###DOMAIN###';
      // General Values


      //////////////////////////////////////////////////////////////////////
      //
      // UPDATE constants
    
    $arr_ts[$int_uid]['tstamp']    = $this->timestamp;
    $arr_ts[$int_uid]['constants'] = '
  ////////////////////////////////////////
  //
  // plugin.org

plugin.org {
  tx_wtcart_pi1 {
    powermailContentUid = '. $this->arr_pluginUids[$this->pi_getLL('plugin_powermail_header')] .'
  }
  powermail {
    noreply     = ' . $str_emailName . '
    sender.name = ' . $this->arr_piFlexform['data']['sDEF']['lDEF']['mail_subject']['vDEF'] . '
    sender.mail = ' . $this->arr_piFlexform['data']['sDEF']['lDEF']['mail_default_sender']['vDEF'] . '
  }
}
  // plugin.org
';

    foreach($arr_ts as $fields_values)
    {
      //var_dump($GLOBALS['TYPO3_DB']->UPDATEquery($table, $where, $fields_values, $no_quote_fields));
      $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields);
        // Message
      $this->markerArray['###FIELD###']     = '"constants"';
      $this->markerArray['###TITLE###']     = '"'.$this->str_tsWtCart.'"';
      $this->markerArray['###TITLE_PID###'] = '"'.$this->pi_getLL('page_title_tickets').'" (uid '.$this->arr_pageUids[$this->pi_getLL('page_title_tickets')].')';
      $str_consolidate_prompt = '
        <p>
          '.$this->arr_icons['ok'].' '.$this->pi_getLL('consolidate_prompt_content').'
        </p>';
      $str_consolidate_prompt = $this->cObj->substituteMarkerArray($str_consolidate_prompt, $this->markerArray);
      $this->arrReport[] = $str_consolidate_prompt;
        // Message
    }
    unset($arr_ts);
      // UPDATE constants

  }









  /**
 * init_boolTopLevel(): If current page is on the top level, $this->bool_topLevel will become true.
 *                      If not, false.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
  private function init_boolTopLevel()
  {
    $select_fields  = 'pid';
    $from_table     = 'pages';
    $where_clause   = 'uid = ' . $GLOBALS['TSFE']->id;
    $groupBy        = null;
    $orderBy        = null;
    $limit          = null;
    //var_dump(__METHOD__ . ' (' . __LINE__ . '): ' . $GLOBALS['TYPO3_DB']->SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit));
    $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields,$from_table,$where_clause,$groupBy,$orderBy,$limit);
    $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
    
    if($row['pid'] < 1)
    {
      $this->bool_topLevel = true;
    }
    if($row['pid'] >= 1)
    {
      $this->bool_topLevel = false;
    }
  }












   /**
   * Shop will be installed - with or without template
   *
   * @return    The content that is displayed on the website
   */
  private function promptCleanUp()
  {
    // Get the cHash. Important in case of realUrl and no_cache=0
    $cHash_calc = $this->get_cHash(false);

    $lConfCObj['typolink.']['parameter']         = $GLOBALS['TSFE']->id;
    $lConfCObj['typolink.']['additionalParams']  = '&cHash='.$cHash_calc;
    $lConfCObj['typolink.']['returnLast']        = 'url';
    // Set the TypoScript configuration array

    // Set the URL (wrap the Link)
    $this->local_cObj = t3lib_div::makeInstance('tslib_cObj');
    $action               = $this->local_cObj->stdWrap('#', $lConfCObj);
//var_dump($action, $lConfCObj);
//        <form name="form_confirm" action="'.$action.'" method="POST">


    $this->arrReport[] = '
      <h2>
       '.$this->pi_getLL('end_header').'
      </h2>
      <p>
       '.$this->arr_icons['info'].$this->pi_getLL('end_reloadBe_prompt').'<br />
       '.$this->arr_icons['info'].$this->pi_getLL('end_deletePlugin_prompt').'
      </p>
      <div style="text-align:right;">
        <form name="form_confirm" method="POST">
          <fieldset id="fieldset_confirm" style="border:1px solid #F66800;padding:1em;">
            <legend style="color:#F66800;font-weight:bold;padding:0 1em;">
              '.$this->pi_getLL('end_header').'
            </legend>
            <input type="hidden" name="cHash"  value="'.$cHash_calc.'" />
            <input type="submit" name="submit" value=" '.$this->pi_getLL('end_button').' " />
          </fieldset>
        </form>
      </div>
      ';
  }














   /**
   * Shop will be installed - with or without template
   *
   * @return    The content that is displayed on the website
   */
  private function zz_getMaxDbUid($table)
  {
    $int_maxUid = false;
    
    $select_fields = 'max(`uid`) AS "uid"';
    $from_table    = '`'.$table.'`';
    $where_clause  = '';
    $groupBy       = '';
    $orderBy       = '';
    $limit         = '';
    $uidIndexField = '';
    
    //var_dump($GLOBALS['TYPO3_DB']->SELECTquery($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit, $uidIndexField));
    $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit, $uidIndexField);
    
    if(is_array($rows) && count($rows) > 0)
    {
      $int_maxUid = $rows[0]['uid'];
    }
    return $int_maxUid;
  }














   /**
   * Shop will be installed - with or without template
   *
   * @return    The content that is displayed on the website
   */
  private function zz_getPathToIcons()
  {
    $pathToIcons = t3lib_extMgm::siteRelPath($this->extKey).'/res/images/22x22/';
    $this->arr_icons['error'] = '<img width="22" height="22" src="'.$pathToIcons.'dialog-error.png"> ';
    $this->arr_icons['warn']  = '<img width="22" height="22" src="'.$pathToIcons.'dialog-warning.png"> ';
    $this->arr_icons['ok']    = '<img width="22" height="22" src="'.$pathToIcons.'dialog-ok-apply.png"> ';
    $this->arr_icons['info']  = '<img width="22" height="22" src="'.$pathToIcons.'dialog-information.png"> ';
  }









   /**
   * zz_getFlexValues(): Allocates flexform values to $this->arr_piFlexform
   *
   * @return    void
   * @version 1.0.0
   */
  private function zz_getFlexValues()
  {
      // Init methods for pi_flexform
    $this->pi_initPIflexForm();

      // Get values from the flexform
    $this->arr_piFlexform = $this->cObj->data['pi_flexform'];
  }









   /**
   * zz_getPassword: Get a random value
   *
   * @return    string  random value
   * @version 1.0.0
   */
  private function zz_getPassword()
  {
    mt_srand((double)microtime()*1000000);
    $randval = mt_rand();
    $randval = md5($randval);
    
    return $randval;
  }









  /**
 * Calculate the cHash md5 value
 *
 * @param  string    $str_params: URL parameter string like &tx_browser_pi1[showUid]=12&&tx_browser_pi1[cat]=1
 * @return  string    $cHash_md5: md5 value like d218cfedf9
 */
  function get_cHash($str_params)
  {
    $cHash_array  = t3lib_div::cHashParams($str_params);
    $cHash_md5    = t3lib_div::shortMD5(serialize($cHash_array));

    return $cHash_md5;
  }
}













if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/org_installer/pi1/class.tx_orginstaller_pi1.php']);
}