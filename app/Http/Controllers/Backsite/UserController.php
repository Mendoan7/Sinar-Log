<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;

// use library here
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

// request
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

// use everything here
use Gate;
use Auth;

// use model here
use App\Models\User;
use App\Models\ManagementAccess\DetailUser;
use App\Models\ManagementAccess\Permission;
use App\Models\ManagementAccess\Role;
use App\Models\ManagementAccess\TypeUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (auth()->user()->detail_user->type_user_id == 2) {
            $user = User::whereHas('detail_user', function ($query) {
                $query->where('type_user_id', '!=', 1);
            })->orderBy('created_at', 'desc')->get();
        } else {
            $user = User::orderBy('created_at', 'desc')->get();
        }

        $type_user = TypeUser::orderBy('name', 'asc')->get();
        $roles = Role::all()->pluck('title', 'id');

        return view('pages.backsite.management-access.user.index', compact('user', 'roles', 'type_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('role');

        return view('pages.backsite.management-access.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (auth()->user()->detail_user->type_user_id == 2) {
            $role = Role::where('id', '!=', 1)->pluck('title', 'id');
            $type_user = TypeUser::where('id', '!=', 1)->orderBy('name', 'asc')->get();
        } else {
            $role = Role::all()->pluck('title', 'id');
            $type_user = TypeUser::orderBy('name', 'asc')->get();
        }

        $user->load('role');

        return view('pages.backsite.management-access.user.edit', compact('user', 'role', 'type_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // get all request from frontsite
        $data = $request->all();

        // update to database
        $user->update($data);

        // update roles
        $user->role()->sync($request->input('role', []));

        // save to detail user , to set type user
        $detail_user = DetailUser::find($user['id']);
        $detail_user->type_user_id = $request['type_user_id'];
        $detail_user->save();

        alert()->success('Success Message', 'Successfully updated user');
        return redirect()->route('backsite.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->forceDelete();

        alert()->success('Success Message', 'Successfully deleted user');
        return back();
    }

    // Custom

    public function updateStatus(User $user, $status)
    {
        
        $statusValue = $status === 'activate' ? 1 : 0;
        $user->update(['status' => $statusValue]);

        $statusText = $status === 'activate' ? 'Berhasil Aktif' : 'Di Nonaktifkan';
        $message = "User $statusText.";

        alert()->success('Success Message', $message);
        return back();
    }

}
