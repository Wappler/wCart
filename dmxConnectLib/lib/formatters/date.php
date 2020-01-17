<?php

namespace lib\core;

function formatter_formatDate($val, $format) {
    if ($val == NULL) return NULL;

    $date = new \DateTime((is_numeric($val) ? '@' : '') . $val);

    $format = str_replace('yyyy', 'Y', $format);
    $format = str_replace('yy', 'y', $format);
    $format = str_replace('mm', 'i', $format);
    $format = str_replace('m', 'i', $format);
    $format = str_replace('MMMM', 'F', $format);
    $format = str_replace('MMM', '@@@', $format);
    $format = str_replace('MM', 'm', $format);
    $format = str_replace('M', 'n', $format);
    $format = str_replace('@@@', 'M', $format);
    $format = str_replace('dddd', 'l', $format);
    $format = str_replace('ddd', 'D', $format);
    $format = str_replace('dd', '@@@', $format);
    $format = str_replace('d', 'j', $format);
    $format = str_replace('@@@', 'd', $format);
    $format = str_replace('HH', '@@@', $format);
    $format = str_replace('H', 'G', $format);
    $format = str_replace('@@@', 'H', $format);
    $format = str_replace('hh', '@@@', $format);
    $format = str_replace('h', 'g', $format);
    $format = str_replace('@@@', 'h', $format);
    $format = str_replace('ss', 's', $format);

    return $date->format($format);
}

function formatter_dateAdd($val, $interval, $num) {
    if ($val == NULL) return NULL;

    $date = new \DateTime((is_numeric($val) ? '@' : '') . $val);
    $add = $num > 0;
    $num = abs($num);

    switch ($interval) {
        case 'years':
            $interval = 'P' . $num . 'Y';
            break;
        case 'months':
            $interval = 'P' . $num . 'M';
            break;
        case 'weeks':
            $interval = 'P' . $num . 'W';
            break;
        case 'days':
            $interval = 'P' . $num . 'D';
            break;
        case 'hours':
            $interval = 'PT' . $num . 'H';
            break;
        case 'minutes':
            $interval = 'PT' . $num . 'M';
            break;
        case 'seconds':
            $interval = 'PT' . $num . 'S';
            break;
        default:
            return $date;
    }

    $interval = new \DateInterval($interval);
    $newDate = $add ? $date->add($interval) : $date->sub($interval);

    return $newDate->format('Y-m-d\TH:i:s');
}

function formatter_dateDiff($val, $interval, $date) {
    if ($val == NULL) return NULL;

    $date1 = new \DateTime((is_numeric($val) ? '@' : '') . $val);
    $date2 = new \DateTime((is_numeric($date) ? '@' : '') . $date);
    $diff = $date2->diff($date1);

    switch ($interval) {
        case 'years':
            return abs($diff->y);
        case 'months':
            return abs($diff->y * 12 + $diff->m);
        case 'weeks':
            return floor(abs($diff->days) / 7);
        case 'days':
            return abs($diff->days);
        case 'hours':
            return abs($diff->days * 24 + $diff->h);
        case 'minutes':
            return abs($diff->days * 24 * 60 + $diff->h * 60 + $diff->i);
        case 'seconds':
            return abs($diff->days * 24 * 60 * 60 + $diff->h * 60 * 60 + $diff->i * 60 + $diff->s);
        case 'hours:minutes':
            return abs($diff->days * 24 + $diff->h) . ':' . abs($diff->i);
        case 'minutes:seconds':
            return abs($diff->days * 24 * 60 + $diff->h * 60 + $diff->i) . ':' . abs($diff->s);
        case 'hours:minutes:seconds':
            return abs($diff->days * 24 + $diff->h) . ':' . abs($diff->i) . ':' . abs($diff->s);
        default:
            return NULL;
    }
}
