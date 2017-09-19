1.mysql库(假设库的编码都是用utf8保存），那么一般在Windows命令控制台输入insert语句时，如若要正确保存中文以utf8方式,并且在控制台显示中文，那么需要输入命令:
 <br>SET NAMES gbk （这一句是让三个变量都为gbk）
 输入这一句后用show variables like 'chara%'; 可以看到3个字符集（ character_set_client，character_set_connection，character_set_results）都设置成了gbk,紧接着用：
 <br>insert into s values('我们你');
 <br>这样的语句是可以插入中文，但是最终保存的中文格式并不是
 utf8而是gbk格式，这个和用php或其他java程序等以utf8方式插入会有区别，会显示成乱码,
 解决办法就是再加一句 
 <br>SET character_set_connection = utf8;
 <br>这一句是重置character_set_connection=utf8,这样character_set_client=gbk格式会被转换成utf8保存
 起来，最终写入数据库的都是utf8.
 
 
<br><br>2.用文本文件(source *.sql)来导入数据的时候，文本文件里所有的地方都用utf8,文件格式也用utf8
然后在控制台运行set names utf8,
然后运行 source *.sql 来导入文本文件的内容到数据库。
但是这个时候在控制台不能正确显示中文，那么运行
 <br>SET character_set_results = gbk */
 就可以了；如果这个时候再想从控制台直接用语句插入中文那么运行
 <br>SET character_set_connection = gbk 

<br>
<br>参考文章<a href="http://blog.csdn.net/fdipzone/article/details/18180325">http://blog.csdn.net/fdipzone/article/details/18180325</a><br>

-----------------------------------  
页面测试：
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
    
    //mysql_query("SET character_set_results =utf8");
                        
    mysql_query("set names utf8");
    //mysql_set_charset('utf8', $conn); 
        
    //执行插入
    if( $_POST['firstname'] != ''){
        
        //$strsql="INSERT INTO s values('".mb_convert_encoding('提取信息',"gbk","utf-8")."')";
        echo "表单数据=".$_POST['firstname']."<br>" ;
        
        //$strsql="INSERT INTO s values('".mb_convert_encoding($_POST['firstname'],"gbk","utf-8")."')";
        echo $strsql;
        $strsql="INSERT INTO s values('".$_POST['firstname']."')";
        echo $strsql;
        
        $result=mysql_db_query($mysql_database, $strsql, $conn);
    }
    
                        
     // 从表中提取信息的sql语句
    //$strsql="SELECT id,name,login FROM no_members limit 470,15";    
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
  