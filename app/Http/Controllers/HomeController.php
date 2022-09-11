<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $provinces = $this->provinces();

        $employes = Employee::where('position', 'like', '%' . request()->filterPosition . '%')->where(function ($query) {
            $query->where('first_name', 'like', '%' . request()->filterName . '%')
                ->orWhere('last_name', 'like', '%' . request()->filterName . '%');
        })->orderBy('first_name', 'asc')->paginate(10)->withQueryString();

        return view('home', compact(['provinces', 'employes']));
    }

    protected function provinces()
    {
        $provinces = file_get_contents('http://dev.farizdotid.com/api/daerahindonesia/provinsi');
        $provinces = json_decode($provinces, true);
        $provinces = $provinces['provinsi'];

        return $provinces;
    }

    public function view($id)
    {
        $emp = Employee::find($id);

        $cover = asset(Storage::url($emp->photo_ktp));

        $return = '<div class="modal-header">        
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="' . $cover . '" alt="ktp" class="img img-fluid">
                    </div>';

        return $return;
    }

    public function edit($id)
    {
        $emp = Employee::find($id);

        $cover = asset(Storage::url($emp->photo_ktp));
        $provinces = $this->provinces();

        $url = route('employes.update', $id);

        $return = [
            'provinces' => $provinces,
            'data'      => $emp,
            'url'       => $url
        ];

        return $return;
    }
}
