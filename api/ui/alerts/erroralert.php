<?php

namespace yz\ui\alerts;

use yz\ui\alerts\GlobalAlert;

class ErrorAlert extends GlobalAlert{
    public function __construct($title, $texte, $picto = 'flaticon-error') {
        parent::__construct($title, $texte, $picto);
        parent::addClass('erreur');
    }
}
