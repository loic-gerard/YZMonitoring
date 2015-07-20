<?php

namespace yz\data;

use jin\query\Query;
use jin\query\QueryResult;

class Billet{
    private $datas;
    private $scans;
    
    public function __construct($numero) {
        $q = new Query();
        $q->setRequest('SELECT * FROM tb_billet WHERE pk_billet='.$q->argument($numero, Query::$SQL_NUMERIC));
        $q->execute();
        
        $this->datas = $q->getQueryResults();
        if($this->datas->count() != 1){
            throw new \Exception('Billet inexistant');
        }
        
        $q = new Query();
        $q->setRequest('SELECT * FROM tb_scan WHERE fk_billet='.$q->argument($this->getPk(), Query::$SQL_NUMERIC));
        $q->execute();
        
        $this->scans = $q->getQueryResults();
    }
    
    public function getNumero(){
        return $this->datas->getValueAt('in_numero');
    }
    
    public function getPk(){
        return $this->datas->getValueAt('pk_billet');
    }
    
    public function get($key){
        return $this->datas->getValueAt($key);
    }
    
    public function isValide(){
        if($this->get('in_valide') == '1'){
            return true;
        }
        return false;
    }
    
    public function isScanned(){
        foreach($this->scans AS $scan){
            if($scan['tt_type'] == 'OK'){
                return true;
            }
        }
        return false;
    }
    
    public function isSurcharged(){
         if($this->get('in_surcharge') == '1'){
            return true;
        }
        return false;
    }
    
    public function getScans(){
        $q = new Query();
        $q->setRequest('SELECT * FROM tb_scan WHERE fk_billet='.$q->argument($this->getPk(), Query::$SQL_NUMERIC).' ORDER BY dt_datetime ASC');
        $q->execute();
        
        return $q->getQueryResults();
    }
    
    public function cancelScan($pk_scan){
        $q = new Query();
        $q->setRequest('DELETE FROM tb_scan WHERE pk_scan='.$q->argument($pk_scan, Query::$SQL_NUMERIC));
        $q->execute();
    }
    
    public function addScan($data){
        $q = new Query();
        $q->setRequest('INSERT INTO tb_scan (tt_type, fk_billet) VALUES ('.$q->argument($data, Query::$SQL_STRING).', '.$q->argument($this->getPk(), Query::$SQL_NUMERIC).')');
        $q->execute();
    }
    
    public function setValide(){
        $q = new Query();
        $q->setRequest('UPDATE tb_billet SET in_valide=1, in_surcharge=1 WHERE pk_billet='.$q->argument($this->getPk(), Query::$SQL_NUMERIC));
        $q->execute();
        $this->addScan('Opération manuelle : rendu valide');
    }
    
    public function setInvalide(){
        $q = new Query();
        $q->setRequest('UPDATE tb_billet SET in_valide=0, in_surcharge=1 WHERE pk_billet='.$q->argument($this->getPk(), Query::$SQL_NUMERIC));
        $q->execute();
        $this->addScan('Opération manuelle : rendu invalide');
    }
    
    public function manualScan(){
        $q = new Query();
        $q->setRequest('UPDATE tb_billet SET in_surcharge=1 WHERE pk_billet='.$q->argument($this->getPk(), Query::$SQL_NUMERIC));
        $q->execute();
        $this->addScan('Opération manuelle : scan');
        
        $q = new Query();
        $dt = new \DateTime();
        $q->setRequest('INSERT INTO tb_scan '
                . '(tt_type, '
                . 'fk_billet, '
                . 'in_day, '
                . 'in_hour) '
                . 'VALUES '
                . '('.$q->argument('OK', Query::$SQL_STRING).','
                . ' '.$q->argument($this->getPk(), Query::$SQL_NUMERIC).','
                . ' '.$q->argument($dt->format('d'), Query::$SQL_NUMERIC).', '
                . ' '.$q->argument($dt->format('h'), Query::$SQL_NUMERIC).')');
        $q->execute();
    }
    
    public function cancelOkScan(){
        $this->addScan('Opération manuelle : annulation du scan');
        $q = new Query();
        $q->setRequest('DELETE FROM tb_scan WHERE fk_billet='.$q->argument($this->getPk(), Query::$SQL_NUMERIC).' AND tt_type='.$q->argument('OK', Query::$SQL_STRING));
        $q->execute();
    }
    
    public function saveComments($comments){
        $q = new Query();
        $q->setRequest('UPDATE tb_billet SET tt_commentaires='.$q->argument($comments, Query::$SQL_STRING).' WHERE pk_billet='.$q->argument($this->getPk(), Query::$SQL_NUMERIC));
        $q->execute();
        $this->addScan('Opération manuelle : modification du commentaire');
    }
}