<?php
	error_reporting(0);
   
	try
    {
		$user = $_POST["user"];
    	$pass = $_POST["pass"];
    	
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
    	
    	fclose($file);
    	
    	$data = json_decode($content,true);
    	if(array_key_exists($user,$data))
    	{
    		$realPass = $data[$user];
        	if($realPass == $pass)
        	{
        		//密码正确
            	showMsg("已登录","你好，".$user."！");
        	}	
        	else
        	{
            	//密码错误
        		showMsg("未登录","密码错误。");
        	}
    	}
    	else
    	{
        	//用户名在 users.json 中找不到
        	showMsg("无法登录","服务器中不存在此账户，你可以尝试<a href='../reg.html'>注册</a>。");
    	}
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