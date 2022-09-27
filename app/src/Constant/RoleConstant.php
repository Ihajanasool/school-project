<?php

namespace App\Constant;

/**
 * Class RoleConstant.
 */
class RoleConstant
{
    public const ROLE_SEKOLIKO = [
        'Administrateur' => 'ROLE_ADMIN',
        'Professeur' => 'ROLE_PROFS',
        'Etudiant' => 'ROLE_ETUDIANT',
        'Direction' => 'ROLE_DIRECTION',
        'SuperAdmin' => 'ROLE_SUPER_ADMIN',
        'Secretaire' => 'ROLE_SECRETAIRE',
        'Trésorier' => 'ROLE_TRESORIER',
        'secretaire' => 'ROLE_SECRETAIRE',
    ];

    public const ROLE_PROFS = 1;
}
