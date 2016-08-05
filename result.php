<?php
	 function read_dir(&$result,&$filenum,$dirname){
      $num = 0;
      $dir_handle = opendir($dirname);
      $file = array();
      while($file = readdir($dir_handle)){
        if($file!="." && $file!=".."){
          $dirFile = $dirname."/".$file;
          $filenum++;
          #echo "one";
          if (!is_dir($dirFile)){
          $md5 = md5_file($dirFile);
          if($result[$md5]==""){
            $result[$md5] = array();
            $result[$md5][] = $dirFile;
          }
          else $result[$md5][] = $dirFile;
        }else{
          read_dir($result,$filenum,$dirFile);
          $filenum--;
        }
        }
      }
      closedir($dir_handle);
    }
    $dirname = "1";
    $dirname1 = "2";
    $filenum = 0;
    $result = array();
    $result1 = array();
    read_dir($result1, $filenum, $dirname1);
    $numofdir1 = $filenum;
    $filenum = 0;
    read_dir($result, $filenum, $dirname);
    $numofdir2 = $filenum;
    foreach ($result as $key => $value) {
      echo "$key"." ";
      foreach ($value as $k => $v){
          echo '<a href='.$v.'>'.$v.'</a>'.'|';
      }
      echo "<br>";
    }
    echo "total of $numofdir2 files.";
    echo "<br>";
    foreach ($result1 as $key1 => $value1) {
      echo "$key1"." ";
      foreach ($value1 as $k => $v){
        echo '<a href='.$v.'>'.$v.'</a>'.'|';
      }
      echo "<br>";
    }
    echo "total of $numofdir1 files.";
?>