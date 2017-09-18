   
<form action="./mysql-insert.php" method="post">
Firstname: <input type="text" name="firstname" />
<input type="submit" value="插入这个表单数据"/>


 <?php
  
    //echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
    header ( "Content-type:text/html;charset=utf8" ); 
    
    echo "<br><br>当前页面编码</br>"; 

    $mysql_server_name="127.0.0.1"; //数据库服务器名称
    $mysql_username="root"; // 连接数据库用户名
    $mysql_password="111111"; // 连接数据库密码
    $mysql_database="t1"; // 数据库的名字
    
    // 连接到数据库
    
    print_r(iconv_get_encoding()); 
    
    echo "<br><br>表内容<br>";
    
    $conn=mysql_connect($mysql_server_name, $mysql_username,
                        $mysql_password);
    
   // mysql_query("SET character_set_result =gbk");
                        
    //mysql_query("set names latin1");
    //mysql_set_charset('utf8', $conn); 
        
                        
     // 从表中提取信息的sql语句
    //$strsql="SELECT id,name,login FROM no_members limit 470,15";
    
    //执行插入
    if( $_POST['firstname'] != ''){
        
        //$strsql="INSERT INTO s values('".mb_convert_encoding('提取信息',"gbk","utf-8")."')";
        echo "表单数据=".$_POST['firstname']."<br>" ;
        $strsql="INSERT INTO s values('".mb_convert_encoding($_POST['firstname'],"gbk","utf-8")."')";
        echo $strsql;
        
        $result=mysql_db_query($mysql_database, $strsql, $conn);
    }
    
    
    $strsql="SELECT name FROM s";
    // mysql_query("SET character_set_results = utf8");  
    // 执行sql查询
    
    
    
    $result=mysql_db_query($mysql_database, $strsql, $conn);
     
    // 获取查询结果
    $row=mysql_fetch_row($result);
    
     
    echo '<font face="verdana">';
    echo '<table border="1" cellpadding="1" cellspacing="2">';

    // 显示字段名称
    echo "</b><tr></b>";
    for ($i=0; $i<mysql_num_fields($result); $i++)
    {
      echo '<td bgcolor="#00FF00"><b>'.
      mysql_field_name($result, $i);
      echo "</b></td></b>";
    }
    echo "</tr></b>";
    // 定位到第一条记录
    mysql_data_seek($result, 0);
    // 循环取出记录
    while ($row=mysql_fetch_row($result))
    {
      echo "<tr></b>";
      for ($i=0; $i<mysql_num_fields($result); $i++ )
      {
        echo '<td bgcolor="#00FF00">';
        
        //echo iconv("UTF-8","gb2312//IGNORE",$row[$i]) ;
        //echo mb_detect_encoding($row[$i]);
        
        //echo iconv("UTF-8", "gb2312", $row[$i]);
        $name1= "记录2";
        //echo iconv("UTF-8", "UTF-8", $name1);;
        //echo mb_detect_encoding($name1);
        
        //echo mb_convert_encoding($name1,"UTF-8","UTF-8")." ";
        //echo $row[$i];
        echo mb_convert_encoding($row[$i],"UTF-8","gbk");
        
        echo '</td>';
      }
      echo "</tr></b>";
    }
   
    echo "</table></b>";
    echo "</font>";
    // 释放资源
    mysql_free_result($result);
    
    //

    // 关闭连接
    mysql_close($conn);  
    
    
?>

</form>
  