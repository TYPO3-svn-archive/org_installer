<?php

if ( !defined( 'TYPO3_MODE' ) )
  die( 'Access denied.' );

// Extending TypoScript from static template uid=43 to set up userdefined tag
t3lib_extMgm::addPItoST43( $_EXTKEY, 'pi1/class.tx_orginstaller_pi1.php', '_pi1', 'list_type', 1 );
//
// #61663, 140917, dwildt, 2+
//   Comment: It seems, that disabling the cache (USER_INT plugin) hasn't any effect in context with the error:
//   Page Not Found
//   Reason: Request parameters could not be validated (&cHash empty)
//
//$cacheIt = 0;
//t3lib_extMgm::addPItoST43( $_EXTKEY, 'pi1/class.tx_orginstaller_pi1.php', '_pi1', 'list_type', $cacheIt );
?>