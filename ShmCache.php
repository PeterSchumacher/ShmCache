<?php

/**
 * Simple cache using Shared memory (shm)
 * 
 * Based on https://github.com/WindomZ/shmcache
 * show segments : 'ipcs -m'
 * show process  : 'ipcs -pm'
 */

class ShmCache {

    protected static $shm_key;

    private function __clone() {
        
    }

    protected function setup() {
        if (empty(self::$shm_key)) {
            self::$shm_key = ftok(__FILE__, 'x');
        }
        
        if(false === function_exists('shmop_open')) {
            exit('shmop not loaded...');
        }
    }

    protected function read() {
        self::setup();

        if (($handle = @shmop_open(self::$shm_key, 'a', 0, 0)) !== false) {
            $data = shmop_read($handle, 0, shmop_size($handle));
            shmop_close($handle);

            if (!$data) {
                return false;
            }

            return (unserialize($data));
        }

        return false;
    }
    
    protected function write($data) {
        self::setup();
        
        $data = serialize($data);

        $handle = shmop_open(self::$shm_key, "n", 0644, strlen($data));

        if (!$handle) {
            return false;
        }

        $size = shmop_write($handle, $data, 0);

        shmop_close($handle);

        return !empty($size);        
        
    }

    public static function get(string $key) {

        if (($data = self::read()) !== false) {
            if (array_key_exists($key, $data)) {
                return $data[$key];
            }
        }

        return false;
    }

    public static function getAll() {

        if (($data = self::read()) !== false) {
            return $data;
        }

        return false;
    }

    public static function delete(string $key) {

        if (empty($key)) {
            return false;
        }

        $data = self::read();

        if (!is_array($data)) {
            $data = array();
        }

        if (!array_key_exists($key, $data)) {
            return false;
        }

        unset($data[$key]);

        self::flush();

        return self::write($data);

    }

    public static function set(string $key, $value) {

        if (empty($key)) {
            return false;
        }

        $data = self::read();

        if (!is_array($data)) {
            $data = array();
        }

        $data[$key] = $value;

        self::flush();

        return self::write($data);
    }

    public static function flush() {
        self::setup();

        if (($handle = @shmop_open(self::$shm_key, 'a', 0, 0)) !== false) {
            shmop_delete($handle);
            shmop_close($handle);
            return true;
        }

        return false;
    }

}
