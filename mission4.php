<?php
header('Content-Type: text/html; charset=UTF-8');

$dsn  =  'データベース名';

$user  =  'ユーザー名';
$password  =  'パスワード';
$pdo  =  new  PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>


<?php

$sql="CREATE TABLE if not exists ykk2 (id INT PRIMARY KEY AUTO_INCREMENT,name char(32),comment TEXT,date datetime,pass char(32));";
$stmt =  $pdo->query($sql);

$sql = 'SELECT*FROM ykk2 ';
$results = $pdo -> query($sql);

$name = $_POST['name'];
$comment = $_POST['comment'];
$number = $_POST['number'];
$number2 = $_POST['number2'];
$number2sub = $_POST['number2sub'];
$passward = $_POST['passward'];
$passward1 = $_POST['passward1'];
$passward2 = $_POST['passward2'];



#通常の処理

 if((!empty($name) or !empty($comment)or !empty($passward)) and empty($number2sub)){
 
 $sql =  $pdo  ->  prepare("INSERT INTO ykk2 (name,comment,date,pass)  VALUES  (:name,:comment,NOW(),:pass)");
 $sql ->  bindParam(':name',$name,PDO::PARAM_STR);
 $sql ->  bindParam(':comment',$comment,PDO::PARAM_STR); 
 $sql ->  bindParam(':pass',$passward,PDO::PARAM_STR); 

 
 $sql ->  execute();

 }


//削除機能

if(!empty($number)){ 
$sql='SELECT*FROM  ykk2';
$results=$pdo->query($sql);
$date=$results->fetchAll();
foreach($date as $row){
    
     if($row['id']==$number){
      if($row['pass']==$passward1) {       
       $sql4="delete from ykk2 where id=$number";
       $result=$pdo->query($sql4);
       }
     else{ 
       $error = "パスワードが違います！";
           }
     }
  }
 }

#編集機能１

  if(!empty($number2)){
  $sql='SELECT*FROM  ykk2';
  $results=$pdo->query($sql);
  $date=$results->fetchAll();
   foreach($date as $row){
    
    if($row['id']==$number2){
      if($row['pass']==$passward2) { 
       $edit = $row['id'];
       $edit1 = $row['name'];
       $edit2 = $row['comment'];
      }
      else{ $error = "パスワードが違います！";
      }
     }
    }
   }

?>


<html>
<head><meta charset="UTF-8"><?php echo $error; ?></head>
<body>
<form  method = "post" >
<input type = "text" name = 'name' placeholder = "名前" value="<?php echo $edit1;?>"size=20>
<br>
<input type = "text" name = 'comment' placeholder = "コメント"value="<?php echo $edit2;?>"size=20>
<br>
<input type =  "text" name = "passward" placeholder = "パスワード">
<input type = "submit"value = "送信" >
<input type ="text" name = 'number2sub' style ="visibility:hidden" value= <?php echo $edit;?> >
<br>
<br>
 <input type = "text" name = "number" placeholder = "削除行番号" size = "20">
<br>
<input type = "text" name = "passward1" placeholder = "パスワード">
<input type = "submit"value = "削除" >
<br>
<input type = "text" name = "number2" placeholder = "編集行番号" size = "20">
<br>
<input type = "text" name = "passward2" placeholder = "パスワード">
<input type = "submit"value = "編集" >
<br>
</form>
</body>

//編集機能2
<?php

if(!empty($number2sub)){
  $sql='SELECT*FROM  ykk2';
  $results=$pdo->query($sql);
  $date=$results->fetchAll();
   foreach($date as $row){
    if(!($row['id']==$number2sub)){
      $sql5="update ykk2 set name = '$name',comment='$comment' where id =$number2sub";
      $result=$pdo->query($sql5);
     }
    }
}

$sql='SELECT*FROM ykk2';
$results=$pdo->query($sql);
$results->execute();
foreach($results as $row){
 echo $row['id'].',';
 echo $row['name'].',';
 echo $row['comment'].',';
 echo $row['date'].'<br>';
}

?>
<html>