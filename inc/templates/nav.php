
<div>
    <div class="float-start">
        <p>
    <a href="/?task=report">All Students</a>
    <?php if(isEditor() || isAdmin()):?>
    
    |
        <a href="/?task=add">Add New Student</a>
        <?php endif; ?>
        
        <?php if(isAdmin()):?>
            |
            <a href="/?task=seed">Seed</a>
            
         <?php endif; ?>   
    </p>
    </div>
    <div class="float-end">
        <p>
            <?php if($_SESSION['loggedin'] == false):?>

                <a href="login.php">Login</a>

            <?php else:?>
                <a href="login.php?logout=true">Logout(<?= $_SESSION['role']?>)</a>
            <?php endif; ?>
        </p>
    </div>
</div>  


   
  
   