<?php

namespace mix8872\useradmin\controllers;

use mix8872\useradmin\models\User;
use mix8872\useradmin\models\searchs\User as UserSearch;
use mix8872\useradmin\components\rbac\models\Role;
use mix8872\useradmin\components\rbac\models\AuthItem;
use mix8872\useradmin\helpers\Translit;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    const PAGE_SIZE = 25;
    public $userClassName;
    public $usernameField = 'username';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-role' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->userClassName === null) {
            $this->userClassName = \mix8872\useradmin\models\User::class;
        }
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;

        $roles = $auth->getRoles();

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'roles' => $this->_findArrayData($roles)
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $user = new User(['scenario' => 'create']);
        $role = new Role();

        if ($user->load(Yii::$app->request->post()) && $user->validate()) {
            $user->setPassword($user->password);
            $user->generateAuthKey();
            if ($user->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('user-admin', "Пользователь $user->username успешно добавлен"));
                return $this->redirect(['update', 'id' => $user->id]);
            } else {
                error_log(print_r($user->getErrorSummary(1), 1));
                Yii::$app->getSession()->setFlash('error', Yii::t('user-admin', "Ошибка при добавлении пользователя $user->username"));
            }
        }
        return $this->render('create', [
            'user' => $user,
            'role' => $role,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param  integer $id The user id.
     * @return string|\yii\web\Response
     *
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        // get role
        $role = Role::findOne(['user_id' => $id]);

        // get user details
        $user = $this->findModel($id);

        if (!Yii::$app->user->can('admin')) {
            if ($role->item_name === 'admin') {
                return $this->goHome();
            }
        }

        // load user data with role and validate them
        if ($user->load(Yii::$app->request->post()) && $user->validate()) {
            // only if user entered new password we want to hash and save it
            if ($user->password) {
                $user->setPassword($user->password);
            }

            if ($user->hasAttribute('img')) {
                $this->_saveAvatar($user);
            }

            // if admin is activating user manually we want to remove account activation token
            if ($user->status == User::STATUS_ACTIVE && ($user->hasAttribute('account_activation_token') && $user->account_activation_token != null)) {
                $user->removeAccountActivationToken();
            }
            if ($user->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('user-admin', "Данные пользователя $user->username успешно обновлены"));
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('user-admin', "При обновления пользователя $user->username возникла ошибка"));
                error_log(print_r($user->getErrorSummary(1), 1));
            }
        }
        return $this->render('update', [
            'user' => $user,
            'role' => $role,
            'usernameField' => $this->usernameField,
        ]);
    }

    /**
     * Deletes an existing User model.
     *
     * @param  integer $id The user id.
     * @return \yii\web\Response
     *
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $user = $this->findModel($id);

        if ($user->delete()) {
            // delete this user's role from auth_assignment table
            if ($roles = Role::find()->where(['user_id' => $id])->all()) {
                foreach ($roles as $role) {
                    $role->delete();
                }
            }

            Yii::$app->getSession()->setFlash('success', Yii::t('user-admin', "Пользователь $user->username удален"));
        }

        return $this->redirect(['index']);
    }

    /**
     * Assign or revoke assignment to user
     *
     * @return mixed
     */
    public function actionAssign()
    {
        $post = Yii::$app->request->post();
        $id = $post['id'];
        $action = $post['action'];
        $roles = $post['roles'];
        $manager = Yii::$app->authManager;
        $error = [];
        if ($action == 'assign') {
            foreach ($roles as $name) {
                try {
                    $item = $manager->getRole($name);
                    $item = $item ?: $manager->getPermission($name);
                    $manager->assign($item, $id);
                } catch (\Exception $exc) {
                    $error[] = $exc->getMessage();
                }
            }
        } else {
            foreach ($roles as $name) {
                try {
                    $item = $manager->getRole($name);
                    $item = $item ?: $manager->getPermission($name);
                    $manager->revoke($item, $id);
                } catch (\Exception $exc) {
                    $error[] = $exc->getMessage();
                }
            }
        }
        Yii::$app->cache->flush('rbac');
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'type' => 'S',
            'errors' => $error,
        ];
    }

    /**
     * Search roles of user
     * @param  integer $id
     * @param  string $target
     * @param  string $term
     * @return array
     */
    public function actionRoleSearch($id, $target, $term = '')
    {
        Yii::$app->response->format = 'json';
        $authManager = Yii::$app->authManager;
        $roles = $authManager->getRoles();
        $permissions = $authManager->getPermissions();

        $avaliable = [];
        $assigned = [];
        foreach ($authManager->getAssignments($id) as $assigment) {
            if (isset($roles[$assigment->roleName])) {
                if (empty($term) || strpos($assigment->roleName, $term) !== false) {
                    $assigned['Roles'][$assigment->roleName] = $assigment->roleName;
                }
                unset($roles[$assigment->roleName]);
            } elseif (isset($permissions[$assigment->roleName]) && $assigment->roleName[0] != '/') {
                if (empty($term) || strpos($assigment->roleName, $term) !== false) {
                    $assigned['Permissions'][$assigment->roleName] = $assigment->roleName;
                }
                unset($permissions[$assigment->roleName]);
            }
        }

        if ($target == 'avaliable') {
            if (count($roles)) {
                foreach ($roles as $role) {
                    if (empty($term) || strpos($role->name, $term) !== false) {
                        $avaliable['Roles'][$role->name] = $role->name;
                    }
                }
            }
            if (count($permissions)) {
                foreach ($permissions as $role) {
                    if ($role->name[0] != '/' && (empty($term) || strpos($role->name, $term) !== false)) {
                        $avaliable['Permissions'][$role->name] = $role->name;
                    }
                }
            }
            return $avaliable;
        } else {
            return $assigned;
        }
    }

//-------------------------------------------

    /**
     * Returns new ArrayData provider based on input array
     * @param $array
     * @return ArrayDataProvider
     */
    private function _findArrayData($array)
    {
        return new ArrayDataProvider([
            'allModels' => $array,
            'sort' => false,
            'pagination' => new Pagination([
                'pageSize' => self::PAGE_SIZE,
                'forcePageParam' => false,
                'pageSizeParam' => false
            ])
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param  integer $id The user id.
     * @return User The loaded model.
     *
     * @throws NotFoundHttpException
     */
    private function findModel($id)
    {
        $class = $this->userClassName;
        if (($model = $class::findIdentity($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Save user avatar to host and write path to file in model
     * @param $user
     */
    private function _saveAvatar(&$user)
    {
        $file = UploadedFile::getInstanceByName('user-img');

        if ($file) {
            $module = Yii::$app->getModule('user-admin');
            $path = Yii::getAlias('@webroot' . $module->parameters['avatarSavePath']);
            $urlPath = Yii::getAlias('@web' . $module->parameters['avatarSavePath']);

            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            if ($user->img) {
                $split = explode('/', $user->img);
                $oldFileName = array_pop($split);
                if (is_file($path . $oldFileName)) {
                    unlink($path . $oldFileName);
                }
            }

            $baseFileName = Translit::t($file->name);
            $fileName = $baseFileName . '.' . $file->extension;
            $i = 1;
            while (is_file($path . $fileName)) {
                $fileName = $baseFileName . $i . '.' . $file->extension;
                $i++;
            }
            $file->saveAs($path . $fileName);
            $user->img = $urlPath . $fileName;
        }
    }
}
