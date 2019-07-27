<?php
class Controller{
	
    //construtor
    public function __construct() {}

    //destruidor
    public function __destruct() {}

	 /*
	 * This responsible operation generate every hour.
	 * 
	 * @param $start the first time
	 * @param $end the last time
	 * @param $interval the interval time Ex: 30 mins to 30 mins, default = 1 min.
	 * @param $format the formatted time in 12h or 24h, default 24h
	 * @return the amount time in hours Ex: 14:00:00, 15:30:00 = 1:30:00
	 * @author deibson.januario
 	 * @since 1.0
	 */	
	function createTimeRange($start, $end, $interval = '1 min', $format = '24') {
		$startTime = strtotime($start); 
		$endTime   = strtotime($end);
		$returnTimeFormat = ($format == '12')?'g:i:s A':'G:i:s';

		$current   = time(); 
		$addTime   = strtotime('+'.$interval, $current); 
		$diff      = $addTime - $current;
	
		$times = array(); 
		while ($startTime < $endTime) { 
			$times[] = date($returnTimeFormat, $startTime); 
			$startTime += $diff; 
		} 
		$times[] = date($returnTimeFormat, $startTime); 
		return $times; 
	}
	
	 /*
	 * This operation responsible for checking and returning time differences.
	 * Ex: days=days total,y=years,m=months,d=days,h=hours,i=minutes,s=seconds
	 * 
	 * @param $start the first time
	 * @param $end the last time
	 * @return the amount time in hours Ex: 14:00:00, 15:30:00 = 1:30:00
	 * @author deibson.januario
 	 * @since 1.0
	 */
	function diffTime($start, $end){
			$start_date = new DateTime('2012-09-11 '.$start);
			$since_start = $start_date->diff(new DateTime('2012-09-11 '.$end));
			return $since_start->h.':'.$since_start->i.':00';
	}
	
     /*
	 * This operation convert seconds to hours.
	 * 
	 * @param $totalSeconds the amount time in seconds
	 * @return the amount a total time in hours
	 * @author deibson.januario
 	 * @since 1.0
	 */
	function convertSecondToHour($totalSeconds){
			$hour = sprintf("%02s",floor($totalSeconds / (60*60)));
			$totalSeconds = ($totalSeconds % (60*60));
			$minute = sprintf("%02s",floor ($totalSeconds / 60 ));
			$totalSeconds = ($totalSeconds % 60);
			$hourMinute = $hour.":".$minute.":00";
			return $hourMinute;
	}
	
	/*
	 * This operation is intended to validate every workday.
	 * 
	 * @param $start the time a start workday
	 * @param $end the time a end workday
	 * @param $interval the time a interval workday
	 * @param $overTime the time a overtime defaut zero.
	 * @return the amount a total time worked
	 * @author deibson.januario
 	 * @since 1.0
	 */
	function checkTimes($start, $end, $interval, $overTime = "00:00:00"){
     	 //Convert hours in timestamp 
		 $start  = strtotime($start);
		 $end    = strtotime($end);
		 $interval    = strtotime($interval);
		 $overTime = strtotime($overTime);
		 
		 //split the values ​​and you get the total seconds worked
		 $totalSeconds = ($end - $start);
		 
		 //checks interval and overtime value if any
		 $secondsInterval = $interval - $overTime;
         
		 //and the final calculation counting the total hours worked minus the break.
		 $secundsTotal = $totalSeconds - $secondsInterval;
		 
		 //and now the total hours worked are returned in seconds
		 return $this->convertSecondToHour($secundsTotal);
	}
	
	/*
	 * This operation remove the second the time.
	 * 
	 * @param $time the time with second Ex: 24:59:00.
	 * @return the without second Ex: 24:59
	 * @author deibson.januario
 	 * @since 1.0
	 */
	function showTime($time){
		return date('G:i',strtotime($time));
	}
	
	/*
	 * This operation processed all times.
	 * 
	 * @return return all times processed.
	 * @author deibson.januario
 	 * @since 1.0
	 */
	function mountTimes(){
		for($i=0; $i<31; $i++){
			$diff[0] = 0;
			while($diff[0] < 3){
				$fist = $this->createTimeRange('8:45', '9:15')[rand(0, 30)];
				$second = $this->createTimeRange('11:45', '12:15')[rand(0, 30)];
				$diff = $this->diffTime($fist,$second);
			}
			$diff[0] = 0;
            while($diff[0] < 1){			
				$third = $this->createTimeRange('12:45', '13:15')[rand(0, 30)];
				$diff = $this->diffTime($second,$third);
			}
			
			$fourt = $this->createTimeRange('17:45', '18:15')[rand(0, 30)];
			while($this->checkTimes($fist,$fourt,$diff) != '08:00:00'){
				$fourt = $this->createTimeRange('17:45', '18:15')[rand(0, 30)];
			}
			?>
			<tr style="text-align: center;">
			  <td>Dia <?php echo $i+1; ?></td>
			  <td id="<?php echo 'td-fist-'.$i; ?>" onclick="mycopy('<?php echo 'fist-'.$i; ?>')">
			    <input style="border: none;text-align:center;width:67px;" type="text" value="<?php echo $this->showTime($fist); ?>" id="<?php echo 'fist-'.$i; ?>">
			  </td>
			  <td id="<?php echo 'td-second-'.$i; ?>" onclick="mycopy('<?php echo 'second-'.$i; ?>')">
				<input style="border: none;text-align:center;width:67px;" type="text" value="<?php echo $this->showTime($second); ?>" id="<?php echo 'second-'.$i; ?>">
			  </td>
			  <td id="<?php echo 'td-third-'.$i; ?>" onclick="mycopy('<?php echo 'third-'.$i; ?>')">
				<input style="border: none;text-align:center;width:67px;" type="text" value="<?php echo $this->showTime($third); ?>" id="<?php echo 'third-'.$i; ?>">
			  </td>
			  <td id="<?php echo 'td-fourt-'.$i; ?>" onclick="mycopy('<?php echo 'fourt-'.$i; ?>')">
				<input style="border: none;text-align:center;width:67px;" type="text" value="<?php echo $this->showTime($fourt); ?>" id="<?php echo 'fourt-'.$i; ?>">
			  </td>
			</tr>			
			<?php
		}
	}
	
	/*
	 * This operation show grid of times.
	 * 
	 * @return return the grid of times processed.
	 * @author deibson.januario
 	 * @since 1.0
	 */
	function timesTableView(){
		?>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
			  <a class="nav-link" href="index.php">Recarregar</a>
			  </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr style="text-align: center;">
                      <th>Data</th>
                      <th>Início</th>
                      <th>Intervalo</th>
                      <th>Volta</th>
                      <th>Fim</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr style="text-align: center;">
                      <th>Data</th>
                      <th>Início</th>
                      <th>Intervalo</th>
                      <th>Volta</th>
                      <th>Fim</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php echo $this->mountTimes(); ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>		
		<?php
	}
	
}
?>