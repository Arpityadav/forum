<?php

function create($className, $attribute = [])
{
    return factory($className)->create($attribute);
}

function make($className, $attribute = [])
{
    return factory($className)->make($attribute);
}
