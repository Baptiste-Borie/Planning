<?php
class UserController
{
    private $userManager;
    private $db;

    private $eventCollection;



    public function __construct($db)
    {
        require_once('./Model/User.php');
        require_once('./Model/UserManager.php');
        $this->userManager = new UserManager($db);
        $this->db = $db;
        $this->eventCollection = "Planning.event";
    }

    public function home(): void
    {
        require('./View/default.php');
    }

    public function login()
    {
        $page = 'login';
        require('./View/default.php');
    }

    public function logout(): void
    {
        $_SESSION['user_id'] = null;
        $_SESSION['user_last_name'] = null;
        $_SESSION['admin'] = null;
        require('./View/default.php');
    }

    public function doLogin()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $result = $this->userManager->findByEmail($email);
        var_dump($result);

        if ($result && password_verify($password, $result->getPassword())) {
            $info = "Connexion réussie";
            $_SESSION['user_id'] = $result->getId();
            $_SESSION['user_last_name'] = $result->getLastName();
        } else {
            $info = "Identifiants incorrects.";
            $page = 'login';
        }

        require('./View/default.php');
    }

    public function create()
    {
        $page = 'form';
        require('./View/default.php');
    }

    public function doCreate()
    {
        $alreadyExist = $this->userManager->findByEmail($_POST['email']);
        if (!$alreadyExist) {
            $newUser = new User($_POST);
            $this->userManager->create($newUser);
        } else {
            $error = "ERROR : This email (" . $_POST['email'] . ") is used by another user";
        }
        require('./View/default.php');
    }

    public function usersList()
    {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $user = $this->userManager->findOne($userId);
            $_SESSION['user_last_name'] = $user->getLastName();
            if (!$user->getAdmin()) {
                $page = "unauthorized";
            } else {
                $users = $this->userManager->findAll();
                $page = "userList";
            }
        } else {
            $page = "unauthorized";
        }
        require('./View/default.php');
    }

    public function modif()
    {
        $page = 'form';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $user = $this->userManager->findOne($id);
            $_SESSION['modif'] = true;
        }
        require('./View/default.php');
    }

    public function doModif()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            die("User ID not provided.");
        }

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $lastName = htmlspecialchars($_POST['lastName']);
        $firstName = htmlspecialchars($_POST['firstName']);
        $password = htmlspecialchars($_POST['password']);

        $user = $this->userManager->findOne($id);

        /*        $user->getEmail() = $email;
        $user->getLastName() = $lastName;
        $user->getFirstName() = $firstName; */
        $user->setEmail($email);
        $user->setLastName($lastName);
        $user->setFirstName($firstName);
        if (!empty($password)) {
            $passsword_hash = password_hash($password, PASSWORD_BCRYPT);
            $user->setPassword($passsword_hash);
        }

        $this->userManager->update($user);

        $_SESSION['modif'] = false;
        header("Location: index.php?ctrl=user&action=usersList");
        exit();
    }

    public function suppress()
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $this->userManager->delete($id);
            header('Location: ./index.php?ctrl=user&action=usersList');
            exit();
        } else {
            echo "ID invalide ou non défini.";
        }
    }

    public function planning()
    {
        // Requête pour récupérer tous les événements
        $query = new MongoDB\Driver\Query([]); // Filtre vide pour récupérer tout
        $cursor = $this->db->executeQuery($this->eventCollection, $query);

        // Convertir les événements en tableau PHP
        $events = [];
        foreach ($cursor as $event) {
            $events[] = $event;
        }

        $userManager = $this->userManager;
        $page = "planning";
        require('./View/default.php');
    }
}
