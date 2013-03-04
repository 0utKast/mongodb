<?php

require_once('dbconnection.php');

class SessionManager{
        
    const COLLECTION = 'sessions'; //nombre de la colección en la que serán almacenadas las sesiones
    
    const SESSION_TIMEOUT = 600;    //La sesión expira después de 10 minutos de inactividad
    const SESSION_LIFESPAN = 3600;  //1 hora
    const SESSION_NAME = 'mongosessid'; //nombre de la cookie de sesión
    
    const SESSION_COOKIE_PATH = '/';
    const SESSION_COOKIE_DOMAIN = ''; //el nombre de dominio de tu aplicación web, por ejemplo .muaplicacion.com
    
    private $_mongo;
    private $_collection;
    
    private $_currentSession;
    
    public function __construct()
    {
        $this->_mongo = DBConnection::instantiate();
        $this->_collection = $this->_mongo->getCollection(SessionManager::COLLECTION);
        
        session_set_save_handler(
            array(&$this, 'open'),
            array(&$this, 'close'),
            array(&$this, 'read'),
            array(&$this, 'write'),
            array(&$this, 'destroy'),
            array(&$this, 'gc')            
        );
        
        // configura periodo recolección de basura
        ini_set('session.gc_maxlifetime', SessionManager::SESSION_LIFESPAN);

        session_set_cookie_params(  SessionManager::SESSION_LIFESPAN, 
                                    SessionManager::SESSION_COOKIE_PATH, 
                                    SessionManager::SESSION_COOKIE_DOMAIN
        );
        
        
        session_name(SessionManager::SESSION_NAME);
        session_cache_limiter('nocache');
        session_start();
    }
    
    public function open($path, $name)
    {
        return true;
    }
    
    public function close()
    {
        return true;
    }
    
    public function read($sessionId)
    {
        $query = array(
                        'session_id' => $sessionId,
                        'timedout_at' => array('$gte' => time()),
                        'expired_at' => array('$gte' => time())
                      );
                      
        $result = $this->_collection->findOne($query);
        
        $this->_currentSession = $result;
        
        if(!isset($result['data'])){
            return '';
        }
        
        return $result['data'];
    }
    
    public function write($sessionId, $data)
    {
        $new_obj = array( 
                          'data' => $data,
                          'timedout_at' => time() + self::SESSION_TIMEOUT,
                          'expired_at' => (empty($this->_currentSession)) ? time() + SessionManager::SESSION_LIFESPAN
                                                                          : $this->_currentSession['expired_at']
                        );

        $query = array('session_id' => $sessionId);
        
        $this->_collection->update( 
                                    $query, 
                                    array('$set' => $new_obj), 
                                    array('upsert' => True)
                                  );
        return True;
    }
    
    public function destroy($sessionId)
    {
        $this->_collection->remove(array('session_id' => $sessionId));
        
        return True;
    }
    
    public function gc()
    {
        $query = array('expired_at' => array( '$lt' => time()));
        
        $this->_collection->remove($query);
        
        return True;
    }
    
    public function __destruct()
    {
        session_write_close();
    }
}

$session = new SessionManager();