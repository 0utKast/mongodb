<?php

require_once('dbconnection.php');
require_once('session.php');

class User
{
    const COLLECTION = 'users';
    
    private $_mongo;
    private $_collection;
    private $_user;
    
    public function __construct()
    {
        $this->_mongo = DBConnection::instantiate();
        $this->_collection = $this->_mongo->getCollection(User::COLLECTION);
        
        if ($this->isLoggedIn()) $this->_loadData();
    }
    
    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
    
    public function authenticate($nombreusuario, $password)
    {
        $query = array('nombreusuario' => $nombreusuario, 'password' => md5($password));
        
        $this->_user = $this->_collection->findOne($query);
        
        if (empty($this->_user)) return False;
        
        $_SESSION['user_id'] = (string) $this->_user['_id'];
        
        return True;
    }
    
    public function logout()
    {
        unset($_SESSION['user_id']);
    }

    public function __get($attr)
    {
        if (empty($this->_user))
            return Null;
        
        switch($attr) {
            
            case 'direccion':
                $direccion = $this->_user['direccion'];
                return sprintf('Ciudad: %s, Provincia: %s', $direccion['ciudad'], $direccion['provincia']);
            
            case 'ciudad':
                return $this->_user['address']['ciudad'];
            
            case 'provincia':
                return $this->_user['direccion']['provincia'];
            
            case 'password':
                return NULL;
            
            default:
                return (isset($this->_user[$attr])) ? $this->_user[$attr] : NULL;
        }
    }
    
    private function _loadData()
    {
        $id = new MongoId($_SESSION['user_id']);
        $this->_user = $this->_collection->findOne(array('_id' => $id));
    }
}