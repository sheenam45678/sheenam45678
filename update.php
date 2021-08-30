<?php
  include('config.php');
// include_once('header.php');
  $id=$_GET['id'];
 ?>
 <head>
 	<style>
 	.img{
 	  background: url('jpg/slide.jpg');
 	  background-size: cover ;
 	 
 		height: 88vh;
 	}
 	.form1{
 		text-align: center;
 		
 	background-color: #73cbd9;
 		width: 461px;
 		height: 60vh;
 		border-radius: 20px;
 		border: 2px solid cornflowerblue;
 		padding-top: 70px;
 		margin-top: 170px;
 		position: absolute;


 	}
 	label{
 		color: white;font-size: 20px;

 	}
	 #a
     {
     	height: 37px;
    background-color: #6f8285;
    width: 300px;
    padding: 14px 12px;
    border-radius: 30px;
    border: 1px solid #ddd;
    margin-bottom: 15px;
    outline: none;
    box-shadow: 0px 0px 42px #d4d4d4;}
   
    form input[type=textarea] {
    width: 300px;
    height: 37px;
     background-color: #6f8285;
    padding: 14px 12px;
    border-radius: 30px;
    border: 1px solid #ddd;
    margin-bottom: 15px;
    outline: none;
    box-shadow: 0px 0px 42px #d4d4d4;}
     form input[type=date] {
    width: 300px;
    height: 37px;
     background-color: #6f8285;
    padding: 14px 12px;
    border-radius: 30px;
    border: 1px solid #ddd;
    margin-bottom: 15px;
    outline: none;
    box-shadow: 0px 0px 42px #d4d4d4;
      }
   
    #submit
    {
   width: 150px;
    background-color: #6f8285;
   
   
    padding: 10px 15px 10px 15px;
    color: white;
    font-size:20px;
    font-weight: 20px;
    border: none;
    border-radius: 10px;

}
#submit:hover{
    background: purple;
}
#status{
    font-size: 30px;
    border-radius: 10px;
   background-color: #6f8285;
    color: white;
    border: none;
    }
    #status:hover{
background-color: purple;
    }
</style></head>

<body>  

<?php
// define variables and set to empty values
 $nameerr = $deserr = $dateerr = $enderr=$commentErr = $sterror = "";
 $project_name=$description = $start_date = $end_date = $status= $pro_na= $pro_id=$row_id="";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["project_name"]))
    {
        $nameerr = "Name is required";
    } 
    else 
    {
        $project_name = test_input($_POST["project_name"]);
    // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$project_name)) 
        {
          $nameerr = "Only letters and white space allowed";
        }
    }
    if (empty($_POST["desc"])) 
    {
        $deserr = "Description is required";
    } 
    else 
    {
        $description = test_input($_POST["desc"]);
    }
    
    if (empty($_POST["start_date"]))
    {
        $dateerr = "plz enter Date";
    } 
    else 
    {
        $start_date = test_input($_POST["start_date"]); 
         $start_date=date("Y-m-d", strtotime($start_date) );
    }
   if (empty($_POST["end_date"]))
        {
       $sterror = "plz enter Date";
        }
     else
      {
        $end_date = test_input($_POST["end_date"]);
         $end_date=date("Y-m-d", strtotime($end_date) );
      }
     if (empty($_POST["sel"]))
       {
       $enderr = "plz enter Date";
       }
    else
        {
        $status = test_input($_POST["sel"]);
        }
     

   

 
        $sql1="update project set project_name='$project_name', description='$description',start_date='$start_date',end_date='$end_date',status='$status' where id='$id'";
       
        
  $res=mysqli_query($conn,$sql1);
  print_r($res);
   if($res)
  {
     
     header('Location:dashboard.php?proshow');
  }
  else
  {
     echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
   
  }
  $sql2="update task set project_name='$project_name' where id='$id'";
 $res2=mysqli_query($conn,$sql2);
  print_r($res2);
   if($res2)
  {
     header('Location:dashboard.php?proshow');
       }
  else
  {
     echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
   
  }
  

}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<?php

$sql ="select * from project where id='$id'";
$result= mysqli_query($conn,$sql);
 while($rows=mysqli_fetch_assoc($result))
  {
  	$pro_id =$rows['id'];
  	$proj_name=$rows['project_name'];
  	$pro_descr=$rows['description'];
  	$pro_st_date=$rows['start_date'];
  	$pro_end_date=$rows['end_date'];
  	$pro_status=$rows['status'];
   }
?>


<div class="img">
    <div class="form1">
<form method="post" action=""> 

<label > P_Name</label> 
    <input type="text" name="project_name" id="a" value="<?php echo $proj_name;?>"><br>
  
 <label> description:</label> <input type=textarea col="50" rows="30" name="desc" value="<?php echo $pro_descr;?>">
  <span class="error">* <?php echo $deserr;?></span>
  <br>
 <label> start_date:</label> <input type="date" name="start_date" value="<?php echo $pro_st_date;?>">
  <span class="error"><?php echo $dateerr;?></span>
  <br>
  <label> end_date:</label> <input type="date" name="end_date" value="<?php echo $pro_end_date;?>">
  <span class="error"><?php echo $enderr;?></span>
  <br>
  
   
   <select name="sel" id="status">status
      <option>status</option> 
      <option <?php if($pro_status=="pending"){echo "selected";} ?>  value="pending">pending</option>
      <option <?php if($pro_status=="complete"){echo "selected";} ?> value="complete">complete</option>
  
</select><br><br>

 
  <input type="submit" name="submit" value="Submit" id="submit">  
</form>

</div>
</div>

</body>
</html>