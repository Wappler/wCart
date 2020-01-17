<?php

namespace lib\validator\messages\en;

class core extends \lib\core\Singleton
{
    public $required = "This field is required.";
    public $email = "Please enter a valid email address.";
    public $url = "Please enter a valid URL.";
    public $date = "Please enter a valid date.";
    public $time = "Please enter a valid time.";
    public $month = "Please enter a valid month.";
    public $week = "Please enter a valid week.";
    public $color = "Please enter a color in the format #xxxxxx.";
    public $pattern = "Invalid format.";
    public $number = "Please enter a valid number.";
    public $digits = "Please enter only digits.";
    public $alphanumeric = "Letters, numbers, and underscores only please.";
    public $creditcard = "Please enter a valid credit card number.";
    public $bic = "Please specify a valid BIC code.";
    public $iban = "Please specify a valid IBAN.";
    public $vat = "Please specify a valid VAT Number";
    public $integer = "A positive or negative non-decimal number please.";
    public $ipv4 = "Please enter a valid IP v4 address.";
    public $ipv6 = "Please enter a valid IP v6 address.";
    public $lettersonly = "Letters only please.";
    public $letterswithbasicpunc = "Letters or punctuation only please.";
    public $nowhitespace = "No white space please.";
    public $minlength = "Please enter at least {0} characters.";
    public $maxlength = "Please enter no more than {0} characters.";
    public $minitems = "Please select at least {0} items.";
    public $maxitems = "Please select no more than {0} items.";
    public $min = "Please enter a value greater than or equal to {0}.";
    public $max = "Please enter a value less than or equal to {0}.";
    public $equalTo = "Please enter the same value again.";
    public $notEqualTo = "Please enter a different value, values must not be the same.";
}
