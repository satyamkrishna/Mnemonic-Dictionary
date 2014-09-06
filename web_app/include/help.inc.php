<?php

function print_val($array)
{
	foreach($array as $a)
	{
		echo $a.'<br />';
	}
}

function postSession($value = false)
{
	if(sizeof($_POST)>0)
	{
		$div = 5;
		if(sizeof($_POST)%$div ==0)
		{
			$div = 4;
		}
		$count = 1;
		$message = 'if(isset(';
		foreach ($_POST as $key=>$val)
		{
			$message .= '$_POST[\''.$key.'\'],';
			if($count++%$div==0)
			{
				$message .= '<br />';
			}
		}
		
		$message = substr($message, 0 ,strlen($message)-1).'))<br />{<br />';
		$count = 1;
		$message .= 'if(';
		foreach ($_POST as $key=>$val)
		{
			$message .= '!empty($_POST[\''.$key.'\']) &&';
			if($count++%$div==0)
			{
				$message .= '<br />';
			}
		}
		
		$message = substr($message, 0 ,strlen($message)-3).')<br />{<br/><br/> ';
		foreach ($_POST as $key=>$val)
		{
			if($value == true)
			{
				$message .= 'echo ';
			}
			$message .= '$'.$key.' = htmlentities($_POST[\''.$key.'\'])';
			if($value == true)
			{
				$message .= '.\'<code>&lt;br &#47;&gt;</code>\' ';
			}
			$message .= ';<br />';
		}
			
		
		$message .= '<br/><br/>// Variable ->  ';
		foreach ($_POST as $key=>$val)
		{
			$message .= '$'.$key.',';
		}
		$message .= '<br /><br />// Write Your Code Here<br/>}<br />}<br />';
		echo $message;
		
		die();
	}
	else
	{
	}
}

function getSession($value = false)
{
    if(sizeof($_GET)>0)
    {
        $div = 5;
        if(sizeof($_GET)%$div ==0)
        {
            $div = 4;
        }
        $count = 1;
        $message = 'if(isset(';
        foreach ($_GET as $key=>$val)
        {
            $message .= '$_GET[\''.$key.'\'],';
            if($count++%$div==0)
            {
                $message .= '<br />';
            }
        }

        $message = substr($message, 0 ,strlen($message)-1).'))<br />{<br />';
        $count = 1;
        $message .= 'if(';
        foreach ($_GET as $key=>$val)
        {
            $message .= '!empty($_GET[\''.$key.'\']) &&';
            if($count++%$div==0)
            {
                $message .= '<br />';
            }
        }

        $message = substr($message, 0 ,strlen($message)-3).')<br />{<br/><br/> ';
        foreach ($_GET as $key=>$val)
        {
            if($value == true)
            {
                $message .= 'echo ';
            }
            $message .= '$'.$key.' = htmlentities($_GET[\''.$key.'\'])';
            if($value == true)
            {
                $message .= '.\'<code>&lt;br &#47;&gt;</code>\' ';
            }
            $message .= ';<br />';
        }


        $message .= '<br/><br/>// Variable ->  ';
        foreach ($_GET as $key=>$val)
        {
            $message .= '$'.$key.',';
        }
        $message .= '<br /><br />// Write Your Code Here<br/>}<br />}<br />';
        echo $message;

        die();
    }
    else
    {
    }
}

?>