<?php
/**
 * @namespace
 */
namespace User\Service;

/**
 * Class Token
 *
 * @category   Service
 * @package    User
 */
class Token
{
    /**
     * Name of selected hashing algorithm (i.e. "md5", "sha256", "haval160,4", etc..) See <b>hash_algos</b> for a list of supported algorithms.
     */
    CONST HASH_ALGO = 'sha256';

    /**
     * Local timestamp
     * @var integer
     */
    private $_timestamp;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_timestamp = time();
    }

    /**
     * Generate user new token
     *
     * @param string $user
     * @param string $key
     * @return string
     */
    public function generate($user, $key)
    {
        return $this->_generate($user, $key, $this->_timestamp);
    }

    /**
     * Generate token
     *
     * @param string $user
     * @param string $key
     * @param integer $timestamp
     * @return string
     */
    private function _generate($user, $key, $timestamp)
    {
        return hash_hmac(self::HASH_ALGO, $user.$timestamp, $key).'t'.$timestamp;
    }

    /**
     * Return local timestamp
     *
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->_timestamp;
    }

    /**
     * Check token
     *
     * @param string $token
     * @param string $user
     * @param string $key
     * @return bool
     */
    public function checkToken($token, $user, $key)
    {
        $timestamp = self::parseTimestamp($token);
        return $token === $this->_generate($user, $key, $timestamp);
    }

    /**
     * Return timestamp from token
     *
     * @param string $token
     * @return integer
     */
    public static function parseTimestamp($token)
    {
        return (int) substr($token, strpos($token, 't')+1);
    }
}