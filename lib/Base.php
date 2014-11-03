<?php

final class Base
{
    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Base();
        }
        return $inst;
    }

    private function __construct()
    {

    }
	
	public function createCookie()
	{
		$crypt = new CkCrypt2() ;

	    $success = $crypt->UnlockComponent("WILLAWCrypt_KM8tJZPHMRLn");
	    if ($success != true) {
	        printf("%s\n",$crypt->lastErrorText());
	        return "";
	    }

		$crypt->put_CryptAlgorithm("aes");
	    $crypt->put_CipherMode("cbc");
	    $crypt->put_KeyLength(256);
	    $crypt->put_PaddingScheme(0);
	    $crypt->put_EncodingMode("hex");

    	return $crypt->genRandomBytesENC(32);
	}
	
	public function encrypt($src)
	{
		$crypt = new CkCrypt2();
		$success = $crypt->UnlockComponent('WILLAWCrypt_KM8tJZPHMRLn');
		if ($success != true) {
		    print $crypt->lastErrorText() . "\n";
		    return "";
		}

		$crypt->put_CryptAlgorithm('aes');
		$crypt->put_CipherMode('cbc');
		$crypt->put_KeyLength(256);
		$crypt->put_PaddingScheme(0);
		$crypt->put_EncodingMode('hex');

		$ivHex = '100102030405060708090A0B0C0D0E0E';
		$crypt->SetEncodedIV($ivHex,'hex');
		$keyHex = '100102030405060708090A0B0C0D0E0F101112131415161718191A1B1C1D1E1E';
		$crypt->SetEncodedKey($keyHex,'hex');

		$encStr = $crypt->encryptStringENC($src);
		return $encStr;
	}
	
	public function decrypt($src)
	{
		$crypt = new CkCrypt2();
		$success = $crypt->UnlockComponent('WILLAWCrypt_KM8tJZPHMRLn');
		if ($success != true) {
		    print $crypt->lastErrorText() . "\n";
		    return "";
		}

		$crypt->put_CryptAlgorithm('aes');
		$crypt->put_CipherMode('cbc');
		$crypt->put_KeyLength(256);
		$crypt->put_PaddingScheme(0);
		$crypt->put_EncodingMode('hex');

		$ivHex = '100102030405060708090A0B0C0D0E0E';
		$crypt->SetEncodedIV($ivHex,'hex');
		$keyHex = '100102030405060708090A0B0C0D0E0F101112131415161718191A1B1C1D1E1E';
		$crypt->SetEncodedKey($keyHex,'hex');
		
		$decStr = $crypt->decryptStringENC($src);
		return $decStr;
	}
}