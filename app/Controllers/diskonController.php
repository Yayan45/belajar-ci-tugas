<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    protected $diskon;

    public function __construct()
    {
        $this->diskon = new DiskonModel();
        helper(['form']);
    }

    private function onlyAdmin()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses hanya untuk admin.');
        }
    }

    public function index()
    {
        if ($this->onlyAdmin()) return $this->onlyAdmin();

        $data['diskon'] = $this->diskon->orderBy('tanggal', 'DESC')->findAll();
        return view('v_diskon', $data);
    }

    public function store()
    {
        if ($this->onlyAdmin()) return $this->onlyAdmin();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'tanggal' => [
                'label' => 'Tanggal Diskon',
                'rules' => 'required|is_unique[diskon.tanggal]',
                'errors' => [
                    'required' => 'Tanggal diskon tidak boleh kosong.',
                    'is_unique' => 'Diskon untuk tanggal tersebut sudah ada.'
                ]
            ],
            'nominal' => [
                'label' => 'Nominal Diskon',
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => [
                    'required' => 'Nominal diskon wajib diisi.',
                    'numeric' => 'Nominal diskon harus berupa angka.',
                    'greater_than_equal_to' => 'Nominal diskon tidak boleh negatif.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('/diskon')
                ->withInput()
                ->with('errors', $validation->getErrors())
                ->with('modal', 'tambah');
        }

        $tanggal = $this->request->getPost('tanggal');
        $nominal = $this->request->getPost('nominal');

        $this->diskon->save([
            'tanggal' => $tanggal,
            'nominal' => $nominal,
        ]);

        // ✅ Set session jika diskon untuk hari ini
        if ($tanggal === date('Y-m-d')) {
            session()->set('diskon_nominal', $nominal);
        }

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function update($id)
    {
        if ($this->onlyAdmin()) return $this->onlyAdmin();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nominal' => [
                'label' => 'Nominal Diskon',
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => [
                    'required' => 'Nominal diskon tidak boleh kosong.',
                    'numeric' => 'Nominal diskon harus berupa angka.',
                    'greater_than_equal_to' => 'Nominal tidak boleh bernilai negatif.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $edit = $this->diskon->find($id);
            return redirect()->to('/diskon')
                ->withInput()
                ->with('errors', $validation->getErrors())
                ->with('modal', 'edit')
                ->with('edit_id', $id)
                ->with('edit_data', $edit);
        }

        $nominalBaru = $this->request->getPost('nominal');
        $this->diskon->update($id, [
            'nominal' => $nominalBaru,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // ✅ Perbarui session jika ini diskon hari ini
        $diskon = $this->diskon->find($id);
        if ($diskon && $diskon['tanggal'] === date('Y-m-d')) {
            session()->set('diskon_nominal', $nominalBaru);
        }

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil diupdate.');
    }

    public function delete($id)
    {
        if ($this->onlyAdmin()) return $this->onlyAdmin();

        $diskon = $this->diskon->find($id);
        $this->diskon->delete($id);

        // ✅ Hapus session jika yang dihapus adalah diskon hari ini
        if ($diskon && $diskon['tanggal'] === date('Y-m-d')) {
            session()->remove('diskon_nominal');
        }

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil dihapus.');
    }

    public function tambah($id)
    {
        $produkModel = new \App\Models\ProductModel();
        $produk = $produkModel->find($id);

        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $harga = $produk['harga'];

        if (session()->has('diskon_nominal')) {
            $harga -= session('diskon_nominal');
            if ($harga < 0) $harga = 0;
        }

        $cart = service('cart');
        $cart->insert([
            'id'      => $produk['id'],
            'name'    => $produk['nama'],
            'price'   => $harga,
            'qty'     => 1,
            'options' => ['foto' => $produk['foto'] ?? 'default.jpg'],
        ]);

        return redirect()->to('/keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }
}
