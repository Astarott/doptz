<?php

namespace frontend\controllers;

use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\Photo;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use Yii;
use common\models\User;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * AuthController implements the CRUD actions for User model.
 */
class AuthController extends Controller
{

    public function actionSetImage()
    {
        $model = new Photo;

        if ($model->load(Yii::$app->request->post()))
        {
            $user = $this->findModel(yii::$app->user->id);
            $file = UploadedFile::getInstance($model,'path');

          //  vardump($model->uploadFile($file));die;

            if ($user->saveImage($model->uploadFile($file,$user->avatar)))
            {
                return $this->redirect(['view', 'id'=>$user->id]);
            }
        }
        return $this->render('image',['model'=>$model]);
    }

    //Личный кабинет
    public function actionView()
    {
        return $this->render('view', [
            'model' => $this->findModel(yii::$app->user->id),
        ]);
    }

    public function actionUpdate()
    {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        //vardump($ds);die;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            vardump($model->validate());die;
            $request = Yii::$app->request->post('User');
            $model->username = $request['username'];
            $model->city = $request['city'];
            $model->about = $request['about'];
            $model->phone = $request['phone'];
            $model->save();
              //Вручную лезем в БД и изменяем поля.
//            Yii::$app->db->createCommand()->update('user', ['username' => $request['username']], 'id =:id',array(':id' =>$id))->execute();
//            Yii::$app->db->createCommand()->update('user', ['city' => $request['city']], 'id =:id',array(':id' =>$id))->execute();
//            Yii::$app->db->createCommand()->update('user', ['phone' => $request['phone']], 'id =:id',array(':id' =>$id))->execute();
//            Yii::$app->db->createCommand()->update('user', ['about' => $request['about']], 'id =:id',array(':id' =>$id))->execute();
            return $this->redirect('view');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    //Авторизация
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            // return $this->redirect(['view','id' =>$model->get_current_user()];
            return $this->redirect(['view', 'id' => yii::$app->user->id]);
            // return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    //Регистрация
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup())
        {
            //Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->redirect(['view', 'id' => yii::$app->user->id]);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
    /**
     * Finds the Declaration model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
function vardump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
};