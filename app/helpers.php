<?php

use App\Models\Characteristic;
use App\Models\Direction;
use App\Models\District;
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
function districts()
{
  return District::orderBy('created_at', 'desc')->get();
}
function directions()
{
  return Direction::orderBy('created_at', 'desc')->get();
}
function characteristics()
{
  $list = [];
  foreach (Characteristic::all() as $value) {
    $list[] = $value->name;
  }
  return  json_encode($list);
}
function getThumb($originalPath)
{
  // Tách đường dẫn thành thư mục và tên file
  $pathInfo = pathinfo($originalPath);

  // Tạo đường dẫn mới với thư mục 'thumbs'
  $newPath = $pathInfo['dirname'] . '/thumbs/' . $pathInfo['basename'];

  return $newPath;
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
