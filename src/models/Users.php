<?php

/**
* 
*/
namespace Models;

class Users
{
    private $_users;

    function __construct($db = false)
    {
        if ($db) {
            $sql = "SELECT id, firstname, lastname FROM users";
            if ($users = $db->fetchAll($sql)) {
                $this->_users = $users;
            }
            else {
                $this->_users = null;
            }
        }
        else {
            $this->_users = array(
                1 => array(
                    'id' => '1',
                    'firstname' => 'Julien',
                    'lastname'  => 'Grossiord'
                    ),
                2 => array(
                    'id' => '2',
                    'firstname' => 'John',
                    'lastname'  => 'Doe'
                    )
                );
        }
    }
    public function users() {
        return $this->_users;
    }
}