<?php

namespace lib\validator\messages\en;

class upload extends \lib\core\Singleton
{
    public $accept = "Please select a file with a valid file type.";
    public $minsize = "Please select a file of at least {0} bytes.";
    public $maxsize = "Please select a file of no more than {0} bytes.";
    public $mintotalsize = "Total size of selected files should be at least {0} bytes.";
    public $maxtotalsize = "Total size of selected files should be no more than {0} bytes.";
    public $minfiles = "Please select at least {0} files.";
    public $maxfiles = "Please select no more than {0} files.";
}
