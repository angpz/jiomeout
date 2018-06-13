<?php

use yii\web\JsExpression;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
?>
	<?php Modal::begin([
            'id'     => 'eventModal',
            'size'   => 'modal-lg',
            'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
    ]);
    
    Modal::end() ?>

<!-- $JSEventClick = <<<EOF
function(calEvent, jsEvent, view) {
	console.log(calEvent);
  	$('.modal-header').html('<h2>'+calEvent.title+'</h2>');
    $('.modal-body').html(moment(calEvent.start).format('MMM Do h:mm A')+'-'+moment(calEvent.end).format('MMM Do h:mm A')+'<br>'+calEvent.nonstandard);
    $('#eventModal').modal();
}
EOF; -->


<div class="container">
	<div style="padding:0 100px;">
		<?= \yii2fullcalendar\yii2fullcalendar::widget(array(
				'options'=>[
					
				],
				'clientOptions' => [
				    'header' => [
				        'left'=>'prev,next today',
				        'center'=>'prevYear,nextYear title',
				        'right'=>'month,agendaWeek,agendaDay',
				    ],
				    'selectable' => true,
				    'themeSystem'=>'bootstrap4',
				],
				'eventRender' => 'function (event,element) {
							        // element.attr("href", "event-content?id="+event.id);
									element.attr("href", "?r=event/event-content&id="+event.id);
							        element.attr("data-toggle","modal");
							        element.attr("data-target","#eventModal");
							        element.attr("data-title",event.title);
							    }',
			    
			  ));
	  	?>
  	</div>
</div>