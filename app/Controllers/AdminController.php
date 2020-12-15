<?php
/**
 * Created by PhpStorm.
 * User: ermolaev
 * Date: 10.12.2020
 * Time: 14:20
 */

namespace App\Controllers;

use App\Models\User;

class AdminController extends Controller{

    public function index($request,$response){
        return $this->view->render($response,'admin.index.twig');
    }

    public function get_user($request, $response){
        return $this->view->render($response,'admin.users.twig');
    }

    public function get_sessions($request, $response){
        return $this->view->render($response,'admin.sessions.twig');
    }

    public function getUserSession($request,$response){
        $users = User::all();

        $users_count = User::count();

        $data = array();

       foreach ($users as $user)
        {
            $sub_array = array();
            $sub_array[] = '<div class="update" data-id="'.$user->id.'" data-column="username">' . $user->username . '</div>';
            $sub_array[] = '<div class="update" data-id="'.$user->id.'" data-column="role">' . $user->role . '</div>';
            $sub_array[] = '<div class="update" data-id="'.$user->id.'" data-column="session">' . $user->getStatus() .'</div>';
            if($user->session != null) {
                $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $user->id . '">Drop Session</button>';
            }else{
                $sub_array[] = '<button type="button" disabled="true" name="delete" class="btn btn-danger btn-xs delete" id="' . $user->id . '">Drop Session</button>';
            }
            $data[] = $sub_array;
        }

        $output = array(
            "draw"    => 1,
            "recordsTotal"  =>  $users,
            "recordsFiltered" => $users_count,
            "data"    => $data
        );

        return $response->withJson($output);
    }

    public function getUsers($request,$response){
        $users = User::all();

        $users_count = User::count();

        $data = array();

        foreach ($users as $user)
        {
            $sub_array = array();
            $sub_array[] = '<div class="update" data-id="'.$user->id.'" data-column="username">' . $user->username . '</div>';
            $sub_array[] = '<div class="update" data-id="'.$user->id.'" data-column="role">' . $user->role . '</div>';
            $sub_array[] = '<div class="update" data-id="'.$user->id.'" data-column="email">' . $user->email . '</div>';
            $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$user->id.'">Delete User</button>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"    => 1,
            "recordsTotal"  =>  $users,
            "recordsFiltered" => $users_count,
            "data"    => $data
        );

        return $response->withJson($output);
    }

    public function unsetUser($request,$response){
        $user_id = $request->getParam('user_id');
        $user = User::where('id',$user_id)->first();
        session_id($user->session);
        $userDB = User::where('id',$user_id)->update(['session'=> Null]);
        session_start();
        session_destroy();
        session_commit();
    }

    public function deleteUser($request,$response){
        $user_id = $request->getParam('user_id');
        $user = User::where('id',$user_id)->delete();
    }
}