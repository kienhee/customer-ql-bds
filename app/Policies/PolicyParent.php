<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

class PolicyParent
{
    public $role;

    public $module;

    public function __construct()
    {
        $this->role = json_decode(Auth::user()->group->permissions, true);
    }
    public function view()
    {
        return isRole($this->role, $this->module, 'view');
    }
    public function create()
    {
        return isRole($this->role, $this->module, 'add');
    }
    public function update()
    {
        return isRole($this->role, $this->module, 'edit');
    }
    public function delete()
    {
        return isRole($this->role, $this->module, 'delete');
    }
}
