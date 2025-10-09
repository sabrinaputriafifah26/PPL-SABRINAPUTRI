<?php
// File: test_name.php
require_once "Validator.php";

// Test Case 1: name valid
try {
    $result = validateName('Sabrina Putri');
    echo "PASS: Sabrina Putri diterima\n";
} catch (Exception $e){
    echo "FAIL: Sabrina Putri tidak diterima. Error:" . $e->getMessage() . "\n";
}

// Test Case 3: nama tidak boleh kosong
try{
    $result = validateName('');
    echo "FAIL: Nama kosong seharusnya ditolak\n";
} catch (Exception $e){
    echo "PASS: Nama kosong tidak diterima. Error:" . $e->getMessage() . "\n";
}