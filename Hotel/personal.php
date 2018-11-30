<?php
  session_start();
  if(!isset($_SESSION['guest'])){
     header('Location: login.php');
    exit();
  }
 

   
    include 'database.php';
     $id = $_SESSION['ID'] ; 
    
    $stmt = $conn->prepare('select id,name,phone,startdate,enddate,enddate - startdate as days, number, type , price   from guest inner join room on guest.num =room.number  where guest.id = ? limit 1;');

    $stmt->execute(array($id ));
    $row = $stmt->fetch();
    
    $stmt1 = $conn->prepare('select  * from orders  where gid = ?;');
    $stmt1->execute(array($id ));
    $orders = $stmt1->fetchAll();

    $stmt2 = $conn->prepare('select ((enddate - startdate) * room.price) + sum(orders.price) as total from guest ,room ,orders  where id= ? and num =number and  id =gid ;');
    $stmt2->execute(array($id ));
    $total = $stmt2->fetch();



  
?>

<!DOCTYPE html>
<html>
<head>
	<title>Hotel</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	 <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/style.media.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
      <ul class="nav ">
        <li class="nav-item">
         <div class="pull-left icon  ">
           <i class="fa fa-caret-down btn" id="dropdownMenu1" data-toggle="dropdown"></i>
            <ul class="dropdown-menu" id="setting-logout" aria-labelledby="dropdownMenu1;" >
              <!-- <li><a href="setting.html"><i class="fa fa-cog"></i>Setting</a></li> -->
              <li><a href="logout.php"><i class="fa fa-sign-out"></i>Sign out</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="navbar-brand" href="#">Hotel</a>      
        </li> 
      </ul>
 
        
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="personal.php">Bill<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="orders.php">Restaurant</a>
          </li>
          
          <?php if(isset($_SESSION['admin'])){?>     

          <li class="nav-item">
            <a class="nav-link" href="guests.php">Guests</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="available.php">Available Rooms</a>
          </li>
        <?php } ?>
        </ul>
      </div>
    </nav>	


	<!-- Start setting form --> 
  <div class="container">
  <div class="setting-body">
    <div class="setting">
      <h2 class="setting-title">Guest Information !</h2>
      <section class="setting clearfix">
          <span class="span1  pull-left">
           Guest Name 
          </span> 
          <span class="span2 pull-left">
            <span id="oldname"><?php echo $row['name'];?></span>
            
      </section>

      <section class="setting clearfix">
          <span class="span1  pull-left">
              Room Number
              </span> 
              <span class="span2 pull-left">
                <span id="oldemail"><?php echo $row['number'];?></span>
                </span>             
      </section>

      <section class="setting clearfix">
          <span class="span1  pull-left">
           Room type
          </span> 
          <span class="span2 pull-left">
            <span id="oldphone"><?php echo $row['type'];?></span>
        </span>
      </section>

      <section class="setting clearfix">
              <span class="span1  pull-left">Phone Number</span> 
              <span class="span2 pull-left">
                <span id="oldpassword"><?php echo $row['phone'];?></span>
            </span>
      
      </section>
      <section class="setting clearfix">
              <span class="span1  pull-left">Start Date</span> 
              <span class="span2 pull-left">
                <span id="oldpassword"><?php echo $row['startdate'];?></span>
            </span>
      
      </section>
      <section class="setting clearfix">
              <span class="span1  pull-left">End Date</span> 
              <span class="span2 pull-left">
                <span id="oldpassword"><?php echo $row['enddate'];?></span>
            </span>
      
      </section>
      <section class="setting clearfix">
              <span class="span1  pull-left">Price Room for day  </span> 
              <span class="span2 pull-left">
                <span id="oldpassword"><?php echo $row['price'];?></span>
            </span>
      
      </section>
       <section class="setting clearfix">
              <span class="span1  pull-left">Number Of Day</span> 
              <span class="span2 pull-left">
                <span id="oldpassword"><?php echo $row['days'];?>days</span>
            </span>
      
      </section>
      <section class="setting clearfix">
              <span class="span1  pull-left"><h3>Total bill is :</h3></span> 
              <span class="span2 pull-left">
                <span id="oldpassword"><?php 
                if( $total['total'] ==null)
                  echo $row['price'] * $row['days'];
                else
                  echo $total['total'] ;?>$</span>
            </span>
      
      </section>
    </div>
  </div>
  </div>
  <h1 style="margin-top:15px;margin-bottom: 0px;text-align: center;">Orders</h1>
  <div class="container home"  >
    <div class="row">
      <?php foreach ($orders as $order) {?>
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="home-card">
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td>Order Name</td>
                      <td><?php echo $order['ordername'];?></td>
                    </tr>
                    <tr>
                      <td>Price</td>
                      <td>
                        <?php echo $order['price'];?>$
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>            
          </div>
        <?php } ?>
      </div>
    </div>
	<!-- End setting form -->
	<!-- 		start footer   -->
        <div class="container-fluid footer-body " style="margin-top: 0px;">
        <div class="footer" >

        <span>Copyright &copy; 2018 Ahmed Marey.</span>
        <ul>
            <li><a href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="https://www.facebook.com" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a href="https://www.facebook.com" target="_blank"><i  class="fa fa-linkedin" aria-hidden="true" ></i></a></li>
            <li><a href="https://www.facebook.com" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
        </ul>	
        </div>
    </div>    
<!-- 		end footer   -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.2.1.min.js" ></script>
    <script src="js/popper.min.js" ></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/backend.js"></script>
    <script src="js/setting.js"></script>

   
</body>
</html>