<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PostModel;

class AdminPostsController extends BaseController
{
    protected $PostModel;

    public function __construct()
    {
        $this->PostModel = new PostModel();
    }

    public function index()
    {
        $PostModel = model("PostModel");
        $data = [
            'posts' => $PostModel->findall()
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
            "post_title" => [
                "label" => "Judul",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
            "slug" => [
                "label" => "Slug",
                "rules" => "required|is_unique[posts.slug]",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                    "is_unique" => "{field} sudah ada!",
                ]
            ],
            "post_category" => [
                "label" => "Kategori",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
            "post_author" => [
                "label" => "Author",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
            "post_description" => [
                "label" => "Deskripsi",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ]
        ]);

        if ($valid) {
            $data = [
                'post_title' => $this->request->getVar('post_title'),
                'slug' => $this->request->getVar("slug"),
                'post_category' => $this->request->getVar("post_category"),
                'post_author' => $this->request->getVar("post_author"),
                'post_description' => $this->request->getVar("post_description")
            ];
            $PostModel = model("PostModel");
            $PostModel->insert($data);
            return redirect()->to(base_url('/admin/posts'));
        } else {
            return redirect()->to(base_url('/admin/posts/create'))->withInput()->with('validation', $this->validator);
        }
    }

    public function delete($slug)
    {
        $posts = new PostModel();
        $posts->where(['slug' => $slug])->delete();
        session()->setFlashdata('message', ' Post Deleted Successfully');
        session()->setFlashdata('alert-class', 'alert-danger');
        return redirect()->to(base_url('admin/posts/'));
    }

    public function edit($slug)
    {
        session();
        $data = [
            'validation' => \Config\Services::validation(),
            'posts' => $this->PostModel->getPosts($slug)
        ];

        return view("posts/edit", $data);
    }

    public function update($slug)
    {
        $postLama = $this->PostModel->getPosts($this->request->getVar('slug'));
        if ($postLama['slug'] == $this->request->getVar('slug')) {
            $rule_slug = 'required';
        } else {
            $rule_slug = 'required|is_unique[posts.slug]';
        }

        $valid = $this->validate([
            "post_title" => [
                "label" => "Judul",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
            "slug" => [
                "label" => "Slug",
                "rules" => $rule_slug,
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                    "is_unique" => "{field} sudah ada!",
                ]
            ],
            "post_category" => [
                "label" => "Kategori",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
            "post_author" => [
                "label" => "Author",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
            "post_description" => [
                "label" => "Deskripsi",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
        ]);

        if ($valid) {
            $PostModel = model("PostModel");
            $data = $this->request->getPost();
            $PostModel->update($slug, $data);
            session()->setFlashdata('message', 'Post Has Been Updated');
            session()->setFlashdata('alert-class', 'alert-success');
            return redirect()->to(base_url('/admin/posts/'));
        } else {
            return redirect()->to(base_url('admin/posts/edit/' . $this->request->getVar('slug')))->withInput()->with('validation', $this->validator);
        }
    }
}
