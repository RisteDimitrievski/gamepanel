<?php 
namespace App\Repository;

class FunctionsRepository
{
	public function _clean_input($data)
	{
		$input = htmlspecialchars(htmlentities(trim($data)));
		return $input;
	}
	public function randomString()
	{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}
		
}
