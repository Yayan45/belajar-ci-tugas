<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\DiskonModel;

class AuthController extends BaseController
{
    protected $user;

    public function __construct()
    {
        helper('form');
        $this->user = new UserModel();
    }

    public function login()
    {
        if ($this->request->getPost()) {
            $rules = [
                'username' => 'required|min_length[6]',
                'password' => 'required|min_length[7]|numeric',
            ];

            if ($this->validate($rules)) {
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');

                $dataUser = $this->user->where(['username' => $username])->first();

                if ($dataUser) {
                    if (password_verify($password, $dataUser['password'])) {
                        // Simpan data login ke session
                        session()->set([
                            'username' => $dataUser['username'],
                            'role'     => $dataUser['role'],
                            'isLoggedIn' => true
                        ]);

                        // ✅ Cek diskon hari ini
                        $tglHariIni = date('Y-m-d');
                        $diskonModel = new DiskonModel();
                        $diskon = $diskonModel->where('tanggal', $tglHariIni)->first();

                        if ($diskon) {
                            session()->set('diskon_nominal', $diskon['nominal']);
                        } else {
                            session()->remove('diskon_nominal');
                        }

                        return redirect()->to(base_url('/'));
                    } else {
                        session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                        return redirect()->back()->withInput();
                    }
                } else {
                    session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                    return redirect()->back()->withInput();
                }
            } else {
                session()->setFlashdata('failed', $this->validator->listErrors());
                return redirect()->back()->withInput();
            }
        }

        return view('v_login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
