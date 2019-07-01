<?php
//////////////////////////////////////////////////////////////////////////////
require_once dirname(__FILE__) .   "/../Accounts.php"                        ;
$AA      = array                     (                                     ) ;
//////////////////////////////////////////////////////////////////////////////
$mypath  = dirname                   ( dirname ( __FILE__ )                ) ;
$mypath  = str_replace               ( "\\" , "/" , $mypath                ) ;
//////////////////////////////////////////////////////////////////////////////
$rootpt  = dirname                   ( dirname ( $mypath )                 ) ;
$rootpt  = str_replace               ( "\\" , "/" , $rootpt                ) ;
//////////////////////////////////////////////////////////////////////////////
$ROOT    = Parameter                 ( "Root"                              ) ;
$LANG    = Parameter                 ( "Language"                          ) ;
$FILE    = Parameter                 ( "File"                              ) ;
$WIDTH   = Parameter                 ( "Width"                             ) ;
$APPEND  = Parameter                 ( "Append"                            ) ;
$DELETE  = Parameter                 ( "Delete"                            ) ;
$ACCOUNT = Parameter                 ( "Account"                           ) ;
$ROOT    = Parameter                 ( "Root"                              ) ;
//////////////////////////////////////////////////////////////////////////////
$ACCT    = new Accounts              ( $mypath , $rootpt , $LANG , $FILE   ) ;
$ACCT   -> setAppend                 ( $APPEND                             ) ;
$ACCT   -> setDelete                 ( $DELETE                             ) ;
$ACCT   -> Width = $WIDTH                                                    ;
//////////////////////////////////////////////////////////////////////////////
$ACCT   -> DeletePassword            ( $ACCOUNT                            ) ;
//////////////////////////////////////////////////////////////////////////////
$AA [ "Message" ] = $ACCT -> Editing (                                     ) ;
$AA [ "Answer"  ] = "Yes"                                                    ;
//////////////////////////////////////////////////////////////////////////////
$RJ = json_encode                    ( $AA                                 ) ;
unset                                ( $AA                                 ) ;
//////////////////////////////////////////////////////////////////////////////
header                               ( "Content-Type: application/json"    ) ;
echo $RJ                                                                     ;
//////////////////////////////////////////////////////////////////////////////
?>
