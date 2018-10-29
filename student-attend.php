<?php //print_r($_REQUEST);exit;
  include('include/head.php');
  session_start();    
    if(isset($_REQUEST['admno_selected1']))
    {
		//echo "<script>alert('1')</script>";
        $count=count($_REQUEST['admno_selected1']);
        for($i=0;$i<$count;$i++)
        {
			//echo '<script>alert(2)</script>';
            $val=array_values($_REQUEST['admno_selected1']);  
            $value=$val[$i];
            


            $q=mysql_query("select * from  (select frmobile as mobile1,stclass as stclass1,name as name1,crsection as crsection1 from student_1819 where sno in ('".$value."') and frmobile!='' union all (select mrmobile as mobile2,stclass as stclass1,name as name1,crsection as crsection1 from student_1819 where sno in ('".$value."') and mrmobile!='')) x");   
            $res=mysql_fetch_array($q);


      
             $d=date_create(date('d-m-Y',strtotime($_REQUEST['wrongsms_date1'])));
			 $sms_date=date_format($d, 'd-F-Y');

                $username="nivista"; 
                $password="kushal@987";
                
                $message="Dear Parents, Please be informed ".$res['name1']." of class ".$res['stclass1']." - \"".$res['crsection1']."\" is absent on ".$sms_date." - from PRINCIPAL BCBS";
                $sender="BCBSBL"; //ex:INVITE
                $mobile_number=$res['mobile1'];;
                
                $url="http://203.212.70.200/smpp/sendsms?username=".urlencode($username)."&password=".urlencode($password)."&text=".urlencode($message)."&from=".urlencode($sender)."&to=".$mobile_number;

                $ch1 = curl_init($url);
                curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                $curl_scraped_page = curl_exec($ch1);				
				$err = curl_error($ch1);				
                curl_close($ch1); 
				
				if($err)
				{
					$delivery_status='0';
				}
				else
				{
				    $delivery_status='1';
				}
                if($ch1)
                {
                    mysql_query("insert into sms_table(course,section,stid,student_name,phone,message,status,sms_date)values('".$res['stclass1']."','".$res['crsection1']."','".$value."','".$res['name1']."','".$mobile_number."','".$message."','".$delivery_status."','".$sms_date."')");
                    echo "<script> alert('SMS Sent Successfully!.');window.location.href='student-attend.php';</script>";
                }
        }
        
    }
      if(isset($_REQUEST['admno_selected']))
    {
		//echo "<script>alert('1')</script>";
        $count=count($_REQUEST['admno_selected']);
        for($i=0;$i<$count;$i++)
        {
			//echo '<script>alert(2)</script>';
            $val=array_values($_REQUEST['admno_selected']);  
			
            $value=$val[$i];
            


            $q=mysql_query("select * from  (select frmobile as mobile1,stclass as stclass1,name as name1,crsection as crsection1 from student_1819 where sno in ('".$value."') and frmobile!='' union all (select mrmobile as mobile2,stclass as stclass1,name as name1,crsection as crsection1 from student_1819 where sno in ('".$value."') and mrmobile!='')) x");   

            while($res=mysql_fetch_array($q))
			{
             $d=date_create(date('d-m-Y',strtotime($_REQUEST['wrongsms_date1'])));
			 $sms_date=date_format($d, 'd-F-Y');
          

                $username="nivista"; 
                $password="kushal@987";              
               $message="Dear Parents, kindly note ".$res['name1']." of class ".$res['stclass1']." - \"".$res['crsection1']."\" is present on ".$sms_date." please ignore the previous message";
                $sender="BCBSBL"; //ex:INVITE
                $mobile_number=$res['mobile1'];
                
                $url="http://203.212.70.200/smpp/sendsms?username=".urlencode($username)."&password=".urlencode($password)."&text=".urlencode($message)."&from=".urlencode($sender)."&to=".$mobile_number;

                $ch1 = curl_init($url);
                curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                $curl_scraped_page = curl_exec($ch1);				
				$err = curl_error($ch1);				
                curl_close($ch1); 
				
				if($err)
				{
					$delivery_status='0';
				}
				else
				{
				    $delivery_status='1';
				}
                if($ch1)
                {
					//echo '<script>alert(3)</script>';
                    mysql_query("insert into sms_table(course,section,stid,student_name,phone,message,status,sms_date)values('".$res['stclass1']."','".$res['crsection1']."','".$value."','".$res['name1']."','".$mobile_number."','".$message."','".$delivery_status."','".$sms_date."')");
                    echo "<script> alert('SMS Sent Successfully!.');window.location.href='student-attend.php';</script>";
                }
		}
        }
        
    }
    if(isset($_REQUEST['send']))
    { 
      $d=date_create(date($_REQUEST['joindate']));
     $sms_date=date_format($d, 'd-F-Y');
   // $sms_date=date('d-F-Y');

      $q=mysql_query("select *from student_1819 where stclass='".$_REQUEST['courseid']."' and crsection='".$_REQUEST['batchid']."'");
      while($res=mysql_fetch_array($q))
      {
        if($_REQUEST['attd'.$res['id']]=='')
        {
           $q1=mysql_query("select distinct mobile1,stclass1,name1,crsection1,sno1 from (select frmobile as mobile1,stclass as stclass1,name as name1,crsection as crsection1,sno as sno1 from student_1819 where stclass in ('".$_REQUEST['courseid']."') and crsection='".$_REQUEST['batchid']."' and name='".$res['name']."' union all (select mrmobile as mobile2,stclass as stclass1,name as name1,crsection as crsection1,sno as sno1 from student_1819 where stclass in ('".$_REQUEST['courseid']."') and crsection='".$_REQUEST['batchid']."' and name='".$res['name']."')) x");
            while($res1=mysql_fetch_array($q1))
            {
                $username="nivista"; 
                $password="kushal@987";
                
                $message="Dear Parents, Please be informed ".$res1['name1']." of class ".$res1['stclass1']." - \"".$res1['crsection1']."\" is absent on ".$sms_date." - from PRINCIPAL BCBS";
                $sender="BCBSBL"; //ex:INVITE
                $mobile_number=$res1['mobile1'];
                $url="http://203.212.70.200/smpp/sendsms?username=".urlencode($username)."&password=".urlencode($password)."&text=".urlencode($message)."&from=".urlencode($sender)."&to=".$mobile_number;

                $ch1 = curl_init($url);
                curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                $curl_scraped_page = curl_exec($ch1);
                $err = curl_error($ch1);				
                curl_close($ch1); 
				
				if($err)
				{
					$delivery_status='0';
				}
				else
				{
				    $delivery_status='1';
				} 
                if($ch1)
                {
                    mysql_query("insert into sms_table(course,section,stid,student_name,phone,message,status,sms_date)values('".$_REQUEST['courseid']."','".$_REQUEST['batchid']."','".$res1['sno1']."','".$res1['name1']."','".$mobile_number."','".$message."','".$delivery_status."','".$sms_date."')");
                    echo "<script> alert('SMS Sent Successfully!.');window.location.href='student-attend.php';</script>";
                }
                //mysql_query("insert into testing(name,mobile)values('".$gstd1->name."','".$res['frmobile']."')");                    
            }
        }
      }

      $qno=mysql_query("select *from sattend where atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."'  and course='".$_REQUEST['courseid']."' and batch='".$_REQUEST['batchid']."'");
    if($no=mysql_num_rows($qno)>=1)
    {
        $gstd2=mysql_query("select * from student_1819 where stclass='".$_REQUEST['courseid']."' and crsection='".$_REQUEST['batchid']."' order by name asc");
      while($r=mysql_fetch_array($gstd2))
      {
          $q=mysql_query("select *from sattend where atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."' and stname='".$r['name']."' and course='".$_REQUEST['courseid']."' and batch='".$_REQUEST['batchid']."'");
          $res=mysql_fetch_array($q);
          $q1=mysql_query("update sattend set is_present='".$_REQUEST['is_present'.$r['id']]."',stremark='".$_REQUEST['remark'.$r['id']]."' where stname='".$res['stname']."' and course='".$_REQUEST['courseid']."' and batch='".$_REQUEST['batchid']."' and atdate='".date('Y-m-d',strtotime($res['atdate']))."'");
      }  
    }

   

    $gstd=mysql_query("select * from student_1819 where stclass='".$_REQUEST['courseid']."' 
    and crsection='".$_REQUEST['batchid']."' order by name asc");
    while($gstd1=mysql_fetch_object($gstd))
    {
       /* echo "select * from sattend where course='".$_REQUEST['courseid']."' 
        and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
        and atdate='".$_REQUEST['joindate']."'";
         $chkatd=mysql_num_rows(mysql_query("select * from sattend where course='".$_REQUEST['courseid']."' 
        and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
        and atdate='".$_REQUEST['joindate']."'"));
        echo "<hr>";*/

        $chkatd=mysql_num_rows(mysql_query("select * from sattend where course='".$_REQUEST['courseid']."' 
        and admno='".$gstd1->sno."' and atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."'"));
        //echo $chkatd;

       if($_REQUEST['attd'.$gstd1->id.'']=='Yes' || $_REQUEST['attd'.$gstd1->id.'']=='')
        {
            if($chkatd>0)
            {
              /*echo "update sattend set is_present=";
                if(!isset($_REQUEST['attd'.$gstd1->id.''])){
                  echo 'N';
                }else{
                  echo $_REQUEST['present'.$gstd1->id.''];
                }
              echo ", stremark='".$_REQUEST['remark'.$gstd1->id.'']."' where course='".$_REQUEST['courseid']."' 
              and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
              and atdate='".$_REQUEST['joindate']."'";


              echo "<hr>";*/
              //echo 'Update';

              $q = "update sattend set is_present=";

               if(!isset($_REQUEST['attd'.$gstd1->id.''])){
                  $q .= "'N'";
                }else{
                  $q .=  "'".$_REQUEST['present'.$gstd1->id.'']."'";
                }
             /*   $q .= ", stremark='".$_REQUEST['remark'.$gstd1->id.'']."' where course='".$_REQUEST['courseid']."' 
              and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
              and atdate='".$_REQUEST['joindate']."'"; */
              $q .= ", stremark='".$_REQUEST['remark'.$gstd1->id.'']."' where course='".$_REQUEST['courseid']."' 
               and admno='".$gstd1->sno."' and atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."'";

              mysql_query($q);
              //echo $q."<hr>";


              /*mysql_query("update sattend set is_present='".$_REQUEST['present'.$gstd1->id.'']."', stremark='".$_REQUEST['remark'.$gstd1->id.'']."' where course='".$_REQUEST['courseid']."' 
              and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
              and atdate='".$_REQUEST['joindate']."'");*/
            }
            else
            {
                //echo 'Add';
                
                $date =date('Y-m-d',strtotime($_REQUEST['joindate']));
               
		   $exquery=mysql_query("SELECT holiday,type  FROM `extraholiday` where holiday='".$date."'");
			$check_exquery=mysql_num_rows($exquery);
			
			$make_holiday_to_workingday_query= mysql_query("SELECT *  FROM `make_holiday_to_workingday` where h_date='".$date."'");
			$check_make_holiday_to_workingday_query=mysql_num_rows($make_holiday_to_workingday_query);
			
			$d1=date('D', strtotime($date));
				/*if($check_exquery>0)
				{
				echo "<script>
				alert('Holiday Entry is Not allowed!..'); 
				window.location.href='student-attend.php';
				</script>";
				}
				else */if($d1=='Sun')
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
                    if($_REQUEST['attd'.$gstd1->id.'']=='')
                    {

                          mysql_query("insert into sattend(course,batch,atdate,day,admno,stname,is_present,stremark)values('".$_REQUEST['courseid']."','".$_REQUEST['batchid']."','".date('Y-m-d',strtotime($_REQUEST['joindate']))."','".$d1."','".$gstd1->sno."','".$gstd1->name."','N','".$_REQUEST['remark'.$gstd1->id.'']."')");

                                    
                    }
                    else
                    {

                        mysql_query("insert into sattend(course,batch,atdate,day,admno,stname,is_present,stremark)values('".$_REQUEST['courseid']."','".$_REQUEST['batchid']."','".date('Y-m-d',strtotime($_REQUEST['joindate']))."','".$d1."','".$gstd1->sno."','".$gstd1->name."','".$_REQUEST['present'.$gstd1->id.'']."','".$_REQUEST['remark'.$gstd1->id.'']."')");
                    }
                }
            }
        }
        else
        {
          if($chkatd>0)
          {
           /* echo "delete from sattend where course='".$_REQUEST['courseid']."' 
            and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
            and atdate='".date("Y-m-d", strtotime($_REQUEST['joindate']))."'";

            echo "<hr>";*/

            mysql_query("delete from sattend where course='".$_REQUEST['courseid']."' 
            and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
            and atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."'");
          }
        } 
    }
    //exit;
    $query=mysql_query("select *from sattend where course='".$_REQUEST['courseid']."' 
            and batch='".$_REQUEST['batchid']."' and atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."' and is_present='Y'");
    $pre=mysql_num_rows($query);

    $query1=mysql_query("select *from sattend where course='".$_REQUEST['courseid']."' 
            and batch='".$_REQUEST['batchid']."' and atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."' and is_present='N'");
    $abs=mysql_num_rows($query1);

    $_SESSION['pre']=$pre;
    $_SESSION['abs']=$abs;
   
    header("location:student-attend.php?scmsg=Yes");     
  }

  if(isset($_REQUEST['abs_std']))
  {
    $_SESSION['course'] = $_REQUEST['courseid'];
  }

  if(isset($_REQUEST['save']))
  {
    $ab=0;
    $pr=0;
    $qno=mysql_query("select *from sattend where atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."'  and course='".$_REQUEST['courseid']."' and batch='".$_REQUEST['batchid']."'");
    if($no=mysql_num_rows($qno)>=1)
    {
        $gstd2=mysql_query("select * from student_1819 where stclass='".$_REQUEST['courseid']."' and crsection='".$_REQUEST['batchid']."' order by name asc");
      while($r=mysql_fetch_array($gstd2))
      {
          $q=mysql_query("select *from sattend where atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."' and stname='".$r['name']."' and course='".$_REQUEST['courseid']."' and batch='".$_REQUEST['batchid']."'");
          $res=mysql_fetch_array($q);
          $q1=mysql_query("update sattend set is_present='".$_REQUEST['is_present'.$r['id']]."',stremark='".$_REQUEST['remark'.$r['id']]."' where stname='".$res['stname']."' and course='".$_REQUEST['courseid']."' and batch='".$_REQUEST['batchid']."' and atdate='".date('Y-m-d',strtotime($res['atdate']))."'");
      }  
    }

    $gstd=mysql_query("select * from student_1819 where stclass='".$_REQUEST['courseid']."' 
    and crsection='".$_REQUEST['batchid']."' order by name asc");
    while($gstd1=mysql_fetch_object($gstd))
    {
       /* echo "select * from sattend where course='".$_REQUEST['courseid']."' 
        and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
        and atdate='".$_REQUEST['joindate']."'";

        echo "<hr>";
		
		select * from sattend where course='".$_REQUEST['courseid']."' 
        and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
        and atdate='".$_REQUEST['joindate']."'
		
		*/

        $chkatd=mysql_num_rows(mysql_query("select * from sattend where course='".$_REQUEST['courseid']."' 
         and admno='".$gstd1->sno."' and atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."'"));
        //echo $chkatd;

       if($_REQUEST['attd'.$gstd1->id.'']=='Yes' || $_REQUEST['attd'.$gstd1->id.'']=='')
        {
            if($chkatd>0)
            {
              /*echo "update sattend set is_present=";
                if(!isset($_REQUEST['attd'.$gstd1->id.''])){
                  echo 'N';
                }else{
                  echo $_REQUEST['present'.$gstd1->id.''];
                }
              echo ", stremark='".$_REQUEST['remark'.$gstd1->id.'']."' where course='".$_REQUEST['courseid']."' 
              and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
              and atdate='".$_REQUEST['joindate']."'";


              echo "<hr>";*/
              //echo 'Update';

              $q = "update sattend set is_present=";

               if(!isset($_REQUEST['attd'.$gstd1->id.''])){
                  $q .= "'N'";
                }else{
                  $q .=  "'".$_REQUEST['present'.$gstd1->id.'']."'";
                }
              /* $q .= ", stremark='".$_REQUEST['remark'.$gstd1->id.'']."' where course='".$_REQUEST['courseid']."' 
              and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
              and atdate='".$_REQUEST['joindate']."'"; */
              $q .= ", stremark='".$_REQUEST['remark'.$gstd1->id.'']."' where course='".$_REQUEST['courseid']."' 
               and admno='".$gstd1->sno."' and atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."'";

              mysql_query($q);
              //echo $q."<hr>";


              /*mysql_query("update sattend set is_present='".$_REQUEST['present'.$gstd1->id.'']."', stremark='".$_REQUEST['remark'.$gstd1->id.'']."' where course='".$_REQUEST['courseid']."' 
              and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
              and atdate='".$_REQUEST['joindate']."'");*/
            }
            else
            {
                //echo 'Add';
                
                $date =date('Y-m-d',strtotime($_REQUEST['joindate']));
                
				$exquery=mysql_query("SELECT holiday,type  FROM `extraholiday` where holiday='".$date."'");
				$check_exquery=mysql_num_rows($exquery);
				
				$make_holiday_to_workingday_query= mysql_query("SELECT *  FROM `make_holiday_to_workingday` where h_date='".$date."'");
				$check_make_holiday_to_workingday_query=mysql_num_rows($make_holiday_to_workingday_query);
				
                $d1=date('D', strtotime($date));
				/*if($check_exquery>0)
				{
				echo "<script>
				alert('Holiday Entry is Not allowed!..'); 
				window.location.href='student-attend.php';
				</script>";
				}
				else */if($d1=='Sun')
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
                    $ins='yes';
                    if($_REQUEST['attd'.$gstd1->id.'']=='')
                    {
                          mysql_query("insert into sattend(course,batch,atdate,day,admno,stname,is_present,stremark)values('".$_REQUEST['courseid']."','".$_REQUEST['batchid']."','".date('Y-m-d',strtotime($_REQUEST['joindate']))."','".$d1."','".$gstd1->sno."','".$gstd1->name."','N','".$_REQUEST['remark'.$gstd1->id.'']."')");
                          $ab=$ab+1;
                    }
                    else
                    {
                       /* echo "insert into sattend(course,batch,atdate,day,admno,stname,is_present,stremark)values('".$_REQUEST['courseid']."','".$_REQUEST['batchid']."','".date("Y-m-d", strtotime($_REQUEST['joindate']))."','".$d1."','".$gstd1->sno."','".$gstd1->name."','".$_REQUEST['present'.$gstd1->id.'']."','".$_REQUEST['remark'.$gstd1->id.'']."')";

                        echo "<hr>";*/

                        mysql_query("insert into sattend(course,batch,atdate,day,admno,stname,is_present,stremark)values('".$_REQUEST['courseid']."','".$_REQUEST['batchid']."','".date('Y-m-d',strtotime($_REQUEST['joindate']))."','".$d1."','".$gstd1->sno."','".$gstd1->name."','".$_REQUEST['present'.$gstd1->id.'']."','".$_REQUEST['remark'.$gstd1->id.'']."')");

                        $pr=$pr+1;
                    }
                }
            }
        }
        else
        {
          if($chkatd>0)
          {
           /* echo "delete from sattend where course='".$_REQUEST['courseid']."' 
            and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
            and atdate='".date("Y-m-d", strtotime($_REQUEST['joindate']))."'";

            echo "<hr>";*/

            mysql_query("delete from sattend where course='".$_REQUEST['courseid']."' 
            and batch='".$_REQUEST['batchid']."' and admno='".$gstd1->sno."' and stname='".$gstd1->name."' 
            and atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."'");
          }
        } 
    }
    //exit;
    $query=mysql_query("select *from sattend where course='".$_REQUEST['courseid']."' 
            and batch='".$_REQUEST['batchid']."' and atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."' and is_present='Y'");
    $pre=mysql_num_rows($query);

    $query1=mysql_query("select *from sattend where course='".$_REQUEST['courseid']."' 
            and batch='".$_REQUEST['batchid']."' and atdate='".date('Y-m-d',strtotime($_REQUEST['joindate']))."' and is_present='N'");
    $abs=mysql_num_rows($query1);
    if($ins=='yes')
    {
      $_SESSION['pre']=$pr;
      $_SESSION['abs']=$ab;  
    }
    else
    {
      $_SESSION['pre']=$pre;
      $_SESSION['abs']=$abs;
    }
    $_SESSION['abs_std']= "?class='".$_REQUEST['courseid']."'&batch='".$_REQUEST['batchid']."'&atdate='".$_REQUEST['joindate']."'";
    header("location:student-attend.php?scmsg=Yes");
    
?>    
<?php 
  } 
  
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-FRAME-OPTIONS" content="DENY">
        <link rel="stylesheet" type="text/css" href="assets/716fe13f/css/ui-lightness/jquery-ui-1.8.2.custom.css" />
        <script type="text/javascript" src="js/fvalidation.js"></script>
		<script type="text/javascript" src="/assets/2b845a33/jquery.js"></script>
        <script type="text/javascript" src="assets/2b845a33/jquery.yiiactiveform.js"></script>
<title>Admin panel</title>

        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <link rel="icon" href="images/f.jpg" type="image/png" sizes="50x50">

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="js/lib/bootstrap-switch/stylesheets/bootstrap-switch.css">

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/style2.css">
<link rel="stylesheet" href="css/theme/color_3.css" id="theme">

<link rel="stylesheet" href="cssinc/font-awesome.min.css">
       
<link href="cssinc/bootstrap-combined.no-icons.min.css" rel="stylesheet">
<script src="assets/js/jquery.min.js"></script>
        <script>
$(document).ready(function(){
    $(document).ajaxStart(function(){
        $("#wait").css("display", "block");
    });
    $(document).ajaxStop(function(){
        $("#wait").css("display", "none");
    });
    $("button").click(function(){
        $("#txt").load("demo_ajax_load.asp");
    });
});
</script>
    <script type="text/javascript">
function printDiv(divName) {

     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
    </script>

        <script src="js/country.js"></script>	
<style>
@page {
  size: A4;
  margin-left: 20;
  margin-right: 20;
}

@media print {
  .printpage {
    margin-left: 20;
    margin-right: 20;
    border: initial;
    border-radius: initial;
    width: initial;
    min-height: initial;
    box-shadow: initial;
    background: initial;
    page-break-after: always;
  }
</style>
    </head>
    <body class=" sidebar_hidden side_fixed">
        <div id="wrapper_all">
            <?php include('include/header.php'); ?>						

            <!-- mobile navigation -->
            <nav id="mobile_navigation"></nav>
            <div id="content">
	<style> 

    #overlaygif {
        background: url("/images/loading.gif") no-repeat center;
        position:fixed;top:0;right:0;bottom:0;left:0;
       
        //background: rgba(0,0,0,0.5)no-repeat 50% 50%;
        /*background: url(http://www.deepakgems.com/images/new/loading.gif) no-repeat center;*/
    }

    .panel-default > .panel-heading-custom {
        background: #F8F8F8;
        color: #black;
    }

    #customstyle:link {text-decoration: none; color:black;} 
    #customstyle:visited {text-decoration: none; color:black;}
    #customstyle:active {text-decoration: none; color:black;font-weight: bold;} 
    #customstyle:hover {text-decoration: none;font-weight: bold;color:black;}

</style>

<section id="breadcrumbs">
    <div class="container">
        <ul>
        	<li><a href="#"><i class="icon-home2 position-left"></i>Home</a></li>
            <li><a href="#">Student</a></li>
            <li><span>Attendance</span></li>
        </ul>
    </div>
</section>
<section class="container clearfix main_section">
    <div id="main_content_outer" class="clearfix">
        <div id="main_content">
        <?php
						if($_REQUEST['scmsg']=='Yes')
						{
							?><div class="row" id='msg'><div class="col-sm-12"><div class="alert alert-success">Attendance has been Successfully Saved.</div></div></div>
              <div class="row">
                
                    <!-- <script type="text/javascript">
                      setTimeout(function(){
                        document.getElementById('pre').style.display='none';
                        document.getElementById('abs').style.display='none';
                        document.getElementById('msg').style.display='none';
                      },10000);
                    </script> -->
                    <?php
                      if($_SESSION['pre']!="")
                      { 
                    ?>
                      <div class="col-sm-6" id="present_student"><div class="alert alert-success" id='pre'>Total Present : <?php echo $_SESSION['pre']; ?></div></div>
                    <?php     
                      }

                      if($_SESSION['abs']!="")
                      {
                    ?>
                        <div class="col-sm-6" id="absent_student">
                          <a href="abs_std.php<?php echo $_SESSION['abs_std'];?>">
                            <button class="alert alert-danger col-sm-12" style="text-align: left!important;">
                              Total Absent : <?php echo $_SESSION['abs']; ?>
                            </button>
                          </a>
                        </div>
                    <?php    
                      }
                    ?>
       
                
              </div>
              <?php
						}
						?>
            <div class="content">
<div class="col-sm-12">
  <ul class="nav nav-tabs nav-tabs-highlight">
    <li class="active"><a href="#tbb_a" data-toggle="tab">Attendance Entry</a></li>
    <li class=""><a href="#tbb_b" data-toggle="tab">View Attendance</a></li>
    <li class=""><a href="#tbb_c" data-toggle="tab">Attendance Report</a></li>
    <li class=""><a href="#tbb_d" data-toggle="tab">Absent Report</a></li>
    <li class=""><a href="#tbb_e" data-toggle="tab">Send Absent SMS</a></li>
	<li class=""><a href="#tbb_f" data-toggle="tab">Sent Report</a></li>
	<li class=""><a href="#tbb_g" data-toggle="tab">Wrong SMS</a></li>
    </ul><br>

  <div class="tab-content">
    <div class="tab-pane active" id="tbb_a">
      <form action="" method="post" name="Addform" id="Addform">
      
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">Attendance </h4>
              </div>
            <div class="panel-body">
              <div class="form-group col-sm-3" id="course">
                <label for="reg_input" class="req">Class</label>
                <select class="form-control" name="courseid" id="Studentabsent_courseid">
  				<option value="">Select Class</option>
  				<?php $sel = "select * from course order by id asc";
				  $opl = mysql_query($sel);
				  $i = 0;
				  while($row = mysql_fetch_array($opl)){
				  ?>
                  	<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                  <?php } ?>
  </select><div class="school_val_error" id="errf1"></div>                                </div>  
              
              <div class="form-group col-sm-3" id="Batch_subject">
                <label for="reg_input" class="req">Section</label>
                <select class="form-control" name="batchid" id="Studentabsent_batchid">
  <option value="">Select Section</option>
  </select><div class="school_val_error" id="errf2"></div>                                </div> 
              
              <div class="form-group col-sm-3" id="subject" style="display:none;">
                
                <label for="reg_input" class="req">Subject</label>
                <select class="form-control" name="subject" id="Studentabsent_subjectid">
  <option value="">Select Subject</option>
  </select>                               </div> 
              
              
              <div class="form-group col-sm-3" id="date">
                <label for="reg_input_name" class="req">Date </label>
                <div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
                  <input name="joindate" placeholder="Date" class="form-control" id="joindate" type="text" />
                  <span class="input-group-addon"><i class="icon-calendar"></i></span> </div>
                <div class="school_val_error" id="errf3"></div> 
                <!--<span class="help-block">dd-mm-yyyy</span>-->
                </div>
              
              
              <div class="form-group col-sm-3">
                <label for="reg_input">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <div class="row ">
                <a href="javascript:showlist();" onclick="ok()" class="btn btn-info">Show List</a>&nbsp;&nbsp;<input type='button' class="btn btn-info reset"   value="Reset">
				</div> 
                </div>
              
              </div>
            </div>
          </div>
        </div>
      
      <p>
        </p><div class="alert alert-warning warning">
          <span class="icon-warning icon-2x" style="color:orange"></span> Put Remark on students who were present.
          </div>
      <p></p>
      <div class="row">
        <div class="col-sm-12" id="gridview">
          <div id="wait" style="display:none;width:64px;height:64px;border-radious:8px solid black;position:absolute;top:30%;left:50%;padding:2px;"><img src='lo.gif' width="100" height="100" /></div>
          <div class="panel panel-default" id="attendancediv" style="display:none">
            <div class="panel-heading">
              <h4 class="panel-title">Attendance </h4>
              </div>
              <div id="teachername">
                
              </div>
            <div class="table-responsive">
              <table class="table responsive table-bordered table-striped" id="studentattendence">
                <thead>
                  <tr>
                      <th data-hide="phone,tablet" width="5%">S.No.</th>
                    <th data-hide="phone,tablet" width="15%">Student Admission No.</th>
   <th data-hide="phone,tablet" width="5%">Student Roll No.</th>
                    <th data-hide="phone,tablet" width="30%">Student Name</th>
                    <th data-hide="phone" class="footable-last-column" width="15%">Check all<input type="checkbox" id="checkall" style="position: relative;top:2px;width: auto !important;vertical-align: baseline;margin-left: 5px;"></th>
                    <th data-hide="phone,tablet" width="30%">Remarks</th>                       
                    
                    </tr>
                  </thead>
                <tbody>
                  
                  
                  </tbody>
                
                </table>
              </div>
            </div>
          </div>
        </div>
      
      <div class="row">
        <div class="col-sm-5">
          
          </div>
        </div>
      </form>
      </div>

      <div class="tab-pane" id="tbb_e">
      <form action="" method="post" name="absentsms" id="absentsms">
			  
				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">Absent Student </h4>
							</div>
							<div class="panel-body">
							
								<div class="form-group col-sm-3" id="course">
									<label for="reg_input" class="req">Class</label>
									<select class="form-control" name="courseid" id="Studentabsent_courseid8">
										<option value="">Select Class</option>
										<?php $sel = "select * from course order by id asc";
										  $opl = mysql_query($sel);
										  $i = 0;
										  while($row = mysql_fetch_array($opl)){
										?>
										<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
										<?php } ?>
									</select>
									<div class="school_val_error" id="err11"></div>                                
									
								</div>  
						  
								<div class="form-group col-sm-3" id="Batch_subject">
									<label for="reg_input" class="req">Section</label>
									<select class="form-control" name="batchid" id="Studentabsent_batchid8">
										<option value="">Select Section</option>
									</select>
									<div class="school_val_error" id="err12"></div>                                
								</div> 
								<div class="form-group col-sm-3" id="date">
									<label for="reg_input_name" class="req">Date </label>
									<div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
										<input name="wrongsms_date" placeholder="Date" class="form-control" id="wrongsms_date" type="text" />
										<span class="input-group-addon"><i class="icon-calendar"></i></span> 
									</div>
									<div class="school_val_error" id="errf72"></div> 
								</div>				  
								
									   
								 <div class="form-group col-sm-3">
									<label for="reg_input">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
									<div class="row ">
									<a href="javascript:showlist8();"  class="btn btn-info">Show List</a>&nbsp;&nbsp;
									</div>
									</div>
						  
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12" id="gridview">
						<div id="loader8" style="display:none;width:64px;height:64px;border-radious:8px solid black;position:absolute;top:30%;left:50%;padding:2px;"><img src='lo.gif' width="100" height="100" /></div>
						
						<div class="panel panel-default" id="sms_sentabsentdiv1" style="display:none">
							<div class="panel-heading">
								<h4 class="panel-title">SMS Sent Absent </h4>
							</div>
							<!-- <div id="teachername"></div> -->
							<div class="table-responsive"> 
							<form action="" method="post" name="absent_sms" id="absent_sms">
								<table class="table responsive table-bordered table-striped" id="studentattendence8">
									<thead>
										<tr>
										    <th width="5%"><input type="checkbox" id="selectAll"></th>
											<th data-hide="phone,tablet" width="5%">S.No.</th>
											<th data-hide="phone,tablet" width="20%">BCBSID</th>
											<th data-hide="phone,tablet" width="20%">Student Name</th>											
											<th data-hide="phone,tablet" width="5%">Course</th>
											<th data-hide="phone,tablet" width="5%">Section</th>
											
										</tr>
									</thead>
									
									<tbody>
									<div class="pull-right">
							        <input type='submit' class="btn btn-info send_absent_sms"   value="Send Absent sms">
									</div> 
									</tbody>							
								</table>
							</form>
							</div>
						</div>
					</div>
				</div>
				  
				<div class="row">
					<div class="col-sm-5"></div>
				</div>
			
			</form>
      </div>

   <div class="tab-pane" id="tbb_b">
	<form action="new_ts.php"  method="POST">
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">Attendance</h4>
              </div>
            <div class="panel-body">
              <div class="form-group col-sm-3" id="course">
                <label for="reg_input" class="req">Class</label>
                <select class="form-control" name="courseid1" id="Studentabsent_courseid1">
  <option value="">Select Class</option>
  <?php $sel = "select * from course order by id asc";
          $opl = mysql_query($sel);
          $i = 0;
          while($row = mysql_fetch_array($opl)){
          ?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                  <?php } ?>
  </select><div class="school_val_error" id="errf11"></div>                                </div>  
              
              <div class="form-group col-sm-3" id="Batch_subject1">
                <label for="reg_input" class="req">Section</label>
                <select class="form-control" name="batchid1" id="Studentabsent_batchid1">
  <option value="">Select Section</option>
  </select><div class="school_val_error" id="errf22"></div>                                </div> 
              
              <div class="form-group col-sm-3" id="subject1" style="display:none;">
                <label for="reg_input" class="req">Subject</label>
                <select class="form-control" name="Studentabsent[subjectid1]" id="Studentabsent_subjectid1">
  <option value="">Select Subject</option>
  </select><div class="school_val_error" id="Studentabsent_subjectid1_em_" style="display:none"></div>   </div>  


  <div class="form-group col-sm-3">
                <label for="reg_input_name">Year</label>
             
                
                <select maxlength="6" class="form-control" value="04" name="year" id="year">
  <option value="2018">2018</option>
 
  </select><div class="school_val_error" id="errf33"></div>                                               
                </div> 
              
              <div class="form-group col-sm-3">
                <label for="reg_input_name">Month</label>
             
                
                <select maxlength="6" class="form-control" value="04" name="month" id="Studentabsent_date15">
  <option value="">Select</option>
  <option value="01">January</option>
  <option value="02">February</option>
  <option value="03">March</option>
  <option value="04">April</option>
  <option value="05">May</option>
  <option value="06">June</option>
  <option value="07">July</option>
  <option value="08">August</option>
  <option value="09">September</option>
  <option value="10">October</option>
  <option value="11">November</option>
  <option value="12">December</option>
  </select><div class="school_val_error" id="errf33"></div>                                               
                </div>
              <div class="form-group col-sm-2">
                <label for="reg_input">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                &nbsp;&nbsp;<!--<a href="javascript:showlist1();" class="btn btn-info">Show List</a> -->
				            <input type ="submit" class="btn btn-info" value="Show List">
                </div>
               
              
              </div>
            </div>
          </div>
        </div>
		</form>
		<!--
      <div class="row" id="print">
        <div class="col-sm-12" id="gridview">
 <div id="loader" style="display:none;width:64px;height:64px;border-radious:8px solid black;position:absolute;top:30%;left:50%;padding:2px;"><img src='lo.gif' width="100" height="100" /></div>
          <div class="panel panel-default" id="attendance">
            <div class="panel-heading">
              <h4 class="panel-title" id="reporttitle">Attendance Report</h4>
              </div>
            
            <div class="table-responsive view-report" >
              <table class="table responsive table table-bordered table table-striped" id="employeeattendence1">
                <thead>
                  </thead>
 
                <tbody id="attendancebody">
                 
                   <div id="wait" style="display:none;width:64px;height:64px;border-radious:8px solid black;position:absolute;top:30%;left:50%;padding:2px;"><img src='lo.gif' width="100" height="100" /></div>
                  </tbody>
                
                </table>
              </div>

            </div>
          
          </div>
        </div>
       -->
      </div>
	  
<div class="tab-pane" id="tbb_c">
    <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">Attendance Report</h4>
            </div>
            <div class="panel-body">
				<div class="form-group col-sm-3" id="course">
					<label for="reg_input" class="req">Class</label>
					<select class="form-control" name="courseid1" id="Studentabsent_courseid2">
						<option value="">Select Class</option>
						  <?php $sel = "select * from course order by id asc";
								  $opl = mysql_query($sel);
								  $i = 0;
								  while($row = mysql_fetch_array($opl)){
								  ?>
						<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
					  <?php } ?>
					</select>
					<div class="school_val_error" id="errf11"></div>                                
				</div>  
              
				<div class="form-group col-sm-3" id="Batch_subject1">
					<label for="reg_input" class="req">Section</label>
					<select class="form-control" name="batchid1" id="Studentabsent_batchid2">
					<option value="">Select Section</option>
					</select><div class="school_val_error" id="errf22"></div>                                
				</div> 
              
				<div class="form-group col-sm-3" id="subject1" style="display:none;">
					<label for="reg_input" class="req">Subject</label>
					<select class="form-control" name="Studentabsent[subjectid1]" id="Studentabsent_subjectid1">
					<option value="">Select Subject</option>
					</select><div class="school_val_error" id="Studentabsent_subjectid1_em_" style="display:none"></div>   
				</div>  


				<div class="form-group col-sm-3" id="date">
					<label for="reg_input_name" class="req">From Date </label>
					<div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
					  <input name="fromdate" placeholder="Date" class="form-control" id="fromdate" type="text" />
					  <span class="input-group-addon"><i class="icon-calendar"></i></span> </div>
					<div class="school_val_error" id="errf33"></div> 
                </div>
              
				<div class="form-group col-sm-3" id="date">
					<label for="reg_input_name" class="req">To Date </label>
					<div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
					  <input name="todate" placeholder="Date" class="form-control" id="todate" type="text" />
					  <span class="input-group-addon"><i class="icon-calendar"></i></span> </div>
					<div class="school_val_error" id="errf43"></div> 
                </div>
				<!--div class="form-group col-sm-2">
                                <label for="reg_input">Test*</label>
                                <select class="form-control" name="test_exam" id="test_exam">
									<option value="">Select Test</option>
									<option value="1ST Term Unit Test">1ST Term Unit Test</option>
									<option value="First Term Examination">First Term Examination</option>
									<option value="2nd Term Unit Test">2nd Term Unit Test</option>
									<option value="Final Examination">Final Examination</option>
								</select>
                 </div-->
				<div class="form-group col-sm-2">
					<label for="reg_input">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
					&nbsp;&nbsp;<a href="javascript:showlist3();" class="btn btn-info">Show Report</a> 
					 
                </div>
              
              </div>
			  
            </div>
          </div>
        </div>
    	<div class="row" id="print">
        <div class="col-sm-12" id="gridview">
 <div id="loader1" style="display:none;width:64px;height:64px;border-radious:8px solid black;position:absolute;top:30%;left:50%;padding:2px;"><img src='lo.gif' width="100" height="100" /></div>

          <div class="panel panel-default" id="attendance">
            <div class="panel-heading">
              <h4 class="panel-title" id="reporttitle">Attendance Report</h4>
              </div>
            
            <div class="table-responsive">
              <table class="table responsive table table-bordered table table-striped" id="totalstudentattendence">
                <thead>
                 
          
            
    
          
                  </thead>
 
                <tbody id="attendancebody">
                 <div id="wait" style="display:none;width:64px;height:64px;border-radious:8px solid black;position:absolute;top:30%;left:50%;padding:2px;"><img src='lo.gif' width="100" height="100" /></div>
                   
                  </tbody>
                
                </table>
              </div>

            </div>
          
          </div>
        </div>
	</div>

    <div class="tab-pane" id="tbb_d">
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">Absent Report</h4>
              </div>
            <div class="panel-body">
              <div class="form-group col-sm-3" id="course">
                <label for="reg_input" class="req">Class</label>
                <select class="form-control" name="courseid1" id="Studentabsent_courseid3">
  <option value="">Select Class</option>
  <?php $sel = "select * from course order by id asc";
          $opl = mysql_query($sel);
          $i = 0;
          while($row = mysql_fetch_array($opl)){
          ?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                  <?php } ?>
  </select><div class="school_val_error" id="errf11"></div>                                </div>  
              
              <div class="form-group col-sm-3" id="Batch_subject1">
                <label for="reg_input" class="req">Section</label>
                <select class="form-control" name="batchid1" id="Studentabsent_batchid3">
  <option value="">Select Section</option>
  </select><div class="school_val_error" id="errf22"></div>                                </div> 
              
              <div class="form-group col-sm-3" id="subject1" style="display:none;">
                <label for="reg_input" class="req">Subject</label>
                <select class="form-control" name="Studentabsent[subjectid1]" id="Studentabsent_subjectid1">
  <option value="">Select Subject</option>
  </select><div class="school_val_error" id="Studentabsent_subjectid1_em_" style="display:none"></div>   </div>  


          <div class="form-group col-sm-3" id="date">
                <label for="reg_input_name" class="req">From Date </label>
                <div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
                  <input name="fromdate" placeholder="Date" class="form-control" id="fromdate3" type="text" />
                  <span class="input-group-addon"><i class="icon-calendar"></i></span> </div>
                <div class="school_val_error" id="errf33"></div> 
                <!--<span class="help-block">dd-mm-yyyy</span>-->
                </div>
              
              <div class="form-group col-sm-3" id="date">
                <label for="reg_input_name" class="req">To Date </label>
                <div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
                  <input name="todate" placeholder="Date" class="form-control" id="todate3" type="text" />
                  <span class="input-group-addon"><i class="icon-calendar"></i></span> </div>
                <div class="school_val_error" id="errf43"></div> 
                <!--<span class="help-block">dd-mm-yyyy</span>-->
                </div>
              <div class="form-group col-sm-2">
                <label for="reg_input">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                &nbsp;&nbsp;<a href="javascript:showlist4();" class="btn btn-info">Show Report</a> 
                 
                </div>
              
              
              </div>
            </div>
          </div>
        </div>
    	<div class="row" id="print">
        <div class="col-sm-12" id="gridview">
 <div id="loader2" style="display:none;width:64px;height:64px;border-radious:8px solid black;position:absolute;top:30%;left:50%;padding:2px;"><img src='lo.gif' width="100" height="100" /></div>
 <input type="button" id="btnPrint" value="Print Report" onclick="printDiv('printpage')"  class="btn btn-danger">
          <div class="panel panel-default" id="attendance3">
            <div class="panel-heading">
              <h4 class="panel-title" id="reporttitle">Absent Report</h4>

              </div>
           
            <div class="table-responsive" id="printpage">
              <!-- <table class="table responsive table table-bordered table table-striped" id="totalstudentattendence3">
                <thead>
                 
          
            
    
          
                  </thead>
 
                <tbody id="attendancebody3">
                 
                   <div id="wait" style="display:none;width:64px;height:64px;border-radious:8px solid black;position:absolute;top:30%;left:50%;padding:2px;"><img src='lo.gif' width="100" height="100" /></div>
                  </tbody>
                
                </table> -->
                <div id="totalstudentattendence3"> 
                <div id="wait" style="display:none;width:64px;height:64px;border-radious:8px solid black;position:absolute;top:30%;left:50%;padding:2px;"><img src='lo.gif' width="100" height="100" /></div>
                </div>
              </div>

            </div>
          
          </div>
        </div>
	</div>

<div class="tab-pane" id="tbb_f">
	<form action="" method="post" name="sentreportform" id="sentreportform">
      
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">Attendance </h4>
					</div>
					<div class="panel-body">
					
						<div class="form-group col-sm-3" id="course">
							<label for="reg_input" class="req">Class</label>
							<select class="form-control" name="courseid" id="Studentabsent_courseid6">
								<option value="">Select Class</option>
								<?php $sel = "select * from course order by id asc";
								  $opl = mysql_query($sel);
								  $i = 0;
								  while($row = mysql_fetch_array($opl)){
								?>
								<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
								<?php } ?>
							</select>
							<div class="school_val_error" id="errf6"></div>                                
							
						</div>  
				  
						<div class="form-group col-sm-3" id="Batch_subject">
							<label for="reg_input" class="req">Section</label>
							<select class="form-control" name="batchid" id="Studentabsent_batchid6">
								<option value="">Select Section</option>
							</select>
							<div class="school_val_error" id="errf7"></div>                                
						</div> 
										  
						<div class="form-group col-sm-3" id="date">
							<label for="reg_input_name" class="req">Date </label>
							<div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
								<input name="joindate" placeholder="Date" class="form-control" id="joindate6" type="text" />
								<span class="input-group-addon"><i class="icon-calendar"></i></span> 
							</div>
							<div class="school_val_error" id="errf8"></div> 
						</div>
							   
						<div class="form-group col-sm-2">
							<label for="reg_input">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
							&nbsp;&nbsp;<a href="javascript:showlist6();" class="btn btn-info">Show List</a> 
						</div>
				  
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12" id="gridview">
				<div id="loader6" style="display:none;width:64px;height:64px;border-radious:8px solid black;position:absolute;top:30%;left:50%;padding:2px;"><img src='lo.gif' width="100" height="100" /></div>
				
				<div class="panel panel-default" id="sentabsentdiv" style="display:none">
					<div class="panel-heading">
						<h4 class="panel-title">Sent Absent </h4>
					</div>
					<!-- <div id="teachername"></div> -->
					<div class="table-responsive">
						<table class="table responsive table-bordered table-striped" id="studentattendence6">
							<thead>
								<tr>
									<th data-hide="phone,tablet" width="5%">S.No.</th>
									<th data-hide="phone,tablet" width="20%">BCBSID</th>
									<th data-hide="phone,tablet" width="20%">Student Name</th>									
									<th data-hide="phone,tablet" width="5%">Course</th>
									<th data-hide="phone,tablet" width="5%">Section</th>
									<th data-hide="phone,tablet" width="30%">Message</th>
								</tr>
							</thead>
							
							<tbody>
					  
							</tbody>
					
						</table>
					</div>
				</div>
			</div>
		</div>
		  
		<div class="row">
			<div class="col-sm-5"></div>
		</div>
	
	</form>
</div>      
      
<!-- wrong sms-->  
      <div class="tab-pane" id="tbb_g">
				 <form action="" method="post" name="wrongsms" id="wrongsms">
			  
				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">Absent Student </h4>
							</div>
							<div class="panel-body">
							
								<div class="form-group col-sm-3" id="course">
									<label for="reg_input" class="req">Class</label>
									<select class="form-control" name="courseid" id="Studentabsent_courseid7">
										<option value="">Select Class</option>
										<?php $sel = "select * from course order by id asc";
										  $opl = mysql_query($sel);
										  $i = 0;
										  while($row = mysql_fetch_array($opl)){
										?>
										<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
										<?php } ?>
									</select>
									<div class="school_val_error" id="errf9"></div>                                
									
								</div>  
						  
								<div class="form-group col-sm-3" id="Batch_subject">
									<label for="reg_input" class="req">Section</label>
									<select class="form-control" name="batchid" id="Studentabsent_batchid7">
										<option value="">Select Section</option>
									</select>
									<div class="school_val_error" id="errf10"></div>                                
								</div> 
								<div class="form-group col-sm-3" id="date">
									<label for="reg_input_name" class="req">Date </label>
									<div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
										<input name="wrongsms_date" placeholder="Date" class="form-control" id="wrongsms_date" type="text" />
										<span class="input-group-addon"><i class="icon-calendar"></i></span> 
									</div>
									<div class="school_val_error" id="errf72"></div> 
								</div>				  
								
									   
								 <div class="form-group col-sm-3">
									<label for="reg_input">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
									<div class="row ">
									<a href="javascript:showlist7();"  class="btn btn-info">Show List</a>&nbsp;&nbsp;
									</div>
									</div>
						  
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12" id="gridview">
						<div id="loader7" style="display:none;width:64px;height:64px;border-radious:8px solid black;position:absolute;top:30%;left:50%;padding:2px;"><img src='lo.gif' width="100" height="100" /></div>
						
						<div class="panel panel-default" id="sms_sentabsentdiv" style="display:none">
							<div class="panel-heading">
								<h4 class="panel-title">SMS Sent Absent </h4>
							</div>
							<!-- <div id="teachername"></div> -->
							<div class="table-responsive"> 
							<form action="" method="post" name="wr_sms" id="wr_sms">
								<table class="table responsive table-bordered table-striped" id="studentattendence7">
									<thead>
										<tr>
										    <th width="5%"><input type="checkbox" id="selectAll"></th>
											<th data-hide="phone,tablet" width="5%">S.No.</th>
											<th data-hide="phone,tablet" width="20%">BCBSID</th>
											<th data-hide="phone,tablet" width="20%">Student Name</th>											
											<th data-hide="phone,tablet" width="5%">Course</th>
											<th data-hide="phone,tablet" width="5%">Section</th>
											
										</tr>
									</thead>
									
									<tbody>
									<div class="pull-right">
							        <input type='submit' class="btn btn-info send_sms"   value="Send sms">
									</div> 
									</tbody>							
								</table>
							</form>
							</div>
						</div>
					</div>
				</div>
				  
				<div class="row">
					<div class="col-sm-5"></div>
				</div>
			
			</form>
	   </div>




	  
      </div>
    </div>
</div>

</div>
            
</div>
</div>
</section>
</div><!-- content -->


            <div id="footer_space"></div>
        </div>        <?php echo include('include/footer.php'); ?>
<!-- side menu----------------------------------------------------------------------------------------> 
                      <?php echo include('include/sidebar.php'); ?>
            
                               <!-- side menu----------------------------------------------------------------------------------------> 

        <!--[[ common plugins ]]-->

        <!-- jQuery -->
        <!--<script src="/js/jquery.min.js"></script>-->
        <!-- bootstrap framework -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- jQuery resize event -->
        <script src="js/jquery.ba-resize.min.js"></script>
        <!-- jquery cookie -->
        <script src="js/jquery_cookie.min.js"></script>
        <!-- retina ready -->
        <script src="js/retina.min.js"></script>
        <!-- typeahead -->
        <script src="js/lib/typeahead.js/typeahead.min.js"></script>
        <script src="js/lib/typeahead.js/hogan-2.0.0.js"></script>

        <!-- tinyNav -->
        <script src="js/tinynav.js"></script>
        <!-- slimscroll -->
        <script src="js/lib/jQuery-slimScroll/jquery.slimscroll.min.js"></script>

        <!-- bootstrap switch -->
        <script src="js/lib/bootstrap-switch/js/bootstrap-switch.min.js"></script>

        <!-- touchSwipe -->
        <script src="js/lib/TouchSwipe/jquery.touchSwipe.min.js"></script>

        <!-- Navgoco -->
        <script src="js/lib/navgoco/jquery.navgoco.min.js"></script>

        <!-- ebro common scripts/functions -->
        <script src="js/ebro_common.js"></script>
        <script src="js/pages/ebro_wizard.js"></script>


        <!--[[ page specific plugins ]]-->
        <!-- qrcode -->
        <script src="js/lib/qrcode/jquery.qrcode-0.7.0.min.js"></script>

        <script src="js/pages/ebro_invoices.js"></script>
        <script src="js/lib/jquery-steps/jquery.steps.min.js"></script>
        <script src="js/lib/datepicker/js/bootstrap-datepicker.js"></script>

        <!--[if lte IE 9]>
                <script src="/js/ie/jquery.placeholder.js"></script>
                <script>
                        $(function() {
                                $('input, textarea').placeholder();
                        });
                </script>
        <![endif]-->

        <!-- style switcher -->
        <?php echo include('include/pdesign.php'); ?>
<script>
           $('#selectAll').click(function(e){
			var table= $(e.target).closest('table');
			$('td input:checkbox',table).prop('checked',this.checked);
		});
            $(function () {
                ebro_datepicker.init();

            }); 

            ebro_datepicker = {
                init: function () {
                    if ($('.ebro_datepicker').length) {
                        $('.ebro_datepicker').datepicker({endDate: "today"})
                    }
                    if (($('#dpStart').length) && ($('#dpEnd').length)) {
                        $('#dpStart').datepicker().on('changeDate', function (e) {
                            $('#dpEnd').datepicker('setStartDate', e.date);
                        });
                        $('#dpEnd').datepicker().on('changeDate', function (e) {
                            $('#dpStart').datepicker('setEndDate', e.date)
                        });
                    }
                }
            };

		  
		   
	$('#joindate').datepicker()
.on('changeDate', function(ev){   
console.log('fghj')              
    $('#joindate').datepicker('hide');
});	   

$('.icon-calendar').on('click', function(){ $('.datepicker').toggle()   });

            //check mail timer settings
          setInterval(function () {
                console.log('Checking mail');
                     // var memberid = //get after login
                $.ajax({ 
                  type: "POST", 
                  url: "ajaxphp/hcount.php",
                  //data: {empid:empid},
                  success: function(data){ 
                          //alert("Success "+data); 
                          $('#envelope').html(data);
                          },
                  error: function(err){   
                          //alert("failure "+err);
                           } 
                 });

            }, 10000);


        </script> 
<script>
            function PrintTable() {
                var divToPrint = document.getElementById('totalstudentattendence');
                var popupWin = window.open('', '_blank');
                popupWin.document.open();
                popupWin.document.write('<html><head><link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css"></head><body onload="window.print()"><div class="container"><table class="table table-bordered" style="font-size:11px;"><caption><button style="display: none!important;"></button></caption>' + divToPrint.innerHTML + '</table></div></body></html>');
                popupWin.document.close();
            }
        </script>
<script type="text/javascript" src="assets/716fe13f/js/jquery.form.js"></script> 
<script type="text/javascript" src="assets/716fe13f/js/jquery.validate.js"></script> 
<script type="text/javascript" src="assets/716fe13f/js/bbq.js"></script> 
<script type="text/javascript" src="assets/716fe13f/js/jquery-ui-1.8.5.custom.min.js"></script> 
<script type="text/javascript" src="assets/716fe13f/js/jquery.form.wizard.js"></script>        
    
<script type="text/javascript">
jQuery('body').on('change','#Studentabsent_courseid',function(){
	jQuery.ajax({'type':'POST','url':'ajaxphp/batchtime.php','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#Studentabsent_batchid").html(html)}});return false;});
	
jQuery('body').on('change','#Studentabsent_courseid1',function(){ 
	jQuery.ajax({'type':'POST','url':'ajaxphp/batchtime.php','cache':false,data: {courseid: $('#Studentabsent_courseid1 option:selected').val()},'success':function(html){jQuery("#Studentabsent_batchid1").html(html)}});return false;});	

jQuery('body').on('change','#Studentabsent_courseid2',function(){
  jQuery.ajax({'type':'POST','url':'ajaxphp/batchtime.php','cache':false,data: {courseid: $('#Studentabsent_courseid2 option:selected').val()},'success':function(html){jQuery("#Studentabsent_batchid2").html(html)}});return false;});  
	
jQuery('body').on('change','#Studentabsent_courseid3',function(){
  jQuery.ajax({'type':'POST','url':'ajaxphp/batchtime.php','cache':false,data: {courseid: $('#Studentabsent_courseid3 option:selected').val()},'success':function(html){jQuery("#Studentabsent_batchid3").html(html)}});return false;});

  jQuery('body').on('change','#Studentabsent_courseid5',function(){
  jQuery.ajax({'type':'POST','url':'ajaxphp/batchtime.php','cache':false,data: {courseid: $('#Studentabsent_courseid5 option:selected').val()},'success':function(html){jQuery("#Studentabsent_batchid5").html(html)}});return false;}); 
	
  jQuery('body').on('change','#Studentabsent_courseid6',function(){
  jQuery.ajax({'type':'POST','url':'ajaxphp/batchtime.php','cache':false,data: {courseid: $('#Studentabsent_courseid6 option:selected').val()},'success':function(html){jQuery("#Studentabsent_batchid6").html(html)}});return false;});
  
   jQuery('body').on('change','#Studentabsent_courseid7',function(){
  jQuery.ajax({'type':'POST','url':'ajaxphp/batchtime.php','cache':false,data: {courseid: $('#Studentabsent_courseid7 option:selected').val()},'success':function(html){jQuery("#Studentabsent_batchid7").html(html)}});return false;});  
  
   jQuery('body').on('change','#Studentabsent_courseid8',function(){
  jQuery.ajax({'type':'POST','url':'ajaxphp/batchtime.php','cache':false,data: {courseid: $('#Studentabsent_courseid8 option:selected').val()},'success':function(html){jQuery("#Studentabsent_batchid8").html(html)}});return false;});
function showlist() 
{		
	   var chkerr=0;
	   var inpfocus=0;
	   
	   if(document.getElementById('Studentabsent_courseid').value=="")
	   {
		   document.getElementById('errf1').innerHTML='Class cannot be blank.';
		   chkerr=1;
	   }
	   else
	   {
			document.getElementById('errf1').innerHTML='';
	   }
	   
	   if(document.getElementById('Studentabsent_batchid').value=="")
	   {
		   document.getElementById('errf2').innerHTML='Section cannot be blank.';
		   chkerr=1;
	   }
	   else
	   {
			document.getElementById('errf2').innerHTML='';
	   }  
	   
	   if(document.getElementById('joindate').value=="")
	   {
		   
		   document.getElementById('errf3').innerHTML='Date cannot be blank.';
		   chkerr=1;
	   }
	   else
	   {
			document.getElementById('errf3').innerHTML='';
	   }
	   
	   
	   
	   if(chkerr==0)
	   {
		   //return true;
		   $('#studentattendence tbody').empty();
            $.ajax({
                type: "POST",
                url: "ajaxphp/sattendance.php",
                data: {courseid: $('#Studentabsent_courseid option:selected').val(), batchid: $('#Studentabsent_batchid option:selected').val(), joindate: $('#joindate').val()},
                dataType: "html",
                success: function (data) {
                    $('#studentattendence tbody').append(data);
                    $('#attendancediv').show("slow");
                }
        	});
	   }
	   else
	   {
		   //return false; 
	   }	
		   
}
function ok()
{
    $('#teachername').empty();
            $.ajax({
                type: "POST",
                url: "ajaxphp/getteachername.php",
                data: {courseid: $('#Studentabsent_courseid option:selected').val(), batchid: $('#Studentabsent_batchid option:selected').val(), joindate: $('#joindate').val()},
                dataType: "html",
                success: function (data) {
                    $('#teachername').append(data);
                    $('#attendancediv').show("slow");
                }
          });
}

$(document).ready(function () {
        $('#checkall').click(function (event) {  //on click 
            if (this.checked) { // check select status
                $('.checkbox').each(function () { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"  
                                 
                });
            } else {
                $('.checkbox').each(function () { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });
            }
        });

    });	


function showlist5() 
{   
     var chkerr=0;
     var inpfocus=0;
     
     if(document.getElementById('Studentabsent_courseid5').value=="")
     {
       document.getElementById('errf1').innerHTML='Class cannot be blank.';
       chkerr=1;
     }
     else
     {
      document.getElementById('errf1').innerHTML='';
     }
     
     if(document.getElementById('Studentabsent_batchid5').value=="")
     {
       document.getElementById('errf2').innerHTML='Section cannot be blank.';
       chkerr=1;
     }
     else
     {
      document.getElementById('errf2').innerHTML='';
     }  
     
     if(document.getElementById('joindate5').value=="")
     {
       
       document.getElementById('errf3').innerHTML='Date cannot be blank.';
       chkerr=1;
     }
     else
     {
      document.getElementById('errf3').innerHTML='';
     }
     
     
     
     if(chkerr==0)
     {
       //return true;
       $('#studentattendence5 tbody').empty();
            $("#loader").show();
            $.ajax({
                type: "POST",
                url: "ajaxphp/getabsent.php",
                data: {courseid: $('#Studentabsent_courseid5 option:selected').val(), batchid: $('#Studentabsent_batchid5 option:selected').val(), joindate: $('#joindate5').val()},
                dataType: "html",
                success: function (data) {
                    $('#studentattendence5 tbody').append(data);
                    $('#attendancediv5').show("slow");
                    $("#loader").hide();
                }
          });
     }
     else
     {
       //return false; 
     }  
    
}

function showlist1() 
{   
     var chkerr=0;
     var inpfocus=0;
     
     if(document.getElementById('Studentabsent_courseid1').value=="")
     {
       document.getElementById('errf11').innerHTML='Class cannot be blank.';
       chkerr=1;
     }
     else
     {
      document.getElementById('errf11').innerHTML='';
     }
     
     if(document.getElementById('Studentabsent_batchid1').value=="")
     {
       document.getElementById('errf22').innerHTML='Section cannot be blank.';
       chkerr=1;
     }
     else
     {
      document.getElementById('errf22').innerHTML='';
     }  
     
     if(document.getElementById('Studentabsent_date15').value=="")
     {
       document.getElementById('errf33').innerHTML='Month cannot be blank.';
       chkerr=1;
     }
     else
     {
      document.getElementById('errf33').innerHTML='';
     }
     
     // sattendance1
     if(chkerr==0)
     {
       //return true;
       $('#employeeattendence1 tbody').empty();
            $("#loader").show();
            $.ajax({
                type: "POST",
                url: "ajaxphp/ts.php",
                data: {courseid: $('#Studentabsent_courseid1 option:selected').val(), batchid: $('#Studentabsent_batchid1 option:selected').val(), month: $('#Studentabsent_date15').val(),year: $('#year').val()},
                dataType: "html",
                success: function (data) {
					console.log(data);
                    $('#employeeattendence1 tbody').append(data);
                    $('#attendancediv').show("slow");
                    $("#loader").hide();
                }
          });
     }
     else
     {
       //return false; 
     }        
}

function showlist2() 
{  
     var chkerr=0;
     var inpfocus=0;
     
     if(document.getElementById('Studentabsent_courseid1').value=="")
     {
       document.getElementById('errf11').innerHTML='Class cannot be blank.';
       chkerr=1;
     }
     else
     {
      document.getElementById('errf11').innerHTML='';
     }
     
     if(document.getElementById('Studentabsent_batchid1').value=="")
     {
       document.getElementById('errf22').innerHTML='Section cannot be blank.';
       chkerr=1;
     }
     else
     {
      document.getElementById('errf22').innerHTML='';
     }  
     
     if(document.getElementById('fromdate').value=="")
     {
       document.getElementById('errf33').innerHTML='From Date cannot be blank.';
       chkerr=1;
     }
     else
     {
      document.getElementById('errf33').innerHTML='';
     }

     if(document.getElementById('todate').value=="")
     {
       document.getElementById('errf44').innerHTML='To Date cannot be blank.';
       chkerr=1;
     }
     else
     {
      document.getElementById('errf44').innerHTML='';
     }
     
     // sattendance1
     if(chkerr==0)
     {
       //return true;
      /* $('#employeeattendence1 tbody').empty();
            $.ajax({
                type: "POST",
                url: "ajaxphp/ts.php",
                data: {courseid: $('#Studentabsent_courseid1 option:selected').val(), batchid: $('#Studentabsent_batchid1 option:selected').val(), month: $('#Studentabsent_date15').val(),year: $('#year').val()},
                dataType: "html",
                success: function (data) {
                    $('#employeeattendence1 tbody').append(data);
                    //$('#attendancediv').show("slow");
                }
          });*/
     }
     else
     {
       //return false; 
     }        
}
</script>
<script type="text/javascript">
function showlist3() 
{		
	   var chkerr=0;
	   var inpfocus=0;
	   
	   if(document.getElementById('Studentabsent_courseid2').value=="")
	   {
		   document.getElementById('errf11').innerHTML='Class cannot be blank.';
		   chkerr=1;
	   }
	   else
	   {
			document.getElementById('errf11').innerHTML='';
	   }
	   
	   if(document.getElementById('Studentabsent_batchid2').value=="")
	   {
		   document.getElementById('errf22').innerHTML='Section cannot be blank.';
		   chkerr=1;
	   }
	   else
	   {
			document.getElementById('errf22').innerHTML='';
	   }  
	   
	   if(chkerr==0)
	   {
			//return true;
			$('#totalstudentattendence').empty();
            $("#loader1").show();

            $.ajax({
                type: "POST",
              //  url: "ajaxphp/newstudentattend.php",
                url: "ajaxphp/new_att_cal.php",
                data: {courseid: $('#Studentabsent_courseid2 option:selected').val(), batchid: $('#Studentabsent_batchid2 option:selected').val(), fromdate: $('#fromdate').val(),todate: $('#todate').val()},
                dataType: "html",
                success: function (data) {
                    $('#totalstudentattendence').append(data);
                    $('#attendancediv').show("slow");
                    $("#loader1").hide();
                }
        	});
	   }
	   else
	   {

	   }				
}
</script>

<script type="text/javascript">
function showlist4() 
{		
	   var chkerr=0;
	   var inpfocus=0;
	   
	   if(document.getElementById('Studentabsent_courseid3').value=="")
	   {
		   document.getElementById('errf11').innerHTML='Class cannot be blank.';
		   chkerr=1;
	   }
	   else
	   {
			document.getElementById('errf11').innerHTML='';
	   }
	   
	   if(document.getElementById('Studentabsent_batchid3').value=="")
	   {
		   document.getElementById('errf22').innerHTML='Section cannot be blank.';
		   chkerr=1;
	   }
	   else
	   {
			document.getElementById('errf22').innerHTML='';
	   }  
	   
	  /* if(document.getElementById('Studentabsent_date15').value=="")
	   {
		   document.getElementById('errf33').innerHTML='Month cannot be blank.';
		   chkerr=1;
	   }
	   else
	   {
			document.getElementById('errf33').innerHTML='';
	   }
	 */  
	   // sattendance1
	   if(chkerr==0)
	   {
		   $('#totalstudentattendence3').empty();
		   $("#loader2").show();
            $.ajax({
                type: "POST",
                url: "ajaxphp/newstudentattend1.php",
                data: {courseid: $('#Studentabsent_courseid3 option:selected').val(), batchid: $('#Studentabsent_batchid3 option:selected').val(), fromdate: $('#fromdate3').val(),todate: $('#todate3').val()},
                dataType: "html",
                success: function (data) {
                    $('#totalstudentattendence3').append(data);
                    $('#attendancediv').show("slow");
					$("#loader2").hide();
                }
        	});
	   }
	   else
	   {
		   //return false; 
	   }				
}</script>
<script>
$(function(){
  
    $('#joindate').datepicker({
        format: 'dd-mm-yyyy',
        endDate: '+0m',
        autoclose: true,
        maxDate: moment()
    });
    
    $('#fromdate').datepicker({
        format: 'dd-mm-yyyy',
        endDate: '+0m',
        autoclose: true,
        maxDate: moment()
    });

     $('#todate').datepicker({
        format: 'dd-mm-yyyy',
        endDate: '+0m',
        autoclose: true,
        maxDate: moment()
    });
});
</script>
<script>
	function PrintTable() {
		var divToPrint = document.getElementById('formate');
		var popupWin = window.open('', '_blank');
		popupWin.document.open();
		popupWin.document.write('<html><head><link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css"><style>.btn-toolbar { display:none; } </style></head><body onload="window.print()"><div class="container"><table class="table table-bordered" style="font-size:11px;"><button class="btn btn-default csv" id="print" style="display: none;">Print</button>' + divToPrint.innerHTML + '</table></div></body></html>');
		popupWin.document.close();
	}
</script>

<script>
	$(".form-control").attr("autocomplete", "off");
</script>

<script>

function getAbsentDetailsOfAStudent(stname,stid,fromdate,toadte){
	$.ajax({
		type: "POST",
		url: "ajaxphp/getabsentdetailsofstudent.php",
		data: {stname: stname, admno: stid, fromdate: fromdate,todate: toadte},
		dataType: "json",
		success: function (data) {
			//alert(data);
			//console.log(data);
		}
	});
}

</script>

<script>
$('.reset').on('click', function(){ 
    var answer = confirm("Are you sure?")
  if (answer) {
    $('#studentattendence tbody').empty();
            $.ajax({
                type: "POST",
                url: "ajaxphp/sattendance.php",
                data: {courseid: $('#Studentabsent_courseid option:selected').val(), batchid: $('#Studentabsent_batchid option:selected').val(), joindate: $('#joindate').val(),reset:1},
                dataType: "html",
                success: function (data) {
                    $('#studentattendence tbody').append(data);
                    $('#attendancediv').show("slow");
                }
        	});
      }
	else {
		return false;
	}
       
 });
function showlist6(){
//alert('here');	
	   var chkerr=0;
	   var inpfocus=0;
	   
	   if(document.getElementById('Studentabsent_courseid6').value==""){
		   document.getElementById('errf6').innerHTML='Class cannot be blank.';
		   chkerr=1;
	   }else {
			document.getElementById('errf6').innerHTML='';
	   }
	   
	   if(document.getElementById('Studentabsent_batchid6').value==""){
		   document.getElementById('errf7').innerHTML='Section cannot be blank.';
		   chkerr=1;
	   }else{
			document.getElementById('errf7').innerHTML='';
	   }  
	   
	   if(document.getElementById('joindate6').value==""){
		   document.getElementById('errf8').innerHTML='Date cannot be blank.';
		   chkerr=1;
	   }else{
			document.getElementById('errf8').innerHTML='';
	   }
	   
	   if(chkerr==0){
		   $('#studentattendence6 tbody').empty();
		   $("#loader6").show();
            $.ajax({
                type: "POST",
                url: "ajaxphp/sentabsent.php",
                data: {courseid: $('#Studentabsent_courseid6 option:selected').val(), batchid: $('#Studentabsent_batchid6 option:selected').val(), joindate: $('#joindate6').val()},
                dataType: "html",
                success: function (data) {
                    $('#studentattendence6 tbody').append(data);
                    $('#sentabsentdiv').show("slow");
					$("#loader6").hide();
                }
        	});
	   }
	   else{
		   //return false; 
	   }	
		   
}

function showlist7(){		 
	   var chkerr=0;
	   var inpfocus=0;
	   
	   if(document.getElementById('Studentabsent_courseid7').value==""){
		   document.getElementById('errf9').innerHTML='Class cannot be blank.';
		   chkerr=1;
	   }else {
			document.getElementById('errf9').innerHTML='';
	   }
	   
	   if(document.getElementById('Studentabsent_batchid7').value==""){
		   document.getElementById('errf10').innerHTML='Section cannot be blank.';
		   chkerr=1;
	   }else{
			document.getElementById('errf10').innerHTML='';
	   }  
	    if(document.getElementById('wrongsms_date').value==""){
		   document.getElementById('errf72').innerHTML='Date cannot be blank.';
		   chkerr=1;
	   }else{
			document.getElementById('errf72').innerHTML='';
	   }
	  
	   
	   if(chkerr==0){
		   $('#studentattendence7 tbody').empty();
		   $("#loader7").show();
            $.ajax({
                type: "POST",
                url: "ajaxphp/sms_sentabsent.php",
                data: {courseid: $('#Studentabsent_courseid7 option:selected').val(), batchid: $('#Studentabsent_batchid7 option:selected').val(),wrongsms_date: $('#wrongsms_date').val()},
                dataType: "html",
                success: function (data) {
                    $('#studentattendence7 tbody').append(data);
					 
                    $('#sms_sentabsentdiv').show("slow");
					$("#loader7").hide();
                }
        	});
	   }
	   else{
		   //return false; 
	   }	
		   
}
function showlist8(){		
	   var chkerr=0;
	   var inpfocus=0;
	   
	   if(document.getElementById('Studentabsent_courseid8').value==""){
		   document.getElementById('err11').innerHTML='Class cannot be blank.';
		   chkerr=1;
	   }else {
			document.getElementById('err11').innerHTML='';
	   }
	   
	   if(document.getElementById('Studentabsent_batchid8').value==""){
		   document.getElementById('err12').innerHTML='Section cannot be blank.';
		   chkerr=1;
	   }else{
			document.getElementById('err12').innerHTML='';
	   }  
	   
	  
	   
	   if(chkerr==0){
		   $('#studentattendence8 tbody').empty();
		   $("#loader8").show();
            $.ajax({
                type: "POST",
                url: "ajaxphp/sms_sentabsent.php",
                data: {courseid: $('#Studentabsent_courseid8 option:selected').val(), batchid: $('#Studentabsent_batchid8 option:selected').val(),type:1,wrongsms_date: $('#wrongsms_date').val()},
                dataType: "html",
                success: function (data) {
                    $('#studentattendence8 tbody').append(data);
					 
                    $('#sms_sentabsentdiv1').show("slow");
					$("#loader8").hide();
                }
        	});
	   }
	   else{
		   //return false; 
	   }	
		   
}
</script>


</body>
</html>
<?php 
  unset($_SESSION["pre"]);
  unset($_SESSION["abs"]);
?>