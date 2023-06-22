<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model\Manager\UserManager;

class UserController extends BaseController
{

    public function getLoggedUser(): void
    {
        $auth = new AuthController();
        $user = $auth->verifyJwt();
        if ($user) {
            header('Content-Type: application/json');
            echo json_encode([
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
                'phone_number' => $user->getPhoneNumber(),
                'address' => $user->getAddress(),
                'post_code' => $user->getPostCode(),
                'city' => $user->getCity(),
                'country' => $user->getCountry(),
                'is_staff' => $user->getIsStaff(),
                'is_admin' => $user->getIsAdmin(),
                'is_logistic' => $user->getIsLogistic()
            ]);
        }
        else {
            echo json_encode(['message' => 'Invalid or missing Token']);
        }
    }

    public function getUserDetails($userId)
    {
        $auth = new AuthController();
        $user = $auth->verifyJwt();

        if ($user->getIsAdmin() || $user->getIsStaff()) {
            $manager = new UserManager();
            header('Content-Type: application/json');
            if ($manager->getUserById($userId)) {
                echo json_encode($manager->getUserById($userId)->jsonSerialize());
                return;
            }
            echo json_encode(['message' => 'Error : User not found']);
        } else {
            echo json_encode(['message' => 'Error : You cannot access this data']);
        }
    }

    public function getAllUsers() : void
    {
        $page = intval($_GET['page']);

        if (!$page) {
            $page = 1;
        }

        $manager = new UserManager();
        $users = $manager->getUserPage($page);
        $data = [];

        foreach ($users as $user) {
            $data[] = $user->jsonSerialize();
        }

        header('Content-Type: application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(['message' => 'Error : no values in this page']);
        }
    }

    public function deleteUser() : void
    {
        $userId = intval($_GET['id']);

        $auth = new AuthController();
        $user = $auth->verifyJwt();

        if(!$user){
            echo json_encode(['error' => 'User not logged']);
            return;
        }

        if(!$user->getIsAdmin()){
            echo json_encode(['error' => 'You are not authorized to delete accounts']);
            return;
        }

        $userManager = new UserManager();
        $userManager->deleteUser($userId);

        echo json_encode(['message' => 'User deleted successfully']);

    }
}