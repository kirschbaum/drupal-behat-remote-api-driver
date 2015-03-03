<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Api;


class User extends BaseDrupalRemoteAPI {

    public function userCreate(\stdClass $user) {
        $response = $this->post('/drupal-remote-api/users/create', get_object_vars($user));
        $this->confirmResponseStatusCodeIs200($response);
        $user->uid = $response['data'];
        return $user;
    }

    public function userAddRole(\stdClass $user, $role_name) {
        $data['uid'] = $user->uid;
        $data['role_name'] = $role_name;
        $response = $this->post('/drupal-remote-api/users/addrole', $data);
        $this->confirmResponseStatusCodeIs200($response);
        return $response;
    }

    public function userDelete(\stdClass $user) {
        // Not confirming status code here because restws does not return one.
        return $this->delete('/user/'.$user->uid);
    }

    public function getUserIDbyAuthorName($value)
    {
        $response = $this->get('/user.json?name=' . trim($value));
        $this->confirmRestWSFilterResponse($response);
        return $user_id = $response['list'][0]['uid'];
    }

}