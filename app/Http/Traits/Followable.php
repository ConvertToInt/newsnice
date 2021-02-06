<?php

namespace App\Http\Traits;
use App\Models\Category;

trait Followable {

    public function follow(Category $category) {
        return $this->follows()->save($category);
    }

    public function unfollow(Category $category) {
        return $this->follows()->detach($category);
    }

    public function toggleFollow(Category $category) {

        if ($this->following($category->id)) {
            return $this->unfollow($category);
        }

        return $this->follow($category);
    }

    public function following($category) {
        return $this->follows()
            ->where('category_id', $category)
            ->exists();
    }

    public function follows() {
        return $this->belongsToMany(Category::class, 'follows', 'user_id', 'category_id');
    }
}