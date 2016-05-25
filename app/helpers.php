<?php

function flash( $message, $level = "info")
{
	session()->flash( "flash_message" , $message );
	session()->flash( "flash_message_level" , $level );
}

function print_pre( $arr )
{
	print "<pre>";
	print_r( $arr );
	print "</pre>";
}
