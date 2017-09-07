<?php
use yii\helpers\Html;
use yii\grid\GridView;
use frontend\widgets\EPjax;
use frontend\assets\SearchPageAsset;
use yii\base\Widget;
use frontend\widgets\QuickSearch;
use yii\widgets\Pjax;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cars';
$this->params ['breadcrumbs'] [] = $this->title;
SearchPageAsset::register ( $this );
$this->title = 'Carbnb2';
?>
<?php

?>
<main class="search-page content">
<div class="container">
	<h1 class="page-title">We Found Cars at</h1>
		<?php echo QuickSearch::widget();?>
		<div class="row">
			<aside class="col-md-3 border-right">
					<?php echo $this->render('_search', ['allMakes'=>$allMakes,'stats'=>$stats,'model' => $searchModel]); ?>
			</aside>
			<?php EPjax::begin(['options'=>['tag'=>'section','class'=>'col-md-9'],'formSelector'=>'#car-search-form']); ?>
				
					<div class="search-header clearfix">
						<div class="pull-left"><?=$dataProvider->totalCount?> Results</div>
						<div data-layout-switcher="" class="pull-right layout-switcher">
							<a href="javascript:;" class="active" data-layout="thumb"><i
								class="fa fa-th-large"></i></a> <a href="javascript:;"
								data-layout="list" class=""><i class="fa fa-th-list"></i></a>
						</div>
					</div>
				
						<?php echo ListView::widget([
							'dataProvider' => $dataProvider,
							'itemView' => '_item',
							'itemOptions'=>[
								'data-thumb-class'=>'col-md-6',
								'data-list-class'=>'col-md-12',
								'class'=>'col-md-6'
							],
							'summary'=>'',
							'options'=>['class'=>'search-list view-grid','data-thumb-class'=>'view-grid','data-list-class'=>'view-list'],
							'layout'=>'<div class="row">{items}</div><div class="text-center">{pager}</div>'
						]);?>
			<?php EPjax::end(); ?>
		</div>
</div>
</main>