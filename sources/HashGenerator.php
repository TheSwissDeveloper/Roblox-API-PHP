<?php

class HashGenerator {
    private $config;
    
    public function __construct($config) {
        $this->config = $config;
    }
    
    public function generate($input) {
        $seed = $this->config['seed'];
        $prime = $this->config['prime'];
        $output = "";
        $offset = 0;
        
        // Phase 1: Offset-Berechnung
        for ($i = 0; $i < strlen($input); $i++) {
            $offset = ($offset + ord($input[$i]) * $prime) % 255;
        }
        
        // Phase 2: Hash-Generierung
        for ($i = 0; $i < strlen($input); $i++) {
            $char = ord($input[$i]);
            $seed = (($seed * $prime) ^ ($char * $offset)) % (2 ** 32);
            $offset = ($offset + $char) % 255;
            $output .= $this->config['custom_chars'][$seed % strlen($this->config['custom_chars'])];
        }
        
        // Prefix und Suffix hinzufügen
        return $this->config['prefix'] . $output . $this->config['suffix'];
    }
    
    public function verify($input, $hash) {
        return $this->generate($input) === $hash;
    }
}
