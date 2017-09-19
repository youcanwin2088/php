mysql库一般在用文本文件(source *.sql)或者控制台输入insert语句，来导入数据的时候，需要set names gbk,设置gbk会正确保存中文字符,并且在控制台正确显示中文，即使建设库的用的是utf8.（在文本文件里设置，控制台也一样
 <br>SET NAMES gbk
 <br>SET character_set_client = gbk */
 <br>像ENGINE=InnoDB AUTO_INCREMENT=1016 DEFAULT CHARSET=utf8;这个不需要变
 
 <br> 
 如果用的是set names latin1，虽然可以正确保存中文，但是保存的都是latin1格式，所以在用程序如php,读取时会比较麻烦，需要从utf8转换称gbk， 注意是utf8（用mb_convert_encoding函数），而不是latin1,而服务器端最终保存的都是utf8.<br>
 如果用set names utf8，反而无法正确保存中文,不要用utf8<br>
 
 <br>在php语句里使用传统的mysql_connect后，在php5.2.*版本里，需要申明结果集用utf8格式   
 mysql_query("SET character_set_results =utf8");
 而在php5.6版本里，则不需要；其它版本的php未测试 <br>
 
 http://www.jb51.net/article/30864.htm<br>

-----------------------------------    
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
    $mysql_database="timesheet"; // 数据库的名字
    
    // 连接到数据库
    
    print_r(iconv_get_encoding()); 
    
    echo "<br><br>表内容<br>";
    
    $conn=mysql_connect($mysql_server_name, $mysql_username,
                        $mysql_password);
    
    mysql_query("SET character_set_results =utf8");
                        
    //mysql_query("set names latin1");
    //mysql_set_charset('utf8', $conn); 
        
    //执行插入
    if( $_POST['firstname'] != ''){
        
        //$strsql="INSERT INTO s values('".mb_convert_encoding('提取信息',"gbk","utf-8")."')";
        echo "表单数据=".$_POST['firstname']."<br>" ;
        $strsql="INSERT INTO s values('".mb_convert_encoding($_POST['firstname'],"gbk","utf-8")."')";
        echo $strsql;
        
        $result=mysql_db_query($mysql_database, $strsql, $conn);
    }
    
                        
     // 从表中提取信息的sql语句
    $strsql="SELECT id,name,login FROM no_members limit 470,15";    
    //$strsql="SELECT name FROM s";
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
        echo $row[$i];
        //echo mb_convert_encoding($row[$i],"UTF-8","gbk");
        
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
  