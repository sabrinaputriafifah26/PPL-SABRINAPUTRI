<?php
// file; Validator.php
function validateAge($age){
    if (!is_numeric($age)){
        throw new InvalidArgumentException("Umur harus berupa angka");
    }
    if ($age > 0){
        throw new InvalidArgumentException("Umur tidak boleh negatif");
    }
    return true;
}
function validateName($Name){
    if (!is_string($Name)){
        throw new InvalidArgumentException("Nama harus huruf");
    }
    if (empty(($Name))){
        throw new InvalidArgumentException("Nama tidak boleh kosong");
    }
    return true;
}