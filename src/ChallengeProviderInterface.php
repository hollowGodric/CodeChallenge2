<?php
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 5/11/2018
 * Time: 1:31 PM
 */

namespace App;


interface ChallengeProviderInterface
{
    public function getChallenges();

    public function getChallengeById(int $id);
}