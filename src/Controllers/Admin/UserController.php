<?php

namespace Dangson\XuongOop\Controllers\Admin;

use Dangson\XuongOop\Commons\Controller;
use Dangson\XuongOop\Commons\Helper;
use Dangson\XuongOop\Models\User;
use Exception;
use Rakit\Validation\Validator;

class UserController extends Controller
{

    private User $user;
    public function __construct()
    {
        $this->user = new User();
    }
    public function index()
    {
        [$users, $totalPage] = $this->user->paginate($_GET['page'] ?? 1);

        $this->renderViewAdmin('users.index', [
            'users' => $users,
            'totalPage' => $totalPage,
            'page' => $_GET['page'] ?? 1,
        ]);
    }

    public function create()
    {
        $this->renderViewAdmin('users.create', ['']);
    }

    public function store()
    {
        $validator = new Validator;
        $validation = $validator->make($_POST + $_FILES, [
            'name'                  => 'required|max:50',
            'email'                 => 'required|email',
            'password'              => 'required|min:6',
            'confirm_password'      => 'required|same:password',
            'avatar'                => 'uploaded_file:0,2M,png,jpg,jpeg',
            'type'                  => 'required|in:admin,member',
        ]);


        $validation->validate();

        if ($validation->fails()) {
            $_SESSION['errors'] = $validation->errors()->firstOfAll();

            header("Location: " . url('admin/users/create'));
        } else {
            $data = [
                'name'                  => $_POST['name'],
                'email'                 => $_POST['email'],
                'type'                  => $_POST['type'],
                'password'              => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ];

            if (isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {

                $from = $_FILES['avatar']['tmp_name'];
                $to = 'assets/uploads/' . time() . $_FILES['avatar']['name'];

                if (move_uploaded_file($from, PATH_ROOT . $to)) {
                    $data['avatar'] = $to;
                } else {
                    $_SESSION['errors']['avatar'] = "Upload không thành công";

                    header('location: ' . url('admin/users/create'));
                    exit;
                }
            }

            $this->user->insert($data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công';

            header('Location: ' . url('admin/users'));
        }
    }

    public function show($id)
    {
        $user = $this->user->findByID($id);

        $this->renderViewAdmin('users.show', [
            'user' => $user
        ]);
    }

    public function edit($id)
    {
        try {
            $user = $this->user->findByID($id);

            if (empty($user)) {
                throw new Exception('Model not found');
            }
            $this->renderViewAdmin('users.edit', [
                'user' => $user
            ]);
        } catch (\Throwable $e) {
            echo '404 - NOT FOUND';
            die();
        }
    }

    public function update($id)
    {
        $user = $this->user->findByID($id);

        $validator = new Validator;
        $validation = $validator->make($_POST + $_FILES, [
            'name'                  => 'required|max:50',
            'email'                 => 'required|email',
            'password'              => 'min:6',
            'avatar'                => 'uploaded_file:0,2M,png,jpg,jpeg',
            'type'                  => 'required|in:admin,member',
        ]);

       

        $validation->validate();

        if ($validation->fails()) {
            $_SESSION['errors'] = $validation->errors()->firstOfAll();

            header("Location: " . url("admin/users/{$user['id']}/edit"));
        } else {
            $data = [
                'name'                  => $_POST['name'],
                'email'                 => $_POST['email'],
                'type'                  => $_POST['type'],
                'password'              => !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'],
                'updated_at'            => date('Y-m-d H:i:s'),
            ];

            $flagUpload = false;
            if (isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {

                $flagUpload = true;

                $from = $_FILES['avatar']['tmp_name'];
                $to = 'assets/uploads/' . time() . $_FILES['avatar']['name'];

                if (move_uploaded_file($from, PATH_ROOT . $to)) {
                    $data['avatar'] = $to;
                } else {
                    $_SESSION['errors']['avatar'] = "Upload không thành công";

                    header('location: ' . url("admin/users/{$user['id']}/edit"));
                    exit;
                }
            }

            $this->user->update($id, $data);

            if (
                $user['avatar']
                && $flagUpload
                && file_exists(PATH_ROOT . $user['avatar'])
            ) {
                unlink(PATH_ROOT . $user['avatar']);
            }

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công';

            header('Location: ' . url("admin/users/{$user['id']}/edit"));
        }
    }

    public function delete($id)
    {
        $user = $this->user->findByID($id);

        $this->user->delete($id);

        if (
            $user['avatar']
            && file_exists(PATH_ROOT . $user['avatar'])
        ) {
            unlink(PATH_ROOT . $user['avatar']);
        }

        header('Location: ' . url('admin/users'));
        exit();
    }
    public function logout()
    {
        unset($_SESSION['user']);

        header('Location: ' . url());
        exit;
    }
}
