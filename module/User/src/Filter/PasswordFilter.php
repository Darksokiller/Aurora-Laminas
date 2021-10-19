<?php
namespace User\Filter;
use Laminas\Filter\AbstractFilter;

class PasswordFilter extends AbstractFilter
{
    public function filter($value)
    {
        if (!is_string($value)) {
            // eventually do some stuff here
        }
        
        return  password_hash($value, PASSWORD_DEFAULT);
    }
}

