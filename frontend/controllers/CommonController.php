<?php 
namespace frontend\controllers;

use Yii;
use yii\web\Cookie;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

class CommonController extends Controller
{
    //public $enableCsrfValidation = false;
    /*public function beforeAction($action)
    {
        
        if (!parent::beforeAction($action)) {

             return false;
        }
        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        $permissionName = $controller.'/'.$action; 
        
        if(!Yii::$app->user->isGuest)
        {
            if(Yii::$app->user->identity->status == 1 || Yii::$app->user->identity->status == 2)
            {
               

                if($permissionName == 'site/logout')
                {
                    return true;
                }
                    
                $this->redirect(['/site/validation']);
                return false;
            }
        }
       
        return true;
    }*/

    public function init()
    {
        $number ="";
    }

    public static function menuItems()
    {   /*['label' => 'Home', 'url' =>  '#','options'=>['class'=>'scroll-top']],
        ['label' => 'About us', 'url' =>  '#','options'=>['class'=>'scroll-link','data-id'=>'about']],
        ['label' => 'Portfolio', 'url' =>  '#','options'=>['class'=>'scroll-link','data-id'=>'portfolio']],
        ['label' => 'Blog', 'url' =>  '#','options'=>['class'=>'scroll-link','data-id'=>'blog']],
        ['label' => 'Contact Us', 'url' =>  '#','options'=>['class'=>'scroll-link','data-id'=>'contact-us']],*/
        $menuItems = array();

        if (!Yii::$app->user->isGuest) {
            $add_on = self::userNav();
        }
        else{
            $add_on = self::guestNav();
        }

        foreach ($add_on as $k => $value) {
            $menuItems[] = $value;
        }

        return $menuItems;
    }

    public static function guestNav()
    {
        $menuItems = array();
        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        $page = $controller.'/'.$action;

        if ($page == 'site/index') {
            $menuItems[] = ['label' => 'Main', 'url' =>  '#','options'=>['class'=>'scroll-top']];
            $menuItems[] = ['label' => 'About us', 'url' =>  '#','options'=>['class'=>'scroll-link','data-id'=>'about']];
            $menuItems[] = ['label' => 'Blog', 'url' =>  '#','options'=>['class'=>'scroll-link','data-id'=>'blog']];
        }
        
        $menuItems[] = ['label' => 'Sign In', 'url' =>  Url::to(['/site/login'])];
        return $menuItems;
    }

    public static function userNav()
    {
        $menuItems = array();
        $menuItems[] = ['label' => 'Calendar', 'url' => '#'];
        $menuItems[] = ['label' => 'Events', 'url' => '#'];
        $menuItems[] = ['label' => 'Friends', 'url' => Url::to(['/user/friends'])];
        $menuItems[] = ['label' => 'Setting', 'url' => '#'];
        $menuItems[] = ['label' => 'Sign Out', 'url' => Url::to(['/site/logout'])];
        return $menuItems;
    }
}