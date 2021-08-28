<?php

use Vinkla\Hashids\Facades\Hashids;

    function id2Hash($id){
        $hashids = new Hashids('mzpmagicpay123',8);
        return $hashids->encode($id);
    }

    function hash2Id($hash){

        $hashids = new Hashids('mzpmagicpay123',8);
        return $hashids->decode($hash)[0];
    }
