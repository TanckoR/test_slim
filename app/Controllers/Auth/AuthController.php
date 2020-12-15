<?php
/**
 * Created by PhpStorm.
 * User: ermolaev
 * Date: 10.12.2020
 * Time: 14:03
 */

namespace App\Controllers\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//From PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use App\Models\User;
use App\Controllers\Controller;


use Respect\Validation\Validator as v;

class AuthController extends Controller
{
        public function getSignOut($request,$response){
            $this->auth->logout();

            return $response->withRedirect($this->router->pathFor('home'));
        }

        public function getSignUp($request,$response){

            return $this->view->render($response,'auth/signup.twig');
        }

        public function postSignUp($request,$response){

            $validation = $this->validator->validate($request, [
                'email'=>v::noWhitespace()->notEmpty()->email(),
                'name'=>v::notEmpty()->alpha(),
                'password'=>v::noWhitespace()->notEmpty(),
                ]);


            if($validation->failed()){
                return $response->withRedirect($this->router->pathFor('auth.signup'));
            }

            $user = User::create([
                'email' => $request->getParam('email'),
                'username' => $request->getParam('name'),
                'password' => password_hash($request->getParam('password'),PASSWORD_DEFAULT),
                'role' => 'user'
            ]);

            $this->auth->attmpt($user->email,$request->getParam('password'));

            return $response->withRedirect($this->router->pathFor('home'));
      }

        public function getSignIn($request,$response){
           return $this->view->render($response,'auth/signin.twig');
        }

        public function postSignIn($request,$response){
            $auth = $this->auth->attmpt(
                $request->getParam('email'),
                $request->getParam('password')
            );

            if(!$auth){
                return $response->withRedirect($this->router->pathFor('auth.signin'));
            }

            return $response->withRedirect($this->router->pathFor('home'));
        }

        public function getUpdatePass($request,$response){
            return $this->view->render($response,'auth/update_pass.twig');
        }

        public function postUpdatePass($request,$response){
            $email = $request->getParam('email');
            $password = $request->getParam('pass');

            //check user by email
            $user = User::where('email',$email)->first();
            //generate hash and add in db
            $hash = $this->generatePassword();

            $user = User::where('email',$email)->update(['update_hash'=>$hash]);

            //send hash to email
            $this->sendVerificationEmail($email);
        }


        public function generatePassword($length = 8) {
            $chars = 'abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            $count = mb_strlen($chars);

            for ($i = 0, $result = ''; $i < $length; $i++) {
                $index = rand(0, $count - 1);
                $result .= mb_substr($chars, $index, 1);
            }

            return $result;
        }

        public function sendVerificationEmail($email)
        {
            $user = User::where('email',$email)->first();

            try{
            $mail = new PHPMailer;
            $mail->CharSet = 'utf-8';
                $mail->IsSMTP();
                $mail->Host       = 'smtp.yandex.ru';
                $mail->SMTPAuth   = true;
                $mail->Port       = 25;
                $mail->Username   = "vald.ermolaev95@yandex.ru";
                $mail->Password   = "yerm0l2iev";
                $mail->Mailer   = "smtp";
//            $mail->Host="smtp.mail.ru";
//            $mail->SMTPAuth=true;
//            $mail->Username="test_user_for_zags@inbox.ru";//логин от почты с которой будет отправляться письмо
//            $mail->Password="yerm0l2iev";//пароль от почты с которой будет оправлено письмо
//            $mail->SMTPSecure="ssl";
//            $mail->Port=465;

            $mail->setFrom('vald.ermolaev95@yandex.ru','Test');//от кого будет уходить письмо
            $mail->addAddress($email);//кому будет отправлено письмо
            $mail->isHTML(true);

            $mail->Subject = 'Обновление пароля на стайте';
            $mail->Body = 'Ключ подтверждения для изменения пароля: '.$user->update_hash.'';
//            $mail->AltBody = '345';

            if($mail->send())
            {
                return true;
            }
            }catch (Exception $e){
                echo 'Произошла ошибка при отправке почты';
                var_dump($e);
            }

        }

        public function postCheckCode($request,$response){
            $code = $request->getParam('code');
            $email = $request->getParam('email');

            $user = User::where('email',$email)->first();

            if(!$user){
                return $response->withRedirect($this->router->pathFor('auth.user.forget'));
            }

            if(!$request->getParam('password')){
                return $response->withRedirect($this->router->pathFor('auth.user.forget'));
            }

            if(!$code){
                return $response->withRedirect($this->router->pathFor('auth.user.forget'));
            }
            User::where('id',$user->id)->update(['update_hash'=>Null]);
            if($user->update_hash == $code){

                User::where('id',$user->id)->update(['password'=>password_hash($request->getParam('password'),PASSWORD_DEFAULT)]);

                return $response->withRedirect($this->router->pathFor('auth.user.update.success'));
            }

            return $response->withRedirect($this->router->pathFor('auth.user.forget'));
        }

        public function getSuccess($request,$response){
          return $this->view->render($response,'auth/success.twig');
        }



}