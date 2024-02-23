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
  $userGroupId = Auth::user()->group_id;
  $groups = Group::query();
  if ($userGroupId == 2) {
    // Miền
    $groups->whereNotIn('id', range(1, 2));
  } elseif ($userGroupId == 3) {
    // tỉnh
    $groups->whereNotIn('id', range(1, 3));
  } elseif ($userGroupId == 4) {
    // huyện
    $groups->whereNotIn('id', range(1, 4));
  } elseif ($userGroupId == 5) {
    // trưởng phòng
    $groups->whereNotIn('id', range(1, 5));
  }

  return $groups->get();
}
function regions()
{
  $userGroupId = Auth::user()->group_id;
  $regions = Region::query();
  if ($userGroupId != 1) {
    $regions->where('id', Auth::user()->region_id);
  }
  return $regions->get();
}
function provinces()
{
  $userGroupId = Auth::user()->group_id;
  $provinces = Province::query();
  if ($userGroupId == 1) {
    // admin->lấy hết
    return $provinces->get();
  } elseif ($userGroupId == 2) {
    // ql miền -> lấy các tỉnh trong miền
    return $provinces->where('region_id', Auth::user()->region_id)->get();
  } else {
    // Cấp khác chỉ lấy nguyên tỉnh nó ở
    return $provinces->where('id', Auth::user()->province_id)->get();
  }
}
function districts()
{
  $userGroupId = Auth::user()->group_id;
  $districts = District::query();
  if ($userGroupId != 1) {
    $districts->where('id', Auth::user()->district_id);
  }
  return $districts->get();
  // return District::orderBy('created_at', 'desc')->get();
}
function districtByProvince()
{
  $userGroupId = Auth::user()->group_id;
  $districts = District::query();
  if ($userGroupId != 1) {
    $districts->where('province_id', Auth::user()->province_id);
  }
  return $districts->get();
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
