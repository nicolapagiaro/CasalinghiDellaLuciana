<?php

/**
 * Classe per la marca, cioè i prodotti
 */
class Marca {

    var $id;
    var $nome;
    var $immagine;
    var $categoria;
    

    /**
     * Costruttore non parametrico
     */
    function __construct() {
        
    }

    /**
     * 
     * @param type $id
     * @param type $nome
     * @return self oggetto della classe
     */
    public static function conIdNome($id, $nome) {
        $instance = new self();
        $instance->setId($id);
        $instance->setNome($nome);
        return $instance;
    }
    
    /**
     * 
     * @param type $id
     * @param type $nome
     * @param type $immagine
     * @return self oggetto della classe
     */
    public static function conIdNomeImmagine($id, $nome, $immagine) {
        $instance = new self();
        $instance->setId($id);
        $instance->setNome($nome);
        $instance->setImmagine($immagine);
        return $instance;
    }
    
    /**
     * 
     * @param type $id
     * @param type $nome
     * @param type $descrizione
     * @return self oggetto della classe
     */
    public static function conIdNomeDescrizioneEtaImmagine($id, $nome, $descrizione, $eta, $immagine) {
        $instance = new self();
        $instance->setId($id);
        $instance->setNome($nome);
        $instance->setDescrizione($descrizione);
        $instance->setEta($eta);
        $instance->setImmagine($immagine);
        return $instance;
    }
    
    /**
     * 
     * @param type $id
     * @param type $nome
     * @param type $immagine
     * @return self oggetto della classe
     */
    public static function conIdNomeImmagineCategoria($id, $nome, $immagine, $categoria) {
        $instance = new self();
        $instance->setId($id);
        $instance->setNome($nome);
        $instance->setImmagine($immagine);
        $instance->setCategoria($categoria);
        return $instance;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }
    function getImmagine() {
        return $this->immagine;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setImmagine($immagine) {
        $this->immagine = $immagine;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    
    /**
     * toString
     * @return type
     */
    public function __toString(){
        $v = $this->id."-".$this->descrizione."-".$this->immagine."-"
                .$this->categoria."-".$this->nome;
        return $v;
    }
}

/**
 * Classe per le categorie di prodotti
 */
class Categoria {

    var $id;
    var $nome;
    var $descrizione;
    var $immagine;
    var $marche;
    var $fotos;
    var $eta;

    /**
     * Costruttore non parametrico
     */
    function __construct() {
        
    }

    /**
     * 
     * @param type $id
     * @param type $nome
     * @param type $immagine
     * @return self oggetto della classe
     */
    public static function conIdNomeImmagine($id, $nome, $immagine) {
        $instance = new self();
        $instance->setId($id);
        $instance->setNome($nome);
        $instance->setImmagine($immagine);
        return $instance;
    }

    /**
     * 
     * @param type $id
     * @param type $nome
     * @return self oggetto della classe
     */
    public static function conIdNome($id, $nome) {
        $instance = new self();
        $instance->setId($id);
        $instance->setNome($nome);
        return $instance;
    }

    function getId() {
        return $this->id;
    }

    function getDescrizione() {
        return $this->descrizione;
    }

    function getImmagine() {
        return $this->immagine;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescrizione($descrizione) {
        $this->descrizione = $descrizione;
    }

    function setImmagine($immagine) {
        $this->immagine = $immagine;
    }

    function getNome() {
        return $this->nome;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function getMarche() {
        return $this->marche;
    }

    function setMarche($marche) {
        $this->marche = $marche;
    }
    

    function getFotso() {
        return $this->fotos;
    }

    function setFotos($fotos) {
        $this->fotos = $fotos;
    }
    
    
    function getEta() {
        return $this->eta;
    }

    function setEta($eta) {
        $this->eta = $eta;
    }
    
    /**
     * toString
     * @return type
     */
    public function __toString(){
        $v = $this->id."-".$this->descrizione."-".$this->immagine."-".print_r($this->marche)."-".$this->nome."-"
                .$this->fotos;
        return $v;
    }
}

class Foto {
    var $id;
    var $immagine;
    var $categoria;

    /**
     * Costruttore vuoto
     */
    function __construct() {
        
    }

    /**
     * 
     * @param type $id
     * @param type $immagine
     * @return self oggetto della classe
     */
    public static function conIdImmagine($id, $immagine) {
        $instance = new self();
        $instance->setId($id);
        $instance->setImmagine($immagine);
        return $instance;
    }
    
    function getId() {
        return $this->id;
    }

    function getImmagine() {
        return $this->immagine;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setImmagine($immagine) {
        $this->immagine = $immagine;
    }
    
    function getCategoria() {
        return $this->categoria;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

        
    /**
     * toString
     * @return type
     */
    public function __toString(){
        $v = $this->id."-".$this->immagine."-".$this->categoria;
        return $v;
    }
}

/**
 * Classe per gestire le news che appariranno nella home del sito
 */
class News {
   var $id;
   var $titolo;
   var $descrizione; 
   var $coloreTesto;
   var $immagine; 
   var $dataI;
   var $dataF; 
   
   /**
    * Costruttore con tutto
    * @param type $id
    * @param type $titolo
    * @param type $descrizione
    * @param type $coloreTesto
    * @param type $immagine
    * @param type $dataI
    * @param type $dataF
    */
   function __construct($id, $titolo, $descrizione, $coloreTesto, $immagine, $dataI, $dataF) {
       $this->id = $id;
       $this->titolo = $titolo;
       $this->descrizione = $descrizione;
       $this->coloreTesto = $coloreTesto;
       $this->immagine = $immagine;
       $this->dataI = $dataI;
       $this->dataF = $dataF;
   }

      
   function getId() {
       return $this->id;
   }

   function getTitolo() {
       return $this->titolo;
   }

   function getDescrizione() {
       return $this->descrizione;
   }

   function getColoreTesto() {
       return $this->coloreTesto;
   }

   function getImmagine() {
       return $this->immagine;
   }

   function getDataI() {
       return $this->dataI;
   }

   function getDataF() {
       return $this->dataF;
   }

   function setId($id) {
       $this->id = $id;
   }

   function setTitolo($titolo) {
       $this->titolo = $titolo;
   }

   function setDescrizione($descrizione) {
       $this->descrizione = $descrizione;
   }

   function setColoreTesto($coloreTesto) {
       $this->coloreTesto = $coloreTesto;
   }

   function setImmagine($immagine) {
       $this->immagine = $immagine;
   }

   function setDataI($dataI) {
       $this->dataI = $dataI;
   }

   function setDataF($dataF) {
       $this->dataF = $dataF;
   }
}
