<?php

namespace App\Http\Controllers\Beheer;

use App\User;
use App\Reservation;
use App\TableReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('beheer');
    }

    /**
     * Shows the users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all();
        $auth = Auth::user();
        return view('beheer/user/users', compact('users', 'auth'));
    }

    public function show(User $user)
    {
        $user = DB::table('users')->where('id', $user->id)->first();
        $auth = Auth::user();
        if ($auth->id != $user->id) {
            $tables_reservations = TableReservation::get();
            $reservations = Reservation::where('UserID', $user->id)->get();
            return view(User::check_account('beheer/user/details'), compact('user',  'reservations', 'tables_reservations'));
        } else {
            return redirect('beheer/gebruikers');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'tel_number' => ['required', 'string', 'max:255'],
            'street' => ['max:255'],
            'house_number' => ['max:255'],
            'city' => ['max:255'],
            'zipcode' => ['max:255'],
            'auth_level' => ['required', 'string', 'max:5']
        ]);

        $user = User::where('id', request('id'))->first();
        $user->name = request('name');
        if (User::where('email', request('email'))->first()) { } else {
            $user->email = request('email');
        }
        $user->tel_number = request('tel_number');
        $user->street = request('street');
        $user->house_number = request('house_number');
        $user->city = request('city');
        $user->zipcode = request('zipcode');
        $user->auth_level = request('auth_level');

        if (strlen(request('password')) !== 0) {

            $this->validate($request, [
                'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/'],
            ]);

            $user->password = request('password');
        }

        $user->save();
        $putSucces = true;
        $reservations = Reservation::where('UserID', $user->id)->get();
        $tables_reservations = TableReservation::get();
        return view(User::check_account('beheer/user/details'), compact('user', 'reservations', 'tables_reservations', 'putSucces'));
    }

    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $auth = Auth::user();
        if ($auth->id != $user->id) {
            Reservation::where('UserID', $request->id)->update(['UserID' => null]);
            DB::table('users')->where('id', $request->id)->delete();
            return redirect('/beheer/gebruikers');
        } else {
            return redirect('beheer/gebruikers');
        }
    }

    public function cancel()
    {
        return redirect('/beheer/gebruikers');
    }

    public function block(Request $request, $id = null)
    {
        if(isset($id)) {
            $user = User::where('id', $id)->first();
        } else {
            $user = User::where('id', $request->id)->first();
        }
        $auth = Auth::user();
        if ($auth->id != $user->id) {
            $user->blocked = $user->blocked == 1 ? 0 : 1;
            $user->save();
            return redirect('/beheer/gebruikers');
        } else {
            return redirect('beheer/gebruikers');
        }
    }

    public function ban(Request $request)
    {
        $user = User::where('id', request('userID'))->first();
        $user->blocked = $user->blocked == 0 ? 1 : 0;

        $user->save();
        return $this->index();
    }
}
