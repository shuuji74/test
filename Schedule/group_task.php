<?php
require_once('bdd.php');

$sql = "SELECT * FROM groups g INNER JOIN group_affi a ON g.group_id = a.group_id WHERE member_id = '". $_COOKIE['id'] ."'";
$g = $bdd->prepare($sql);
$g->execute();

$group = $g->fetchAll();


$sql = "SELECT task_g_id AS id, task_name AS title, task_start AS start, task_finish AS end, color, task_priority FROM group_task WHERE member_id = '". $_COOKIE['id'] ."'";

$taskg = $bdd->prepare($sql);
$taskg->execute();
$events = $taskg->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>スケジュール</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	<!-- FullCalendar -->
	<link href='css/fullcalendar.css' rel='stylesheet' />

    <!-- Custom CSS -->
	<link href='css/index.css' rel='stylesheet' />

    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
	#calendar {
		max-width: 800px;
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>スケジュール作成</h1>
                <!-- <p class="lead">Complete with pre-defined file paths that you won't have to change!</p> -->
                <div id="calendar" class="col-centered">
                </div>
            </div>
			
        </div>
        <!-- /.row -->
		
		<!-- Modal -->
		<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="addEvent.php">
				<input type="hidden" name="tsak_id" value="group_task">

			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">イベントを追加</h4>
			  </div>
			  <div class="modal-body">
				
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">タイトル</label>
					<div class="col-sm-10">
					  <input type="text" name="title" class="form-control" id="title" placeholder="タイトルを入力" required>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="color" class="col-sm-2 control-label">バーの色</label>
					<div class="col-sm-10">
					  <select name="color" class="form-control" id="color">
						  <option value="">色を選択してください</option>
						  <option style="color:#0071c5;" value="#0071c5">&#9724; 青色</option>
						  <option style="color:#40E0D0;" value="#40E0D0">&#9724; 水色</option>
						  <option style="color:#008000;" value="#008000">&#9724; 緑色</option>						  
						  <option style="color:#FFD700;" value="#FFD700">&#9724; 黄色</option>
						  <option style="color:#FF8C00;" value="#FF8C00">&#9724; 橙色</option>
						  <option style="color:#FF0000;" value="#FF0000">&#9724; 赤色</option>
						  <option style="color:#000;" value="#000">&#9724; 黒色</option>
						  
						</select>
					</div>	
				  </div>

				  <div class="form-group">
					<label for="task" class="col-sm-2 control-label">タスクの種類</label>
					<div class="col-sm-10">
					  <select name="task" class="form-control" id="task">
						<optgroup label="グループタスク">
						<?php foreach ($group as $key => $value) :?>
							<option value="<?php echo $group[$key]["group_id"]; ?>,g"><?php echo $group[$key]["group_name"]; ?></option>
						<?php endforeach; ?>
						</optgroup>
						</select>
					</div>
				  </div>

				  <!-- <div class="form-group">
					<label for="task" class="col-sm-2 control-label">Type</label>
					<div class="col-sm-10">
					  <select name="task" class="form-control" id="task">
					 	  <option value="c">Class Task</option>
  						  <option value="g">Group Task</option>
  						  <option value="s" selected>Solo Task</option>
						</select>
					</div>
				  </div> -->

				  <div class="form-group">
					<label for="task_priority" class="col-sm-2 control-label">優先度</label>
					<div class="col-sm-10">
					  <select name="task_priority" class="form-control" id="task_priority">
					  	<option value="1">高</option>
  						<option value="2" selected>中</option>
 						<option value="3">低</option>
					  </select>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">開始日</label>
					<div class="col-sm-10">
					  <input type="text" name="start" class="form-control" id="start" >
					</div>
				  </div>
				  <div class="form-group">
					<label for="end" class="col-sm-2 control-label">終了日</label>
					<div class="col-sm-10">
					  <input type="text" name="end" class="form-control" id="end" >
					</div>
				  </div>
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
				<button type="submit" class="btn btn-primary">保存</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>
		
		
		<!-- タスク変更用 -->
		<!-- Modal -->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="editEventTitle.php">
				<input type="hidden" name="tsak_id" value="group_task">

			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">内容を変更</h4>
			  </div>
			  <div class="modal-body">
				
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">タイトル</label>
					<div class="col-sm-10">
					  <input type="text" name="title" class="form-control" id="title" placeholder="Title" required>
					</div>
				  </div>
				  <div class="form-group">
					<label for="color" class="col-sm-2 control-label">バーの色</label>
					<div class="col-sm-10">
					  <select name="color" class="form-control" id="color">
						  <option value="">Choose</option>
						  <option style="color:#0071c5;" value="#0071c5">&#9724; 青</option>
						  <option style="color:#40E0D0;" value="#40E0D0">&#9724; 水色</option>
						  <option style="color:#008000;" value="#008000">&#9724; 緑</option>						  
						  <option style="color:#FFD700;" value="#FFD700">&#9724; 黄色</option>
						  <option style="color:#FF8C00;" value="#FF8C00">&#9724; オレンジ</option>
						  <option style="color:#FF0000;" value="#FF0000">&#9724; 赤</option>
						  <option style="color:#000;" value="#000">&#9724; 黒</option>
						</select>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="task_priority" class="col-sm-2 control-label">優先度</label>
					<div class="col-sm-10">
					  <select name="task_priority" class="form-control" id="task_priority">
					  	<option value="1">高</option>
  						<option value="2">中</option>
 						<option value="3">低</option>
					  </select>
					</div>
				  </div>
				  
				    <div class="form-group"> 
						<div class="col-sm-offset-2 col-sm-10">
						  <div class="checkbox">
							<label class="text-danger"><input type="checkbox"  name="delete">スケジュールを削除</label>
						  </div>
						</div>
					</div>
				  
				  <input type="hidden" name="id" class="form-control" id="id">
				
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
				<button type="submit" class="btn btn-primary">保存</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<!-- FullCalendar -->
	<script src='js/moment.min.js'></script>
	<script src='js/fullcalendar.min.js'></script>
	<script src='js/locales-all.js'></script>

	<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '" . <?php echo $date; ?> . "',
			timeZone: 'Asia/Tokyo',
			locale: 'ja',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			businessHours:true,
			titleFormat: {
            month: 'YYYY年M月',                            
            week: "YYYY年M月D日", 
            day: 'YYYY年 M月 D日[(]ddd[)]',
		},
		timeFormat: 'H:mm',
        // ボタン文字列
        buttonText: {
            today:    '今日',
            month:    '月',
            week:     '週',
            day:      '日'
		},
		monthNames: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
        // 月略称
        monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
        // 曜日名称
        dayNames: ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
        // 曜日略称
        dayNamesShort: ['日', '月', '火', '水', '木', '金', '土'],
			select: function(start, end) {
				
				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm'));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm'));
				$('#ModalAdd').modal('show');
			},
			eventRender: function(event, element) {
				element.bind('click', function() {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #title').val(event.title);
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit #task_priority').val(event.task_priority);
					$('#ModalEdit').modal('show');
				});
			},
			eventDrop: function(event, delta, revertFunc) { // si changement de position

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

				edit(event);

			},
			events: [
			<?php foreach($events as $event): 
			
				$start = explode(" ", $event['start']);
				$end = explode(" ", $event['end']);
				if($start[1] == '00:00:00'){
					$start = $start[0];
				}else{
					$start = $event['start'];
				}
				if($end[1] == '00:00:00'){
					$end = $end[0];
				}else{
					$end = $event['end'];
				}
			?>
				{
					id: '<?php echo $event['id']; ?>',
					title: '<?php echo $event['title']; ?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>',
					color: '<?php echo $event['color']; ?>',
					task_priority: '<?php echo $event['task_priority']; ?>',

				},
			<?php endforeach; ?>
			]
		});
		
		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm');
			}else{
				end = start;
			}
			
			id =  event.id;
			
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;
			
			$.ajax({
			 url: 'editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('保存しました。');
					}else{
						alert('Could not be saved. try again.'); 
					}
				}
			});
		}
		
	});
</script>
</body>

</html>
