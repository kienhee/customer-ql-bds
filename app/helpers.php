<?php

use App\Models\Group;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;

function groups()
{
  if (Auth::user()->group_id == 0) {
    return Group::orderBy('created_at', 'desc')->get();
  } else {
    return Group::orderBy('created_at', 'desc')->where('id', '<>', 0)->get();
  }
}
function regions()
{
  return Region::orderBy('created_at', 'desc')->get();
}
function provices()
{
  return Province::orderBy('created_at', 'desc')->get();
}

function isRole($dataArr, $module, $role = 'view')
{
  if (!empty($dataArr)) {
    $roleArr = $dataArr[$module] ?? [];
    if (!empty($roleArr) && in_array($role, $roleArr)) {
      return true;
    }
  }
  return false;
}
