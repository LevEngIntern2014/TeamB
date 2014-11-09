<?php
    $cate_color = array("php"=>"blue","perl"=>"red");
    //var_dump($Event);
    //var_dump($TimelineData);
    //exit;

    $timeline = array();

    foreach($Event as $val){
        $val["Event"]["created"] = $val["Event"]["event_date"];
        $timeline[] = $val["Event"];
    }
    foreach($TimelineData as $val){
        if(!empty($val["Question"])){
            $timeline[] = $val["Question"];
        }
    }
    foreach($TimelineData as $val){
     if(!empty($val["Reply"])){
        $timeline[] = $val["Reply"];
     }
    }

    foreach($timeline as $key => $val){
        $updated[$key] = $val["created"];
    }
    //配列のkeyのupdatedでソート
    array_multisort($updated, SORT_DESC, $timeline);

?>
<!doctype html>
<html>
<head>
   <meta charset='UTF-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="ramen.css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   

    <!-- タイムライン用CSS-->
    <!--<link rel="stylesheet" href="css/demo.css" type="text/css" media="screen">-->
    <?php 
    	echo $this->Html->css('timeliner');
    	echo $this->Html->css('responsive');
    	echo $this->Html->css('inc/colorbox');
    ?>

    <!--Bootstrap-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>


   <title>ramen</title>
</head>
<body bgcolor="#cee4ae">

<div id='cssmenu' align="center" style="margin-bottom:60px;">
<ul style="list-style-type: none;">
   <li>
   	<a href='#'>
   		<img src="http://localhost/terafile/img/logo.png">
   	</a>
   </li>
</ul>
</div>





<div class="row">
    <div class="col-md-3 col-md-offset-1">
    	<div class="panel panel-default">
    		<div class="panel-heading">
    			<h3 class="panel-title">ユーザー情報</h3>
    		</div>
    		<div class="panel-body">
    		<div  align=center>
    			<h1>
    				<!-- <img src=<?php //echo $profile["User"]["photo"]; ?> alt="" width="90" height="90"/> -->
    				
    				<img src=<?php echo $profile["User"]["photo"]; ?> alt="..." class="img-rounded">
    			</h1>

				<font size="-1">ユーザー名　: <a href=<?php echo "https://teratail.com/users/". $profile["User"]["display_name"]; ?> target="_blank"><?php echo $profile["User"]["display_name"]; ?></a></font>
				<p><font size="-1">所属 ： <?php echo $profile["User"]["department"]; ?></font></p>
				<p><font size="-1">　住居 ： <?php echo $profile["User"]["prefecture"]; ?></font></p>
				<p><font size="-1">　自己紹介 ： <?php echo $profile["User"]["self_info"]; ?></font></p>
				<p><font size="-1">ブログ ： 　<?php echo $profile["User"]["blog"]; ?></font></p>
    			</div>

    			<div class="progress">
				  <div class="progress-bar progress-bar-success" aria-valuenow="60"style="width: 35%">
				    <span class="sr-only">35%</span>
				  </div>
				  <div class="progress-bar progress-bar-danger progress-bar-striped"aria-valuenow="60" style="width: 60%">
				    <span class="sr-only">60%</span>
				  </div>
				 </div>
    		</div>
    	</div>
    </div>
    <div class="col-md-7">



        <div id="timeline" class="timeline-container">

            <button class="timeline-toggle">+ expand all</button>

            <br class="clear">


            <div class="timeline-wrapper">
                <h2 class="timeline-time"><span style="background: red;">PHP</span></h2>
                <dl class="timeline-series">
                    <dt id="19540517" class="timeline-event"><a></a></dt>
                    <dd class="timeline-event-content" id="19540517EX">
                        <a href="">hogehogehogehogehogehogehogehogehogehogehogehogehogehogehogehogehogehogehogehoge</a><br/>
                        <a href="">hogehoge</a><br/>
                        <a href="">hogehoge</a><br/>
                        <a href="">hogehoge</a><br/>
                        <a href="">hogehoge</a>
                    </dd><!-- /.timeline-event-content -->
                </dl><!-- /.timeline-series -->
            </div><!-- /.timeline-wrapper --> 



            <div class="timeline-wrapper">
                <h2 class="timeline-time"><span>Perl</span></h2>
                <dl class="timeline-series">
                    <dt id="19550828" class="timeline-event"><a></a></dt>
                    <dd class="timeline-event-content" id="19550828EX">
                        <a href="">hogehoge</a><br/>
                        <a href="">hogehoge</a><br/>
                        <a href="">hogehoge</a><br/>
                        <a href="">hogehoge</a><br/>
                        <a href="">hogehoge</a>
                    </dd><!-- /.timeline-event-content -->
                </dl><!-- /.timeline-series -->
            </div><!-- /.timeline-wrapper -->

            <div class="timeline-wrapper">
                <h2 class="timeline-time"><span>CISCO</span></h2>
                <dl class="timeline-series">
                    <dt id="19570904" class="timeline-event"><a></a></dt>
                    <dd class="timeline-event-content" id="19570904EX">
                        <a href="">hogehoge</a><br/>
                        <a href="">hogehoge</a><br/>
                        <a href="">hogehoge</a><br/>
                        <a href="">hogehoge</a><br/>
                        <a href="">hogehoge</a>
                    </dd><!-- /.timeline-event-content -->
                </dl><!-- /.timeline-series -->
            </div><!-- /.timeline-wrapper -->


            <br class="clear">
        </div><!-- /#timelineContainer -->



    </div>
</div>






<!-- タイムライン用 -->
<?php echo $this->Html->script('inc/colorbox');
		echo $this->Html->script('timeliner');
	 ?>
<script>
    $(document).ready(function() {
        $.timeliner({
            //defaultで開いておきたい箇所を指定
            //startOpen:['#19550828', '#19630828'],
        });
        $.timeliner({
            timelineContainer: '#timeline-js',
            timelineSectionMarker: '.milestone',
            oneOpen: true,
            startState: 'flat',
            expandAllText: '+ Show All',
            collapseAllText: '- Hide All'
        });
        // Colorbox Modal
        $(".CBmodal").colorbox({inline:true, initialWidth:100, maxWidth:682, initialHeight:100, transition:"elastic",speed:750});
    });
</script>


</body>
</html>
