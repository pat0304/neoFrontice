<?php 
namespace App\Enums;

enum AccessLevel: int
{
    case SUPER_ADMIN = 1;
    case ADMIN = 2;
    case MODERATOR = 3;
    case SUPPORT = 4;
}