<?php

namespace restapi\modules\v1\controllers;

use yii;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use restapi\modules\v1\models\Product;
use restapi\modules\v1\models\Category;

class ProductsController extends ActiveController {

    /**
     * @inheritdoc
     */
    public function init() {}

    /**
     * @inheritdoc
     */
    public function actions() {}

    public function actionIndex($parent_ctl, $parent_id) {
        if ($parent_ctl !== 'businesses') {
            throw new NotFoundHttpException();
        }

        $categorys = Category::find()->where(['business_id' => $parent_id])->asArray()->all();
        if ($categorys === null) {
            $categorys = [];
        } else {
            foreach ($categorys as &$category) {
                $products = Product::findAll(['category_id' => $category['id']]);
                if ($products === null) {
                    $products = array();
                }
                $category['products'] = $products;
            }
        }

        return $categorys;
    }
}