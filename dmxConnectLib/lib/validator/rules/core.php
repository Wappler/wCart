<?php

namespace lib\validator\rules;

class core extends \lib\core\Singleton
{
    public function required($value) {
        return $this->getLength($value) > 0;
    }

    public function email($value) {
        return !$this->isValidStringValue($value) || preg_match('/^(?!\.)((?!.*\.{2})[a-zA-Z0-9\x{0080}-\x{00FF}\x{0100}-\x{017F}\x{0180}-\x{024F}\x{0250}-\x{02AF}\x{0300}-\x{036F}\x{0370}-\x{03FF}\x{0400}-\x{04FF}\x{0500}-\x{052F}\x{0530}-\x{058F}\x{0590}-\x{05FF}\x{0600}-\x{06FF}\x{0700}-\x{074F}\x{0750}-\x{077F}\x{0780}-\x{07BF}\x{07C0}-\x{07FF}\x{0900}-\x{097F}\x{0980}-\x{09FF}\x{0A00}-\x{0A7F}\x{0A80}-\x{0AFF}\x{0B00}-\x{0B7F}\x{0B80}-\x{0BFF}\x{0C00}-\x{0C7F}\x{0C80}-\x{0CFF}\x{0D00}-\x{0D7F}\x{0D80}-\x{0DFF}\x{0E00}-\x{0E7F}\x{0E80}-\x{0EFF}\x{0F00}-\x{0FFF}\x{1000}-\x{109F}\x{10A0}-\x{10FF}\x{1100}-\x{11FF}\x{1200}-\x{137F}\x{1380}-\x{139F}\x{13A0}-\x{13FF}\x{1400}-\x{167F}\x{1680}-\x{169F}\x{16A0}-\x{16FF}\x{1700}-\x{171F}\x{1720}-\x{173F}\x{1740}-\x{175F}\x{1760}-\x{177F}\x{1780}-\x{17FF}\x{1800}-\x{18AF}\x{1900}-\x{194F}\x{1950}-\x{197F}\x{1980}-\x{19DF}\x{19E0}-\x{19FF}\x{1A00}-\x{1A1F}\x{1B00}-\x{1B7F}\x{1D00}-\x{1D7F}\x{1D80}-\x{1DBF}\x{1DC0}-\x{1DFF}\x{1E00}-\x{1EFF}\x{1F00}-\x{1FFF}\x{20D0}-\x{20FF}\x{2100}-\x{214F}\x{2C00}-\x{2C5F}\x{2C60}-\x{2C7F}\x{2C80}-\x{2CFF}\x{2D00}-\x{2D2F}\x{2D30}-\x{2D7F}\x{2D80}-\x{2DDF}\x{2F00}-\x{2FDF}\x{2FF0}-\x{2FFF}\x{3040}-\x{309F}\x{30A0}-\x{30FF}\x{3100}-\x{312F}\x{3130}-\x{318F}\x{3190}-\x{319F}\x{31C0}-\x{31EF}\x{31F0}-\x{31FF}\x{3200}-\x{32FF}\x{3300}-\x{33FF}\x{3400}-\x{4DBF}\x{4DC0}-\x{4DFF}\x{4E00}-\x{9FFF}\x{A000}-\x{A48F}\x{A490}-\x{A4CF}\x{A700}-\x{A71F}\x{A800}-\x{A82F}\x{A840}-\x{A87F}\x{AC00}-\x{D7AF}\x{F900}-\x{FAFF}\.!#$%&\'*+-\/=?^_`{|}~\-\d]+)@(?!\.)([a-zA-Z0-9\x{0080}-\x{00FF}\x{0100}-\x{017F}\x{0180}-\x{024F}\x{0250}-\x{02AF}\x{0300}-\x{036F}\x{0370}-\x{03FF}\x{0400}-\x{04FF}\x{0500}-\x{052F}\x{0530}-\x{058F}\x{0590}-\x{05FF}\x{0600}-\x{06FF}\x{0700}-\x{074F}\x{0750}-\x{077F}\x{0780}-\x{07BF}\x{07C0}-\x{07FF}\x{0900}-\x{097F}\x{0980}-\x{09FF}\x{0A00}-\x{0A7F}\x{0A80}-\x{0AFF}\x{0B00}-\x{0B7F}\x{0B80}-\x{0BFF}\x{0C00}-\x{0C7F}\x{0C80}-\x{0CFF}\x{0D00}-\x{0D7F}\x{0D80}-\x{0DFF}\x{0E00}-\x{0E7F}\x{0E80}-\x{0EFF}\x{0F00}-\x{0FFF}\x{1000}-\x{109F}\x{10A0}-\x{10FF}\x{1100}-\x{11FF}\x{1200}-\x{137F}\x{1380}-\x{139F}\x{13A0}-\x{13FF}\x{1400}-\x{167F}\x{1680}-\x{169F}\x{16A0}-\x{16FF}\x{1700}-\x{171F}\x{1720}-\x{173F}\x{1740}-\x{175F}\x{1760}-\x{177F}\x{1780}-\x{17FF}\x{1800}-\x{18AF}\x{1900}-\x{194F}\x{1950}-\x{197F}\x{1980}-\x{19DF}\x{19E0}-\x{19FF}\x{1A00}-\x{1A1F}\x{1B00}-\x{1B7F}\x{1D00}-\x{1D7F}\x{1D80}-\x{1DBF}\x{1DC0}-\x{1DFF}\x{1E00}-\x{1EFF}\x{1F00}-\x{1FFF}\x{20D0}-\x{20FF}\x{2100}-\x{214F}\x{2C00}-\x{2C5F}\x{2C60}-\x{2C7F}\x{2C80}-\x{2CFF}\x{2D00}-\x{2D2F}\x{2D30}-\x{2D7F}\x{2D80}-\x{2DDF}\x{2F00}-\x{2FDF}\x{2FF0}-\x{2FFF}\x{3040}-\x{309F}\x{30A0}-\x{30FF}\x{3100}-\x{312F}\x{3130}-\x{318F}\x{3190}-\x{319F}\x{31C0}-\x{31EF}\x{31F0}-\x{31FF}\x{3200}-\x{32FF}\x{3300}-\x{33FF}\x{3400}-\x{4DBF}\x{4DC0}-\x{4DFF}\x{4E00}-\x{9FFF}\x{A000}-\x{A48F}\x{A490}-\x{A4CF}\x{A700}-\x{A71F}\x{A800}-\x{A82F}\x{A840}-\x{A87F}\x{AC00}-\x{D7AF}\x{F900}-\x{FAFF}\-\.\d]+)((\.([a-zA-Z\x{0080}-\x{00FF}\x{0100}-\x{017F}\x{0180}-\x{024F}\x{0250}-\x{02AF}\x{0300}-\x{036F}\x{0370}-\x{03FF}\x{0400}-\x{04FF}\x{0500}-\x{052F}\x{0530}-\x{058F}\x{0590}-\x{05FF}\x{0600}-\x{06FF}\x{0700}-\x{074F}\x{0750}-\x{077F}\x{0780}-\x{07BF}\x{07C0}-\x{07FF}\x{0900}-\x{097F}\x{0980}-\x{09FF}\x{0A00}-\x{0A7F}\x{0A80}-\x{0AFF}\x{0B00}-\x{0B7F}\x{0B80}-\x{0BFF}\x{0C00}-\x{0C7F}\x{0C80}-\x{0CFF}\x{0D00}-\x{0D7F}\x{0D80}-\x{0DFF}\x{0E00}-\x{0E7F}\x{0E80}-\x{0EFF}\x{0F00}-\x{0FFF}\x{1000}-\x{109F}\x{10A0}-\x{10FF}\x{1100}-\x{11FF}\x{1200}-\x{137F}\x{1380}-\x{139F}\x{13A0}-\x{13FF}\x{1400}-\x{167F}\x{1680}-\x{169F}\x{16A0}-\x{16FF}\x{1700}-\x{171F}\x{1720}-\x{173F}\x{1740}-\x{175F}\x{1760}-\x{177F}\x{1780}-\x{17FF}\x{1800}-\x{18AF}\x{1900}-\x{194F}\x{1950}-\x{197F}\x{1980}-\x{19DF}\x{19E0}-\x{19FF}\x{1A00}-\x{1A1F}\x{1B00}-\x{1B7F}\x{1D00}-\x{1D7F}\x{1D80}-\x{1DBF}\x{1DC0}-\x{1DFF}\x{1E00}-\x{1EFF}\x{1F00}-\x{1FFF}\x{20D0}-\x{20FF}\x{2100}-\x{214F}\x{2C00}-\x{2C5F}\x{2C60}-\x{2C7F}\x{2C80}-\x{2CFF}\x{2D00}-\x{2D2F}\x{2D30}-\x{2D7F}\x{2D80}-\x{2DDF}\x{2F00}-\x{2FDF}\x{2FF0}-\x{2FFF}\x{3040}-\x{309F}\x{30A0}-\x{30FF}\x{3100}-\x{312F}\x{3130}-\x{318F}\x{3190}-\x{319F}\x{31C0}-\x{31EF}\x{31F0}-\x{31FF}\x{3200}-\x{32FF}\x{3300}-\x{33FF}\x{3400}-\x{4DBF}\x{4DC0}-\x{4DFF}\x{4E00}-\x{9FFF}\x{A000}-\x{A48F}\x{A490}-\x{A4CF}\x{A700}-\x{A71F}\x{A800}-\x{A82F}\x{A840}-\x{A87F}\x{AC00}-\x{D7AF}\x{F900}-\x{FAFF}]){2,63})+)$/u', $value);
    }

