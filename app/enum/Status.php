<?php

namespace App\Enum;

enum Status: int

{
    case active = 1;
    case pending = 0 ;

    //Enum Method
    public function Status(): array
    {

        return match ($this) {

            self::active => [

                'user-edit',
                'user-insert',
                'user-delete',
            ],

            self::pending => [
                'user-login'
            ]
        };
    }
}
