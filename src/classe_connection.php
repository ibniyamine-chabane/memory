<?php

class Userpdo 
{

    //ATTRIBUTS
    private $id;
    public  $login;
    public $database;
    public $data;


    //CONSTRUCTEUR
    public function __construct() {
        session_start();

        try {
            $this->database = new PDO('mysql:host=localhost;dbname=memory;charset=utf8;port=3307', 'root', '');
        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        
        $request = $this->database->prepare('SELECT * FROM utilisateurs');
        $request->execute(array());
        $data = $this->data;
        $this->data = $request->fetchAll();
        echo "<h1 style='color:red;font-family:monospace;font-size:30px;text-align:center'>
        la classe Userpdo a été instancié, message depuis le contructeur</h1>";
        //var_dump($this->data);
    }
    
    //MÉTHODES 
    public function register($login, $password, $password_confirm) {
        $this->login =      $login;
        //$login = $_POST['login'];
        $password;
        $password_confirm;
        $loginOk = false;

        if ($password == $password_confirm) {
            $loginOk = false;
        
            foreach ( $this->data as $user ) { 
                            
            //une condition dans le cas ou le login existe déjà 
            if ( $this->login == $user[1] ) { 

                echo "le login est déja pris</br>";                
                $loginOk = false;
                break;
            } else {
                $loginOk = true;
            }

        }

        if ( $loginOk ) {          
            $request = $this->database->prepare("INSERT INTO utilisateurs(login, password) VALUES (?, ?)");
            $request->execute(array($this->login, $password));
            echo "utilisateur crée avec succès!";
            
        } 

        } else {
            echo "le mot de passe de confirmation n'est pas identique!";
        } 
        
    }

    public function connect($login, $password) {

        $this->login = $login;
        $password;
        $logged = false;

        foreach ($this->data as $user) { //je lis le contenu de la table $con de la BDD

            if ($login === $user[1] && $password === $user[2]) {                         
                $_SESSION['login'] = $login;
                $logged = true;
                break;

            } else {
                $logged = false;
            }

        }

        if( $logged ) {
            echo "vous êtes connecté";
            header("Location:./index.php");
        } else {
            echo "erreur dans le mdp ou login</br>";
        }

        
    }

    public function disconnect() {

        session_destroy();
        echo "vous êtes déconnecté";
        
    }

    public function delete() {

        if (!empty($_SESSION['login'])) {

            $this->login = $_SESSION['login'];
            $request = $this->database->prepare("DELETE FROM `utilisateurs` WHERE `login` = (?)");
            $request->execute(array($this->login));
            echo "votre compte a été supprimé";
            session_destroy();

        }
    
    }

    public function update($login, $password) {

       /* if (!empty($_SESSION['login'])) {

            $this->login =      $login;
            $password;
            $logged_user = $_SESSION['login'];

            $request = $this->database->prepare("UPDATE `utilisateurs` SET `login` = (?) , `password` = (?) , `email` = (?) , 
            `firstname` = (?) , `lastname` = (?) WHERE `utilisateurs`.`login` = (?)");

            $request->execute(array($this->login, $password, $this->email, $this->firstname, $this->lastname, $logged_user));
            $_SESSION['login'] = $this->login;

        } else {
            echo "Acces interdit";
        }*/

        foreach ($this->database as $user_login_db) {
                    
            $user_password_db = $user_login_db[1];
            $user_login_ok = false;
                  // condition pour changer le login avec validation du mdp actuel 
            if ( $filled == $user_login_db[0] && !empty($new_login) && 
            $current_password == $user_password_db ) {

                $update = "UPDATE `utilisateurs` SET `login` = '$new_login'  WHERE `utilisateurs`.`login` = '$filled'";
                $request_change_password = $connectDatabase->query($update);
                $message = "Succes !!";
                $_SESSION['login'] = $new_login;
                header("Location:profil.php");

            } else {
                $message = "erreur sur le mot de passe actuel";
            }    
                // condition si le login existe déjà dans la bdd
            if ( $new_login == $user_login_db[0] && $new_login != $filled ) {
                $message = "le login est déjà pris";
                break;
            } 
            
        }


    }

    public function isConnected() {
         
        if (isset($_SESSION['login'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllInfos() {

        $this->login = $_SESSION['login'];
        $request = $this->database->prepare("SELECT * FROM `utilisateurs` WHERE `login` = (?)");
        $request->execute(array($this->login));
        $this->data = $request->fetch();
        return $this->data;
        
    }

    public function getLogin() {

        $this->login = $_SESSION['login'];
        $request = $this->database->prepare("SELECT `login` FROM `utilisateurs` WHERE `login` = (?)");
        $request->execute(array($this->login));
        $this->data = $request->fetch();
        $this->login = $this->data['login'];
        return $this->login;
            
    }

    public function getEmail() {

        $this->login = $_SESSION['login'];
        $request = $this->database->prepare("SELECT `email` FROM `utilisateurs` WHERE `login` = (?)");
        $request->execute(array($this->login));
        $this->data = $request->fetch();
        $this->email = $this->data['email'];
        return $this->email;

    }

    public function getFirstname() {

        $this->login = $_SESSION['login'];
        $request = $this->database->prepare("SELECT `firstname` FROM `utilisateurs` WHERE `login` = (?)");
        $request->execute(array($this->login));
        $this->data = $request->fetch();
        $this->firstname = $this->data['firstname'];
        return $this->firstname;

    }

    public function getLastname() {

        $this->login = $_SESSION['login'];
        $sql = "SELECT `lastname` FROM `utilisateurs` WHERE `login` = '$this->login'";
        $request = $this->database->prepare("SELECT `lastname` FROM `utilisateurs` WHERE `login` = (?)");
        $request->execute(array($this->login));
        $this->data = $request->fetch();
        $this->lastname = $this->data['lastname'];
        return $this->lastname;
    }

}

//$utilisateur = new Userpdo;
//$utilisateur->register('zaft', 'system', 'gundam@rengou.com', 'Kira', 'Yamato');
//$utilisateur->connect('rengou','system');
//$utilisateur->disconnect();
//$utilisateur->delete();
//$utilisateur->update('rengou', 'system', 'gundam@faith.com', 'Kira', 'Yamato');
//$utilisateur->getAllInfos()['login'];
//$utilisateur->getLogin();
//$utilisateur->getEmail();
//$utilisateur->getFirstname();
//$utilisateur->getLastname();
//$utilisateur->isConnected();
//echo $_SESSION['login'];

?>