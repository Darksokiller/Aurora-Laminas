<?php
namespace Application\Log;

/**
 *
 * @author acesn
 *        
 */
interface LoggableInterface
{
    public function save($data);
    public function update($data);
    public function send();
}

