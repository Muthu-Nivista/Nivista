<?php  //print_r($_REQUEST);exit;
require('../sql.php');
session_start();

$query=mysql_query("select *from teacher from teacheralloc where course='".$_REQUEST['courseid']."' and batch='".$_REQUEST['batchid']."'");
$result=mysql_fetch_array($query);
$_SESSION['teachername']=$result['teacher'];


$gstd=mysql_query("select * from student_1819 where stclass='".$_REQUEST['courseid']."' and crsection='".$_REQUEST['batchid']."' order by name asc");
if(mysql_num_rows($gstd)<=0)
{
	?><tr><td colspan="4">No record found</td></tr><?php
}
else
{
	$date =date('Y-m-d',strtotime($_REQUEST['joindate']));
	//$exquery=mysql_query("SELECT holiday,type  FROM `Extraholiday` where holiday='".$date."' and class='".$_REQUEST['courseid']."' ");
	// $check_exquery=mysql_num_rows($exquery);

	//$make_holiday_to_workingday_query= mysql_query("SELECT *  FROM `make_holiday_to_workingday` where h_date='".$date."' and class='".$_REQUEST['courseid']."' ");
	//$check_make_holiday_to_workingday_query=mysql_num_rows($make_holiday_to_workingday_query);

	$d1=date('D', strtotime($date));
	/*if($check_exquery>0)
	{
		echo "<script>
	alert('Holiday Entry is Not allowed!..'); 
	window.location.href='student-attend.php';
	</script>";
	}
	else if($check_make_holiday_to_workingday_query<0)
	{
		echo "<script>
	alert('Holiday Entry is Not allowed1!..'); 
	window.location.href='student-attend.php';
	</script>";
	} 
	else*/ if($d1=='Sun')
	{
	echo "<script>
	alert('Sunday Entry is Not allowed!..');
	window.location.href='student-attend.php';
	</script>";
	}
	else if($d1=='Sat')
		{
		  
		  echo "<script>
		alert('Saturday Entry is Not allowed!..');
		window.location.href='student-attend.php';
		</script>";
		}
	else
	{
		if($_REQUEST['reset']==1)
		  {       

			$jo=date('Y-m-d',strtotime($_REQUEST['joindate']));
			$gstd2=mysql_query("select *from sattend where atdate='".$jo."'  and course='".$_REQUEST['courseid']."' ");
			while($gstd3=mysql_fetch_object($gstd2))
			{
			 $q = mysql_query("update sattend set is_present='' where id='".$gstd3->id."'");
			}
				
		  }
		$i=1;
		while($gstd1=mysql_fetch_object($gstd))
		{
			/*$date1 =$_REQUEST['joindate'];
			$date2 = str_replace('/', '-', $date1);
			$ddd=date('Y-m-d', strtotime($date2));*/			 

			/* $res = mysql_query( "select * from sattend where course='".$_REQUEST['courseid']."' and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."'  and atdate='".$_REQUEST['joindate']."'");*/
			
			$j1=date('Y-m-d',strtotime($_REQUEST['joindate']));

			$res = mysql_query( "select * from sattend where course='".$_REQUEST['courseid']."'  and admno='".$gstd1->sno."'  and atdate='".$j1."'");
				
			$res1 = mysql_fetch_assoc($res);
				
			$new_admis_date= $gstd1->adm_date;
			$new_admis_date 	= date('Y-m-d',strtotime($new_admis_date));
			$from_date11 	= date('Y-m-d',strtotime($_REQUEST['joindate'])); 
			
				?>
				<tr>
					<td <?php if($res1["is_present"] == 'N') { echo "style='background-color:#FF9999;'"; } if($res1["is_present"] == 'Y') { echo "style='background-color:#DDEEAA;'"; } if($from_date11<$new_admis_date){ echo "style='background-color:#ffff0078;'"; }?>><?php echo $i; ?></td>
					<td <?php if($res1["is_present"] == 'N') { echo "style='background-color:#FF9999;'"; } if($res1["is_present"] == 'Y') { echo "style='background-color:#DDEEAA;'"; } if($from_date11<$new_admis_date){ echo "style='background-color:#ffff0078;'"; } ?>><?php echo $gstd1->adno; ?></td>
					<td <?php if($res1["is_present"] == 'N') { echo "style='background-color:#FF9999;'"; } if($res1["is_present"] == 'Y') { echo "style='background-color:#DDEEAA;'"; } if($from_date11<$new_admis_date){ echo "style='background-color:#ffff0078;'"; }?>><?php echo $gstd1->roll_no; ?></td>
					<td <?php if($res1["is_present"] == 'N') { echo "style='background-color:#FF9999;'"; } if($res1["is_present"] == 'Y') { echo "style='background-color:#DDEEAA;'"; } if($from_date11<$new_admis_date){ echo "style='background-color:#ffff0078;'"; } ?>><?php echo $gstd1->name; ?></td>
					<td data-id="12" <?php if($res1["is_present"] == 'N') { echo "style='background-color:#FF9999;'"; } if($res1["is_present"] == 'Y') { echo "style='background-color:#DDEEAA;'"; } if($from_date11<$new_admis_date){ echo "style='background-color:#ffff0078;'"; }?>>
			       
					<?php /*$chkatd1=mysql_fetch_object($chkatd);*/ ?>


			<input type="checkbox" <?php if($res1["is_present"] != 'N') { echo 'checked'; }  ?> name="attd<?php echo $gstd1->id; ?>" id="attd<?php echo $gstd1->id; ?>" class="checkbox" value="Yes" <?php if(!empty($res1) and $res1["is_present"] == 'Y') { echo 'checked'; }  ?> ><input type='hidden' name="present<?php echo $gstd1->id; ?>" value="Y">  </td>

				

			<td <?php if($res1["is_present"] == 'N') { echo "style='background-color:#FF9999;'"; } if($res1["is_present"] == 'Y') { echo "style='background-color:#DDEEAA;'"; } if($from_date11<$new_admis_date){ echo "style='background-color:#ffff0078;'"; } ?>><input type="text" name="remark<?php echo $gstd1->id; ?>" id="remark<?php echo $gstd1->id; ?>" class="form-control" value="<?php echo $res1["stremark"];  ?>"> </td>
				</tr>
				<?php
			$i++;
		}
			?><tr><td colspan="5"><p>&nbsp;&nbsp; <input type='submit' class="btn btn-info" name="save" align="right" value="Save">
			&nbsp;&nbsp; <a href="<?php if($_SESSION['utype']=='Admin'){echo "student-attend.php";} else{echo "tch-attendance.php";}?>" class="btn btn-danger" align="right">Cancel</a>&nbsp;&nbsp; 
			
			
			<?php $cltch=mysql_num_rows(mysql_query("select * from teacheralloc where teacher='".$_SESSION['tcname']."' and status!='1'"));
			            
			   if($_REQUEST['courseid']=='XI' || $_REQUEST['courseid']=='XII' || $_REQUEST['courseid']=='X' || $_REQUEST['courseid']=='IX' || $_REQUEST['courseid']=='VIII' || $_REQUEST['courseid']=='VII' || $_REQUEST['courseid']=='VI' ||  $_SESSION['utype']=='Admin' || ($cltch>0)){
			?>
			<input type='submit' class="btn btn-success" name="send" align="right" value="Save And Send SMS">
			   <?php } ?>
			
			
			<?php if($_REQUEST['courseid']=='XI' || $_REQUEST['courseid']=='XII'){ ?>&nbsp;&nbsp; <a href="formate.php?c=<?php echo $_REQUEST['courseid'] ?>&s=<?php echo $_REQUEST['batchid'] ?>"><input type='button' class="btn btn-warning" name="print" align="right" target='new' value="Print Formate"></a> <?php } ?></p></td></tr>
			<?php
	}
}
?>

