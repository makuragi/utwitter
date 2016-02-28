<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        うついったー
    </title>
    <?php
        echo $this->Html->meta('icon');
 
        echo $this->Html->css('bootstrap.min.css');
 		echo $this->Html->css('style.css');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
     
    <style>
        body {
          padding-top: 70px;
        }
    </style>
</head>
<body>
      
    <?php echo $this->element('navigation');?>
   
    <div class="container">
      <?php echo $this->Session->flash(); ?>
 
      <?php echo $this->fetch('content'); ?>
      <hr>
      <footer class="text-center">
        <p>developed by @makuragi.com</p>
      </footer>
    </div> <!-- /container -->
       
     
     
     
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php echo $this->Html->script('jquery-1.12.0'); ?>
    <?php echo $this->Html->script('bootstrap.min'); ?>
    <?php echo $this->Html->script('script'); ?>
</body>
</html>
