<?php
include_once(dirname(__FILE__).'/../includes/functions.php');
include_once(dirname(__FILE__).'/../includes/session.php');

$c_code="#include<stdio.h>

int main()
{
	//your code
	return 0;
}
";

$c_input="";
$c_output="";
$tmp="tmp\\";
$save_name='';
$check='';

if(isset($_SESSION['edit']))
{
    $c_code=$_SESSION['edit'];
    unset($_SESSION['edit']);
    $save_name=$_SESSION['save-name'];
    unset($_SESSION['save-name']);
}


if(!isset($_SESSION['user'])) header('Location: index.php');

if(isset($_POST['submit']))
{
    $file = rename_extension(tempnam($tmp, ""),$tmp,'.c');
    $file_handle = fopen($file, "w");
    $input = change_extension($file,$tmp,'.input');
    $input_handle = fopen($input, "w");
    $c_code=$_POST['c_code'];
    fwrite($file_handle,$c_code);
    $c_input=$_POST['c_input'];
    fwrite($input_handle,$c_input);
    fclose($file_handle);
    fclose($input_handle);
    if(isset($_POST['save'])&&$_POST['save']=='save')
    {
        $check='checked';
        $save_name=get_base_name($_POST['save-name']);
        if($save_name=='') $save_name=get_base_name($file);
        $tf=dirname(__FILE__).'/../tmp/'.get_base_name($file).'.c';
        if($_SESSION['user']!='')
        {
            $uname=$_SESSION['user'];
            $user_folder_fname = dirname(__FILE__).'/../data/'.$_SESSION['user'].'/'.$save_name.'.c';
            if(!copy($tf,$user_folder_fname)) $_SESSION['error']='unable to save file';
            else $_SESSION['error']="saved file <a style='color: #f48042;' href='/users/view.php?uname=$uname&fname=$save_name.c'> $save_name.c </a> to user public saved files";
        }
        else $_SESSION['error']='unable to save file';
    }
    else $_SESSION['error']='';
    $executable = change_extension($file,$tmp,'.exe');
    $error = change_extension($file,$tmp,'.err');
    system("gcc ".$file.' -o '.$executable.' 2> '.$error);
    if(filesize($error)>0)
    {
        $error_handle=fopen($error,"r");
        $c_output=fread($error_handle,filesize($error));
        fclose($error_handle);
    }else{
    $file_name=get_base_name($file);
    $exec_res=exec("cd tmp && start \"$file_name\" /B $file_name.exe < $file_name.input > $file_name.output & timeout /t 1 & Taskkill /im $file_name.exe /f");
    $output= change_extension($file,$tmp,'.output');
    if(!$exec_res)
    {
    $output_handle=fopen($output,"r");
    $output_file_size=filesize($output);
    if($output_file_size>0) $c_output=fread($output_handle,$output_file_size);
    fclose($output_handle);
    }
    else $c_output='Time Limit Exceeded';
    unlink($output);
    unlink($executable);
    }
    unlink($error);
    unlink($file);
    unlink($input);
}
?>