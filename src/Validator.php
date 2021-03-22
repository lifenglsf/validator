<?php

namespace simple\validator;

use Countable;
use InvalidArgumentException;

class Validator
{
    /**
     * @param $data
     *
     * @return bool
     *
     * 是否必须
     */
    public static function required($data)
    {
        if (is_null($data)) {
            return false;
        } elseif (is_string($data) && trim($data) === '') {
            return false;
        } elseif ((is_array($data) || $data instanceof Countable) && count($data) < 1) {
            return false;
        } elseif (is_object($data)) {
            throw new  InvalidArgumentException;
        } elseif (is_dir($data)) {
            throw new  InvalidArgumentException;
        } elseif (is_file($data)) {
            throw new  InvalidArgumentException;
        } elseif (is_callable($data)) {
            throw new  InvalidArgumentException;
        } elseif (is_resource($data)) {
            throw new  InvalidArgumentException;
        }
        return true;
    }

    /**
     * @param $data
     * @return bool
     * 是否是整数
     */
    public static function integer($data)
    {
        return filter_var($data, FILTER_VALIDATE_INT) !== false;
    }

    /**
     * @param $data
     * @return bool
     * 是否是ip
     */
    public static function ip($data)
    {
        return filter_var($data, FILTER_VALIDATE_IP) !== false;
    }

    /**
     * @param $data
     * @return bool
     * 是否是ipv4
     */
    public static function validateIpv4($data)
    {
        return filter_var($data, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    /**
     * @param $data
     * @return bool
     * 是否是ipv6
     */
    public static function validateIpv6($data)
    {
        return filter_var($data, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    /**
     * @param $data
     * @param $value
     * @return bool
     * data和value是否相等
     */
    public static function equal($data, $value)
    {
        return self::compare($data, $value, '=');
    }

    /**
     * @param $data
     * @param $value
     * @return bool
     * data是否大于value
     */
    public static function greaterThan($data, $value)
    {
        return self::compare($data, $value, '>');
    }

    /**
     * @param $data
     * @param $value
     * @return bool
     * data是否大于等于value
     */
    public static function greaterEqualThan($data, $value)
    {
        return self::compare($data, $value, '>=');
    }

    /**
     * @param $data
     * @param $value
     * @return bool
     * data是否小于value
     */
    public static function lessThan($data, $value)
    {
        return self::compare($data, $value, '<');
    }

    /**
     * @param $data
     * @param $value
     * @return bool
     * data是否小于等于value
     */
    public static function lessEqualThan($data, $value)
    {
        return self::compare($data, $value, '<=');
    }

    /**
     * @param $data
     * @return bool
     * 是否为bool类型
     */
    public static function boolean($data)
    {
        $valid = [true, false, 0, 1, "0", "1"];
        return in_array($valid, $data, true);
    }

    /**
     * @param $first
     * @param $second
     * @param $operator
     * @return bool
     * 辅助方法,计算data和value的大小关系
     */
    private static function compare($first, $second, $operator)
    {
        switch ($operator) {
            case '<':
                return $first < $second;
            case '>':
                return $first > $second;
            case '<=':
                return $first <= $second;
            case '>=':
                return $first >= $second;
            case '=':
                return $first == $second;
            default:
                throw new InvalidArgumentException;
        }
    }

}