<?php

namespace App\Eloquents;

interface AuthEloquent
{
    /**
     * Đăng ký user mới.
     *
     * @param array $data
     * @return mixed
     */
    public function register(array $data);

    /**
     * Đăng nhập user.
     *
     * @param array $credentials
     * @return string|false
     */
    public function login(array $credentials);

    /**
     * Cập nhật thông tin user.
     *
     * @param array $array
     * @return mixed
     */
    public function update(array $array);
}
