<?php

declare(strict_types=1);

namespace ElementorToGutenberg;

class Admin
{
    public static function page()
    {
        include ETG_DIR . 'templates/admin.php';
    }
}