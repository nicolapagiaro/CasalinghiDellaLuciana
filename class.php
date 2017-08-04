<?php

/**
 * Classe per la marca, cioè i prodotti
 */
class Marca {

    var $id;
    var $nome;
    var $descrizione;
    var $immagine;
    var $categoria;
    var $eta;
    var $fotos;

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
     * @param type $descrizione
     * @return self oggetto della classe
     */
    public static function conIdNomeDescrizioneEta($id, $nome, $descrizione, $eta) {
        $instance = new self();
        $instance->setId($id);
        $instance->setNome($nome);
        $instance->setDescrizione($descrizione);
        $instance->setEta($eta);
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

    function getDescrizione() {
        return $this->descrizione;
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

    function setDescrizione($descr) {
        $this->descrizione = $descr;
    }

    function setImmagine($immagine) {
        $this->immagine = $immagine;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
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
}

/**
 * Classe per le categorie di prodotti
 */
class Categoria {

    var $id;
    var $nome;
    var $descrizione;
    var $immagine;

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

}

class Foto {
    var $id;
    var $immagine;
    var $marca;

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

    function getMarca() {
        return $this->marca;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setImmagine($immagine) {
        $this->immagine = $immagine;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }

}
