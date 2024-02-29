<?php

namespace App\Enum;

enum UserStatus:int
{
    case pending = 0;
    case active = 1;
}
