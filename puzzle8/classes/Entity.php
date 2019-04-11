<?php

/**
 * \Entity
 *
 * @author Filipe Voges <filipe@emsventura.com.br>
 * @since 2019-04-11
 * @version 1.0
 */
abstract class Entity extends stdClass{

    /**
     * Getter Generic
     *
     * @param $property | String
     * @return mixed
     */
    public function get($property){
        if(property_exists($this, $property)){
            return $this->$property;
        }else{
            throw new Exception("Atributo inexistente." . "-> {$property}", 500);
        }
    }

    /**
     * Setter Generic
     *
     * @param $property | String
     * @param $value | mixed
     * @return void
     */
    public function set($property, $value){
        $this->$property = $value;
    }

    /**
     * returns a Attributes of Class
     *
     * @return array
     */
    public function getAttibutes(){
        return get_object_vars($this);
    }

    /**
     * Set the attributes of the class.
     *
     * @param $dados Array
     * @return void
     */
    protected function populate(array $dados){
        if(empty($dados)){
            throw new Exception("Não há dados para popular a Classe " . get_class($this), 400);
        }

        foreach ($dados as $key => $value) {
            $this->set($key, $value);
        }
    }

}
