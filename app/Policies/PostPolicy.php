<?php

namespace App\Policies;

use App\Models\User;

class PostPolicy extends PolicyParent

{
    public $module = 'posts';
    public function comment()
    {
        return true;
    }
    public function news()
    {
        return true;
    }
}
