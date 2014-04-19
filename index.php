<!DOCTYPE html>
<html>
<head>

</head>

<body>
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
/*
//open connection
$socket = new TSocket( 'localhost', 9090 );
$transport = new TBufferedTransport( $socket );
$protocol = new TBinaryProtocol( $transport );
$client = new HbaseClient( $protocol );
$transport->open();
//show all tables
$tables = $client->getTableNames();
/*foreach ( $tables as $name ) {
	echo( "  found: {$name}\n" );
}
*/

//get table data

/*
Hive php thrift client
*/
 
//open connection
$transport = new TSocket("localhost", 10000);
$protocol = new TBinaryProtocol($transport);
$client = new ThriftHiveClient($protocol);
$transport->open();
//show tables
$client->execute('select mcase, mcontext from `biglaw`');
$rows = $client->fetchAll();
foreach ($rows as $row){
        echo "<fieldset>";
	print_r( str_replace( '\n' , "<br />" ,$row ));
        echo "<br />";
        echo "</fieldset>";
}

?>
</body>
</html>
