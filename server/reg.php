<?php
	error_reporting(0);

	try
   	{
		$user = $_POST["user"];
    	$pass = $_POST["pass"];
    	$passed = $_POST["passed"];
    	
    	if($pass!=$passed)	
    	{
        	showMsg("注册失败","两次输入的密码不同，请重试。");
        	return;
    	}
    	
    	$path = "../data/users.json";
    	
    	if(!file_exists($path) or filesize($path)==false)
    	{
        	$mfile = fopen($path, "w");
    		fwrite($mfile,"{}");
        	$content = "{}";
        	fclose($mfile);
    	}
    	$file = fopen($path, "r+");
    	$content = fread($file,filesize($path));
    	
    	$data = json_decode($content,true);
    	if(array_key_exists($user,$data))
    	{
    		showMsg("无法注册","服务器中已存在此账户，你可以尝试<a href='../index.html'>登录</a>。");
    	}
    	else
    	{
        	$mfile = fopen($path, "w");
			$data[$user] = $pass;
      		fwrite($mfile,json_encode($data));
        	fclose($mfile);
        	showMsg("注册成功","现在可以尝试<a href='../index.html'>登录</a>。");
    	}
    	fclose($file);
    }
    catch(Exception $e)
    {
    	showMsg("出错了","错误信息：".$e->getMessage()."。");
    }
    
    function showMsg($title,$msg)
    {
        $file = fopen("../alert.html","r");
    	echo (str_replace("MSG",$msg,str_replace("TITLE",$title,fread($file,filesize("../alert.html")))));
    	fclose($file);
    }
?>