<?php 
	$db_user="rsgl";
	$db_pwd="rsgl";

	// 方式一：oci_connect()链接Oracle，

	// resource oci_connect ( string $username , string $password [, string $db [, string $charset [, int $session_mode ]]] )

	// 参数3：字符编码，Oracle 10g 的 Easy Connect 串格式：[//]host_name[:port][/service_name]。Oracle 11g 则为：[//]host_name[:port][/service_name][:server_type][/instance_name]。服务名可在数据库服务器机器上运行 Oracle 实用程序 lsnrctl status 找到。

	// 参数4：会话模式，此参数在 PHP 5（PECL OCI8 1.1）版本开始可用，并收受下列值：OCI_DEFAULT，OCI_SYSOPER 和 OCI_SYSDBA。如为 OCI_SYSOPER 或 OCI_SYSDBA 其中之一
	$conn=oci_connect($db_user, $db_pwd, "//192.168.31.10/orcl","utf8");
	$sql="select * from t_dw where rownum<11";
	$stmt = oci_parse($conn, $sql);
	oci_execute($stmt, OCI_DEFAULT);
	while ($row=oci_fetch_assoc($stmt)) {
		$data[]=$row;
	}
	var_dump($data);


    // 方式二：PDO方法链接Oracle
    // PDO::__construct ( string $dsn [, string $username [, string $password [, array $driver_options ]]] )
    // Connect to a database defined in tnsnames.ora
	//oci:dbname=mydb

	// Connect using the Oracle Instant Client
	// oci:dbname=//localhost:1521/mydb
    try {
		$dsn="oci:dbname=//192.168.31.10:1521/orcl;charset=utf8";
		$pdo=new pdo($dsn,$db_user,$db_pwd);
    } catch (PDOException $e) {
    	die($e->getMessage());
    }

	$stat=$pdo->query($sql);
	// $stat->execute();
	$data=$stat->fetchAll(PDO::FETCH_ASSOC);

	var_dump($data);