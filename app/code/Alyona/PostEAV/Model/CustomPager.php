<?php

namespace Alyona\PostEAV\Model;

class CustomPager extends \Magento\Theme\Block\Html\Pager
{
//    public function getPagerUrl($params = [])
//    {
//        $urlParams = [];
//        $urlParams['_current'] = true;
//        $urlParams['_escape'] = true;
//        $urlParams['_use_rewrite'] = true;
//        $urlParams['_fragment'] = $this->getFragment();
//        $urlParams['_query'] = $params;
//
//        try {
//            return $this->getUrl('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?p=' . (string)$params['p']);
//        } catch (\Exception $e) {
//            return $this->getUrl($_SERVER['REQUEST_URI'] . "?p=1");
//        }
//    }
//
//    public function getUrl($route = '', $params = [])
//    {
//        if (count($params)!=0) {
//            $buff = $route . "?";
//            foreach ($params as $param) {
//                $buff .= $param;
//            }
//        } else {
//            $buff = $route;
//        }
//        return $buff;
//    }
}
