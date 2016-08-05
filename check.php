<?php
  function read_dir(&$result,&$filenum,$dirname){
	  $num = 0;
	  $dir_handle = opendir($dirname);
    $file = array();
	  while($file = readdir($dir_handle)) {
	    if($file != "." && $file != "..") {
	      $dirFile = $dirname."/".$file;
	      $filenum ++;
        if (!is_dir($dirFile)) {
  	      $md5 = md5_file($dirFile);
  	      if($result[$md5] == "") {
  	        $result[$md5] = array();
  	        $result[$md5][] = $dirFile;
  	      } else $result[$md5][] = $dirFile;
	      } else {
          read_dir($result,$filenum,$dirFile);
          $filenum --;
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
	read_dir($result, $filenum, $dirname);
	$numofdir1 = $filenum;
	$filenum = 0;
	read_dir($result1, $filenum, $dirname1);
	$numofdir2 = $filenum;
	/*foreach ($result as $key => $value) {
		echo "$key"." ";
		foreach ($value as $k => $v)
			echo "$v"." ";
		echo "<br>";
	}
	echo "total of $numofdir1 files.";
	echo "<br>";
	foreach ($result1 as $key1 => $value1) {
		echo "$key1"." ";
		foreach ($value1 as $k => $v)
			echo "$v"." ";
		echo "<br>";
	}
	echo "total of $numofdir2 files.";*/

	$same = array();
	$differ1 = array();
	$differ2 = array();
	foreach ($result as $key => $value) {
		if ($result1[$key]=="") {
			$differ1[$key] = array();
			$differ1[$key] = $value;
		}
	}
	foreach ($result1 as $key => $value) {
		if ($result[$key]=="") {
			$differ2[$key] = array();
			$differ2[$key] = $value;
		}
	}
	foreach ($result as $key => $value) {
		if ($result1[$key] != "") {
			$same[$key] = array();
			$same[$key] = $value;
		}
	}
	/*echo "<br>";
	foreach ($differ1 as $key => $value) {
		echo "$key"." ";
		foreach ($value as $k => $v)
			echo "$v"." ";
		echo "<br>";
	}
	echo "<br>";
	foreach ($differ2 as $key1 => $value1) {
		echo "$key1"." ";
		foreach ($value1 as $k => $v)
			echo "$v"." ";
		echo "<br>";
	}
	echo "<br>";
	foreach ($same as $key1 => $value1) {
		echo "$key1"." ";
		foreach ($value1 as $k => $v)
			echo "$v"." ";
		echo "<br>";
	}*/
	echo '<table border="1" align="center" width="960px" cellspacing="0" cellpadding="0">';
  echo '<caption><h2>目录'.$dirname.'与'.$dirname1.'中文件差异比较</h2></caption>';
  echo '<tr align="left" bgcolor="#cccccc">';
  echo '<th>目录名</th><th>文件数</th></tr>';
  echo '<tr bgcolor="#cccccc">';
  echo '<td>'.$dirname.'</td>';
  echo '<td>'.$numofdir1.'</td>';
  echo '</tr>';
  echo '<tr bgcolor="#cccccc">';
  echo '<td>'.$dirname1.'</td>';
  echo '<td>'.$numofdir2.'</td>';
  echo '</tr>';
  echo '</table>';
  echo '<form name="form1" method="post" action="">';
  echo '<div align="center" style="margin-top:20px"><input type="submit" name="scan" value="scan"></div>';
  echo '</form>';	

  if ($_POST["scan"] != "") {
  	# code...
  	echo '<table border="0" align="center" width="200px" cellspacing="0" cellpadding="0">';
  	echo '<tr><p style="text-align:center">扫描完成。</p></tr>';
  	echo '<tr>';
  	echo '<form method="post" action=""><td align="left"><input type="submit" name="same" value="显示相同文件"></td></form>'	;
  	echo '<form method="post" action=""><td align="right"><input type="submit" name="different" value="显示不同文件"></td></form>';
  	echo '</tr>';
  	echo '</table>';
  }

  if ($_POST["same"] != "") {
  	echo '<table border="1" align="center" width="960px" cellspacing="0" cellpadding="0">';
  	echo '<tr align="left" bgcolor="#cccccc">';
 		echo '<th>md5值</th><th>目录'.$dirname.'中的文件路径</th><th>目录'.$dirname1.'中的文件路径</th></tr>';
 		$count = 0;
  	foreach ($same as $key => $value) {
  		if($count++%2 == 0)
        $bgcolor = "#ffffff";
      else
        $bgcolor = "#cccccc";
      if(count($value) > 1 || count($result1[$key]) > 1) {
  			echo '<tr bgcolor='.$bgcolor.'>';
  			echo '<td>'.$key.'</td>';
  			echo '<td>';
  			foreach ($value as $k => $v)
  				echo '<a href='.$v.'>'.$v.'</a>'.'<br>';
  			echo "</td>";
  			echo "<td>";
  			foreach ($result1[$key] as $k => $v)
  				echo '<a href='.$v.'>'.$v.'</a>'.'<br>';
  			echo '</td></tr>';
      }
  }
		echo '</table>';
  }
  if ($_POST["different"]!="") {
    echo '<div style="width:460px; float: left;">';
    echo '<table border="1" align="center" width="460px" cellspacing="0" cellpadding="0">';
    echo '<tr align="left" bgcolor="#cccccc">';
    echo '<th>文件夹'.$dirname.'中具有的不同文件</th></tr>';
    $count = 0;
    foreach ($differ1 as $key => $value) {
      if($count++%2==0)
        $bgcolor="#ffffff";
      else
         $bgcolor="#cccccc";
      echo '<tr bgcolor='.$bgcolor.'>';
      #echo '<td>'.$key.'</td>';
      echo '<td>';
      foreach ($value as $k => $v)
        echo '<a href='.$v.'>'.$v.'</a>'.'<br>';
      echo '</td></tr>';
    }
    echo '</table>';
    echo '</div>';
    echo '<div style="width:460px; float: right;">';
    echo '<table border="1" align="center" width="460px" cellspacing="0" cellpadding="0">';
    echo '<tr align="left" bgcolor="#cccccc">';
    echo '<th>文件夹'.$dirname1.'中具有的不同文件</th></tr>';
    foreach ($differ2 as $key => $value) {
      if($count++%2==0)
        $bgcolor="#ffffff";
      else
        $bgcolor="#cccccc";
      echo '<tr bgcolor='.$bgcolor.'>';
      #echo '<td>'.$key.'</td>';
      echo '<td>';
      foreach ($value as $k => $v)
        echo '<a href='.$v.'>'.$v.'</a>'.'<br>';
      echo '</td></tr>';
    }
    echo '</table>';
    echo '</div>';
  }
?>