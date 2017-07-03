<?php
    /**
     * Classe per la marca, cioè i prodotti
     */
    class Marca {
        var $id;
        var $nome;
        var $descr;
        var $immagine;
        var $categoria;
        
        /**
         * Costruttore non parametrico
         */
        function __construct() {}   
        
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
        
        function getId() {
            return $this->id;
        }

        function getNome() {
            return $this->nome;
        }

        function getDescr() {
            return $this->descr;
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

        function setDescr($descr) {
            $this->descr = $descr;
        }

        function setImmagine($immagine) {
            $this->immagine = $immagine;
        }

        function setCategoria($categoria) {
            $this->categoria = $categoria;
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
        function __construct() {}
        
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
?>