    public function url($value) {
        return !$this->isValidStringValue($value) || preg_match('/^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]-*)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]-*)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})).?)(?::\d{2,5})?(?:[\/?#]\S*)?$/ui', $value);
    }

    public function date($value) {
        return !$this->isValidStringValue($value) || preg_match('/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/u', $value);
    }

    public function time($value) {
        return !$this->isValidStringValue($value) || preg_match('/^([01][0-9]|2[0-4]):[0-5][0-9](:([0-5][0-9]|60))?$/', $value);
    }

    public function month($value) {
        return !$this->isValidStringValue($value) || preg_match('/^\d{4}-(0[1-9]|1[012])$/', $value);
    }

    public function week($value) {
        return !$this->isValidStringValue($value) || preg_match('/^\d{4}-W(0[1-9]|[1-4][0-9]|5[0-3])$/', $value);
    }

    public function color($value) {
        return !$this->isValidStringValue($value) || preg_match('/^#[a-fA-F0-9]{6}$/', $value);
    }

    public function dateISO($value) {
        return !$this->isValidStringValue($value) || preg_match('/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/', $value);
    }

    public function pattern($value, $param) {
        return !$this->isValidStringValue($value) || preg_match('/^(?:' . $param . ')$/', $value);
    }

    public function number($value) {
        return !$this->isValidStringValue($value) || preg_match('/^(?:-?\d+|-?\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/', $value);
    }

