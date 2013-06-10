<?php

/**
* 
*/
namespace Models;
 
class User 
{
    private $_id_user;
    private $_firstname;
    private $_lastname;

    function __construct($id_user=100, $db = false)
    {
        $this->_id_user = $id_user;
        if ($db) {
            $sql = "SELECT id, firstname, lastname FROM users WHERE id = ?";
            if ($user = $db->fetchAssoc($sql, array($id_user))) {
                 $this->_firstname = $user['firstname'];
                 $this->_lastname = $user['lastname'];
            }
            else {
                $this->_id_user = null;
            }
        }
        else {
            $this->_firstname = 'SAMPLE-Scarlett';
            $this->_lastname = 'SAMPLE-Johanson';
        }
    }
    public function id_user() {
        return $this->_id_user;
    }
    public function id() {
        return $this->_id_user;
    }
    public function firstname() {
        return $this->_firstname;
    } 
    public function lastname() {
        return $this->_lastname;
    }
    public function user() {
        return array(
            'id' => $this->id_user(),
            'firstname' => $this->firstname(),
            'lastname' => $this->lastname()
            );
    } 
}
