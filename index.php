<?php
/*
 * login.php - the simplest login
 * sqlite3 db
 * create table users (id integer primary key asc, user text unique, pass text);
 * insert into users (user, pass) values ('1234', '1234');
*/
$application = new Login();

class Login
{
  private $user_logged = false;

  public function __construct()
  {
    session_start();
    if (isset($_POST['logout'])) {
      session_destroy();
      $this->user_logged = false;
    } elseif (!empty($_SESSION['user']) && ($_SESSION['user_logged'])) {
      $this->user_logged = true;
    } elseif (isset($_POST["login"])) {
      if (!empty($_POST['user']) && !empty($_POST['pass'])) {
        $db = new PDO('sqlite:db');
        $sql = 'SELECT * FROM users WHERE user="'.$_POST['user'].'" AND pass="'.$_POST['pass'].'"';
        $result = $db->query($sql);
        if ($row = $result->fetchObject()){
          $_SESSION['user'] = $row->user;
          $_SESSION['user_logged'] = true;
          $this->user_logged = true;
        }
      }
    }
    if ($this->user_logged) {
      $this->LoggedForm();
    } else {
      $this->LoginForm();
    }
  }

  private function LoginForm()
  {
    ?>
    <html>
      <head>
        <title>LoginForm</title>
      </head>
      <body>
        <h2>Login.</h2>
        <form action="index.php" method="post">
          <table>
            <tr>
              <td><label for="user">User:</label></td>
              <td><input type="text" name="user" id="user" required/></td>
            </tr>
            <tr>
              <td><label for="pass">Pass:</label></td>
              <td><input type="password" name="pass" id="pass" required/></td>
            <tr>
              <td></td>
              <td><input type="submit" name="login" value="Submit"/></td>
            </tr>
          </table>
        </form>
        <?php
        if (!empty($_POST['user']) && !empty($_POST['pass']) && !$this->user_logged) {
          echo '<h3  style="color: red; font-weight: bold;">Login Failed!!!</h3>';
        }
        ?>
       </body>
    </html>
    <?php
  }

  private function LoggedForm()
  {
    ?>
    <html>
      <head>
        <title>LoggedForm</title>
      </head>
      <body>
        <h2>Home.</h2>
        <form action="index.php" method="post">
          <table>
            <tr>
              <td><label for="logout">Welcome: <?php echo $_SESSION['user'];?></label></td>
            </tr>
            <tr>
              <td align="center"><input type="submit" name="logout" id="logout" value="Logout"/></td>
            </tr>
          </table>
        </form>
       </body>
    </html>
    <?php
  }
}
?>
