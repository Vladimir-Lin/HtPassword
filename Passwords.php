<?php

require_once dirname(__FILE__) . "/Accounts.php" ;

class HtPassword
{

public static function setHooks ( &$parser )
{
//  $parser -> setHook ( 'HtPassword', 'HtPassword::Editor' ) ;
  $parser -> setFunctionHook ( 'HtPassword' , [ self::class , 'Editor' ] ) ;
  return true ;
}

public static function Editor( Parser $parser , $FILE = "" , $LANG = "zh-TW" , $WIDTH = "100%" , $canAppend = "Yes" , $canDelete = "Yes" )
{
  ////////////////////////////////////////////////////////////////////////////
  $mypath   = dirname      ( __FILE__                                      ) ;
  $mypath   = str_replace  ( "\\" , "/" , $mypath                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $rootpt   = dirname      ( dirname ( $mypath )                           ) ;
  $rootpt   = str_replace  ( "\\" , "/" , $rootpt                          ) ;
  ////////////////////////////////////////////////////////////////////////////
  $ACCT     = new Accounts ( $mypath , $rootpt , $LANG , $FILE             ) ;
  $ACCT    -> setAppend    ( $canAppend                                    ) ;
  $ACCT    -> setDelete    ( $canDelete                                    ) ;
  $ACCT    -> Width = $WIDTH                                                 ;
  ////////////////////////////////////////////////////////////////////////////
  $outp     = $ACCT -> Content           (                                 ) ;
  ////////////////////////////////////////////////////////////////////////////
  $parser -> getOutput ( ) -> addModules ( [ 'ext.HtPassword' ] )            ;
  ////////////////////////////////////////////////////////////////////////////
  return array ( $outp , 'noparse' => true , 'isHTML' => true )              ;
}

}

?>
