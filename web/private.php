<?php

session_start();

  $pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');
  $u_id = $_SESSION['userid'];

  if ($u_id == 53) {

$fieldLabels = [
  'id' => 'ID',
  'email' => 'Email',
  'vorname' => 'Vorname',
  'nachname' => 'Nachname',
  'info' => 'Info'
];

$db = new PDO('mysql:host=localhost;dbname=stepbystep;charset=utf8', 'root', '');

$sql = "
    SELECT " . implode(', ', array_keys($fieldLabels)) . " FROM info";

$customers = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kundentabelle</title>
    <link rel="stylesheet" type="text/css" href="theme.css">
</head>
<body>
<table>
    <thead>
    <tr>
      <?php foreach ($fieldLabels as $label): ?>
          <th>
            <?= htmlspecialchars($label, ENT_COMPAT, 'UTF-8'); ?>
          </th>
      <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($customers as $customer): ?>
        <tr>
          <?php foreach ($customer as $fieldValue): ?>
              <td>
                <?= htmlspecialchars($fieldValue, ENT_COMPAT, 'UTF-8') ?>
              </td>
          <?php endforeach; ?>
            <td>
              <?php
              echo '<form method="post" action="delete.php">
                                <input type="hidden" name="id" value="'.$customer['id'].'">
                                <input type="submit" value="DELETE">
                              </form>';
              print_r($customer['id']);
              if (!$customer['id'] && !empty($_SESSION['customer_ids']) && !in_array($customer['id'], $_SESSION['customer_ids'])) {
                $_SESSION['customer_ids'][] = $customer['id'];
              }
              ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
<?php
    if (isset($_POST['text'])) {
      $statement = $pdo->prepare("SELECT email, nachname, vorname, info FROM info");
      $result = $statement->execute();
    }
?>
<?php

  } elseif ($u_id != 53) {
    $fieldLabels = [
      'id' => 'ID',
      'email' => 'Email',
      'vorname' => 'Vorname',
      'nachname' => 'Nachname',
      'info' => 'Info',
    ];

    $db = new PDO('mysql:host=localhost;dbname=stepbystep;charset=utf8', 'root', '');

    $sql = "SELECT " . implode(', ', array_keys($fieldLabels)) . " FROM info WHERE u_id = $u_id ";

    $customers = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: text/html; charset=utf-8');
    ?>
      <!DOCTYPE html>
      <html>
      <head>
          <title>Kundentabelle</title>
          <link rel="stylesheet" type="text/css" href="theme.css">
      </head>
      <body>
      <table border="1">
          <tbody>
          <?php foreach ($customers as $customer): ?>
              <tr>
                <?php foreach ($customer as $fieldValue): ?>
                    <td>
                      <?= htmlspecialchars($fieldValue, ENT_COMPAT, 'UTF-8')?>
                    </td>
                <?php endforeach; ?>
                    <td><?php
                        echo '<form method="post" action="delete.php">
                                <input type="hidden" name="id" value="'.$customer['id'].'">
                                <input type="submit" value="DELETE">
                              </form>';
                      if (!$customer['id'] && !empty($_SESSION['customer_ids']) && !in_array($customer['id'], $_SESSION['customer_ids'])) {
                        $_SESSION['customer_ids'][] = $customer['id'];
                      }
                    ?></td>
              </tr>
          <?php endforeach; ?>
          </tbody>
          <thead>
          <tr>
            <?php foreach ($fieldLabels as $label): ?>
                <th>
                  <?= htmlspecialchars($label, ENT_COMPAT, 'UTF-8'); ?>
                </th>
            <?php endforeach; ?>
          </tr>
          </thead>
      </table>
      </body>
      </html>
    <?php
    if (isset($_POST['text'])) {
      $statement = $pdo->prepare("SELECT email, nachname, vorname, info FROM info WHERE u_id = $u_id ");
      $result = $statement->execute();
    }
  }

echo '<a href="logout.php">     LOGOUT     </a><br>';
echo '<a href="addentry.php">     ADD ENTRY     </a><br>';