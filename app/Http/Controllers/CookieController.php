<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Category;

class CookieController extends Controller
{

   public function getColorScheme(Request $request){
      $colorScheme = $request->cookie('colorScheme');
      return $colorScheme;
   }

   public function setColorScheme(Request $request){
      $response = new Response('Your color scheme has been updated');
      if ($request->colorScheme == 'inverted'){
         $response->withCookie(cookie('colorScheme', 'inverted'));
      } else if ($request->colorScheme == 'default'){
         $response->withCookie(cookie('colorScheme', 'default'));
      } 
      return $response;
   }

   public function getFontSize(Request $request){
      $fontSize = $request->cookie('fontSize');
      return $fontSize;
   }

   public function setFontSize(Request $request){
      $response = new Response('Your font size has been updated');
      
      switch ($request->size) {
         case "sm":
            $response->withCookie(cookie('fontSize', 'font-sm'));
            break;
         case "md":
            $response->withCookie(cookie('fontSize', 'font-md'));
            break;
         case "lg":
            $response->withCookie(cookie('fontSize', 'font-lg'));
            break;
         default:
            $response->withCookie(cookie('fontSize', 'font-sm'));
      }
      
      return $response;
   }

   public function getCategories(Request $request){
      //$categories = json_decode($request->cookie('categories'));
      $categories = $request->cookie('categories');
      return $categories;
   }

   public function toggleCategory(Request $request, Category $category){

      $categories = json_decode($request->cookie('categories'));

      if ($request->cookie('categories')){ //check if cookie exists;
         $following = $this->isFollowing($categories, $category);
         if ($following == 1){
            $response = $this->removeCategory($categories, $category);
         } else {
            $response = $this->addToCategories($categories, $category);
         }
      } else {
         $response = $this->addCategory($category);
      }
     
      return $response;
   }

   public function addCategory($category)
   {
      $response = new Response('You have successfully followed a category');
      $categories = json_encode(array($category->name));
      $response->withCookie(cookie('categories', $categories));
      return $response;
   }

   public function setCategories($category)
   {
      $response = new Response();
      $response->withCookie(cookie('categories', ''));
      return $response;
   }

   public function removeCategory($categories, $category)
   {
      if (($key = array_search($category->name, $categories)) !== null){
         unset($categories[$key]);
         $categories = array_values($categories);
      }
      $categories = json_encode($categories);
      $response = new Response('You have successfully unfollowed a category');
      $response->withCookie(cookie('categories', $categories));
      return $response;
   }

   public function addToCategories($categories, $category)
   {
      $category = array($category->name);
      $categories = json_encode(array_merge($categories, $category));
      $response = new Response('You have successfully followed a category');
      $response->withCookie(cookie('categories', $categories));
      return $response;
   }

   public function isFollowing($categories, $category){

      $following = 0;

      foreach ($categories as $categories) { //check if already following
         if ($categories == $category->name) {
            $following = 1;
            break;
         } 
      }

      return $following;
   }
}
