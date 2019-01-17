<?php

function create($className, $attribute = [], $times = null)
{
    return factory($className, $times)->create($attribute);
}

function make($className, $attribute = [], $times = null)
{
    return factory($className, $times)->make($attribute);
}
