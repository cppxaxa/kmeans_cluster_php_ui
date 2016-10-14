<html>

<head>
	<title>K MEANS CLUSTERS</title>
	<link rel="stylesheet" href="css/font-awesome.min.css" />
	<link rel="stylesheet" href="css/pure-min.css" />
	<link rel="stylesheet" href="css/style.css" />
	<script src="js/processing.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/main.js"></script>
</head>
	
<body>
	<div id="ground" class="pure-g">
		<div id="leftside" class="pure-u-1-6">
			<!--Left Gap-->
		</div>
		<div id="page" class="pure-u-2-3">
			<div id="pageTitle">
				<div id="pageTitleContent">
					K-MEANS CLUSTER
				</div>
			</div>
			<div id="pageContent">
				<!--Hello-->
				<form class="pure-form" id="searchForm" method="POST">
					<legend>PARAMETERS</legend>
					<fieldset class="pure-group">
						<textarea class="pure-input-1" name="data" style="height: 300px;"><?php if(isset($_REQUEST['data'])) echo $_REQUEST['data']; else 
echo '{"set":[
	{"x":185,"y":72},
	{"x":170,"y":56},
	{"x":168,"y":60},
	{"x":179,"y":68},
	{"x":182,"y":72},
	{"x":188,"y":77},
	{"x":180,"y":71},
	{"x":180,"y":70},
	{"x":183,"y":84},
	{"x":180,"y":88},
	{"x":180,"y":67},
	{"x":177,"y":76}
]}'?></textarea>
					</fieldset>
					<fieldset class="pure-group">
						<label class="pure-input-1">Value of k</label>
						<input class="pure-input-1" type="number" name="k" value="<?php if(isset($_REQUEST['k'])) echo $_REQUEST['k']; else echo "2"; ?>">
					</fieldset>
					<fieldset class="pure-group">
						<input class="pure-input-1 pure-button pure-button-primary" type="submit" value="CALCULATE">
					</fieldset>
					<fieldset class="pure-group">
						<a href="index.php" class="pure-input-1 pure-button">CLEAR</a>
					</fieldset>
				</form>

				
				<?php
				
				class DataSet{
					public $x;
					public $y;
					function __construct($x, $y){
						$this->x = $x;
						$this->y = $y;
					}
				}
				
				function distance($p1, $p2){
					return abs($p1->x - $p2->x)+abs($p1->y - $p2->y);
					//return sqrt($p1*$p1 + $p2*$p2);
				}
				
				function dump($table, $centroid, $k){
					$cluster = array();
					
				?>
					<table class="pure-table pure-table-horizontal tableResize">
						<thead>
							<tr>
								<th>X</th>
								<th>Y</th>
								<?php
									for($i=0; $i<$k; $i++)
										echo "<th>(".$centroid[$i]->x." , ".$centroid[$i]->y.")</th>";
								?>
								<th>Cluster</th>
							</tr>
						</thead>

						<tbody>
							<?php
								foreach($table as $row){
							?>
							<tr>
								<td>
									<?php
										echo $row->x;
									?>
								</td>
								<td>
									<?php
										echo $row->y;
									?>
								</td>
								<?php
									$minValue = 999999;
									$minID = 0;
									
									for($i=0; $i<$k; $i++){
										//echo "<td>(".$row->x." , ".$row->y.") - (".$centroid[$i]->x." , ".$centroid[$i]->y.")</td>";
										$dist = distance($row, $centroid[$i]);
										echo "<td>".$dist."</td>";
										if($minValue > $dist){
											$minID = $i;
											$minValue = $dist;
										}
									}
									
									$cluster[] = $minID;
								?>
								<td>
									<?php echo $minID; ?>
								</td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>
					<br/><br/>
				<?php
					
					return $cluster;
				}
				
				function dump_group($centroid, $group, $k){
					?>
					<table class="pure-table pure-table-horizontal tableResize">
						<thead>
							<tr>
								<?php
									for($i=0; $i<$k; $i++)
										echo "<th>(".$centroid[$i]->x." , ".$centroid[$i]->y.")</th>";
								?>
							</tr>
						</thead>
						<tbody>
							<tr>
							<?php
								for($i=0; $i<$k; $i++){
									echo "<td>";
									
									$x = 0;
									$y = 0;
									
									$c = 0;
									foreach($group[ $i ] as $set){
										$c++;
										echo "( ".$set->x." , ".$set->y." )<br/>";
										$x += $set->x;
										$y += $set->y;
									}
									
									$x /= $c;
									$y /= $c;
									
									$centroid[$i] = new DataSet($x, $y);
									
									echo "</td>";
								}
							?>
							</tr>
						</tbody>
					</table>
					<?php
					
					return $centroid;
				}
				
				if(isset($_REQUEST['data'])){
					$var = $_REQUEST['data'];
				}
				else
					$var = '{"set":[
						{"x":185,"y":72},
						{"x":170,"y":56},
						{"x":168,"y":60},
						{"x":179,"y":68},
						{"x":182,"y":72},
						{"x":188,"y":77},
						{"x":180,"y":71},
						{"x":180,"y":70},
						{"x":183,"y":84},
						{"x":180,"y":88},
						{"x":180,"y":67},
						{"x":177,"y":76}
					]}';
				
				if(isset($_REQUEST['k']))
					$k = $_REQUEST['k'];
				else
					$k = 2;
				
				$obj = json_decode($var);
				
				$table = array();
				foreach($obj->set as $row){
					$table[] = new DataSet($row->x, $row->y);
				}
				
				$centroid = array();
				for($i=0; $i<$k; $i++)
					$centroid[] = new DataSet($table[$i]->x, $table[$i]->y);
				
				
				$iteration_limit = 10;
				
				for($iteration = 0; $iteration < $iteration_limit; $iteration++){
					echo '<br/><div style="background: #DDD; position: relative; width: 100%; height: 30px; border: 1px solid black; color: black; font-weight: bold;"><div style="padding: 5px;"><i class="fa fa-info-circle"></i> ITERATION '. $iteration .'</div></div><br/>';
					
					$cluster = dump($table, $centroid, $k);

					$group = array();
					for($i=0; $i<$k; $i++){
						$group[] = array();
					}

					$i = 0;
					foreach($table as $row){
						$group[ $cluster[$i] ][] = new DataSet( $row->x, $row->y );
							$i++;
					}

					$new_centroid = dump_group($centroid, $group, $k);
					
					// CHECK CHANGED IN NEW CENTROID AND BREAK
					$flag = true;	//ASSUME SAME VALUES EXIST
					$i = 0;
					foreach($new_centroid as $g){
						if( $centroid[$i]->x != $new_centroid[$i]->x || $centroid[$i]->y != $new_centroid[$i]->y)
						{
							$flag = false;
							break;
						}
						$i++;
					}
					
					if($flag){
						break;
					}
					
					// COPY NEW_CENTROID TO CENTROID
					$i = 0;
					foreach($new_centroid as $g){
						$centroid[$i] = new DataSet( $g->x, $g->y );
						$i++;
					}

					/*
					echo "<br/>CENTROID { <br/>";
					foreach($centroid as $g){
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$g->x." , ".$g->y."<br/>";
					}
					echo "}<br/><br/>";
					*/
					
					echo "</br></br></br></br></br></br></br>";
				}
				
				if($flag){
					echo '<br/><div style="background: aquamarine; position: relative; width: 100%; height: 30px; border: 1px solid yellow; color: black; font-weight: bold;"><div style="padding: 5px;"><i class="fa fa-info-circle"></i> CLUSTER FINDING SUCCESSFULL</div></div><br/>';
				}
				else{
					echo '<br/><div style="background: red; position: relative; width: 100%; height: 30px; border: 1px solid yellow; color: white; font-weight: bold;"><div style="padding: 5px;"><i class="fa fa-info-circle"></i> ITERATION LIMIT REACHED. IMPERFECT CLUSTER, TRY CHAGING VALUE OF $k </div></div><br/>';
				}
				
				?>
			</div>
		</div>
		<div id="rightside" class="pure-u-1-6">
			<!--Right Gap-->
		</div>
	</div>

	<div id="titlebar">
		<?php include 'assets/titlebar.php'; ?>
	</div>
	
	<div id="sidemenu">
		<?php include 'assets/sidebar.php'; ?>
	</div>
    
</body>

</html>