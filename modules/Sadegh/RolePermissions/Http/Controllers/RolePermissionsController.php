<?php

namespace Sadegh\RolePermissions\Http\Controllers;


use App\Http\Controllers\Controller;
use Sadegh\Category\Responses\AjaxResponses;
use Sadegh\RolePermissions\Http\Requests\RoleRequest;
use Sadegh\RolePermissions\Http\Requests\RoleUpdateRequest;
use Sadegh\RolePermissions\Repositories\PermissionRepo;
use Sadegh\RolePermissions\Repositories\RoleRepo;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsController extends Controller
{

    private $roleRepo;
    private $permissionRepo;

    public function __construct(RoleRepo $roleRepo,PermissionRepo $permissionRepo)
    {
        $this->roleRepo = $roleRepo;
        $this->permissionRepo = $permissionRepo;
    }
    
    public function index()
    {
        $roles = $this->roleRepo->all();
        $permissions = $this->permissionRepo->all();
        return view('RolePermissions::index',compact('roles','permissions'));
    }

    public function store(RoleRequest $request)
    {
      return $this->roleRepo->create($request);
    }

    public function edit($roleId)
    {
      $role =  $this->roleRepo->findById($roleId);
      $permissions = $this->permissionRepo->all();
      return view('RolePermissions::edit',compact('role','permissions'));
    }

    public function update(RoleUpdateRequest $roleUpdateRequest,$id)
    {
        $this->roleRepo->update($id,$roleUpdateRequest);
        return redirect(route('role-permissions.index'));
    }

    public function destroy($roleId)
    {
        $this->roleRepo->delete($roleId);
        return AjaxResponses::successResponses();
    }


}