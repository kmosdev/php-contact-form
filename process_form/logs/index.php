 <!DOCTYPE html>

  <head>

    <link rel="stylesheet" type="text/css" href="style.css" />

    <title>Form Submission Logs</title>

  </head>

  <body>

<?php

/*

* Minimum security check

*/

$password = '';



if(isset($_GET['pass'])) {

  $password = $_GET['pass'];

}

if($password == 'changeme'):



  require_once('../class.maillog.php');



  /*

  * Get all records

  */

  $log = new MailLog();

  $records = $log->getRecords();

  ?>

  <h1>Form Submission Results</h1>

  <?php if(is_object($records)):?> 
 
  <table>

    <?php

    $x = 0;
    /*
    * This needs to be changed to get fields from the config file
    */
    foreach($records as $r) { ?>
      <tr>

        <td><?php echo $r['name']; ?></td>

        <td><?php echo $r['email']; ?></td>

        <td><?php echo $r['phone']; ?></td>

        <td><?php echo $r['tour']; ?></td>

        <td><?php echo $r['consultation']; ?></td>

        <td><?php echo $r['referrer']; ?></td>

        <td><?php echo date('m/d/Y h:i a',$r['time']); ?></td>

      </tr>

    <?php

    $x++;

    }

    ?>

  </table>

  <h3>Total: <?php echo $x; ?></h3>

  <?php else: ?>

  <p>No Results</p>

  <?php endif; ?>

  <?php

  /*

  * Close connection

  */

  $log->close();



else:

  echo 'Sorry. You do not have permission to view this page.';

endif; 

  ?>

</body>

</html>