    public function digits($value) {
        return !$this->isValidStringValue($value) || preg_match('/^\d+$/', $value);
    }

    public function alphanumeric($value) {
        return !$this->isValidStringValue($value) || preg_match('/^\w+$/i', $value);
    }

    public function creditcard($value) {
        if (!$this->isValidStringValue($value)) {
            return TRUE;
        }

        // accept only spaces, digits and dashes
        if (preg_match('/[^0-9 \-]+/', $value)) {
            return FALSE;
        }

        $check = 0;
        $digit = 0;
        $even = FALSE;

        $value = preg_replace('/\D/', '', $value);
        $len = strlen($value);

        // Basing min and max length on
        // http://developer.ean.com/general_info/Valid_Credit_Card_Types
        if ($len < 13 || $len > 19 ) {
            return FALSE;
        }

        for ($n = $len - 1; $n >= 0; $n--) {
            $digit = intval($value[$n]);
            if ($even) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $check += $digit;
            $even = !$even;
        }

        return ($check % 10) === 0;
    }

    public function bic($value) {
        return !$this->isValidStringValue($value) || preg_match('/^([A-Z]{6}[A-Z2-9][A-NP-Z1-2])(X{3}|[A-WY-Z0-9][A-Z0-9]{2})?$/', $value);
    }

