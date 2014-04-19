<?php

$GLOBALS['THRIFT_ROOT'] = dirname(__FILE__).'/thrift/src';
require_once( $GLOBALS['THRIFT_ROOT'].'/Thrift.php' );
require_once( $GLOBALS['THRIFT_ROOT'].'/transport/TSocket.php' );
require_once( $GLOBALS['THRIFT_ROOT'].'/transport/TBufferedTransport.php' );
require_once( $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php' );

//hbase thrift
require_once dirname(__FILE__).'/thrift/Hbase.php';
 
//hive thrift
require_once dirname(__FILE__).'/thrift/ThriftHive.php';

//轉西元
function dateTo_ad($in_date)
{

$cyear = substr($in_date, 0, -4);
$year = ((int) $cyear )+1911;
$mon = substr($in_date, -4, 2);
$day = substr($in_date, -2);

$date = date("Y-m-d", mktime (0,0,0,$mon ,$day, date($year)));
return $date;

}


//轉民國，後面參數為分隔符號自訂
function dateTo_c($in_date, $in_txt="")
{

    $ch_date = explode("-", $in_date);
    $ch_date[0] = $ch_date[0]-1911;
    $date = '00.00.00';
    
    
    if ($in_txt=="")
    {
        $date = '000000';
        if ($ch_date[0] > 0 ) $date = $ch_date[0]."".$ch_date[1]."".$ch_date[2];
        
    }
    else
    {
        if ($ch_date[0] > 0 ) $date = $ch_date[0]."$in_txt".$ch_date[1]."$in_txt".$ch_date[2];
    }

    return $date;

}

function addToHbase($court , $number , $type , $case , $date , $context ){
	$socket = new TSocket( 'localhost' , 9090 );
	$transport = new TBufferedTransport( $socket );
	$protocol = new TBinaryProtocol( $transport );
	$client = new HbaseClient( $protocol );
	$transport->open();

	/* Add key */
	$mutation = new Mutation( array("column" => "key:" , "value" => $number));
	$client->mutateRow("BigLaw" , $row_key , array($mutation));
	/* Add Type */
	$mutation = new Mutation( array("column" => "M:Type" , "value" => $type ));
	$client->mutateRow("BigLaw" , $row_key , array($mutation));
	/* Add Number */
	$mutation = new Mutation( array("column" => "M:Number" , "value" => $number ));
	$client->mutateRow("BigLaw" , $row_key , array($mutation));
	/* Add Case */
	$mutation = new Mutation( array("column" => "M:Case" , "value" => $case ));
	$client->mutateRow("BigLaw" , $row_key , array($mutation));
	/* Add Court */
	$mutation = new Mutation( array("column" => "M:Court" , "value" => $court ));
	$client->mutateRow("BigLaw" , $row_key , array($mutation));
	/* Add Context */
	$mutation = new Mutation( array("column" => "M:Context" , "value" => $context ));
	$client->mutateRow("BigLaw" , $row_key , array($mutation));
	/* Add Date */
	$mutation = new Mutation( array("column" => "M:Date" , "value" => $date ));
	$client->mutateRow("BigLaw" , $row_key , array($mutation));
}

$type = $_POST['type'];
$number = $_POST['number'];
$case = $_POST['case'];
$court = $_POST['court'];
$context = $_POST['context'];
$date = dateTo_ad($_POST['date']);
$row_key = $number;

if($type == "") exit;
if($number == "") exit;
if($case == "") exit;
if($court == "") exit;
if($context == "") exit;
if($date == "") exit;

addToHbase($court , $number ,$type ,$case , $date  , $context);
//addToHbase("臺灣台北地方法院" , "103,交簡,711" ,"刑事類" ,"賭博","2014-03-03"  , $context);

header("Location:hbaseint.php");