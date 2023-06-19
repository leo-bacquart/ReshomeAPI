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
}