    public function iban($value) {
        if (!$this->isValidStringValue($value)) {
            return TRUE;
        }

        $iban = strtoupper(str_replace(' ', '', $value));
        $countrycode = substr($iban, 0, 2);
        $ibancountrypatterns = array(
            "AL" => "\\d{8}[\\dA-Z]{16}",
    		"AD" => "\\d{8}[\\dA-Z]{12}",
    		"AT" => "\\d{16}",
    		"AZ" => "[\\dA-Z]{4}\\d{20}",
    		"BE" => "\\d{12}",
    		"BH" => "[A-Z]{4}[\\dA-Z]{14}",
    		"BA" => "\\d{16}",
    		"BR" => "\\d{23}[A-Z][\\dA-Z]",
    		"BG" => "[A-Z]{4}\\d{6}[\\dA-Z]{8}",
    		"CR" => "\\d{17}",
    		"HR" => "\\d{17}",
    		"CY" => "\\d{8}[\\dA-Z]{16}",
    		"CZ" => "\\d{20}",
    		"DK" => "\\d{14}",
    		"DO" => "[A-Z]{4}\\d{20}",
    		"EE" => "\\d{16}",
    		"FO" => "\\d{14}",
    		"FI" => "\\d{14}",
    		"FR" => "\\d{10}[\\dA-Z]{11}\\d{2}",
    		"GE" => "[\\dA-Z]{2}\\d{16}",
    		"DE" => "\\d{18}",
    		"GI" => "[A-Z]{4}[\\dA-Z]{15}",
    		"GR" => "\\d{7}[\\dA-Z]{16}",
    		"GL" => "\\d{14}",
    		"GT" => "[\\dA-Z]{4}[\\dA-Z]{20}",
    		"HU" => "\\d{24}",
    		"IS" => "\\d{22}",
    		"IE" => "[\\dA-Z]{4}\\d{14}",
    		"IL" => "\\d{19}",
    		"IT" => "[A-Z]\\d{10}[\\dA-Z]{12}",
    		"KZ" => "\\d{3}[\\dA-Z]{13}",
    		"KW" => "[A-Z]{4}[\\dA-Z]{22}",
    		"LV" => "[A-Z]{4}[\\dA-Z]{13}",
    		"LB" => "\\d{4}[\\dA-Z]{20}",
    		"LI" => "\\d{5}[\\dA-Z]{12}",
    		"LT" => "\\d{16}",
    		"LU" => "\\d{3}[\\dA-Z]{13}",
    		"MK" => "\\d{3}[\\dA-Z]{10}\\d{2}",
    		"MT" => "[A-Z]{4}\\d{5}[\\dA-Z]{18}",
    		"MR" => "\\d{23}",
    		"MU" => "[A-Z]{4}\\d{19}[A-Z]{3}",
    		"MC" => "\\d{10}[\\dA-Z]{11}\\d{2}",
    		"MD" => "[\\dA-Z]{2}\\d{18}",
    		"ME" => "\\d{18}",
    		"NL" => "[A-Z]{4}\\d{10}",
    		"NO" => "\\d{11}",
    		"PK" => "[\\dA-Z]{4}\\d{16}",
    		"PS" => "[\\dA-Z]{4}\\d{21}",
    		"PL" => "\\d{24}",
    		"PT" => "\\d{21}",
    		"RO" => "[A-Z]{4}[\\dA-Z]{16}",
    		"SM" => "[A-Z]\\d{10}[\\dA-Z]{12}",
    		"SA" => "\\d{2}[\\dA-Z]{18}",
    		"RS" => "\\d{18}",
    		"SK" => "\\d{20}",
    		"SI" => "\\d{15}",
    		"ES" => "\\d{20}",
    		"SE" => "\\d{20}",
    		"CH" => "\\d{5}[\\dA-Z]{12}",
    		"TN" => "\\d{20}",
    		"TR" => "\\d{5}[\\dA-Z]{17}",
    		"AE" => "\\d{3}\\d{16}",
    		"GB" => "[A-Z]{4}\\d{14}",
    		"VG" => "[\\dA-Z]{4}\\d{16}"
        );

        if (isset($ibancountrypatterns[$countrycode])) {
            if (!preg_match('/^[A-Z]{2}\d{2}' . $ibancountrypatterns[$countrycode] . '$/', $iban)) {
                return FALSE;
            }
        }

        $leadingZeroes = TRUE;
        $ibancheck = str_split(substr($iban, 4) . substr($iban, 0, 4));
        $ibancheckdigits = '';
        foreach ($ibancheck as $char) {
            if ($char !== '0') {
                $leadingZeroes = FALSE;
            }
            if (!$leadingZeroes) {
                $ibancheckdigits .= strpos('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', $char);
            }
        }

        $rest = '';
        $operator = '';
        $ibancheckdigits = str_split($ibancheckdigits);
        foreach ($ibancheckdigits as $char) {
            $operator = $rest . $char;
            $rest = $operator % 97;
        }

        return $rest === 1;
    }

    public function vat($value) {
        return !$this->isValidStringValue($value) || preg_match('/^((AT)?U[0-9]{8}|(BE)?0[0-9]{9}|(BG)?[0-9]{9,10}|(CY)?[0-9]{8}L|(CZ)?[0-9]{8,10}|(DE)?[0-9]{9}|(DK)?[0-9]{8}|(EE)?[0-9]{9}|(EL|GR)?[0-9]{9}|(ES)?[0-9A-Z][0-9]{7}[0-9A-Z]|(FI)?[0-9]{8}|(FR)?[0-9A-Z]{2}[0-9]{9}|(GB)?([0-9]{9}([0-9]{3})?|[A-Z]{2}[0-9]{3})|(HU)?[0-9]{8}|(IE)?[0-9]S[0-9]{5}L|(IT)?[0-9]{11}|(LT)?([0-9]{9}|[0-9]{12})|(LU)?[0-9]{8}|(LV)?[0-9]{11}|(MT)?[0-9]{8}|(NL)?[0-9]{9}B[0-9]{2}|(PL)?[0-9]{10}|(PT)?[0-9]{9}|(RO)?[0-9]{2,10}|(SE)?[0-9]{12}|(SI)?[0-9]{8}|(SK)?[0-9]{10})$/', $value);
    }

