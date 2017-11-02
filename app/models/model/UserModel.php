<?php
namespace model;

/**
 * UserModel
 */
class UserModel extends Model
{
    protected $_table = 'e_users';

    public function getUserById($id)
    {
        return $this->_db->get($this->_table, '*', [
                    'id' => $id
                ]);
    }
}
