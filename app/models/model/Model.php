<?php
namespace model;

use Medoo\Medoo;

class Model
{
    protected $_error;
    protected $_db;

    /**
     * Construct Method
     * @method __construct
     */
    public function __construct($db = 'default')
    {
        if (!empty($db)) {
            $this->setDb(app()->db($db));
        }
    }

    public function getError()
    {
        return $this->_error;
    }

    public function setDb(Medoo $db)
    {
        $this->_db = $db;
    }
}
