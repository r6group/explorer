<?php
namespace phi\controllers;


class ReportMenuController extends \yii\web\Controller {
    public function actionIndex()
    {
        return $this->render('index');
    }
}