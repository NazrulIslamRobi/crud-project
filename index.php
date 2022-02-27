<?php require_once('inc/functions.php'); 

$info = '';
$task = $_GET['task'] ?? 'report';

if("seed" == $task){
    seed();
    $info = "seeding is complete";
}

$error = 0;

if(isset($_POST['submit'])){

  if($_POST['name'] != '' && $_POST['roll'] != '' && $_POST['department'] != ''){


    $name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
    $roll = filter_input(INPUT_POST,'roll',FILTER_SANITIZE_STRING);
    $department = filter_input(INPUT_POST,'department',FILTER_SANITIZE_STRING);
    
   $result = studentAdd($name,$roll,$department);

   if(!$result){
      $error = 1;
   }else{
    header("location:/?task=report"); 
   }

  }
 
}


if('edit' == $task && !empty($_GET['id'])){

    $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);

    $getEditingStudent = getStudent($id);
   
  }


  if(isset($_POST['update'])){

    if($_POST['name'] != '' && $_POST['roll'] != '' && $_POST['department'] != '' && !empty($_POST['id'])){
      
      // echo "<pre>";
      // print_r($_POST);
      // echo "<pre>";
      // die;
      $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING);
      $name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
      $roll = filter_input(INPUT_POST,'roll',FILTER_SANITIZE_STRING);
      $department = filter_input(INPUT_POST,'department',FILTER_SANITIZE_STRING);
      
     $result = studentUpdate($name,$roll,$department,$id);
  
     if(!$result){

        $error = 1;

     }else{

      header("location:/?task=report"); 

     }
  
    }
   
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="public/bootstrap5/css/bootstrap.min.css">

</head>
<body>
    

    <div class="container">
        <div class="row">
          <div class="col-md-6 m-auto">
            <h2>CRUD Project</h2>
            <p>We can use this project to store students information in a plane text file.</p>

            <?php include_once('inc/templates/nav.php')?>
            <hr>
          <?php if($info != ''){

              echo "<p> $info </p>";
          }?>
        </div>
          </div>

          <?php if($error == 1):?>

             <p class="text-center text-danger"> Duplicate Roll number</p>

          <?php endif; ?>

          <?php if('report'==$task): ?>
          <div class="row">
              <div class="col-md-12">
               <?php generateReport(); ?>
              </div>
          </div>
        <?php endif; ?>

       
          <?php if('add' == $task): ?>
          <div class="row">

              <div class="col-md-6 offset-md-3">
          <form action="/?task=add" method="POST">
          <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="" value="<?= !empty($_POST['name']) ? $_POST['name'] : '' ?>"><br>
              </div>

              <div class="form-group">
                <label for="roll">Roll</label>
                <input type="text" class="form-control" name="roll" id="" value="<?= !empty($_POST['roll']) ? $_POST['roll'] : ''  ?>"><br>
              </div>

              <div class="form-group">
                <label for="department">Department</label>br
                <input type="text" class="form-control" name="department" id="" value="<?= !empty($_POST['department']) ? $_POST['department'] : ''  ?>"><br>
              </div>

              <button type="submit" class="btn btn-primary" name="submit">Submit</button>
          </form>

              </div>
          </div>
        <?php endif; ?>

          <?php if('edit' == $task && !empty($_GET['id'])): ?>
          <div class="row">

              <div class="col-md-6 offset-md-3">
          <form action="/?task=add" method="POST">
          <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="" value="<?= $getEditingStudent['name'] ?>"><br>
              </div>

              <div class="form-group">
                <label for="roll">Roll</label>
                <input type="text" class="form-control" name="roll" id="" value="<?= $getEditingStudent['roll'] ?>"><br>
              </div>

              <div class="form-group">
                <label for="department">Department</label>br
                <input type="text" class="form-control" name="department" id="" value="<?= $getEditingStudent['department'] ?>"><br>
              </div>
              <input type="hidden" name="id" value="<?= $getEditingStudent['id'] ?>">
              <button type="submit" class="btn btn-primary" name="update">Update</button>
          </form>

              </div>
          </div>
        <?php endif; ?>

    </div>

<script src="public/bootstrap5/js/bootstrap.min.js"></script>
</body>
</html>