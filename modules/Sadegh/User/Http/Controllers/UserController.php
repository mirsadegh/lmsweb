<?php


namespace Sadegh\User\Http\Controllers;


use App\Http\Controllers\Controller;
use Sadegh\Common\Responses\AjaxResponses;
use Sadegh\Media\Services\MediaFileServiece;
use Sadegh\RolePermissions\Models\Role;
use Sadegh\RolePermissions\Repositories\RoleRepo;
use Sadegh\User\Http\Requests\addRoleRequest;
use Sadegh\User\Http\Requests\UpdateUserRequest;
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

    public function edit($userId,RoleRepo $roleRepo)
    {
        $this->authorize('edit',User::class);
        $user = $this->userRepo->findById($userId);
        $roles = $roleRepo->all();
        return view("User::Admin.edit",compact('user','roles'));
        
    }

    public function update(UpdateUserRequest $request,$userId)
    {
        $this->authorize('edit',User::class);
        $user = $this->userRepo->findById($userId);

        if ($request->hasFile('image')) {
            $request->request->add(['image_id' => MediaFileServiece::upload($request->file('image'))->id]);
            if ($user->banner)
                $user->banner->delete();
        } else {
            $request->request->add(['image_id' => $user->image_id]);

        }
        $this->userRepo->update($userId,$request);
        newFeedback();
        return redirect()->back();
    }

    public function destroy($userId)
    {
        $user = $this->userRepo->findById($userId);
        $user->delete();
        return AjaxResponses::successResponses();
    }

    public function manualVerify($userId)
    {
        $this->authorize('manualVerify',User::class);
        $user = $this->userRepo->findById($userId);
        $user->markEmailAsVerified();
        return AjaxResponses::successResponses();

    }

    public function addRole(addRoleRequest $request ,User $user)
    {
        $this->authorize('addRole',User::class);
        $user->assignRole($request->role);
        newFeedback('موفقیت آمیز',  " نقش کاربری  {$request->role} به کاربر {$user->name} داده شد.",'success');
        return back();
    }

    public function removeRole($userId,$role)
    {
        $this->authorize('removeRole',User::class);
        $user = $this->userRepo->findById($userId);
        $user->removeRole($role);
        return AjaxResponses::successResponses();

    }
}