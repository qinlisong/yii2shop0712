<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/18
 * Time: 17:57
 */

namespace frontend\widgets;


use backend\models\GoodsCategory;
use yii\base\Widget;
use yii\helpers\Html;

class GoodsCateWidgets extends Widget
{
    public function run()
    {
        //得到所有一级分类
        $cates=GoodsCategory::find()->where(['parent_id'=>0])->all();
        //循环取出
        $html="";
        foreach ($cates as $k1 => $v1){
            $html.='<div class="cat '.($k1 == 0? "item1":"").'">';
            $html.=' <h3> '.Html::a($v1->name,['index/list','id'=>$v1->id]).'<b></b></h3>';
            $html.=' <div class="cat_detail">';

            //循环出二级分类
            foreach ($v1->children as $k2 => $v2){
             $html.=' <dl class="dl_1st">';
             $html.='<h3>'.Html::a($v2->name,['index/list','id'=>$v2->id]).' <b></b></h3>';
             $html.='<dd>';
             foreach ($v2->children as $k3=>$v3){
                 $html .= Html::a($v3->name, ['index/list', 'id' => $v3->id]);
             }
                $html .= '</dd></dl>';
            }
            $html .= '</div></div>';
        }

    return <<<EOF
       <div class="category fl"> <!-- 非首页，需要添加cat1类 -->
           <div class="cat_bd">
           
           {$html}
            </div>
      </div>
EOF;

}
}