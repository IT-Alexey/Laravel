<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller {

    public function registerForm() {
        return view('pages.register');
    }

    public function register(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        $user = User::add($request->all());
        $user->generatePassword($request->get('password'));

        return redirect('/login');
    }

    public function loginform() {
        return view('pages.login');
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt([
                    'email' => $request->get('email'),
                    'password' => $request->get('password'),
                ])) {
            return redirect('');
        }
        return redirect()->back()->with('status', 'Неправильный логин или пароль');
//        dd(Auth::check());
//        1 . Проверить пользователя на основе емайла и пароль
//        2. Если человек ввёл неправильный логин или пароль выводим флеш сообщение 
//        3. Иначе редиректим его на главную
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }

}
