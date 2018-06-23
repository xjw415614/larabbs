<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
    //str_replace函数：把Route::currentRouteName里的.替换成-
    //currentRouteName 方法可以返回处理当前请求用到的路由的名字：
}