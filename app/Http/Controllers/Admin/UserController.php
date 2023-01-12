<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\User\UserStoreRequest;
use App\Models\User;

use App\Http\Requests\Admin\User\UserUpdateRequest;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Toastr;


class UserController extends BaseController
{

    /**
     * UserController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->addBaseView('user');
        $this->addBaseRoute('user');
    }

    /**
     * List users
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $users = new User();
        if ($request->has('name')) {
            $users = $users->where(function ($query) use($request) {
                $query->where('first_name', 'LIKE', '%'.$request->name.'%')
                ->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
            });
        }
        if ($request->has('status') && '' != $request->status) {
            $users = $users->where('status', $request->status);
        }
        $users = $users->get();
        return $this->renderView($this->getView('index'), compact('users'), 'User List');
    }

    /**
     * Show form to create user
     *
     * @return Factory|View
     */
    public function create()
    {
        return $this->renderView($this->getView('create'), [], 'Add User');
    }

    /**
     * Store user to DB
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request)
    {
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
        ]);
        Toastr::success('User added successfully');
        return redirect()->route($this->getRoute('index'));
    }

    /**
     * Show form to edit user
     *
     * @param User $user
     * @return Factory|View
     */
    public function edit(User $user)
    {
        return $this->renderView($this->getView('edit'), compact('user'), 'Edit User');
    }

    /**
     * Update user
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);
        Toastr::success('User updated successfully');
        return redirect()->route($this->getRoute('index'));
    }

    /**
     * Delete user
     *
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return Response::json(['success' => 'User deleted successfully']);
    }

}
