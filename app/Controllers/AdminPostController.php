<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminPostController extends BaseController
{
    public function index()
    {
        $PostModel = model("PostModel");
        $data = [
            'posts' => $PostModel->findAll()
        ];
        return view("posts/index", $data);
    }

    public function create()
    {
        session();
        $data = [
            'validation' => \Config\Services::validation(),
        ];
        return view("posts/create", $data);
    }

    public function store()
    {
        $valid = $this->validate([
            "judul" => [
                "label" => "judul",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!"
                ]
            ],
            "slug" => [
                "label" => "slug",
                "rules" => "required|is_unique[posts.slug]",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                    "is_unique" => "{filed} sudah ada!"
                ]
            ],
            "kategori" => [
                "label" => "kategori",
                "rules" => "required",
                "errors" => [
                    "{field} Harus Diisi!"
                ]
            ],
            "author" => [
                "label" => "author",
                "rules" => "required",
                "errors" => [
                    "{field} Harus Diisi!"
                ]
            ],
            "deskripsi" => [
                "label" => "deskripsi",
                "rules" => "required",
                "errors" => [
                    "{field} Harus Diisi!"
                ]
            ]
        ]);

        if ($valid) {
            $data = [
                'judul' => $this->request->getVar('judul'),
                'slug' => $this->request->getVar('slug'),
                'kategori' => $this->request->getVar('kategori'),
                'author' => $this->request->getVar('author'),
                'deskripsi' => $this->request->getVar('deskripsi'),
            ];

            $PostModel = model("PostModel");
            $PostModel->insert($data);
            return redirect()->to(base_url('/admin/posts/'));
        } else {
            return redirect()->to(base_url('/admin/posts/create'))->withInput()->with('validation', $this->validator);
        }
        // return view("posts/store");
    }
}
