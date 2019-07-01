<?php

if ( function_exists( 'wfLoadExtension' ) ) {
  wfLoadExtension( 'HtPassword' );
  $wgMessagesDirs['HtPassword'] = __DIR__ . '/i18n';
  return true;
} else {
  die( 'This extension requires MediaWiki 1.25+' );
}

?>
