<!DOCTYPE html>
<html>
<head>
	<title>insert data to hbase</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head> 
<body>
	<h1>Insert RefereeBook to HBase NoSQL Server</h1>
<form action="inbase.php" method="post">
	 <!--<p><label>Key:<input type="text" name="key" /></label></p>-->
 	<p><label>Type:<input type="text" value="刑事類" name="type" /></label></p>
 	<p><label>Number:<input type="text" name="number" /></label></p>
 	<p><label>Case:<input type="text" name="case"  /></label></p>
 	<p><label>Court:<input type="text" value="臺灣台北地方法院" name="court"  /></label></p>
 	<p><label>Date:<input type="text" name="date" value="1030303" /></label></p>
 	<p><label>Context:<textarea name="context" style="width:400px;height:300px" ></textarea> </label></p>
 	<input type="submit" value="insert" />
</form>
</body>
</html>
