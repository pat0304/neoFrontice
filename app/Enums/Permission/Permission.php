<?php

namespace App\Enums\Permission;

use App\Traits\CrudAction;

enum Permission: string
{
    use CrudAction;
    case USERS = 'manage_users';
    case ROLES = 'manage_roles';
    case CHALLENGES = 'manage_challenges';
    case FILES = 'manage_files';
    case TASKS = 'manage_tasks';
    case SOLUTIONS = 'manage_solutions';
}
