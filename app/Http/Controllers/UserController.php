<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Services\UserService;

// Validation
use App\Http\Requests\User\CreateUser;
use App\Http\Requests\User\UpdateUser;

class UserController extends Controller
{

    protected $userService;


    /**
     * Create a new controller instance.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show the index
     */
    public function index(Request $request)
    {
        // For Datatables
        if ($request->ajax()) {
            return Datatables::of($this->userService->getAllUsers())
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn =  "
                                    <a href='/admin/user/$row->id' class=''>Edit</a> |
                                    <a href='#' onclick='deleteUser(".$row->id.")' class=''>Delete</a>

                                    ";
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        // Return the view
        return view('admin.user.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUser $request)
    {
        try {
            $result = $this->userService->saveUser($request);

            return redirect(route('admin.user.index'))->with([
                'status'=>"success",
                "message" => 'User successully created'
            ]);
        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Int $id)
    {
        try {
            $result = $this->userService->getOneById($id);

            // return to view with data
            return view('admin.user.edit')->with(["user"=>$result]);

        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Int $user)
    {
        return redirect(route('admin.user.show',$user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(UpdateUser $request, Int $user)
    { 
        try {
            $result = $this->userService->updateUser($request, $user);

            return back()->with([
                'status'=>"success",
                "message" => 'User successully updated'
            ]);

        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Soft delete the specified resource from storage.
     */
    public function destroy(Int $user)
    { 
        try {
            $result = $this->userService->softDeleteUser($user);

            return redirect(route('admin.user.index'))->with([
                'status'=>"warning",
                "message" => 'User successully deleted.'
            ]);

        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }
    }
}
