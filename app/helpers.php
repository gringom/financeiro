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

function getTypes( $main = false ){
	if ( $main == true ){
		return array('entrada' => 'Entrada', 'saida' => 'Saída');
	}
	return array('entrada' => 'Entrada', 'saida' => 'Saída', 'a_receber' => 'A Receber', 'a_pagar' => 'A Pagar');
}

function br_num_format( $s , $money = false ){
	$s = (float)$s ;
	if ( $money === true ) {
			$money = 2;
	}
	return number_format( $s , $money ? $money : strlen( substr( $s , strpos( $s , "." ) !== false ? strpos( $s , "." ) + 1 : strlen( $s ) ) ) , "," , "." ) ;
}

function getSumClass( $value = 0 ){
	if( $value >= 0 && $value <= 10000 ){
		return "warning";
	}
	else if ( $value > 10000 ){
		return "info";
	}
	else {
		return "danger";
	}
}