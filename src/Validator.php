<?php

namespace simple\validator;

use Countable;
use DateTime;
use InvalidArgumentException;

class Validator
{
    /**
     * @param mixed $data
     *
     * @return bool
     *
     * 是否必须
     */
    public static function required($data): bool
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
     * @param mixed $data
     * @return bool
     * 是否是整数
     */
    public static function integer($data): bool
    {
        return filter_var($data, FILTER_VALIDATE_INT) !== false;
    }

    /**
     * @param mixed $data
     * @return bool
     * 是否是ip
     */
    public static function ip($data): bool
    {
        return filter_var($data, FILTER_VALIDATE_IP) !== false;
    }

    /**
     * @param mixed $data
     * @return bool
     * 是否是ipv4
     */
    public static function ipv4($data): bool
    {
        return filter_var($data, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    /**
     * @param mixed $data
     * @return bool
     * 是否是ipv6
     */
    public static function ipv6($data): bool
    {
        return filter_var($data, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    /**
     * @param mixed $data
     * @param mixed $value
     * @return bool
     * data和value是否相等
     */
    public static function equal($data, $value): bool
    {
        return self::compare($data, $value, '=');
    }

    /**
     * @param mixed $data
     * @param mixed $value
     * @return bool
     * data是否大于value
     */
    public static function greaterThan($data, $value): bool
    {
        return self::compare($data, $value, '>');
    }

    /**
     * @param mixed $data
     * @param mixed $value
     * @return bool
     * data是否大于等于value
     */
    public static function greaterEqualThan($data, $value): bool
    {
        return self::compare($data, $value, '>=');
    }

    /**
     * @param mixed $data
     * @param mixed $value
     * @return bool
     * data是否小于value
     */
    public static function lessThan($data, $value): bool
    {
        return self::compare($data, $value, '<');
    }

    /**
     * @param mixed $data
     * @param mixed $value
     * @return bool
     * data是否小于等于value
     */
    public static function lessEqualThan($data, $value): bool
    {
        return self::compare($data, $value, '<=');
    }

    /**
     * @param mixed $data
     * @return bool
     * 是否为bool类型
     */
    public static function boolean($data): bool
    {
        $valid = [true, false, 0, 1, "0", "1"];
        return in_array($valid, $data, true);
    }

    /**
     * @param string $data
     * @return bool
     * 是否为email
     */
    public static function email(string $data): bool
    {
        return filter_var($data, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * @param mixed $data
     * @return bool
     * 是否为数字
     */
    public static function numeric($data): bool
    {
        return is_numeric($data);
    }

    /**
     * @param mixed $data
     * @param mixed $value
     * @return bool
     * data和value是否完全相同
     */
    public static function same($data, $value): bool
    {
        return $data === $value;
    }

    /**
     * @param mixed $data
     * @return bool
     * 是否为字符串
     */
    public static function string($data): bool
    {
        return is_string($data);
    }

    /**
     * @param mixed $data
     * @return bool
     * 是否只包含字母字符
     */
    public static function alpha($data): bool
    {
        return is_string($data) && preg_match('/^[\pL\pM]+$/u', $data);
    }

    /**
     * @param mixed $data
     * @return bool
     * 是否只包含数字字符,破折号,下划线
     */
    public static function alphaDash($data): bool
    {
        if (!is_string($data) && !is_numeric($data)) {
            return false;
        }

        return preg_match('/^[\pL\pM\pN_-]+$/u', $data) > 0;
    }

    /**
     * @param mixed $data
     * @return bool
     * 是否只包含数字字符
     */
    public static function alphaNum($data): bool
    {
        if (!is_string($data) && !is_numeric($data)) {
            return false;
        }
        return preg_match('/^[\pL\pM\pN]+$/u', $data) > 0;
    }

    /**
     * @param mixed $data 日期
     * @param string $format 日期格式
     * @return bool
     * 验证日期格式
     */
    public static function dateFormat($data, string $format): bool
    {
        if (!is_string($data) && !is_numeric($data)) {
            return false;
        }
        $date = DateTime::createFromFormat('!' . $format, $data);
        return $date && $date->format($format) == $data;
    }

    /**
     * @param mixed $first
     * @param mixed $second
     * @param string $operator
     * @return bool
     * 辅助方法,计算data和value的大小关系
     */
    private static function compare($first, $second, string $operator): bool
    {
        $res = false;
        switch ($operator) {
            case '<':
                $res = $first < $second;
                break;
            case '>':
                $res = $first > $second;
                break;
            case '<=':
                $res = $first <= $second;
                break;
            case '>=':
                $res = $first >= $second;
                break;
            case '=':
                $res = $first == $second;
                break;
            default:
                //throw new InvalidArgumentException;
        }
        return $res;
    }

}