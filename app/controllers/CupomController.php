<?php
require_once 'models/Coupon.php';

class CouponController {
    public function index() {
        $coupons = (new Coupon())->all();
        include 'views/coupons/index.php';
    }

    public function store() {
        $data = $_POST;
        (new Coupon())->create($data);
        header('Location: /coupons');
    }
}
