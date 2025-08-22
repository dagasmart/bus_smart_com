<?php

namespace App\Library;

/**
 * //$aes = new Aes();
 * //$ciphertext = $aes->encrypt(json_encode(['module'=>admin_current_module(), 'mer_id'=>admin_mer_id(), 'lat'=>microtime(true)], JSON_THROW_ON_ERROR));
 * //dump($ciphertext);
 * //$plainText = $aes->decrypt($ciphertext);
 * //dump($plainText);
 *
 */
class Aes
{

    // AES加密
    private string $key = 'e10adc3949ba59abbe56e057f20f883e';//密钥
    private string $method = 'AES-128-ECB';//类型
    private string $iv = '';//向量值


    public function __construct($config = [])
    {
        foreach ( $config as $k => $v ) {
            $this->$k = $v;
        }
    }
    //加密
    public function encrypt($data): string
    {
        return base64_encode(openssl_encrypt($data, $this->method, $this->key, OPENSSL_RAW_DATA, $this->iv));
    }
    //解密

    public function decrypt($data): false|string
    {
        return openssl_decrypt(base64_decode($data), $this->method, $this->key, OPENSSL_RAW_DATA, $this->iv);
    }


}
