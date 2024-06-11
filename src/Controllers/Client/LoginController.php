<?php

namespace Dangson\XuongOop\Controllers\Client;

use Dangson\XuongOop\Commons\Controller;
use Dangson\XuongOop\Commons\Helper;
use Dangson\XuongOop\Models\User;
use Rakit\Validation\Validator;

class LoginController extends Controller
{
    private User $user;
    public function __construct()
    {
        $this->user = new User();
    }

    public function showFormLogin()
    {
        avoid_login();

        $this->renderViewClient('members.login');
    }

    public function login()
    {
        avoid_login();

        try {

            //code...
            $user = $this->user->findByEmail($_POST['email']);

            if (empty($user)) {
                throw new \Exception("Email : " . $_POST['email'] . " chưa được đăng kí!");
            }
            $check = $user['type'];
            // Helper::debug($check);
            $flag = password_verify($_POST['password'], $user['password']);
            if ($flag && $check == 'admin') {
                $_SESSION['user'] = $user;

                // unset($_SESSION('cart'));
                header('Location: ' . url('admin/'));
                $_SESSION['user']['type'] = 'admin';
                unset($_SESSION['cart']);
                exit();
            } else if ($flag && $check == 'member') {
                $_SESSION['user'] = $user;
                $_SESSION['user']['type'] = 'member';
                // unset($_SESSION('cart'));

                header('Location: ' . url(''));
                unset($_SESSION['cart']);
                exit();
            }

            throw new \Exception("Mật khẩu bạn nhập đã sai ");
        } catch (\Throwable $th) {
            //throw $th;
            // Helper::debug($th->getMessage());
            $_SESSION['error'] = $th->getMessage();
            // Helper::debug($_SESSION['error']);
            header('Location: ' . url('auth/login'));
            exit();
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);

        header('Location: ' . url());
        exit;
    }

    public function showFormRegister()
    {
        avoid_register();
        $this->renderViewClient('members.register');
    }

    public function register()
    {
        avoid_register();

        $validator = new Validator;
        $validation = $validator->make($_POST + $_FILES, [
            'name'                  => 'required|max:50',
            'email'                 => 'required|email',
            'password'              => 'required|min:6',
            'confirm_password'      => 'required|same:password',
            'avatar'                => 'uploaded_file:0,2M,png,jpg,jpeg',
        ]);
        $validation->validate();

        if ($validation->fails()) {
            $_SESSION['errors'] = $validation->errors()->firstOfAll();

            header('Location: ' . url('auth/register'));
            exit;
        } else {
            $data = [
                'name'      => $_POST['name'],
                'email'     => $_POST['email'],
                'password'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ];

            if (isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {

                $from = $_FILES['avatar']['tmp_name'];
                $to = 'assets/uploads/' . time() . $_FILES['avatar']['name'];

                if (move_uploaded_file($from, PATH_ROOT . $to)) {
                    $data['avatar'] = $to;
                } else {
                    $_SESSION['errors']['avatar'] = 'Upload Không thành công';

                    header('Location: ' . url('auth/login'));
                    exit;
                }
            }

            $this->user->insert($data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công';

            header('Location: ' . url(''));
            exit;
        }
    }
}