    public function integer($value) {
        return !$this->isValidStringValue($value) || preg_match('/^-?\d+$/', $value);
    }

    public function ipv4($value) {
        return !$this->isValidStringValue($value) || preg_match('/^(25[0-5]|2[0-4]\d|[01]?\d\d?)\.(25[0-5]|2[0-4]\d|[01]?\d\d?)\.(25[0-5]|2[0-4]\d|[01]?\d\d?)\.(25[0-5]|2[0-4]\d|[01]?\d\d?)$/i', $value);
    }

    public function ipv6($value) {
        return !$this->isValidStringValue($value) || preg_match('/^((([0-9A-Fa-f]{1,4}:){7}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}:[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){5}:([0-9A-Fa-f]{1,4}:)?[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){4}:([0-9A-Fa-f]{1,4}:){0,2}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){3}:([0-9A-Fa-f]{1,4}:){0,3}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){2}:([0-9A-Fa-f]{1,4}:){0,4}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(([0-9A-Fa-f]{1,4}:){0,5}:((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(::([0-9A-Fa-f]{1,4}:){0,5}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|([0-9A-Fa-f]{1,4}::([0-9A-Fa-f]{1,4}:){0,5}[0-9A-Fa-f]{1,4})|(::([0-9A-Fa-f]{1,4}:){0,6}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){1,7}:))$/i', $value);
    }

    public function lettersonly($value) {
        return !$this->isValidStringValue($value) || preg_match('/^[a-z]+$/i', $value);
    }

    public function letterswithbasicpunc($value) {
        return !$this->isValidStringValue($value) || preg_match('/^[a-z\-.,()\'"\s]+$/i', $value);
    }

    public function nowhitespace($value) {
        return !$this->isValidStringValue($value) || preg_match('/^\S+$/', $value);
    }

    public function minlength($value, $param) {
        $length = $this->getLength($value);
        return $length == 0 || $length >= (int)$param;
    }

    public function maxlength($value, $param) {
        $length = $this->getLength($value);
        return $length == 0 || $length <= (int)$param;
    }

    public function rangelength($value, $param) {
        $length = $this->getLength($value);
        return $length == 0 || ($length >= (int)$param->{'0'} && $length <= (int)$param->{'1'});
    }

    public function minitems($value, $param) {
        $length = $this->getLength($value);
        return $length == 0 || (is_array($value) && $length >= (int)$param);
    }

    public function maxitems($value, $param) {
        $length = $this->getLength($value);
        return $length == 0 || (is_array($value) && $length <= (int)$param);
    }

    public function rangeitems($value, $param) {
        $length = $this->getLength($value);
        return $length == 0 || (is_array($value) && $length >= (int)$param->{'0'} && $length <= (int)$param->{'1'});
    }

    public function min($value, $param) {
        return !$this->isValidNumberValue($value) || (float)$value >= (float)$param;
    }

    public function max($value, $param) {
        return !$this->isValidNumberValue($value) || (float)$value <= (float)$param;
    }

    public function range($value, $param) {
        return !$this->isValidNumberValue($value) || ((float)$value >= (float)$param->{'0'} && (float)$value <= (float)$param->{'1'});
    }

    public function equalTo($value, $param) {
        $param = '{{$_POST.' . preg_replace('/\[([^\]]+)\]/', '.\1', $param) . '}}';
        return $value == $this->app->parseObject($param);
    }

    public function notEqualTo($value, $param) {
        $param = '{{$_POST.' . preg_replace('/\[([^\]]+)\]/', '.\1', $param) . '}}';
        return $value != $this->app->parseObject($param);
    }

    public function isValidStringValue($value) {
        return isset($value) && is_string($value) && $this->getLength($value) > 0;
    }

    public function isValidNumberValue($value) {
        return isset($value) && is_string($value) && is_numeric($value);
    }

    public function isValidFileValue($value) {
        return isset($value) && is_array($value) && count($value) > 0 && (isset($value['isFile']) || isset($value[0]['isFile']));
    }

    protected function getLength($value) {
        if (is_array($value)) {
            return count($value);
        } elseif (is_string($value)) {
            return strlen($value);
        } else {
            return 0;
        }
    }
}
