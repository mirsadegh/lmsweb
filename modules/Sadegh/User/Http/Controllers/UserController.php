<?php


namespace Sadegh\User\Http\Controllers;


use App\Http\Controllers\Controller;
use Sadegh\RolePermissions\Models\Role;
use Sadegh\RolePermissions\Repositories\RoleRepo;
use Sadegh\User\Http\Requests\addRoleRequest;
use Sadegh\User\Models\User;
use Sadegh\User\Repositories\UserRepo;

class UserController extends Controller
{

    /**
     * @var UserRepo
     */
    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {

        $this->userRepo = $userRepo;
    }
    
    public function index(RoleRepo $roleRepo)
    {
        $this->authorize('addRole',User::class);
        $users = $this->userRepo->paginate();
        $roles = $roleRepo->all();
        return view("User::Admin.index",compact('users','roles'));
    }

    public function addRole(addRoleRequest $request ,User $user)
    {
        $this->authorize('addRole',User::class);
        $user->assignRole($request->role);
        newFeedback('موفقیت آمیز',  " نقش کاربری  {$request->role} به کاربر {$user->name} داده شد.",'success');
        return back();
    }
}